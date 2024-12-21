<?php
        require_once "dbconnect.php";


        try{
            $sql = "select * from airline";
            $stmt = $conn->query($sql);
            $airlines = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        
        if(isset($_POST['insert'])){

            $airname = $_POST['airline_id'];
            $fname = $_POST['flight_name'];
            $date = $_POST['flight_date'];
            $des = $_POST['destination'];
            $ori = $_POST['source'];
            $tdistance = $_POST['total_distance'];
            $price = $_POST['fee_per_ticket'];
            $deptime = $_POST['departure_time'];
            $arrtime = $_POST['arrival_time'];
            $cap = $_POST['capacity'];
            $rerseat = $_POST['seats_researved'];
            $avaseat = $_POST['seats_available'];
            $gate = $_POST['gate'];
            $img = $_FILES['image']['name'];
            $uploadImg = "../images/flight/".$img;

            move_uploaded_file($_FILES['image']['tmp_name'], $uploadImg);


            
            
            try{
                $sql = "INSERT INTO flight (airline_id,flight_name,flight_date,destination,source,total_distance,fee_per_ticket,departure_time,arrival_time,capacity,seats_researved,seats_available,gate,image) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $status = $stmt->execute([$airname,$fname,$date,$des,$ori,$tdistance,$price,$deptime,$arrtime,$cap,$rerseat,$avaseat,$gate,$img]);
                $flightId = $conn->lastInsertId();


                if($status){
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
                <div>
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Select Airline</label>
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
                    <input type="text" name="flight_name" class=" bg-gray-50 border border-gray-300 dark:text-gray text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Flight Name" required />
                </div>
                
                <div>
                    <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Date</label>
                    <input type="date" name="flight_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date" required />
                </div>  
                
                <div>
                    <label for="des" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Destination</label>
                    <input type="text" name="destination" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Destination" required />
                </div>
                <div>
                    <label for="source" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Source</label>
                    <input type="text" name="source" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Origin" required />
                </div>
                
                <div>
                    <label for="tdistance" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Total Distance</label>
                    <input type="text" name="total_distance" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Total Distance in kilometer" required />
                </div>
                <div>
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Fee Per Tickets</label>
                    <input type="number" name="fee_per_ticket" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Price Per Tickets" required />
                </div>
                
                <div>
                    <label for="deptime" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Departure Time</label>
                    <input type="time" name="departure_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Departure Time" required />
                </div>
                <div>
                    <label for="arrtime" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Arrival Time</label>
                    <input type="time" name="arrival_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Arrival Time" required />
                </div>

                <div>
                    <label for="gateName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Gate</label>
                    <input type="text" name="gate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="gate" required />
                </div>
               
                <div>
                    <label for="cap" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Capacity</label>
                    <input type="number" name="capacity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Capacity" required />
                </div>
               
                <div>
                    <label for="reseats" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Reserved Seats</label>
                    <input type="number" name="seats_researved" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Reserved Seats" required />
                </div>
                <div>
                    <label for="avaseats" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Available Seats</label>
                    <input type="number" name="seats_available" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Available Seats" required />
                </div>
                <div>
                    <label for="avaseats" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Photo</label>
                    <input type="file" name="seats_available" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Available Seats" required />
                </div>
            </div>
           
            <button type="sumbit" name="insert" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Flight Schedule</button>
        </form>

    </body>
</html>