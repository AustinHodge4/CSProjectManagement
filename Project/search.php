<?php 
include 'config.php';
include 'debug.php';
session_start();

if(isset($_SESSION['username'])) {  
	$userID = $_SESSION['username'];  
	$isStudent = (substr($userID, 0, 3) == '940' ? true : false);
	debug_to_console($userID);  
	debug_to_console($isStudent);
}
else {
	mysqli_close($link);
	header("Location: index.php");
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Search</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="calendar/calendar-blue2.css" rel="stylesheet" type="text/css"/>
  
  <script type="text/javascript" src="calendar/calendar.js"></script>
  <script type="text/javascript" src="calendar/calendar-en.js"></script>
  <script type="text/javascript" src="calendar/calendar-setup.js"></script>
  
  <!-- validate -->
		 <SCRIPT type=text/javascript>
		<!--
		function collapseElem(obj)
		{
			var el = document.getElementById(obj);
			el.style.display = 'none';
		}


		function expandElem(obj)
		{
			var el = document.getElementById(obj);
			el.style.display = '';
		}


		//-->
		</SCRIPT>
		<!-- expand/collapse function -->


		<!-- expand/collapse function -->
		    <SCRIPT type=text/javascript>
			<!--

			// collapse all elements, except the first one
			function collapseAll()
			{
				var numFormPages = 1;

				for(i=2; i <= numFormPages; i++)
				{
					currPageId = ('mainForm_' + i);
					collapseElem(currPageId);
				}
			}


			//-->
			</SCRIPT>
		<!-- expand/collapse function -->


		 <!-- validate -->
		<SCRIPT type=text/javascript>
		<!--
			function validateField(fieldId, fieldBoxId, fieldType, required)
			{
				fieldBox = document.getElementById(fieldBoxId);
				fieldObj = document.getElementById(fieldId);

				if(fieldType == 'text'  ||  fieldType == 'textarea'  ||  fieldType == 'password'  ||  fieldType == 'file'  ||  fieldType == 'phone'  || fieldType == 'website')
				{	
					if(required == 1 && fieldObj.value == '')
					{
						fieldObj.setAttribute("class","mainFormError");
						fieldObj.setAttribute("className","mainFormError");
						fieldObj.focus();
						return false;					
					}

				}


				else if(fieldType == 'menu'  || fieldType == 'country'  || fieldType == 'state')
				{	
					if(required == 1 && fieldObj.selectedIndex == 0)
					{				
						fieldObj.setAttribute("class","mainFormError");
						fieldObj.setAttribute("className","mainFormError");
						fieldObj.focus();
						return false;					
					}

				}


				else if(fieldType == 'email')
				{	
					if((required == 1 && fieldObj.value=='')  ||  (fieldObj.value!=''  && !validate_email(fieldObj.value)))
					{				
						fieldObj.setAttribute("class","mainFormError");
						fieldObj.setAttribute("className","mainFormError");
						fieldObj.focus();
						return false;					
					}

				}



			}

			function validate_email(emailStr)
			{		
				apos=emailStr.indexOf("@");
				dotpos=emailStr.lastIndexOf(".");

				if (apos<1||dotpos-apos<2) 
				{
					return false;
				}
				else
				{
					return true;
				}
			}


			function validateDate(fieldId, fieldBoxId, fieldType, required,  minDateStr, maxDateStr)
			{
				retValue = true;

				fieldBox = document.getElementById(fieldBoxId);
				fieldObj = document.getElementById(fieldId);	
				dateStr = fieldObj.value;


				if(required == 0  && dateStr == '')
				{
					return true;
				}


				if(dateStr.charAt(2) != '/'  || dateStr.charAt(5) != '/' || dateStr.length != 10)
				{
					retValue = false;
				}	

				else	// format's okay; check max, min
				{
					currDays = parseInt(dateStr.substr(0,2),10) + parseInt(dateStr.substr(3,2),10)*30  + parseInt(dateStr.substr(6,4),10)*365;
					//alert(currDays);

					if(maxDateStr != '')
					{
						maxDays = parseInt(maxDateStr.substr(0,2),10) + parseInt(maxDateStr.substr(3,2),10)*30  + parseInt(maxDateStr.substr(6,4),10)*365;
						//alert(maxDays);
						if(currDays > maxDays)
							retValue = false;
					}

					if(minDateStr != '')
					{
						minDays = parseInt(minDateStr.substr(0,2),10) + parseInt(minDateStr.substr(3,2),10)*30  + parseInt(minDateStr.substr(6,4),10)*365;
						//alert(minDays);
						if(currDays < minDays)
							retValue = false;
					}
				}

				if(retValue == false)
				{
					fieldObj.setAttribute("class","mainFormError");
					fieldObj.setAttribute("className","mainFormError");
					fieldObj.focus();
					return false;
				}
			}
		//-->
		</SCRIPT>
		<!-- end validate -->

  
  
  
</head>
<body onLoad="collapseAll()">

  <nav class="light-blue lighten-1" role="navigation">
    <?php include 'nav.php'; ?>
  </nav>
  <div class="section no-pad-bot" id="index-banner"  style="height:100%">
    <div class="container">
      <br><br>
      <h2 class="header center orange-text">Search</h2>
      <div class="row center">
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
		<!-- begin form -->
		<form method=post enctype=multipart/form-data action=processor.php onSubmit="return validatePage1();"><ul class=mainForm id="mainForm_1">

				<li class="mainForm" id="fieldBox_1">
					<label class="formFieldQuestion">Search for:</label><span><input class=mainForm type=radio name=field_1 id=field_1_option_1 value="Student" /><label class=formFieldOption for="field_1_option_1">Student</label><input class=mainForm type=radio name=field_1 id=field_1_option_2 value="Professor" /><label class=formFieldOption for="field_1_option_2">Professor</label></span></li>

				<li class="mainForm" id="fieldBox_2">
					<label class="formFieldQuestion">Name:</label><input class=mainForm type=text name=field_2 id=field_2 size='20' value=''></li>

				<li class="mainForm" id="fieldBox_3">
					<label class="formFieldQuestion">Projects:</label><select class=mainForm name=field_3 id=field_3><option value=''></option><option value="Apollo">Apollo</option><option value="Barcelona">Barcelona</option><option value="Barney">Barney</option><option value="Bender">Bender</option><option value="Bladerunner">Bladerunner</option><option value="Bullwinkle">Bullwinkle</option><option value="Canary">Canary</option><option value="Casanova">Casanova</option><option value="Cauldron">Cauldron</option><option value="Cold Fusion">Cold Fusion</option><option value="Colusa">Colusa</option><option value="Crusader">Crusader</option><option value="Deepmind">Deepmind</option></select></li>

				<li class="mainForm" id="fieldBox_4">
					<label class="formFieldQuestion">Begin Date</label><input type=text  name=field_4 id=field_4 value=""><button type=reset class=calendarStyle id=fieldDateTrigger_4></button><SCRIPT type='text/javascript'>   Calendar.setup({
								inputField     :    "field_4",   
								ifFormat       :    "%m/%d/%Y",   
								showsTime      :    false,          
								button         :    "fieldDateTrigger_4",
								singleClick    :    true,           
								step           :    1                
								});</SCRIPT></li>

				<li class="mainForm" id="fieldBox_5">
					<label class="formFieldQuestion">End Date</label><input type=text  name=field_5 id=field_5 value=""><button type=reset class=calendarStyle id=fieldDateTrigger_5></button><SCRIPT type='text/javascript'>   Calendar.setup({
								inputField     :    "field_5",   
								ifFormat       :    "%m/%d/%Y",   
								showsTime      :    false,          
								button         :    "fieldDateTrigger_5",
								singleClick    :    true,           
								step           :    1                
								});</SCRIPT></li>
		
		
		<!-- end of this page -->

		<!-- page validation -->
		<SCRIPT type=text/javascript>
		<!--
			function validatePage1()
			{
				retVal = true;
				if (validateField('field_1','fieldBox_1','radio',0) == false)
 retVal=false;
if (validateField('field_2','fieldBox_2','text',0) == false)
 retVal=false;
if (validateField('field_3','fieldBox_3','menu',0) == false)
 retVal=false;
if (validateDate('field_4','fieldBox_4','date',0,'','') == false)
 retVal=false;
if (validateDate('field_5','fieldBox_5','date',0,'','') == false)
 retVal=false;

				if(retVal == false)
				{
					alert('Please correct the errors.  Fields marked with an asterisk (*) are required');
					return false;
				}
				return retVal;
			}
		//-->
		</SCRIPT>

		<!-- end page validaton -->



		<!-- next page buttons --><li class="mainForm">
					<input id="saveForm" class="btn-large waves-effect waves-light orange" type="submit" value="Submit" />
				</li>

			</form>
			<!-- end of form -->
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

      
      <div class="row center">
        Results
      </div>
      <br><br>

    </div>
  </div>


  <div class="container">
    <div class="section">

      <!--   Results Section   -->
      

    </div>
    <br><br>
  </div>

  <?php include 'footer.php'; ?>


  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  <!-- page validation -->
		<SCRIPT type=text/javascript>
		<!--
			function validatePage1()
			{
				retVal = true;
				if (validateField('field_1','fieldBox_1','menu',1) == false)
				 retVal=false;
				if (validateField('field_2','fieldBox_2','text',1) == false)
				 retVal=false;
				if (validateField('field_3','fieldBox_3','textarea',1) == false)
				 retVal=false;
				if (validateField('field_4','fieldBox_4','radio',1) == false)
				 retVal=false;
				if (validateField('field_5','fieldBox_5','hidden',0) == false)
				 retVal=false;

				if(retVal == false)
				{
					alert('Please correct the errors.  Fields marked with an asterisk (*) are required');
					return false;
				}
				return retVal;
			}
		//-->
		</SCRIPT>

		<!-- end page validaton -->

  </body>
</html>
