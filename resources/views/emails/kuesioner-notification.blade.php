<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Kuesioner Tracer Study</title>
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
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
            font-weight: bold;
            margin: 0;
        }
        .subtitle {
            color: #666;
            font-size: 1.1em;
            margin: 5px 0 0 0;
        }
        .content {
            margin-bottom: 30px;
        }
        .greeting {
            font-size: 1.2em;
            margin-bottom: 20px;
        }
        .message {
            margin-bottom: 25px;
            text-align: justify;
        }
        .details {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 20px;
            margin: 25px 0;
            border-radius: 5px;
        }
        .detail-item {
            margin: 10px 0;
            display: flex;
            align-items: center;
        }
        .detail-label {
            font-weight: bold;
            min-width: 120px;
            color: #007bff;
        }
        .detail-value {
            margin-left: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
        }
        .contact-info {
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .highlight {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">🎓</div>
            <h1 class="title">Universitas Harkat Negeri</h1>
            <p class="subtitle">Tracer Study Alumni</p>
        </div>

        <div class="content">
            <div class="greeting">
                <strong>Halo {{ $nama }}! 👋</strong>
            </div>

            <div class="message">
                Terima kasih telah meluangkan waktu untuk mengisi kuesioner <strong>Tracer Study Universitas Harkat Negeri</strong>.
                Data yang Anda berikan sangat berharga untuk pengembangan kualitas pendidikan di kampus kami.
            </div>

            <div class="highlight">
                <strong>✅ Konfirmasi:</strong> Data kuesioner Anda telah berhasil disimpan dan akan digunakan untuk evaluasi dan pengembangan program studi.
            </div>

            <div class="details">
                <h3 style="color: #007bff; margin-top: 0;">📋 Detail Pengisian:</h3>
                <div class="detail-item">
                    <span class="detail-label">Nama:</span>
                    <span class="detail-value">{{ $nama }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Perusahaan:</span>
                    <span class="detail-value">{{ $namaPerusahaan }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Tanggal:</span>
                    <span class="detail-value">{{ $tanggal }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">✅ Berhasil Disimpan</span>
                </div>
            </div>

            <div class="message">
                Data yang Anda berikan akan membantu kami dalam:
                <ul style="margin: 15px 0; padding-left: 20px;">
                    <li>Meningkatkan kualitas kurikulum</li>
                    <li>Mengembangkan program studi yang relevan</li>
                    <li>Menyiapkan mahasiswa untuk dunia kerja</li>
                    <li>Membangun kerjasama dengan industri</li>
                </ul>
            </div>

            <div class="contact-info">
                <strong>📞 Butuh Bantuan?</strong><br>
                Jika ada pertanyaan atau saran, silakan hubungi kami melalui:<br>
                <strong>Email:</strong> tracer@poltek-harber.ac.id<br>
                <strong>WhatsApp:</strong> +62 812-3456-7890
            </div>
        </div>

        <div class="footer">
            <p><strong>Salam,</strong></p>
            <p><strong>Tim Tracer Study</strong><br>
            Politeknik Harapan Bersama</p>

            <div style="margin-top: 20px;">
                <a href="https://poltek-harber.ac.id" class="btn">Kunjungi Website</a>
                <a href="https://alumni.poltek-harber.ac.id" class="btn">Portal Alumni</a>
            </div>

            <p style="font-size: 0.9em; margin-top: 20px; color: #999;">
                Email ini dikirim otomatis, mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>
