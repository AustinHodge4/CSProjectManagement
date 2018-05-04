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
  header("Location: index.php");
}
// Showing toast when you login 
if (isset($_COOKIE['showToast'])) {
  $showToast = false;
} else {
  setcookie('showToast', true);
  $showToast = true;
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

// Get all the projects tuples for student or faculty
if ($isStudent){
  $studentID = $user['sid'];
  $sql = "SELECT P.* FROM Project P, Assigned A WHERE P.pid = A.pid AND A.sid = '$studentID'";
} else {
  $facultyID = $user['fid'];
  $sql = "SELECT * FROM Project WHERE pinv = '$facultyID' OR copinv = '$facultyID'";
}
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  debug_to_console($rows);
  $numberOfProjects = count($rows);
}
mysqli_close($link);
?> 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Projects</title>

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
           <h3>Projects</h3>
        </div>
     </div>
    <div class="row">
        <div class="col s12 m8 offset-m2">
        <?php if($numberOfProjects == 0): ?>
          <div class="row center-align">
            <i class="material-icons large">sentiment_very_dissatisfied</i>
          </div>
          <h6 class="center-align flow-text"><i>You are not assigned to any projects</i></h6>
          
        <?php endif; ?>
        <?php $count = $numberOfProjects; $rem = $numberOfProjects - floor($numberOfProjects/3) * 3; for($i=0; $i < $numberOfProjects/3; $i++): ?>
          <div class="row">
            <?php for($j=0; $j < ($count <= $rem ? $rem : 3); $j++): 
                  $tuple = $rows[$count-1];
                  $count--; ?>
            <div class="col s12 m4">
            <form method="POST" action="projectDetail.php" onsubmit="AddImageToSubmit(this);">
            <input type="hidden" name="project_id" value="<?php echo $tuple['pid']; ?>" />
            <input type="hidden" name="project_image" />
            <div class="card sticky-action">
                <div class="card-image waves-effect waves-block waves-light">
                  <img class="activator" name="project_image_src" src="<?php $images = array("background1.jpg", "background2.jpg", "background3.jpg");
                                               echo $images[rand(0, 2)]; ?>">
                </div>
                <div class="card-content">
                  <span class="card-title activator grey-text text-darken-4"><?php echo $tuple['pname']; ?><i class="material-icons right">more_vert</i></span>
                </div>
                <div class="card-action right-align">
                    <button class="btn waves-effect waves-light waves-teal" type="submit" name="submit">View Project
                    </button>
                </div>
                <div class="card-reveal">
                  <span class="card-title grey-text text-darken-4"><?php echo $tuple['pname']; ?><i class="material-icons right">close</i></span>
                  <blockquote>
                    <p>Start Date: <?php $startDate = DateTime::createFromFormat("Y-m-d", $tuple['sdate']);
                                    echo $startDate->format("M. d, Y"); ?></p>
                    <p>End Date: <?php $endDate = DateTime::createFromFormat("Y-m-d", $tuple['edate']);
                                    echo $endDate->format("M. d, Y"); ?></p>
                  </blockqoute>
                </div>
              </div> 
              </form> 
              </div>
              <?php endfor;?>
           </div>
           <?php endfor;?>
        </div>
    </div>
 </main>
 <?php include 'footer.php'; ?>
  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  <script>
  function AddImageToSubmit(form){
    form.project_image.value = form.project_image_src.src;
  }
  </script>
  <?php 
  $username = $isStudent == true ? $user['sname'] : $user['fname'];
  if($showToast) { echo '<script type="text/javascript">',
  'M.toast({html: "Welcome, '. $username .'!"})',
  '</script>';} ?>
  </body>
</html>
