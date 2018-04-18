<?php
	session_start();
	include('connection.php');

		$id = $_GET['id'];

		$namefetch = mysqli_query($dbc, "SELECT image FROM post WHERE id='".$id."'");
		$row = mysqli_fetch_array($namefetch, MYSQLI_BOTH);
		$name = $row['image'];

		if (!empty($name)) {
			$location = realpath(dirname(__FILE__)).'/images/'.basename($name); 
			$image_path = realpath(dirname(__FILE__)).'/images/';   
			
			if(file_exists($location)){
			    unlink($location);
			 } 
		}
		$query = "DELETE FROM post WHERE id='".$id."'";

		unset($_GET['id']);

		echo "<script>
				alert('Post Deleted!!!');
				window.location.href = 'dashboard.php';
				exit;
				</script>";
	mysqli_query($dbc, $query);
?>