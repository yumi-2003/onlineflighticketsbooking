<?php

require_once "dbconnect.php";

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['users'])) {
    $user_id = $_SESSION['users']['user_id'];

} else {
    echo "<script>alert('NO user ID selected!!!')</script>";
}

try {
    $sql = "SELECT * FROM airline";
    $stmt = $conn->prepare($sql);
    $status = $stmt->execute();

    if ($status) {
        $airlines = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

//get flight information and make pagination
try {
    //pagination setup
    $perPage = 8; // number of flight for each page

    //get the current page number or set 1 as a default
    $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

    //calculate the first record to display on the current page
    $start = ($currentPage - 1) * $perPage;

    //get flight counts
    $count = "SELECT count(*) as total FROM flightclasses";
    $stmtCount = $conn->query($count);

    //fetch the total number of flights
    $totalFlights = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    //calculate the total pages based on total flights and per pages
    $totalPages = ceil($totalFlights / $perPage);

    $sql = "SELECT 
                    *
                FROM 
                    flight
                INNER JOIN 
                    airline ON flight.airline_id = airline.airline_id
                INNER JOIN 
                    flightclasses ON flight.flight_id = flightclasses.flight_id
                INNER JOIN 
                    classes ON flightclasses.class_id = classes.class_id
                INNER JOIN 
                    triptype on flightclasses.triptype = triptype.triptypeId
                LIMIT :perPage OFFSET :start; 
                "; //limt the number of flight to display on each page, offset is the starting point of the record to display

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);

    $stmt->execute();
    $flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}
//search by source, destin, flight date
if (isset($_POST['find'])) {
    $source = $_POST['source'];
    $desti = $_POST['destination'];
    $date = $_POST['flight_date'];

    try {
        $sql = "SELECT 
                    flight.flight_id,
                    airline.airline_name,
                    airline.photo, 
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
                    flightclasses.classPrice,
                    triptype.priceCharge
                    triptype.triptype_name, 
                    classes.class_id,
                    classes.class_name,
                    classes.base_fees
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
                ON 
                    flightclasses.class_id = classes.class_id WHERE source = ? AND destination = ? AND flight_date = ?
                ";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $source, PDO::PARAM_STR);
        $stmt->bindParam(2, $desti, PDO::PARAM_STR);
        $stmt->bindParam(3, $date, PDO::PARAM_STR);
        $stmt->execute();
        $flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<script>alert('There is no available flight for your search')</script>";
    }
}

//search by radio buttion of class name
if (isset($_POST['classPrice']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $classPrice = $_POST['classPrice']; // Get user-selected class type

    $sql = "SELECT 
                *
            FROM 
                flight
            INNER JOIN 
                airline ON flight.airline_id = airline.airline_id
            INNER JOIN 
                flightclasses ON flight.flight_id = flightclasses.flight_id
            INNER JOIN 
                classes ON flightclasses.class_id = classes.class_id
            INNER JOIN 
                triptype on flightclasses.triptype = triptype.triptypeId
            WHERE 
                classes.class_id = ?;";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $classPrice, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the results
    $flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//process to seat Layout
if (isset($_POST['selectSeat'])  && $_SERVER['REQUEST_METHOD'] == 'POST') {

    // Store the selected flight data in the session
    $_SESSION['flight'] = [
        'flight_id' => $_POST['flight_id'],
        'airline_name' => $_POST['airline_name'],
        'photo' => $_POST['photo'],
        'fee_per_ticket' => $_POST['fee_per_ticket'],
        'base_fees' => $_POST['base_fees'],
        'priceCharge' => $_POST['priceCharge'],
        'flight_name' => $_POST['flight_name'],
        'class_name' => $_POST['class_name'],
        'classPrice' => $_POST['classPrice'],
        'source' => $_POST['source'],
        'destination' => $_POST['destination'],
        'gate' => $_POST['gate'],
        'flight_date' => $_POST['flight_date'],
        'departure_time' => $_POST['departure_time'],
        'arrival_time' => $_POST['arrival_time'],
        'triptypeId' => $_POST['triptypeId'],
        'triptype_name' => $_POST['triptype_name'],
        'class_id' => $_POST['class_id']
    ];

    header("Location: showSeat.php");
    exit;
}

//get filtered flight information by price
if (isset($_POST['priceRangeSearch'])) {
    $price = $_POST['priceRangeSearch'];

    $minPrice = $price - 100;
    $maxPrice = $price + 100;

    try {
        $sql = "SELECT 
                        *
                    FROM 
                        flight
                    INNER JOIN 
                        airline ON flight.airline_id = airline.airline_id
                    INNER JOIN 
                        flightclasses ON flight.flight_id = flightclasses.flight_id
                    INNER JOIN 
                        classes ON flightclasses.class_id = classes.class_id
                    INNER JOIN 
                        triptype on flightclasses.triptype = triptype.triptypeId
                    WHERE
                        flightclasses.classPrice BETWEEN ? AND ?;
                    ";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $price, PDO::PARAM_INT);
        $stmt->execute([$minPrice, $maxPrice]);
        $flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//search by radio buttion of trip name
if (isset($_POST['tripType'])) {
    $triptype = $_POST['tripType']; // Get user-selected class type

    $sql = "SELECT 
                *
            FROM 
                flight
            INNER JOIN 
                airline ON flight.airline_id = airline.airline_id
            INNER JOIN 
                flightclasses ON flight.flight_id = flightclasses.flight_id
            INNER JOIN 
                classes ON flightclasses.class_id = classes.class_id
            INNER JOIN 
                triptype on flightclasses.triptype = triptype.triptypeId
            WHERE 
                triptype.triptypeId = ?;";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $triptype, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the results
    $flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//search by airline name using select option
if (isset($_POST['airlineSearch'])) {
    $name = $_POST['airline_name']; // Get user-selected class type
    $sql = "SELECT 
                *
            FROM 
                flight
            INNER JOIN 
                airline ON flight.airline_id = airline.airline_id
            INNER JOIN 
                flightclasses ON flight.flight_id = flightclasses.flight_id
            INNER JOIN 
                classes ON flightclasses.class_id = classes.class_id
            INNER JOIN 
                triptype on flightclasses.triptype = triptype.triptypeId
            WHERE 
                airline.airline_id = ?;";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name]);
    // Fetch the results
    $flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if(isset($_POST['submit'])){
    $rating = $_POST['rating'];
    $text = $_POST['review_text'];
    $createdAt = date('Y-m-d H:i:s');
    try{
        $reviewSql = "INSERT INTO review (user_id,rating,review_text,created_at) VALUES (?,?,?,?)";
        $revStmt = $conn->prepare($reviewSql);
        $status = $revStmt->execute([$user_id,$rating,$text,$createdAt]);
        $review_id= $conn->lastInsertId();

        if($status){
            $_SESSION['completed_review'] = "Thanks for your time, Enjoy your journey with SwiftMiles";
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
    <title>Flgiht Information Search</title>
    <link href="./output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite-datepicker@1.0.0/dist/datepicker.min.js"></script>
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
        if (isset($_SESSION['userisLoggedIn'])) {
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

  <!-- banner starts -->
  <div class="font-[sans-serif]">
      <div class=" w-full h-60 mt-10" >
      <img src="/images/banner5.png" alt="Banner Image" class="w-full h-full object-cover"/>
      </div>

      <div class="-mt-28 mb-6 px-4">
        <div class="mx-auto max-w-6xl shadow-lg p-8 relative rounded bg-[#f5f5f5]">
          <h2 class="text-xl text-gray-800 font-bold">Search Your Destination</h2>

          <form class="mt-8 grid sm:grid-cols-4 gap-2" action="" method="POST">
            <div>
              <!-- <label class="text-gray-800 text-sm block mb-2">Source</label> -->
              <select id="source" name="source" class="w-full rounded py-2.5 px-4 border border-gray-300 text-sm focus:border-blue-600 outline-none">
              <option selected>From: City</option>
              <?php
              $uniqueSources = array_unique(array_column($flights, 'source'));
              foreach ($uniqueSources as $source) {
                echo "<option value='$source'>$source</option>";
              }
              ?>
            </select>
            </div>
            <div>
              <!-- <label class="text-gray-800 text-sm block mb-2">Destination</label> -->
              <select id="destination" name="destination" class="w-full rounded py-2.5 px-4 border border-gray-300 text-sm focus:border-blue-600 outline-none">
              <option selected>To: City</option>
              <?php
              $uniqueDestin = array_unique(array_column($flights, 'destination'));
              foreach ($uniqueDestin as $destin) {
                echo "<option value='$destin'>$destin</option>";
              }
              ?>
            </select>
            </div>
            <div>
              <!-- <label class="text-gray-800 text-sm block mb-2">Depature Time</label> -->
              <input type="date" name="flight_date" class="w-full rounded py-2.5 px-4 border border-gray-300 text-sm focus:border-blue-600 outline-none" id="depDate" name='flight_date' placeholder="Departure Date" />
            </div>
            <div>
              <!-- <label class="text-gray-800 text-sm block mb-2"></label> -->
              <button name="find" class="w-full rounded py-2.5 px-4 border border-gray-300 text-sm text-[#f2f2ef] focus:border-blue-600 outline-none w-60 bg-[#173187]">Search</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- banner ends -->


    <!-- main contents starts -->
    <div class="p-4 grid grid-cols-5 gap-1">
        <div class="col-span-1 grid-row-4 gap-1">
            <!-- filter section -->
            <div class="flex justify-start rounded-lg text-black">
                <h3 class="font-[sans-serif] text-2xl">Filter Flight Information</h3>
            </div>

            <!-- search by classes -->
            <div class="flex justify-start rounded-lg text-black">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" class="p-1" id="classPriceSearch">
                    <label for="">Choose Flight Classes
                    </label>
                    <div class="grid space-y-3 pt-3" id="classPriceSearch">
                        <label for="hs-vertical-radio-in-form" class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <input type="radio" name="classPrice" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="first-class" value="1" onchange="this.form.submit();" <?php echo (isset($_POST['classPrice']) && $_POST['classPrice'] == '1') ? 'checked' : ''; ?>>
                            <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">First</span>
                        </label>

                        <label for="hs-vertical-radio-in-form" class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <input type="radio" name="classPrice" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="business-class" value="2" onchange="this.form.submit();" <?php echo (isset($_POST['classPrice']) && $_POST['classPrice'] == '2') ? 'checked' : ''; ?>>
                            <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Business</span>
                        </label>

                        <label for="hs-vertical-radio-in-form" class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <input type="radio" name="classPrice" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="economy-class" value="3" onchange="this.form.submit();" <?php echo (isset($_POST['classPrice']) && $_POST['classPrice'] == '3') ? 'checked' : ''; ?>>
                            <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Premium Economy</span>
                        </label>

                        <label for="hs-vertical-radio-checked-in-form" class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <input type="radio" name="classPrice" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="primaryeco-class" value="4" onchange="this.form.submit();" <?php echo (isset($_POST['classPrice']) && $_POST['classPrice'] == '4') ? 'checked' : ''; ?>>
                            <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Economy</span>
                        </label>
                        
                    </div>
                </form>
            </div>
            <hr class='h-px my-8 bg-gray-200 border-0 dark:bg-gray-700'>


            <!-- search by price range -->
            <div class="flex justify-start rounded-lg text-black">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" class="p-3 w-full" id="priceRangeSearch">
                    <label for="">Price Range</label>
                    <div class="relative mb-6 z-0">
                        <input id="labels-range-input" name="priceRangeSearch" type="range" value="100" min="100" max="1500" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" onchange="this.form.submit()">
                        <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400">
                            <span class="text-sm text-gray-500 dark:text-gray-400 absolute start-0 -bottom-6">($100)</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400 absolute end-0 -bottom-6">($1500)</span>
                        </div>
                    </div>
                </form>
            </div>
            <hr class='h-px my-8 bg-gray-200 border-0 dark:bg-gray-700'>

            <!-- search by trip type -->
            <div class="flex justify-start rounded-lg text-black mt-0">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" class="p-3" id="tripTypeSearch">
                    <label for="">Choose Trip Type</label>
                    <div class="grid space-y-3 pt-3">
                        <label for="hs-vertical-radio-in-form" class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <input type="radio" name="tripType" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="single" value="1" onchange="this.form.submit();" <?php echo (isset($_POST['tripType']) && $_POST['tripType'] == '1') ? 'checked' : ''; ?>>
                            <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Single</span>
                        </label>

                        <label for="hs-vertical-radio-in-form" class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <input type="radio" name="tripType" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="round" value="2" onchange="this.form.submit();" <?php echo (isset($_POST['tripType']) && $_POST['tripType'] == '2') ? 'checked' : ''; ?>>
                            <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Round</span>
                        </label>
                    </div>
                </form>

            </div>
            <hr class='h-px my-8 bg-gray-200 border-0 dark:bg-gray-700'>

            <!-- search by ariline name -->
            <div class="flex justify-start rounded-lg text-black">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" class="p-3" id="airlineSearch">
                    <label for="">Airline Name</label>
                    <div class="grid space-y-3 pt-3">
                        <select class="py-3 px-4 pe-9 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600" name="airline_name" onchange="selectAirline()">
                            <option>Choose Airline</option>
                            <?php
                            foreach ($airlines as $airline) {
                                echo "<option value='{$airline['airline_name']}'>{$airline['airline_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </form>
            </div>
            <hr class='h-px my-8 bg-gray-200 border-0 dark:bg-gray-700'>

            <!-- search by departure time and arrival time -->
            <div class="flex justify-start rounded-lg text-black">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" class="p-3" id="timeSearch">
                    <label for="">Departure and Arrival</label>
                    <div class="grid space-y-3 pt-3">
                        <div class="grid space-y-2">
                            <label for="departure-checkbox" class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="departure-checkbox" name="departure_time" onchange="this.form.submit();">
                                <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Departure Time</span>
                            </label>

                            <label for="arrival-checkbox" class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="arrival-checkbox" name="arrival_time" onchange="this.form.submit();">
                                <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Arrival Time</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <hr class='h-px my-8 bg-gray-200 border-0 dark:bg-gray-700'>
        </div>

        <!-- disply flight information -->
        <div class="p-1 border-gray-200 dark:border-gray-700 grid col-span-3">

            <?php
            if (isset($flights)) {
                echo "<div class='p-6 border border-gray-200 dark:border-gray-700 bg-white shadow-lg rounded-lg w-auto max-w-2xl mx-auto'>";

                foreach ($flights as $flight) {
                    echo "
                        <div class='flex items-center justify-between mb-4'>
                            <div class='flex items-center space-x-4'>
                                <img src='{$flight['photo']}' alt='Airline Logo' class='w-16 h-12 rounded-full'>
                                <div>
                                    <p class='text-lg font-semibold text-gray-800'>{$flight['airline_name']}</p>
                                    <p class='text-sm text-gray-500'>{$flight['flight_name']}</p>
                                </div>
                            </div>
                            <p class='text-xl font-bold text-blue-600'>{$flight["class_name"]}</p>
                            <p class='text-xl font-bold text-blue-600'><span class='text-xl font-bold text-blue-600'>$</span>{$flight["classPrice"]}</p>
                        </div>
                        <div class='flex items-center justify-between mb-4'>
                            <div class='text-center'>
                                <p class='text-lg font-semibold text-gray-800'>From</p>
                                <p class='text-sm text-gray-500'>{$flight["source"]}</p>
                                <p class='text-sm text-gray-500'>{$flight["departure_time"]}</p>
                            </div>
                            <div class='text-center text-gray-500'>
                                <div class='flex items-center space-x-2'>
                                    <span class='w-6 h-6 flex items-center justify-center bg-blue-100 text-blue-500 rounded-full'>
                                        <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4' viewBox='0 0 20 20' fill='currentColor'>
                                            <path d='M10.293 15.707a1 1 0 010-1.414l3-3H3a1 1 0 110-2h10.586l-3-3a1 1 0 011.414-1.414l4.707 4.707a1 1 0 010 1.414l-4.707 4.707a1 1 0 01-1.414 0z' />
                                        </svg>
                                    </span>
                                    <p class='text-sm'>{$flight["total_distance"]}km</p>
                                </div>
                                <p class='text-xs'>Gate Name:{$flight["gate"]}</p>
                                <p class='text-xs'>Trip Type:{$flight["triptype_name"]}</p>
                            </div>
                            <div class='text-center'>
                                <p class='text-lg font-semibold text-gray-800'>To</p>
                                <p class='text-sm text-gray-500'>{$flight["destination"]}</p>
                                <p class='text-sm text-gray-500'>{$flight["arrival_time"]}</p>
                            </div>
                        </div>
                        <div class='flex items-center justify-between'>
                            <p class='text-sm text-gray-500'>{$flight["flight_date"]}</p>
                            
                            <form action='$_SERVER[PHP_SELF]' method='POST' enctype='multipart/form-data'>
                                    <input type='hidden' name='flight_id' value='{$flight['flight_id']}'>
                                    <input type='hidden' name='class_id' value='{$flight['class_id']}'>
                                    <input type='hidden' name='fee_per_ticket' value='{$flight['fee_per_ticket']}'>
                                    <input type='hidden' name='photo' value='{$flight['photo']}'>
                                    <input type='hidden' name='airline_name' value='{$flight['airline_name']}'>
                                    <input type='hidden' name='flight_name' value='{$flight['flight_name']}'>
                                    <input type='hidden' name='class_name' value='{$flight["class_name"]}'>
                                    <input type='hidden' name='base_fees' value='{$flight["base_fees"]}'>
                                    <input type='hidden' name='priceCharge' value='{$flight["priceCharge"]}'>
                                    <input type='hidden' name='classPrice' value='{$flight["classPrice"]}'>
                                    <input type='hidden' name='source' value='{$flight["source"]}'>
                                    <input type='hidden' name='flight_date' value='{$flight["flight_date"]}'>
                                    <input type='hidden' name='departure_time' value='{$flight["departure_time"]}'>
                                    <input type='hidden' name='triptypeId' value='{$flight["triptypeId"]}'>
                                    <input type='hidden' name='triptype_name' value='{$flight["triptype_name"]}'>
                                    <input type='hidden' name='gate' value='{$flight["gate"]}'>
                                    <input type='hidden' name='destination' value='{$flight["destination"]}'>
                                    <input type='hidden' name='arrival_time' value='{$flight["arrival_time"]}'>
                                    <div class='space-x-2'>
                                        <button type='submit' name='selectSeat' class='px-4 py-2 rounded-lg text-white text-sm bg-blue-600 hover:bg-blue-700'>Select Seat</button>
                                    </div>
                            </form>
                            
                        </div>
                        <hr class='h-px my-8 bg-gray-200 border-0 dark:bg-gray-700'>";
                }

                echo "</div>";

                //pagination links start here
                echo "<div class='flex justify-center items-center space-x-2 mt-6'>";

                // set up the previous page link
                if ($currentPage > 1) {
                    echo "<a href='?page=" . ($currentPage - 1) . "' class='flex items-center justify-center w-9 h-9 bg-gray-100 rounded-md'>
                                <svg xmlns='http://www.w3.org/2000/svg' class='w-4 fill-gray-400' viewBox='0 0 55.753 55.753'>
                                    <path d='M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z'/>
                                </svg>
                            </a>";
                }
                // loop through the total pages
                for ($i = 1; $i <= $totalPages; $i++) {
                    $activeClass = ($i == $currentPage) ? "bg-blue-500 text-white" : "bg-gray-100 text-gray-800";

                    echo "<a href='?page=$i' class='flex items-center justify-center w-9 h-9 $activeClass border rounded-md'>$i</a>";
                }
                // set up the next page link
                if ($currentPage < $totalPages) {
                    echo "<a href='?page=" . ($currentPage + 1) . "' class='flex items-center justify-center w-9 h-9 bg-gray-100 rounded-md'>
                                <svg xmlns='http://www.w3.org/2000/svg' class='w-4 fill-gray-400 rotate-180' viewBox='0 0 55.753 55.753'>
                                    <path d='M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z'/>
                                </svg>
                            </a>";
                }
                echo "</div>";
            } else {
                echo "<div class='p-4 border border-gray-200 dark:border-gray-700 bg-white shadow-lg rounded-lg w-full max-w-2xl mx-11'>
                        <p class='text-lg font-semibold text-gray-800'>No Flights Found</p>
                    </div>";
            }
            ?>



        </div>

        <div class="p-1 rounded-lg col-span-1">
            <div class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 w-auto rounded-lg font-[sans-serif] overflow-hidden mx-auto mt-4">
                <h3 class="text-xl font-bold text-gray-800">Keep Updated</h3>
                <p class="mt-3 text-sm text-gray-500 leading-relaxed">
                    You can contact us by sending emails to us.
                </p>

                <!-- Email Input and Button -->
                <div class="flex items-center px-1 bg-gray-50 border border-gray-300 rounded-lg mt-6">
                    <!-- Input Field -->
                    <input
                        type="email"
                        placeholder="Enter email"
                        class="p-3 text-gray-800 flex-1 text-sm bg-transparent outline-none w-full md:w-auto" />
                    <!-- Button -->
                </div>
                <button
                    type="button"
                    class="px-4 py-2 rounded-lg text-white text-sm bg-blue-600 hover:bg-blue-700 mt-6">
                    Subscribe
                </button>
            </div>
            <div class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 w-auto rounded-lg font-[sans-serif] overflow-hidden mx-auto mt-4">
                
                <h2>How is yours experiences?</h2>
                <!-- Open the modal using ID.showModal() method -->
                    <!-- You can open the modal using ID.showModal() method -->
                <button class="btn px-4 py-2 rounded-lg text-white text-sm bg-blue-600 hover:bg-blue-700 " onclick="my_modal_3.showModal()">Rate us please!!!</button>
                <dialog id="my_modal_3" class="modal shadow rounded-lg">
                    <div class="modal-box w-96">
                        <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-0">✕</button>
                        </form>
                            <form class="max-w-md mx-auto p-4 bg-white" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                            <h2 class="text-2xl font-bold mb-4">Feedback Form</h2>
                            <!-- <div class="mb-4">
                                <label for="name" class="block mb-1">Name</label>
                                <input type="text" id="name" class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block mb-1">Email</label>
                                <input type="email" id="email" class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div> -->
                            <div class="mb-4">
                                <label class="block mb-1">Rating</label>
                                    <div class="flex items-center space-x-2">
                                        <input type="radio" name="rating" id="rating1" value="1" class="focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <label for="rating1">1</label>
                                        <input type="radio" name="rating" id="rating2" value="2" class="focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <label for="rating2">2</label>
                                        <input type="radio" name="rating" id="rating3" value="3" class="focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <label for="rating3">3</label>
                                        <input type="radio" name="rating" id="rating4" value="4" class="focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <label for="rating4">4</label>
                                        <input type="radio" name="rating" id="rating5" value="5" class="focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <label for="rating5">5</label>
                                    </div>
                            </div>
                            <div class="mb-4">
                                <label for="message" class="block mb-1">Message</label>
                                <textarea id="message" name="review_text" class="w-full py-2 px-4 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                            <button type="submit" name="submit" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Submit</button>
                            </form>
                    </div>
                </dialog>
            </div>
        </div>

        <script>
            function airlineSearch() {
                document.getElementById('airline_name').value;
            }
        </script>
        <!-- main contents ends -->
</body>

</html>