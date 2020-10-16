<?php  
  include 'php/sandbox.php';
  echo $test_var;
  ?>
<!------------- HTML ------------->
<!DOCTYPE html>
<html>

<head>
  <title>SQL Sandbox</title>
  <link href='css/style.css' rel='stylesheet'>
  <script src="js/effects.js"></script>
  <!--- SOURCE: https://www.w3schools.com/php/php_includes.asp --->
</head>

<body>

  <h2>SQL Sandbox</h2>

  <section class="block-of-text" style="display: none;">
    <button class="collapsible">See Example Usage</button>
    <div class="content">
      <fieldset class="side">
        <legend>Sample Database</legend>

      </fieldset>

      <fieldset class="side">
        <legend>Sample Updates</legend>

      </fieldset>

      <fieldset class="side">
        <legend>Sample Queries</legend>

      </fieldset>
    </div>
  </section>

  <form action="index.php" method="post" id="options">

    <!-- QUERY OPTIONS SECTION -->

    <section class="block-of-text">
      <fieldset>
        <legend>Target Database</legend>

        <!-- populate drop-down list -->
        <?php
              
              $list = '<option name = "sqldblist">Select Database</option>';

              //Extract list of all databases
              $q = 'show databases;';
              if ($dblist = mysqli_query($conn, $q))
              {
                while($row = mysqli_fetch_array($dblist))
                {
                  $val = $row['Database'];
                  if (array_search($val, $defaultTables) === false) # exclude defauls mysql tables
                  {
                    $list .= '<option';
                    $list .= $val == $targetDB ? ' selected = \'selected\'>' : '>';
                    $list .= $val.'</option>';
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

        <textarea class="FormElement" name="inputQuery" id="input" cols="40" rows="10"
          placeholder="Type Query Here"><?php echo $inputQuery; ?></textarea>

        <br>

        <input type="submit" id="submit" name="submit" value="Submit" onclick="return checkInput();">

      </fieldset>
    </section>
  </form>

  <!-- OUTPUT SECTION -->
  <form action="index.php" method="post">

    <section class="block-of-text">
      <fieldset>
        <legend>Output</legend>

        <?php echo $result
        ?>
        

      </fieldset>
    </section>
  </form>

  <section class="block-of-text">
    <a href="index.html"><input type="submit" name="reset" value="Reset Page" /></a>
  </section>

  <?php $conn->close(); ?>
</body>
</html>