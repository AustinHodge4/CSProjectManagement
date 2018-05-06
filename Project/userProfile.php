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

if ($userStudentProfile == "true") {
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

// Get all the projects tuples for student or faculty
if ($userStudentProfile == "true"){
  $sql = "CALL user_projects('$userProfileID', 'student')";
} else {
  $sql = "CALL user_projects('$userProfileID', 'faculty')";
}

$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    $projects[] = $row;
  }
  debug_to_console($projects);
  // Have to call next result when calling multiple stored procedures one after the other
  $result->free();
  $link->next_result();
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
        <div class="col s12 m4 offset-m4">
            <div class="card">
                <div class="card-content">
                <?php if($userStudentProfile == "true"): ?>
                  <div class="row valign-wrapper">
                    <div class="col s4">
                      <img src="https://api.adorable.io/avatars/285/<?php echo $userProfile['sid']; ?>.png" alt="" class="circle responsive-img">
                    </div>
                    <div class="col s8">
                      <h4><?php echo $userProfile['sname']; ?></h4>
                      <span class="black-text">
                        <?php echo $userProfile['level']; ?>, <?php echo $userProfile['major']; ?> Major<br />
                        <?php echo $userProfile['byear']; ?>
                      </span>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <div class="row">
                    <div class="col s12">
                      <h5><i class="material-icons left">web</i>Projects</h5>
                      <blockquote>
                      <?php for($i = 0; $i < count($projects); $i++): $project = $projects[$i]; ?>
                        <div class="chip">
                          <?php echo $project['pname']; ?>
                        </div>
                      <?php endfor; ?>
                      </blockquote>
                    </div>
                  </div>
                <?php else: ?>
                  <div class="row valign-wrapper">
                    <div class="col s4">
                      <img src="https://api.adorable.io/avatars/285/<?php echo $userProfile['fid']; ?>.png" alt="" class="circle responsive-img">
                    </div>
                    <div class="col s8">
                      <h4><?php echo $userProfile['fname']; ?></h4>
                      <span class="black-text">
                        <?php echo $userProfile['department']; ?>
                      </span>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <div class="row">
                    <div class="col s12">
                      <h5><i class="material-icons left">web</i>Projects Supervised</h5>
                      <blockquote>
                      <?php for($i = 0; $i < count($projects); $i++): $project = $projects[$i]; ?>
                        <div class="chip">
                          <?php echo $project['pname']; ?>
                        </div>
                      <?php endfor; ?>
                      </blockquote>
                    </div>
                  </div>
                <?php endif; ?>
                </div>
                <div class="card-action right-align">
                  <a class="waves-effect waves-light btn" href="projects.php"><i class="material-icons left">arrow_back</i>Back to Projects</a>
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
