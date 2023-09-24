<?php
require_once("../services/session.php");
require_once("../components/header.php");
require_once("../services/crud.php");
adminSession();
headerComponentBootstrap("View Order - Cukurukuk BookStore");
adminNav();
?>

<div class="card m-5">
    <div class="card-header">Data Buku Per Kategori</div>
    <div class="card-body">
        <br>
        <table class="table table-striped">
            <tr>
                <th>Category</th>
                <th>ISBN</th>
                <th>Title</th>
                <th>Author</th>
                <th>Price</th>
            </tr>
            <?php
            $result = getSingleOrdered("buku", "Category");
            if (!$result) {
                die("Could not query the database: <br/>" . $db->error . "<br/>Query: " . $query);
            }

            $currentCategory = null;
            while ($row = $result->fetch_object()) {
                // Jika kategori saat ini berbeda dari kategori sebelumnya, buat baris baru dengan <span>
                if ($currentCategory !== $row->Category) {
                    // Jika ini bukan baris pertama, tutup baris sebelumnya
                    if ($currentCategory !== null) {
                        echo '</td>';
                        echo '<td></td>';
                        echo '</tr>';
                    }

                    echo '<tr>';
                    echo '<td><span>' . $row->Category . '</span></td>';
                    $currentCategory = $row->Category;
                } else {
                    // Ini adalah baris tambahan dengan kategori yang sama, jadi tidak perlu menampilkan kategori lagi
                    echo '<tr>';
                    echo '<td></td>';
                }

                // Tampilkan informasi buku
                echo '<td>' . $row->ISBN . '</td>';
                echo '<td>' . $row->Title . '</td>';
                echo '<td>' . $row->Author . '</td>';
                // Ubah harga menjadi format IDR
                echo '<td>Rp ' . number_format($row->Price, 0, ',', '.') . '</td>';
                echo '</tr>';
            }

            // Tutup baris terakhir jika ada
            if ($currentCategory !== null) {
                echo '</td>';
                echo '<td></td>';
                echo '</tr>';
            }

            echo '</table>';
            echo '<br/>';
            echo 'Total Rows = ' . $result->num_rows;
            $result->free();
            $db->close();
            ?>
        </table>
        
    </div>
</div>

<?php
require_once("../components/footer.php");
?>
