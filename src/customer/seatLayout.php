<?php
    require_once 'dbconnect.php';

    if(!isset($_SESSION)){
        session_start();
    }
  
    //$flightID = $_GET['flight_ID'];  
    
    // Define class distribution
    $classes = [
        ['class_ID' => 1, 'prefix' => 'F', 'count' => 10],   // First Class
        ['class_ID' => 2, 'prefix' => 'B', 'count' => 30],   // Business Class
        ['class_ID' => 3, 'prefix' => 'P', 'count' => 50],   // Premium Economy
        ['class_ID' => 4, 'prefix' => 'E', 'count' => 60],   // Economy
    ];
    
    // Generate and insert seats for each class
    foreach ($classes as $class) {
        $classID = $class['class_ID'];
        $prefix = $class['prefix'];
        $count = $class['count'];
    
        for ($i = 1; $i <= $count; $i++) {
            $seatNumber = $prefix . $i;  // Generate seat number (e.g., F1, B1, P1, E1)
            $sql = "INSERT INTO seat_layout (flight_ID, class_ID, seatNo, status) VALUES ('$flightID', '$classID', '$seatNumber', 0)";
            $conn->query($sql);
        }
    }
    
    echo "Seats generated successfully for all classes!";
    ?>
    