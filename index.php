<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//    Seb@1234 johnshelby392@gmail.com
$showAlert = false;
$showError = false;
$exists = false;
require 'partials/dbconnect.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordc = $_POST["passwordc"];
    $exists=false;
    $existSql="select * from users where username='$username'";
    $result = mysqli_query($conn,$existSql);

    $rowExists=mysqli_num_rows($result);
    if($rowExists>0){
        $exists=true;
        $showError = " This username is alerady exists";
    }
    else{
        if(($password == $passwordc &&  $exists==false)){
            $random_id = rand(time(), 100000000);
            $hash= password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users`( `public_key`, `username`, `email`, `password`) VALUES ('$random_id','$username','$email','$hash');";
            $result = mysqli_query($conn,$sql);
            if($result){ 
                $showAlert = true;   
                session_start();
                     $sql = "Select * from users where username='$username'";
                     $result = mysqli_query($conn, $sql);
                     $data = mysqli_fetch_assoc($result);
                     $_SESSION['public_key'] = $data['public_key'];
                     $public_key = $data['public_key'];
                     $to = $data['email'];
                     $otp = $random_id = mt_rand(111111, 999999);
                     $sql2 = "UPDATE `users` SET `otp`=$otp WHERE public_key = $public_key;";
                     $result2 = mysqli_query($conn,$sql2);
                     include 'sendotp.php';
                       sendotp($to,$otp);
                     header("location: verifyotp.php"); 
            }
        }
        else{    
            $showError = "Password and confirm password do not match";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup </title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/alert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
</head>
<style>
    .foot{
    margin: 10px;
    text-decoration: none;
}
</style>
<body>
<?php
if($showError){
    echo '<div class="alert error">
        <input type="checkbox" id="alert1"/>
        <label class="close" title="close" for="alert1">
        <i class="icon-remove"></i>
        </label>
        <p class="inner">
            <strong>Warning! </strong>'.$showError.'
        </p>
        </div>';
}
if($showAlert){
    echo '<div class="alert success">
        <input type="checkbox" id="alert1"/>
        <label class="close" title="close" for="alert1">
        <i class="icon-remove"></i>
        </label>
        <p class="inner">
            <strong> Success </strong> Account has been created successfully! Now you Can login.
        </p>
        </div>';
}

?>

    <div class="container">
        <div class="header">
            <h2>Create Account</h2>
        </div>
        <form id="form" class="form" method="post" action="">
            <div class="form-control">
                <label for="username">Username</label>
                <input type="text" placeholder="" id="username" name="username" required/>             
            </div>
            <div class="form-control">
                <label for="username">Email</label>
                <input type="email" placeholder="" id="email" name="email" required/>                
            </div>
            <div class="form-control">
                <label for="username">Password</label>
                <input type="password" placeholder="" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required/>               
            </div>
            <div class="form-control">
                <label for="username">Password check</label>
                <input type="password" placeholder="re-enter" id="password2" name="passwordc" required/>
            </div>
            <button>Signup</button>
            <div class="foot" id="foot">
                Already Have an Account?
                <a href="login.php">Login Here</a>
            </div>
        </form>
    </div>
</body>
</html>