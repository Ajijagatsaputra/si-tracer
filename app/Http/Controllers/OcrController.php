<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;
use Throwable;
use function class_exists;
use Illuminate\Support\Str;

class OcrController extends Controller
{
    /**
     * Process PDF file and extract academic data using multi strategy
     */
    public function processPdf(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'pdf' => 'required|file|mimes:pdf|max:15360' // Max 15MB
            ]);

            $file = $request->file('pdf');

            // Ensure temp directory exists and is writable
            $tempDir = storage_path('app/temp');
            if (!is_dir($tempDir)) {
                @mkdir($tempDir, 0775, true);
            }
            $hints = [];
            if (!is_dir($tempDir)) {
                $hints[] = 'Gagal membuat folder temp: ' . $tempDir;
            }
            if (!is_writable($tempDir)) {
                $hints[] = 'Folder temp tidak writable: ' . $tempDir;
            }

            // Save uploaded file explicitly
            $filename = 'ocr_' . Str::random(16) . '.pdf';
            $fullPath = rtrim($tempDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
            $file->move($tempDir, $filename);

            // Double-check file exists after move
            if (!file_exists($fullPath)) {
                $hints[] = 'File tidak ditemukan setelah penyimpanan manual (move). Cek permission/storage path/SELinux context.';
                $hints[] = 'Target path: ' . $fullPath;
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan file upload ke storage.',
                    'hints' => $hints,
                    'data' => []
                ], 500);
            }

            // 1) Try spatie/pdf-to-text (pdftotext) if available
            $text = $this->extractWithPdfToText($fullPath, $hints);

            // 2) Fallback: Smalot\PdfParser
            if (trim($text) === '') {
                $text = $this->extractWithSmalot($fullPath, $hints);
            }

            $images = [];
            // 3) Fallback: Tesseract OCR with Imagick (PDF->PNG)
            if (trim($text) === '') {
                [$images, $text] = $this->extractWithTesseract($fullPath, $hints);
            }

            // Clean up temporary files
            @unlink($fullPath);
            foreach ($images as $img) {
                @unlink($img);
            }

            if (empty($text)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat mengekstrak teks dari PDF. Pastikan file dapat dibaca.',
                    'hints' => $hints,
                    'data' => []
                ], 400);
            }

            $academicData = $this->parseAcademicData($text);

            if (empty($academicData)) {
                $preview = $this->makeRawPreview($text, 30);
                return response()->json([
                    'success' => false,
                    'message' => 'Teks berhasil diambil tetapi pola nilai tidak ditemukan. Perlu penyesuaian parser.',
                    'hints' => $hints,
                    'raw_preview' => $preview,
                    'data' => []
                ], 200);
            }

            return response()->json([
                'success' => true,
                'message' => 'PDF berhasil diproses',
                'data' => $academicData
            ]);
        } catch (\Exception $e) {
            Log::error('OCR PDF Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses PDF: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    private function extractWithPdfToText(string $filePath, array &$hints): string
    {
        try {
            if (class_exists('Spatie\\PdfToText\\Pdf')) {
                // Try default
                $text = \Spatie\PdfToText\Pdf::getText($filePath);
                if (trim((string)$text) !== '') return (string)$text;

                // Try with -layout to preserve columns
                if (method_exists(\Spatie\PdfToText\Pdf::class, 'setOptions')) {
                    $pdf = new \Spatie\PdfToText\Pdf();
                    $pdf->setOptions(['-layout']);
                    $text = $pdf->getText($filePath);
                    if (trim((string)$text) !== '') return (string)$text;

                    // Try with -raw as last attempt
                    $pdf2 = new \Spatie\PdfToText\Pdf();
                    $pdf2->setOptions(['-raw']);
                    $text = $pdf2->getText($filePath);
                    if (trim((string)$text) !== '') return (string)$text;
                }
                $hints[] = 'pdftotext menghasilkan kosong (default/-layout/-raw). Kemungkinan PDF image-only atau font bermasalah.';
                return '';
            }
            $hints[] = 'Library spatie/pdf-to-text tidak terpasang atau tidak terdeteksi.';
        } catch (Throwable $e) {
            $hints[] = 'pdftotext gagal: ' . $e->getMessage();
            Log::warning('pdftotext failed: ' . $e->getMessage());
        }
        return '';
    }

    private function extractWithSmalot(string $filePath, array &$hints): string
    {
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($filePath);
            $text = (string) $pdf->getText();
            if (trim($text) === '') {
                $hints[] = 'Smalot/PdfParser tidak menemukan text-layer.';
            }
            return $text;
        } catch (Throwable $e) {
            $hints[] = 'Smalot parser gagal: ' . $e->getMessage();
            Log::warning('Smalot parser failed: ' . $e->getMessage());
            return '';
        }
    }

    private function extractWithTesseract(string $filePath, array &$hints): array
    {
        $images = [];
        $allText = '';
        try {
            $hasImagick = class_exists('Imagick');
            $hasTesseract = class_exists('Thiagoalessio\\TesseractOCR\\TesseractOCR');
            if (!$hasImagick) {
                $hints[] = 'Extensi PHP Imagick tidak tersedia; konversi PDF->gambar tidak bisa.';
            }
            if (!$hasTesseract) {
                $hints[] = 'Library thiagoalessio/tesseract_ocr tidak tersedia; OCR fallback tidak bisa.';
            }
            if (!$hasImagick || !$hasTesseract) {
                return [$images, ''];
            }
            // Convert PDF pages to images (PNG @ 300 DPI)
            $images = $this->convertPdfToImages($filePath, $hints);
            foreach ($images as $img) {
                try {
                    $ocr = new \Thiagoalessio\TesseractOCR\TesseractOCR($img);
                    $ocr->lang('ind', 'eng')->oem(1)->psm(6);
                    $allText .= "\n" . $ocr->run();
                } catch (Throwable $e) {
                    $hints[] = 'Tesseract gagal di file ' . basename($img) . ': ' . $e->getMessage();
                    Log::warning('Tesseract run failed: ' . $e->getMessage());
                }
            }
        } catch (Throwable $e) {
            $hints[] = 'Tesseract fallback gagal: ' . $e->getMessage();
            Log::warning('Tesseract fallback failed: ' . $e->getMessage());
        }
        if (trim($allText) === '') {
            $hints[] = 'OCR tidak menemukan teks. Pastikan paket bahasa ind+eng terpasang dan dokumen terbaca.';
        }
        return [$images, trim($allText)];
    }

    private function convertPdfToImages(string $filePath, array &$hints): array
    {
        $images = [];
        try {
            $imagick = new \Imagick();
            $imagick->setResolution(300, 300);
            $imagick->readImage($filePath);
            $imagick->setImageBackgroundColor('white');
            $imagick->setImageAlphaChannel(\Imagick::ALPHACHANNEL_REMOVE);
            $imagick = $imagick->coalesceImages();
            $page = 0;
            foreach ($imagick as $frame) {
                // Basic preprocess to improve OCR
                $frame->setImageFormat('png');
                $frame->setImageCompressionQuality(95);
                $frame->setImageColorSpace(\Imagick::COLORSPACE_GRAY);
                $frame->despeckleImage();
                $frame->adaptiveSharpenImage(1, 1);
                $frame->brightnessContrastImage(0, 10);

                $tmp = storage_path('app/temp/ocr_' . uniqid() . '_' . $page . '.png');
                if (!is_dir(dirname($tmp))) @mkdir(dirname($tmp), 0777, true);
                $frame->writeImage($tmp);
                $images[] = $tmp;
                $page++;
            }
            $imagick->clear();
            $imagick->destroy();
        } catch (Throwable $e) {
            $hints[] = 'Imagick konversi gagal: ' . $e->getMessage();
            Log::warning('Imagick convert failed: ' . $e->getMessage());
        }
        return $images;
    }

    /**
     * Parse academic data from extracted text
     */
    private function parseAcademicData(string $text): array
    {
        $academicData = [];
        $lines = preg_split('/\r\n|\r|\n/', $text);

        // Normalize whitespace to make regex easier
        $normalized = [];
        foreach ($lines as $line) {
            $line = preg_replace("/\t+/", " ", $line);
            $line = preg_replace("/ {2,}/", " ", trim($line));
            if ($line !== '') $normalized[] = $line;
        }

        // Accepted grade tokens (including common local variants)
        $gradeMap = [
            'AB' => 'A-', 'BA' => 'A-',
            'BC' => 'B-', 'CB' => 'B-',
            'CD' => 'C-', 'DC' => 'C-',
            'DE' => 'D-', 'ED' => 'D-'
        ];

        // Regex patterns for varied formats
        $patterns = [
            // NO  KODE  NAMA_MK   SEM   SKS   GRADE  [BOBOT]
            // e.g. "1 T1101 BAHASA INGGRIS 1 2 B 6.00"
            '/^\d+\s+[A-Z0-9]{3,}\s+(.+?)\s+\d+\s+(\d(?:[\.,]\d)?)\s+([A-E][\+\-]?|AB|BA|BC|CB|CD|DC|DE|ED)(?:\s+[\d\.,]+)?$/i',
            // MK  SKS  Grade (with dots/commas in SKS)
            '/^(.+?)\s+(\d(?:[\.,]\d)?)\s+([A-E][\+\-]?|AB|BA|BC|CB|CD|DC|DE|ED)$/i',
            // MK - SKS - Grade
            '/^(.+?)\s*-\s*(\d(?:[\.,]\d)?)\s*-\s*([A-E][\+\-]?|AB|BA|BC|CB|CD|DC|DE|ED)$/i',
            // MK (SKS) Grade
            '/^(.+?)\s*\((\d(?:[\.,]\d)?)\)\s*([A-E][\+\-]?|AB|BA|BC|CB|CD|DC|DE|ED)$/i',
            // MK  Grade  SKS
            '/^(.+?)\s+([A-E][\+\-]?|AB|BA|BC|CB|CD|DC|DE|ED)\s+(\d(?:[\.,]\d)?)$/i',
        ];

        foreach ($normalized as $line) {
            // Column-aware parsing: if there are long gaps (3+ spaces), split columns
            if (preg_match_all('/\s{3,}/', $line) && substr_count($line, '  ') >= 2) {
                $cols = preg_split('/\s{3,}/', $line);
                // Expect roughly: NO, KODE, NAMA, SEM, SKS, GRADE, [BOBOT]
                if (count($cols) >= 6) {
                    $maybeKode = trim($cols[1] ?? '');
                    $maybeNama = trim($cols[2] ?? '');
                    $maybeSks = trim($cols[4] ?? '');
                    $maybeGrade = strtoupper(trim($cols[5] ?? ''));
                    $sks = $this->normalizeSks($maybeSks);
                    $grade = $gradeMap[$maybeGrade] ?? $maybeGrade;
                    if ($this->isValidAcademicDataFlexible($maybeNama, $sks, $grade)) {
                        $academicData[] = [
                            'mataKuliah' => $maybeNama,
                            'sks' => (int)round($sks),
                            'grade' => $grade
                        ];
                        continue;
                    }
                }
            }

            // Skip likely header lines
            if (preg_match('/^(SEMESTER|KODE|KODE\s*MK|NO\b|NAMA\s*MATA\s*KULIAH|MATA\s*KULIAH|SKS|CREDIT|GRADE|GRADES|NILAI|BOBOT|WEIGHT|HM|TOTAL|JUMLAH|RATA|IPK|IP)\b/i', $line)) {
                continue;
            }

            $matched = false;
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $line, $m)) {
                    // Determine positions depending on pattern
                    if (count($m) === 4) {
                        $mk = trim($m[1]);
                        $sksRaw = $m[2];
                        $gradeRaw = strtoupper(trim($m[3]));
                        // For pattern MK Grade SKS, swap
                        if (preg_match('/[A-E]|AB|BA|BC|CB|CD|DC|DE|ED/i', $sksRaw) && is_numeric(str_replace([',','.'], '', $gradeRaw)) ) {
                            $tmp = $gradeRaw; $gradeRaw = $sksRaw; $sksRaw = $tmp; // unlikely branch
                        }
                    } else {
                        continue;
                    }

                    $grade = $gradeMap[$gradeRaw] ?? $gradeRaw;
                    $sks = $this->normalizeSks($sksRaw);

                    if ($this->isValidAcademicDataFlexible($mk, $sks, $grade)) {
                        $academicData[] = [
                            'mataKuliah' => $mk,
                            'sks' => (int)round($sks),
                            'grade' => $grade
                        ];
                        $matched = true;
                        break;
                    }
                }
            }

            if ($matched) continue;

            // Heuristic fallback: last token grade, prev token sks, rest mk
            $tokens = preg_split('/\s+/', $line);
            if (count($tokens) >= 3) {
                $gradeRaw = strtoupper(array_pop($tokens));
                $sksRaw = array_pop($tokens);
                $mk = trim(implode(' ', $tokens));
                $grade = $gradeMap[$gradeRaw] ?? $gradeRaw;
                $sks = $this->normalizeSks($sksRaw);
                if ($this->isValidAcademicDataFlexible($mk, $sks, $grade)) {
                    $academicData[] = [
                        'mataKuliah' => $mk,
                        'sks' => (int)round($sks),
                        'grade' => $grade
                    ];
                }
            }
        }

        // As final attempt, try to pick lines containing a valid grade token and a number near it
        if (empty($academicData)) {
            foreach ($normalized as $line) {
                if (preg_match('/(A\-|A|B\+|B\-|B|C\+|C\-|C|D\+|D|E|AB|BA|BC|CB|CD|DC|DE|ED)\b/i', $line, $gm)) {
                    if (preg_match('/\b(\d(?:[\.,]\d)?)\b/', $line, $sm)) {
                        $grade = strtoupper($gm[1]);
                        $sks = $this->normalizeSks($sm[1]);
                        $mk = trim(str_replace([$gm[0], $sm[0]], '', $line));
                        $mk = preg_replace('/\s{2,}/', ' ', $mk);
                        $grade = $gradeMap[$grade] ?? $grade;
                        if ($this->isValidAcademicDataFlexible($mk, $sks, $grade)) {
                            $academicData[] = [
                                'mataKuliah' => $mk,
                                'sks' => (int)round($sks),
                                'grade' => $grade
                            ];
                        }
                    }
                }
            }
        }

        return $academicData;
    }

    private function normalizeSks($raw)
    {
        $s = str_replace(',', '.', (string)$raw);
        if (!is_numeric($s)) return 0;
        $val = (float)$s;
        // Typical SKS range 1..6; clamp and round to nearest int
        if ($val < 0.5 || $val > 6.5) return 0;
        return $val;
    }

    private function isValidAcademicDataFlexible(string $mataKuliah, $sks, string $grade): bool
    {
        if (strlen($mataKuliah) < 2 || strlen($mataKuliah) > 120) return false;
        if (!is_numeric($sks) || $sks <= 0) return false;
        if (!preg_match('/^(A\-|A|B\+|B\-|B|C\+|C\-|C|D\+|D|E|AB|BA|BC|CB|CD|DC|DE|ED)$/i', $grade)) return false;
        // Skip common non-academic words
        $skipWords = ['TOTAL', 'JUMLAH', 'RATA', 'IPK', 'IP', 'SEMESTER', 'KODE'];
        foreach ($skipWords as $word) {
            if (stripos($mataKuliah, $word) !== false) return false;
        }
        return true;
    }

    private function alternativeParsing(string $text): array
    {
        $academicData = [];
        $sections = preg_split('/\n\s*\n/', $text);
        foreach ($sections as $section) {
            $lines = preg_split('/\r\n|\r|\n/', $section);
            foreach ($lines as $line) {
                $line = trim($line);
                if (preg_match('/([A-Za-z\s]{5,50})\s+(\d+)\s+([A-E][\+\-]?)/', $line, $m)) {
                    $mataKuliah = trim($m[1]);
                    $sks = (int) $m[2];
                    $grade = strtoupper(trim($m[3]));
                    if ($this->isValidAcademicData($mataKuliah, $sks, $grade)) {
                        $academicData[] = [
                            'mataKuliah' => $mataKuliah,
                            'sks' => $sks,
                            'grade' => $grade
                        ];
                    }
                }
            }
        }
        return $academicData;
    }

    private function makeRawPreview(string $text, int $limit = 30): array
    {
        $lines = preg_split('/\r\n|\r|\n/', $text);
        $out = [];
        foreach ($lines as $ln) {
            $ln = trim($ln);
            if ($ln !== '') $out[] = $ln;
            if (count($out) >= $limit) break;
        }
        return $out;
    }
}
