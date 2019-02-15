<?php 
	include('functions.php');

/*	if (!isLoggedIn()) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}*/


$idfile = $_GET['id'];
$user = $_GET['user'];
$url = $_GET['file'];

					
$idutente = $_SESSION['user']['id'];

$selectuniquequery = "SELECT idunique FROM users where id='$idutente'";
$numerouserresult = mysqli_query($db, $selectuniquequery);

    while($row = mysqli_fetch_assoc($numerouserresult)) {
	$uniqueid = $row["idunique"]; }


$selectidquery = "SELECT user, priv FROM uploaded where fileid='$idfile'";
$selectresult = mysqli_query($db, $selectidquery);

	while($row = mysqli_fetch_assoc($selectresult)) {
	$uploaduser = $row["user"];
		
	// Is a file PRIVATE or PUBLIC
		if($row["priv"] != 0) {
			$privacy = "Private";
			
			if ($idutente != $uploaduser) {
			$_SESSION['msg'] = "This file is not public";
			header('location: index.php');
			}		
		} elseif ($row["priv"] == 0){
			$privacy = "Public";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SKEdata - Download BETA</title>
	<link rel="stylesheet" type="text/css" href="style.css?v1.1.47">
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
  		 <li><a href="settings.php">Settings</a></li>
		</ul>
		<!-- logged in user information -->
		<div class="profile_info" align="right"> 

			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
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
	
	<?php
	
$selectuserquery = "SELECT user FROM uploaded where fileid='$idfile'";
$selectresult2 = mysqli_query($db, $selectuserquery);

    while($row = mysqli_fetch_assoc($selectresult2)) {
        $numerouser = $row["user"];
    }

$selectuniquequery = "SELECT idunique FROM users where id='$numerouser'";
$numerouserresult = mysqli_query($db, $selectuniquequery);

    while($row = mysqli_fetch_assoc($numerouserresult)) {
	$uniqueid = $row["idunique"];
		}
				
// get uploader username 
$selectidquery = "SELECT user, priv FROM uploaded where fileid='$idfile'";
$selectresult = mysqli_query($db, $selectidquery);			
if (mysqli_num_rows($selectresult) > 0) {
while($row = mysqli_fetch_assoc($selectresult)) {
			$username = $row["user"];
			$selectuserquery = "SELECT username FROM users where id='$username'";
			$selectuserresult = mysqli_query($db, $selectuserquery);
			if (mysqli_num_rows($selectuserresult) > 0) {
			while($row = mysqli_fetch_assoc($selectuserresult)) {
			$username = $row["username"];
}}}}
				
				
$selectidquery = "SELECT fileid, filename, user, date, ext, size, priv FROM uploaded where fileid='$idfile'";
$selectresult = mysqli_query($db, $selectidquery);
				
if (mysqli_num_rows($selectresult) > 0) {
	
// output data of each row
while($row = mysqli_fetch_assoc($selectresult)) {

if(!empty($url)){
	
	$ext1 = $row["ext"];
	if($ext1 == 'mp4'){
		
		$fileext = $row["ext"];
        echo "<br>File: ". $row["filename"] . " " . $row["ext"] . "<br>
		Size: ". $row["size"] . " MB<br>
		Upload date: ". $row["date"] . "<br><br>
		<a href='uploads/0/" . $url . "/". $row["filename"]. "' download><img src='img/downloadbtn.png' width='300'></a><br>
		<a href='player.php?id=" . $idfile . "'><img src='img/watchnowbtn.png' width='200'></a><br><br>";
    }	
	else {

        echo "<br>File: ". $row["filename"] . "<br>
		Size: ". $row["size"] . " MB<br>
		Upload date: ". $row["date"] . "<br><br>
		<a href='uploads/0/" . $url . "/". $row["filename"]. "' download><img src='img/downloadbtn.png' width='300'></a><br><br>";
    }

} else {
	
	$ext1 = $row["ext"];
	if($ext1 == 'mp4'){
		
		$fileext = $row["ext"];
        echo "<br>File: ". $row["filename"] . "<br>
		Size: ". $row["size"] . " MB<br>
		Upload date: ". $row["date"] . "<br><br>
		<a href='uploads/" . $uniqueid . "/". $row["filename"]. "' download><img src='img/downloadbtn.png' width='300'></a><br>
		<a href='player.php?id=" . $idfile . "'><img src='img/watchnowbtn.png' width='200'></a><br><br>";

	}
	 
	else {
		

		
        echo "<br>File: ". $row["filename"] . "<br>
		Size: ". $row["size"] . " MB<br>
		Upload date: ". $row["date"] . "<br>
		Uploaded by: ". $username . "<br><br>
		<a href='uploads/" . $uniqueid . "/". $row["filename"]. "' download><img src='img/downloadbtn.png' width='300'></a><br><br>";

		
	}
	}

}
	}
else {
    echo "No files found!";
}



mysqli_close($db);
?>


	</div>
		
	</div>
	
	<div class="footer"><p>Made by <a href="https://www.sebastianoriva.it" class="footer" target="_blank">Sebastiano Riva</a> &copy <?php echo $year; php?></p></div>
	
	
	
</body>
</html>