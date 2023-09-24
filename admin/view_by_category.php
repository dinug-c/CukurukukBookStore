<?php
require_once("../services/session.php");
require_once("../components/header.php");
require_once("../services/crud.php");
adminSession();
headerComponent("View Order - Cukurukuk BookStore");
?>
<div class="card">
    <div class="card-header">Customer Data</div>
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
                // Jika kategori saat ini berbeda dari kategori sebelumnya, buat baris baru
                if ($currentCategory !== $row->Category) {
                    echo '<tr>';
                    echo '<td>' . $row->Category . '</td>';
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
                echo '<td>' . $row->Price . '</td>';
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
