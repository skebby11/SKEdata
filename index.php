<?php 
	include('functions.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>SKEdata - Home BETA</title>
	<link rel="stylesheet" type="text/css" href="style.css?v1.1.47">
	<link rel="stylesheet" type="text/css" href="form.css?v1.1.3">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <link rel="icon" href="favicon.ico" />
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="dropzone.js"></script>


</head>
<body>


	<div class="header" align="center">
		<img src="img/skedata1.png" width="80%">
	</div>
		<div class="menu">
		<ul>
 		 <li><a class="active" href="">Home</a></li>
  		 <li><a href="myfiles.php">My files</a></li>
  		 <li><a href="settings.php">Settings</a></li>
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
		
		
		<div class="upload">	
			 
			 <?php  if (isset($_SESSION['user'])) : ?>
			 <?php
			
				$oldpath = "uploads/".$year."/".$month;
				$_SESSION['user']['id']; 
				$idutente = $_SESSION['user']['id'];
			
					$selectuniquequery = "SELECT idunique FROM users where id='$idutente'";
					$uniqueresult = mysqli_query($db, $selectuniquequery);

		if (mysqli_num_rows($uniqueresult) > 0) {
    while($row = mysqli_fetch_assoc($uniqueresult)) {
	$uniqueid = $row["idunique"];
		}
	}			
	
if(isset($_POST['submit'])){
	
	$path = "uploads/".$uniqueid;
 
 // Count total files
 $countfiles = count($_FILES['file']['name']);

 // Looping all files
 for($i=0;$i<$countfiles;$i++){
  $filename = $_FILES['file']['name'][$i];
 
  // Upload file
  move_uploaded_file($_FILES['file']['tmp_name'][$i],$path.'/'.$filename);
	 
	 $sizepath = $path.'/'.$filename;
	 $ext = pathinfo($filename, PATHINFO_EXTENSION);
	 $size = filesize($sizepath);
	 $size = round($size / 1024 / 1024, 2); // megabytes with 2 digit
 
 }

	if (isset($_SESSION['user'])) { 	
					$datainsertquery = "INSERT INTO uploaded (filename, user, date, ext, size) VALUES ('$filename', '$idutente', '$time', '$ext', '$size')";
					mysqli_query($db, $datainsertquery);
	}
	
	echo "You successfully uploaded your file!";	
	mysqli_close($db);

} 
?>
<?php endif ?>
			 
<?php  if (!isset($_SESSION['user'])) : ?>
<?php
			
$nlid = bin2hex(openssl_random_pseudo_bytes(8));

	
if(isset($_POST['submit'])){
 mkdir("uploads/0/$nlid", 0775);
 // Count total files
 $countfiles = count($_FILES['file']['name']);

 // Looping all files
 for($i=0;$i<$countfiles;$i++){
  $nlfilename = $_FILES['file']['name'][$i];
 
  // Upload file
	 $nlpath = "uploads/0/$nlid";
  move_uploaded_file($_FILES['file']['tmp_name'][$i],$nlpath.'/'.$nlfilename);
	 
	 $nlsizepath = $nlpath.'/'.$nlfilename;
	 $nlext = pathinfo($nlfilename, PATHINFO_EXTENSION);
	 $nlsize = filesize($nlsizepath);
	 $nlsize = round($nlsize / 1024 / 1024, 2); // megabytes with 2 digit
 
 }

	if (!isset($_SESSION['user'])) { 		
					$nologdatainsertquery = "INSERT INTO uploaded (filename, user, date, ext, size) VALUES ('$nlfilename', '0', '$time', '$nlext', '$nlsize')";
					mysqli_query($db, $nologdatainsertquery);
					$dataselectquery = "SELECT fileid, filename, user, date, ext, size FROM uploaded where filename='$nlfilename'";
					$resultdue = mysqli_query($db, $dataselectquery);

		if (mysqli_num_rows($resultdue) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($resultdue)) {
	echo "You successfully uploaded your file!<br><br>
		  <div class='myfile'> <img src='img/ext/" . $row["ext"] . ".png'>
		<div>Filename: <a href='download.php?file=" . $nlid . "&id=" . $row["fileid"] . "' target='_blank'>". $row["filename"]. "</a><br>
		Date: ". $row["date"] . "<br>
		Extention: ". $row["ext"] . " - Size: ". $row["size"] . " MB <br></div></div>";
		}
	}
}

	
	mysqli_close($db);
}
?>
<?php endif ?>

 <form method='post' action='' class='drop-zone' class='dropzone' enctype='multipart/form-data'>
 <input class='btn ' type='file' name='file[]' id='file' height='100%' style='height: 100%'>

 <input class='btn blue' type='submit' name='submit' value='Upload'>
</form>

		</div>
		
	</div>
	
	<div class="footer"><p>Made by <a href="https://www.sebastianoriva.it" class="footer" target="_blank">Sebastiano Riva</a> &copy <?php echo $year; ?></p></div>
	
	
	
</body>
</html>