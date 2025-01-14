<?php
    require_once "dbconnect.php";
    
    //get all users
    $sql = "SELECT * FROM users";
    try{
      $stmt = $conn->query($sql);
      $status = $stmt->execute();

      if($status){
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
      }


    }catch(PDOException $e){
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

</head>

<body>
   
     <!-- nav stars -->
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
               <a href="admindashboard.php" class="flex items-center p-2 text-gray-900 rounded-lg text-darkBlue hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <span class="ms-3">Dashboard</span>
               </a>
            </li>

            <li>
               <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-blue dark:hover:bg-gray-700" aria-controls="dropdown" data-collapse-toggle="dropdown" id="dropdownButton">
                  <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap dark:text-blue">Flight Information</span>
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                  </svg>
               </button>
               <ul id="dropdownMenu" class="hidden py-2 space-y-2">
                  <li>
                     <a href="viewAirline.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-blue dark:hover:bg-gray-700">Airline</a>
                  </li>
                  <li>
                     <a href="viewFlight.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-blue dark:hover:bg-gray-700">Flight Schedule</a>
                  </li>
                  <li>
                     <a href="viewFlightClasses.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-blue dark:hover:bg-gray-700">Flight Classes & Trip Types</a>
                  </li>
                  <li>
                     <a href="flightClassesandtriptypePrice.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-blue dark:hover:bg-gray-700">Pricing</a>
                  </li>
                  <li>
                     <a href="viewSeats.php" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-blue dark:hover:bg-gray-700">Seat Number</a>
                  </li>
               </ul>
            </li>

            <li>
               <a href="viewBooking.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-blue hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <span class="flex-1 ms-3 whitespace-nowrap">Booking</span>
                  <span class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
                     
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
                  <span class="flex-1 ms-3 whitespace-nowrap ">Tickets</span>
                  <span class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
                     
                  <!-- //count of bookings -->
               
                  </span>
               </a>
            </li>

            <li>
               <a href="viewUsers.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-blue hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
               </a>
            </li>

            <li>
               <a href="viewPayment.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-blue hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <span class="flex-1 ms-3 whitespace-nowrap">Payment</span>
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
                <span class="font-semibold">Users</span>
                
                </p>
            </div>
        </div>
            

            <div class="font-sans overflow-x-auto">
            <table class="min-w-full bg-white">
            <thead class="bg-gray-100 whitespace-nowrap">
                <tr>
                    <th class="p-4 text-left text-base font-semibold text-gray-800">
                    User ID
                    </th>
                    <th class="p-4 text-left text-base font-semibold text-gray-800">
                    Username
                    </th>
                    <th class="p-4 text-left text-base font-semibold text-gray-800">
                    Email
                    </th>
                    <th class="p-4 text-left text-base font-semibold text-gray-800">
                    Profile
                    </th>
                    <th class="p-4 text-left text-base font-semibold text-gray-800">
                    Action
                    </th>
                </tr>
            </thead>

                <tbody class="whitespace-nowrap">
                <?php
               if(isset($users)){
                  foreach($users as $user){
                  echo "<tr class='hover:bg-gray-50'>
                    <td class='p-4 text-[15px] text-gray-800'>
                    $user[user_id]
                    </td>
                    <td class='p-4 text-[15px] text-gray-800'>
                    $user[username]
                    </td>
                    <td class='p-4 text-[15px] text-gray-800'>
                    $user[email]
                    </td>
                    <td class='p-4 text-[15px] text-gray-800'>
                    <img src='$user[profile]' class='w-32 h-24'>
                    </td>
                    <td class='p-4'>
                    <button class='mr-4' title='Edit'>
                    <a href='deleteUsers.php?uid=$user[user_id]'>
                        <svg xmlns='http://www.w3.org/2000/svg' class='w-5 fill-red-500 hover:fill-red-700' viewBox='0 0 24 24'>
                        <path
                            d='M19 7a1 1 0 0 0-1 1v11.191A1.92 1.92 0 0 1 15.99 21H8.01A1.92 1.92 0 0 1 6 19.191V8a1 1 0 0 0-2 0v11.191A3.918 3.918 0 0 0 8.01 23h7.98A3.918 3.918 0 0 0 20 19.191V8a1 1 0 0 0-1-1Zm1-3h-4V2a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v2H4a1 1 0 0 0 0 2h16a1 1 0 0 0 0-2ZM10 4V3h4v1Z'
                            data-original='#000000' />
                        <path d='M11 17v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Zm4 0v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Z'
                            data-original='#000000'/>
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
    </div>
    <!-- end airline information -->

    <!-- script for dropdown menu -->
    <script>
    const dropdownButton = document.getElementById('dropdownButton');
    const dropdownMenu = document.getElementById('dropdownMenu');

    dropdownButton.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });

    </script>

</body>
    
 