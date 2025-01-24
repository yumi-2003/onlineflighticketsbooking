<?php
        require_once "dbconnect.php";



        if(!isset($_SESSION)){
            session_start();
        }

        if(isset($_GET['uid'])){

            $userId = $_GET['uid'];
            $sql = "delete from users where user_id = ?";
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute([$userId]);
        }
        if($status){
            //$_SESSION['deleteAirline'] = "d";
            header('Location:viewUsers.php');
        }
?>