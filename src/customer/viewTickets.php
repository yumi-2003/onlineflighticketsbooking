<?php
require_once 'dbconnect.php';

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['users'])) {
    $user_id = $_SESSION['users']['user_id'];
}

//check the last payment id from session
if (isset($_SESSION['paymentId'])) {
    $paymentId = $_SESSION['paymentId'];

    $sql = "SELECT * 
    FROM booking b
    INNER JOIN seat_layout s ON b.seatNoId = s.id
    INNER JOIN flight f ON b.flight_id = f.flight_id
    INNER JOIN users u ON b.user_id = u.user_id
    INNER JOIN classes c ON b.class_id = c.class_id
    INNER JOIN triptype t ON b.tripType_id = t.tripTypeId
    INNER JOIN payment p ON b.payment_id = p.paymentID
    INNER JOIN passengers ps ON b.passenger_id = ps.passenger_id
    WHERE p.paymentID = $paymentId";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($booking);

    
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
</head>

<body>

   

    <div class="p-6 border border-gray-200 dark:border-gray-700 bg-white shadow-lg rounded-lg w-auto max-w-2xl mx-auto my-24">
        <!-- Start of a Flight Card -->
        <!-- <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-4">
                <img src="airline-logo.jpg" alt="Airline Logo" class="w-16 h-12 rounded-full">
                <div>
                    <p class="text-lg font-semibold text-gray-800">Airline Name</p>
                    <p class="text-sm text-gray-500">Flight Name</p>
                </div>
            </div>
            <p class="text-xl font-bold text-blue-600">Class Name</p>
            <p class="text-xl font-bold text-blue-600"><span class="text-xl font-bold text-blue-600">$</span>Class Price</p>
        </div> -->

        <!-- <div class="flex items-center justify-between mb-4">
            <div class="text-center">
                <p class="text-lg font-semibold text-gray-800">From</p>
                <p class="text-sm text-gray-500">Source City</p>
                <p class="text-sm text-gray-500">Departure Time</p>
            </div>
            <div class="text-center text-gray-500">
                <div class="flex items-center space-x-2">
                    <span class="w-6 h-6 flex items-center justify-center bg-blue-100 text-blue-500 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.293 15.707a1 1 0 010-1.414l3-3H3a1 1 0 110-2h10.586l-3-3a1 1 0 011.414-1.414l4.707 4.707a1 1 0 010 1.414l-4.707 4.707a1 1 0 01-1.414 0z" />
                        </svg>
                    </span>
                    <p class="text-sm">Total Distance km</p>
                </div>
                <p class="text-xs">Gate Name: Gate 1</p>
                <p class="text-xs">Trip Type: One-way</p>
            </div>
            <div class="text-center">
                <p class="text-lg font-semibold text-gray-800">To</p>
                <p class="text-sm text-gray-500">Destination City</p>
                <p class="text-sm text-gray-500">Arrival Time</p>
            </div>
        </div> -->

        <!-- <div class="flex items-center justify-between">
            <p class="text-sm text-gray-500">Flight Date</p>

            <form action="">
                <button type="button" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Book Now</button>
            </form>
        </div> -->

        <?php
            if (isset($tickets)) {
                echo "<div class='p-6 border border-gray-200 dark:border-gray-700 bg-white shadow-lg rounded-lg w-auto max-w-2xl mx-auto'>";

                foreach ($tickets as $ticket) {
                    echo "
                        <div class='flex items-center justify-between mb-4'>
                            <div class='flex items-center space-x-4'>
                                <div>
                                    <p class='text-lg font-semibold text-gray-800'>{$ticket['seatNo']}</p>
                                </div>
                                <div>
                                    <p class='text-lg font-semibold text-gray-800'>{$ticket['fullName']}</p>
                                    <p class='text-sm text-gray-500'>{$ticket['flight_name']}</p>
                                </div>
                            </div>
                            <p class='text-xl font-bold text-blue-600'>{$ticket["class_name"]}</p>
                        </div>
                        <div class='flex items-center justify-between mb-4'>
                            <div class='text-center'>
                                <p class='text-lg font-semibold text-gray-800'>From</p>
                                <p class='text-sm text-gray-500'>{$ticket["source"]}</p>
                                <p class='text-sm text-gray-500'>{$ticket["departure_time"]}</p>
                            </div>
                            <div class='text-center text-gray-500'>
                                <div class='flex items-center space-x-2'>
                                    <span class='w-6 h-6 flex items-center justify-center bg-blue-100 text-blue-500 rounded-full'>
                                        <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4' viewBox='0 0 20 20' fill='currentColor'>
                                            <path d='M10.293 15.707a1 1 0 010-1.414l3-3H3a1 1 0 110-2h10.586l-3-3a1 1 0 011.414-1.414l4.707 4.707a1 1 0 010 1.414l-4.707 4.707a1 1 0 01-1.414 0z' />
                                        </svg>
                                    </span>
                                    <p class='text-sm'>{$ticket["total_distance"]}km</p>
                                </div>
                                <p class='text-xs'>Gate Name:{$ticket["gate"]}</p>
                                <p class='text-xs'>Trip Type:{$ticket["triptype_name"]}</p>
                            </div>
                            <div class='text-center'>
                                <p class='text-lg font-semibold text-gray-800'>To</p>
                                <p class='text-sm text-gray-500'>{$ticket["destination"]}</p>
                                <p class='text-sm text-gray-500'>{$ticket["arrival_time"]}</p>
                            </div>
                        </div>
                        <div class='flex items-center justify-between'>
                            <p class='text-sm text-gray-500'>{$ticket["flight_date"]}</p>

                                    <div class='space-x-2'>
                                        <button type='submit' name='selectSeat' class='px-4 py-2 rounded-lg text-white text-sm bg-blue-600 hover:bg-blue-700'>PRINT</button>
                                    </div>
                            
                            
                        </div>
                        <hr class='h-px my-8 bg-gray-200 border-0 dark:bg-gray-700'>";
                }
            }
                echo "</div>";
        ?>

    </div>

    <!-- footer starts -->
    <footer class=" py-10 px-10 font-sans tracking-wide bg-[#00103c]">
        <div class="bg-[#00103c] py-10 px-6 font-[sans-serif]">
            <div class="max-w-lg mx-auto text-center">
                <h2 class="text-2xl font-bold mb-6 text-white">Subscribe to Our Newsletter</h2>
                <div class="mt-12 flex items-center overflow-hidden bg-gray-50 rounded-md max-w-xl mx-auto">
                    <input type="email" placeholder="Enter your email" class="w-full bg-transparent py-3.5 px-4 text-gray-800 text-base focus:outline-none" />
                    <button class="bg-[#004be4] hover:bg-[#a91079e2] text-white text-base tracking-wide py-3.5 px-6 hover:shadow-md hover:transition-transform transition-transform hover:scale-105 focus:outline-none">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>

        <div class="max-w-2xl mx-auto text-center">
            <ul class="flex flex-wrap justify-center gap-6 mt-8">
                <li>
                    <a href='javascript:void(0)'>
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-blue-600 w-8 h-8" viewBox="0 0 49.652 49.652">
                            <path d="M24.826 0C11.137 0 0 11.137 0 24.826c0 13.688 11.137 24.826 24.826 24.826 13.688 0 24.826-11.138 24.826-24.826C49.652 11.137 38.516 0 24.826 0zM31 25.7h-4.039v14.396h-5.985V25.7h-2.845v-5.088h2.845v-3.291c0-2.357 1.12-6.04 6.04-6.04l4.435.017v4.939h-3.219c-.524 0-1.269.262-1.269 1.386v2.99h4.56z" data-original="#000000" />
                        </svg>
                    </a>
                </li>
                <li>
                    <a href='javascript:void(0)'>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 112.196 112.196">
                            <circle cx="56.098" cy="56.097" r="56.098" fill="#007ab9" data-original="#007ab9" />
                            <path fill="#fff" d="M89.616 60.611v23.128H76.207V62.161c0-5.418-1.936-9.118-6.791-9.118-3.705 0-5.906 2.491-6.878 4.903-.353.862-.444 2.059-.444 3.268v22.524h-13.41s.18-36.546 0-40.329h13.411v5.715c-.027.045-.065.089-.089.132h.089v-.132c1.782-2.742 4.96-6.662 12.085-6.662 8.822 0 15.436 5.764 15.436 18.149zm-54.96-36.642c-4.587 0-7.588 3.011-7.588 6.967 0 3.872 2.914 6.97 7.412 6.97h.087c4.677 0 7.585-3.098 7.585-6.97-.089-3.956-2.908-6.967-7.496-6.967zm-6.791 59.77H41.27v-40.33H27.865v40.33z" data-original="#f1f2f2" />
                        </svg>
                    </a>
                </li>
                <li>
                    <a href='javascript:void(0)'>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 152 152">
                            <linearGradient id="a" x1="22.26" x2="129.74" y1="22.26" y2="129.74" gradientUnits="userSpaceOnUse">
                                <stop offset="0" stop-color="#fae100" />
                                <stop offset=".15" stop-color="#fcb720" />
                                <stop offset=".3" stop-color="#ff7950" />
                                <stop offset=".5" stop-color="#ff1c74" />
                                <stop offset="1" stop-color="#6c1cd1" />
                            </linearGradient>
                            <g data-name="Layer 2">
                                <g data-name="03.Instagram">
                                    <rect width="152" height="152" fill="url(#a)" data-original="url(#a)" rx="76" />
                                    <g fill="#fff">
                                        <path fill="#ffffff10" d="M133.2 26c-11.08 20.34-26.75 41.32-46.33 60.9S46.31 122.12 26 133.2q-1.91-1.66-3.71-3.46A76 76 0 1 1 129.74 22.26q1.8 1.8 3.46 3.74z" data-original="#ffffff10" />
                                        <path d="M94 36H58a22 22 0 0 0-22 22v36a22 22 0 0 0 22 22h36a22 22 0 0 0 22-22V58a22 22 0 0 0-22-22zm15 54.84A18.16 18.16 0 0 1 90.84 109H61.16A18.16 18.16 0 0 1 43 90.84V61.16A18.16 18.16 0 0 1 61.16 43h29.68A18.16 18.16 0 0 1 109 61.16z" data-original="#ffffff" />
                                        <path d="m90.59 61.56-.19-.19-.16-.16A20.16 20.16 0 0 0 76 55.33 20.52 20.52 0 0 0 55.62 76a20.75 20.75 0 0 0 6 14.61 20.19 20.19 0 0 0 14.42 6 20.73 20.73 0 0 0 14.55-35.05zM76 89.56A13.56 13.56 0 1 1 89.37 76 13.46 13.46 0 0 1 76 89.56zm26.43-35.18a4.88 4.88 0 0 1-4.85 4.92 4.81 4.81 0 0 1-3.42-1.43 4.93 4.93 0 0 1 3.43-8.39 4.82 4.82 0 0 1 3.09 1.12l.1.1a3.05 3.05 0 0 1 .44.44l.11.12a4.92 4.92 0 0 1 1.1 3.12z" data-original="#ffffff" />
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href='javascript:void(0)'>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 1227 1227">
                            <path d="M613.5 0C274.685 0 0 274.685 0 613.5S274.685 1227 613.5 1227 1227 952.315 1227 613.5 952.315 0 613.5 0z" data-original="#000000" />
                            <path fill="#fff" d="m680.617 557.98 262.632-305.288h-62.235L652.97 517.77 470.833 252.692H260.759l275.427 400.844-275.427 320.142h62.239l240.82-279.931 192.35 279.931h210.074L680.601 557.98zM345.423 299.545h95.595l440.024 629.411h-95.595z" data-original="#ffffff" />
                        </svg>
                    </a>
                </li>
            </ul>
        </div>


        <hr class="my-10 border-gray-500" />

        <div class="flex max-md:flex-col gap-4">
            <ul class="flex flex-wrap gap-4">
                <li class="text-sm">
                    <a href='javascript:void(0)' class='text-gray-300 font-semibold hover:underline'>Terms of Service</a>
                </li>
                <li class="text-sm">
                    <a href='javascript:void(0)' class='text-gray-300 font-semibold hover:underline'>Privacy Policy</a>
                </li>
                <li class="text-sm">
                    <a href='javascript:void(0)' class='text-gray-300 font-semibold hover:underline'>Security</a>
                </li>
            </ul>
            <p class='text-sm text-gray-300 md:ml-auto'>© SwiftMiles. All rights reserved.</p>
        </div>
    </footer>
    <!-- footer ends -->


</body>

</html>