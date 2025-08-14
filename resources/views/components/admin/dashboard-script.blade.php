{{-- Dashboard Script - Terpisah dari script utama --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Prevent be_pages_dashboard.min.js from creating charts
  if (typeof window.initCharts === 'function') {
    window.initCharts = function() {
      console.log('Chart initialization blocked by dashboard script');
      return false;
    };
  }

  // Global chart storage
  window.dashboardCharts = {};

  // Function to safely create charts
  function createDashboardChart(canvasId, config) {
    // Destroy existing chart if exists
    if (window.dashboardCharts[canvasId]) {
      window.dashboardCharts[canvasId].destroy();
      delete window.dashboardCharts[canvasId];
    }

    // Also destroy any existing Chart.js instances on this canvas
    const canvas = document.getElementById(canvasId);
    if (canvas) {
      // Get all Chart.js instances and destroy them
      if (canvas.chart) {
        canvas.chart.destroy();
        delete canvas.chart;
      }

      const ctx = canvas.getContext('2d');
      const newChart = new Chart(ctx, config);
      window.dashboardCharts[canvasId] = newChart;
      canvas.chart = newChart; // Store reference on canvas
    }
  }

  // Initialize all dashboard charts
  function initDashboardCharts() {
    console.log('Initializing dashboard charts...');

    // Bar Chart - Statistik Alumni
    createDashboardChart('barChartAlumni', {
      type: 'bar',
      data: {
        labels: ['Bekerja', 'Belum Bekerja', 'Wirausaha', 'Melanjutkan Studi', 'Tidak Bekerja'],
        datasets: [{
          label: 'Jumlah Alumni',
          data: [0, 0, 0, 0, 0], // Will be populated by PHP
          backgroundColor: [
            'rgba(25, 135, 84, 0.1)',      // Bekerja: bg-success bg-opacity-10
            'rgba(220, 53, 69, 0.1)',      // Belum Bekerja: bg-danger bg-opacity-10
            'rgba(255, 193, 7, 0.1)',      // Wirausaha: bg-warning bg-opacity-10
            'rgba(13, 110, 253, 0.1)',     // Melanjutkan Studi: bg-primary bg-opacity-10
            'rgba(108, 117, 125, 0.1)'     // Tidak Bekerja: bg-secondary bg-opacity-10
          ],
          borderRadius: 8,
          borderWidth: 2,
          borderColor: [
            'rgba(25, 135, 84, 1)',        // text-success
            'rgba(220, 53, 69, 1)',        // text-danger
            'rgba(255, 193, 7, 1)',        // text-warning
            'rgba(13, 110, 253, 1)',       // text-primary
            'rgba(108, 117, 125, 1)'       // text-secondary
          ]
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: 'rgba(0,0,0,0.8)',
            titleColor: '#fff',
            bodyColor: '#fff',
            borderColor: '#007bff',
            borderWidth: 1,
            callbacks: {
              label: (ctx) => `${ctx.parsed.y} Alumni`
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { stepSize: 1, precision: 0 },
            grid: { color: 'rgba(0,0,0,0.1)' }
          },
          x: {
            grid: { display: false }
          }
        }
      }
    });

    // Line Chart - Alumni Growth
    createDashboardChart('lineChartAlumni', {
      type: 'line',
      data: {
        labels: ['2021', '2022', '2023', '2024', '2025'],
        datasets: [{
          label: 'Alumni Lulus',
          data: [0, 0, 0, 0, 0], // Will be populated by PHP
          borderColor: 'rgba(25, 135, 84, 1)',
          backgroundColor: 'rgba(25, 135, 84, 0.1)',
          borderWidth: 3,
          fill: true,
          tension: 0.4,
          pointBackgroundColor: 'rgba(25, 135, 84, 1)',
          pointBorderColor: '#fff',
          pointBorderWidth: 2,
          pointRadius: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: 'rgba(0,0,0,0.8)',
            titleColor: '#fff',
            bodyColor: '#fff'
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: { color: 'rgba(0,0,0,0.1)' }
          },
          x: {
            grid: { display: false }
          }
        }
      }
    });

    // Line Chart - Tracer Study Response
    createDashboardChart('lineChartTracer', {
      type: 'line',
      data: {
        labels: ['2021', '2022', '2023', '2024', '2025'],
        datasets: [{
          label: 'Tracer Study Response',
          data: [0, 0, 0, 0, 0], // Will be populated by PHP
          borderColor: 'rgba(108, 117, 125, 1)',
          backgroundColor: 'rgba(108, 117, 125, 0.1)',
          borderWidth: 3,
          fill: true,
          tension: 0.4,
          pointBackgroundColor: 'rgba(108, 117, 125, 1)',
          pointBorderColor: '#fff',
          pointBorderWidth: 2,
          pointRadius: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: 'rgba(0,0,0,0.8)',
            titleColor: '#fff',
            bodyColor: '#fff'
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: { color: 'rgba(0,0,0,0.1)' }
          },
          x: {
            grid: { display: false }
          }
        }
      }
    });

    console.log('Dashboard charts initialized successfully');
  }

  // Initialize charts when DOM is ready
  document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM ready, waiting to initialize charts...');
    // Wait for any existing scripts to finish
    setTimeout(initDashboardCharts, 1000);
  });

  // Cleanup on page unload
  window.addEventListener('beforeunload', function() {
    Object.keys(window.dashboardCharts).forEach(chartId => {
      if (window.dashboardCharts[chartId]) {
        window.dashboardCharts[chartId].destroy();
      }
    });
  });
</script>