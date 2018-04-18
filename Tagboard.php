<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<?php
		session_start();
		include('connection.php');
		if (isset($_GET['val'])) {
			$val = $_GET["val"];
		}
		if (!empty($_SESSION['uname'])) {
			$uname = $_SESSION['uname'];
			$myQuery = "SELECT * FROM registration WHERE username='".$uname."'";
			$r=  mysqli_query($dbc, $myQuery);// or die($myQuery."<br/><br/>".mysql_error());
			$row = mysqli_fetch_array($r, MYSQLI_BOTH);
			$_SESSION['uname'] = $uname;
			$avatar = $row['avatar'];
		}
		else {
			//header('Location: homepage.php');
	      	// Immediately exit and send response to the client and do not go furthur in whatever script it is part of.
	      	if($_GET['val'] == 'Tags') {
	      		echo "<script> if (confirm('Browse as non-user?')) {
							} else {
							    window.location = 'homepage.php';
							} </script>";
			}
		}
	?>
	<link rel="stylesheet" type="text/css" href="dashboard.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>1Tag</title>
	<style type="text/css">
		.element, .outer-container {
		 	width: 750px;
			height: 1100px;
			margin-left: auto;
			margin-right: auto;
		}
		 
		.outer-container {
			border: 5px transparent;
			position: relative;
			overflow: hidden;
			border-radius: 8px;
			background-color: rgba(0,0,0,0.4);
		}
		 
		.inner-container {
		 position: absolute;
		 left: 0;
		 overflow-x: hidden;
		 overflow-y: scroll;
		}
		 
		.inner-container::-webkit-scrollbar {
		 display: none;
		}
	</style>
</head>
<body style="background-image: url('5.jpg');">
	<nav id="myHeader" style="margin-left: -9px; margin-right: -9px; margin-top: -8px; position: fixed; top: 8px; width: 100%;">
	    <ul class="ls">
	    	<?php
				if (isset($row['avatar'])) {
					echo "<li class='ls'><img src='images/".$row['avatar']."' class='avatar' width='32px' style='margin-left: 15px; margin-top: 5px; border-width:2px; height:32px !important;'></li>";
				}
			?>
	    	<?php if (empty($uname)) {
		        	echo "<li class='ls'><a href='homepage.php'>Homepage</a></li>";
		        } else {
		        	echo "<li class='ls'><a href='profile.php'>Profile</a></li>";
		        }
	        ?>
	        <li class="ls"><a href="Dashboard.php">Dashboard</a></li>
	        <li class="ls"><a href="" id="sr" ondblclick="document.getElementById('div1').style.display='none'">Search</a></li>
	        <li class="ls"><div id="div1" style="display: none; margin-top: 13px; margin-left: 5px; margin-right: 5px;"><form action="search.php" method="post"><input type="search" name="search" value="#" placeholder="Search Tags" pattern="#[A-Za-z0-9_]{2,50}"/><button type="submit">go</button></form></div></li>
	        <li class="ls"><a href="#">Others</a></li>
	    </ul>
	    <?php 
	    	include('formmodal.php');
	 		if (!empty($_SESSION['uname'])) {
	 			echo "<button type='button' id='logout' onclick='window.location=\"logout.php\"' class='button3' 
													   value='check' style='		
													   	   margin-right: 5%;
		        										   padding: 6px 16px;
		        										   font-size: 14px;
		        										   margin-top: -3%;'>Log out</button>";
		    	
	 		} else {
	 			echo "<button type='button' id='login' class='button3' 
													   value='check' style='		
													   	   margin-right: 5%;
		        										   padding: 6px 16px;
		        										   font-size: 14px;
		        										   margin-top: -3%;'>Log In</button>";
	 		}
	 	?>
	</nav>
	<div style="position: absolute; float: left; margin-left: 5px; margin-top: 50px;">
		<?php 
			include('popular_tags.php');
		?>
	</div>

	<div class="dash">
		<h1>Tagboard</h1>
	</div>

	<div class="container">
		<p><br></p>
		<?php
				echo "<h3>".$val."</h3>";
		?><p id="demo"></p>
	</div>

	<div class="outer-container" style="margin-top: 150px;">
		<div class="inner-container">
			<div class="element">
				<?php include('tagposts.php');?>
			</div>
		</div>
	</div>	
	<script type="text/javascript">
		
		var loc = document.getElementById('view');
		var spana = document.getElementsByClassName("closea")[0];
		var modala = document.getElementById('box');

		loc.onclick = function(event) {
			event.preventDefault();
		    modala.style.display = "block";
		}
		spana.onclick = function() {
		    modala.style.display = "none";
		}
		window.onclick = function(event) {
		    if (event.target.id == 'box') {
		        modala.style.display = "none";
		    }
		}

		var search = document.getElementById('sr');

		search.onclick = function(event) {
			event.preventDefault();
			document.getElementById('div1').style.display = "block";
		}
	</script>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

	<script type="text/javascript">
		var modal = document.getElementById('myModal');
		var modalreg = document.getElementById('myReg');
		var btn = document.getElementById("login");
		var span = document.getElementsByClassName("close")[0];
		var span1 = document.getElementsByClassName("close")[1];

		btn.onclick = function(event) {
			event.preventDefault();
		    modal.style.display = "block";
		}

		$('.message a').click(function(event){
			event.preventDefault();
			modal.style.display = "none";
			modalreg.style.display = "block";
		});

		span.onclick = function() {
		    modal.style.display = "none";
		}

		span1.onclick = function() {
		    modalreg.style.display = "none";
		}

		window.onclick = function(event) {
		    if (event.target.id == 'myModal') {
		        modal.style.display = "none";
		    }
		    if (event.target.id == 'myReg') {
		        modalreg.style.display = "none";
		    }
		}

		var check = function() {
		  if (document.getElementById('psw0').value ==
		    document.getElementById('pswcon').value) {
		    document.getElementById('message').style.color = 'green';
		    document.getElementById('message').innerHTML = '*matching';
		  } else {
		    document.getElementById('message').style.color = 'red';
		    document.getElementById('message').innerHTML = '*not matching';
		  }
		}
	</script>

	<footer style="margin-top: 5%;">Copyright &copy; 1tag.com</footer>
</body>
</html>