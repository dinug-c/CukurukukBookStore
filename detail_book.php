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