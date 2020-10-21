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
  <link href="css/login.css" rel='stylesheet'>
  <script src="js/effects.js"></script>
  <!--- SOURCE: https://www.w3schools.com/php/php_includes.asp --->
</head>

<body>

  <h2>My Health Patient Portal Login Page</h2>

  <section class="login_area" id="login_area">
    <h2>Enter Username and Password</h2>
    <div class="container form-signin">

      <?php
      $msg = '';

      if (
        isset($_POST['login']) && !empty($_POST['username'])
        && !empty($_POST['password'])
      ) {

        if (
          # For now we put the username and password here. Later we can check it against a database
          $_POST['username'] == 'doctor' &&
          $_POST['password'] == 'doctor'
        ) {
          $_SESSION['valid'] = true;
          $_SESSION['timeout'] = time();
          $_SESSION['username'] = 'tutorialspoint';

          echo 'You have entered valid use name and password';
          # Send us to the desired page, ideally in prod this should be a link address
          header('Location: php/healthcare_worker_portal.php');
        }
        else if (
          # For now we put the username and password here. Later we can check it against a database
          $_POST['username'] == 'patient' &&
          $_POST['password'] == 'patient'
        )
        {
          $_SESSION['valid'] = true;
          $_SESSION['timeout'] = time();
          $_SESSION['username'] = 'patient';

          echo 'You have entered valid use name and password';
          # Send us to the desired page, ideally in prod this should be a link address
          header('Location: php/patient_portal.php');
        }

        else {
          $msg = 'Wrong username or password';
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
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button>
      </form>

      Click here to clean <a href="php/logout.php" tite="Logout">Session.

    </div>
  </section>

</body>

</html>