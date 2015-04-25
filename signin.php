<?php session_start();
// Author: 	Tony Hess
// File: 	signin.php
// Purpose: This file is used for either logging into an account 
// 			or going to the page wher they can create an account

include('dataControl/dbconnect.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/> 
	<script type="text/javascript" src="javascript/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="javascript/formatWx.js"></script>
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
		border-color: #949494;
	}

	#headder{
		background: linear-gradient(#4C4C4C, #3A3A3A, #4D4D4D);
		color:#777777;
		text-shadow:0px 1px 0px rgba(255,255,255,0), 0px 4px 15px rgba(0,0,0,1.7);
		text-align: center;
		max-width: 600px;
		height:100px;

	}
	#airportID{
		margin-left:15px;
		margin-bottom: 10px;
		background-color: transparent;
		font-size: 16px;
	}
	h1,h3{
		color:#BDBDBD;
		margin:4px;
		background: transparent;
		text-align: center;
		max-width: 600px;
	}

	#loginForm{
		min-height:100%;
		max-width: 600px;
		font-size: 16px;
		background: linear-gradient(#646363, #7E7B7B, #8c8a8a);
		color:#F5F5F5;
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
	#all{
		max-width: 600px;
		width:95%;
		font-size: 10px;
		background: #333333;
		color:#ffffff;
		font:sans-serif;
		text-shadow: none;
		padding: 3px;
		border:1px solid;
		border-color: black;
		border-radius: 3px;
		margin: 0 auto;
		margin-bottom: 5px;
	}
	errr{
		color: #DB9797;
	}
	tab{
		margin-left: 15px;
	}
	b{
		color: #33bbcc;
	}
	input#username, input#password, input#apt{
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
	img {
		width: 100%;
	}
	#explination{
		font-size: 10px;
		width:75%;
	}

	</style>


	<script type="text/javascript">
	
	//*******************************************************************
	//controls input in the airport input box.. If enter pressed, 
	//submits text, then clears the input box
	//*******************************************************************
	$(document).ready(function() {
		$('#apt').on("keypress",function(e){
			if (e.which == 13 || e.keyCode == 13){ 
				e.preventDefault();
				//simulates clicking the "getweather button"
				$('#sub').click();
			}
		});
	});


	//*******************************************************************
	//used to get weather from another airport
	//*******************************************************************
	function Airport(t){
		$.ajax({
			url:'dataControl/displayApt.php',
			type: "GET",
			data: {'airport': t },
			complete: function (data) {
				all = data.responseText;
				all = format_wx(all);

	        //gets user weather highlight settings 
	        var wx_lim = <?php $a = mysql_query("SELECT * FROM wx_limitations WHERE id = 1");
	        while($row = mysql_fetch_array($a)){
	        	echo json_encode($row);
	        };?>;
	        
	        var apt_rep = <?php $a = mysql_query("SELECT * FROM spec_apt_reports WHERE id = 1");
	        while($row = mysql_fetch_array($a)){
	        	echo json_encode($row);
	        };?>;
	        
	        all = boldline(all, wx_lim, apt_rep);
	        document.getElementById("all").innerHTML = all;

	    },

	    error: function () {
	    }
	});
	}

	</script>

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
		
		<input type="submit" name="submit" value="Login"><br>
	</form>

	<div id="create_user">
		<label for="create">Sign Up for a FREE Account<br></label>
		<input type="button" id="create" value="Create Account" onclick="window.location.href='UserCreateForm.php'"/>
	</div>
	
	<!--metar/taf request-->
	<form id = "airportID" role="search">
		<p id="explination">Weather reports below will be highlighted using general settings including precipitation, low ceilings, low visibility, and special airport conditions.</p>
		<label>Airport 4 letter ID:</label><br>
		<span>
			<input type="text" maxlength="4" name="apt" id="apt"  />
			<input type="button" id="sub" class="body-button" onclick="Airport(document.getElementById('apt').value)" value="Get Weather"/>
		</span>
	</form>


	<!--Displays the metar/tafs-->
	<h4 id="metar-label"></h4>
	<div id="all"></div>






	<div id="about_scud">
		<h4>About Scud Runner</h4>

		<p>Scud runner is aimed to be a simple Mobile/Web tool for pilots and aviation personnel who are interested in
			quickly getting the current conditions at any airport that reports weather. Create an account to get your own custom
			highlighted weather reports and notams.</p>

			<p>The tool quickly returns Metars, Tafs, and Notams which we get fresh from the NOAA website every 5 minutes in addition to any report that someone has posted 
				to this site regarding that airport. The most important part is that this application highlights conditions for the requester based on settings the user has
				set up in their account settings. I have tried to address the most important conditions such as Temp/Dew spread, Visibility, Ceilings, Wind Speed, Precip,
				and special airport conditions such as Peak Wind reports, RVR, etc. There are a good amount to choose from now, and more will be added.<p/>

				<!--<img src="screen.png" alt="NoImage">-->

				<p> For instance, if you want to know anytime visibility at an airport is at or forecasted to be below 1 mile, the user can set it up to always let them know when visibility 
					is at or below that level. This is meant to help you quickly see and avoid missing any conditions that may affect the flight. Even though our weather data does
					come from the NOAA published weather databases,	this site is not meant to replace getting the required or approved weather reporting for your type of flight.
					We are in no way approved as an official weather reporting source. More in the realm of a way of inhancing situational
					awareness. I would however love to get to the approved point someday.</p> 

					<h4>About The Developer</h4>

					<p>My name is Tony I am a former Part 121 Dispatcher, Part 135 Flight Coordinator, and licensed pilot with a degree in Aeronautics from Embry-Riddle and another
						degree from Oregon State in Computer Science. I spent 8 years in aviation in various rolls and still have a strong passion for it, but recently found a 
						strong interest in Computers and development. I spent a few months developing how to go about making this page so that it would be useful mostly to pilots, but
						also benefit flight planners, dispatchers, etc.</p>

						<p>This site is new as of Feb 2015 and still has a lot of features I want to add to it. I will continue to slowly add features and please let me know what you think
							and what you want to see. I am working on having a highlight feature added to the Notams section as well. I hope you enjoy, please feel free to 
							contact me at tony@thescudrunner.com. I do have another job and family so time is limited but if you message me I will do my best to respond quickly.</p>
						</div>

					</div>
				</body>
				</html>