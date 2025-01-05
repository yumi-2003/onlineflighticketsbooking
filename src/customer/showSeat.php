<?php
    require_once 'dbconnect.php';

    if(!isset($_SESSION)){
        session_start();
    }

    //get the selected seat No
    if(isset($_POST['select'])){
        $_SESSION['seat_layout'] = [
            'id' => $_POST['id'],
            'flight_id' =>$_POST['flight_id'],
            'class_id' => $_POST['class_id'],
            'seatNo' => $_POST['seatNo']
        ];

        header('Location: booking.php');
        exit();
    }

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
        echo "<script>alert('NO flight selected!!!')</script>";
    }

  
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Selection</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
        <!-- nav starts -->
        <nav class= "fixed top-0 z-50 w-full bg-[#0463ca]">
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


    <div class="flex justify-center items-center  font-[sans-serif] h-full md:min-h-screen p-4 my-3 grid grid-cols-3 gap-4">
    <div class="p-4 gap-2 mt-16 mx-auto bg-cyan-200 col-span-2 border-2 rounded-lg">
        <h1>Select Your Seat</h1>
                <?php
                    $flight_id = $flight['flight_id'] ?? '';
                    $airline_name = $flight['airline_name'] ?? '';
                    $flight_name = $flight['flight_name'] ?? '';
                    $class_name = $flight['class_name'] ?? '';
                    $class_price = $flight['classPrice'] ?? '';
                    $source = $flight['source'];
                    $destination = $flight['destination'] ?? '';
                    $gate = $flight['gate'] ?? '';
                    $flight_date = $flight['flight_date'] ?? '';
                    $departure_time = $flight['departure_time'] ?? '';
                    $arrival_time = $flight['arrival_time'] ?? '';
                    $triptype_name = $flight['triptype_name'] ?? '';
                    $sql = "SELECT * FROM seat_layout WHERE flight_ID = :flightID";

                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':flightID', $flightID);
                    $stmt->execute();
                    $seats = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $row = 1;
                    $col = 1;
                    echo "<form action='booking.php' method='POST' class='seat-container w-full inline-block' enctype='multipart/form-data'>";

                    foreach ($seats as $seat) {
                        if ($col > 10) {
                            $col = 1;
                            $row++;
                            echo "<br>";
                        }
                        if ($col == 6){
                            echo "<span>aisle</span>";
                        }
                        if ($row > 15) {
                            break;
                        }
                        if ($seat['status'] == 1) {
                            echo "
                            
                            <button type='submit' name='select' class='focus:outline-none text-white bg-green-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 w-16 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800'>{$seat['seatNo']}
                            </button>
                            
                            ";
                        } else{
                            echo "
                            <button type='submit' name='select' class='focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 w-16 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800'>{$seat['seatNo']}
                            </button>
                            
                            ";
                        }
                        $col++;
                    }
                    echo "
                                <input type='hidden' name='id' value='{$seat['id']}'>
                                <input type='hidden' name='flight_id' value='{$seat['flight_id']}'>
                                <input type='hidden' name='class_id' value='{$seat['class_id']}'>
                                <input type='hidden' name='seatNo' value='{$seat['seatNo']}'>
                            </form>";
                    
                ?>
            
    </div>
    <div class="gap-4 w-full h-60 mx-auto my-0 col-span-1 bg-cyan-100 border-b rounded-lg">
        <div class="">booked</div>
        <div class="">Available</div>
    </div>
    </div>
</body>
</html>
