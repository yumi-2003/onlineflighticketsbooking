<?php

    require_once 'dbconnect.php';

    if(!isset($_SESSION)){
      session_start();
    }

    //get selected flight info from book button
    if (isset($_SESSION['flight'])) {
        // Retrieve the flight details from the session
        $flight = $_SESSION['flight'];
        $flight_id = $flight['flight_id'];
        $airline_name = $flight['airline_name'];
        $flight_name = $flight['flight_name'];
        $class_name = $flight['class_name'];
        $class_price = $flight['classPrice'];
        $source = $flight['source'];
        $destination = $flight['destination'];
        $gate = $flight['gate'];
        $flight_date = $flight['flight_date'];
        $departure_time = $flight['departure_time'];
        $arrival_time = $flight['arrival_time'];
        $triptype_name = $flight['triptype_name'];

        // Now, you can use these values to populate your booking form
    } else {
        echo "<script>window.alerts('NO flight selected!!!')</script>";
    }

    //store the selected data when clicked next button using session
    if (isset($_POST['next'])) {
        // Store the selected flight data in the session
        $_SESSION['flight'] = [
            'flight_id' => $_POST['flight_id'],
            'airline_name' => $_POST['airline_name'],
            'flight_name' => $_POST['flight_name'],
            'class_name' => $_POST['class_name'],
            'classPrice' => $_POST['classPrice'],
            'source' => $_POST['source'],
            'destination' => $_POST['destination'],
            'gate' => $_POST['gate'],
            'flight_date' => $_POST['flight_date'],
            'departure_time' => $_POST['departure_time'],
            'arrival_time' => $_POST['arrival_time'],
            'triptype_name' => $_POST['triptype_name']
        ];

        // Redirect to the booking page
        header("Location: booking.php");
        exit;
    }

    //store personal information
    try{
        $sql = "SELECT * FROM passengers";
        $stmt =$conn->query($sql);
        $personInfos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }catch(PDOException $e){
        echo $e->getMessage();
    }

    if(isset($_POST['savePersonalInfo'])){
        $fName = $_POST['fullName'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $nationality = $_POST['nationality'];
        $phoneNo = $_POST['phoneNo'];
        $idCard = $_POST['IDcard'];
        $passport = $_POST['passportNo'];

        try{
            $sql = "INSERT INTO passengers (fullName,age,gender,nationality,phoneNo,IDcard,passportNo) VALUES (?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute([$fName,$age,$gender,$nationality,$phoneNo,$idCard,$passport]);
            $passenger = $conn->lastInsertId();

            if($status){
                $_SESSION['completedPersonalInformation'] = "You Completed your personal information";
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
    <title>Booking</title>
    <link href="./output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite-datepicker@1.0.0/dist/datepicker.min.js"></script>
    
</head>
<body>
        <!-- nav starts -->
        <nav class= "fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto p-4">
                <a href="https://flowbite.com" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <!-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" /> -->
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">SwiftMiles</span>
                </a>

                <div class="flex items-center md:order-2 space-x-1 md:space-x-2 rtl:space-x-reverse">

                    <?php

                      if(isset($_SESSION['userisLoggedIn'])){
                    ?>

                    <div class="flex items-center">
                        <div class="flex items-center ms-3">
                          <div>
                              <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user" id="dropdownUser">
                                <span class="sr-only">Open user menu</span>


                                <img class="w-8 h-8 rounded-full" src="<?php echo $_SESSION['userPhoto'] ?>" alt="user photo">

                              </button>
                          </div>

                          <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                          <div class="px-4 py-3" role="none">
                              <p class="text-sm text-gray-900 dark:text-white" role="none">
                                <?php
                                    echo $_SESSION['userEmail'];
                                ?>
                              </p>
                              <!-- <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                              </p> -->
                          </div>
                          <ul class="py-1" role="none">
                              <li>
                                <a href="editUProfile.php?uID=$users[]" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Edit Your Profile</a>
                              </li>
                              <li>
                                <a href="cLogout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Sign out</a>
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
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
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
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
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
                                                Library
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                                                Resources
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                                                Pro Version
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="p-4 pb-0 text-gray-900 md:pb-4 dark:text-white">
                                    <ul class="space-y-4">
                                        <li>
                                            <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                                                Blog
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                                                Newsletter
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                                                Playground
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                                                License
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="p-4">
                                    <ul class="space-y-4">
                                        <li>
                                            <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                                                Contact Us
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                                                Support Center
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                                                Terms
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
        <div id="default-carousel" class="relative w-full mt-16" data-carousel="slide">
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
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
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
                        <input type="hidden" name="airline_name" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" required="" value="
                        <?php
                        if(isset($flight['flight_id'])){
                            echo $flight['flight_id'];
                        }
                        ?>">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Airline Name
                        </label>
                        <input type="text" name="airline_name" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" required="" value="<?php
                        if(isset($flight['airline_name'])){
                            echo $flight['airline_name'];
                        }
                        ?>">
                    </div>
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Flight Name
                        </label>
                        <input type="text" name="flight_name" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" required="" value="<?php
                        if(isset($flight['flight_name'])){
                            echo $flight['flight_name'];
                        }
                        ?>" >
                    </div>
                </div>
                <div class="flex gap-x-6 mb-6">
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Class Name
                        </label>
                        <input type="text" name="class_name" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" required="" value="<?php
                        if(isset($flight['class_name'])){
                            echo $flight['class_name'];
                        }
                        ?>">
                    </div>
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Trip Type
                        </label>
                        <input type="text" name="triptype_name" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" required="" value="<?php
                        if(isset($flight['triptype_name'])){
                            echo $flight['triptype_name'];
                        }
                        ?>">
                    </div>
                </div>
                <div class="flex gap-x-6 mb-6">
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Source
                        </label>
                        <input type="text" name="source" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" required="" value="<?php
                        if(isset($flight['source'])){
                            echo $flight['source'];
                        }
                        ?>">
                    </div>
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Gate
                        </label>
                        <input type="text" name="gate" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" required="" value="<?php
                        if(isset($flight['gate'])){
                            echo $flight['gate'];
                        }
                        ?>">
                    </div>
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Destination
                        </label>
                        <input type="text" name="destination" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" required="" value="<?php
                        if(isset($flight['destination'])){
                            echo $flight['destination'];
                        }
                        ?>">
                    </div>
                </div>
                <div class="flex gap-x-6 mb-6">
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Price
                        </label>
                        <input type="number" name="classPrice" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" required="" value="<?php
                        if(isset($flight['classPrice'])){
                            echo $flight['classPrice'];
                        }
                        ?>">
                    </div>
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Depature  Time
                        </label>
                        <input type="time" name="departure_time" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" required="" value="<?php
                        if(isset($flight['departure_time'])){
                            echo $flight['departure_time'];
                        }
                        ?>">
                    </div>
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Arrival Time
                        </label>
                        <input type="time" name="arrival_time" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" required="" value="<?php
                        if(isset($flight['arrival_time'])){
                            echo $flight['arrival_time'];
                        }
                        ?>">
                    </div>
                    <div class="w-full relative">
                        <label class="flex  items-center mb-2 text-gray-600 text-sm font-medium">Flight Date
                        </label>
                        <input type="date" name="flight_date" id="default-search" class="block w-full h-11 px-5 py-2.5 bg-white leading-7 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-full placeholder-gray-400 focus:outline-none " placeholder="" required="" value="<?php
                        if(isset($flight['flight_date'])){
                            echo $flight['flight_date'];
                        }
                        ?>">
                    </div>
                </div>
                
                    <!-- get selected flight info by next button -->
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" method="POST">
                        <input type='hidden' name='flight_id' value ="<?php
                            if(isset($flight['flight_id'])){
                                echo $flight['flight_id'];
                            }
                            ?>">
                        <input type='hidden' name='airline_name' value ="<?php
                            if(isset($flight['airline_name'])){
                                echo $flight['airline_name'];
                            }
                            ?>">
                        <input type='hidden' name='flight_name' value ='"<?php
                            if(isset($flight['flight_name'])){
                                echo $flight['flight_name'];
                            }
                            ?>"'>
                        <input type='hidden' name='class_name' value="<?php
                            if(isset($flight['class_name'])){
                                echo $flight['class_name'];
                            }
                            ?>">
                        <input type='hidden' name='classPrice' value="<?php
                            if(isset($flight['classPrice'])){
                                echo $flight['classPrice'];
                            }
                            ?>">
                        <input type='hidden' name='source'  value="<?php
                            if(isset($flight['source'])){
                                echo $flight['source'];
                            }
                            ?>">
                        <input type='hidden' name='flight_date' value="<?php
                            if(isset($flight['flight_date'])){
                                echo $flight['flight_date'];
                            }
                            ?>">
                        <input type='hidden' name='departure_time' value="<?php
                            if(isset($flight['departure_time'])){
                                echo $flight['departure_time'];
                            }
                            ?>">
                        <input type='hidden' name='triptype_name' value="<?php
                            if(isset($flight['triptype_name'])){
                                echo $flight['triptype_name'];
                            }
                            ?>">
                        <input type='hidden' name='gate'  value="<?php
                            if(isset($flight['gate'])){
                                echo $flight['gate'];
                            }
                            ?>">
                        <input type='hidden' name='destination' value="<?php
                            if(isset($flight['destination'])){
                                echo $flight['destination'];
                            }
                            ?>">
                        <input type='hidden' name='arrival_time' value="<?php
                            if(isset($flight['arrival_time'])){
                                echo $flight['arrival_time'];
                            }
                            ?>">
                    <button type="submit" name="next" id="nexttoPersonalInfo" class="w-52 h-12 shadow-sm rounded-lg bg-indigo-600 hover:bg-indigo-800 transition-all duration-700 text-white text-base font-semibold leading-7 mb-10">Next</button>
                    </form>
                
                </form>
            </div>

         </div>

        <div id="personalInfoForm" class="block">
            <ol class="flex justify-items-center w-full text-sm text-gray-500 font-medium sm:text-base mb-12 mt-10 px-11">
                <!-- Step 1: Flight Information -->
                <li class="flex md:w-full items-center text-gray-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-4 xl:after:mx-8">
                    <div class="flex items-center whitespace-nowrap after:content-['/'] sm:after:hidden after:mx-2">
                        <span class="w-6 h-6 bg-indigo-600 border border-indigo-200 rounded-full flex justify-center items-center mr-3 text-sm text-white lg:w-10 lg:h-10">1</span>Flight Information
                    </div>
                </li>

                <!-- Step 2: Personal Information (Active Step) -->
                <li class="flex md:w-full items-center text-indigo-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-4 xl:after:mx-8">
                    <div class="flex items-center whitespace-nowrap after:content-['/'] sm:after:hidden after:mx-2">
                        <span class="w-6 h-6 bg-indigo-600 border border-indigo-200 rounded-full flex justify-center items-center mr-3 text-sm text-white lg:w-10 lg:h-10">2</span>Personal Information
                    </div>
                </li>

                <!-- Step 3: Final -->
                <li class="flex md:w-full items-center text-gray-600">
                    <div class="flex items-center">
                        <span class="w-6 h-6 bg-gray-100 border border-gray-200 rounded-full flex justify-center items-center mr-3 lg:w-10 lg:h-10">3</span> Final
                    </div>
                </li>
            </ol>
            <p>
            <?php
            if(isset($_SESSION['completedPersonalInformation'])){
               echo "<div class='p-4 mb-4 text-sm text-black rounded-lg bg-green-50 dark:bg-cyan-50                  dark:text-green-400' role='alert'>
                        <span class='font-medium'>$_SESSION[completedPersonalInformation]</span>
                     </div>
                     ";
               unset($_SESSION['completedPersonalInformation']);
            }
            ?>
         </p>
            <div class="flex flex-col justify-items-center w-3/4 px-11 md:grid-cols-2 items-center gap-8 h-full">

                <form class="space-y-6 px-4 max-w-sm mx-auto font-[sans-serif]" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" method="POST">
                    <div class="flex items-center">
                        <label class="text-gray-400 w-36 text-sm">Full Name</label>
                        <input type="text" name="fullName" placeholder="Enter your name"
                        class="px-2 py-2 w-full border-b-2 focus:border-[#333] outline-none text-sm bg-white" />
                    </div>

                    <div class="flex items-center">
                        <label class="text-gray-400 w-36 text-sm">Age</label>
                        <input type="number" name="age" placeholder="Enter your email"
                        class="px-2 py-2 w-full border-b-2 focus:border-[#333] outline-none text-sm bg-white" />
                    </div>

                    <div class="flex items-center">
                        <label class="text-gray-400 w-36 text-sm">Gender</label>
                        <input type="text" name="gender" placeholder="Enter your phone no"
                        class="px-2 py-2 w-full border-b-2 focus:border-[#333] outline-none text-sm bg-white" />
                    </div>

                    <div class="flex items-center">
                        <label class="text-gray-400 w-36 text-sm">Nationality</label>
                        <input type="text" name="nationality" placeholder="Enter your state"
                        class="px-2 py-2 w-full border-b-2 focus:border-[#333] outline-none text-sm bg-white" />
                    </div>

                    
                    <div class="flex items-center">
                        <label class="text-gray-400 w-36 text-sm">Phone NO.</label>
                        <input type="number" name="phoneNo" placeholder="Enter your state"
                        class="px-2 py-2 w-full border-b-2 focus:border-[#333] outline-none text-sm bg-white" />
                    </div>

                    <div class="flex items-center">
                        <label class="text-gray-400 w-36 text-sm">ID Card NO.</label>
                        <input type="text" name="IDcard" placeholder="Enter your state"
                        class="px-2 py-2 w-full border-b-2 focus:border-[#333] outline-none text-sm bg-white" />
                    </div>

                    <div class="flex items-center">
                        <label class="text-gray-400 w-36 text-sm">PassPort No.</label>
                        <input type="text" name="passportNo" placeholder="Enter your state"
                        class="px-2 py-2 w-full border-b-2 focus:border-[#333] outline-none text-sm bg-white" />
                    </div>

                    <button type="submit" name="savePersonalInfo"
                    class="!mt-8 px-6 py-2 w-full bg-[#233d9a] hover:bg-[#444] text-sm text-white mx-auto block">Submit</button>
                </form>
                
            </div>
        </div>

        <div id="paymentForm" class="block">
            <ol class="flex justify-items-center w-full text-sm text-gray-500 font-medium sm:text-base mb-12 mt-10 px-11">
                <!-- Step 1: Flight Information -->
                <li class="flex md:w-full items-center text-gray-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-4 xl:after:mx-8">
                    <div class="flex items-center whitespace-nowrap after:content-['/'] sm:after:hidden after:mx-2">
                        <span class="w-6 h-6 bg-indigo-600 border border-indigo-200 rounded-full flex justify-center items-center mr-3 text-sm text-white lg:w-10 lg:h-10">1</span>Flight Information
                    </div>
                </li>

                <!-- Step 2: Personal Information-->
                <li class="flex md:w-full items-center text-gray-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-4 xl:after:mx-8">
                    <div class="flex items-center whitespace-nowrap after:content-['/'] sm:after:hidden after:mx-2">
                        <span class="w-6 h-6 bg-indigo-600 border border-indigo-200 rounded-full flex justify-center items-center mr-3 text-sm text-white lg:w-10 lg:h-10">2</span>Personal Information
                    </div>
                </li>

                <!-- Step 3: Final  (Active Step)  -->
                <li class="flex md:w-full items-center text-indigo-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-4 xl:after:mx-8">
                    <div class="flex items-center whitespace-nowrap after:content-['/'] sm:after:hidden after:mx-2">
                        <span class="w-6 h-6 bg-indigo-600 border border-indigo-200 rounded-full flex justify-center items-center mr-3 text-sm text-white lg:w-10 lg:h-10">3</span>Payment
                    </div>
                </li>
            </ol>
            <p>
            <?php
            if(isset($_SESSION['completedPersonalInformation'])){
               echo "<div class='p-4 mb-4 text-sm text-black rounded-lg bg-green-50 dark:bg-cyan-50                  dark:text-green-400' role='alert'>
                        <span class='font-medium'>$_SESSION[completedPersonalInformation]</span>
                     </div>
                     ";
               unset($_SESSION['completedPersonalInformation']);
            }
            ?>
         </p>

            <div class="font-[sans-serif] bg-white p-4">
                <div class="font-[sans-serif] lg:flex lg:items-center lg:justify-center lg:h-screen max-lg:py-4">
                    <div class="bg-purple-100 p-8 w-full max-w-5xl max-lg:max-w-xl mx-auto rounded-md">
                        <h2 class="text-3xl font-extrabold text-gray-800 text-center">Checkout</h2>

                        <div class="grid lg:grid-cols-3 gap-6 max-lg:gap-8 mt-16">
                        <div class="lg:col-span-2">
                            <h3 class="text-lg font-bold text-gray-800">Choose your payment method</h3>

                            <div class="grid gap-4 sm:grid-cols-2 mt-4">
                            <div class="flex items-center">
                                <input type="radio" class="w-5 h-5 cursor-pointer" id="card" checked />
                                <label for="card" class="ml-4 flex gap-2 cursor-pointer">
                                <img src="https://readymadeui.com/images/visa.webp" class="w-12" alt="card1" />
                                <img src="https://readymadeui.com/images/american-express.webp" class="w-12" alt="card2" />
                                <img src="https://readymadeui.com/images/master.webp" class="w-12" alt="card3" />
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="radio" class="w-5 h-5 cursor-pointer" id="paypal" />
                                <label for="paypal" class="ml-4 flex gap-2 cursor-pointer">
                                <img src="https://readymadeui.com/images/paypal.webp" class="w-20" alt="paypalCard" />
                                </label>
                            </div>
                            </div>

                            <form class="mt-8">
                            <div class="grid sm:col-span-2 sm:grid-cols-2 gap-4">
                                <div>
                                <input type="text" placeholder="Name of card holder"
                                    class="px-4 py-3.5 bg-white text-gray-800 w-full text-sm border rounded-md focus:border-[#007bff] outline-none" />
                                </div>
                                <div>
                                <input type="number" placeholder="Postal code"
                                    class="px-4 py-3.5 bg-white text-gray-800 w-full text-sm border rounded-md focus:border-[#007bff] outline-none" />
                                </div>
                                <div>
                                <input type="number" placeholder="Card number"
                                    class="col-span-full px-4 py-3.5 bg-white text-gray-800 w-full text-sm border rounded-md focus:border-[#007bff] outline-none" />
                                </div>
                                <div>
                                <input type="number" placeholder="EXP."
                                    class="px-4 py-3.5 bg-white text-gray-800 w-full text-sm border rounded-md focus:border-[#007bff] outline-none" />
                                </div>
                                <div>
                                <input type="number" placeholder="CVV"
                                    class="px-4 py-3.5 bg-white text-gray-800 w-full text-sm border rounded-md focus:border-[#007bff] outline-none" />
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-4 mt-8">
                                <button type="button"
                                class="px-7 py-3.5 text-sm tracking-wide bg-white hover:bg-gray-50 text-gray-800 rounded-md">Pay later</button>
                                <button type="button"
                                class="px-7 py-3.5 text-sm tracking-wide bg-blue-600 text-white rounded-md hover:bg-blue-700">Submit</button>
                            </div>
                            </form>
                        </div>

                        <div class="bg-white p-6 rounded-md max-lg:-order-1">
                            <h3 class="text-lg font-bold text-gray-800">Summary</h3>
                            <ul class="text-gray-800 mt-6 space-y-3">
                            <li class="flex flex-wrap gap-4 text-sm">Sub total <span class="ml-auto font-bold">$48.00</span></li>
                            <li class="flex flex-wrap gap-4 text-sm">Discount (20%) <span class="ml-auto font-bold">$4.00</span></li>
                            <li class="flex flex-wrap gap-4 text-sm">Tax <span class="ml-auto font-bold">$4.00</span></li>
                            <hr />
                            <li class="flex flex-wrap gap-4 text-base font-bold">Total <span class="ml-auto">$52.00</span></li>
                            </ul>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- show and hide flightInfo form and personal form -->
        <script>
            document.getElementById("nexttoPersonalInfo").addEventListener("click", function () {
            document.getElementById("flightInfoForm").classList.toggle("hidden");
            document.getElementById("flightInfoForm").classList.toggle("block");

            document.getElementById("personalInfoForm").classList.toggle("hidden");
            document.getElementById("personalInfoForm").classList.toggle("block");
        });
        </script>
        
</body>
</html>