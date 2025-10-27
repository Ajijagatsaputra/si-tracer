<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prediksi Karier Alumni</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1e40af;
      --secondary: #64748b;
      --success: #059669;
      --border-color: #e2e8f0;
      --bg-light: #f8fafc;
    }

    body {
      background: radial-gradient(circle at top left, #e0e7ff, #f1f5f9);
      font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
      min-height: 100vh;
      padding: 2rem 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .main-wrapper {
      width: 100%;
      max-width: 1100px;
      padding: 0 1rem;
    }

    .header-section {
      text-align: center;
      margin-bottom: 2.5rem;
      animation: fadeInDown 0.6s ease-out;
    }

    .header-section h1 {
      font-size: 2.5rem;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 0.75rem;
      letter-spacing: -0.5px;
    }

    .header-section p {
      font-size: 1rem;
      color: var(--secondary);
      max-width: 600px;
      margin: 0 auto;
    }

    .form-card {
      background: rgba(255, 255, 255, 0.75);
      backdrop-filter: blur(12px);
      border-radius: 16px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
      padding: 2.5rem;
      border: 1px solid rgba(226, 232, 240, 0.7);
      transition: transform 0.3s ease;
    }

    .form-card:hover {
      transform: translateY(-4px);
    }

    .section-header {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1.75rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid var(--bg-light);
    }

    .section-icon {
      width: 46px;
      height: 46px;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.1rem;
      box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
    }

    .section-header h5 {
      font-size: 1.125rem;
      font-weight: 600;
      color: #1e293b;
      margin: 0;
    }

    .section-header small {
      color: var(--secondary);
      font-weight: 400;
      font-size: 0.875rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-label {
      font-weight: 600;
      color: #334155;
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .form-control {
      border: 1.5px solid var(--border-color);
      border-radius: 8px;
      padding: 0.65rem 0.875rem;
      font-size: 0.9375rem;
      transition: all 0.25s ease;
    }

    .form-control:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
      outline: none;
      transform: scale(1.01);
    }

    .btn-submit {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      border: none;
      color: white;
      padding: 0.875rem 2.5rem;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      transition: all 0.25s ease;
      box-shadow: 0 5px 15px rgba(37, 99, 235, 0.35);
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(37, 99, 235, 0.45);
    }

    .btn-back {
      background: #f1f5f9;
      color: #1e293b;
      border: 1px solid var(--border-color);
      padding: 0.75rem 2rem;
      border-radius: 8px;
      font-weight: 600;
      transition: all 0.25s ease;
    }

    .btn-back:hover {
      background: #e2e8f0;
    }

    .result-card {
      background: linear-gradient(135deg, #059669, #047857);
      border-radius: 12px;
      padding: 2rem;
      color: white;
      margin-top: 2rem;
      text-align: center;
      box-shadow: 0 10px 30px rgba(5, 150, 105, 0.3);
      animation: fadeInUp 0.6s ease-out;
    }

    .result-card .icon {
      font-size: 3rem;
      margin-bottom: 1rem;
    }

    .result-card h3 {
      font-size: 1.75rem;
      font-weight: 700;
    }

    .alert-error {
      background: #fef2f2;
      border: 1px solid #fecaca;
      border-radius: 8px;
      padding: 1rem 1.25rem;
      color: #991b1b;
      margin-top: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .stats-bar {
      display: flex;
      gap: 1.5rem;
      margin-bottom: 2rem;
      padding: 1.5rem;
      background: var(--bg-light);
      border-radius: 12px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .stat-item {
      text-align: center;
    }

    .stat-number {
      font-size: 2rem;
      font-weight: 700;
      color: var(--primary);
      display: block;
    }

    .stat-label {
      font-size: 0.875rem;
      color: var(--secondary);
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 768px) {
      .form-card {
        padding: 1.5rem;
      }

      .header-section h1 {
        font-size: 1.75rem;
      }

      .stats-bar {
        flex-direction: column;
      }
    }
  </style>
</head>

<body>
  <div class="main-wrapper">
    <div class="header-section">
      <h1>Prediksi Karier Alumni</h1>
      <p>Sistem prediksi berbasis AI untuk menganalisis potensi karier berdasarkan kemampuan teknis dan kepribadian</p>
    </div>

    <div class="stats-bar">
      <div class="stat-item">
        <span class="stat-number">4</span>
        <div class="stat-label">Kemampuan Teknis</div>
      </div>
      <div class="stat-item">
        <span class="stat-number">10</span>
        <div class="stat-label">Aspek Kepribadian</div>
      </div>
      <div class="stat-item">
        <span class="stat-number">14</span>
        <div class="stat-label">Total Parameter</div>
      </div>
    </div>

    <div class="form-card">
      <form action="{{ route('predictOutcome') }}" method="POST">
        @csrf

        <!-- Technical Section -->
        <div class="section-header">
          <div class="section-icon">
            <i class="fas fa-code"></i>
          </div>
          <div>
            <h5>Kemampuan Teknis</h5>
            <small>Penilaian kompetensi teknis dalam skala 1-6</small>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 form-group">
            <label class="form-label"><i class="fas fa-microchip"></i> Computer Architecture</label>
            <input type="number" name="discrete1" class="form-control" min="1" max="6"
              value="{{ old('discrete1', 3) }}" required>
          </div>
          <div class="col-md-6 form-group">
            <label class="form-label"><i class="fas fa-laptop-code"></i> Programming Skill</label>
            <input type="number" name="discrete2" class="form-control" min="1" max="6"
              value="{{ old('discrete2', 3) }}" required>
          </div>
          <div class="col-md-6 form-group">
            <label class="form-label"><i class="fas fa-tasks"></i> Project Management</label>
            <input type="number" name="discrete3" class="form-control" min="1" max="6"
              value="{{ old('discrete3', 3) }}" required>
          </div>
          <div class="col-md-6 form-group">
            <label class="form-label"><i class="fas fa-comments"></i> Communication Skill</label>
            <input type="number" name="discrete4" class="form-control" min="1" max="6"
              value="{{ old('discrete4', 3) }}" required>
          </div>
        </div>

        <div class="mt-4 section-header">
          <div class="section-icon">
            <i class="fas fa-user-circle"></i>
          </div>
          <div>
            <h5>Aspek Kepribadian</h5>
            <small>Evaluasi karakteristik kepribadian dalam skala 0.00–1.00</small>
          </div>
        </div>

        <div class="row">
          @php
          $traits = [
          ['name'=>'Openness','icon'=>'lightbulb'],
          ['name'=>'Conscientiousness','icon'=>'clipboard-check'],
          ['name'=>'Extraversion','icon'=>'users'],
          ['name'=>'Agreeableness','icon'=>'handshake'],
          ['name'=>'Emotionalness','icon'=>'heart'],
          ['name'=>'Conversation','icon'=>'comment-dots'],
          ['name'=>'Openness to Change','icon'=>'sync-alt'],
          ['name'=>'Hedonism','icon'=>'smile'],
          ['name'=>'Self Enhancement','icon'=>'arrow-up'],
          ['name'=>'Self Transcendence','icon'=>'infinity']
          ];
          @endphp
          @foreach ($traits as $i => $trait)
          <div class="col-md-6 form-group">
            <label class="form-label"><i class="fas fa-{{ $trait['icon'] }}"></i> {{ $trait['name'] }}</label>
            <input type="number" name="continuous{{ $i + 5 }}" class="form-control" step="0.01" min="0" max="1"
              value="{{ old('continuous' . ($i + 5), 0.5) }}" required>
          </div>
          @endforeach
        </div>

        <div class="mt-4 text-center">
          <button type="submit" class="btn-submit">
            <i class="fas fa-chart-line"></i> Analisis & Prediksi Karier
          </button>
        </div>

        <div class="mt-3 text-center">
          <button type="button" onclick="history.back()" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
          </button>
        </div>
      </form>

      @isset($prediction)
      <div class="result-card">
        <div class="icon"><i class="fas fa-check-circle"></i></div>
        <h5>Hasil Prediksi Karier Anda</h5>
        <h3>{{ $prediction }}</h3>
      </div>
      @endisset

      @if (session('error'))
      <div class="alert-error">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
      </div>
      @endif
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
