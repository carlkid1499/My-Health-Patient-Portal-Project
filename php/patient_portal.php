<?php
/* This is the patient_portal.php file.
* All Patient information will be accessed
* through this page.
*/

# import another php file and access it's variables
include 'sandbox.php';

# Start the session again to access session variables
session_start();
# Grab all the session values
$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
$isemployee = $_SESSION['isemployee'];
$pid = $_SESSION['pid'];

//Populate table column values but let's get that data first!
// Variables for Patient information
$name_first = NULL;
$name_last = NULL;
$DOB = NULL;
$gender = NULL;
$address = NULL;
$email = NULL;
$phone = NULL;
$e_name = NULL;
$e_phone = NULL;

// Create connection for log in
$conn = new mysqli("localhost", "myhealth2", "CIOjh^J8h^?b", "myhealth2");
// Check if connection is valid
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  $msg = "Connection failed: to DB";
}

// Query the PatientInfo database for the information
$results = $conn ->query("SELECT * FROM PatientInfo WHERE PID='$pid'");

// Did we get any results
if($results->num_rows >0)
{
  // Get the Query Results
  while ($row = $results->fetch_assoc()) {
    $name_first = $row["name_first"];
    $name_last = $row["name_last"];
    $DOB = $row["DOB"];
    $gender = $row["Gender"];
    $address = $row["address"];
    $email = $row["email"];
    $phone = $row["phone"];
    $e_name = $row["Emergency_name"];
    $e_phone = $row["Emergency_phone"];
  } 
}
?>
<!--end of php section-->

<!------------- HTML ------------->
<!DOCTYPE html>
<html>

<head>
  <title>Patient Portal </title>
  <link href='../css/welcome.css' rel='stylesheet'>
  <link href="../css/blue_theme.css" rel='stylesheet'>
  <link href="../css/patient_portal.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="../js/effects.js"></script>
  <!--- SOURCE: https://www.w3schools.com/php/php_includes.asp --->
</head>

<div class="w3-bar w3-theme-d5">
<!--Home Button-->
  <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
      <button class="w3-bar-item w3-button" name="home" type="submit">Home
        <!-- If the logout button is pushed -->
        <?php if(isset($_POST['home']))
        {
          header('Location: ../index.php');
        } 
        ?>
        </button>
  </form>
<!--Refresh Page Button-->
  <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
      <button class="w3-bar-item w3-button" name="refresh" type="submit">Refresh Page
        <!-- If the logout button is pushed -->
        <?php if(isset($_POST['reload']))
        {
          header('Location: patient_portal.php');
        } 
        ?>
        </button>
  </form>
<!--Logout Button-->
  <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
      <button class="w3-bar-item w3-button logoutbtn" name="logout" type="submit" style="float: right;">Logout
        <!-- If the logout button is pushed -->
        <?php if(isset($_POST['logout']))
        {
          header('Location: logout.php');
        } 
        ?>
        </button>
  </form>

</div>

<div class="header w3-theme-d2">
    <h1><b>My Health Patient Portal</b></h1>
</div>

<body>
<div class="container">
<div class="center">

  <h2>Patient Portal: <?php echo " Welcome - <B>$name_first</B>"?></h2>

  <section name="patientinfo" class="center">
    <!-- This is the place where we get/print and patient informaton in the database. The patient must have access to only his/her info and no one else -->
    <table name="patientinfo_table" class="center" style="width=95%;" border="3" cellpadding="1">
    <tbody>
      <!-- Populate table column names -->
      <tr>
        <th> Patient ID </th> 
        <th> First name </th>
        <th> Last name </th>
        <th> Birthday </th>
        <th> Gender </th>
        <th> Address </th>
        <th> Email </th>
        <th> Phone </th>
        <th> Emergency Contact Name </th>
        <th> Emergency Phone Number </th>
      </tr>
      <!-- Populate patient information-->
      <tr>
        <td><?php echo "$pid"?></td>
        <td><?php echo "$name_first"?></td>
        <td><?php echo "$name_last"?></td>
        <td><?php echo "$DOB"?></td>
        <td><?php echo "$gender"?></td>
        <td><?php echo "$address"?></td>
        <td><?php echo "$email"?></td>
        <td><?php echo "$phone"?></td>
        <td><?php echo "$e_name"?></td>
        <td><?php echo "$e_phone"?></td>
      </tr>
      </tbody>
    </table>
  </section>
</div>
</div>
<div class="center">
  <section name="options">
    <!-- Let's put any actions the user (patient) can take. i.e update info, view records, etc -->
    
      <button class="portal" type="submit" name="update information">update information</button>
      <button class="portal" type="submit" name="records">view records</button>
<!--bring up form to make an appointment-->
      <button class="portal" onclick="document.getElementById('id01').style.display='block'" style="width:auto;"
        type="submit" name="appointment">Make Appointment
      </button>

  </section>
</div>

<!--modal called to display login form-->
<div id="id01" class="modal">
  
  <form class="modal-content animate" method="post">
  <div class="imgcontainer">
    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    <div class="center">
      <h3>Make an Appointment</h3>
    </div>
  </div>

  <div class="container">
  <section class="make_appointment" id="make_appointment">
    <form class="form-signup" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                  ?>" method="post">
      <input type="date" class="form-signup" name="appointment_date" placeholder="Patient ID" required></br></br>
      <input type="text" class="form-signup" name="name_first" placeholder=<?php echo "$name_first"?> required></br></br>
      <input type="text" class="form-signup" name="name_last" placeholder=<?php echo "$name_last"?> required></br></br>
      <input type="text" class="form-signup" name="username" placeholder="Reason for Visit" required></br></br>

      <button class="loginbtn" type="submit" name="submit">submit
      </button>
    </form>
  </section>
    <div class="container">
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </div>
  </form>
</div>

<!--JS to close modal window on click outside of window-->
<script>
  // Get the modal
  var modals = document.getElementsByClassName('modal');

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    for(i=0; i<modals.length;i++)
      if (event.target == modals[i]) {
          modals[i].style.display = "none";
      }
  }
</script>

  <?php $conn->close(); ?>
</body>
</html>