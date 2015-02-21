<?php session_start();
// Author: 	Tony Hess
// File: 	UserCreateForm.php
// Purpose:	This file is used for setting the user up with an account.


include('dataControl/dbconnect.php');

?>

<!DOCTYPE html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/> 
<script type="text/javascript" src="javascript/jquery-1.11.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<title>Create Account</title>

	<style>
		
		body{
		    height: 100%;
   			max-width: 600px;
    		background-color: #555555;
    		margin: 0 auto;
    		border: 3px solid;
			border-color: #33bbcc;
		}

		#headder{
			background: linear-gradient(#333, #3f3f3f, #fff);
			color:#33bbcc;
			text-shadow:0px 1px 0px rgba(255,255,255,.3), 0px -1px 0px rgba(0,0,0,.7);
			text-align: center;
			max-width: 600px;
			height:100px;

		}
		h1,h3{
			color:#33bbcc;
			margin:0;
			background: transparent;
			text-align: center;
			max-width: 600px;
		}
		#form1{
			max-width: 600px;
			width:100%;
			font-size: 15px;
			display:inline-block;
			background: linear-gradient(#ddd, #3f3f3f, #fff);
			color:#000;
			font:sans-serif;
			text-shadow: none;
			padding: 3px;
		}
		#form2{
			max-width: 600px;
			width:100%;
			font-size: 15px;
			display:inline-block;
			background: transparent;
			color:#000;
			font:sans-serif;
			text-shadow: none;
			padding: 3px;
		}
		
		#errr{
			background-color: #ffffff;
			color:#ff0000;
			}

	</style>

</head>

<!-- form to create an account-->
<body>
<div id="headder">	
	<h1>Welcome</h1>
	<h3>Please Create your Account</h3>
</div>


<div id="form1">
<label for="form2">Please enter a username and password you would like to use.</label>
<br>Username and Password must be at least 6 characters.<br><br>

<!-- form to create an account-->
<form action="createUser.php" method="post" name="form2" id="form2"> 
		<label for="CRname">Username:</label>
		<input type="text" name="CRname" id="CRname" data-mini="true" data-inline="true"><br>
		<label for="CRpassword">Password:</label>
		<input type="text" name="CRpassword" id="CRpassword" data-mini="true" data-inline="true"><br>
		<label for="CRemail">Email:</label>
		<input type="text" name="CRemail" id="CRemail" data-mini="true" data-inline="true"><br><br>



		<div id = "errr">
		<!-- displays any errors-->
		<?php if (isset($_SESSION['errors'])): ?> 
		    <div id="errorDiv"> 
				<?php foreach($_SESSION['errors'] as $error): ?> 
				<p><?php echo $error ?></p> 
				<?php endforeach; ?> 
		    </div> 
		<?php endif; ?>	
		</div>

	<input type="submit" name="create" value="Create Account">
</form>
</div>



</body>
</html>
