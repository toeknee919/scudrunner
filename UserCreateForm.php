<?php session_start();
// Author: 	Tony Hess
// File: 	UserCreateForm.php
// Purpose:	This file is used for setting the user up with an account.


 	$dbHost = "localhost";   //Location Of Database/localhost 
    $dbUser = "toeknee919";           		 //Database User Name 
    $dbPass = "portland";            //Database Password 
    $dbDatabase = "toeknee919";    			//Database Name 
     
    $db = mysql_connect($dbHost,$dbUser,$dbPass)or die("Error connecting to database."); 
    //Connect to the database 
    mysql_select_db($dbDatabase, $db)or die("Couldn't select the database.");

?>

<!DOCTYPE html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/> 
<link rel="stylesheet" type="text/css" href="css/jquery.mobile-1.3.2.min.css" />
<title>Create Account</title>

	<style>
		
		body{
		    margin: 0;
		    padding: 0;
		}

		#headder,h1,h3{
			color:#777777;
			text-align: center;
			background-color: #333333;
			text-shadow: none;
			margin: 0;
	    	padding: 0;
	    	border: 0;
		}

		#form1{
			position: absolute;
			min-height:100%;
			min-width:100%;
			font-size: 15px;
			display:inline-block;
			background-color: #555555;
			color:#ffffff;
			font:sans-serif;
			text-shadow: none;
			padding: 3px;
		}
		#form2{
			margin-left:5px;
			margin-right:15px;
			background-color: #55555;
			text-shadow: none;
			width:70%;
			max-width: 250px;

		}
		#errr{
			background-color: #ffffff;
			color:#ff0000;
			}

	</style>

<script type="text/javascript" src="javascript/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="javascript/jquery.mobile-1.3.2.min.js"></script>
</head>

<!-- form to create an account-->
<body>
<div id="headder">	
	<h1>Welcome</h1>
	<h3>Please Create your Account</h3>
</div>


<div id="form1">
<label for="form2">Please enter a username and password you would like to use.</label>
Username and Password must be at least 6 characters.<br><br>

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
