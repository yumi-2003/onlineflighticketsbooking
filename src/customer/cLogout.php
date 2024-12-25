<?php

    if(!isset($_SESSION)){
        session_start();
    }

    if(isset($_SESSION['userisLoggedIn'])){
        
        session_destroy();
        header('Location: cLogin.php');
    }
?>