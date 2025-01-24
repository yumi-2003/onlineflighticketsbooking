<?php

require_once 'dbconnect.php';

if (!isset($_SESSION)) {
    session_start();
}

function ispwdstrong($password)
{
    if (strlen($password) < 8) {
        return false;
    } else if (isstrong($password)) {
        return true;
    } else {
        return false;
    }
}

function isstrong($password)
{
    $digitCount = 0;
    $capitalCount = 0;
    $specialCount = 0;
    $lowerCount = 0;

    foreach (str_split($password) as $char) {
        if (is_numeric($char)) {
            $digitCount++;
        } elseif (ctype_upper($char)) {
            $capitalCount++;
        } elseif (ctype_lower($char)) {
            $lowerCount++;
        } elseif (ctype_punct($char)) {
            $specialCount++;
        }
    }

    if ($digitCount > 0 && $capitalCount > 0 && $specialCount > 0 && $lowerCount > 0) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['signup']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $filename = $_FILES['profile']['name'];
    $uploadPath = '../userPhoto/' . $filename;

    if ($password == $cpassword) {
        if (ispwdstrong($password)) {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            move_uploaded_file($_FILES['profile']['tmp_name'], $uploadPath);

            try {
                $sql = "INSERT INTO users (username,email,password,profile) VALUES (?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $status = $stmt->execute([$username, $email, $password_hash, $uploadPath]);

                if ($status) {
                    $user_id = $conn->lastInsertId();

                    $_SESSION['users'] = [
                        'user_id' => $user_id,
                        'username' => $username
                    ];
                    $_SESSION['signUpSuccess'] = 'Sign Up Successful';
                    header('Location: cLogin.php');
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Password is not strong enough";
        }
    } else {
        echo "Password does not match";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Sign Up</title>
    <link href="./output.css" rel="stylesheet">
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
                                        <a href="aboutUs.php" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                                            About Us
                                        </a>
                                    </li>
                                    <li>
                                        <a href="contactUs.php" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
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

    <!-- Login Page -->

    <div class="font-[sans-serif] bg-white min-h-screen flex items-center justify-center p-6 mt-16">
        <div class="w-full max-w-2xl bg-white shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-xl overflow-hidden">
            <!-- Form Section -->
            <form class="w-full py-8 px-6 sm:px-12" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" method="POST">
                <div class="mb-8">
                    <h3 class="text-gray-800 text-3xl font-bold">Create an account</h3>
                </div>

                <div class="space-y-6">
                    <!-- Name Field -->
                    <div>
                        <label class="text-gray-600 text-sm font-medium mb-2 block">Name</label>
                        <div class="relative flex items-center">
                            <input name="username" type="text" required class="w-full text-sm px-4 py-3 rounded-md border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition duration-200" placeholder="Enter name" />
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-4 h-4 absolute right-4" viewBox="0 0 24 24">
                                <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                                <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z" data-original="#000000"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label class="text-gray-600 text-sm font-medium mb-2 block">Email</label>
                        <div class="relative flex items-center">
                            <input name="email" type="email" required class="w-full text-sm px-4 py-3 rounded-md border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition duration-200" placeholder="Enter email" />
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-4 h-4 absolute right-4" viewBox="0 0 682.667 682.667">
                                <defs>
                                    <clipPath id="a" clipPathUnits="userSpaceOnUse">
                                        <path d="M0 512h512V0H0Z" data-original="#000000"></path>
                                    </clipPath>
                                </defs>
                                <g clip-path="url(#a)" transform="matrix(1.33 0 0 -1.33 0 682.667)">
                                    <path fill="none" stroke-miterlimit="10" stroke-width="40" d="M452 444H60c-22.091 0-40-17.909-40-40v-39.446l212.127-157.782c14.17-10.54 33.576-10.54 47.746 0L492 364.554V404c0 22.091-17.909 40-40 40Z" data-original="#000000"></path>
                                    <path d="M472 274.9V107.999c0-11.027-8.972-20-20-20H60c-11.028 0-20 8.973-20 20V274.9L0 304.652V107.999c0-33.084 26.916-60 60-60h392c33.084 0 60 26.916 60 60v196.653Z" data-original="#000000"></path>
                                </g>
                            </svg>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label class="text-gray-600 text-sm font-medium mb-2 block">Password</label>
                        <div class="relative flex items-center">
                            <input name="password" type="password" id="pwd" required class="w-full text-sm px-4 py-3 rounded-md border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition duration-200" placeholder="Enter password" />
                            <svg xmlns="http://www.w3.org/2000/svg" onclick="showPwd()" fill="#bbb" stroke="#bbb" class="w-4 h-4 absolute right-4 cursor-pointer" viewBox="0 0 128 128">
                                <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" data-original="#000000"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label class="text-gray-600 text-sm font-medium mb-2 block">Confirm Password</label>
                        <div class="relative flex items-center">
                            <input name="cpassword" type="password" id="cpwd" required class="w-full text-sm px-4 py-3 rounded-md border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition duration-200" placeholder="Confirm password" />
                            <svg xmlns="http://www.w3.org/2000/svg" onclick="cshowPwd()" fill="#bbb" stroke="#bbb" class="w-4 h-4 absolute right-4 cursor-pointer" viewBox="0 0 128 128">
                                <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" data-original="#000000"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label class="text-gray-600 text-sm font-medium mb-2 block">Upload Profile</label>
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none transition duration-200" id="file_input" type="file" name="profile" />
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" required/>
                        <label for="remember-me" class="ml-3 block text-sm text-gray-600">
                            I accept the <a href="javascript:void(0);" class="text-blue-600 font-semibold hover:underline ml-1">Terms and Conditions</a>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit" name="signup" class="w-full px-4 py-3 text-sm font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                        Create an account
                    </button>
                </div>

                <!-- Login Link -->
                <p class="text-gray-600 text-sm mt-6 text-center">Already have an account? <a href="javascript:void(0);" class="text-blue-600 font-semibold hover:underline ml-1">Login here</a></p>
            </form>
        </div>
    </div>

    <script>
        const firstPwd = document.getElementById('pwd');
        const confirmPwd = document.getElementById('cpwd');

        function showPwd() {
            if (firstPwd.type === 'password') {
                firstPwd.type = 'text';
            } else {
                firstPwd.type = 'password';
            }
        }

        function cshowPwd() {
            if (confirmPwd.type === 'password') {
                confirmPwd.type = 'text';
            } else {
                confirmPwd.type = 'password';
            }
        }

        
    </script>

</body>

</html>