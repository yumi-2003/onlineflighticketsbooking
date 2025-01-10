<?php

    require_once 'dbconnect.php';

    if(!isset($_SESSION)){
      session_start();
    }

    

    if (isset($_SESSION['users'])) {
        $user_id = $_SESSION['users']['user_id'];
    }

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

    // if(isset($_SESSION['seat_layout'])){
    //     $seats = $_SESSION['seat_layout'];
    //     $seatId = $seats['id'];
    //     $flightId = $seats['flight_id'];
    //     $seatNo = $seats['seatNo'];
    // }else{
    //     echo "<script>alert('NO Seat selected!!!')</script>";
    // }

    if (isset($_SESSION['selectedSeats'])) {
        $selectedSeats = $_SESSION['selectedSeats'];
        foreach($selectedSeats as $seatId => $seatNo){
            echo $seatId.":".$seatNo;
        }
    } else {
        header('Location: showSeats.php');
    }

    //store personal information
    // try{
    //     $sql = "SELECT * FROM passengers";
    //     $stmt =$conn->query($sql);
    //     $personInfos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // }catch(PDOException $e){
    //     echo $e->getMessage();
    // }

    if(isset($_POST['savePersonalInfo'])) {
        $passengerData = [];
        $flight_id = $flight['flight_id'] ?? '';
        $classId = $flight['class_id'] ?? '';
        $triptypeId = $flight['triptypeId'] ?? '';
        $seatId = $seats['id'] ?? '';
        $book_at = date('Y-m-d H:i:s');
        
        foreach ($_POST['fullName'] as $index => $fullName) {
            $age = $_POST['age'][$index];
            $gender = $_POST['gender'][$index];
            $nationality = $_POST['nationality'][$index];
            $phoneNo = $_POST['phoneNo'][$index];
            $idCard = $_POST['IDcard'][$index];
            $passport = $_POST['passportNo'][$index];
            $seatId = $_POST['id'][$index];
            $seatNo = $_POST['seatNo'][$index];
            
        
        // Insert the passenger information into the database
        try {
            $sql = "INSERT INTO passengers (fullName, age, gender, nationality, phoneNo, IDcard, passportNo) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$fullName, $age, $gender, $nationality, $phoneNo, $idCard, $passport]);

            $passengerId = $conn->lastInsertId(); // Get the newly inserted passenger ID

            // Insert booking information for this passenger
            $book_at = date('Y-m-d H:i:s');
            $sql_booking = "INSERT INTO booking (user_id, flight_id, class_id, triptype_id, seatNoId, bookAt, passenger_id, status)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_booking = $conn->prepare($sql_booking);
            $stmt_booking->execute([$user_id, $flight_id, $classId, $triptypeId, $seatId, $book_at, $passengerId, 'pending']);
            $bookingId = $conn->lastInsertId();
            $bookingIds[] = $bookingId;

        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
        }
    
    $_SESSION['bookingIds'] = $bookingIds;
    // After inserting all passengers and bookings, redirect to checkout
    $_SESSION['completedPersonalInformation'] = "You have successfully entered your personal information.";
    header('Location: checkout.php');
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

                    <?php

                    foreach($selectedSeats as $seatId => $seatNo) {
                        //var_dump($seatNo)
                    ?> 
 
                    <div class="flex items-center">
                        <label class="text-gray-400 w-36 text-sm">Full Name</label>
                        <input type="text" name="fullName[]" placeholder="Enter your name"
                        class="px-2 py-2 w-full border-b-2 focus:border-[#333] outline-none text-sm bg-white" required/>
                    </div>

                    <div class="flex items-center">
                        <label class="text-gray-400 w-36 text-sm">Age</label>
                        <input type="number" name="age[]" placeholder="Age"
                        class="px-2 py-2 w-full border-b-2 focus:border-[#333] outline-none text-sm bg-white" min="1" required/>
                    </div>

                    <div class="flex items-center">
                        <label class="text-gray-400 w-36 text-sm">Gender</label>
                        <input type="text" name="gender[]" placeholder="Gender"
                        class="px-2 py-2 w-full border-b-2 focus:border-[#333] outline-none text-sm bg-white" required/>
                    </div>

                    <div class="flex items-center">
                        <label class="text-gray-400 w-36 text-sm">Nationality</label>
                        <input type="text" name="nationality[]" placeholder="Your Nationality"
                        class="px-2 py-2 w-full border-b-2 focus:border-[#333] outline-none text-sm bg-white" required/>
                    </div>

                    
                    <div class="flex items-center">
                        <label class="text-gray-400 w-36 text-sm">Phone NO.</label>
                        <input type="text" name="phoneNo[]" placeholder="Phone No."
                        class="px-2 py-2 w-full border-b-2 focus:border-[#333] outline-none text-sm bg-white" required/>
                    </div>

                    <div class="flex items-center">
                        <label class="text-gray-400 w-36 text-sm">ID Card NO.</label>
                        <input type="text" name="IDcard[]" placeholder="ID card No"
                        class="px-2 py-2 w-full border-b-2 focus:border-[#333] outline-none text-sm bg-white" required/>
                    </div>

                    <div class="flex items-center">
                        <label class="text-gray-400 w-36 text-sm">PassPort No.</label>
                        <input type="text" name="passportNo[]" placeholder="Passport No"
                        class="px-2 py-2 w-full border-b-2 focus:border-[#333] outline-none text-sm bg-white" required/>
                    </div>
                    <input type="hidden" name="passenger_id" value="<?php 
                            echo isset($_SESSION['passengerId']) ? $_SESSION['passengerId'] : '';  
                    
                    ?>">
                    <input type="hidden" name="booking_id" value="<?php 
                    
                        echo isset($_SESSION['bookingId']) ? $_SESSION['bookingId'] : '';
                    ?>">

                    <input type="hidden" name="id[]" value="<?php echo $seatId; ?>">
                    <input type="hidden" name="seatNo[]" value="<?php echo $seatNo; ?>">
                    <?php

}

                    ?>

                    <button type="submit" name="savePersonalInfo"
                    class="!mt-8 px-6 py-2 w-full bg-[#233d9a] hover:bg-[#444] text-sm text-white mx-auto block">Submit</button>
                </form>
                
            </div>
        </div>
        
</body>
</html>