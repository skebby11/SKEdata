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

//CHANGE PRIVACY








?>
<!DOCTYPE html>
<html>
<head>
	<title>SKEdata - My files BETA</title>
	<link rel="stylesheet" type="text/css" href="style.css?v1.1.58">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="form.css?v1.1.3">
	 <link rel="icon" href="favicon.ico" />
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
		function del(id) {
			var answer = confirm("Sicuro di voler eliminare?");
			if (answer){
				window.location = "deletefile.php?id="+id;
				return true;
			}
		}
		function public(id) {
				var answer = confirm("Do you really want to make the file public?");
				if (answer){
					window.location = "myfiles.php?pub="+id;
					return true;
				}
			}
		function private(id) {
				var answer = confirm("Do you really want to make the file private?");
				if (answer){
					window.location = "myfiles.php?priv="+id;
					return true;
				}
			}
</script>
	
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
		
		<div class="myfiles">	
			 
			 <?php


$sql1 = "SELECT filename, fileid, user, date, ext, size, priv FROM uploaded where user = '$idutente'";
$result1 = mysqli_query($db, $sql1);
if (mysqli_num_rows($result1) > 0) {
	
    // output data of each row
    while($row = mysqli_fetch_assoc($result1)) {
		
		// Is a file PRIVATE or PUBLIC
		if($row["priv"] != 0) {
			$privacy = "<a href='javascript:;' onclick=" . '"' . "public('" . $row["fileid"]."')" . '"' . "><img src='./img/lock1.png' class='privimg' alt='Private file' title='Private file'></a>";
		} elseif ($row["priv"] == 0){
			$privacy = "<a href='javascript:;' onclick=" . '"' . "private('" . $row["fileid"]."')" . '"' . "><img src='./img/globe.png' class='privimg' alt='Public file' title='Public file'></a>";
		}
		
        echo "<div class='myfile'> <img src='img/ext/" . $row["ext"] . ".png'>
		<div>Filename: <a href='download.php?id=" . $row["fileid"] . "' target='_blank'>". $row["filename"]. "</a><br>
		Date: ". $row["date"] . "<br>
		Extention: ". $row["ext"] . " - Size: ". $row["size"] . " MB ". $privacy ." <br> 
		<a href='javascript:;' onclick=" . '"' . "del('" . $row["fileid"]."')" . '"' . ">
		<input type='submit' class='btn del delbtn' value='Delete'></a></div></div>";
		
	
    }
} else {
    echo "No files found!";
}

mysqli_close($db);
?> 

		
		</div>
	</div>
	
	<div class="footer"><p>Made by <a href="https://www.sebastianoriva.it" class="footer" target="_blank">Sebastiano Riva</a> &copy <?php $year = date("Y"); echo $year; ?></p></div>
	
	
	
</body>
</html>