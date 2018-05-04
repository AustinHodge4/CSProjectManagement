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

$showToast = false;
$pid = $_REQUEST['project_id'];
$projectImage = $_REQUEST['project_image'];

// We are assigning a new student to this project
if (isset($_REQUEST['studentID'])){
  $showToast = true;
  $studentID = $_REQUEST['studentID'];
  $studentStartDate = date("Y-m-d", strtotime($_REQUEST['studentStartDate']));
  $studentEndDate = date("Y-m-d", strtotime($_REQUEST['studentEndDate']));

  // Check to see if this is a valid student
  $sql = "SELECT * FROM Student WHERE sid = '$studentID'";
  $result = mysqli_query($link, $sql);
  if (mysqli_num_rows($result) <= 0) {
    $toastMessage = "Student ID is does not exist!";
  } else if (mysqli_query($link, "INSERT into Assigned (sid, pid, sdate, edate) VALUES ('$studentID', '$pid', $studentStartDate, $studentEndDate)")) {
    $toastMessage = "Student successfully added!";
  } else  {
    $toastMessage = "Unable to insert into table :(";
  }
}

// Get the project tuple
$sql = "SELECT * FROM Project WHERE pid = '$pid'";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
      debug_to_console($row);
      $projectTuple = $row;
  }
}



// Get the faculty/supervisor
$pinv = $projectTuple['pinv'];
$sql = "SELECT * FROM Faculty F WHERE F.fid = '$pinv'";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
      $faculty = $row;
  }
  debug_to_console($faculty);
}

//Get the co-supervisor
$coFaculty = NULL;
$copinv = $projectTuple['copinv'];
$sql = "SELECT * FROM Faculty F WHERE F.fid = '$copinv'";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
      $coFaculty = $row;
  }
  debug_to_console($coFaculty);
}

// Get all the students who are currently active on the project
$students = NULL;
$sql = "CALL users_on_project('$pid', 'active')";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
      $students[] = $row;
  }
  debug_to_console($students);
  // Have to call next result when calling multiple stored procedures one after the other
  $result->free();
  $link->next_result();
}
// Get all the students who are not currently active on the project
$pastStudents = NULL;
$sql = "CALL users_on_project('$pid', 'inactive')";
$result = mysqli_query($link, $sql);
debug_to_console($result);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
      $pastStudents[] = $row;
  }
  debug_to_console($pastStudents);
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
  <title>Project Detail</title>

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
           <h3><?php echo $projectTuple['pname']; ?> Details</h3>
        </div>
     </div>
    <div class="row">
        <div class="col s12 m8 offset-m2">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                      <div class="col s6">
                        <h5><i class="material-icons left">date_range</i>Start Date</h5>
                        <blockquote>
                          <p><?php $startDate = DateTime::createFromFormat("Y-m-d", $projectTuple['sdate']);
                                        echo $startDate->format("M. d, Y"); ?>
                          </p>
                        </blockquote>
                      </div>
                      <div class="col s6">
                        <h5><i class="material-icons left">date_range</i>End Date</h5>
                        <blockquote>
                          <p><?php $endDate = DateTime::createFromFormat("Y-m-d", $projectTuple['edate']);
                                        echo $endDate->format("M. d, Y"); ?>
                          </p>
                        </blockquote>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col s6">
                        <h5><i class="material-icons left">supervisor_account</i>Supervisor</h5>
                        <blockquote>
                          <p><a href="userProfile.php?user_profile_id=<?php echo $faculty['fid']; ?>&user_student_profile=false">
                              <?php echo $faculty['fname']; ?>, <i><b><?php echo $faculty['department']; ?></b></i></a></p>
                        </blockquote>
                      </div>
                      <?php if(isset($coFaculty) == True): ?>
                      <div class="col s6">
                        <h5><i class="material-icons left">supervisor_account</i>Co-Supervisor</h5>
                        <blockquote>
                          <p><a href="userProfile.php?user_profile_id=<?php echo $coFaculty['fid']; ?>&user_student_profile=false">
                              <?php echo $coFaculty['fname']; ?>, <i><b><?php echo $coFaculty['department']; ?></b></i></a></p>
                        </blockquote>
                      </div>
                      <?php endif; ?>
                      </div>
                      <?php if(isset($students) == True): ?>
                      <h5><i class="material-icons left">people</i>Students on the Project</h5>
                      <blockquote>
                      <?php for($i = 0; $i < count($students); $i++): $student = $students[$i]; ?>
                        <a href="userProfile.php?user_profile_id=<?php echo $student['sid']; ?>&user_student_profile=true">
                        <div class="chip">
                        <img src="https://api.adorable.io/avatars/285/<?php echo $student['sid']; ?>.png" />
                          <?php echo $student['sname']; ?>
                        </div>
                        </a>
                      <?php endfor; ?>
                      </blockquote>
                      <?php endif; ?>
                      <?php if(isset($pastStudents) == True): ?>
                      <h5><i class="material-icons left">people</i>Past Students on the Project</h5>
                      <blockquote>
                      <?php for($i = 0; $i < count($pastStudents); $i++): $student = $pastStudents[$i]; ?>
                        <a href="userProfile.php?user_profile_id=<?php echo $student['sid']; ?>&user_student_profile=true">
                        <div class="chip">
                          <img src="https://api.adorable.io/avatars/285/<?php echo $student['sid']; ?>.png" />
                          <?php echo $student['sname']; ?>
                        </div>
                        </a>
                      <?php endfor; ?>
                      </blockquote>
                      <?php endif; ?>
                </div>
                <div class="card-action right-align">
                  <a class="waves-effect waves-light btn" href="projects.php"><i class="material-icons left">arrow_back</i>Back</a>
                </div>
            </div>      
        </div>
    </div>
    <?php if (!$isStudent): ?>
    <div class="row">
      <div class="col s12 m8 offset-m2">
        <form method="POST" action="projectDetail.php" onsubmit="return Validate(this);">
        <input type="hidden" name="project_id" value="<?php echo $pid; ?>" />
        <input type="hidden" name="project_image" value="<?php echo $projectImage; ?>" />
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12">
                  <h5><i class="material-icons left">person_add</i>Add Student to Project</h5>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="student_id" name="studentID" type="text" class="validate" required>
                  <label for="student_id">Student ID</label>
                </div>
              </div>
              <div class="row">
              <div class="col s6">
                <input id="student_sdate" name="studentStartDate" type="text" class="datepicker" required>
                <label for="student_sdate">Start Date</label>
              </div>
              <div class="col s6">
                <input id="student_edate" name="studentEndDate" type="text" class="datepicker" required>
                <label for="student_edate">End Date</label>
              </div>
              </div>
            </div>
            <div class="card-action right-align">
              <button class="btn waves-effect waves-light waves-teal" type="submit" name="submit"><i class="material-icons left">add_circle</i>Add Student
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <? endif; ?>
    <div class="parallax-container">
      <div class="parallax"><img src="<?php echo $projectImage; ?>"></div>
    </div>
 </main>
 <?php include 'footer.php'; ?>


  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  <script>
  function Validate(form){
    // This checks the validation of the studentID input field

    // If the studentID contains anything except numbers
    if(!(/^\d+$/.test(form.studentID.value))){
      form.studentID.classList.remove('valid');
      form.studentID.classList.add('invalid');
      M.toast({html: 'Student ID must only contain numbers!'});
      return false;
    }
    else if (!form.studentID.value.startsWith('940')){
      form.studentID.classList.remove('valid');
      form.studentID.classList.add('invalid');
      M.toast({html: 'Student ID must start with 940!'});
      return false;
    } else {
      return true;
    }
  }
  </script>
  <script>
  var startDateElem = document.getElementById('student_sdate');
  var startDateInstance = M.Datepicker.init(startDateElem, {"minDate": new Date("<?php echo $projectTuple['sdate']; ?>"),
                                          "maxDate": new Date("<?php echo $projectTuple['edate']; ?>"),
                                          "defaultDate": new Date("<?php echo $projectTuple['sdate']; ?>"),
                                          "onSelect": function(newDate){
                                            endDateInstance.options.minDate = newDate;
                                          }});
  var endDateElem = document.getElementById('student_edate');
  var endDateInstance = M.Datepicker.init(endDateElem, {"minDate": new Date("<?php echo $projectTuple['sdate']; ?>"),
                                          "maxDate": new Date("<?php echo $projectTuple['edate']; ?>"),
                                          "defaultDate": new Date("<?php echo $projectTuple['edate']; ?>"),
                                          "onSelect": function(newDate){
                                            startDateInstance.options.maxDate = newDate;
                                          }});
  </script>
  <?php if($showToast) { echo '<script type="text/javascript">',
  'M.toast({html: "'.$toastMessage.'"})',
  '</script>';} ?>
  </body>
</html>
