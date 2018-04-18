<?php  
	include('connection.php');
	session_start();

    if (empty($_SESSION['uname'])) {
    	header('Location: homepage.php');
      	exit();
    }
    
    $uname = $_SESSION['uname'];

	$myQuery = "SELECT * FROM registration WHERE username='".$uname."'";
	$r=  mysqli_query($dbc, $myQuery);// or die($myQuery."<br/><br/>".mysqli_error($dbc));
	if (!$r) {
		echo "Error: failure. ERROR: ".mysqli_error($dbc);
		echo "Debugging errno: ".mysqli_errno($dbc).PHP_EOL;
		echo "Debugging error : ".mysqli_error($dbc).PHP_EOL;
		exit;
	}

	$row = mysqli_fetch_array($r, MYSQLI_BOTH);
	$age = $row['age'];
	$email = $row['email'];
	$gender = $row['gender'];
	$_SESSION['uname'] = $uname;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Settings</title>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<link rel="stylesheet" type="text/css" href="dashboard.css">
	<link rel="stylesheet" type="text/css" href="theme.css">
	<style type="text/css">
		.field {
			position: absolute;
			vertical-align: middle;
			margin-left: 20%;
			margin-right: auto;
		    width: 60%; /* Full width */
		    height: 70%; /* Full height *//* Enable scroll if needed */
		    background-color: rgb(0,0,0); /* Fallback color */
		    background-color: rgba(0,0,0,0.7); /* Black w/ opacity */
		}
		label.del a {
			text-decoration: none;
			font-size: 18px;
			position: absolute;
			font-family: Helvetica Neue;
			color: #acacac;
		}
		label.del a:hover {
			color: white;
		}
	</style>
</head>
<body style="background-image: url('5.jpg'); background-size: 220%; background-repeat: no-repeat;">
	<nav id="myHeader" style="margin-left: -9px; margin-right: -9px; margin-top: -8px; position: fixed; top: 8px; width: 100%;">
	    <ul class="ls">
	        <li class="ls"><a href="profile.php">Profile</a></li>
	        <li class="ls"><a href="Tagboard.php?val=Tags">Tags</a></li>
	        <li class="ls"><a href="#" id="searchbox">Search</a></li>
	        <li class="ls"><a href="#">Others</a></li>
	    </ul>
	<button type="button" id="logout" class="button3"  onclick="window.location.href = 'logout.php'" 
													   value="check" style="															        
													   	   margin-right: 5%;
		        										   padding: 6px 16px;
		        										   font-size: 14px;
		        										   margin-top: -3%;">Log out</button>
	</nav>

	<div class="dash">
		<h1><?php echo $uname; ?></h1>
	</div>

	<div class="container" style="height: 140%;">
		<p><br></p>
		<h2 style="text-align: center; margin-left:auto; margin-right:auto;">Change Profile Info</h2>
			<div class="field">
				<form class="modal-content" style="background-color: transparent;" action="edit.php" enctype="multipart/form-data" method="post">
				    <div style="background-color: transparent; margin-left: 50px; margin-top: -10px; margin-right: 0; margin-bottom: 0; width: 400px;">
				      <p style="font-family: Helvetica Neue; font-size: 30px; color: #acacac;">Edit Info.</p>
				      <hr>
				      <label for="avatar"><b style="font-family: Helvetica Neue; color: #acacac;">Change Avatar : </b></label><br>
				      <input type="file" name="avatar" id="avatar" accept="image/*" style="margin-top: 12px; margin-bottom: 18px; color: #eaeaea;">
				      <br><label style="color: red; font-size: 14px;">Not submitting any photo will change to default avatar!</label><br>

				      <br><label for="delt" class="del"><a href="" id="del">Delete Account</a></label><br><br>
		      <div class="clearfix">
		        <button type="button" id="cancel"  onclick="window.location.href = 'profile.php'" class="button3" style="margin-right: 5%; 
				    background-color: #333;
				    padding: 6px 16px;
				    font-size: 14px;">Cancel</button>
		        <button type="submit" class="button2" id="ch" style=" padding:6px 16px; font-size: 14px;" name="edit" value="submit">Save Changes</button>
		      </div>
		    </div>
		  </form>
		</div>
	</div>
	<footer style="margin-top:62%;">Copyright &copy; 1tag.com</footer>
	<script type="text/javascript">
		var del = document.getElementById('del');
		del.onclick = function() {
			if(confirm("Delete account?")) {
				event.preventDefault();
				document.location.href = "delete.php";
			}
			else {
				event.preventDefault();
				window.location.href = "profile.php";
			}
		}
	</script>
</body>
</html>