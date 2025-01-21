<?php

require_once 'dbconnect.php';

if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['users'])) {
    $user_id = $_SESSION['users']['user_id'];
} else {
    echo "<script>alert('NO user ID selected!!!')</script>";
}

//get selected flight info from book button
if (isset($_SESSION['flight'])) {
    // Retrieve the flight details from the session
    $flight = $_SESSION['flight'];
    $flight_id = $flight['flight_id'];
    $airline_name = $flight['airline_name'];
    $flight_name = $flight['flight_name'];
    $feePerTicket = $flight['fee_per_ticket'];
    $classtypefees = $flight['base_fees'];
    $triptypefees = $flight['priceCharge'];
    $classId = $flight['class_id'];
    $class_name = $flight['class_name'];
    $class_price = $flight['classPrice'];
    $source = $flight['source'];
    $destination = $flight['destination'];
    $gate = $flight['gate'];
    $flight_date = $flight['flight_date'];
    $departure_time = $flight['departure_time'];
    $arrival_time = $flight['arrival_time'];
    $triptypeId = $flight['triptypeId'];
    $triptype_name = $flight['triptype_name'];
} else {
    echo "<script>alert('NO flight selected!!!')</script>";
}

if (isset($_SESSION['selectedSeats'])) {
    $selectedSeats = $_SESSION['selectedSeats'];
    // foreach($selectedSeats as $seatId => $seatNo){
    //     echo $seatNo;
    // }
} else {
    header('Location: showSeats.php');
}

//store the selected data when clicked next button using session
if (isset($_POST['next'])) {
    // Store the selected flight data in the session
    $_SESSION['flight'] = [
        'flight_id' => $_POST['flight_id'],
        'airline_name' => $_POST['airline_name'],
        'flight_name' => $_POST['flight_name'],
        'fee_per_ticket' => $_POST['fee_per_ticket'],
        'base_fees' => $_POST['base_fees'],
        'priceCharge' => $_POST['priceCharge'],
        'class_id' => $_POST['class_id'],
        'class_name' => $_POST['class_name'],
        'classPrice' => $_POST['classPrice'],
        'source' => $_POST['source'],
        'destination' => $_POST['destination'],
        'gate' => $_POST['gate'],
        'flight_date' => $_POST['flight_date'],
        'departure_time' => $_POST['departure_time'],
        'arrival_time' => $_POST['arrival_time'],
        'triptypeId' => $_POST['triptypeId'],
        'triptype_name' => $_POST['triptype_name']
    ];

    $_SESSION['seat_Layout'] = [
        'id' => $_POST['id'],
        'flight_id' => $_POST['flight_id'],
        'class_id' => $_POST['class_id'],
        'seatNo' => $_POST['seatNo']
    ];

    $_SESSION['users'] = [
        'user_id' => $user_id
    ];

    header("Location: passengerBookForm.php");
    exit;
}

try {
    $sql = "SELECT * FROM payment INNER JOIN paymenttype on payment.paymentType = paymenttype.typeID;";
    $stmt = $conn->query($sql);
    $payment = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Information</title>
    <link href="./output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite-datepicker@1.0.0/dist/datepicker.min.js"></script>

</head>

<body>
    
    <!-- nav starts -->
  <nav class="fixed top-0 z-50 w-full bg-[#00103c]">
    <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto p-4">
      <a href="index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
        <!-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" /> -->
        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">SwiftMiles</span>
      </a>

      <div class="flex items-center md:order-2 space-x-1 md:space-x-2 rtl:space-x-reverse">
        <div class="flex items-center">
          <a href="wishlist.php" class="text-white px-4 py-2 rounded-md">
            <div class="flex items-center space-x-4">
              <a href="wishlist.php" class="text-white px-4 py-2 rounded-md"><svg style="color: white" role="img" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" aria-labelledby="favouriteIconTitle">
                  <title id="favouriteIconTitle">Favourite</title>
                  <path d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z" fill="white"></path>
                </svg>
              </a>
            </div>
          </a>
          <!-- <a href="bookingCart.php" class="text-white px-4 py-2 rounded-md">
            <svg width="45" height="45" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="5" y="42" width="26" height="38" rx="2" transform="rotate(-90 5 42)" fill="none" stroke="white" stroke-width="1" stroke-linejoin="round" />
              <path d="M9.00002 16L32 5L37 16" stroke="white" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" />
              <circle cx="13" cy="23" r="2" fill="white" />
              <circle cx="13" cy="29" r="2" fill="white" />
              <circle cx="13" cy="35" r="2" fill="white" />
              <path d="M21 35H25L36 23" stroke="white" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M24 29H30" stroke="white" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </a> -->
        </div>
        <?php
        if (isset($_SESSION['userisLoggedIn'])) {
        ?>
          <div class="flex items-center">
            <div class="flex items-center ms-3">
              <div>
                <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 ml-2" aria-expanded="false" data-dropdown-toggle="dropdown-user" id="dropdownUser">
                  <span class="sr-only">Open user menu</span>
                  <img class="w-10 h-10 rounded-full" src="<?php echo $_SESSION['userPhoto'] ?>" alt="user photo">
                </button>
              </div>

              <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                <div class="px-4 py-3" role="none">
                  <p class="text-sm text-gray-900 dark:text-white" role="none">
                    <?php
                    echo $_SESSION['userEmail'];
                    ?>
                  </p>
                </div>
                <ul class="py-1" role="none">
                  <li>
                    <a href="viewProfile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Your Profile</a>
                  </li>
                  <li>
                    <a href="editUProfile.php?uID=<?php echo $users['user_id'] ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Edit Your Profile</a>
                  </li>
                  <li>
                    <a href="cLogout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Sign out</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        <?php
        } else {
        ?>

          <a href="clogin.php" class="text-white px-4 py-2 rounded-md">Login</a>
          <a href="cSignUp.php" class="text-blue hover:text-white px-4 py-2 rounded-md bg-[#f5effb] hover:bg-[#00103c]">Sign Up</a>
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
            <a href="index.php" class="block py-2 px-3  text-gray-900 border-b border-gray-100 md:w-auto hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700" aria-current="page">Home</a>
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
                    <a href="aboutUs.php" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                      About Us
                    </a>
                  </li>
                  <li>
                    <a href="contactUs.php" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
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

    <!-- slider starts -->
    <div id="default-carousel" class="relative w-full mt-14" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
            <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="/images/ready1.png" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>

                <img src="/images/Let’s (1).png" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="/images/booking.png" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
        </div>
        <!-- Slider controls -->
        <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>
    <!-- slider end -->

    <!-- stepper and booking form -->
    <div id="flightInfoForm" class="block">
        <ol class="flex justify-items-centercenter w-full text-sm text-gray-500 font-medium sm:text-base mb-12 mt-10 px-11">
            <li class="flex md:w-full items-center text-indigo-600  sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-4 xl:after:mx-8 ">
                <div class="flex items-center whitespace-nowrap after:content-['/'] sm:after:hidden after:mx-2 ">
                    <span class="w-6 h-6 bg-indigo-600 border border-indigo-200 rounded-full flex justify-center items-center mr-3 text-sm text-white lg:w-10 lg:h-10">1</span>Flight Information
                </div>
            </li>
            <li class="flex md:w-full items-center text-gray-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-4 xl:after:mx-8 ">
                <div class="flex items-center whitespace-nowrap after:content-['/'] sm:after:hidden after:mx-2 ">
                    <span class="w-6 h-6 bg-gray-100 border border-gray-200 rounded-full flex justify-center items-center mr-3 lg:w-10 lg:h-10">2</span>Personal Information
                </div>
            </li>
            <li class="flex md:w-full items-center text-gray-600 ">
                <div class="flex items-center  ">
                    <span class="w-6 h-6 bg-gray-100 border border-gray-200 rounded-full flex justify-center items-center mr-3 lg:w-10 lg:h-10">3</span> Final
                </div>
            </li>
        </ol>

        <div class="flex flex-col justify-items-center w-3/4 px-11">
            <!-- get slected flight info by book now button from fligh search page -->
            <form action="<?php $_SERVER['REQUEST_URI'] ?>" enctype="multipart/form-data" method="POST" class="w-auto">
                <div class="flex gap-x-6 mb-6">
                    <div class="w-full relative">
                        <input type="hidden" name="flight_id" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" readonly value="
                        <?php
                        if (isset($flight['flight_id'])) {
                            echo $flight['flight_id'];
                        }
                        ?>">
                        <input type="hidden" name="id" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" readonly value="
                        <?php
                        if (isset($seat['id'])) {
                            echo $seat['id'];
                        }
                        ?>">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Airline Name
                        </label>
                        <input type="text" name="airline_name" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" readonly value="<?php
                                                                                                                                                                                                                                                                                                                        if (isset($flight['airline_name'])) {
                                                                                                                                                                                                                                                                                                                            echo $flight['airline_name'];
                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                        ?>">
                    </div>
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Flight Name
                        </label>
                        <input type="text" name="flight_name" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" readonly value="<?php
                                                                                                                                                                                                                                                                                                                    if (isset($flight['flight_name'])) {
                                                                                                                                                                                                                                                                                                                        echo $flight['flight_name'];
                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                    ?>">
                    </div>
                </div>
                <div class="flex gap-x-6 mb-6">
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Class Name
                        </label>
                        <input type="text" name="class_name" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" readonly value="<?php
                                                                                                                                                                                                                                                                                                                    if (isset($flight['class_name'])) {
                                                                                                                                                                                                                                                                                                                        echo $flight['class_name'];
                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                    ?>">
                    </div>
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Trip Type
                        </label>
                        <input type="text" name="triptype_name" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" readonly value="<?php
                                                                                                                                                                                                                                                                                                                        if (isset($flight['triptype_name'])) {
                                                                                                                                                                                                                                                                                                                            echo $flight['triptype_name'];
                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                        ?>">
                    </div>
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Seat No
                        </label>
                        <input type="text" name="seatNo" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" readonly value="<?php

                                                                                                                                                                                                                                                                                                                if (isset($_SESSION['selectedSeats'])) {

            $selectedSeats = $_SESSION['selectedSeats'];
            $seatNumbers = array_map(function($seat) {
                return $seat;
            },
            $selectedSeats);
            echo implode(', ',$seatNumbers);                                                                                                           }
                                                                                                                                                                                                                                                                                                                ?>">
                    </div>
                </div>
                <div class="flex gap-x-6 mb-6">
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Source
                        </label>
                        <input type="text" name="source" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" readonly value="<?php
                                                                                                                                                                                                                                                                                                                if (isset($flight['source'])) {
                                                                                                                                                                                                                                                                                                                    echo $flight['source'];
                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                ?>">
                    </div>
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Gate
                        </label>
                        <input type="text" name="gate" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" readonly value="<?php
                                                                                                                                                                                                                                                                                                                if (isset($flight['gate'])) {
                                                                                                                                                                                                                                                                                                                    echo $flight['gate'];
                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                ?>">
                    </div>
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Destination
                        </label>
                        <input type="text" name="destination" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" readonly value="<?php
                                                                                                                                                                                                                                                                                                                    if (isset($flight['destination'])) {
                                                                                                                                                                                                                                                                                                                        echo $flight['destination'];
                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                    ?>">
                    </div>
                </div>
                <div class="flex gap-x-6 mb-6">
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Price
                        </label>
                        <input type="number" name="classPrice" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" readonly value="<?php
                                                                                                                                                                                                                                                                                                                        if (isset($flight['classPrice'])) {
                                                                                                                                                                                                                                                                                                                            echo $flight['classPrice'];
                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                        ?>">
                    </div>
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Depature Time
                        </label>
                        <input type="time" name="departure_time" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" readonly value="<?php
                                                                                                                                                                                                                                                                                                                        if (isset($flight['departure_time'])) {
                                                                                                                                                                                                                                                                                                                            echo $flight['departure_time'];
                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                        ?>">
                    </div>
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Arrival Time
                        </label>
                        <input type="time" name="arrival_time" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" readonly value="<?php
                                                                                                                                                                                                                                                                                                                        if (isset($flight['arrival_time'])) {
                                                                                                                                                                                                                                                                                                                            echo $flight['arrival_time'];
                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                        ?>">
                    </div>
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Flight Date
                        </label>
                        <input type="date" name="flight_date" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" readonly value="<?php
                                                                                                                                                                                                                                                                                                                    if (isset($flight['flight_date'])) {
                                                                                                                                                                                                                                                                                                                        echo $flight['flight_date'];
                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                    ?>">
                    </div>
                </div>

                <!-- get selected flight info by next button -->
                <form action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" method="POST">
                    <input type='hidden' name='flight_id' value="<?php
                                                                    if (isset($flight['flight_id'])) {
                                                                        echo $flight['flight_id'];
                                                                    }
                                                                    ?>">
                    <input type='hidden' name='airline_name' value="<?php
                                                                    if (isset($flight['airline_name'])) {
                                                                        echo $flight['airline_name'];
                                                                    }
                                                                    ?>">
                    <input type='hidden' name='flight_name' value='"<?php
                                                                    if (isset($flight['flight_name'])) {
                                                                        echo $flight['flight_name'];
                                                                    }
                                                                    ?>"'>
                    <input type='hidden' name='fee_per_ticket' value='"<?php
                                                                        if (isset($flight['fee_per_ticket'])) {
                                                                            echo $flight['fee_per_ticket'];
                                                                        }
                                                                        ?>"'>
                    <input type='hidden' name='class_id' value="<?php
                                                                if (isset($flight['class_id'])) {
                                                                    echo $flight['class_id'];
                                                                }
                                                                ?>">
                    <input type='hidden' name='class_name' value="<?php
                                                                    if (isset($flight['class_name'])) {
                                                                        echo $flight['class_name'];
                                                                    }
                                                                    ?>">
                    <input type='hidden' name='base_fees' value="<?php
                                                                    if (isset($flight['base_fees'])) {
                                                                        echo $flight['base_fees'];
                                                                    }
                                                                    ?>">
                    <input type='hidden' name='priceCharge' value="<?php
                                                                    if (isset($flight['priceCharge'])) {
                                                                        echo $flight['priceCharge'];
                                                                    }
                                                                    ?>">
                    <input type='hidden' name='classPrice' value="<?php
                                                                    if (isset($flight['classPrice'])) {
                                                                        echo $flight['classPrice'];
                                                                    }
                                                                    ?>">
                    <input type='hidden' name='source' value="<?php
                                                                if (isset($flight['source'])) {
                                                                    echo $flight['source'];
                                                                }
                                                                ?>">
                    <input type='hidden' name='flight_date' value="<?php
                                                                    if (isset($flight['flight_date'])) {
                                                                        echo $flight['flight_date'];
                                                                    }
                                                                    ?>">
                    <input type='hidden' name='departure_time' value="<?php
                                                                        if (isset($flight['departure_time'])) {
                                                                            echo $flight['departure_time'];
                                                                        }
                                                                        ?>">
                    <input type='hidden' name='triptypeId' value="<?php
                                                                    if (isset($flight['triptypeId'])) {
                                                                        echo $flight['triptypeId'];
                                                                    }
                                                                    ?>">
                    <input type='hidden' name='triptype_name' value="<?php
                                                                        if (isset($flight['triptype_name'])) {
                                                                            echo $flight['triptype_name'];
                                                                        }
                                                                        ?>">
                    <input type='hidden' name='gate' value="<?php
                                                            if (isset($flight['gate'])) {
                                                                echo $flight['gate'];
                                                            }
                                                            ?>">
                    <input type='hidden' name='destination' value="<?php
                                                                    if (isset($flight['destination'])) {
                                                                        echo $flight['destination'];
                                                                    }
                                                                    ?>">
                    <input type='hidden' name='arrival_time' value="<?php
                                                                    if (isset($flight['arrival_time'])) {
                                                                        echo $flight['arrival_time'];
                                                                    }
                                                                    ?>">
                    <input type='hidden' name='id' value="<?php
                                                            if (isset($seats['id'])) {
                                                                echo $seats['id'];
                                                            }
                                                            ?>">
                    <input type='hidden' name='seatNo' value="<?php
                                                                if (isset($seats['seatNo'])) {
                                                                    echo $seats['seatNo'];
                                                                }
                                                                ?>">
                    <button type="submit" name="next" id="nexttoPersonalInfo" class="w-52 h-12 shadow-sm rounded-lg bg-indigo-600 hover:bg-indigo-800 transition-all duration-700 text-white text-base font-semibold leading-7 mb-10">Next</button>
                </form>

            </form>
        </div>

    </div>
</body>

</html>