<?php

require_once "dbconnect.php";

if (!isset($_SESSION)) {
   session_start();
}

if (!isset($_SESSION['isLoggedIn'])) {
   header('Location: adminLogin.php');
}

try {
   $sql = "select * from paymenttype";
   $stmt = $conn->query($sql);
   $paymenttype = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
   echo $e->getMessage();
}

$sql = "SELECT * FROM payment
        JOIN paymenttype
        ON payment.paymentType = paymenttype.typeID";

try {
   $stmt = $conn->query($sql);
   $status = $stmt->execute();

   if ($status) {
      $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
   }
} catch (PDOException $e) {
   echo $e->getMessage();
}

$sql = "SELECT * FROM admin";
try {
   $stmt = $conn->prepare($sql);
   $stmt->execute();
   $admin = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
   echo $e->getMessage();
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

</head>

<body class="bg-[#f2f1ef]">

   <!-- nav starts -->
   <nav class="fixed top-0 z-50 w-full bg-[#00103c]">
      <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto p-4">
         <a href="" class="flex items-center space-x-3 rtl:space-x-reverse">
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
   <div class="p-4 sm:ml-64 mt-24">
      <div class="grid-cols-2">
         <div>
            <p>
               <span class="font-semibold text-base">Transaction</span>
            </p>
         </div>
      </div>

      <div class="font-sans overflow-x-auto">

         <table class="min-w-full bg-white">
            <thead class="bg-gray-100 whitespace-nowrap">
               <tr>
                  <th class="p-4 text-center text-base font-sans text-gray-800">
                     Transaction ID
                  </th>
                  <th class="p-4 text-center text-base ffont-sans text-gray-800">
                     Payment Date
                  </th>
                  <th class="p-4 text-center text-base font-sans text-gray-800">
                     Card Holder Name
                  </th>
                  <th class="p-4 text-center text-base font-sans text-gray-800">
                     Card Number
                  </th>
                  <th class="p-4 text-center text-base font-sans text-gray-800">
                     Security Code
                  </th>
                  <th class="p-4 text-center text-base font-sans text-gray-800">
                     Expiry Date
                  </th>
                  <th class="p-4 text-center text-base font-sans text-gray-800">
                     Payment Amount
                  </th>
                  <th class="p-4 text-center text-base font-sans text-gray-800">
                     Payment Type
                  </th>
                  <th class="p-4 text-center text-base font-sans text-gray-800">
                     Action
                  </th>
               </tr>
            </thead>

            <tbody class="whitespace-nowrap">
               <?php
               if (isset($payments)) {
                  foreach ($payments as $payment) {
                     echo "<tr class='hover:bg-gray-50'>
                    <td class='p-4 text-m text-gray-800'>
                        $payment[paymentID]
                    </td>
                    <td class='p-4 text-sm text-gray-800'>
                        $payment[paymentDate]
                    </td>
                    <td class='p-4 text-sm text-gray-800'>
                        $payment[name]
                    </td>
                    <td class='p-4 text-sm text-gray-800'>
                        $payment[cardNo]
                    </td>
                    <td class='p-4 text-sm text-gray-800'>
                        $payment[securityCode]
                    </td>
                    <td class='p-4 text-sm text-gray-800'>
                        $payment[expireDate]
                    </td>
                    <td class='p-4 text-sm text-gray-800'>
                        $payment[totalPrice]
                    </td>
                    <td class='p-4 text-sm text-gray-800'>
                        $payment[paymentName]
                    </td>
                    <td class='p-4'>
                    <button class='mr-4' title='Delete'>
                    <a href='deletePayment.php?pid=$payment[paymentID]'>
                        <svg xmlns='http://www.w3.org/2000/svg' class='w-5 fill-red-500 hover:fill-red-700' viewBox='0 0 24 24'>
                        <path
                            d='M19 7a1 1 0 0 0-1 1v11.191A1.92 1.92 0 0 1 15.99 21H8.01A1.92 1.92 0 0 1 6 19.191V8a1 1 0 0 0-2 0v11.191A3.918 3.918 0 0 0 8.01 23h7.98A3.918 3.918 0 0 0 20 19.191V8a1 1 0 0 0-1-1Zm1-3h-4V2a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v2H4a1 1 0 0 0 0 2h16a1 1 0 0 0 0-2ZM10 4V3h4v1Z'
                            data-original='#000000' />
                        <path d='M11 17v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Zm4 0v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Z'
                            data-original='#000000' />
                        </svg>
                    </a>
                    </button>
                    </td>
                </tr>";
                  }
               }
               ?>
            </tbody>
         </table>
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