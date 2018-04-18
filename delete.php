<?php 
	session_start();
	include('connection.php');

	$uname = $_SESSION['uname'];
	
	$namefetch = mysqli_query($dbc, "SELECT avatar FROM registration WHERE username='".$uname."'");
	$row = mysqli_fetch_array($namefetch, MYSQLI_BOTH);
	$name = $row['avatar'];

	if (!empty($name)) {
		$location = realpath(dirname(__FILE__)).'/images/'.basename($name); 
		$image_path = realpath(dirname(__FILE__)).'/images/';   
		
		if(file_exists($location)){
		    unlink($location);
		 } 
	}

	$myQuery = "DELETE FROM registration WHERE username='".$uname."'";
	$query = "DELETE FROM post WHERE username='".$uname."'";

	unset($_SESSION['uname']);

	echo "<script>
			alert('Account Deleted!!!');
			window.location.href = 'homepage.php';
			exit;
			</script>";
	mysqli_query($dbc, $myQuery);
	mysqli_query($dbc, $query);
?>