<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<?php
		session_start();
		include('connection.php');
		//$val = $_GET["val"];
		if (!empty($_SESSION['uname'])) {
			$uname = $_SESSION['uname'];
			$myQuery = "SELECT * FROM registration WHERE username='".$uname."'";
			$r=  mysqli_query($dbc, $myQuery);// or die($myQuery."<br/><br/>".mysql_error());
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
	<link rel="stylesheet" type="text/css" href="postvalidation.js">
	<title>1Tag</title>
	<style type="text/css">
		.element, .outer-container {
		 	width: 750px;
			height: 750px;
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
		.image-upload {
			border-radius: 2px;
			height: 38px;
			margin-left: 65px;
			margin-top: -10px;
			width: 40px;
		}
		.image-upload > input {
		    display: none;
		}
		.gh {
			width: 85%;
			color: #333;
		}
		input#tagbox {
			position: absolute;
			margin-top: -22px;
			margin-left: -170px;
			padding: 2px;
			border-color: transparent;
			border-radius: 5px;
			background-color: transparent;
			border-color: #222;
		}
		input#tagbox:focus {
			border-color: #333;
		    background-color: transparent;
		    color: #eaeaea;
		    outline: none;
		}
		#uploadPreview {
			position: absolute;
			margin-left: 20px;
			margin-top: -21px;
		}
	</style>
</head>
<body style="background-image: url('5.jpg'); background-size: 220%; background-repeat: no-repeat;">
	<nav id="myHeader" style="margin-left: -9px; margin-right: -9px; margin-top: -8px; position: fixed; top: 8px; width: 100%;">
	    <ul class="ls">
	        <li class="ls"><a href="profile.php">Profile</a></li>
	        <li class="ls"><a href="Tagboard.php?val=Tags">Tags</a></li>
	        <li class="ls"><a href="" id="sr" ondblclick="document.getElementById('div1').style.display='none'">Search</a></li>
	        <li class="ls"><div id="div1" style="display: none; margin-top: 13px; margin-left: 5px; margin-right: 5px;"><form action="search.php" method="post"><input type="search" name="search" value="#" placeholder="Search Tags" pattern="#[A-Za-z0-9_]{2,50}"/><button type="submit">go</button></form></div></li>
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
		<h1>Dashboard</h1>
	</div>

	<div class="container">
		<p><br></p>

		<h2 style="text-align: center; margin-left:auto; margin-right:auto;">Write Posts</h2>

		<div class="postbox">
			<p><br></p>
			<p><br></p>
			<form action="make_post.php" enctype="multipart/form-data" method="post">
				<textarea class="post" maxlength="180" id="posst" name="post" cols="90" rows="4" placeholder="Write a post..."></textarea><hr class="gh">
			    <button type="submit" class="button4" name="posted">POST</button>
			    <div class="image-upload">
				    <label for="file-input">
				    	<img src="cam0.png" width="130%" onmouseover="this.src='cam1.png';" onmouseout="this.src='cam0.png';"/>
				    </label>
				    <input id="file-input" name="image" accept="image/*" onchange="previewImg();" type="file"/>
				</div>
				<input type="text" id="tagbox" name="tag" pattern="#[A-Za-z0-9_]{2,50}" placeholder="e.g.:#hash_tag" onfocusin="focusFunction()" onfocusout="blurFunction()" title="Character limit: 2-50" required>
				<img src="http://upload.wikimedia.org/wikipedia/commons/c/ce/Transparent.gif" id="uploadPreview" style="width: 40px; height: 40px;" />
				<p id="pp" style="float: right; margin-right: 16px; margin-top: -20px; font-size: 17px; color: #eaeaea;"></p>
			</form>
		</div>
			<p><br></p>

		<h2 style="text-align: center; margin-top: -10px; margin-left:auto; margin-right:auto;">All Posts</h2>
		<div class="outer-container">
			<div class="inner-container">
				<div class="element">
					<?php include('posta.php');?>
				</div>
			</div>
		</div>	
	</div>
	
	<footer>Copyright &copy; 1tag.com</footer>
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

	<script type="text/javascript">
		var textarea = document.querySelector("textarea");
		var tg = document.getElementsByName("tag")[0];


	    function previewImg() {
	        var oFReader = new FileReader();
	        oFReader.readAsDataURL(document.getElementById("file-input").files[0]);

	        oFReader.onload = function (oFREvent) {
	            document.getElementById("uploadPreview").src = oFREvent.target.result;
	            document.getElementById("uploadPreview").style.border = "2px solid #333";
	            document.getElementById("uploadPreview").style.borderRadius = "4px";
	        };
	    };

		function focusFunction(){tg.placeholder=' '; tg.style.background = transparent;}
		function blurFunction(){tg.placeholder='e.g.:#hash_tag';}

		textarea.addEventListener("input", function(){
		    var maxlength = this.getAttribute("maxlength");
		    var currentLength = this.value.length;

		    if( currentLength >= maxlength ){
		        document.getElementById('pp').innerText = maxlength - currentLength + "/" + maxlength;
		    }else{
		        document.getElementById('pp').innerText = maxlength - currentLength + "/" + maxlength; 
		    }
		});
		textarea.onpaste = function(e){
		    //do some IE browser checking for e
		    var max = this.getAttribute("maxlength");
		    e.clipboardData.getData('text/plain').slice(0, max);
		};
	</script>

</body>
</html>