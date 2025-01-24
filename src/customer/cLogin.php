<?php

require_once 'dbconnect.php';

if (!isset($_SESSION)) {
    session_start();
}



if (isset($_POST['login']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (strlen($password) > 7) {
        try {
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);
            $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userInfo) {
                $password_hash = $userInfo['password'];
                $profile = $userInfo['profile'];
                $user_id = $userInfo['user_id'];

                if (password_verify($password, $password_hash)) {
                    $_SESSION['users'] = [
                        'user_id' => $user_id
                    ];
                    $_SESSION['userLoginSuccess'] = 'Login Successful';
                    $_SESSION['userEmail'] = $email;
                    $_SESSION['userPhoto'] = $profile;
                    $_SESSION['userisLoggedIn'] = true;
                    header('Location: index.php');
                } else {
                    $password_err =  "Invalid email or password";
                    //echo "<script>alert('Invalid email or password')</script>";
                }
            } else {
                $password_err =  "Invalid email or password";
                echo "<script>alert('Invalid email or password')</script>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
} else {
    $password_err =  "Invalid email or password";
    echo "<script>alert('Invalid email or password')</script>";
}

// if(isset($_SESSION['signUpSuccess'])){
//     var_dump($_SESSION['signUpSuccess']);
// }

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
    

    <!-- Login Page -->
    <div class="font-[sans-serif] mt-10">
        <p>
            <?php
            if (isset($_SESSION['signUpSuccess']) && $_SESSION['signUpSuccess'] === 'Sign Up Successful') {
                
                echo "
            <div class='flex p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 w-56' role='alert'>
                <svg class='flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 20 20'>
                    <path d='M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z'/>
                </svg>
                <div>
                    <span class='font-medium'>WELCOME TO SWIFTMILES</span>
                    <ul class='mt-1.5 list-disc list-inside'>
                        <li>Save 15% OFF for your registration</li>
                        <li>Use PromoCode in your next booking</li>
                        <li>Remember this promocode: <strong>SWIFT10</strong></li>
                    </ul>
                </div>
            </div>
            ";
                
                unset($_SESSION['signUpSuccess']);
            }
            ?>
        </p>

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
                                <input name="email" type="email" required class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" placeholder="Enter your email" />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4" viewBox="0 0 24 24">
                                    <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                                    <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z" data-original="#000000"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Password</label>
                            <div class="relative flex items-center">
                                <input name="password" type="password" required class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" id="pwd" placeholder="Enter your password" />
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
                <div class="lg:h-[500px] md:h-[400px] max-md:mt-8">
                    <img src="/images/booking-hotel-reservation-travel-destination-concept.jpg" class="w-full h-full max-md:w-4/5 mx-auto block object-cover" alt="" />
                </div>
            </div>
        </div>
    </div>

    <script>
        function showPwd() {
            const pwd = document.getElementById('pwd');
            if (pwd.type === 'password') {
                pwd.type = 'text';
            } else {
                pwd.type = 'password';
            }

        }
    </script>

</body>

</html>