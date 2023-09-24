<?php
function adminSession() {
    session_start();
    if(!isset($_SESSION['username'])){
        header('Location: admin.php');
    }elseif($_SESSION['category'] != "admin"){
        header('Location: dashboard.php');
    }
}

function userSession(){
    session_start();
    if(!isset($_SESSION['username'])){
        header('Location: login.php');
    }elseif($_SESSION['category'] != "customer"){
        header('Location: index.php');
    }
}
?>