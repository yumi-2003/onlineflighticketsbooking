<?php
require_once 'dbconnect.php';

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $adInfo = getAdminInfo($id);
}

function getAdminInfo($adID)
{
    global $conn;
    $sql = 'SELECT * FROM admin WHERE admin_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->execute([$adID]);
    $adInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    return $adInfo;
}

if (isset($_POST['editProfile'])) {
    $ad_id = $_POST['admin_id'];
    $ad_email = $_POST['admin_email'];
    $ad_uname = $_POST['admin_uname'];
    $filename = $_FILES['profile']['name'];
    $uploadPath = "../userPhoto/. $filename";
    move_uploaded_file($_FILES['profile']['tmp_name'], $uploadPath);

    try {

        $sql = 'Update admin set admin_email = :email, admin_uname = :uname, profile =:profile where admin_id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $ad_email);
        $stmt->bindParam(':uname', $ad_uname);
        $stmt->bindParam(':profile', $uploadPath);
        $stmt->bindParam(':id', $ad_id);
        $status = $stmt->execute();

        if ($status) {
            $_SESSION['updateAdminProfile'] = "Admin information has been updated";
            $_SESSION['adName'] = $_POST['admin_uname'];
            $_SESSION['adEmail'] = $_POST['admin_email'];
            header("Location:admindashboard.php");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

$sql = "SELECT * FROM admin";
try {
   $stmt = $conn->prepare($sql);
   $stmt->execute();
   $admin = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
   echo $e->getMessage();
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="./output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f2f1ef]">

    <!-- nav starts -->
    <nav class="fixed top-0 z-50 w-full bg-[#00103c]">
        <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto p-4">
            <a href="" class="flex items-center space-x-3 rtl:space-x-reverse">
                <!-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" /> -->
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">SwiftMiles</span>
            </a>

            <div class="flex items-center md:order-2 space-x-1 md:space-x-2 rtl:space-x-reverse">
                <?php

                if (isset($_SESSION['isLoggedIn'])) {
                ?>
                    <div class="flex items-center">
                        <div class="flex items-center ms-3">
                            <div>
                                <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user" id="dropdownUser">
                                    <span class="sr-only">Open user menu</span>
                                    <!-- admin profile -->
                                    <img class="w-8 h-8 rounded-full" src="<?php echo $admin['profile'] ?>" alt="admin photo">

                                </button>
                            </div>

                            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                                <div class="px-4 py-3" role="none">
                                    <p class="text-sm text-gray-900 dark:text-white" role="none">
                                        <?php
                                        echo $admin['admin_uname'];
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
                                        <a href="editProfile.php?id=<?php echo $admin['admin_id']; ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Edit Profile</a>

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

    <!-- edit form starts -->
    <section class="py-20 my-auto ">
        <div class="lg:w-[80%] md:w-[50%] xs:w-[96%] mx-auto flex gap-4 ">
            <div
                class="lg:w-[50%] md:w-[50%] sm:w-[50%] xs:w-full mx-auto shadow-2xl p-4 rounded-xl h-fit self-center bg-neutral-800">
                <!--  -->
                <div class="">
                    <h1
                        class="lg:text-3xl md:text-2xl sm:text-xl xs:text-xl font-serif font-extrabold mb-2 text-white">
                        Edit Profile
                    </h1>
                    <h2 class="text-grey text-sm mb-4 dark:text-gray-400">Edit Profile</h2>

                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="admin_id" value="<?php
                                                                    if (isset($adInfo['admin_id'])) {
                                                                        echo $adInfo['admin_id'];
                                                                    }
                                                                    ?> " />
                        <!-- Profile Image -->
                        <div
                            class="mx-auto flex justify-center w-[141px] h-[141px] bg-blue-300/20 rounded-full  bg-cover bg-center bg-no-repeat">

                            <div class="bg-white/90 rounded-full w-6 h-6 text-center ml-28 mt-4">

                                <input type="file" name="profile" id="upload_profile" hidden>

                                <label for="upload_profile">
                                    <svg data-slot="icon" class="w-6 h-5 text-blue-700" fill="none"
                                        stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z">
                                        </path>
                                    </svg>
                                </label>
                            </div>
                        </div>

                </div>
                <h2 class="text-center mt-1 font-semibold dark:text-gray-300">Upload Profile
                </h2>
                <div class="flex lg:flex-row md:flex-col sm:flex-col xs:flex-col gap-2 justify-center w-full">
                    <div class="w-full  mb-4 mt-6">
                        <label for="" class="mb-2 dark:text-gray-300">Admin Name</label>
                        <input type="text" name="admin_uname"
                            class="mt-2 p-4 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                            placeholder="Name">
                    </div>
                    <div class="w-full  mb-4 mt-6">
                        <label for="" name="admin_email" class=" dark:text-gray-300">Email</label>
                        <input type="email"
                            name="admin_email"
                            class="mt-2 p-4 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                            placeholder="Email">
                    </div>
                </div>
                <div class="w-full rounded-lg bg-blue-500 mt-4 text-white text-lg font-semibold">
                    <button type="submit" name="editProfile" class="w-full p-4">Update</button>
                </div>
                </form>
            </div>
        </div>
        </div>
    </section>
</body>

</html>