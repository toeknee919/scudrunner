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

		#loginForm{
			min-height:100%;
			max-width: 600px;
			font-size: 16px;
			background: linear-gradient(#c2c2c2, #d3d2d2, #8c8a8a);
			color:#000000;
			font:sans-serif;
			text-shadow: none;
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
			font-size: 16px;
		}
		input[type=submit], input[type=button]{	
			width:120px;
			border-radius: 3px;
			border:none;
			color:black;
			background-color: #33bbcc;	
			height:26px;
			margin-top: 5px;
			font-size: 16px;
		}
		#create_user{
			float: right;
			width:125px;
		}
		#about_scud{
			margin:10px;
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
			
			<div id="about_scud">
			<h4>About Scud Runner</h4>

				<p>Scud runner is aimed to be a simple Mobile/Web tool for pilots and aviation personnel who are interested in
					quickly getting the current conditions at an airport in the united states and various airports abroad.</p>

				<p>This tool quickly returns Metars Tafs which we get fresh from the NOAA website every 5 minutes in addition to any report that someone has posted 
					to this site regarding that airport. The most important part is that this application highlights conditions for the requester based on settings the user has
					set up in their account settings. I have tried to address the most important conditions such as Temp/Dew spread, Visibility, Ceilings, Wind Speed, Precip,
					and special airport conditions such as Peak Wind reports, RVR, etc. There are a good amount to choose from now, and more will be added.<p/>

				<img src="screen.png" alt="NoImage">

				<p> For instance, if you want to know anytime visibility at an airport is at or forecasted to be below 1 mile, the user can set it up to always let them know when visibility 
				is at or below that level. This is meant to help you quickly see and avoid missing any conditions that may affect the flight. Even though our weather data does
					come from the NOAA published weather databases,	this site is not meant to replace getting the required and approved weather reporting for your type of flight.
					We are in no way approved in any way as a weather reporting source. I would however love to get to that point someday.</p> 

				<h4>About The Developer</h4>

				<p>I am a former Part 121 Dispatcher, Part 135 Flight Coordinator, and licensed pilot with a degree in Aeronautics from Embry-Riddle and another
				 degree from Oregon State in Computer Science. I spent 8 years in aviation in various rolls and still have a strong passion for it, but recently found a 
				 strong interest in Computers and development. I spent a few months developing how to go about making this page so that it would be useful mostly to pilots, but
				 also benefit flight planners, dispatchers, etc.</p>

				 <p>This site is new as of Feb 2015 and still has a lot of features I want to add to it. I will continue to slowly add features and please let me know what you think
				 and what you want to see. I am hoping that Notams will be published electronically soon so I can add a similar to them as well. I hope you enjoy, please feel free to 
				 contact me at toeknee919@gmail.com. I do have another job so time is limited but if you message me I will do my best to respond quickly.</p>


			</div>




	</div>
</body>
</html>