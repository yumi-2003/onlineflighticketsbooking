<?php
require_once "dbconnect.php";

if (!isset($_SESSION)) {
   session_start();
}

$sql = "SELECT * FROM admin";
try {
   $stmt = $conn->prepare($sql);
   $stmt->execute();
   $admin = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
   echo $e->getMessage();
}

$sql = "SELECT * FROM airline";
try {
   $stmt = $conn->prepare($sql);
   $stmt->execute();
   $airlines = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
   echo $e->getMessage();
}

$sql = "SELECT * FROM flight";
try {
   $stmt = $conn->prepare($sql);
   $stmt->execute();
   $flightInfos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
   echo $e->getMessage();
}

$sql = "SELECT * FROM classes";
try {
   $stmt = $conn->prepare($sql);
   $stmt->execute();
   $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
   echo $e->getMessage();
}

$sql = "SELECT * FROM triptype";
try {
   $stmt = $conn->prepare($sql);
   $stmt->execute();
   $triptypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
   echo $e->getMessage();
}


//get flight information
$sql = "SELECT 
        *
    FROM 
        flight
    INNER JOIN 
        airline
    ON 
        flight.airline_id = airline.airline_id
    INNER JOIN 
        flightclasses
    ON 
        flight.flight_id = flightclasses.flight_id
    INNER JOIN 
        classes
    ON
        flightclasses.class_id = classes.class_id
    INNER JOIN
        triptype
    ON
        flightclasses.triptype = triptype.triptypeId
    ";

try {
   $stmt = $conn->query($sql);
   $status = $stmt->execute();

   if ($status) {
      $flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
   }
} catch (PDOException $e) {
   echo $e->getMessage();
}

//insert pricing information

if(isset($_POST['insertPricing']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
   $flight_id = $_POST['flight_id'];
   $class_id = $_POST['class_id'];
   $triptype = $_POST['triptype'];
   $classPrice = $_POST['classPrice'];

   try{
      //fetch fee per ticket
      $sql = "SELECT fee_per_ticket FROM flight WHERE flight_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$flight_id]);
      $fee_per_ticket = $stmt->fetch(PDO::FETCH_ASSOC);
      $fee_per_ticket = $fee_per_ticket['fee_per_ticket'];

      //fetch base fees for class
      $sql = "SELECT base_fees FROM classes WHERE class_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$class_id]);
      $base_fee = $stmt->fetch(PDO::FETCH_ASSOC);
      $base_fee = $base_fee['base_fees'];

      //fetch priceCharge from triptype
      $sql = "SELECT priceCharge FROM triptype WHERE triptypeId = ?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$triptype]);
      $priceCharge = $stmt->fetch(PDO::FETCH_ASSOC);
      $priceCharge = $priceCharge['priceCharge'];

      //calculate class price
      $classPrice = $fee_per_ticket * $base_fee * $priceCharge;

      //insert into flightclasses
      $sql = "INSERT INTO flightclasses (flight_id, class_id, triptype, classPrice) VALUES (?,?,?,?)";
      $stmt = $conn->prepare($sql);
      $status = $stmt->execute([$flight_id, $class_id, $triptype, $classPrice]);

      if($status){
         header('Location: flightClassesandtriptypePrice.php');
      }

   } catch (PDOException $e) {
      echo $e->getMessage();
   }
}


?>

<!doctype html>
<html>

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="./output.css" rel="stylesheet">
   <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>

   
   

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

   <!-- main cotent starts -->
   <div class="p-4 sm:ml-64 mt-16">
      <div class="p-4 border-gray-200 rounded-lg dark:border-gray-700">
         <div class="grid gap-4 mb-4">
            <div class="flex h-10 rounded">
               <p class="text-2xl text-black ">
                  Pricing Information
               </p>
            </div>
            </di>

            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
               <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-3">
                  <div>
                     <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Select Flight Name</label>
                     <select name="flight_id" class="bg-gray-50 border border-gray-300 dark:text-gray text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Choose Flight</option>
                        <?php

                        if (isset($flightInfos)) {
                           foreach ($flightInfos as $flight) {
                              echo "<option value = $flight[flight_id]>$flight[flight_name]</option>";
                           }
                        }
                        ?>
                     </select>
                  </div>
                  <div>
                     <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Select Class Names</label>
                     <select name="class_id" class="bg-gray-50 border border-gray-300 dark:text-gray text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Choose Class Types</option>
                        <?php
                        if (isset($classes)) {
                           foreach ($classes as $class) {
                              echo "<option value = $class[class_id]>$class[class_name]</option>";
                           }
                        }
                        ?>
                     </select>
                  </div>
                  <div>
                     <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Select Trip Type Name</label>
                     <select name="triptype" class="bg-gray-50 border border-gray-300 dark:text-gray text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Choose TripTypes</option>
                        <?php
                        if (isset($triptypes)) {
                           foreach ($triptypes as $triptype) {
                              echo "<option value = $triptype[triptypeId]>$triptype[triptype_name]</option>";
                           }
                        }
                        ?>
                     </select>
                  </div>

                  <input type="hidden" name="classPrice" id="classPrice">

                  <button type="sumbit" name="insertPricing" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Price</button>
            </form>

         </div>
         <div class="font-sans overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
               <thead class="bg-gray-100 whitespace-nowrap">
                  <tr>
                     <th class="px-4 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        ID
                     </th>
                     <th class="px-4 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Flight Name
                     </th>
                     <th class="px-4 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Source
                     </th>
                     <th class="px-4 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Destination
                     </th>
                     <th class="px-4 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Fee per ticket
                     </th>
                     <th class="px-4 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Class Name
                     </th>
                     <th class="px-4 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Trip type Name
                     </th>
                     <th class="px-4 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Total Price
                     </th>
                     <td class="px-4 py-4 text-sm text-gray-800 width-1/4">
                        <button class="text-red-600">Delete</button>
                     </td>
                  </tr>
               </thead>

               <tbody class="bg-white divide-y divide-gray-200 whitespace-nowrap">
                  <?php
                  if (isset($flights)) {
                     foreach ($flights as $flight) {
                        echo "<tr>
                        <td class='px-4 py-4 text-sm text-gray-800'>
                        $flight[flightclasses_id]
                        </td>
                        <td class='px-4 py-4 text-sm text-gray-800 '>
                           $flight[flight_name] 
                        </td>
                        <td class='px-4 py-4 text-sm text-gray-800 '>
                        $flight[source]
                        </td>
                        <td class='px-4 py-4 text-sm text-gray-800 '>
                        $flight[destination]
                        </td>
                        <td class='px-4 py-4 text-sm text-gray-800 '>
                        $$flight[fee_per_ticket]
                        </td>
                        <td class='px-4 py-4 text-sm text-gray-800 '>
                        $flight[class_name]
                        </td>
                        <td class='px-4 py-4 text-sm text-gray-800 '>
                        $flight[triptype_name]
                        </td>
                         <td class='px-4 py-4 text-sm text-gray-800 '>
                        $flight[classPrice]
                        </td>
                        <td class='px-4 py-4 text-sm text-gray-800'>
                        <a href='deleteFlightClasses.php?flightclasses_id=$flight[flightclasses_id]'>
                        <button class='text-red-600'>Delete</button>
                        </a>
                        </td>
                     </tr>";
                     }
                  }

                  ?>
               </tbody>
            </table>
         </div>


      </div>
      <!-- main content ends -->



      <script>
         const dropdownButton = document.getElementById('dropdownButton');
         const dropdownMenu = document.getElementById('dropdownMenu');

         dropdownButton.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');});

         //calcuate Class Price Dynamically
         

      </script>
</body>

</html>