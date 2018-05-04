<?php
session_start();
    // Include config file

    require_once 'config.php';

     

    // Define variables and initialize with empty values

    $username = $password = $confirm_password = "";

    $username_err = $password_err = $confirm_password_err = "";

     

    // Processing form data when form is submitted

    if($_SERVER["REQUEST_METHOD"] == "POST"){

     

        // Validate username

        if(empty(trim($_POST["username"]))){

            $username_err = "Please enter a username.";

        } else{

            // Prepare a select statement

            $sql = "SELECT id FROM users WHERE username = ?";

            

            if($stmt = mysqli_prepare($link, $sql)){

                // Bind variables to the prepared statement as parameters

                mysqli_stmt_bind_param($stmt, "s", $param_username);

                

                // Set parameters

                $param_username = trim($_POST["username"]);

                

                // Attempt to execute the prepared statement

                if(mysqli_stmt_execute($stmt)){

                    /* store result */

                    mysqli_stmt_store_result($stmt);

                    

                    if(mysqli_stmt_num_rows($stmt) == 1){

                        $username_err = "This username is already taken.";

                    } else{

                        $username = trim($_POST["username"]);

                    }

                } else{

                    echo "Oops! Something went wrong. Please try again later.";

                }

            }

             

            // Close statement

            mysqli_stmt_close($stmt);

        }

        

        // Validate password

        if(empty(trim($_POST['password']))){

            $password_err = "Please enter a password.";     

        } elseif(strlen(trim($_POST['password'])) < 6){

            $password_err = "Password must have atleast 6 characters.";

        } else{

            $password = trim($_POST['password']);

        }

        

        // Validate confirm password

        if(empty(trim($_POST["confirm_password"]))){

            $confirm_password_err = 'Please confirm password.';     

        } else{

            $confirm_password = trim($_POST['confirm_password']);

            if($password != $confirm_password){

                $confirm_password_err = 'Password did not match.';

            }

        }

        

        // Check input errors before inserting in database

        if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

            

            // Prepare an insert statement

            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

             

            if($stmt = mysqli_prepare($link, $sql)){

                // Bind variables to the prepared statement as parameters

                mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

                

                // Set parameters

                $param_username = $username;

                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

                

                // Attempt to execute the prepared statement

                if(mysqli_stmt_execute($stmt)){

                    // Redirect to login page

                    header("location: login.php");

                } else{

                    echo "Something went wrong. Please try again later.";

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

        <meta charset="UTF-8">

        <title>Sign Up</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:600italic,400,800,700,300' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=BenchNine:300,400,700' rel='stylesheet' type='text/css'>
        <script src="js/modernizr.js"></script>
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

      
                                     
      
                              
    <!-- ====================================================
      header section -->
      <header class="top-header">
            <div class="container">
                  <div class="row">
                        <div class="col-xs-5 header-logo">
                              <br>
                              <a href="index.html"><img src="img/logo.png" alt="" class="img-responsive logo"></a>
                        </div>

                        <div class="col-md-7">
                              <nav class="navbar navbar-default">
                                <div class="container-fluid nav-bar">
                                  <!-- Brand and toggle get grouped for better mobile display -->
                                  <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                      <span class="sr-only">Toggle navigation</span>
                                      <span class="icon-bar"></span>
                                      <span class="icon-bar"></span>
                                      <span class="icon-bar"></span>
                                    </button>
                                  </div>

                                  <!-- Collect the nav links, forms, and other content for toggling -->
                                  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                    
                                    <ul class="nav navbar-nav navbar-right" style="width:605px">
                                      <li><a class="menu active" href="index.php" >Home</a></li>
                                      <li><a class="menu" href="index.php#about">about us</a></li>
                                      <li><a class="menu" href="index.php#service">Functions </a></li>
                                      <<!-- li><a class="menu" href="index.php#team">our team</a></li> -->
                                      <li><a class="menu" href="index.php#contact"> contact us</a></li>
                                    
                                    <?php  
                                    if(isset($_SESSION['username']))  
                                    {  
                                    ?>  
                                    <li><a class="menu" href="logout.php" id="logout">Logout</a></li>
                                    <?php  
                                    }  
                                    ?>
                                          
                                          
                                          
                                          
                                          
                                          
                                    </ul>
                                  </div><!-- /navbar-collapse -->
                                </div><!-- / .container-fluid -->
                              </nav>
                        </div>
                  </div>
            </div>
      </header> <!-- end of header area -->

      

      <!-- about section -->
      <section class="about text-center" id="about">
            <div class="container">
                  <div class="row">
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                        
                        <div class="col-md-4 col-sm-6">
                              <div class="single-about-detail clearfix">
                                    
                              </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                              <div class="single-about-detail">
                                  
                                  <h2>Sign Up</h2>
      <?php  
        if(isset($_SESSION['username']))  
        {  
        ?>

        <p>You must first logout to register a new user!</p>

        <?php
        }
        else{
        ?>
            <p>Please fill this form to create an account.</p>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">

                    <label>Username</label>

                    <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">

                    <span class="help-block"><?php echo $username_err; ?></span>

                </div>    

                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">

                    <label>Password</label>

                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">

                    <span class="help-block"><?php echo $password_err; ?></span>

                </div>

                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">

                    <label>Confirm Password</label>

                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">

                    <span class="help-block"><?php echo $confirm_password_err; ?></span>

                </div>

                <div class="form-group">

                    <input type="submit" class="btn btn-primary" value="Submit">

                    <input type="reset" class="btn btn-default" value="Reset">

                </div>

                <p>Already have an account? <a href="login.php">Login here</a>.</p>

            </form>
            <?php
            }
            ?>  

                              </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                              <div class="single-about-detail">
                                    
                              </div>
                        </div>
                  </div>
            </div>
            <br>
      </section><!-- end of about section -->


      

      <!-- footer starts here -->
      <footer class="footer clearfix">
            <div class="container">
                  <div class="row">
                        <div class="col-xs-6 footer-para">
                              <p>Pharma Recolo, LLC.</p>
                        </div>
                        <div class="col-xs-6 text-right">
                              <a href=""><i class="fa fa-facebook"></i></a>
                              <a href=""><i class="fa fa-twitter"></i></a>
                              <a href=""><i class="fa fa-skype"></i></a>
                        </div>
                  </div>
            </div>
      </footer>

      <!-- script tags
      ============================================================= -->
      <script src="js/jquery-2.1.1.js"></script>
      <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
      <script src="js/gmaps.js"></script>
      <script src="js/smoothscroll.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/custom.js"></script>   

    </body>

    </html>

