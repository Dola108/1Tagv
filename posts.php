<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<?php
		include('connection.php');
		//$val = $_GET["val"];
		if (!empty($_SESSION['uname'])) {
			$uname = $_SESSION['uname'];
			$myQuery = "SELECT * FROM registration WHERE username='".$uname."'";
			$r=  mysqli_query($dbc, $myQuery) or die($myQuery."<br/><br/>".mysql_error());
			$row = mysqli_fetch_array($r, MYSQLI_BOTH);
			$_SESSION['uname'] = $uname;
		}
		else {
			echo "<script>
					alert('Log in to use dashboard!');
					window.location.href = 'Tagboard.php?val=Tags';
			</script>";
	      	// Immediately exit and send response to the client and do not go furthur in whatever script it is part of.
	      	exit();
		}
	?>
	<link rel="stylesheet" type="text/css" href="dashboard.css">
	<title>1Tag</title>
	<style type="text/css">
		article {
			margin-top: 20px;
		    margin-left: 20px;
		    border-left: none;
		    padding: 2em;
		    overflow: hidden;
		}

		.boxed {
			width: 85%;
			overflow: auto;
			border-radius: 15px;
		    background: rgba(0,0,0,0.7);
			margin: auto;
			padding: 7px 25px;
			box-shadow: 5px 5px 10px #4CAF50;
		}
		.boxedinside {
			width: auto;
			max-height: 100px;
			overflow: auto;
		    background: transparent;
			margin: 0;
			margin-left: -4.5%;
			padding: 7px 25px;
		}
		.boxedinside::-webkit-scrollbar {
		    display: none;
		}
		p a:hover {
			color: #4CFF5F !important;
		}
		p.del a:hover {
			color: red !important;
		}
	</style>
</head>
<body>
		<?php
			if (empty($_SESSION['id'])) {
				echo "<h2 style='text-align: center;'>No posts to show.</h2>";
			}
			else {
				$myQuery = "SELECT * FROM post WHERE username='".$uname."'ORDER BY time DESC";
				$ro=  mysqli_query($dbc, $myQuery);//or die($myQuery."<br/><br/>".mysql_error());
				$num_row = mysqli_num_rows($ro);

				while($num_row!=0) {
				$rw = mysqli_fetch_array($ro, MYSQLI_BOTH);
				$id = $rw['id'];
					echo "
					<article>
						<div class='div boxed'>
							<p><a href='profile.php' style='text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;'>".$uname."</a></p>
							<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rw['time']."</p>
							<div class='boxedinside'>
							<p style='margin-bottom:-10px; font-size: 14px; color: #ACE3C4; font-family: sans-serif;'>post no.#".$rw['id']."</p>
							<pre><p style='font-size: 18px; color: #ACE3C4; font-family: sans-serif;'>".$rw['post']."</p></pre></div>
							<p class='del'><a href=\"delpost.php?id=".$id."\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>delete</a></p>
						</div>
					</article>";
					$num_row--;
					//$_SESSION['id'] = $rw['id'];
				}
			}
		?>
</body>