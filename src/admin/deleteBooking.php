<?php
        require_once "dbconnect.php";

        if(!isset($_SESSION)){
            session_start();
        }

        if(isset($_GET['bid'])){

            $bookingId = $_GET['bid'];
            $sql = "delete from booking where booking_id=?";
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute([$bookingId]);
            
        }

        if($status){
            //$_SESSION['']
            header('Location:viewBooking.php');
        }
?>