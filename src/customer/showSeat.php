<?php
        require_once 'dbconnect.php';

        if (!isset($_SESSION)) {
            session_start();
        }

        //get the selected seat No
        if (isset($_POST['submitSeats'])) {

            if(isset($_POST['seats'])){
                $selectedSeats = $_POST['seats'];

                foreach($selectedSeats as $seatId => $seatNo){
                    echo "You selected seat: $seatNo <br>";
                }

                $_SESSION['selectedSeats'] = $_POST['seats'];
                header('Location: flightBook.php');
                exit();
            }else{
                echo "Please select a seat";
            }
        }

        if (isset($_SESSION['flight'])) {
            // Retrieve the flight details from the session
            $flight = $_SESSION['flight'];
            $flight_id = $flight['flight_id'];
            // $photo = $flight['photo'];
            $class_id = $flight['class_id'];
            $feePerTicket = $flight['fee_per_ticket'];
            $classtypefees = $flight['base_fees'];
            $triptypefees = $flight['priceCharge'];
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
            $triptypeId = $flight['triptypeId'];
            $triptype_name = $flight['triptype_name'];
        } 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Selection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
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
                    <a href="/nonproductForms/aboutUs.php" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                      About Us
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
        </ul>
      </div>
    </div>
  </nav>
  <!-- nav ends -->
    
  <div class='flex h-auto items-center justify-center'>
  <div class="flex justify-center items-center  font-[sans-serif] h-full md:min-h-screen p-4 my-3 grid grid-cols-3 gap-4">
        <div class="p-4 gap-2 mt-16 mx-auto bg-cyan-200 col-span-2 border-2 rounded-lg">
            <h1>Select Your Seat</h1>
            <?php
            $flight_id = $flight['flight_id'] ?? '';
            $class_id = $flight['class_id']?? '';
            $sql = "SELECT * FROM seat_layout WHERE flight_id = :flight_id AND class_id = :class_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':flight_id', $flight_id, PDO::PARAM_INT);
            $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
            $stmt->execute();
            $seats = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $row = 1;
            $col = 1;

            echo "<form action='$_SERVER[PHP_SELF]' method='POST' class='inline-block' enctype='multipart/form-data'>";
            echo "<div class='seat-container w-full inline-block'>";
            foreach ($seats as $seat) {
                if ($col > 10) {
                    $col = 1;
                    $row++;
                    echo "<br>";
                }
                if ($col == 6) {
                    echo "<span>aisle</span>";
                }
                if ($row > 15) {
                    break;
                }
                if ($seat['status'] == 1) {
                    echo "
                            
                                <button type='button' name='' class='focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 w-16 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800'>{$seat['seatNo']}
                                
                                </button>
                            ";
                } else {

                    if ($seat['class_id'] == 1){
                        echo "
                            
                                <button type='button' name='select' data-seat-id='{$seat['id']}' data-seat-no='{$seat['seatNo']}' class='select-seat-btn focus:outline-none text-white bg-pink-700 hover:bg-pink-800 focus:ring-4 focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 w-16 dark:bg-pink-600 dark:hover:bg-pink-700 dark:focus:ring-pink-800'>{$seat['seatNo']}
                                <input type='hidden' name='seatNo' value='{$seat['seatNo']}'>
                                <input type='hidden' name='id' value='{$seat['id']}'>
                                <input type='hidden' name='flight_id' value='{$flight['flight_id']}'>
                                <input type='hidden' name='class_id' value='{$flight['class_id']}'>
                                <input type='hidden' name='triptypeId' value='{$flight['triptypeId']}'>
                                <input type='hidden' name='fee_per_ticket' value='{$flight['fee_per_ticket']}'>
                                <input type='hidden' name='base_fees' value='{$flight['base_fees']}'>
                                <input type='hidden' name='priceCharge' value='{$flight['priceCharge']}'>
                                </button>
                            ";
                    }else if($seat['class_id'] == 2){
                        echo "
                                <button type='button' name='select' data-seat-id='{$seat['id']}' data-seat-no='{$seat['seatNo']}' class='select-seat-btn focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 w-16 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800'>{$seat['seatNo']}
                                <input type='hidden' name='seatNo' value='{$seat['seatNo']}'>
                                <input type='hidden' name='id' value='{$seat['id']}'>
                                <input type='hidden' name='flight_id' value='{$flight['flight_id']}'>
                                <input type='hidden' name='class_id' value='{$flight['class_id']}'>
                                <input type='hidden' name='triptypeId' value='{$flight['triptypeId']}'>
                                <input type='hidden' name='fee_per_ticket' value='{$flight['fee_per_ticket']}'>
                                <input type='hidden' name='base_fees' value='{$flight['base_fees']}'>
                                <input type='hidden' name='priceCharge' value='{$flight['priceCharge']}'>

                                
                                </button>
                            ";
                    }
                    else if($seat['class_id'] == 3){
                        echo "
                                <button type='button' name='select'  data-seat-id='{$seat['id']}' data-seat-no='{$seat['seatNo']}' class='select-seat-btn focus:outline-none text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 w-16 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800'>{$seat['seatNo']}
                                <input type='hidden' name='seatNo' value='{$seat['seatNo']}'>
                                <input type='hidden' name='id' value='{$seat['id']}'>
                                <input type='hidden' name='flight_id' value='{$flight['flight_id']}'>
                                <input type='hidden' name='class_id' value='{$flight['class_id']}'>
                                <input type='hidden' name='triptypeId' value='{$flight['triptypeId']}'>
                                <input type='hidden' name='fee_per_ticket' value='{$flight['fee_per_ticket']}'>
                                <input type='hidden' name='base_fees' value='{$flight['base_fees']}'>
                                <input type='hidden' name='priceCharge' value='{$flight['priceCharge']}'>

                               
                                </button>
                            ";
                    }else if($seat['class_id'] == 4){
                        echo "
                                <button type='button' name='select' data-seat-id='{$seat['id']}' data-seat-no='{$seat['seatNo']}' class='select-seat-btn focus:outline-none text-white bg-black hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 w-16 dark:bg-black dark:hover:bg-gray-700 dark:focus:ring-gray-800'>{$seat['seatNo']}
                                <input type='hidden' name='seatNo' value='{$seat['seatNo']}'>
                                <input type='hidden' name='id' value='{$seat['id']}'>
                                <input type='hidden' name='flight_id' value='{$flight['flight_id']}'>
                                <input type='hidden' name='class_id' value='{$flight['class_id']}'>
                                <input type='hidden' name='triptypeId' value='{$flight['triptypeId']}'>
                                <input type='hidden' name='fee_per_ticket' value='{$flight['fee_per_ticket']}'>
                                <input type='hidden' name='base_fees' value='{$flight['base_fees']}'>
                                <input type='hidden' name='priceCharge' value='{$flight['priceCharge']}'>

                                
                                </button>
                            
                            ";
                    }
                }
                $col++;
            }
            echo "</div>";
            echo "<button type='submit' name='submitSeats' class='submit-seats-btn bg-green-500 hover:bg-green-600 text-white px-4 py-2 mt-4 rounded-lg'>
                    Submit Selected Seats
                </button>";
            echo "</form>";
            ?>

        </div>
        <div class="gap-4 w-full h-60 mx-auto my-0 col-span-1 bg-cyan-100 border-b rounded-lg">
            <div class="">
                booked
            </div>
            <div class="">
                Available
            </div>
        </div>
    </div>
  </div>

  <!-- footer starts -->
  <footer class="py-10 px-5 font-sans tracking-wide bg-[#00103c] h-72">
    <div class="bg-[#00103c] px-6 font-[sans-serif]">
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
      </ul>
    </div>


    <hr class="border-gray-500 my-2" />

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

    <script>
        document.querySelectorAll('.select-seat-btn').forEach(button => {
            button.addEventListener('click',function(){
                const seatNo = this.dataset.seatNo;
                const seatId = this.dataset.seatId;

                //make sure  already put the seat to the form or not
                let existingSeat = document.querySelector(`input[name="seats[${seatId}]"]`);

                //if not put that seat into th form
                if(!existingSeat){
                    const seatInsert =document.createElement('input');
                    seatInsert.type = 'hidden';
                    seatInsert.name = 'seats[' + seatId + ']';
                    seatInsert.value = seatNo;

                    //append the new hidden input fields to the form
                    document.querySelector('form').appendChild(seatInsert);
                }
            })
        })
    </script>

    
</body>

</html>