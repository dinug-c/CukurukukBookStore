<?php
session_start();
require_once("components/header.php");
require_once("services/db.php");
require_once("services/crud.php");
headerComponent("Register - Cukurukuk BookStore");

if(isset($_POST["submit"])){
    $valid = true;
    $username = test_input($_POST['username']);
    if($username == ''){
        $error_username = '<div class="bg-pink-100 text-sm border-pink-400 py-2 px-3 border-2 text-pink-400 rounded-md mb-3">
             
        <p>Username si required</p>
        </div>';
        $valid = false;
    }
    $email = test_input($_POST['email']);
    if($email == ''){
        $error_email = '<div class="bg-pink-100 text-sm border-pink-400 py-2 px-3 border-2 text-pink-400 rounded-md mb-3">
             
        <p>Email si required</p>
        </div>';
        $valid = false;
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error_email = '<div class="bg-pink-100 text-sm border-pink-400 py-2 px-3 border-2 text-pink-400 rounded-md mb-3">
             
        <p>Invalid email format</p>
        </div>';
        $valid = false;
    } elseif(getSingleBy("akun", "Email", $email)){
        $error_email = '<div class="bg-pink-100 text-sm border-pink-400 py-2 px-3 border-2 text-pink-400 rounded-md mb-3">
             
        <p>❌ Email already registered</p>
        </div>';
        $valid = false;
    }
    $password = test_input($_POST['password']);
    if($password == ''){
        $error_password = '<div class="bg-pink-100 text-sm border-pink-400 py-2 px-3 border-2 text-pink-400 rounded-md mb-3">
             
        <p>Password si required</p>
        </div>';
        $valid = false;
    }
    $confirm = test_input($_POST['confirm']);
    if($confirm == ''){
        $error_confirm = '<div class="bg-pink-100 text-sm border-pink-400 py-2 px-3 border-2 text-pink-400 rounded-md mb-3">
             
        <p>Confirmation password si required</p>
        </div>';
        $valid = false;
    }
    elseif($password != $confirm){
        $error_confirm = '<div class="bg-pink-100 text-sm border-pink-400 py-2 px-3 border-2 text-pink-400 rounded-md mb-3">
             
        <p>Password and confirmation password must be same</p>
        </div>';
        $valid = false;
    }
    if($valid){
        $result = createSingle("akun", array(
            "Username" => $username,
            "Email" => $email,
            "Password" => md5($password),
            "Category" => "customer"
        ));
        if(!$result){
            die("Could not query the database: <br/>".$db->error."<br/>Query: ".$query);
        }else{
            $_SESSION['customer'] = $email;
            header('Location: home.php');
        }
        $db->close();
    }
}

?>
<div class="flex items-center justify-center h-full max-h-fit w-screen overflow-clip py-10 backdrop-blur-3xl bg-[#5843BE]">
        <div class="flex flex-col justify-center w-11/12 p-10 bg-white rounded-lg shadow-xl md:w-5/12 h-fit xl:w-2/5">
            <div class="flex flex-col items-center justify-center w-full h-fit">
                <h1 class="text-3xl font-bold from-slate-800 text-transparent to-purple-900 bg-gradient-to-br bg-clip-text">Cukurukuk</h1>
                <p>Bookstore</p>
            </div>
            <form class="mt-5" method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="username" >Username</label></br>
                <input type="text" class="border-[1.5px] border-gray-200 w-full py-2 px-3 rounded-md my-2 focus:outline-none focus:border-transparent focus:ring-[1.5px] focus:ring-[#5843BE]" id="username" placeholder="Hermoine Granger" size="30" name="username" value="<?php if(isset($username)) echo $username; ?>">
                <span class="error"><?php if(isset($error_username)) echo $error_username; ?></span>
            </div>
            <div class="form-group">
                <label for="email" >Email</label></br>
                <input type="email" class="border-[1.5px] border-gray-200 w-full py-2 px-3 rounded-md my-2 focus:outline-none focus:border-transparent focus:ring-[1.5px] focus:ring-[#5843BE]" id="email" placeholder="example@gmail.com" size="30" name="email" value="<?php if(isset($email)) echo $email; ?>">
                <span class="error"><?php if(isset($error_email)) echo $error_email; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label></br>
                <input type="password" class="border-[1.5px] border-gray-200 w-full py-2 px-3 rounded-md my-2 focus:outline-none focus:border-transparent focus:ring-[1.5px] focus:ring-[#5843BE]" id="password" placeholder="Enter password" name="password" value="">
                <span class="error"><?php if(isset($error_password)) echo $error_password; ?></span>
            </div>
            <div class="form-group">
                <label for="confirm">Password Confirmation</label></br>
                <input type="password" class="border-[1.5px] border-gray-200 w-full py-2 px-3 rounded-md my-2 focus:outline-none focus:border-transparent focus:ring-[1.5px] focus:ring-[#5843BE]" id="confirm" placeholder="Enter password confirmation" name="confirm" value="">
                <span class="error"><?php if(isset($error_confirm)) echo $error_confirm; ?></span>
            </div>
           <?php if(isset($error_toast)) echo $error_toast; ?>
</br>
            <button type="submit" class="bg-yellow-400 px-5 py-3 font-semibold w-full rounded-md hover:shadow-lg hover:shadow-yellow-200 transition-all" name="submit" value="submit">Register</button>
        </form>
        <p class="text-sm mx-auto">Sudah punya akun? <a href="login.php" class="text-yellow-500 font-semibold">Login</a></p>
        </div>
    </div>
<?php
require_once("components/footer.php");
?>