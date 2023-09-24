<?php
require_once("../services/session.php");
require_once("../components/header.php");
require_once("../services/crud.php");
adminSession();
headerComponent("Delete Book - Cukurukuk BookStore");
$id = (isset($_GET['id']) ? $_GET['id'] : '');
if ($id != '') {
    $result = deleteSingle("buku", "ISBN", $id);
    if ($result) {
        echo '<div class="alert alert-success" role="alert">Data berhasil dihapus</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Data gagal dihapus</div>';
    }
}
?>