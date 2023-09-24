<?php
require_once("../services/session.php");
require_once("../components/header.php");
require_once("../services/crud.php");
require_once("../services/count.php");
adminSession();
headerComponent("Dashboard Admin - Cukurukuk BookStore");

$fiksiCount = getCountByAS("buku", "Category", "Fiksi");
$sainsCount = getCountByAS("buku", "Category", "Sains");
echo '<p>Jumlah Buku Fiksi : ' . $fiksiCount['Category'] . '</p>';
echo '<p>Jumlah Buku Sains : ' . $sainsCount['Category'] . '</p>';

$fiksiSell = getCountField("orderitem", "Fiksi");
$sainsSell = getCountField("orderitem", "Sains");
echo '<p>Jumlah Buku Fiksi Terjual : ' . $fiksiSell['Fiksi'] . '</p>';
echo '<p>Jumlah Buku Sains Terjual : ' . $sainsSell['Sains'] . '</p>';
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div style="width: 400px; margin: 0 auto;">
    <canvas id="myPieChart"></canvas>
</div>
<script>
    var fiksiCount = <?php echo $fiksiCount['Category']; ?>;
    var sainsCount = <?php echo $sainsCount['Category']; ?>;
    var fiksiSell = <?php echo $fiksiSell['Fiksi']; ?>;
    var sainsSell = <?php echo $sainsSell['Sains']; ?>;
    var data = {
        labels: ["Buku Fiksi", "Buku Sains"],
        datasets: [{
            data: [fiksiCount, sainsCount],
            backgroundColor: ["#FF5733", "#3399FF"]
        }, {
            data: [fiksiSell, sainsSell],
            backgroundColor: ["#FFC300", "#33FF71"]
        }]
    };
    var config = {
        type: 'pie',
        data: data
    };
    var ctx = document.getElementById('myPieChart').getContext('2d');
    var myPieChart = new Chart(ctx, config);
</script>
