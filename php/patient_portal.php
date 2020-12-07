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
?>

<!------------- HTML ------------->
<!DOCTYPE html>
<html>

<head>
  <title>Patient Portal </title>
  <link href='../css/welcome.css' rel='stylesheet'>
  <link href="../css/blue_theme.css" rel='stylesheet'>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="../js/effects.js"></script>
  <!--- SOURCE: https://www.w3schools.com/php/php_includes.asp --->
</head>

<div class="w3-bar w3-theme-d5">
  <button class="w3-bar-item w3-button">Home</button>
  <button class="w3-bar-item w3-button">Button</button>
  <button class="w3-bar-item w3-button">Button</button>
  <button class="w3-bar-item w3-button logoutbtn" style="float: right;">Logout
    <!-- If the logout button is pushed -->
    <?php if(isset($_POST['logout']))
        {
          header('Location: logout.php');
        } 
        ?>
    </button>
</div>

<div class="header w3-theme-d2">
    <h1><b>My Health Patient Portal</b></h1>
</div>

<body>
<div class="container">
<div class="center">

  <h2>Patient Portal: <?php echo " Welcome - $username"?></h2>

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
      <!-- Populate table column values but let's get that data first! -->
      <?php 

        // Variables for Patient information
        $name_fisrt = NULL;
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
            $name_fisrt = $row["name_first"];
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
      <tr>
        <td><?php echo "$pid"?></td>
        <td><?php echo "$name_fisrt"?></td>
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
    <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
      <button class="portal" type="submit" name="update information">update information</button>
      <button class="portal" type="submit" name="records">view records</button> 
      <button class="logoutbtn right" type="submit" name="logout">Logout
        <!-- If the logout button is pushed -->
        <?php if(isset($_POST['logout']))
        {
          header('Location: logout.php');
        } 
        ?>
        </button>
      </button>
    </form>
  </section>
</div>
  <?php $conn->close(); ?>
</body>
</html>