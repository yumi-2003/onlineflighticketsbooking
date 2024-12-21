<?php
        require_once "dbconnect.php";

        if(isset($_SESSION)){
            session_start();
        }

        if(isset($_GET['fid'])){

            $flightId = $_GET['fid'];
            $sql = "delete from flight where flight_id = ?";
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute([$flightId]);
            
        }

        if($status){
            //$_SESSION['']
            header('Location:viewFlight.php');
        }

        
        
       
                

                
?>
