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

    if(isset($_SESSION['seat_layout'])){
        $seats = $_SESSION['seat_layout'];
        $seatId = $seats['id'];
        $flightId = $seats['flight_id'];
        $seatNo = $seats['seatNo'];
    }else{
        echo "<script>alert('NO Seat selected!!!')</script>";
    }




// Check if the session variable 'booking' is set
if (isset($_SESSION['booking'])) {
    $passengerId = $_SESSION['booking']['passenger_id'];
    $bookingId = $_SESSION['booking']['booking_id'];
} else {
    echo "No booking information found in session.";
}


    if(isset($_POST['payAmount']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $bookingId = $_SESSION['booking']['booking_id'] ?? '';
        echo $bookingId;
        $class_price = $flight['classPrice'] ?? '';
            $tax = 0.15;
            $taxAmount = $class_price * $tax;
            $totalPrice = $class_price + $taxAmount;                               
        $typeId = $_POST['paymentType'];
        $securityCode = $_POST['securityCode'];
        $name = $_POST['name'];
        $expDate = $_POST['expireDate'];
        $cardNo = $_POST['cardNo'];
        $date = date('Y-m-d H:i:s');

        try{

            $sql = "INSERT INTO payment (cardNo, securityCode, expireDate, paymentType, name, totalPrice, bookingID, paymentDate ) VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            
            $status =$stmt->execute([$cardNo,$securityCode, $expDate,$typeId,$name,$totalPrice,$bookingId,$date]);

        if($status){
            $paymentId = $conn->lastInsertId();
            $_SESSION['paymentSuccess'] = "Successful payment!!!";

            $bookingId = $_SESSION['booking']['booking_id'] ?? '';
            
            $updateBook = "UPDATE booking set status = 'confirm',updated_at = NOW() where booking_id = ?";
            $bookStatus = $conn->prepare($updateBook);
            $bookStatus->execute([$bookingId]);

            $seatId = $seats['id'] ?? '';
            $updateSeat = "UPDATE seat_layout set status = 1 where id = ?";
            $seatStatus = $conn->prepare($updateSeat);
            $seatStatus->execute([$seatId]);
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
            // if(isset($_SESSION['completedPersonalInformation'])){
            //    echo "<div class='p-4 mb-4 text-sm text-black rounded-lg bg-green-50 dark:bg-cyan-50                  dark:text-green-400' role='alert'>
            //             <span class='font-medium'>$_SESSION[completedPersonalInformation]</span>
            //          </div>
            //          ";
            //    unset($_SESSION['completedPersonalInformation']);
            // }
            ?> 
         </p>

            <div class="font-[sans-serif] bg-white p-4 mt-28 mx-8">

                <div class="font-[sans-serif] lg:flex lg:items-center lg:justify-center lg:h-screen max-lg:py-4">
                    <div class="bg-purple-100 p-8 w-full max-w-5xl max-lg:max-w-xl mx-auto rounded-md">
                        <h2 class="text-3xl font-extrabold text-gray-800 text-center">Checkout</h2>

                        <div class="grid lg:grid-cols-1 gap-6 max-lg:gap-8 mt-16">
                            <form class="lg:col-span-1" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">

                                <div class="bg-white p-6 rounded-md max-lg:-order-1">
                                    <h3 class="text-lg font-bold text-gray-800">Summary</h3>
                                    <ul class="text-gray-800 mt-6 space-y-3">
                                    <li class="flex flex-wrap gap-4 text-sm">Flight Base Fees<span class="ml-auto font-bold">$
                                        <?php
                                            $feePerTicket = $flight['fee_per_ticket'] ?? '';
                                            echo $feePerTicket;
                                        ?>
                                    </span></li>
                                    <li class="flex flex-wrap gap-4 text-sm">Class Type Charges<span class="ml-auto font-bold">$
                                        <?php
                                            $classtypefees = $flight['base_fees'] ?? '';
                                            echo $classtypefees;
                                        ?>
                                    </span></li>
                                    <li class="flex flex-wrap gap-4 text-sm">Trip type Charges
                                        <span class="ml-auto font-bold">$
                                        <?php
                                            $triptypefees = $flight['priceCharge'];
                                            echo $triptypefees;
                                        ?>
                                        </span></li>
                                        <li class="flex flex-wrap gap-4 text-sm">Tax
                                        <span class="ml-auto font-bold">$
                                        <?php
                                            $tax = 0.15;
                                            echo number_format($tax,2);
                                        ?>
                                        </span></li>
                                    <hr />
                                    <li class="flex flex-wrap gap-4 text-base font-bold">Total <span class="ml-auto">$
                                        <?php
                                            $class_price = $flight['classPrice'] ?? '';
                                            $tax = 0.15;
                                            $taxAmount = $class_price * $tax;
                                            $totalPrice = $class_price + $taxAmount;
                                            echo number_format($totalPrice,2);
                                        ?>
                                    </span></li>
                                    </ul>
                                    <p>
                                        Additonal fees like baggage fee are calculated in tax.
                                    </p>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-1 mt-4">
                                    <h3 class="text-lg font-bold text-gray-800">Choose your payment method</h3>

                                    <div class="flex items-center">
                                        <input type="radio" class="w-5 h-5 cursor-pointer" id="card" name="paymentType" value="1" />
                                        <label for="card" class="ml-4 flex gap-2 cursor-pointer">
                                        <img src="https://readymadeui.com/images/visa.webp" class="w-12" alt="card1" />
                                        <img src="https://readymadeui.com/images/american-express.webp" class="w-12" alt="card2" />
                                        <img src="https://readymadeui.com/images/master.webp" class="w-12" alt="card3" />
                                        </label>
                                    </div>

                                    <div class="flex items-center">
                                        <input type="radio" class="w-5 h-5 cursor-pointer" name="paymentType" value="2" id="paypal" />
                                        <label for="paypal" class="ml-4 flex gap-2 cursor-pointer">
                                        <img src="https://readymadeui.com/images/paypal.webp" class="w-20" alt="paypalCard" />
                                        </label>
                                    </div>
                                </div>
                                

                                <div class="grid sm:col-span-2 sm:grid-cols-2 gap-4 mt-4">
                                        <div>
                                        <input type="text" placeholder="Name of card holder" name="name"
                                            class="px-4 py-3.5 bg-white text-gray-800 w-full text-sm border rounded-md focus:border-[#007bff] outline-none" />
                                        </div>
                                        <div>
                                        <input type="number" placeholder="CVV" name="securityCode"
                                            class="px-4 py-3.5 bg-white text-gray-800 w-full text-sm border rounded-md focus:border-[#007bff] outline-none" />
                                        </div>
                                        <div>
                                        <input type="number" placeholder="Card number" name="cardNo"
                                            class="col-span-full px-4 py-3.5 bg-white text-gray-800 w-full text-sm border rounded-md focus:border-[#007bff] outline-none" />
                                        </div>
                                        <div>
                                        <input type="date" placeholder="EXP." name="expireDate"
                                            class="px-4 py-3.5 bg-white text-gray-800 w-full text-sm border rounded-md focus:border-[#007bff] outline-none" />
                                        </div>
                                </div>

                                <div class="flex flex-wrap gap-4 mt-8">

                                        <button type="button"
                                        class="px-7 py-3.5 text-sm tracking-wide bg-white hover:bg-gray-50 text-gray-800 rounded-md">Pay later</button>

                                        <button type="submit" name="payAmount"
                                        class="px-7 py-3.5 text-sm tracking-wide bg-blue-600 text-white rounded-md hover:bg-blue-700">Submit</button>
                                </div>
                            </form>
                        </div>

                        
                        </div>
        
        
</body>
</html>