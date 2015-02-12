<?php session_start();
// Author: 	Tony Hess
// File: 	signin.php
// Purpose: This file is used for either logging into an account 
// 			or going to the page wher they can create an account

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/> 
<script type="text/javascript" src="javascript/jquery-1.11.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">


<title>Sign In</title>


	<style>
		
		body{
		    height: 100%;
   			max-width: 600px;
    		background-color: #555555;
    		margin: 0 auto;
    		border: 8px solid;
			border-color: #33bbcc;
		}

		#headder,h1,h3{
			color:#33bbcc;
			text-shadow:0px 1px 0px rgba(255,255,255,.3), 0px -1px 0px rgba(0,0,0,.7);
			text-align: center;
			max-width: 600px;
		}

		#loginForm{
			min-height:100%;
			max-width: 600px;
			font-size: 15px;
			background-color: #555555;
			color:#ffffff;
			font:sans-serif;
			text-shadow: none;
			border-top: 8px solid;
			border-color: #33bbcc;
		}
		#fom{
			color:white;
			background-color: #555555;
			text-shadow: none;
			width:140px;
			display:inline-block;
			margin:7px;
			padding: 5px;
			border: 2px solid;
			border-color: #333;
			border-radius: 3px;
			box-shadow: 5px 3px 3px #333;

		}
		errr{
			color:red;
		}
		input#username, input#password{
			width:120px;
			color:black;
		}
		input[type=submit], input[type=button]{	
			width:120px;
			border-radius: 3px;
			border:none;
			color:black;
			background-color: #33bbcc;	
			height:26px;
			margin-top: 5px;
		}
		#create_user{
			float: right;
			width:125px;

		}

	</style>


</head>

<body>

<div id="headder">	
	<h1>The Scud Runner</h1>
	<h3>Please Sign in or Create your Account</h3>
</div>

	<div id = "loginForm">
	<!-- form for entering username and password-->
		<form action="weatherSession.php" method="post" id="fom">
			<label for="username">Username:</label>
			<input type="text" name="username" id="username" data-mini="true" data-inline="true">
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" data-mini="true" data-inline="true">
			
				<?php if (isset($_SESSION['errors'])): ?> 
					<div id="errorDiv"> 
						<?php foreach($_SESSION['errors'] as $error): ?> 
						<errr><?php echo $error ?></errr> 
						<?php endforeach; ?> 
					</div> 
				<?php 	
			endif;
			session_unset();
		?>	
		
	    <input type="submit" name="submit" value="Login"><br><br><br>
		</form>

			<div id="create_user">
	    		<label for="create">Sign Up for a <b>FREE</b> Account !!!<br></label>
				<input type="button" id="create" value="Create Account" onclick="window.location.href='UserCreateForm.php'"/>
			</div>
			
	</div>
</body>
</html>