<?php

    require_once "dbconnect.php";

    if(!isset($_SESSION)){
        session_start();
    }

    //get flight information
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
            flight.seats_researved, 
            flight.seats_available,
            flight.gate,
            flight.placeImg
            
        FROM 
            flight
        INNER JOIN 
            airline
        ON 
            flight.airline_id = airline.airline_id;";

        try{
            $stmt = $conn->query($sql);
            $status = $stmt->execute();

            if($status){
            $flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }catch(PDOException $e){
        echo $e->getMessage();
        }

        //search by source, destin, flight date
        if(isset($_POST['find'])){
        $source = $_POST['source'];
        $desti = $_POST['destination'];
        $date = $_POST['flight_date'];

        try{
        $sql = "SELECT * FROM flight INNER JOIN 
            airline
        ON 
            flight.airline_id = airline.airline_id where  source = ? AND destination = ? AND flight_date=?";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1,$source,PDO::PARAM_STR);
        $stmt->bindParam(2,$desti,PDO::PARAM_STR);
        $stmt->bindParam(3,$date,PDO::PARAM_STR);
        $stmt->execute();
        $flights = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }catch(PDOException $e){
        echo $e->getMessage();
        }
        }

        try{
            $sql = "SELECT * FROM users";
            $stmt = $conn->prepare($sql);
            $users= $stmt->fetchAll(PDO::FETCH_ASSOC);
         }catch(PDOException $e){
            echo $e->getMessage();
         }

         //get classes and flight base fees information

        if(isset($_POST['classPrice']) && $_SERVER['REQUEST_METHOD']){
            $classTypes = $_POST['classPrice']; //get user selected class types

            $sql = "SELECT 
            b.booking_id, 
            b.user_id, 
            b.flight_id, 
            f.fee_per_ticket, 
            c.base_fees, 
            (f.fee_per_ticket * c.base_fees) AS classsPrice, 
            b.tax, 
            ((f.fee_per_ticket * c.base_fees) + b.tax) AS total_price
            FROM 
            booking b
            JOIN 
            flight f ON b.flight_id = f.flight_id
            JOIN 
            classes c ON b.class_id = c.class_id
            WHERE 
            c.class_id = ?";

            //prepare the statment
            $stmt = $conn->prepare($sql);
            //bind the paramenter
            $stmt->bindParam(1, $classTypes, PDO::PARAM_INT);
            //execute the statment
            $stmt->execute();
        }

        //get all infromation connecting to booking
        $sql = "SELECT f.flight_name, 
            f.flight_date, 
            f.destination, 
            f.source, 
            f.total_distance, 
            f.fee_per_ticket, 
            f.departure_time, 
            f.arrival_time, 
            f.capacity, 
            f.gate, 
            b.tax, 
            (f.fee_per_ticket + b.tax) AS total_price
            FROM flight f 
            JOIN booking b ON f.flight_id = b.flight_id";

        try{
            $stmt = $conn->prepare($sql);
            $status =$stmt->execute();

            if($status){
                $bflights = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }


        }catch(PDOException $e){
            echo $e->getMessage();
        }

        


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Flgiht Information Search</title>
        <link href="./output.css" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flowbite-datepicker@1.0.0/dist/datepicker.min.js"></script>
    </head>
    <body>
         <!-- nav starts -->
         <nav class= " bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 ">
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
                                <a href="editUProfile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Edit Your Profile</a>
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
                
         <div class=" font-[sans-serif] p-6 sticky top-0" style="background-image: url('/images/cloud.webp'); background-size: cover;">
            <div class="grid md:grid-cols-1 items-center gap-10 max-w-5xl max-md:max-w-md mx-auto">
                <div class="text-center">
                    <form action="" method="POST" class="space-y-4">
                      <div>
                        <h1 class="text-4xl font-extrabold text-white">Welcome to SwiftMiles</h1>
                      </div>

                      <div>
                        <p class="text-white text-lg mt-4 leading-relaxed">Affordable Flights, Unforgettable Journeys </p>
                      </div>

                      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mt-4">
                        <select id="source" name="source" class="h-12 border border-gray-300 text-gray-600 text-base rounded-lg block w-full py-2.5 px-4 focus:outline-none">
                            <option selected>From: City</option>
                            <?php
                              $uniqueSources = array_unique(array_column($flights, 'source'));
                              foreach($uniqueSources as $source){
                                echo "<option value='$source'>$source</option>";
                              }
                            ?>
                        </select>

                        <select id="destination" name="destination" class="h-12 border border-gray-300 text-gray-600 text-base rounded-lg block w-full py-2.5 px-4 focus:outline-none">
                            <option selected>To: City</option>
                            <?php
                              $uniqueDestin = array_unique(array_column($flights, 'destination'));
                              foreach($uniqueDestin as $destin){
                                echo "<option value='$destin'>$destin</option>";
                              }
                            ?>
                        </select>
                        <input type="date" name="flight_date" class="w-full p-2 rounded-md" id="depDate" name='flight_date' placeholder="Departure Date" /> 
                        <!-- <input type="date" class="w-full p-2 rounded-md" id="retDate" placeholder="Return Date" /> -->
                        <button name="find" class="w-full p-2 text-white bg-blue-600 rounded-md col-span-full lg:col-span-1">Explore</button>
                      </div>
                    </form>

                </div>
            </div>
        </div>


        <!-- main contents starts -->
        <div class="p-1 grid grid-cols-5">
            <div class="col-span-1">
                <div class="flex justify-start h-full rounded-lg text-white">
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" class="p-3" id="classPriceSearch">
                        <label for="">Choose Flight Classes</label>
                        <div class="grid space-y-3 pt-3">
                            <label for="hs-vertical-radio-in-form" class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <input type="radio" name="classPrice" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="first-class" value="1" onchange="this.form.submit();">
                                <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Frist</span>
                            </label>

                            <label for="hs-vertical-radio-in-form" class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <input type="radio" name="classPrice" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="business-class" value="2" onchange="this.form.submit();" >
                                <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Business</span>
                            </label>

                            <label for="hs-vertical-radio-in-form" class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <input type="radio" name="classPrice" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="economy-class" value="3" onchange="this.form.submit();">
                                <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Economy</span>
                            </label>

                            <label for="hs-vertical-radio-checked-in-form" class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <input type="radio" name="classPrice" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="primaryeco-class" value="4" onchange="this.form.submit();">
                                <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Primary Economy</span>
                            </label>
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-1 border-gray-200 dark:border-gray-700 grid col-span-3">
               
            <?php
if (isset($flights)) {
    echo "<div class='p-4 border border-gray-200 dark:border-gray-700 bg-white shadow-lg rounded-lg w-full max-w-2xl mx-11'>";

    foreach ($flights as $flight) {
        echo "
            <div class='flex items-center justify-between mb-4'>
                <div class='flex items-center space-x-4'>
                    <img src='' alt='Airline Logo' class='w-12 h-12 rounded-full'>
                    <div>
                        <p class='text-lg font-semibold text-gray-800'>{$flight['airline_name']}</p>
                        <p class='text-sm text-gray-500'>{$flight['flight_name']}</p>
                    </div>
                </div>
                <p class='text-xl font-bold text-blue-600'>{$flight["fee_per_ticket"]}</p>
            </div>

            <!-- Flight Timing and Stops -->
            <div class='flex items-center justify-between mb-4'>
                <!-- Departure -->
                <div class='text-center'>
                    <p class='text-lg font-semibold text-gray-800'>Departure time</p>
                    <p class='text-sm text-gray-500'>{$flight["departure_time"]}</p>
                </div>
                <!-- Flight Path -->
                <div class='text-center text-gray-500'>
                    <div class='flex items-center space-x-2'>
                        <span class='w-6 h-6 flex items-center justify-center bg-blue-100 text-blue-500 rounded-full'>
                            <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4' viewBox='0 0 20 20' fill='currentColor'>
                                <path d='M10.293 15.707a1 1 0 010-1.414l3-3H3a1 1 0 110-2h10.586l-3-3a1 1 0 011.414-1.414l4.707 4.707a1 1 0 010 1.414l-4.707 4.707a1 1 0 01-1.414 0z' />
                            </svg>
                        </span>
                        <p class='text-sm'>{$flight["total_distance"]}km</p>
                    </div>
                    <p class='text-xs'>{$flight["gate"]}</p>
                </div>
                <!-- Arrival -->
                <div class='text-center'>
                    <p class='text-lg font-semibold text-gray-800'>Arrival time</p>
                    <p class='text-sm text-gray-500'>{$flight["arrival_time"]}</p>
                </div>
            </div>

            <!-- Flight Date and Buttons -->
            <div class='flex items-center justify-between'>
                <!-- Flight Date -->
                <p class='text-sm text-gray-500'>{$flight["flight_date"]}</p>
                <!-- Buttons -->
                <div class='space-x-2'>
                    <button class='px-4 py-2 text-sm bg-blue-100 text-blue-500 rounded-lg'>Flight Detail</button>
                    <button class='px-4 py-2 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600'>Book Now</button>
                </div>
            </div>
            <hr class='h-px my-8 bg-gray-200 border-0 dark:bg-gray-700'>";
    }

    echo "</div>";
}
?>


            </div>  
            
            <div class="p-4  rounded-lg w-full max-w-lg -mx-20 col-span-1">
                <div class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 w-full max-w-sm rounded-lg font-[sans-serif] overflow-hidden mx-auto mt-4">
                    <h3 class="text-xl font-bold text-gray-800">Need Help??</h3>
                    <p class="mt-3 text-sm text-gray-500 leading-relaxed">You can contact us sending emails to us</p>

                    <div class="relative flex items-center px-1 bg-gray-50 border-2 focus-within:border-[#007bff] focus-within:bg-white rounded-lg mt-6">
                        <input type="email" placeholder="Enter email"
                        class="p-3 text-gray-800 w-full text-sm bg-transparent outline-none" />
                        <button type="button"
                        class="px-5 py-2.5 rounded-lg text-white text-sm tracking-wider border-none outline-none bg-blue-600 hover:bg-blue-700">Send</button>
                    </div>
            </div>
            </div>
        <!-- main contents ends -->
    </body>
</html>