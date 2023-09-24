<?php
require_once("../services/session.php");
require_once("../components/header.php");
require_once("../services/crud.php");
adminSession();
headerComponentBootstrap("Delete Book - Cukurukuk BookStore");
$id = (isset($_GET['id']) ? $_GET['id'] : '');
if ($id != '') {
    $result = deleteSingle("buku", "ISBN", $id);
    if ($result) {
        echo '<div class="my-5 mx-5"><div class="alert alert-success" role="alert">Data berhasil dihapus</div><a class="btn btn-primary" href="view_book.php">View Books</a></div>';
        
    } else {
        echo '<div class="alert alert-danger" role="alert">Data gagal dihapus</div>';
    }
}
?>