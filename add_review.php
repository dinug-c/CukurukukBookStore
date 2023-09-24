<?php
require_once("services/session.php");
require_once("services/crud.php");

userSession();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isbn = $_POST["isbn"];
    $review = $_POST["review"];

    $data = array(
        "ISBN" => $isbn,
        "review" => $review
    );

    // Memasukkan ulasan ke dalam tabel "reviews"
    createSingle("reviews", $data);

    // Redirect kembali ke halaman detail buku
    header("Location: detail_book.php?id=" . $isbn);
    exit();
}
?>
