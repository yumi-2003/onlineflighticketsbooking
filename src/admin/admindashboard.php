<?php

require_once "dbconnect.php";

if (!isset($_SESSION)) {
   session_start();
}
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION['isLoggedIn'])) {
   header('Location:adminLogin.php');
}

$sql = "SELECT * FROM admin";
try {
   $stmt = $conn->prepare($sql);
   $stmt->execute();
   $admin = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
   echo $e->getMessage();
}

//booking over time chart daily

// Database query for daily bookings
$sql = "SELECT DATE(bookAt) as booking_date, COUNT(*) as total_bookings
            FROM booking
            GROUP BY DATE(booking_date)
            ORDER BY booking_date ASC";
$result = $conn->prepare($sql);
$result->execute();

// Prepare data for embedding
$dates = [];
$bookings = [];
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
   $dates[] = $row['booking_date'];
   $bookings[] = $row['total_bookings'];
}


//top 5 most active users
// Database query for top 5 most active users
$sql = "SELECT users.username, COUNT(*) as total_bookings
            FROM booking
            JOIN users ON booking.user_id = users.user_id
            GROUP BY users.user_id
            ORDER BY total_bookings DESC
            LIMIT 5";
$result = $conn->prepare($sql);
$result->execute();

// Prepare data for embedding
$users = [];
$bookings1 = [];
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
   $users[] = $row['username']; // You now fetch usernames instead of user_id
   $bookings1[] = $row['total_bookings'];
}

// booked flight classes
$classNames = [];
$classBookings = [];

if (isset($_GET['flight_id']) && !empty($_GET['flight_id'])) {
   $flightId = $_GET['flight_id']; // Retrieve the selected flight ID from the form

   // SQL query to count bookings for each class for the selected flight
   $sql = "SELECT classes.class_name, COUNT(*) as total_bookings
           FROM booking
           JOIN classes ON booking.class_id = classes.class_id
           WHERE booking.flight_id = ?
           GROUP BY classes.class_id
           ORDER BY total_bookings DESC";

   $stmt = $conn->prepare($sql);
   $stmt->execute([$flightId]);

   // Fetch booking data for the selected flight
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $classNames[] = $row['class_name']; // Collect class names
      $classBookings[] = $row['total_bookings']; // Collect total bookings for each class
   }
}

// booked trip types
$tripTypes = [];
$tripTypeBookings = [];
if (isset($_GET['flight_id']) && !empty($_GET['flight_id'])) {
   $flightId = $_GET['flight_id']; // Retrieve the selected flight ID from the form

   // SQL query to count bookings for each trip type for the selected flight
   $sql = "SELECT triptype.triptype_name, COUNT(*) as total_bookings
           FROM booking
           JOIN triptype ON booking.triptype_id = triptype.triptypeId
           WHERE booking.flight_id = ?
           GROUP BY triptype.triptypeId
           ORDER BY total_bookings DESC";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$flightId]);
   // Fetch booking data for the selected flight
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $tripTypes[] = $row['triptype_name']; // Collect trip type names
      $tripTypeBookings[] = $row['total_bookings']; // Collect total bookings for each trip type
   }
}

// Revenue distribution by trip types and classes
// Initialize the arrays to hold the necessary data
$tripTypeNames = [];
$classNames1 = [];
$revenueData = [];
$totalRevenue = 0;

// SQL query to calculate revenue distribution by trip types and classes
$sql = "SELECT triptype.triptype_name, classes.class_name, SUM(payment.totalPrice) as total_revenue
        FROM booking
        JOIN classes ON booking.class_id = classes.class_id
        JOIN triptype ON booking.triptype_id = triptype.triptypeId
        JOIN payment ON booking.payment_id = payment.paymentID
        GROUP BY triptype.triptypeId, classes.class_id
        ORDER BY total_revenue DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();

// Fetch revenue data for each trip type and class
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
   // Store the trip type and class names
   $tripTypeNames[] = $row['triptype_name'];
   $classNames1[] = $row['class_name'];

   // Store the total revenue for each trip type-class combination
   $revenueData[] = $row['total_revenue'];

   // Accumulate the total revenue to calculate percentages later
   $totalRevenue += $row['total_revenue'];
}

// Calculate the percentages for each category (trip type-class)
$percentages = [];
foreach ($revenueData as $revenue) {
   if ($totalRevenue > 0) {
      $percentages[] = round(($revenue / $totalRevenue) * 100, 2); // Calculate percentage
   } else {
      $percentages[] = 0; // Handle division by zero if no revenue is available
   }
}

//booked seat numbers in each flight

$sql = "SELECT 
flight.flight_name,
flight.capacity,
COUNT(DISTINCT booking.seatNOId) AS bookedSeats,
(flight.capacity - COUNT(DISTINCT booking.seatNOId)) AS availableSeats
FROM 
booking
JOIN 
flight ON booking.flight_id = flight.flight_id
GROUP BY 
flight.flight_id;
";

$result = $conn->query($sql);

$flightNames = [];
$capacity = [];
$bookedSeats = [];
$availableSeats = [];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
   $flightNames[] = $row['flight_name'];
   $capacity[] = $row['capacity'];
   $bookedSeats[] = $row['bookedSeats'];
   $availableSeats[] = $row['availableSeats'];
}

//flight count by each airline

$sql = "SELECT airline.airline_name,
COUNT(flight.flight_id) AS flight_count
FROM flight
JOIN airline ON flight.airline_id = airline.airline_id
GROUP BY airline.airline_id;";

$flightCount = $conn->query($sql);

$airlineNames = [];
$flightCounts = [];

while ($row = $flightCount->fetch(PDO::FETCH_ASSOC)) {
   $airlineNames[] = $row['airline_name'];
   $flightCounts[] = $row['flight_count'];
}

//total revenue by daily
// Database query for daily revenue
$sql = "SELECT DATE(bookAt) as booking_date, SUM(totalPrice) as total_revenue
            FROM booking 
            JOIN
            	payment
            ON
            	booking.payment_id = payment.paymentID
            GROUP BY DATE(booking_date)
            ORDER BY booking_date ASC;";
$result = $conn->prepare($sql);
$result->execute();
// Prepare data for embedding
$dates1 = [];
$revenues = [];
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
   $dates1[] = $row['booking_date'];
   $revenues[] = $row['total_revenue'];
}



?>

<!doctype html>
<html>

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="./output.css" rel="stylesheet">
   <script src="https://cdn.tailwindcss.com"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
   <script src="..js/dropbutton.js"></script>
   <script
      src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
   </script>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-[#f2f1ef]">

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
   <div class="p-4 sm:ml-64">
      < class="p-4 rounded-lg dark:border-gray-700 mt-14">
         <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome to Admin Dashboard!!!</h1>

         <p>
            <?php
            if (isset($_SESSION['adminLoginSuccess'])) {
               echo "<div class='p-4 mb-4 text-sm text-black rounded-lg bg-green-50 dark:bg-cyan-50 dark:text-green-400' role='alert'>
                        <span class='font-medium'>$_SESSION[adminLoginSuccess]</span>
                     </div>
                     ";
               unset($_SESSION['adminLoginSuccess']);
            }
            ?>
         </p>

         <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <div class="p-6 bg-[#0034b0] text-white rounded-lg shadow-md hover:shadow-lg">
               <div class="flex items-center space-x-4">
                  <h2 class="text-lg font-bold">Users</h2>
                  <span>
                     <img src="/images/group.png" class="w-10 h-10" alt="user">
                  </span>
               </div>
               <p class="text-2xl">
                  <?php
                  $sql = "SELECT COUNT(*) as user_count FROM users";
                  $result = $conn->query($sql);
                  $userCount = $result->fetch(PDO::FETCH_ASSOC);
                  echo $userCount['user_count'];
                  ?>
               </p>
            </div>

            <div class="p-6 bg-[#0034b0] text-white rounded-lg shadow-md hover:shadow-lg">
               <div class="flex items-center space-x-4">
                  <h2 class="text-lg font-bold">Flight</h2>
                  <span>
                     <img src="/images/airplane.png" class="w-10 h-10" alt="flight">
                  </span>
               </div>
               <p class="text-2xl">
                  <?php
                  $sql = "SELECT COUNT(*) as flight_count FROM flight";
                  $result = $conn->query($sql);
                  $flightCount = $result->fetch(PDO::FETCH_ASSOC);
                  echo $flightCount['flight_count'];
                  ?>
               </p>
            </div>

            <div class="p-6 bg-[#0034b0] text-white rounded-lg shadow-md hover:shadow-lg">
               <div class="flex items-center space-x-4">
                  <h2 class="text-lg font-bold">Booking</h2>
                  <span>
                     <img src="/images/booking (1).png" class="w-10 h-10" alt="booking">
                  </span>
               </div>
               <p class="text-2xl">
                  <?php
                  $sql = "SELECT COUNT(*) as booking_count FROM booking";
                  $result = $conn->query($sql);
                  $bookingCount = $result->fetch(PDO::FETCH_ASSOC);
                  echo $bookingCount['booking_count'];
                  ?>
               </p>
            </div>

            <div class="p-6 bg-[#0034b0] text-white rounded-lg shadow-md hover:shadow-lg">
               <div class="flex items-center space-x-4">
                  <h2 class="text-lg font-bold">Total Revenue</h2>
                  <span>
                     <img src="/images/tag.png" class="w-10 h-10" alt="revenue">
                  </span>
               </div>
               <p class="text-2xl">
                  <?php
                  $sql = "SELECT SUM(totalPrice) as total_revenue FROM payment";
                  $result = $conn->query($sql);
                  $revenue = $result->fetch(PDO::FETCH_ASSOC);
                  echo "$" . $revenue['total_revenue'];
                  ?>
               </p>
            </div>
         </div>

         <div class="flex flex-wrap lg:flex-nowrap items-start justify-between space-y-6 lg:space-y-0 lg:space-x-6 p-6">
            <!-- Booking Chart Section -->
            <div class="flex flex-col items-center justify-center bg-[#cfedff] rounded-lg shadow-md w-full lg:w-2/3">
               <h2 class="text-xl font-semibold text-black-700 dark:text-black-300 mb-4">
                  Bookings Over Time
               </h2>

               <div class="w-full h-64 sm:h-80">
                  <canvas id="bookingChart" class="w-full h-full"></canvas>
               </div>
            </div>

            <!-- Grid Sections (stacked vertically on small screens, side-by-side on larger screens) -->
            <div class="flex flex-col w-full lg:w-1/3 space-y-6">
               <div class="flex items-center justify-center rounded bg-[#74c2ff] h-28">
                  <div class="text-center">
                     <h1 class="text-lg font-semibold text-gray-800">Confirmed Booking Count:</h1>
                     <span class="text-2xl text-gray-700">
                        <?php
                        $sql = "SELECT COUNT(*) as confirmed_booking FROM booking WHERE status = 'confirm'";
                        $result = $conn->query($sql);
                        $confirmedBooking = $result->fetch(PDO::FETCH_ASSOC);
                        echo $confirmedBooking['confirmed_booking'];
                        ?>
                     </span>
                  </div>
               </div>

               <div class="flex items-center justify-center rounded bg-[#74c2ff] h-28">
                  <div class="text-center">
                     <h1 class="text-lg font-semibold text-gray-800">Pending Booking Count:</h1>
                     <span class="text-2xl text-gray-700">
                        <?php
                        $sql = "SELECT COUNT(*) as pending_booking FROM booking WHERE status = 'pending'";
                        $result = $conn->query($sql);
                        $pendingBooking = $result->fetch(PDO::FETCH_ASSOC);
                        echo $pendingBooking['pending_booking'];
                        ?>
                     </span>
                  </div>
               </div>
            </div>
         </div>

         <!-- Most Active Users Chart -->
         <div class="flex flex-col items-center justify-center p-6 bg-[#f0f4f8] rounded-lg shadow-md w-full mt-6">
            <h2 class="text-xl font-semibold text-black-700 dark:text-black-300 mb-4">
               Most Active Users
            </h2>
            <div class="w-full h-64 sm:h-80">
               <canvas id="activeUsersChart" class="w-full h-full"></canvas>
            </div>
         </div>

         <!-- booked flight classes and triptype by flight -->
         <div class="w-full text-center mb-6 mt-10">
            <form action="" method="GET" class="flex flex-col sm:flex-row items-center justify-center space-y-2 sm:space-y-0 sm:space-x-4">
               <label for="flightSelect" class="text-lg font-semibold text-black">Select Flight:</label>
               <select id="flightSelect" name="flight_id" class="border border-gray-300 rounded-lg p-2 w-60">
                  <option value="">Select Flight</option>
                  <?php
                  // Fetch flight details from the database
                  $selectedFlightId = isset($_GET['flight_id']) ? $_GET['flight_id'] : '';
                  $sql = "SELECT flight_id, flight_name FROM flight";
                  $stmt = $conn->prepare($sql);
                  if ($stmt->execute()) {
                     $flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
                     foreach ($flights as $flight) {
                        $selected = ($selectedFlightId == $flight['flight_id']) ? 'selected' : '';
                        echo "<option value='{$flight['flight_id']}' $selected>{$flight['flight_name']} (ID: {$flight['flight_id']})</option>";
                     }
                  } else {
                     echo "<option value=''>Error fetching flights</option>";
                  }
                  ?>
               </select>
               <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Filter</button>
            </form>


            <!-- Charts Section -->
            <div class="flex flex-wrap lg:flex-nowrap items-center justify-center w-full space-y-6 lg:space-y-0 lg:space-x-6">
               <!-- Flight Classes Chart -->
               <div class="flex flex-col items-center justify-center w-full lg:w-1/2">
                  <h2 class="text-xl font-semibold text-black mb-4">Booked Flight Classes</h2>
                  <div class="w-full h-64">
                     <canvas id="flightClassesChart" class="w-full h-full"></canvas>
                  </div>
               </div>

               <!-- Trip Types Chart -->
               <div class="flex flex-col items-center justify-center w-full lg:w-1/2">
                  <h2 class="text-xl font-semibold text-black mb-4">Booked Trip Types</h2>
                  <div class="w-full h-64">
                     <canvas id="tripType" class="w-full h-full"></canvas>
                  </div>
               </div>
            </div>
         </div>

         <div class="flex flex-col items-center justify-center bg-[#cfedff] rounded-lg shadow-md w-full p-6">
            <h2 class="text-xl font-semibold text-black mb-4">
               Revenue Distribution by Trip Type and Class
            </h2>

            <div class="w-full h-64 sm:h-80">
               <canvas id="revenueChart" class="w-full h-full"></canvas>
            </div>
         </div>

         <div class="flex flex-col items-center justify-center h-auto p-4 rounded-lg bg-[#a8dcff] mt-10 shadow-md">
            <!-- Title -->
            <h2 class="text-2xl font-semibold text-black dark:text-black mb-6 text-center">
               Booked Seats in Each Flight
            </h2>

            <!-- Chart Container -->
            <div class="w-full h-64 sm:h-80 md:w-3/4 lg:w-2/3 xl:w-1/2">
               <canvas id="bookedSeats" class="w-full h-full"></canvas>
            </div>
         </div>

         <div class="flex flex-col items-center justify-center h-auto p-4 rounded-lg bg-[#a8dcff] mt-10 shadow-md w-auto">
            <!-- Title -->
            <h2 class="text-2xl font-semibold text-black dark:text-black mb-6 text-center">
               Flight Counts By Each Airline
            </h2>

            <!-- Chart Container -->
            <div class="flex w-full h-auto sm:h-auto md:w-3/4 lg:w-2/3 xl:w-1/2">
               <canvas id="airFlight" class="w-full h-full"></canvas>
            </div>
         </div>

         <div class="flex flex-col items-center justify-center h-auto p-4 rounded-lg bg-[#a8dcff] mt-10 shadow-md w-auto">
            <!-- Title -->
            <h2 class="text-2xl font-semibold text-black dark:text-black mb-6 text-center">
               Total Revenue By Daily
            </h2>

            <!-- Chart Container -->
            <div class="flex w-full h-auto sm:h-auto md:w-3/4 lg:w-2/3 xl:w-1/2">
               <canvas id="revenueDaily" class="w-full h-full"></canvas>
            </div>
         </div>




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

      // Booking Chart
      const labels = <?php echo json_encode($dates); ?>;
      const bookings = <?php echo json_encode($bookings); ?>;

      //chart
      const ctx = document.getElementById('bookingChart').getContext('2d');

      // Create a gradient for the background
      const gradient = ctx.createLinearGradient(0, 0, 0, 400);
      gradient.addColorStop(0, 'rgba(99, 132, 255, 0.2)');
      gradient.addColorStop(1, 'rgba(99, 132, 255, 0.1)');

      const chart = new Chart(ctx, {
         type: 'line',
         data: {
            labels: labels,
            datasets: [{
               label: 'Bookings',
               data: bookings,
               backgroundColor: gradient, // Gradient for background
               borderColor: 'rgb(99, 132, 255)', // Smooth blue border
               borderWidth: 2, // Thicker border for the line
               tension: 0.4, // Smooth curve for the line
               pointBackgroundColor: 'rgb(99, 132, 255)', // Color for points
               pointRadius: 3, // Larger points
               pointHoverRadius: 5, // Larger points on hover
               pointBorderWidth: 2, // Border width for points
            }]
         },
         options: {
            responsive: true,
            maintainAspectRatio: false, // Prevent aspect ratio distortion
            scales: {
               y: {
                  beginAtZero: true,
                  grid: {
                     color: 'rgba(0, 0, 0, 0.1)', // Soft gridlines
                     lineWidth: 1
                  },
                  ticks: {
                     font: {
                        size: 12,
                        family: 'Arial, sans-serif',
                        weight: 'bold',
                        color: '#333'
                     }
                  }
               },
               x: {
                  grid: {
                     color: 'rgba(0, 0, 0, 0.1)', // Soft gridlines
                     lineWidth: 1
                  },
                  ticks: {
                     font: {
                        size: 12,
                        family: 'Arial, sans-serif',
                        weight: 'bold',
                        color: '#333'
                     }
                  }
               }
            },
            plugins: {
               tooltip: {
                  backgroundColor: 'rgba(0, 0, 0, 0.8)', // Dark background for tooltips
                  titleColor: '#fff',
                  bodyColor: '#fff',
                  borderColor: '#99CCFF',
                  borderWidth: 1,
                  callbacks: {
                     label: function(tooltipItem) {
                        return `Bookings: ${tooltipItem.raw}`; // Display bookings count in tooltip
                     }
                  }
               },
               legend: {
                  labels: {
                     font: {
                        size: 10,
                        family: 'Arial, sans-serif',
                        weight: 'bold',
                        color: '#333'
                     },
                     usePointStyle: true,
                  },
                  position: 'top',
               }
            }
         }
      });

      // Active Users Chart
      const users = <?php echo json_encode($users); ?>;
      const bookings1 = <?php echo json_encode($bookings1); ?>;

      const ctx1 = document.getElementById('activeUsersChart').getContext('2d');
      const chart1 = new Chart(ctx1, {
         type: 'bar',
         data: {
            labels: users, // Usernames as labels for the y-axis
            datasets: [{
               label: 'Bookings Count', // Label for the bars
               data: bookings1, // Booking counts as data for the x-axis
               backgroundColor: 'rgba(99, 132, 255, 0.2)', // Bar color
               borderColor: 'rgb(99, 132, 255)', // Bar border color
               borderWidth: 2, // Border width
               barPercentage: 0.5, // Adjust the width of the bars
               categoryPercentage: 0.5 // Adjust the category width
            }]
         },
         options: {
            indexAxis: 'y', // Set to 'y' for horizontal bar chart
            scales: {
               x: {
                  beginAtZero: true // Ensure the x-axis starts at 0
               }
            },
            responsive: true,
            maintainAspectRatio: false, // Allow responsiveness
            plugins: {
               legend: {
                  position: 'top', // Position the legend at the top of the chart
                  labels: {
                     font: {
                        size: 12,
                        family: 'Arial, sans-serif',
                        weight: 'bold',
                        color: '#333' // Font styling for the legend
                     }
                  }
               }
            }
         }
      });

      //most booked flight classes for each flight

      // Pass PHP data to JavaScript
      // Render the donut chart using Chart.js
      const classNames = <?php echo json_encode($classNames); ?>;
      const classBookings = <?php echo json_encode($classBookings); ?>;

      const ctx3 = document.getElementById('flightClassesChart').getContext('2d');
      new Chart(ctx3, {
         type: 'doughnut',
         data: {
            labels: classNames, // Class names as labels
            datasets: [{
               label: 'Bookings Count',
               data: classBookings, // Use raw counts instead of percentages
               backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
            }]
         },
         options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
               tooltip: {
                  callbacks: {
                     label: function(tooltipItem) {
                        return `${tooltipItem.label}: ${tooltipItem.raw} bookings`; // Display count in the tooltip
                     }
                  }
               }
            }
         }
      });

      //most booked trip types for each flight
      // Pass PHP data to JavaScript
      // Render the donut chart using Chart.js
      const tripTypes = <?php echo json_encode($tripTypes); ?>;
      const tripTypeBookings = <?php echo json_encode($tripTypeBookings); ?>;


      const ctx4 = document.getElementById('tripType').getContext('2d');
      new Chart(ctx4, {
         type: 'doughnut',
         data: {
            labels: tripTypes, // Class names as labels
            datasets: [{
               label: 'Bookings Count',
               data: tripTypeBookings, // Use raw counts instead of percentages
               backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
            }]
         },
         options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
               tooltip: {
                  callbacks: {
                     label: function(tooltipItem) {
                        return `${tooltipItem.label}: ${tooltipItem.raw} bookings`; // Display count in the tooltip
                     }
                  }
               }
            }
         }
      });


      // Pass PHP data to JavaScript
      const tripTypeNames = <?php echo json_encode($tripTypeNames); ?>;
      const classNames1 = <?php echo json_encode($classNames1); ?>;
      const revenueData = <?php echo json_encode($revenueData); ?>;

      // Prepare the labels for the X-axis (trip type + class)
      const labels1 = tripTypeNames.map((name, index) => `${name} - ${classNames1[index]}`);

      // Prepare the revenue chart data and labels
      const ctx5 = document.getElementById('revenueChart').getContext('2d');
      new Chart(ctx5, {
         type: 'bar', // Bar chart for total revenue
         data: {
            labels: labels1, // X-axis labels (trip type and class names)
            datasets: [{
               label: 'Total Revenue ($)', // Label for the dataset
               data: revenueData, // Y-axis data (revenue)
               backgroundColor: 'white', // Bar color
               borderColor: '#2D8CE5', // Border color
               borderWidth: 1
            }]
         },
         options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
               y: {
                  beginAtZero: true, // Ensure the Y-axis starts from zero
                  ticks: {
                     stepSize: 1000, // Customize the step size for ticks (revenue)
                     callback: function(value) {
                        return '$' + value;
                     } // Format Y-axis ticks as currency
                  }
               },
               x: {
                  ticks: {
                     autoSkip: true, // Skip ticks for long labels
                     maxRotation: 90, // Rotate labels to avoid overlap
                     minRotation: 45 // Ensure readability of labels
                  }
               }
            },
            plugins: {
               tooltip: {
                  callbacks: {
                     label: function(tooltipItem) {
                        return '$' + tooltipItem.raw.toLocaleString(); // Format the tooltip for revenue
                     }
                  }
               },
               legend: {
                  display: false // Hide the legend for this chart
               }
            }
         }
      });

      // Data from PHP
      const flightNames = <?php echo json_encode($flightNames); ?>;
      const capacities = <?php echo json_encode($capacity); ?>;
      const bookedSeats = <?php echo json_encode($bookedSeats); ?>;
      const availableSeats = <?php echo json_encode($availableSeats); ?>;

      // Create the Chart
      const ctx6 = document.getElementById('bookedSeats').getContext('2d');
      new Chart(ctx6, {
         type: 'bar',
         data: {
            labels: flightNames, // Flight names as labels
            datasets: [{
                  label: 'Capacity',
                  data: capacities,
                  backgroundColor: 'rgba(75, 192, 192, 0.6)', // Light green
                  borderColor: 'rgba(75, 192, 192, 1)',
                  borderWidth: 1,
               },
               {
                  label: 'Booked Seats',
                  data: bookedSeats,
                  backgroundColor: 'red', // Light red
                  borderColor: 'rgba(255, 99, 132, 1)',
                  borderWidth: 1,
               },
               {
                  label: 'Available Seats',
                  data: availableSeats,
                  backgroundColor: 'white', // Light blue
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 1,
               }
            ]
         },
         options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
               legend: {
                  position: 'top',
               }
            },
            scales: {
               x: {
                  stacked: true, // Makes the bars stacked
               },
               y: {
                  beginAtZero: true
               }
            }
         }
      });

      //flight count by each airlines
      const airlineNames = <?php echo json_encode($airlineNames); ?>;
      const flightCounts = <?php echo json_encode($flightCounts); ?>;
      const ctx7 = document.getElementById('airFlight').getContext('2d');

      new Chart(ctx7, {
         type: 'bar', // Horizontal bar chart
         data: {
            labels: airlineNames, // Long labels
            datasets: [{
               label: 'Flight Count',
               data: flightCounts,
               backgroundColor: '#3b82f6',
               borderColor: '#1d4ed8',
               borderWidth: 1
            }]
         },
         options: {
            responsive: true,
            maintainAspectRatio: false, // Ensure the chart resizes dynamically
            indexAxis: 'y', // Horizontal bars
            scales: {
               x: {
                  beginAtZero: true
               },
               y: {
                  ticks: {
                     autoSkip: false, // Show all labels
                     font: {
                        size: 14 // Adjust font size for better visibility
                     },
                     padding: 10, // Add spacing between labels
                     callback: function(value) {
                        return value; // Display full label
                     }
                  }
               }
            },
            layout: {
               padding: {
                  left: 50 // Increase left padding for labels
               }
            },
            plugins: {
               legend: {
                  position: 'top'
               }
            }
         }
      });

      //revenue by daily
      const revdate = <?php echo json_encode($dates1); ?>;
      const revenues = <?php echo json_encode($revenues); ?>;
      const ctx8 = document.getElementById('revenueDaily').getContext('2d');
      

      

   


   </script>
</body>

</html>