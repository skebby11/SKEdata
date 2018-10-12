<?php 
	include('functions.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title>SKEdata - 404 BETA</title>
	<link rel="stylesheet" type="text/css" href="style.css?v1.1.47">
	<link rel="stylesheet" type="text/css" href="form.css?v1.1.3">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <link rel="icon" href="favicon.ico" />
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>
<body>


	<div class="header" align="center">
		<img src="img/skedata1.png" width="80%">
	</div>
		<div class="menu">
		<ul>
 		 <li><a href="index.php">Home</a></li>
  		 <li><a href="myfiles.php">My files</a></li>
  		 <li><a href="settings.php">Settings</a></li>
  		 <li><a class="active" href="notfound.php">404</a></li>
		</ul>
		<!-- logged in user information -->
		<div class="profile_info" align="right"> 

			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;"><?php echo ucfirst($_SESSION['user']); ?></i> 
						<br>
						<a href="index.php?logout='1'" style="color: red;">logout</a>
					</small>

				<?php else : ?>
				<ul class="login">
 		 		<li class="login"><a href="login.php">Login</a></li>
  		 		<li class="login"><a href="register.php">Signup</a></li>
				</ul>

				<?php endif ?>
			</div>
		</div>
	</div>
	<div class="content" align="center">
	
	<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
				<br>
			</div>
		<?php endif ?>
		
	<p>And it's a classic</p>
	<h1>404 not found</h1>
		
	<br><br><p>Nothing here, sorry :(</p>
	<p>Miss click or file removed?</p>
		
		
	<p style="padding-top: 50px; padding-bottom: 20px">Go back to <a href="index.php">home sweet home</a></p>

		
	</div>
	
	<div class="footer"><p>Made by <a href="https://www.sebastianoriva.it" class="footer" target="_blank">Sebastiano Riva</a> &copy <?php echo $year; ?></p></div>
	
	
	
</body>
</html>