<?php
session_start();
    // Include config file

    require_once 'config.php';
    include 'debug.php';
    
    if(isset($_SESSION['username'])) {  
        $userID = $_SESSION['username'];  
        $isStudent = (substr($userID, 0, 3) == '940' ? true : false);
        debug_to_console($userID);  
        debug_to_console($isStudent);    
        // Get current logged in user tuple
        if ($isStudent) {
            $sql = "SELECT * FROM Student WHERE sid = '$userID'";
        } else {
            $sql = "SELECT * FROM Faculty WHERE fid = '$userID'";
        }
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
            $user = $row;
            }
            debug_to_console($user);
        }
    }
    // Define variables and initialize with empty values

    $username = $password = "";

    $username_err = $password_err = "";

     

    // Processing form data when form is submitted

    if($_SERVER["REQUEST_METHOD"] == "POST"){

     

        // Check if username is empty

        if(empty(trim($_POST["username"]))){

            $username_err = 'Please enter username.';

        } else{

            $username = trim($_POST["username"]);

        }

        

        // Check if password is empty

        if(empty(trim($_POST['password']))){

            $password_err = 'Please enter your password.';

        } else{

            $password = trim($_POST['password']);

        }

        

        // Validate credentials

        if(empty($username_err) && empty($password_err)){

            // Prepare a select statement

            $sql = "SELECT username, password FROM users WHERE username = ?";

            

            if($stmt = mysqli_prepare($link, $sql)){

                // Bind variables to the prepared statement as parameters

                mysqli_stmt_bind_param($stmt, "s", $param_username);

                

                // Set parameters

                $param_username = $username;

                

                // Attempt to execute the prepared statement

                if(mysqli_stmt_execute($stmt)){

                    // Store result

                    mysqli_stmt_store_result($stmt);

                    

                    // Check if username exists, if yes then verify password

                    if(mysqli_stmt_num_rows($stmt) == 1){                    

                        // Bind result variables

                        mysqli_stmt_bind_result($stmt, $username, $hashed_password);

                        if(mysqli_stmt_fetch($stmt)){

                            if(password_verify($password, $hashed_password)){

                                /* Password is correct, so start a new session and

                                save the username to the session */

                                session_start();

                                $_SESSION['username'] = $username;   
                                // Unset the cookie to show the toast again when the user login   
                                if (isset($_COOKIE['showToast'])) {
                                    unset($_COOKIE['showToast']);
                                    setcookie('showToast', '', time() - 3600, '/');
                                }
                                mysqli_stmt_close($stmt);
                                mysqli_close($link);
                                header("location: projects.php");
                                

                            } else{

                                // Display an error message if password is not valid

                                $password_err = 'The password you entered was not valid.';

                            }

                        }

                    } else{

                        // Display an error message if username doesn't exist

                        $username_err = 'No account found with that username.';

                    }

                } else{

                    echo "Oops! Something went wrong. Please try again later.";

                }

            }

            

            // Close statement

            mysqli_stmt_close($stmt);

        }

        

        // Close connection

        mysqli_close($link);

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Login</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
<?php include 'nav.php'; ?>
  <main>

  <div class="container">
    <div class="section">

      <!--   Icon Section   -->
      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="material-icons"></i></h2>
            <h5 class="center"></h5>

            <p class="light"></p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="material-icons">group</i></h2>
            <h5 class="center">Login</h5>

            <p class="light">
			
			<?php  
        if(isset($_SESSION['username']))  
        {  
        ?>

        <p>You must first logout to register a new user!</p>

        <?php
        }
        else{
        ?>
			<p>Please fill in your credentials to login.</p>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">

                    <label>Username</label>

                    <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">

                    <span class="help-block"><?php echo $username_err; ?></span>

                </div>    

                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
				

                    <label>Password</label>

                    <input type="password" name="password" class="form-control">

                    <span class="help-block"><?php echo $password_err; ?></span>

                </div>

                <div class="form-group">

                    <input type="submit" class="btn btn-primary" value="Login">

                </div>

                <!-- <p>Don't have an account? <a href="register.php">Sign up now</a>.</p> -->

            </form></p>
			<?php
            }
            ?>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="material-icons"></i></h2>
            <h5 class="center"></h5>

            <p class="light"></p>
          </div>
        </div>
      </div>

    </div>
    <br><br>
  </div>
          </main>
          <?php include 'footer.php'; ?>


  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
   
  </body>
</html>
