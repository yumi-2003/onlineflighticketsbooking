<?php
        require_once "dbconnect.php";

        if(!isset($_SESSION)){
            session_start();
        }

        if(isset($_GET['pid'])){

            $paymentId = $_GET['pid'];
            $sql = "delete from payment where paymentID = ?";
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute([$paymentId]);
            
        }

        if($status){
            //$_SESSION['']
            header('Location:viewPayment.php');
        }
?>
