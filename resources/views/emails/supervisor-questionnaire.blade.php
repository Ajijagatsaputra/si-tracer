<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuesioner Tracer Study - Evaluasi Kinerja Alumni</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 2.5em;
            color: #007bff;
            margin-bottom: 10px;
        }
        .title {
            color: #007bff;
            font-size: 1.8em;
            margin: 0;
        }
        .subtitle {
            color: #666;
            font-size: 1.1em;
            margin: 5px 0;
        }
        .content {
            margin: 25px 0;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            font-size: 1.1em;
            margin: 20px 0;
            box-shadow: 0 4px 15px rgba(0,123,255,0.3);
            transition: all 0.3s ease;
        }
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,123,255,0.4);
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 0.9em;
        }
        .highlight {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .detail-item {
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-item:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #007bff;
            display: inline-block;
            width: 120px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🎓</div>
            <h1 class="title">Universitas Harkat Negeri</h1>
            <p class="subtitle">Tracer Study - Evaluasi Kinerja Alumni</p>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $namaAtasan }}</strong>! 👋</p>

            <p>Anda diminta untuk mengisi kuesioner Tracer Study untuk mengevaluasi kinerja alumni yang bekerja di perusahaan Anda. Data ini sangat penting untuk pengembangan kualitas pendidikan di kampus kami.</p>

            <div class="info-box">
                <h3 style="margin-top: 0; color: #007bff;">📋 Detail Kuesioner</h3>
                <div class="detail-item">
                    <span class="label">Nama Alumni:</span>
                    <span>{{ $namaAlumni }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Perusahaan:</span>
                    <span>{{ $namaPerusahaan }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Tanggal Request:</span>
                    <span>{{ $tanggal }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Kadaluarsa:</span>
                    <span>{{ $expiresAt }}</span>
                </div>
            </div>

            <div class="highlight">
                <strong>⚠️ Penting:</strong> Link kuesioner akan kadaluarsa dalam 7 hari. Silakan isi segera untuk memastikan data dapat diproses.
            </div>

            <p>Kuesioner ini berisi pertanyaan tentang:</p>
            <ul>
                <li>Kinerja dan kompetensi alumni</li>
                <li>Kesesuaian pendidikan dengan pekerjaan</li>
                <li>Saran pengembangan untuk kampus</li>
                <li>Evaluasi kualitas lulusan</li>
            </ul>

            <p><strong>Catatan:</strong> Kuesioner ini menggunakan sistem kuesioner pengguna yang sudah tersedia di website kami.</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $questionnaireUrl }}" class="cta-button">
                    📝 Isi Kuesioner Evaluasi
                </a>
            </div>

            <p><strong>Atau copy link berikut ke browser Anda:</strong></p>
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; word-break: break-all; font-family: monospace; font-size: 0.9em;">
                {{ $questionnaireUrl }}
            </div>
        </div>

        <div class="footer">
            <p><strong>Terima kasih atas partisipasi Anda dalam pengembangan pendidikan!</strong></p>
            <p>Salam,<br>
            <strong>Tim Tracer Study</strong><br>
            Politeknik Harapan Bersama</p>

            <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
                <small>
                    <strong>Informasi:</strong><br>
                    • Email ini dikirim otomatis oleh sistem<br>
                    • Jangan balas email ini<br>
                    • Untuk bantuan, hubungi tim Tracer Study
                </small>
            </div>
        </div>
    </div>
</body>
</html>
