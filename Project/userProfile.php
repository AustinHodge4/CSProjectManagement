<?php
include 'config.php';
include 'debug.php';

// Check to see if the user is logged in and is a student
session_start();
if(isset($_SESSION['username'])) {  
  $userID = $_SESSION['username'];  
  $isStudent = (substr($userID, 0, 3) == '940' ? true : false);
  debug_to_console($userID);  
  debug_to_console($isStudent);
}
else {
  header("Location: login.php");
}
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

$userProfileID = $_REQUEST['user_profile_id'];
$userStudentProfile = $_REQUEST['user_student_profile'];

if ($userStudentProfile) {
    $sql = "SELECT * FROM Student WHERE sid = '$userProfileID'";
} else {
    $sql = "SELECT * FROM Faculty WHERE fid = '$userProfileID'";
} 
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    $userProfile = $row;
  }
  debug_to_console($userProfile);
}

mysqli_close($link);
?> 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>User Profile</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

</head>
<body>
<?php include 'nav.php'; ?>
 <main>
    <div class="row center-align">
        <div class="col s12">
           <h3>User Profile</h3>
        </div>
     </div>
    <div class="row">
        <div class="col s12 m8 offset-m2">
            <div class="card">
                <div class="card-content">
                   <div class="row">
                    <div class="col s6">
                    </div>
                    <div class="col s6">
                    </div>
                   </div>
                </div>
                <div class="card-action right-align">
                  <a class="waves-effect waves-light btn" href="projects.php"><i class="material-icons left">arrow_back</i>Back</a>
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

  </body>
</html>
