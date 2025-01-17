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
            $filename = $_FILES['placeImg']['name'];
            $uploadPath = "../flightImg/".$filename;
            move_uploaded_file($_FILES['placeImg']['tmp_name'], $uploadPath);


            try{
                $sql = "Update flight set airline_id = ?,flight_name = ?,flight_date = ? ,destination =?,source =?,total_distance = ?,fee_per_ticket = ?,departure_time = ?,arrival_time=?,gate=?,capacity =?,placeImg =? where flight_id=?";

                $stmt = $conn->prepare($sql);
                $status = $stmt->execute([$airname,$fname,$date,$des,$ori,$tdistance,$price,$deptime,$arrtime,$gate,$cap,$uploadPath,$flight_Id]);
                

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

    <nav class="fixed top-0 z-50 w-full bg-gray-50 dark:bg-gray-800">
      <div class="px-3 py-3 lg:px-5 lg:pl-3">
         <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
               <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                  <span class="sr-only">Open sidebar</span>
                  <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"></svg>
                  <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                  </svg>
               </button>
               <a href="https://flowbite.com" class="flex ms-2 md:me-24">
                  <!-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-3" alt="FlowBite Logo" /> -->
                  <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">SwiftMiles</span>
               </a>
            </div>

            <?php
            session_start();
            if (isset($_SESSION['isLoggedIn'])) {
            ?>

               <div class="flex items-center">
                  <div class="flex items-center ms-3">
                     <div>
                        <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user" id="dropdownUser">
                           <span class="sr-only">Open user menu</span>
                           <!-- admin profile -->
                           <img class="w-8 h-8 rounded-full" src="../userPhoto/download (3).jpg" alt="admin photo">

                        </button>
                     </div>

                     <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                           <p class="text-sm text-gray-900 dark:text-white" role="none">
                              <?php
                              echo $_SESSION['adName'];
                              ?>
                           </p>
                           <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                              <?php
                              echo $_SESSION['adEmail'];
                              ?>
                           </p>
                        </div>
                        <ul class="py-1" role="none">
                           <li>
                              <a href="editProfile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Edit Profile</a>
                           </li>
                           <li>
                              <a href="adminLogout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Sign out</a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>

            <?php
            } else {
               echo '<a href="login.php" class="text-sm text-gray-700 dark:text-gray-300">Login</a>';
            }
            ?>

         </div>
      </div>
   </nav>
   <!-- nav ends -->

   <!-- sidebar starts -->
   <aside id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 mt-10 py-3" aria-label="Sidebar">
      <div class="h-full px-3 py-4 overflow-y-auto">
         <ul class="space-y-2 font-medium">

            <li>
               <a href="admindashboard.php" class="flex items-center p-2 text-gray-900 rounded-lg text-darkBlue hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-white group">
                  <span class="ms-3">Dashboard</span>
               </a>
            </li>

            <li>
               <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-blue dark:hover:bg-gray-700" aria-controls="dropdown" data-collapse-toggle="dropdown" id="dropdownButton">
                  <span class="flex-1 ms-3 text-left rtl:text-right hover:text-white whitespace-nowrap dark:text-blue">Flight Information</span>
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                  </svg>
               </button>
               <ul id="dropdownMenu" class="hidden py-2 space-y-2">
                  <li>
                     <a href="viewAirline.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-blue hover:text-white dark:hover:bg-gray-700">Airline</a>
                  </li>
                  <li>
                     <a href="viewFlight.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-blue dark:hover:bg-gray-700 hover:text-white">Flight Schedule</a>
                  </li>
                  <li>
                     <a href="viewFlightClasses.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-blue dark:hover:bg-gray-700 hover:text-white">Flight Classes & Trip Types</a>
                  </li>
                  <li>
                     <a href="flightClassesandtriptypePrice.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-blue dark:hover:bg-gray-700 hover:text-white">Pricing</a>
                  </li>
                  <li>
                     <a href="viewSeats.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-blue dark:hover:bg-gray-700 hover:text-white">Seat Number</a>
                  </li>
               </ul>
            </li>

            <li>
               <a href="viewBooking.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-blue hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <span class="flex-1 ms-3 whitespace-nowrap hover:text-white">Booking</span>
                  <span class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300 hover:text-white">
                     
                  <?php
                     $sql = "SELECT * FROM booking";
                     $result = $conn->query($sql);
                     $bookingCount = $result->rowCount();
                     echo $bookingCount;

                  ?>
               
                  </span>
               </a>
            </li>

            <li>
               <a href="viewTickets.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-blue hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <span class="flex-1 ms-3 whitespace-nowrap hover:text-white">Tickets</span>
                  <span class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
                     
                  <!-- //count of bookings -->
               
                  </span>
               </a>
            </li>

            <li>
               <a href="viewUsers.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-blue hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <span class="flex-1 ms-3 whitespace-nowrap hover:text-white">Users</span>
               </a>
            </li>

            <li>
               <a href="viewPayment.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-blue hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <span class="flex-1 ms-3 whitespace-nowrap hover:text-white">Payment</span>
               </a>
            </li>
         </ul>
      </div>
   </aside>
   <!-- sidebar ends -->

   <!-- view airline information -->
   <div class="p-4 sm:ml-64">
      <div class="p-4 border-gray-200 dark:border-gray-700 mt-14">
         <div class="grid-cols-2">
            <div>
               <p>
                  <span class="font-semibold">Editing Flight Information</span>
               </p>
            </div>
         </div>


         <div class="font-sans overflow-x-auto">
         <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" class="mt-16">
            <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-3">
            <input type="hidden" name="flight_id"
                value = 
                "<?php
                if(isset($flight['flight_id'])){
                    echo $flight['flight_id'];
                }
                ?>">
            <div>
                <label for="airline_name" class="block mb-2 text-sm font-medium dark:text-gray dark:text-gray">Selected Airline</label>
                <?php
                if(isset($flight['airline_name'])){
                echo $flight['airline_name'];
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
                <input type="text" name="flight_name" class="bg-gray-50 border border-gray-300 dark:text-gray text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Flight Name" required value = 
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
                ?>" />
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
                ?>" />
            </div>
            <div>
                <label for="tdistance" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Total Distance</label>
                <input type="text" name="total_distance" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Total Distance in kilometer" required value = "<?php
                if(isset($flight['total_distance'])){
                    echo $flight['total_distance'];
                }
                ?>" />
            </div>
            <div>
                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Fee Per Tickets</label>
                <input type="number" min="0" name="fee_per_ticket" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Price Per Tickets" required value = "<?php
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
                ?>" />
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
                <input type="text" name="gate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Gate" required value = "<?php
                if(isset($flight['gate'])){
                    echo $flight['gate'];
                }
                ?>" />
            </div>
            <div>
                <label for="cap" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Capacity</label>
                <input type="number" min="0" name="capacity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Capacity" required value = "<?php
                if(isset($flight['capacity'])){
                    echo $flight['capacity'];
                }
                ?>" />
            </div>
           
            <div>
                <label for="avaseats" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Previous destination photo</label>
                <img class="w-20 h-20" src='<?php
                if(isset($flight['placeImg'])){
                    echo $flight['placeImg'];
                }
                ?>' alt="">
                <input type="file" name="placeImg" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-3" placeholder="Choose image" required value = "" />
            </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" name="update" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update Flight Schedule</button>
            </div></div>
        </form>
         </div>
      </div>
   </div>
   <!-- end airline information -->
    </body>
</html>