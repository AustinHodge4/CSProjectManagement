<nav>
  <div class="nav-wrapper">
    <a href="projects.php" class="brand-logo white-text">Home</a>
    <a href="#" data-target="nav-mobile" class="sidenav-trigger white-text"><i class="material-icons">menu</i></a>
    <ul class="right hide-on-med-and-down">
    <?php  if(isset($_SESSION['username'])) {  ?>  
      <li><a class="waves-effect waves-light white-text" href="search.php"><i class="material-icons left">search</i>Search</a></li>
      <li><a class="waves-effect waves-light white-text" href="logout.php"><i class="material-icons right">exit_to_app</i>Logout</a></li>
    <?php } else { ?>  
      <li><a class="waves-effect waves-light white-text" href="login.php"><i class="material-icons left">person</i>Login</a></li>  
    <?php } ?>
	  </ul>
  </div>
  <ul id="nav-mobile" class="sidenav">
  <?php if(isset($_SESSION['username'])) { ?>
    <li>
      <div class="user-view">
        <div class="background">
          <img src="background1.jpg">
        </div>
      <a href="#user"><img class="circle" src="https://api.adorable.io/avatars/285/<?php echo $userID; ?>.png"></a>
      <a href="#name"><span class="white-text name"><?php if ($isStudent){ echo $user['sname']; } else { echo $user['fname']; } ?></span></a>
      <a href="#name"><span class="white-text email"><?php if ($isStudent){ echo $user['level'] .', '. $user['major']; } else { echo $user['department']; } ?></span></a>

      </div>
    </li>
    <li><a class="waves-effect" href="search.php"><i class="material-icons">search</i>Search</a></li>
    <li><div class="divider"></div></li>
    <li><a class="waves-effect" href="logout.php"><i class="material-icons">exit_to_app</i>Logout</a></li>
  <?php } else { ?>  
    <li><a class="waves-effect" href="login.php"><i class="material-icons">person</i>Login</a></li>  
  <?php } ?>
  </ul>
</nav>