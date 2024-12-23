<?php
        require_once "dbconnect.php";

        if(isset($_SESSION)){
            session_start();
        }


        try{
            $sql = "select * from airline";
            $stmt = $conn->query($sql);
            $airlines = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo $e->getMessage();
        }


        if(isset($_GET['fid'])){

            $flightId = $_GET['fid'];
            $flight = getFlightInfo($flightId);
        }

        function getFlightInfo($fid){
            global $conn;
            $sql = "SELECT 
                    flight.flight_id,
                    airline.airline_name, 
                    flight.flight_name, 
                    flight.flight_date, 
                    flight.destination, 
                    flight.source, 
                    flight.total_distance, 
                    flight.fee_per_ticket, 
                    flight.departure_time, 
                    flight.arrival_time, 
                    flight.capacity, 
                    flight.seats_researved, 
                    flight.seats_available,
                    flight.gate,
                    flight.placeImg  
                FROM 
                    flight
                INNER JOIN 
                    airline
                WHERE
                    flight.airline_id = airline.airline_id AND flight.flight_id = ?";


            $stmt = $conn->prepare($sql);
            $stmt->execute([$fid]);
            $flight = $stmt->fetch(PDO::FETCH_ASSOC);
            return $flight;
        }
        
        if(isset($_POST['update'])){
       
            $flight_Id = $_POST['flight_id'];
            $airname = $_POST['airline_id'];
            $fname = $_POST['flight_name'];
            $date = $_POST['flight_date'];
            $des = $_POST['destination'];
            $ori = $_POST['source'];
            $tdistance = $_POST['total_distance'];
            $price = $_POST['fee_per_ticket'];
            $deptime = $_POST['departure_time'];
            $arrtime = $_POST['arrival_time'];
            $gate = $_POST['gate'];
            $cap = $_POST['capacity'];
            $rerseat = $_POST['seats_researved'];
            $avaseat = $cap - $rerseat;
            $img = $_FILES['placeImg']['name'];
            $uploadImg = "../flightImg/.$img";

            move_uploaded_file($_FILES['placeImg']['tmp_name'],$uploadImg);

            

            try{
                $sql = "Update flight set airline_id = ?,flight_name = ?,flight_date = ? ,destination =?,source =?,total_distance = ?,fee_per_ticket = ?,departure_time = ?,arrival_time=?,gate=?,capacity =? ,seats_researved =?,seats_available = ?, placeImg =? where flight_id=?";

                $stmt = $conn->prepare($sql);

                $status = $stmt->execute([$airname,$fname,$date,$des,$ori,$tdistance,$price,$deptime,$arrtime,$gate,$cap,$rerseat,$avaseat,$img,$flight_Id]);
                

                if($status){
                    $_SESSION['updateFlightComplete'] = "Fligth ID $flightId information has been updated";
                    header("Location:viewFlight.php");
                }
            }catch(PDOException $e){
                echo $e->getMessage();
            }
            

        }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="./output.css" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        
        <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
            <div class="grid-cols-1 gap-6 mb-6 md:grid-cols-1">
                <input type="hidden" name="flight_id"
                    value = 
                    "<?php
                        if(isset($flight['flight_id'])){
                            echo $flight['flight_id'];
                        }
                    ?>">
                <div>

                <label for="airline" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Select Airline</label>
                    <?php
                    if(isset($flight['flight_id'])){
                        echo 'Selected Airline' .$flight['airline_name'];
                    }
                    ?>
                    <select name="airline_id" class="bg-gray-50 border border-gray-300 dark:text-gray text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Choose Airline</option>
                        <?php
                            if(isset($airlines)){
                                foreach($airlines as $airline){
                                    echo "<option value = $airline[airline_id]>$airline[airline_name]</option>";
                                }
                            }

                        ?>
                    </select>
                </div>
                <div>
                    <label for="flight_name" class="block mb-2 text-sm font-medium dark:text-gray dark:text-gray">Flight Name</label>
                    <input type="text" name="flight_name" class=" bg-gray-50 border border-gray-300 dark:text-gray text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Flight Name" required value = 
                    "<?php
                        if(isset($flight['flight_name'])){
                            echo $flight['flight_name'];
                        }
                    ?>" />
                </div>
                
                <div>
                    <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Date</label>
                    <input type="date" name="flight_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date" required value = 
                    "<?php
                        if(isset($flight['flight_date'])){
                            echo $flight['flight_date'];
                        }
                    ?>"
                    
                    
                    />
                </div>  
                
                <div>
                    <label for="des" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Destination</label>
                    <input type="text" name="destination" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Destination" required value = 
                    "<?php
                        if(isset($flight['destination'])){
                            echo $flight['destination'];
                        }
                    ?>" />
                </div>
                <div>
                    <label for="source" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Source</label>
                    <input type="text" name="source" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Origin" required value = "<?php
                        if(isset($flight['source'])){
                            echo $flight['source'];
                        }
                    ?>"
                    />
                </div>
                
                <div>
                    <label for="tdistance" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Total Distance</label>
                    <input type="text" name="total_distance" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Total Distance in kilometer" required value = "<?php
                        if(isset($flight['total_distance'])){
                            echo $flight['total_distance'];
                        }
                    ?>"
                    
                    />
                </div>
                <div>
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Fee Per Tickets</label>
                    <input type="number" name="fee_per_ticket" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Price Per Tickets" required value = "<?php
                        if(isset($flight['fee_per_ticket'])){
                            echo $flight['fee_per_ticket'];
                        }
                    ?>" />
                </div>
                
                <div>
                    <label for="deptime" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Departure Time</label>
                    <input type="time" name="departure_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Departure Time" required value = "<?php
                        if(isset($flight['departure_time'])){
                            echo $flight['departure_time'];
                        }
                    ?>"/>
                </div>
                <div>
                    <label for="arrtime" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Arrival Time</label>
                    <input type="time" name="arrival_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Arrival Time" required value = "<?php
                        if(isset($flight['arrival_time'])){
                            echo $flight['arrival_time'];
                        }
                    ?>" />
                </div>

                <div>
                    <label for="gateName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Gate</label>
                    <input type="text" name="gate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Arrival Time" required value = "<?php
                        if(isset($flight['gate'])){
                            echo $flight['gate'];
                        }
                    ?>" />
                </div>
               
                <div>
                    <label for="cap" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Capacity</label>
                    <input type="number" name="capacity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Capacity" required value = "<?php
                        if(isset($flight['capacity'])){
                            echo $flight['capacity'];
                        }
                    ?>"/>
                </div>
               
                <div>
                    <label for="reseats" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Reserved Seats</label>
                    <input type="number" name="seats_researved" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Reserved Seats" required value = "<?php
                        if(isset($flight['seats_researved'])){
                            echo $flight['seats_researved'];
                        }
                    ?>" />
                </div>
                <div>
                    <label for="avaseats" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Available Seats</label>
                    <input type="number" name="seats_available" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Available Seats" required value = "<?php
                        if(isset($flight['seats_available'])){
                            echo $flight['seats_available'];
                        }
                    ?>" />
                </div>

                <div>
                    <label for="avaseats" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Previous destination photo</label>
                    <img class="w-10 h-10" src="<?php
                        if(isset($flight['image'])){
                            echo $flight['image'];
                        }
                    ?>" alt="">
                    <input type="file" name="placeImg" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Choose image" required value = "" />
                </div>
            </div>
           
            <button type="sumbit" name="update" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update Flight Schedule</button>
        </form>

    </body>
</html>