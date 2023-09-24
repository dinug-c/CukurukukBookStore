<?php
require_once("../services/session.php");
require_once("../components/header.php");
require_once("../services/crud.php");
adminSession();
$id = (isset($_GET['id']) ? $_GET['id'] : '');
$result = getSingleBy("buku", "ISBN", $id);
$nama = $result['Title'];

headerComponentBootstrap("Detail ".$nama." - Cukurukuk BookStore");
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">Detail Buku</h1>
                    <p class="card-text">Judul Buku: <?php echo $nama ?></p>
                    <p class="card-text">ISBN: <?php echo $result['ISBN'] ?></p>
                    <p class="card-text">Kategori: <?php echo $result['Category'] ?></p>
                    <p class="card-text">Penulis: <?php echo $result['Author'] ?></p>
                    <p class="card-text">Harga: <?php echo $result['Price'] ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Review Buku</h2>
                    <?php
                    $res = getSingleByQuery("reviews", "ISBN", $id);
                    echo '<p class="card-text">Review</p>';
                    $i = 1;
                    while ($row = $res->fetch_object()) {
                        echo '<p class="card-text">'.$i.'. '. $row->review . '</p>';
                        echo '<hr>';
                        $i++;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Tambahkan Review</h2>
            <form method="post" action="add_review.php">
                <input type="hidden" name="isbn" value="<?php echo $id; ?>">
                <div class="mb-3">
                    <label for="review" class="form-label">Review</label>
                    <textarea class="form-control" id="review" name="review" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Review</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once("../components/footer.php");
?>
