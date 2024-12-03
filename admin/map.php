<?php require_once '../config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="cssheader/confirms.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .container {
            position: relative;
            z-index: 1;
        }

        .sidebar {
            margin-top: 250px;
            position: relative;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php include_once "./header.php"; ?>
    </div>
    <div>
        <?php include_once "./sider.php"; ?>
    </div>
    <div id="main-content" class="p-4 p-md-5 pt-5">
        <div class="chart-container">
            <h2>📊 Performance</h2>
            <canvas id="performanceChart"></canvas>
        </div>
    </div>

    <script>
        // Dữ liệu biểu đồ
        const ctx = document.getElementById('performanceChart').getContext('2d');
        const performanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['09', '02', '03', '04', '05', '06', '07', '08', '09'], // Các điểm trên trục x
                datasets: [
                    {
                        label: 'Dataset 1',
                        data: [140, 120, 100, 80, 160, 100, 140, 180, 60],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: false,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                    },
                    {
                        label: 'Dataset 2',
                        data: [100, 140, 120, 160, 140, 80, 60, 120, 100],
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: false,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                    },
                    {
                        label: 'Dataset 3',
                        data: [60, 80, 20, 40, 100, 140, 180, 60, 40],
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: false,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    x: {
                        grid: {
                            drawOnChartArea: false,
                        },
                    },
                    y: {
                        beginAtZero: true,
                        max: 200,
                    },
                },
            },
        });
    </script>
</body>

</html>