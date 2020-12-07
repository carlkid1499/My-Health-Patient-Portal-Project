<?php
/* This is the healthcare_worker_portal.php file.
* All healthcare worker information will be accessed
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
  <title>Healthcare Worker Portal </title>
  <link href='../css/welcome.css' rel='stylesheet'>
  <link href='../css/patient_portal.css' rel='stylesheet'>
  <link href="../css/blue_theme.css" rel='stylesheet'>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="../js/effects.js"></script>
  <!--- SOURCE: https://www.w3schools.com/php/php_includes.asp --->
</head>

<div class="w3-bar w3-theme-d5">
  <button class="w3-bar-item w3-button">Home</button>
  <button class="w3-bar-item w3-button">Button</button>
  <button class="w3-bar-item w3-button">Button</button>
  <button class="w3-bar-item w3-button logoutbtn" name="logout" type="submit" style="float: right;">Logout
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
<div class="center">
  <h2>Healthcare Worker Portal: <?php echo " Welcome - $username"?></h2>
  <!-- This is the search bar: https://www.w3schools.com/howto/howto_css_search_button.asp -->
  <div class="container">
  <section class="seachbar-section">
    <form class="searchbar" id="searchbard" action="healthcare_worker_portal.php" method="post" style="margin:auto; max-width=60%">
      <input type="text" placeholder="Patient Search Criteria" name="searchbar-text">
    </form>
  </div>
  <div>
    <div class="container">
    <select name="search_by_options_list" class="align-middle">
      <option name="search_by_options" id="search_by_options">Search by:</option>
      <option name="search_by_options" id="search_by_options">Search by: First Name, Last Name, DOB</option>
      <option name="search_by_options" id="search_by_options">Search by: Patient ID </option>
      <option name="search_by_options" id="search_by_options">Search by: Patient Phone Number </option>
    </select>
      </div>
    <button class="searchbtn" id="searchbar-button" value="searchbar-button" onclick="return checkInput();">search</button>
  </div>
  </section>
</div>
<div class>
  <form action="healthcare_worker_portal.php" method="post" id="options">

    <!-- QUERY OPTIONS SECTION -->

    <section class="block-of-text">
      <fieldset>
        <legend>Target Database</legend>

        <!-- populate drop-down list -->
        <?php

        $list = '<option name = "sqldblist">Select Database</option>';

        //Extract list of all databases
        $q = 'show databases;';
        if ($dblist = mysqli_query($conn, $q)) {
          while ($row = mysqli_fetch_array($dblist)) {
            $val = $row['Database'];
            if (array_search($val, $defaultTables) === false) # exclude defauls mysql tables
            {
              $list .= '<option';
              $list .= $val == $targetDB ? ' selected = \'selected\'>' : '>';
              $list .= $val . '</option>';
            }
          }
          mysqli_free_result($dblist);
        }
        ?>

        <select name="sqldblist">
          <?php echo $list; ?>
        </select>

        <br>

      </fieldset>

    </section>

    <!-- INPUT SECTION -->
    <section class="block-of-text">
      <fieldset>
        <legend>Input</legend>

        <textarea class="FormElement" name="inputQuery" id="input" cols="40" rows="10" placeholder="Type Query Here"><?php echo $inputQuery; ?></textarea>

        <br>

        <input type="submit" id="submit" name="submit" value="Submit" onclick="return checkInput();">

      </fieldset>
    </section>
  </form>

  <!-- OUTPUT SECTION -->
  <form action="healthcare_worker_portal.php" method="post">

    <section class="block-of-text">
      <fieldset>
        <legend>Output</legend>

        <?php


        if ($search_result != NULL) {
          //output data of each row

          if ($search_result->num_rows > 0) {
            while ($row = $search_result->fetch_assoc()) {
              echo "PID: " . $row["PID"] . " First Name: " . $row["name_first"] . " Last Name: " . $row["name_last"] . " DOB: " . $row["DOB"] . "<br>";
            }
          } else {
            echo "0 results!";
          }
        }
        ?>


      </fieldset>
    </section>
  </form>
</div>
<div class="doctor-query container">
  <section name="options">
    <!-- Let's put any actions the user (patient) can take. i.e update info, view records, etc -->
    <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
      <button class="logoutbtn " type="submit" name="logout">Logout
        <!-- If the logout button is pushed -->
        <?php if(isset($_POST['logout']))
        {
          header('Location: logout.php');
        } 
        ?>
        </button>
    </form>
  </section>
</div>
  <?php $conn->close(); ?>
</body>

</html>