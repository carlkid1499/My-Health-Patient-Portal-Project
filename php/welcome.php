<!------------- HTML ------------->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to My Health Portal</title>
    <link href="css/welcome.css" rel='stylesheet'>
    <link href="css/blue_theme.css" rel='stylesheet'>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="js/effects.js"></script>
    <style>

        /* Full-width input fields */
        input[type=text], input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
        }

        /* Set a style for all buttons */
        button {
        background-color: #007183;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        }

        button:hover {
        opacity: 0.8;
        }

        /* Extra styles for the cancel button */
        .cancelbtn {
        width: auto;
        padding: 10px 18px;
        background-color: #f44336;
        }

        /* Center the image and position the close button */
        .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
        position: relative;
        }

        img.avatar {
        width: 40%;
        max-width: 200px;
        border-radius: 50%;
        }

        .container {
        padding: 16px;
        }

        span.psw {
        float: right;
        padding-top: 16px;
        }

        /* The Modal (background) */
        .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        padding-top: 60px;
        }

        /* Modal Content/Box */
        .modal-content {
        background-color: #fefefe;
        margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on screen size */
        max-width: 800px;
        }

        /* The Close Button (x) */
        .close {
        position: absolute;
        right: 25px;
        top: 0;
        color: #000;
        font-size: 35px;
        font-weight: bold;
        }

        .close:hover,
        .close:focus {
        color: red;
        cursor: pointer;
        }

        /* Add Zoom Animation */
        .animate {
        -webkit-animation: animatezoom 0.6s;
        animation: animatezoom 0.6s
        }

        @-webkit-keyframes animatezoom {
        from {-webkit-transform: scale(0)} 
        to {-webkit-transform: scale(1)}
        }
        
        @keyframes animatezoom {
        from {transform: scale(0)} 
        to {transform: scale(1)}
        }

        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {
        span.psw {
            display: block;
            float: none;
        }
        .cancelbtn {
            width: 100%;
        }
        }
</style>

</head>
<body>


<!-- Sidebar -->


<!--main content -->
<div class="w3-bar w3-theme-d5">
  <button class="w3-bar-item w3-button">Home</button>
  <button class="w3-bar-item w3-button">Button</button>
  <button class="w3-bar-item w3-button">Button</button>
</div>

<div class="header w3-theme-d2">
    
        <h1><b>My Health Patient Portal</b></h1>
    
</div>

<div class="content">
    <div class="center">
        <button class="w3-button w3-xlarge w3-round w3-black w3-ripple" 
        onclick="document.getElementById('id01').style.display='block'" style="width:auto;"
            id="btnlogin" type="submit" name="login">Login
                    <!-- If the login button is pushed -->
                    
        </button>
        <button class="w3-button w3-xlarge w3-round w3-black w3-ripple" 
        onclick="document.getElementById('id02').style.display='block'" style="width:auto;"
            id="btnsignup" type="submit" name="signup">Create Account
                <!-- If the signup button is pushed -->
                    <?php if(isset($_POST['signup']))
                    {
                    header('Location: php/signup.php');
                    } 
                    ?>
        </button>
    </div>
</div>

<div class="footer w3-theme-d2 center">
  <p>Created by Carlos, Kiran, and Keller</p>
</div>


<!--modal called to display signup form-->
<div id="id01" class="modal">
  
  <form class="modal-content animate" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="assets/user_icon.png" alt="Avatar" class="avatar">
    </div>

    <div class="container">        
      <?php
      $msg = '';

      if (
        isset($_POST['login']) && !empty($_POST['username'])
        && !empty($_POST['password'])
      ) {

        // Create connection for log in
        $conn = new mysqli("localhost", "myhealth2", "CIOjh^J8h^?b", "myhealth2");
        // Check if connection is valid
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
          $msg = "Connection failed: to DB";
        }

        // Get the information from the forms
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query the users database for the information
        $results = $conn ->query("SELECT * FROM Users WHERE UserName like '%$username%' AND UserPassword like '%$password%' ");

        // If we get a match grant access
        if($results->num_rows >0)
        {
          // Set the Session values to access later
          $_SESSION['valid'] = true;
          $_SESSION['timeout'] = time();
          $_SESSION['username'] = $username;
          $_SESSION['userid'] = NULL;
          $_SESSION['isemployee'] = NULL;
          $_SESSION['pid'] = NULL;

          // Get the Query Results
          while ($row = $results->fetch_assoc()) {
            $_SESSION['userid'] = $row["UserID"];
            $_SESSION['isemployee'] = $row["IsEmployee"];
            $_SESSION['pid'] = $row["PID"];
          }
          // Now we check to see if we have a Patient or Worker
          if($_SESSION['isemployee'] == 0)
          {
            //  We have a Patient
            header('Location: php/patient_portal.php');
          }
          else if ($_SESSION['isemployee'] == 1)
          {
            // We have a Worker
            header('Location: php/healthcare_worker_portal.php');
          }
          else
          {
            // Error
            $msg = "Something went wrong please try again! If the error continues contact support@support.com";
          }
        }
      }
      ?>

      <!-- form for username imput-->
      <form class="form-signin" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
            <h4 class="form-signin-heading"><?php echo $msg; ?></h4>
            <input type="text" class="form-control" name="username" placeholder="username" required autofocus></br>
            <input type="password" class="form-control" name="password" placeholder="password" required>
            <button id="btnlogin" type="submit" name="login">Login</button>
        </form>

        <!-- form for password imput-->
        <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
        </form>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        </div>
    </div>
  </form>
</div>


<!--modal called to display signup form-->
<div id="id02" class="modal">
  
  <form class="modal-content animate" action="/action_page.php" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="assets/user_icon.png" alt="Avatar" class="avatar">
    </div>

    <div class="container">
      <label for="uname"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="uname" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>
        
      <button type="submit">Login</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </form>
</div>

</div>

<script>
    // Get the modal
    var modal = document.getElementById('id01');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    var modal2 = document.getElementById('id02');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal2) {
            modal2.style.display = "none";
        }
    }
</script>

</body>
</html>
