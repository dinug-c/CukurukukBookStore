<?php
require_once("../services/session.php");
require_once("../components/header.php");
require_once("../services/crud.php");
adminSession();
headerComponentBootstrap("View Order - Cukurukuk BookStore");
adminNav();
?>
<div class="card m-5">
    <div class="card-header">Order Data</div>
    <div class="card-body">
        <br>
        <table class="table table-striped">
            <tr>
                <th>ID Order</th>
                <th>Tanggal</th>
                <th>Total Item</th>
                <th>Total Price</th>
            </tr>
            <?php
            // Menggunakan fungsi getSingle untuk mengambil data order dari tabel orderitem
            $result = getAll("orderitem");

            if (!$result) {
                die("Could not query the database");
            }

            foreach ($result as $row) {
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
