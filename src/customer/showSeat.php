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
        } else {
            echo "<script>alert('NO flight selected!!!')</script>";
        }

        if (isset($_SESSION['wishlist'])) {
            // Retrieve the flight details from the session
            $wishlist = $_SESSION['wishlist'];
            $flight_id = $wishlist['flight_id'];
            // $photo = $wishlist['photo'];
            $class_id = $wishlist['class_id'];
            $feePerTicket = $wishlist['fee_per_ticket'];
            $classtypefees = $wishlist['base_fees'];
            $triptypefees = $wishlist['priceCharge'];
            $airline_name = $wishlist['airline_name'];
            $flight_name = $wishlist['flight_name'];
            $class_name = $wishlist['class_name'];
            $class_price = $wishlist['classPrice'];
            $source = $wishlist['source'];
            $destination = $wishlist['destination'];
            $gate = $wishlist['gate'];
            $flight_date = $wishlist['flight_date'];
            $departure_time = $wishlist['departure_time'];
            $arrival_time = $wishlist['arrival_time'];
            $triptypeId = $wishlist['triptypeId'];
            $triptype_name = $wishlist['triptype_name'];
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

                                <input type='hidden' name='flight_id' value='{$wishlist['flight_id']}'>
                                <input type='hidden' name='class_id' value='{$wishlist['class_id']}'>
                                <input type='hidden' name='triptypeId' value='{$wishlist['triptypeId']}'>
                                <input type='hidden' name='fee_per_ticket' value='{$wishlist['fee_per_ticket']}'>
                                <input type='hidden' name='base_fees' value='{$wishlist['base_fees']}'>
                                <input type='hidden' name='priceCharge' value='{$wishlist['priceCharge']}'>



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

                                <input type='hidden' name='flight_id' value='{$wishlist['flight_id']}'>
                                <input type='hidden' name='class_id' value='{$wishlist['class_id']}'>
                                <input type='hidden' name='triptypeId' value='{$wishlist['triptypeId']}'>
                                <input type='hidden' name='fee_per_ticket' value='{$wishlist['fee_per_ticket']}'>
                                <input type='hidden' name='base_fees' value='{$wishlist['base_fees']}'>
                                <input type='hidden' name='priceCharge' value='{$wishlist['priceCharge']}'>
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

                                <input type='hidden' name='flight_id' value='{$wishlist['flight_id']}'>
                                <input type='hidden' name='class_id' value='{$wishlist['class_id']}'>
                                <input type='hidden' name='triptypeId' value='{$wishlist['triptypeId']}'>
                                <input type='hidden' name='fee_per_ticket' value='{$wishlist['fee_per_ticket']}'>
                                <input type='hidden' name='base_fees' value='{$wishlist['base_fees']}'>
                                <input type='hidden' name='priceCharge' value='{$wishlist['priceCharge']}'>
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

                                <input type='hidden' name='flight_id' value='{$wishlist['flight_id']}'>
                                <input type='hidden' name='class_id' value='{$wishlist['class_id']}'>
                                <input type='hidden' name='triptypeId' value='{$wishlist['triptypeId']}'>
                                <input type='hidden' name='fee_per_ticket' value='{$wishlist['fee_per_ticket']}'>
                                <input type='hidden' name='base_fees' value='{$wishlist['base_fees']}'>
                                <input type='hidden' name='priceCharge' value='{$wishlist['priceCharge']}'>
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
            <div class="">booked</div>
            <div class="">Available</div>
        </div>
    </div>

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