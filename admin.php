<?php
session_start();
require_once("components/header.php");
require_once("services/db.php");
require_once("services/crud.php");
headerComponent("Admin Login - Cukurukuk BookStore");

if(isset($_POST["submit"])){
    $valid = true;
    $email = test_input($_POST['email']);
    if($email == ''){
        $error_email = '<div class="bg-pink-100 text-sm border-pink-400 py-2 px-5 border-2 text-pink-400 rounded-md mb-3">
             
        <p>Email si required</p>
        </div>';
        $valid = false;
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error_email = '<div class="bg-pink-100 text-sm border-pink-400 py-2 px-5 border-2 text-pink-400 rounded-md mb-3">
             
        <p>Invalid email format</p>
        </div>';
        $valid = false;
    }
    $password = test_input($_POST['password']);
    if($password == ''){
        $error_password = '<div class="bg-pink-100 text-sm border-pink-400 py-2 px-5 border-2 text-pink-400 rounded-md mb-3">
             
        <p>Password si required</p>
        </div>';
        $valid = false;
    }
    if($valid){
        $result = getSingleMultipleBy("akun", array("Email", "Password", "Category"), array($email, md5($password), "admin"));
        if(!$result){
            die("Could not query the database: <br/>".$db->error."<br/>Query: ".$query);
        }else{
            if($result->num_rows > 0){
                $_SESSION['email'] = $email;
                $_SESSION['category'] = "admin";
                header('Location: view_book.php');
            }else{
                $error_toast = '<div class="bg-pink-100 text-sm border-pink-400 py-2 px-5 border-2 text-pink-400 rounded-md mb-2">
             
                <p>❌ Email or Password Invalid</p>
                </div>';
            }
        }
        $db->close();
    }
}

?>
<div class="flex items-center justify-center w-screen h-screen backdrop-blur-3xl bg-slate-700">
        <div class="flex flex-col justify-center w-11/12 p-10 bg-white rounded-lg shadow-xl md:w-5/12 h-fit xl:w-2/5">
            <div class="flex flex-col items-center justify-center w-full h-fit">
                <h1 class="text-3xl font-bold from-slate-800 text-transparent to-purple-900 bg-gradient-to-br bg-clip-text">Cukurukuk</h1>
                <p>Admin Login</p>
            </div>
            <form class="mt-5" method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="email" >Email</label></br>
                <input type="email" class="border-[1.5px] border-gray-200 w-full py-2 px-5 rounded-md my-2 focus:outline-none focus:border-transparent focus:ring-[1.5px] focus:ring-[#5843BE]" id="email" placeholder="example@gmail.com" size="30" name="email" value="<?php if(isset($email)) echo $email; ?>">
                <span class="error"><?php if(isset($error_email)) echo $error_email; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label></br>
                <input type="password" class="border-[1.5px] border-gray-200 w-full py-2 px-5 rounded-md my-2 focus:outline-none focus:border-transparent focus:ring-[1.5px] focus:ring-[#5843BE]" id="password" placeholder="Enter password" name="password" value="">
                <span class="error"><?php if(isset($error_password)) echo $error_password; ?></span>
            </div>
           <?php if(isset($error_toast)) echo $error_toast; ?>
</br>
            <button type="submit" class="bg-yellow-400 px-5 py-3 font-semibold w-full rounded-md hover:shadow-lg hover:shadow-yellow-200 transition-all" name="submit" value="submit">Login</button>
        </form>
        
        </div>
    </div>
<?php
require_once("components/footer.php");
?>