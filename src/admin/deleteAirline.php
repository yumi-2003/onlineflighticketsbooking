<?php
        require_once "dbconnect.php";



        if(!isset($_SESSION)){
            session_start();
        }

        if(isset($_GET['arid'])){

            $airlineId = $_GET['arid'];
            $sql = "delete from airline where airline_id = ?";
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute([$airlineId]);
        }
        if($status){
            $_SESSION['deleteAirline'] = "Airline ID $airlineId has been deleted";
            header('Location:viewAirline.php');
        }
?>