<?php

        require_once 'dbconnect.php';

        if(!isset($_SESSION)){
            session_start();
        }

        if(isset($_POST['login']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

            $username = $_POST['admin_uname'];
            $email = $_POST['admin_email'];
            $password = $_POST['admin_pwd'];

            if(empty($username) || empty($email) || empty($password)){
                echo "<script>alert('All fields are required')</script>";
            }

            else if(strlen($password) < 7){
                $password_error = "Password must be at least 7 characters long";
            } 
            
            else {
                try{
                    $sql = "SELECT * FROM admin WHERE admin_email = ?";

                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$email]);
                    $info = $stmt->fetch(PDO::FETCH_ASSOC);

                    if($info){
                        $password_hash = $info['admin_pwd'];

                        if(password_verify($password, $password_hash)){
                            
                            $_SESSION['adminLoginSuccess'] = 'Admin login successful';
                            $_SESSION['isLoggedIn'] = true;

                            header('Location: admindashboard.php');
                            exit();
                        } else {
                            $password_error = "There is no account with this credentials";
                        }
                    } else {
                        $password_error = "Email or Password might be wrong";
                    }
                } catch(PDOException $e){
                    echo "Error: " . $e->getMessage();
                }
            }
        }


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        <script src="https://cdn.tailwindcss.com"></script>
       
    </head>
    <body>


        <!-- nav starts -->
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
                </div>
            </div>
        </nav>
        <!-- nav ends -->

        <!-- Login Page -->
        <div class="flex justify-center items-center  font-[sans-serif] h-full md:min-h-screen p-4 mt-16">
            <div class="grid justify-center max-w-md mx-auto">
                <div>
                <img src="/images/plane.jpg" class="w-full object-cover rounded-2xl" alt="login-image" />
                </div>

                <form class="bg-gray-50 rounded-2xl p-6 -mt-24 relative z-10" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-12">
                        <h3 class="text-3xl font-extrabold text-blue-600">Admin Log in</h3>
                    </div>

                    <div class="mt-1">
                        <div class="relative flex items-center">
                        <input name="admin_uname" type="text" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="User Name" />
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" viewBox="0 0 24 24" stroke-width="1.5" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>

                        </div>
                    </div>

                    <div class="relative flex items-center mt-6">
                        <input name="admin_email" type="text" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Enter email" />
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2" viewBox="0 0 682.667 682.667">
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

                    <div class="mt-6">
                        <div class="relative flex items-center">
                        <input name="admin_pwd" type="password" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Enter password" />
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2 cursor-pointer" viewBox="0 0 128 128">
                            <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" data-original="#000000"></path>
                        </svg>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-4 mt-6">
                        <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                        <label for="remember-me" class="text-gray-800 ml-3 block text-sm">
                            Remember me
                        </label>
                        </div>
                        <div>
                        <a href="jajvascript:void(0);" class="text-blue-600 text-sm font-semibold hover:underline">
                            Forgot Password?
                        </a>
                        </div>
                    </div>

                    <div class="mt-12">
                        <button type="submit" name="login" class="w-full py-2.5 px-4 text-sm font-semibold tracking-wider rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                        Log in
                        </button>

                        <p class="text-sm text-center mt-6">if You are not a member <a href="javascript:void(0);" class="text-blue-600 font-semibold hover:underline ml-1 whitespace-nowrap">Register here</a></p>
                    </div>

                    
                    </div>
                </form>
            </div>
    </div>


    </body>
</html>