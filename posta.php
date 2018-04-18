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
			border-radius: 15px;
		    background: rgba(0,0,0,0.7);
			margin: auto;
			padding: 7px 25px;
			margin-bottom: -26px;
			box-shadow: 5px 5px 10px #4CAF50;
		}
		.elements, .outer-containers {
			width: 550px;
			height: 80px;
			padding-left: 10px;
		}
		 
		.outer-containers {
			border: 0;
			position: relative;
			overflow: hidden;
			padding-bottom: 12px;
		}
		 
		.inner-containers {
			position: absolute;
			padding-right: 100%;
			left: 0;
			overflow-x: hidden;
			overflow-y: scroll;
		}
		 
		.inner-containers::-webkit-scrollbar {
			display: none;
		}
		p a:hover {
			color: #4CFF5F !important;
		}
		p.del a:hover {
			color: red !important;
		}
		.modala {
		    display: none; /* Hidden by default */
		    position: fixed; /* Stay in place */
		    z-index: 9999 !important; /* Sit on top */
		    left: 0;
		    top: 0;
		    overflow: auto;
		    width: 100%; /* Full width */
		    height: 100%; /* Full height *//* Enable scroll if needed */
		    background-color: rgb(0,0,0); /* Fallback color */
		    background-color: rgba(0,0,0,0.7); /* Black w/ opacity */
		}

		/* Modal Content/Box */
		.modala-content {
		    background-color: #333;
		    margin: 3% auto; /* 15% from the top and centered */
		    padding: 22px 22px ;
		    width: 600px;/* Could be more or less, depending on screen size */
		}

		/* The Close Button */
		.closea {
		    color: #aaa;
		    float: right;
		    font-size: 28px;
		    font-weight: bold;
		}

		.closea:hover,
		.closea:focus {
		    color: black;
		    text-decoration: none;
		    cursor: pointer;
		}

	</style>
</head>
<body>
		<?php
			if (empty($_SESSION['id'])) {
				echo "<h2 style='text-align: center;'>No posts to show.</h2>";
			}
			else {
				$myQuery = "SELECT * FROM post ORDER BY time DESC";
				$ro=  mysqli_query($dbc, $myQuery);//or die($myQuery."<br/><br/>".mysql_error());
				$num_row = mysqli_num_rows($ro);

				while($num_row!=0) {
				$rw = mysqli_fetch_array($ro, MYSQLI_BOTH);
				$id = $rw['id'];
				$user = $rw['username'];
				$tag = $rw['tag'];
				$image = $rw['image'];
				$posts = nl2br($rw['post']);
				$taglink = preg_replace( "/#([^\s]+)/", "<a href=\"Tagboard.php?val=%23$1\"  style='text-decoration:none; font-size: 14px; color: #eaeaea; font-family: sans-serif;'>".$tag."</a>", $tag );
				if (empty($image)) {
					echo "
					<article>
						<div class='div boxed'>
							<p><a href=\"profile.php?un=".$user."\" style='text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;'>".$user."</a></p>
							<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rw['time']."</p>
								<p style='margin-bottom:-10px; word-wrap: break-word; font-size: 14px; color: #ACE3C4; font-family: sans-serif;'>post no.#".$rw['id']."</p>
								<p style='font-size: 18px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word; padding-bottom:20px;'>".$posts."</p>
								<p>".$taglink."</p>
							<p><a href='' id='view' style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>View full post</a></p>
							<p class='del'><a href=\"delpost.php?id=".$id."\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>delete</a></p>
						</div>
					</article>";
					echo "
					<article>
						<div id='box' class='modala'>
						<div class='modala-content'>
						<span onclick=\"document.getElementById('box').style.display='none'\" class=\"closea\" title=\"Close\" style=\"float: right;\">&times;</span>
							<p><a href=\"profile.php?un=".$user."\" style='text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;'>".$user."</a></p>
							<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rw['time']."</p>
							
								<p style='margin-bottom:-10px; word-wrap: break-word; font-size: 14px; color: #ACE3C4; font-family: sans-serif;'>post no.#".$rw['id']."</p>
								<p style='font-size: 18px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word; padding-bottom:20px;'>".$posts."</p>
								<p>".$taglink."</p>
							<p class='del'><a href=\"delpost.php?id=".$id."\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>delete</a></p>
							</div>
						</div>
					</article>";
				} else {
					echo "
					<article>
						<div class='div boxed'>
							<p><a href=\"profile.php?un=".$user."\" style='text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;'>".$user."</a></p>
							<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rw['time']."</p>
							
								<p style='margin-bottom:-10px; word-wrap: break-word; font-size: 14px; color: #ACE3C4; font-family: sans-serif;'>post no.#".$rw['id']."</p>
								<p style='font-size: 18px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word; padding-bottom:20px;'>".$posts."</p>
								<img src='images/".$rw['image']."' width='90%;' style='margin-left:-10px;'>
								<p>".$taglink."</p>
							
							<p><a href='' id='view' style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>View full post</a></p>
							<p class='del'><a href=\"delpost.php?id=".$id."\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>delete</a></p>
						</div>
					</article>";
					echo "
					<article>
						<div id='box' class='modala'>
						<div class='modala-content'>
						<span onclick=\"document.getElementById('box').style.display='none'\" class=\"closea\" title=\"Close\" style=\"float: right;\">&times;</span>
							<p><a href=\"profile.php?un=".$user."\" style='text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;'>".$user."</a></p>
							<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rw['time']."</p>
							
								<p style='margin-bottom:-10px; word-wrap: break-word; font-size: 14px; color: #ACE3C4; font-family: sans-serif;'>post no.#".$rw['id']."</p>
								<p style='font-size: 18px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word; padding-bottom:20px;'>".$posts."</p>
								<p>".$taglink."</p>
								<img src='images/".$rw['image']."' width='500px' style='margin-left:-10px;'>
							<p class='del'><a href=\"delpost.php?id=".$id."\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>delete</a></p>
							</div>
						</div>
					</article>";
				}
				
					$num_row--;
					$_SESSION['id'] = $rw['id'];
				}
			}
		?>
</body>