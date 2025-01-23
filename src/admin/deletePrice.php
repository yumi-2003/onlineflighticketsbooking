<?php


require_once 'dbconnect.php';

if(!isset($_SESSION)){
    session_start();
}

        if(isset($_GET['flightclasses_id'])){

            $flightClasses = $_GET['flightclasses_id'];
            $sql = "delete from flightclasses where flightclasses_id = ?";
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute([$flightClasses]);
        }
        if($status){
            //$_SESSION['deleteAirline'] = "Airline ID $airlineId has been deleted";
            header('Location:flightClassesanndtriptyePrice.php');
        }





?>