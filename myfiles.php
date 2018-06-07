<?php 
	include('functions.php');

	if (!isLoggedIn()) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}
					
$idutente = $_SESSION['user']['id'];

$selectuniquequery = "SELECT idunique FROM users where id='$idutente'";
$numerouserresult = mysqli_query($db, $selectuniquequery);

    while($row = mysqli_fetch_assoc($numerouserresult)) {
	$uniqueid = $row["idunique"];
		}


?>
<!DOCTYPE html>
<html>
<head>
	<title>SKEdata - My files BETA</title>
	<link rel="stylesheet" type="text/css" href="style.css?v1.1.56">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="form.css?v1.1.3">
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
  		 <li><a class="active" href="">My files</a></li>
  		 <li><a href="settings.php">Settings</a></li>
		</ul>
		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>
		<!-- logged in user information -->
		<div class="profile_info" align="right"> 
			<img src="images/user_profile.png" style="display: none" >

			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;"><?php echo ucfirst($_SESSION['user']); ?></i> 
						<br>
						<a href="index.php?logout='1'" style="color: red;">logout</a>
					</small>

				<?php endif ?>
			</div>
		</div>
	</div>
	<div class="content">
		
		<div class="myfiles">	
			 
			 <?php


$sql1 = "SELECT filename, fileid, user, date, ext, size FROM uploaded where user = '$idutente'";
$result1 = mysqli_query($db, $sql1);

if (mysqli_num_rows($result1) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result1)) {
        echo "<div class='myfile'> <img src='img/ext/" . $row["ext"] . ".png'>
		<div>Filename: <a href='download.php?id=" . $row["fileid"] . "' target='_blank'>". $row["filename"]. "</a><br>
		Date: ". $row["date"] . "<br>
		Extention: ". $row["ext"] . " - Size: ". $row["size"] . " MB <br> <a href='deletefile.php?id=" . $row["fileid"] . "'>
		<input type='submit' class='btn del delbtn' value='Delete'></a></div></div>";
		
	
    }
} else {
    echo "No files found!";
}

mysqli_close($db);
?> 

		
		</div>
	</div>
	
	<div class="footer"><p>Made by <a href="https://www.sebastianoriva.it" class="footer" target="_blank">Sebastiano Riva</a> &copy <?php $year = date("Y"); echo $year; php?></p></div>
	
	
	
</body>
</html>