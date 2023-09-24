<?php
require_once("../services/session.php");
require_once("../components/header.php");
require_once("../services/crud.php");
adminSession();
headerComponentBootstrap("View Order - Cukurukuk BookStore");
adminNav();

// Inisialisasi tanggal awal, tanggal akhir, harga minimum, dan harga maksimum
$startDate = "";
$endDate = "";
$minPrice = "";
$maxPrice = "";

// Periksa apakah formulir telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil tanggal awal, tanggal akhir, harga minimum, dan harga maksimum dari formulir
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];
    $minPrice = $_POST["min_price"];
    $maxPrice = $_POST["max_price"];
}

?>
<div class="card m-5">
    <div class="card-header">Order Data</div>
    <div class="card-body">
        <!-- Form filter berdasarkan tanggal dan harga -->
        <form method="post" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $startDate; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="end_date">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $endDate; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="min_price">Harga Minimum</label>
                        <input type="number" class="form-control" id="min_price" name="min_price" value="<?= $minPrice; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="max_price">Harga Maksimum</label>
                        <input type="number" class="form-control" id="max_price" name="max_price" value="<?= $maxPrice; ?>">
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <table class="table table-striped">
            <tr>
                <th>ID Order</th>
                <th>Tanggal</th>
                <th>Total Item</th>
                <th>Total Price</th>
            </tr>
            <?php
            // Modifikasi query untuk memperhitungkan filter tanggal dan harga
            $query = "SELECT * FROM orderitem";

            if (!empty($startDate) && !empty($endDate)) {
                $query .= " WHERE Tanggal BETWEEN '$startDate' AND '$endDate'";
            }

            if (!empty($minPrice) && !empty($maxPrice)) {
                if (!empty($startDate) && !empty($endDate)) {
                    $query .= " AND TotalPrice BETWEEN $minPrice AND $maxPrice";
                } else {
                    $query .= " WHERE TotalPrice BETWEEN $minPrice AND $maxPrice";
                }
            }

            $result = $db->query($query);

            if (!$result) {
                die("Could not query the database");
            }

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['ID_Order'] . '</td>';
                echo '<td>' . $row['Tanggal'] . '</td>';
                echo '<td>' . $row['Total_item'] . '</td>';
                echo '<td>' . 'Rp ' . number_format($row['TotalPrice'], 0, ',', '.') . '</td>';
                echo '</tr>';
            }
            ?>
        </table>
    </div>
</div>
<?php
require_once("../components/footer.php");
?>
