<?php

        require_once 'dbconnect.php';

        if(!isset($_SESSION)){
            session_start();
        }

        if(isset($_POST['login']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

            
            $email = $_POST['email'];
            $password = $_POST['password'];
            

            if(strlen($password) > 7){
                try{
                    $sql = "SELECT * FROM users WHERE email = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$email]);
                    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

                    if($userInfo){
                        $password_hash = $userInfo['password'];
                        
                        if(password_verify($password,$password_hash)){
                            $_SESSION['userLoginSuccess'] = 'Login Successful';
                            $_SESSION['userEmail'] = $email;
                            $_SESSION['userPhoto'] = $filename;
                            $_SESSION['userisLoggedIn'] = true;
                            header('Location: index.php');
                        }else{
                            $password_err =  "Invalid email or password";
                        }
                    }else{
                        $password_err =  "Invalid email or password";
                    }
                }catch(PDOException $e){
                    echo $e->getMessage();
                }

            }

        }else{
            $password_err =  "Invalid email or password";
        }




?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Customer Login</title>
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
        
        <div class="font-[sans-serif] mt-10">
            <div class="min-h-screen flex fle-col items-center justify-center py-6 px-4">
                <div class="grid md:grid-cols-2 items-center gap-4 max-w-6xl w-full">
                <div class="border border-gray-300 rounded-lg p-6 max-w-md shadow-[0_2px_22px_-4px_rgba(93,96,127,0.2)] max-md:mx-auto">

                    <form class="space-y-4" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="mb-8">
                        <h3 class="text-gray-800 text-3xl font-extrabold">Login in</h3>
                        <p class="text-gray-500 text-sm mt-4 leading-relaxed">Sign in to your account and explore a world of possibilities. Your journey begins here.</p>
                    </div>

                    <div>
                        <label class="text-gray-800 text-sm mb-2 block">Email</label>
                        <div class="relative flex items-center">
                        <input name="email" type="email" required class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" placeholder="Enter user name" />
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4" viewBox="0 0 24 24">
                            <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                            <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z" data-original="#000000"></path>
                        </svg>
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-800 text-sm mb-2 block">Password</label>
                        <div class="relative flex items-center">
                        <input name="password" type="password" required class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" id="pwd" placeholder="Enter password" />
                        <svg xmlns="http://www.w3.org/2000/svg" onclick="showPwd()" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4 cursor-pointer" viewBox="0 0 128 128">
                            <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" data-original="#000000"></path>
                        </svg>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                        <label for="remember-me" class="ml-3 block text-sm text-gray-800">
                            Remember me
                        </label>
                        </div>

                        <div class="text-sm">
                        <a href="jajvascript:void(0);" class="text-blue-600 hover:underline font-semibold">
                            Forgot your password?
                        </a>
                        </div>
                    </div>

                    <div class="!mt-8">
                        <button type="submit" name="login" class="w-full shadow-xl py-3 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                        Log in
                        </button>
                    </div>

                    <p class="text-sm !mt-8 text-center text-gray-800">Don't have an account <a href="cSignUp.php" class="text-blue-600 font-semibold hover:underline ml-1 whitespace-nowrap">Register here</a></p>
                    </form>
                </div>
                <div class="lg:h-[400px] md:h-[300px] max-md:mt-8">
                    <img src="/images/signup. Vector illustration for poster, banner_" class="w-full h-full max-md:w-4/5 mx-auto block object-cover" alt="Dining Experience" />
                </div>
                </div>
            </div>
    </div>

    <script>
        function showPwd(){
            const pwd = document.getElementById('pwd');
            if(pwd.type === 'password'){
                pwd.type = 'text';
            }else{
                pwd.type = 'password';
            }
            
        }
    </script>

    </body>
    
</html>