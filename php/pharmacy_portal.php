<?php
/* This is the healthcare_worker_portal.php file.
* All healthcare worker information will be accessed
* through this page.
*/

# import another php file and access it's variables
include 'queries.php';


# Start the session again to access session variables
session_start();
# Grab all the session values
$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
$employeetype = $_SESSION['employeetype'];

?>

<!------------- HTML ------------->
<!DOCTYPE html>
<html>

<head>
  <title>Healthcare Pharmacy Portal </title>
  <link href='../css/welcome.css' rel='stylesheet'>
  <link href='../css/patient_portal.css' rel='stylesheet'>
  <link href="../css/blue_theme.css" rel='stylesheet'>
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
          header('Location: healthcare_worker_portal.php');
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
  <h1><b>My Health Pharmacy </b></h1>
</div>

<body>
<div class="center">
  <h2>Healthcare Pharmacy Portal: <?php echo " Welcome - $username"?></h2>
  <!-- This is the search bar: https://www.w3schools.com/howto/howto_css_search_button.asp -->
  <div class="container">
  <section class="seachbar-section">
    <form class="searchbar" id="searchbar" action="pharmacy_portal.php" method="post" style="margin:auto; max-width=75%">
      <input type="text" placeholder="Patient Search Criteria: Last name, First name, DOB" name="searchbar-text">
    <div>
    <button class="searchbtn" name="searchbtn" value="searchbar-button" onclick="return checkInput();">search</button>
    </div>
    </form>
  </section>
  </div>
</div>

<div class="container">
  <?php 
  if(isset($_POST["searchbtn"])){
      $inp_string = $_POST["searchbar-text"];
      if($inp_string == NULL){
        echo("<ul>" . "<center>No Search Critera Found: Enter <b>Last Name</b>, <b>First Name</b>, and <b>DOB</b></center>" . "</ul>\n");
      }
      else{
        list($last_name, $first_name, $DOB_search) = explode(",",$inp_string,3);
        //trim whitepace after parsing
        $first_name = trim($first_name);
        $last_name = trim($last_name);
        $DOB_search = trim($DOB_search);

        

        //declare null vars
        $pid_table = NULL;
        $name_first = NULL;
        $name_last = NULL;
        $DOB = NULL;
        $gender = NULL;
        $address = NULL;
        $email = NULL;
        $phone = NULL;
        $e_name = NULL;
        $e_phone = NULL;
        
        $doctor_notes = null;
        $doctor_recommendations = null;
        $record_date = null;

        // Query the PatientInfo database for the information
        $first_last_dob_query->bind_param("sss",$first_name,$last_name,$DOB_search);
        $first_last_dob_query->execute();
        $first_last_dob_query->store_result();
        $first_last_dob_query->bind_result($pid_table, $name_first, $name_last, $DOB, $gender, $address, $email, $phone, $e_name, $e_phone);

        // Did we get any results
        if($first_last_dob_query->num_rows > 0)
        {
          while($first_last_dob_query->fetch())
          {

            $_SESSION['PID'] = $pid_table;

            $patient_record_by_search->bind_param("i", $_SESSION['PID']);
            $patient_record_by_search->execute();
            $patient_record_by_search->store_result();
            $patient_record_by_search->bind_result($record_date, $doctor_notes, $doctor_recommendations);
            $patient_record_by_search->num_rows();

            if($patient_record_by_search->num_rows > 0){

              //create table to display query results
              echo "
              <div class=\"center\">
                <h2>Patient Notes: <b>$name_first $name_last</b></h2><br>
              </div>
              <table name=\"patient_notes\" class=\"pharmacy\" border=\"3\" cellpadding=\"1\">
                <tbody style=\"width=80%\">
                  <tr>
                    <th width=100px> Date </th>
                    <th> Diagnosis </th>
                    <th> Doctor Recommendations </th>
                  </tr>
              ";
              while($patient_record_by_search->fetch()){
                echo "
                  <tr>
                    <td width=50px> $record_date </td>
                    <td> $doctor_notes </td>
                    <td> $doctor_recommendations </td>
                  </tr> ";
              }
              echo " 
                    </tbody>
                  </table>
              ";
            }
          }
        }
      }
  } ?>
</div>
        

<?php $conn->close(); ?>
</body>

</html>