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

            $airname = $_POST['airline_name'];
            $photo = $_FILES['photo']['name'];
            $uploadPath = "../flightImg/".$photo;
            move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath);

            
            try{
                $sql = "INSERT INTO airline (airline_name,photo) VALUES (?,?)";
                $stmt = $conn->prepare($sql);
                $status = $stmt->execute([$airname,$uploadPath]);
                $airline = $conn->lastInsertId();


                if($status){
                    header("Location:viewAirline.php");
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
        
        <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" class="m-auto mt-16 w-60">
            <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-1">
                
                <div>
                    <label for="airlineName" class="block mb-2 text-sm font-medium dark:text-gray dark:text-gray">Airline Name</label>
                    <input type="text" name="airline_name" class=" bg-gray-50 border border-gray-300 dark:text-gray text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-cyan-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Airline Name" required />
                </div>
                

                <label for="uploadFile"
                    class="bg-white text-center rounded w-full max-w-sm min-h-[180px] py-4 px-4 flex flex-col items-center justify-center cursor-pointer border-2 border-gray-300 mx-auto font-[sans-serif]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 mb-3 fill-gray-400" viewBox="0 0 24 24">
                        <path
                        d="M22 13a1 1 0 0 0-1 1v4.213A2.79 2.79 0 0 1 18.213 21H5.787A2.79 2.79 0 0 1 3 18.213V14a1 1 0 0 0-2 0v4.213A4.792 4.792 0 0 0 5.787 23h12.426A4.792 4.792 0 0 0 23 18.213V14a1 1 0 0 0-1-1Z"
                        data-original="#000000" />
                        <path
                        d="M6.707 8.707 11 4.414V17a1 1 0 0 0 2 0V4.414l4.293 4.293a1 1 0 0 0 1.414-1.414l-6-6a1 1 0 0 0-1.414 0l-6 6a1 1 0 0 0 1.414 1.414Z"
                        data-original="#000000" />
                    </svg>
                    <p class="text-gray-400 font-semibold text-sm">Drag & Drop or <span class="text-[#007bff]">Choose Airline Photo</span> to
                        upload</p>
                    <input type="file" id='uploadFile' name="photo" class="hidden" />
                </label>
           
            <button type="sumbit" name="insert" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add New Airline</button>
        </form>

    </body>
</html>