<?php
require_once("services/session.php");
require_once("components/header.php");
require_once("services/crud.php");
userSession();
$id = (isset($_GET['id']) ? $_GET['id'] : '');
$result = getSingleBy("buku", "ISBN", $id);
$nama = $result['Title'];

headerComponentBootstrap("Detail ".$nama." - Cukurukuk BookStore");
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h1>Detail Buku</h1>
            <p>Judul Buku: <?php echo $nama ?></p>
            <p>ISBN: <?php echo $result['ISBN'] ?></p>
            <p>Kategori: <?php echo $result['Category'] ?></p>
            <p>Penulis: <?php echo $result['Author'] ?></p>
            <p>Harga: <?php echo $result['Price'] ?></p>
        </div>
        <div class="col-md-6">
            <h2>Review Buku</h2>
            <?php
            $res = getSingleByQuery("reviews", "ISBN", $id);
            echo '<p>Review</p>';
            $i = 1;
            while ($row = $res->fetch_object()) {
                echo '<p>'.$i.'. '. $row->review . '</p>';
                echo '<hr>';
                $i++;
            }
            ?>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h2>Tambahkan Review</h2>
    <form method="post" action="add_review.php">
        <input type="hidden" name="isbn" value="<?php echo $id; ?>">
        <div class="mb-3">
            <label for="review" class="form-label">Review</label>
            <textarea class="form-control" id="review" name="review" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Review</button>
    </form>
</div>

<?php
require_once("components/footer.php");
?>
