<?php
require_once("../services/session.php");
require_once("../components/header.php");
require_once("../services/crud.php");
require_once("../services/count.php");
adminSession();
headerComponentBootstrap("Dashboard Admin - Cukurukuk BookStore");

// Ambil data jumlah buku berdasarkan kategori dari tabel buku
$categoryCounts = getCountByCategory();

// Ambil data penjualan buku berdasarkan kategori dari tabel penjualan
$salesByCategory = getSalesByCategory();

adminNav();
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div style="width: 400px; margin: 20 auto;">
    <canvas id="myPieChart"></canvas>
</div>
<div class="container mt-4">
    <div class="row">
        <?php foreach ($categoryCounts as $categoryCount): ?>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Buku <?= $categoryCount['Category']; ?></h5>
                        <p class="card-text"><?= $categoryCount['Count']; ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row mt-4">
        <?php foreach ($salesByCategory as $sales): ?>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Penjualan Buku <?= $sales['CategoryName']; ?></h5>
                        <p class="card-text"><?= $sales['TotalSales']; ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div style="width: 400px; margin: 20 auto;">
    <canvas id="myBarChart"></canvas>
</div>

<script>
    var categoryCounts = <?php echo json_encode(array_column($categoryCounts, 'Count')); ?>;
    var salesByCategory = <?php echo json_encode(array_column($salesByCategory, 'TotalSales')); ?>;
    var categoryNames = <?php echo json_encode(array_column($salesByCategory, 'CategoryName')); ?>;
    
    var data = {
        labels: categoryNames,
        datasets: [
            {
                label: 'Jumlah Buku',
                data: categoryCounts,
                backgroundColor: "#FF5733"
            },
            {
                label: 'Jumlah Buku Terjual',
                data: salesByCategory,
                backgroundColor: "#3399FF"
            }
        ]
    };

    var config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };
    
    var ctx = document.getElementById('myBarChart').getContext('2d');
    var myBarChart = new Chart(ctx, config);
</script>

<script>
   var categoryCounts = <?php echo json_encode(array_column($categoryCounts, 'Count')); ?>;
    var salesByCategory = <?php echo json_encode(array_column($salesByCategory, 'TotalSales')); ?>;
    var categoryNames = <?php echo json_encode(array_column($salesByCategory, 'CategoryName')); ?>;
    var data = {
        labels: categoryNames,
        datasets: [{
            label: 'Jumlah Buku',
            data: categoryCounts,
            backgroundColor: ["#FF5733", "#3399FF", "#FFC300", "#33FF71"] // Tambahkan warna sesuai jumlah kategori
        }, {
            label: 'Jumlah Buku Terjual',
            data: salesByCategory,
            backgroundColor: [ "#FFC300", "#33FF71","#FF5733", "#3399FF"] // Tambahkan warna sesuai jumlah kategori
        }]
    };

    var config = {
        type: 'pie',
        data: data
    };
    var ctx = document.getElementById('myPieChart').getContext('2d');
    var myPieChart = new Chart(ctx, config);
</script>
