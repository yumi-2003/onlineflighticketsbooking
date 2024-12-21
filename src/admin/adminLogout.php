<?php

    if(!isset($_SESSION)){
        session_start();
    }


    if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true){
        session_unset();
        session_destroy();
        header('Location: adminLogin.php');
        exit();
    } else {
        header('Location: adminLogin.php');
        exit();
    }
?>