<?php
/* This is the signup php file. The goal if for a new/existing patient
to sign up for an account username and password.
*/

# Start the session
ob_start();
session_start();

?>

<!------------- HTML ------------->
<!DOCTYPE html>
<html>

<head>
  <title>Signup Page</title>
  <link href="../css/login.css" rel='stylesheet'>
  <script src="../js/effects.js"></script>
</head>

<body>

  <h2>My Health Patient Portal Signup Page</h2>
  <p> Please have your Patient ID ready! </p>
  <section class="signup_area" id="signup_area">
  <form class="form-signup" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
      <input type="text" class="form-signup" name="pid" placeholder="Patient ID" required></br></br>
      <input type="text" class="form-signup" name="name_first" placeholder="First Name" required></br></br>
      <input type="text" class="form-signup" name="name_last" placeholder="Last Name" required></br></br>
      <input type="text" class="form-signup" name="username" placeholder="username" required></br></br>
      <input type="password" class="form-control" name="password" placeholder="password" required>
      <input type="password" class="form-control" name="retype_password" placeholder="retype password" required>
      <button class="submit-button" type="submit" name="submit">submit
        <!-- If the submit button is pushed, we need to process the data. If successfull we need to redirect to the patient portal -->
        <?php if(isset($_POST['submit']))
          $msg = '';
        {
          // Process the form information, but first make sure nothing is empty
          if(!empty($_POST['pid']) && !empty($_POST['name_first']) && !empty($_POST['name_last']) && !empty($_POST['password']) && !empty($_POST['retype_password']))
          {
            // Now we check if the password files match. Strip whitespace first
            if(trim($_POST['password']) == trim($_POST['retype_password']))
            {
              // passwords match yay, lets process !
              $pid = trim($_POST['pid']);
              $name_first = trim($_POST['name_first']);
              $name_last = trim($_POST['name_last']);
              $password = trim($_POST['password']);

              // We retrieve and update data based in the PID, for now let's print it to the screen
             $msg = "$pid, $name_first, $name_last, $password";
            }
            else
            {
              $msg = "password field did not match! Please try again!";
            }
          }
          else
          {
            $msg = "One or more fields are empty! Please try again!";
          }
        } 
        ?>
        </button>
    </form>
  </section>
  <?php echo "$msg" ?>
  <?php $conn->close(); ?>
</body>

</html>