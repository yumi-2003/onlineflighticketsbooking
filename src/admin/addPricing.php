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
            flight.placeImg,
            flightclasses.flightclasses_id,
            classes.base_fees,
            triptype.priceCharge,
            flightclasses.classPrice,
            classes.class_name,
            triptype.triptype_name 
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
    
        try{
        $stmt = $conn->query($sql);
        $status = $stmt->execute();
    
        if($status){
        $flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <title>Document</title>
        <link href="./output.css" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>

        <!-- nav stars -->
        <nav class="fixed top-0 z-50 w-full bg-gray-50 dark:bg-gray-800">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                    </button>
                <a href="https://flowbite.com" class="flex ms-2 md:me-24">
                    <!-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-3" alt="FlowBite Logo" /> -->
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">SwiftMiles</span>
                </a>
                </div>

                <?php

                    if(isset($_SESSION['isLoggedIn'])){
                ?>

                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                    <div>
                        <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user" id="dropdownUser">
                            <span class="sr-only">Open user menu</span>

                            <img class="w-8 h-8 rounded-full" src="<?php echo $_SESSION['adprofile'] ?>" alt="admin photo">

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
                    }

                ?>

                
            </div>
        </div>
        </nav>
        <!-- nav ends -->

        <form class="max-w-sm mx-auto mt-16">
        <div class="mb-5">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
            <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required />
        </div>
        <div class="mb-5">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
            <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
        </div>
        <div class="flex items-start mb-5">
            <div class="flex items-center h-5">
            <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" required />
            </div>
            <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
        </div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form>

    </body>
</html>