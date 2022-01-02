<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
  session_start();
  require 'partials/dbconnect.php';
  if(!isset($_SESSION['public_key'])){
    header("location: login.php");
  }
  if($_SERVER["REQUEST_METHOD"] == "GET"){
        $user_id =$_GET['user_id'];
         $sql = mysqli_query($conn, "SELECT * FROM users WHERE public_key = {$user_id}");
         if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
         }else{
            // header("location: main.php");
          }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat Area </title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
  <style>

  </style>
</head>

<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <a href="main.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <div class="details">
          <span>
            <?php echo $row['username'] ?>
          </span>
          <p></p>
        </div>
        <div class="more">
          <i class="fas fa-ellipsis-h dots" id="btn"></i>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
        <input type="text" class="receiver_id" name="receiver_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>

    <div class="modal">
      <div class="btn-box">
        <button class="block" id="report">
          report
        </button>
        <button class="block" id="block">
          block
        </button>
        <button id="close" class="block">
          close
        </button>
      </div>
    </div>
  </div>
  <script>
  
  </script>
  <script src="js/chat.js"></script>
</body>

</html>