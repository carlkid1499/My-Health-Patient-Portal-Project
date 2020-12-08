<?php
/* This is the login php file. Our goal is to have basic
user authentication. User information will ideally be stored
in a database. 
This was derived from this tutorial:
https://www.tutorialspoint.com/php/php_login_example.htm
*/

# Start the session
ob_start();
session_start();

?>

<!------------- HTML ------------->
<!DOCTYPE html>
<html>

<head>
  <title>Login Page</title>
  <link href="../css/welcome.css" rel='stylesheet'>
  <link href="../css/blue_theme.css" rel='stylesheet'>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="js/effects.js"></script>
  <!--- SOURCE: https://www.w3schools.com/php/php_includes.asp --->
</head>

<div class="w3-bar w3-theme-d5">
  <button class="w3-bar-item w3-button">Home</button>
  <button class="w3-bar-item w3-button">Button</button>
  <button class="w3-bar-item w3-button">Button</button>
</div>

<div class="header w3-theme-d2">
    
        <h1><b>My Health Patient Portal</b></h1>
    
</div>

<body>

  <h2>My Health Patient Portal Login</h2>

  <section class="login_area" id="login_area">
  <div class="center">
    <h3>Enter Username and Password</h3>
    <div class="container form-signin">

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
            header('Location: healthcare_worker_portal.php');
          }
          else
          {
            // Error
            $msg = "Something went wrong please try again! If the error continues contact support@support.com";
          }
        }
      }
      ?>
    </div> <!-- /container -->

    <div class="container">

      <form class="form-signin" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
        <h4 class="form-signin-heading"><?php echo $msg; ?></h4>
        <input type="text" class="form-control" name="username" placeholder="username" required autofocus></br>
        <input type="password" class="form-control" name="password" placeholder="password" required>
        <button id="btnlogin" type="submit" name="login">Login</button>
      </form>

      <!-- Let's put any actions the user can take. i.e update info, view records, etc -->
    <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
      <button id="btnsignup" type="submit" name="signup">signup
        <!-- If the logout button is pushed -->
        <?php if(isset($_POST['signup']))
        {
          header('Location: php/signup.php');
        } 
        ?>
        </button>
    </form>
    </div>
  </div>
  </section>
</body>

</html>