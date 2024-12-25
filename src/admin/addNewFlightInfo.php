<?php
        require_once "dbconnect.php";


        try{
            $sql = "select * from airline";
            $stmt = $conn->query($sql);
            $airlines = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        
        if(isset($_POST['insert'])){

            $airname = $_POST['airline_id'];
            $fname = $_POST['flight_name'];
            $date = $_POST['flight_date'];
            $des = $_POST['destination'];
            $ori = $_POST['source'];
            $tdistance = $_POST['total_distance'];
            $price = $_POST['fee_per_ticket'];
            $deptime = $_POST['departure_time'];
            $arrtime = $_POST['arrival_time'];
            $cap = $_POST['capacity'];
            $rerseat = $_POST['seats_researved'];
            $avaseat = $_POST['seats_available'];
            $gate = $_POST['gate'];

            $filename = $_FILES['placeImg']['name'];
            $uploadPath = "../flightImg/".$filename;
            move_uploaded_file($_FILES['placeImg']['tmp_name'], $uploadPath);

            
            try{
                $sql = "INSERT INTO flight (airline_id,flight_name,flight_date,destination,source,total_distance,fee_per_ticket,departure_time,arrival_time,capacity,seats_researved,seats_available,gate,placeImg) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $status = $stmt->execute([$airname,$fname,$date,$des,$ori,$tdistance,$price,$deptime,$arrtime,$cap,$rerseat,$avaseat,$gate,$uploadPath]);
                $flightId = $conn->lastInsertId();


                if($status){
                    header("Location:viewFlight.php");
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
        <title>Document</title>
        <link href="./output.css" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>

       <!-- nav stars -->
   <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
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
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-3" alt="FlowBite Logo" />
            <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">SwiftMiles</span>
         </a>
         </div>

         <div class="flex items-center">
            <div class="flex items-center ms-3">
               <div>
                  <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user" id="dropdownUser">
                     <span class="sr-only">Open user menu</span>
                     <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
                  </button>
               </div>

               <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
               <div class="px-4 py-3" role="none">
                  <p class="text-sm text-gray-900 dark:text-white" role="none">
                     Neil Sims
                  </p>
                  <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                     neil.sims@flowbite.com
                  </p>
               </div>
               <ul class="py-1" role="none">
                  <li>
                     <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Dashboard</a>
                  </li>
                  <li>
                     <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Settings</a>
                  </li>
                  <li>
                     <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Earnings</a>
                  </li>
                  <li>
                     <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Sign out</a>
                  </li>
               </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
   </nav>


        
        <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" class="mt-16">
            <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-3">
                <div>
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Select Airline</label>
                    <select name="airline_id" class="bg-gray-50 border border-gray-300 dark:text-gray text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Choose Airline</option>
                        <?php
                            if(isset($airlines)){
                                foreach($airlines as $airline){
                                    echo "<option value = $airline[airline_id]>$airline[airline_name]</option>";
                                }
                            }

                        ?>
                    </select>
                </div>
                <div>
                    <label for="flight_name" class="block mb-2 text-sm font-medium dark:text-gray dark:text-gray">Flight Name</label>
                    <input type="text" name="flight_name" class=" bg-gray-50 border border-gray-300 dark:text-gray text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Flight Name" required />
                </div>
                
                <div>
                    <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Date</label>
                    <input type="date" name="flight_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date" required />
                </div>  
                
                <div>
                    <label for="des" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Destination</label>
                    <input type="text" name="destination" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Destination" required />
                </div>
                <div>
                    <label for="source" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Source</label>
                    <input type="text" name="source" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Origin" required />
                </div>
                
                <div>
                    <label for="tdistance" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Total Distance</label>
                    <input type="text" name="total_distance" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Total Distance in kilometer" required />
                </div>
                <div>
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Fee Per Tickets</label>
                    <input type="number" min="0" name="fee_per_ticket" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Price Per Tickets" required />
                </div>
                
                <div>
                    <label for="deptime" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Departure Time</label>
                    <input type="time" name="departure_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Departure Time" required />
                </div>
                <div>
                    <label for="arrtime" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Arrival Time</label>
                    <input type="time" name="arrival_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Arrival Time" required />
                </div>

                <div>
                    <label for="gateName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Gate</label>
                    <input type="text" name="gate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="gate" required />
                </div>
               
                <div>
                    <label for="cap" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Capacity</label>
                    <input type="number" min="0" name="capacity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Capacity" required />
                </div>
               
                <div>
                    <label for="avaseats" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Available Seats</label>
                    <input type="number" min="0" name="seats_available" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Available Seats" required />
                </div>

                <div>
                    <label for="reseats" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Reserved Seats</label>
                    <input type="number" min="0" name="seats_researved" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Reserved Seats" required />
                </div>
               
                <div>
                    <label for="avaseats" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray">Photo</label>
                    <input type="file" name="placeImg" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Available Seats" required />
                </div>
            </div>
           
            <button type="sumbit" name="insert" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Flight Schedule</button>
        </form>

    </body>
</html>