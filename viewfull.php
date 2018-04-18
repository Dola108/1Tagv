<?php  
	include('connection.php');
	
	if (!empty($_SESSION['uname'])) {
		$uname = $_SESSION['uname'];
		$myQuery = "SELECT * FROM registration WHERE username='".$uname."'";
		$r=  mysqli_query($dbc, $myQuery) or die($myQuery."<br/><br/>".mysql_error());
		$row = mysqli_fetch_array($r, MYSQLI_BOTH);
		$_SESSION['uname'] = $uname;
	}

	$id = $_GET['id'];
	$q = "SELECT * FROM post WHERE id='".$id."'";
	$r =  mysqli_query($dbc, $q);
	$rq = mysqli_fetch_array($r, MYSQLI_BOTH);


	$image = $rq['image'];
	$posts = nl2br($rq['post']);
	$uname = $rq['username'];
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="theme.css">
</head>
<style type="text/css">
	.box {
		position: absolute;
		background-color: rgba(0,0,0,0.6);
		padding: 10% 28%; /* Stay in place */
	    z-index: 1; /* Sit on top */
	    left: 0;
	    top: 0;
	    width: 100% !important; /* Full width */
	    height: 100%; /* Full height *//* Enable scroll if needed */
	    background-color: rgb(0,0,0); /* Fallback color */
	    background-color: rgba(0,0,0,0.7);
	}
	.post-content {
	    background-color: transparent;
	    margin: 3% auto; /* 15% from the top and centered */
	    padding: 5px 5px ;/* Could be more or less, depending on screen size */
	}
</style>
<body>
	<?php
		echo "
		<article>
			<div id='box' class='modal'>
			<div class='modal-content'>
			<span onclick=\"document.getElementById('box').style.display='none'\" class=\"close\" title=\"Close\" style=\"float: right;\">&times;</span>
				<p><a href='profile.php' style='text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;'>".$uname."</a></p>
				<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rq['time']."</p>
				
					<p style='margin-bottom:-10px; word-wrap: break-word; font-size: 14px; color: #ACE3C4; font-family: sans-serif;'>post no.#".$rq['id']."</p>
					<p style='font-size: 18px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word; padding-bottom:20px;'>".$posts."</p>
					<img src='images/".$rq['image']."' width='500px' style='margin-left:-10px;'>
				<p class='del'><a href=\"delpost.php?id=".$id."\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>delete</a></p>
				</div>
			</div>
		</article>";
	?>
</body>
</html>