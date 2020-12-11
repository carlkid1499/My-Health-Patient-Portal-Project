<?php
/* This is the patient_portal.php file.
* All Patient information will be accessed
* through this page.
*/

# import another php file and access it's variables
include 'queries.php';

# Start the session again to access session variables
session_start();
# Grab all the session values
$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
$isemployee = $_SESSION['isemployee'];
$pid = $_SESSION['pid'];
$name_first = $_SESSION['name_first'];
$name_last = $_SESSION['name_last'];

# Grab the insurace plans the user may be enrolled in. And declare vars for the info
$planid = null;
$companyid = null;

$get_enrolled_query->bind_param("i", $pid);
$get_enrolled_query->execute();

# Tell Browser not to cache anything
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0");
?>
<!--end of php section-->

<!------------- HTML ------------->
<!DOCTYPE html>
<html>

<head>
  <title>Insurance Plans Portal </title>
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
      <?php if (isset($_POST['home'])) {
        header('Location: ../index.php');
      }
      ?>
    </button>
  </form>
  <!--Refresh Page Button-->
  <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                  ?>" method="post">
    <button class="w3-bar-item w3-button" name="patient_portal" type="submit">Patient Portal
      <!-- If the logout button is pushed -->
      <?php if (isset($_POST['patient_portal'])) {
        header('Location: patient_portal.php');
      }
      ?>
    </button>
  </form>
  <!--Insurance Plans Page Button-->
  <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                  ?>" method="post">
    <button class="w3-bar-item w3-button" name="insurance_plans" type="submit">Insurance Plans
      <!-- If the logout button is pushed -->
      <?php if (isset($_POST['insurance_plans'])) {
        header('Location: insurance_plans.php');
      }
      ?>
    </button>
  </form>
  <!--Logout Button-->
  <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                  ?>" method="post">
    <button class="w3-bar-item w3-button logoutbtn" name="logout" type="submit" style="float: right;">Logout
      <!-- If the logout button is pushed -->
      <?php if (isset($_POST['logout'])) {
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

      <h2>Insurance Plans Portal: <?php echo " Welcome - <B>$name_first $name_last</B>" ?></h2>

      <section name="insuranceplans" class="center">
        <?php
        // Did we get any results
        if ($get_enrolled_query->bind_result($planid, $companyid)) {
          // Get the Query Results
          if ($get_enrolled_query->fetch()) {
            echo "We got results!";
          } else {
            echo "<B> You are not enrolled! <B>";
            echo "<div class=\"center\">
                  <section name=\"options\">
                  <!-- Let's put any actions the user (patient) can take. i.e see insurance plans etc -->
    
                  <div class=\"container\">

                  <!--bring up form to list insurance providers and plans-->
                  <button class=\"portal\" onclick=\"document.getElementById('insurance-plans').style.display='block'\" style=\"width:auto;\"
                    type=\"submit\" name=\"insurance-plans\">Shop Insurace Plans
                  </button>

                  </div>
                  </section>
                  </div>";
          }
        }

        // Close the query we are done with it
        $get_enrolled_query->close(); ?>


      </section>

    </div>
  </div>


  <!--modal called to display insurance providers and plans form-->
<div id="insurance-plans" class="modal">
  
  <form class="modal-content animate" method="post">
  <div class="imgcontainer">
    <span onclick="document.getElementById('insurance-plans').style.display='none'" class="close" title="Close Modal">&times;</span>
    <div class="center">
      <h3>Shop for Insurace Plans</h3>
    </div>
  </div>

  <div class="container">
  <section class="insurance_plans" id="insurance_plans">
    <form class="form-signup" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                  ?>" method="post">
      <div class="center">
        <p> State </p>
        <select name="State">
          <option value="DEFAULT"> State Abbr. </option>
          <option value="AL"> Alabama - AL </option>
          <option value="AK"> Alaska - AK </option>
          <option value="AZ"> Arizona - AZ </option>
          <option value="AR"> Arkansas - AR </option>
          <option value="CA"> California - CA </option>
          <option value="Co"> Colorado - CO </option>
          <option value="CT"> Connecticut - CT </option>
          <option value="DE"> Delaware - DE </option>
          <option value="FL"> Florida - FL </option>
          <option value="GA"> Georgia - GA </option>
          <option value="HI"> Hawaii - HI </option>
          <option value="ID"> Idaho - ID </option>
          <option value="IL"> Illinois - IL </option> 
          <option value="IN"> Indiana - IN </option>
          <option value="IA"> Iowa - IA </option>
          <option value="KS"> Kansas - KS </option> 
          <option value="KY"> Kentucky - KY </option>
          <option value="LA"> Louisiana - LA </option>
          <option value="ME"> Maine - ME </option>
          <option value="MD"> Maryland - MD </option>
          <option value="MA"> Massachusetts - MA </option>
          <option value="MI"> Michigan - MI </option>
          <option value="MN"> Minnesota - MN </option>
          <option value="MS"> Mississippi - MS </option>
          <option value="MO"> Missouri - MO </option>
          <option value="MT"> Montana - MT </option>
          <option value="NE"> Nebraska - NE </option>
          <option value="NV"> Nevada - NV </option>
          <option value="NH"> New Hampshire - NH </option>
          <option value="NJ"> New Jersey - NJ </option>
          <option value="NM"> New Mexico - NM </option>
          <option value="NY"> New York - NY </option>
          <option value="NC"> North Carolina - NC </option>
          <option value="ND"> North Dakota - ND </option>
          <option value="OH"> Ohio - OH </option>
          <option value="OK"> Oklahoma - OK </option>
          <option value="OR"> Oregon - OR </option>
          <option value="PA"> Pennsylvania - PA </option>
          <option value="RI"> Rhode Island - RI </option>
          <option value="SC"> South Carolina - SC </option>
          <option value="SD"> South Dakota - SD </option>
          <option value="TN"> Tennessee - TN </option>
          <option value="TX"> Texas - TX </option>
          <option value="UT"> Utah - UT </option>
          <option value="VT"> Vermont - VT </option>
          <option value="VA"> Virginia - VA </option>
          <option value="WA"> Washington - WA </option>
          <option value="WV"> West Virginia - WV </option>
          <option value="WI"> Wisconsin - WI </option>
          <option value="WY"> Wyoming - WY </option>
        </select>  
      </div>
      <div class="center">

      <button class="loginbtn" type="submit" name="create">submit
      <!-- If the submit button is pushed, we need to process the data. If successfull we need to redirect to the patient portal -->
        <?php if (isset($_POST['create'])) {
          // Process the form information
          $pid_appt = $_SESSION['pid'];
          $date = $_POST['appointment_date'];
          $time = $_POST['appointment_time'];
          $reason = trim($_POST['reason']);

          $conn->query("INSERT INTO Appointments (PID, Date, Time, Reason) VALUES ('$pid_appt', '$date', '$time', '$reason')");

        }?>
      </button>
    </form>
  </section>
    <div class="container">
        <button type="button" onclick="document.getElementById('insurance-plans').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </div>
  </form>
</div>



  <?php $conn->close(); ?>
</body>

</html>