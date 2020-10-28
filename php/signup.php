<?php
/* This is the signup php file. The goal if for a new/existing patient
to sign up for an account username and password.
*/

# Start the session
ob_start();
session_start();
# Declare Global Vars for file
$msg = "";
// Create connection for log in
$conn = new mysqli("localhost", "myhealth2", "CIOjh^J8h^?b", "myhealth2");
// Check if connection is valid
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  $msg = "Connection failed: to DB";
}

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
        <?php if (isset($_POST['submit'])) {
          // Process the form information
          // Now we check if the password files match. Strip whitespace first
          if (trim($_POST['password']) == trim($_POST['retype_password'])) {
            // passwords match yay, lets process !
            $pid = trim($_POST['pid']);
            $name_first = trim($_POST['name_first']);
            $name_last = trim($_POST['name_last']);
            $password = trim($_POST['password']);
            $username = trim($_POST['username']);
            // We retrieve and update data based on the PID, first lets check if the PID is valid
            // Query the PatientInfo database for the information
            $results = $conn->query("SELECT PID FROM PatientInfo WHERE PID='$pid' AND name_first='$name_first' AND name_last='$name_last'");

            // Check if results is NULL, if it is the PID doesn't exist
            if ($results == NULL) {
              $msg = "Not a valid Patient ID, please contact tech support!";
            } else {
              // Create a random UserID. Max is unsigned int for mysql
              $userid = rand(1, 4294967295);
              // Check if it already exists in the table/DB.
              $results = $conn->query("SELECT UserID FROM Users WHERE UserID='$userid'");
              if ($results != NULL) {
                // We need to insert into the Users table with the info provied
                $results = $conn->query("INSERT INTO Users (UserID, PID, Username, UserPassword, IsEmployee) VALUES ('$userid','$pid', '$username', '$password', 0)");
                if($results != NULL)
                {
                  // If we get here we inserted into users successfully
                  header('Location: ../index.php');
                }
                else
                {
                  $msg = "error creating account please try again or contact support";
                }
              } else {
                $msg = "We ran into an error please try again or contact support!";
              }
            }
          }
        } else {
          $msg = "password field did not match! Please try again!";
        }
        ?>
      </button>
    </form>
  </section>
  <?php echo "$msg" ?>
  <?php $conn->close(); ?>
</body>

</html>