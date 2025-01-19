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

//get flight information

$sql = "SELECT *  FROM flight INNER JOIN airline ON flight.airline_id = airline.airline_id;";
      try {
         $stmt = $conn->query($sql);
         $status = $stmt->execute();

         if ($status) {
            $flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
         }
      } catch (PDOException $e) {
         echo $e->getMessage();
      }
   

if (isset($_POST['search'])) {
   $searchInput = trim($_POST['searchInput']); // trim to remove space

   if (!empty($searchInput)) {
      $searchInput = '%' .$searchInput. '%';

      $sql = "SELECT * FROM flight WHERE flight_name LIKE :search";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':search', $searchInput,PDO::PARAM_STR);
      $stmt->execute();
      $flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
   } else {
      $sql = "SELECT *  FROM flight INNER JOIN airline ON flight.airline_id = airline.airline_id;";
      try {
         $stmt = $conn->query($sql);
         $status = $stmt->execute();

         if ($status) {
            $flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
         }
      } catch (PDOException $e) {
         echo $e->getMessage();
      }
   }
}

?>

<!doctype html>
<html>

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="./output.css" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
   <script src="https://cdn.tailwindcss.com"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
   <script src="..js/dropbutton.js"></script>

</head>

<body>

   <!-- nav starts -->
   <nav class="fixed top-0 z-50 w-full bg-[#00103c]">
      <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto p-4">
         <a href="https://flowbite.com" class="flex items-center space-x-3 rtl:space-x-reverse">
            <!-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" /> -->
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">SwiftMiles</span>
         </a>

         <div class="flex items-center md:order-2 space-x-1 md:space-x-2 rtl:space-x-reverse">
            <?php

            if (isset($_SESSION['isLoggedIn'])) {
            ?>

               <div class="flex items-center">
                  <div class="flex items-center ms-3">
                     <div>
                        <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user" id="dropdownUser">
                           <span class="sr-only">Open user menu</span>
                           <!-- admin profile -->
                           <img class="w-8 h-8 rounded-full" src="<?php echo $admin['profile'] ?>" alt="admin photo">

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
                              <a href="editProfile.php?id=<?php echo $admin['admin_id']; ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Edit Profile</a>

                           </li>
                           <li>
                              <a href="adminLogout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Sign out</a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>

            <?php
            }

            ?>


            <button data-collapse-toggle="mega-menu" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mega-menu" aria-expanded="false">
               <span class="sr-only">Open main menu</span>
               <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
               </svg>
            </button>
         </div>

         <div id="mega-menu" class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1">
            <ul class="flex flex-col mt-4 font-medium md:flex-row md:mt-0 md:space-x-8 rtl:space-x-reverse">
               <li>
                  <a href="#" class="block py-2 px-3  text-gray-900 border-b border-gray-100 md:w-auto hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700" aria-current="page">Home</a>
               </li>
               <li>
                  <button id="mega-menu-dropdown-button" data-dropdown-toggle="mega-menu-dropdown" class="flex items-center justify-between w-full py-2 px-3 font-medium text-gray-900 border-b border-gray-100 md:w-auto hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">
                     Company <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                     </svg>
                  </button>
                  <div id="mega-menu-dropdown" class="absolute z-10 grid hidden w-auto grid-cols-2 text-sm bg-white border border-gray-100 rounded-lg shadow-md dark:border-gray-700 md:grid-cols-3 dark:bg-gray-700">
                     <div class="p-4 pb-0 text-gray-900 md:pb-4 dark:text-white">
                        <ul class="space-y-4" aria-labelledby="mega-menu-dropdown-button">
                           <li>
                              <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                                 About Us
                              </a>
                           </li>
                           <li>
                              <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                                 Newsletter
                              </a>
                           </li>
                           <li>
                              <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                                 Conatct Us
                              </a>
                           </li>
                           <li>
                              <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                                 Support Center
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </li>
               <li>
                  <a href="#" class="block py-2 px-3 text-gray-900 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">Team</a>
               </li>
               <li>
                  <a href="#" class="block py-2 px-3 text-gray-900 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
               </li>
            </ul>
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

   <!-- main contents starts -->
   <div class="p-4 sm:ml-64 mt-20">


      <div class="grid grid-cols-3 grid-rows-5">
         <!-- Search Bar -->
         <div class="col-span-3 bg-blue-100 py-10 h-28">

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
               <div class="flex rounded-md border-2 border-blue-500 overflow-hidden max-w-md mx-auto font-[sans-serif]">
                  <input type="text" name="searchInput" placeholder="Search Flight Name..."
                     class="w-full outline-none bg-white text-gray-600 text-sm px-4 py-3" />
                  <button type="submit" name="search" class="flex items-center justify-center bg-[#007bff] px-5">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192.904 192.904" width="16px" class="fill-white">
                        <path
                           d="m190.707 180.101-47.078-47.077c11.702-14.072 18.752-32.142 18.752-51.831C162.381 36.423 125.959 0 81.191 0 36.422 0 0 36.423 0 81.193c0 44.767 36.422 81.187 81.191 81.187 19.688 0 37.759-7.049 51.831-18.751l47.079 47.078a7.474 7.474 0 0 0 5.303 2.197 7.498 7.498 0 0 0 5.303-12.803zM15 81.193C15 44.694 44.693 15 81.191 15c36.497 0 66.189 29.694 66.189 66.193 0 36.496-29.692 66.187-66.189 66.187C44.693 147.38 15 117.689 15 81.193z">
                        </path>
                     </svg>
                  </button>
               </div>
            </form>
         </div>

         <!-- Flight Info Section -->
         <div class="col-span-1 row-span-6 row-start-2">
            <h3 class="font-semibold text-lg">Flight Info</h3>
            <!-- card info -->
            <?php
            if (isset($flights)) {
               foreach ($flights as $flight) {
                  echo "<div class='relative flex flex-col my-6 bg-white shadow-sm border border-slate-200 rounded-lg w-80'>";
                  echo "<div class='relative h-56 m-2.5 overflow-hidden text-white rounded-md'>
                           <img src='$flight[placeImg]' alt='card-image' />
                           </div>";
                  echo "<div class='p-4'>";
                  echo "<h6 class='mb-2 text-slate-800 text-xl font-semibold'>
                              $flight[flight_name]
                           </h6>";
                  echo "<span>Source: $flight[source] </span><br>
                           <span>Destination: $flight[destination] </span><br>
                           <span>Departure Date: $flight[flight_date]</span><br>
                           <span>Departure Time: $flight[departure_time] </span><br>
                           <span>Arrival Time: $flight[arrival_time]</span><br>";
                  echo "</div>";
                  echo "<form action='$_SERVER[PHP_SELF]' method='POST'>
                           <input type='hidden' name='flight_id' value='$flight[flight_id]'>
                           <div class='px-4 pb-4 pt-0 mt-2'>
                              <button class='rounded-md bg-slate-800 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-slate-700 focus:shadow-none active:bg-slate-700 hover:bg-slate-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none' type='submit' name='showSeats'>
                              View Available Seats
                              </button>
                           </div>
                     </form>
                     ";
                  echo "</div>";
               }
            }
            ?>
         </div>
      </div>

      <!-- Show Seats Section -->
      <div class="col-span-2 row-span-6 row-start-3">
         <h3 class="font-semibold text-lg">Show Seats</h3>
         <?php
         if (isset($_POST['showSeats']) && isset($flight['flight_id'])) {
            $flight_id = $_POST['flight_id'];
            // Fetch seats for a specific flight and class
            $sql = "SELECT * FROM seat_layout WHERE flight_id = :flight_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':flight_id', $flight_id, PDO::PARAM_INT);
            $stmt->execute();
            $seats = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $row = 1;
            $col = 1;

            echo "<form action='$_SERVER[PHP_SELF]' method='POST' class='inline-block' enctype='multipart/form-data'>";
            echo "<div class='seat-container w-full inline-block'>";

            foreach ($seats as $seat) {
               if ($col > 10) {
                  $col = 1;
                  $row++;
                  echo "<br>";
               }

               if ($row > 15) {
                  break;
               }

               // Seat Display with Delete and View Buttons
               $seatStatusClass = $seat['status'] == 1 ? 'bg-red-700 hover:bg-red-800' : 'bg-green-700 hover:bg-green-800';
               echo "
                <div class='inline-block'>
                    <button type='button' class='focus:outline-none text-white {$seatStatusClass} font-medium rounded-lg text-sm px-5 py-2.5 me-1 mb-1 w-16'>{$seat['seatNo']}</button>
                    <div class='mt-2 flex space-x-1'>
                        <!-- View and Delete buttons can be added here -->
                    </div>
                </div>
            ";

               $col++;
            }
            echo "</div>";
            echo "</form>";
         }

         ?>
      </div>
   </div>




   </div>
   <!-- main contents ends -->


   <script>
      const dropdownButton = document.getElementById('dropdownButton');
      const dropdownMenu = document.getElementById('dropdownMenu');

      dropdownButton.addEventListener('click', () => {
         dropdownMenu.classList.toggle('hidden');
      });
   </script>
</body>

</html>