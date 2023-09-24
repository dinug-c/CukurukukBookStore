<?php
require_once("services/session.php");
require_once("components/header.php");
require_once("services/crud.php");
userSession();
headerComponent("Checkout - Cukurukuk BookStore");

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Ambil data dari session
    $totalItem = $_SESSION['total_item'];
    $totalPrice = $_SESSION['total_price'];

    // Ambil tanggal sekarang
    $currentDate = date("Y-m-d");

    // Siapkan data untuk dimasukkan ke tabel orderitem
    $orderData = [
        'Tanggal' => $currentDate,
        'Total_item' => $totalItem,
        'TotalPrice' => $totalPrice
    ];

    // Masukkan data ke tabel orderitem
    if (createSingle("orderitem", $orderData)) {
        // Bersihkan session
        unset($_SESSION['cart']);
        unset($_SESSION['total_item']);
        unset($_SESSION['total_price']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css">
    <title>Checkout - Cukurukuk BookStore</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="alert alert-success" role="alert">
                    Pesanan Anda telah berhasil diproses. Terima kasih telah berbelanja!
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
    } else {
        echo '<div class="container mt-5">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="alert alert-danger" role="alert">
                            Gagal memproses pesanan Anda. Silakan coba lagi.
                        </div>
                    </div>
                </div>
            </div>';
    }
} else {
    echo '<div class="container mt-5">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="alert alert-warning" role="alert">
                        Keranjang belanja Anda kosong. Silakan kembali ke halaman belanja.
                    </div>
                </div>
            </div>
        </div>';
}
?>
