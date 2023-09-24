<?php
require_once("services/session.php");
require_once("components/header.php");
require_once("services/crud.php");
userSession();
$id = (isset($_GET['id']) ? $_GET['id'] : '');
$result = getSingleBy("buku", "ISBN", $id);
$nama = $result['Title'];

headerComponent("Detail ".$nama." - Cukurukuk BookStore");
?>
<p>Judul Buku : <?php echo $nama ?></p>
<p>ISBN : <?php echo $result['ISBN'] ?></p>
<p>Kategori : <?php echo $result['Category'] ?></p>
<p>Penulis : <?php echo $result['Author'] ?></p>
<p>Harga : <?php echo $result['Price'] ?></p>

<!-- Tampilkan Review Buku -->
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