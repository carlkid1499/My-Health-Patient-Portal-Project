<?php
/* This is the landing page php file. This will be the first
   page displayed when you navigate to our patient portal. It
   will allow for the user to choose to login or singup and
   navigate them to the proper php pages from here. 
*/

# Start the session
ob_start();
session_start();

?>

<!------------- HTML ------------->
<!DOCTYPE html>
<html>

<head>
  <title>My Health Patient Portal</title>
  <link href="localhost/cs360/css/welcome.css" rel='stylesheet' type="buttons/text">
  <link href="localhost/cs360/css/normalize.css" rel='stylesheet' type="normalize">
  <script src="js/effects.js"></script>
  <!--- SOURCE: https://www.w3schools.com/php/php_includes.asp --->
</head>

<body>

    <h2>My Health Patient Portal Login</h2>
    
    <section>

        <!-- Let's put any actions the user can take. i.e update info, view records, etc -->
        <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
            <div>
                <button id="btnlogin" type="submit" name="login">Login
                    <!-- If the login button is pushed -->
                    <?php if(isset($_POST['login']))
                    {
                    header('Location: login.php');
                    } 
                    ?>
                </button>

                <button id="btnsignup" type="submit" name="signup">signup
                <!-- If the signup button is pushed -->
                    <?php if(isset($_POST['signup']))
                    {
                    header('Location: signup.php');
                    } 
                    ?>
                </button>
            </div>
        </form>
    </section>
</body>

</html>