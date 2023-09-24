<?php
require_once("services/session.php");
require_once("components/header.php");
require_once("services/crud.php");
userSession();
headerComponent("Show Cart - Cukurukuk BookStore");
$id = (isset($_GET['id']) ? $_GET['id'] : '');
if ($id != '') {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        $_SESSION['cart'][$id] = 1;
    }
}
?>
<br>
<div class="card mt-4">
    <div class="card-header">Shopping Cart</div>
    <div class="card-body">
        <br>
        <table class="table table-striped">
            <tr>
                <th>ISBN</th>
                <th>Author</th>
                <th>Title</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Price * Qty</th>
            </tr>
            <?php
         
            $sum_qty = 0;
            $sum_price = 0;

            if(isset($_SESSION['cart'])){
                if (is_array($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $id => $qty) {
                        $result = getSingleByQuery("buku", "ISBN", $id);
                        while ($row = $result->fetch_object()) {
                            echo '<tr>';
                            echo '<td>' . $row->ISBN . '</td>';
                            echo '<td>' . $row->Author . '</td>';
                            echo '<td>' . $row->Title . '</td>';
                            echo '<td>Rp ' . $row->Price . '</td>';
                            echo '<td>' . $qty . '</td>';
                            echo '<td>Rp ' . $row->Price * $qty . '</td>';
                            echo '</tr>';
    
                            $sum_qty = $sum_qty + $qty;
                            $sum_price = $sum_price + ($row->Price * $qty);
                        }
                    }
                    echo '<tr><td></td><td></td><td></td><td></td><td></td><td>Rp ' . $sum_price . '</td>';
                    $result->free();
                    $db->close();
                } else {
                    echo '<tr><td colspan="6" align="center">There is no item in shopping cart</td></tr>';
                }
            }
            ?>
        </table>
        Total items = <?php echo $sum_qty ?><br><br>
        <a class="btn btn-primary" href="checkout.php">Checkout</a>
        <a class="btn btn-primary" href="home.php">Continue Shopping</a>
        <a class="btn btn-danger" href="delete_cart.php">Empty Cart</a>
    </div>
</div>