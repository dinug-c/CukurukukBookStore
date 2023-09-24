<?php
function adminSession() {
    session_start();
    if(!$_SESSION['admin']){
        header('Location: index.php');
    }
}

function userSession(){
    session_start();
    if(!$_SESSION['user']){
        header('Location: login.php');
    }
}

function bothSession(){
    session_start();
    if(!$_SESSION['user'] && !$_SESSION['admin']){
        header('Location: login.php');
    }
}
?>

