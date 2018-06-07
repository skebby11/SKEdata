<?php 
	include('functions.php');

	if (!isLoggedIn()) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}
			
$idutente = $_SESSION['user']['id'];
$newmail2=$_POST['newmail'];

?>
<!DOCTYPE html>
<html>
<head>
	<title>SKEdata - Settings BETA</title>
	<link rel="stylesheet" type="text/css" href="style.css??v1.1.47">
	<link rel="stylesheet" type="text/css" href="form.css?v1.1.3">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <link rel="icon" href="favicon.ico" />
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


</head>
<body>


	<div class="header">
		<img src="img/skedata1.png" width="80%">
	</div>
		<div class="menu">
		<ul>
 		 <li><a href="index.php">Home</a></li>
  		 <li><a href="myfiles.php">My files</a></li>
  		 <li><a class="active" href="">Settings</a></li>
		</ul>
		<!-- logged in user information -->
		<div class="profile_info" align="right"> 
			<img src="images/user_profile.png" style="display: none" >

			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
						<br>
						<a href="index.php?logout='1'" style="color: red;">logout</a>
					</small>

				<?php endif ?>
			</div>
		</div>
	</div>
	<div class="content">
	
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
	
				 <?php

	$conn = mysqli_connect('localhost', 'sebastianoriva', '', 'my_sebastianoriva');
				// Check connection
				if (!$conn) {
					die("Connection failed: " . mysqli_connect_error());
				}

				$sql1 = "SELECT username, email, password FROM users where id = '$idutente'";
				$result1 = mysqli_query($conn, $sql1);

					// output data of each row
					while($row = mysqli_fetch_assoc($result1)) {
						$showusername=$row["username"];
						$showemail=$row["email"];
    					}					
				mysqli_close($conn);

				?> 
				
				<form style="border: none; width: 90%">
				Username: <?php echo $showusername; ?> <br>
				Email: <?php echo $showemail; ?> <br><br>
				</form>
				
				
				<?php 
		
		

	// connect to database

		
	$newmail = "";

	// call the pswchange() function if psw_change' is clicked
	if (isset($_POST['psw_change'])) {
		pswchange();
	}

	// call the emailchange() function if email_change is clicked
	if (isset($_POST['email_change'])) {
		emailchange();
	}

	// pswchage
	function pswchange(){
		$idutente = $_SESSION['user']['id'];

		// receive all input values from the form
		$newpassword_1  =  e($_POST['newpassword_1']);
		$newpassword_2  =  e($_POST['newpassword_2']);
		
		$dbnewpass = mysqli_connect('localhost', 'sebastianoriva', '', 'my_sebastianoriva');
		// Check connection
				if (!$dbnewpass) {
					die("Connection failed: " . mysqli_connect_error());
				}

		//if ($password_1 != $password_2) {
		//	echo "The two passwords do not match";
		//}
		//else {
				$newpassword = md5($newpassword_1);
				$newpassquery = "UPDATE users SET password='" . $newpassword ."' WHERE id=" . $idutente;
				mysqli_query($dbnewpass, $newpassquery);
				echo "Password updated!";
				
		//}

	}
		
	// emailchange
	function emailchange(){

		// receive all input values from the form
		$idutente = $_SESSION['user']['id'];
		$newmail  =  $_POST['newmail'];
		
			$dbnewmail = mysqli_connect('localhost', 'sebastianoriva', '', 'my_sebastianoriva');
				if (!$dbnewmail) {
					die("Connection failed: " . mysqli_connect_error());
				}

				$newmailquery = "UPDATE users SET email='$newmail' WHERE id='$idutente'";
				mysqli_query($dbnewmail, $newmailquery);
				echo "Email updated!";
				header('location: settings.php'); 

		}

?>
				<form method="post" action="settings.php" style="border: none; width: 90%" >
				Change Email:<br>
				<input type="email" name="newmail"<br>
				<div class="input-group">
				<button type="submit" class="btn blue" name="email_change">New email</button>
				</div>
				</form>
				
				<form method="post" action="settings.php" style="border: none; width: 90%">
				New password <br>
				<input type="password" name="newpassword_1"><br>
				Repeat new password<br>
				<input type="password" name="newpassword_2">
				
				<div class="input-group">
				<button type="submit" class="btn blue" name="psw_change">Change my password</button>
				</div>
				</form>
				
		
	</div>
	
	<div class="footer"><p>Made by <a href="https://www.sebastianoriva.it" class="footer" target="_blank">Sebastiano Riva</a> &copy <?php $year = date("Y"); echo $year; php?></p></div>
	
	
	
</body>
</html>