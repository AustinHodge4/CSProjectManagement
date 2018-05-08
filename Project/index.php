<?php 
session_start();
require_once 'config.php';
include 'debug.php';

// Showing toast when you logout
if (isset($_COOKIE['showToast'])) {https://github.com/OFFLINE-GmbH/Online-FTP-S3
  $showToast = false;
} else {
  setcookie('showToast', true);
  $showToast = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>CST6306 Term Project</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
  <?php include 'nav.php'; ?>
  <main>
  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <br><br>
      <h1 class="header center orange-text">cst6306 advanced_database</h1>
      <div class="row center">
        <h5 class="header col s12 light">A modern responsive CS Project Management System</h5>
      </div>
      <div class="row center">

      </div>
      <br><br>

    </div>
  </div>


  <div class="container">
    <div class="section">

      <!--   Icon Section   -->
      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="material-icons">flash_on</i></h2>
            <h5 class="center">Speeds up Project development</h5>

            <p class="light-blue-text">Through ease of use and brilliant organization methods this system speeds up the procees of project development.</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="material-icons">group</i></h2>
            <h5 class="center">User Experience Focused</h5>

            <p class="light-blue-text">This project managment system was designed with the primary focus being user experience. The project managment systems allows both students and falculty to view projects.</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="material-icons">settings</i></h2>
            <h5 class="center">Easy to work with</h5>

            <p class="light-blue-text">The project managment was designed to be user friendly and provide ease of use for all ages. </p>
          </div>
        </div>
      </div>

    </div>
  </div>
    </main>
  <?php include 'footer.php'; ?>


  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  <?php if($showToast) { echo '<script type="text/javascript">',
  'M.toast({html: "You have signed out."})',
  '</script>';} ?> 
  </body>
</html>
