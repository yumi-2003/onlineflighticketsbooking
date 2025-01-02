<?php
    require_once 'dbconnect.php';

    if(isset($_POST['id'])){
        $id = $_POST['id'];
        $adInfo = getAdminInfo($id);
    }

    function getAdminInfo($adID){
        global $conn;
        $sql = 'SELECT * FROM admin WHERE admin_id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$adID]);
        $adInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        return $adInfo;
    }

    if(isset($_POST['editProfile'])){
        $ad_id = $_POST['admin_id'];
        $ad_email = $_POST['admin_email'];
        $ad_uname = $_POST['admin_uname'];
        $filename = $_FILES['profile']['name'];
        $uploadPath = "../userPhoto/".$filename;
        move_uploaded_file($_FILES['profile']['tmp_name'], $uploadPath);

        try{
            
            $sql = 'Update admin set admin_email = ?, admin_uname = ?, profile =? where admin_id = ?';
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute([$ad_uname,$ad_email, $uploadPath, $ad_id]);

            if($status){
                $_SESSION['updateAdminProfile'] = "Admin information has been updated";
                header("Location:admindashboard.php");
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
        <title>Edit Profile</title>
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
                        <!-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-3" alt="FlowBite Logo" /> -->
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">SwiftMiles</span>
                    </a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- nav ends -->

        <!-- edit form starts -->
        <section class="py-20 my-auto">
            <div class="lg:w-[80%] md:w-[50%] xs:w-[96%] mx-auto flex gap-4">
                <div
                    class="lg:w-[50%] md:w-[50%] sm:w-[50%] xs:w-full mx-auto shadow-2xl p-4 rounded-xl h-fit self-center">
                    <!--  -->
                    <div class="">
                        <h1
                            class="lg:text-3xl md:text-2xl sm:text-xl xs:text-xl font-serif font-extrabold mb-2 dark:text-black">
                            Edit Profile
                        </h1>
                        <h2 class="text-grey text-sm mb-4 dark:text-gray-400">Edit Profile</h2>
                        
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="admin_id" value="<?php echo $adInfo['admin_id'] ?>">
                                <!-- Profile Image -->
                                <div
                                     class="mx-auto flex justify-center w-[141px] h-[141px] bg-blue-300/20 rounded-full  bg-cover bg-center bg-no-repeat">

                                    <div class="bg-white/90 rounded-full w-6 h-6 text-center ml-28 mt-4">

                                        <input type="file" name="profile" id="upload_profile" hidden required>
                                        
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
                                <div class="w-full  mb-4 lg:mt-6">
                                    <label for="" name="admin_email" class=" dark:text-gray-300">Email</label>
                                    <input type="email"
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