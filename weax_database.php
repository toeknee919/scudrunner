<?php session_start(); 
// Author: 	Tony Hess
// File: 

if(!isset($_SESSION['id'])){ 
	header("Location: signin.php"); 
}

include('dataControl/dbconnect.php');

?>


<!DOCTYPE html>
<head>
	<meta charset='utf-8'>
	<title>Connect DB</title>
	<style>	
	body{
		max-width: 600px;
		background-color:#c2c2c2;
		padding: 5px;
	}
	#certs{
		border:4px outset;
		background-color: #a5d8ff;
		padding: 5px;
		border-radius: 10px;
		clear: both;
		
	}
	#airports, #homeWx{
		border:4px outset;
		background-color: black;
		color: white;
		font-size: .7em;
		padding: 5px;
	}
	label{
		font-size: 1.4em !important;
		text-shadow: none;
	}
	#airports{
		font-size: .5em;
		border-radius: 10px;
		width:80%;
		background-color: #555555;
	}
	#ratings{				
		border-radius: 10px;
	}
	formLabel{
		font-size: 3em !important;
		text-align: center;
		color:#33bbcc;
		text-shadow: none;
	}
	</style>
	
	
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" type="text/css" href="css/jquery.mobile-1.3.2.min.css" />
	<script type="text/javascript" src="javascript/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="javascript/jquery.mobile-1.3.2.min.js"></script>
	<script type="text/javascript">

	window.onload = function(){
		
	// loads the limitations slider value for the user
	load_Limitations();

	// loads the airport reports radio buttons for the user
	load_apt_reports();
}

//***********************************************************************
// this function set the "limitations" sliders to the users current settings
//************************************************************************
function load_Limitations(){

	var json_obj = <?php $a = mysql_query("SELECT * FROM wx_limitations WHERE id = '$_SESSION[id]'");
	while($row = mysql_fetch_array($a)){
		echo json_encode($row);
	};?>;
	
	var count = Object.keys(json_obj).length;							
	count = (count/2) - 1;	

	for(var i = 1; i <= count; i++){
		var elmt = "#slider-" + parseInt(i);									
		$(elmt).val(json_obj[i]);

		//updates slider to current value
		$(elmt).slider('refresh');
	}
}

//***********************************************************************
// this function set the airport reports radio buttons to the users current settings
//************************************************************************
function load_apt_reports(){

	var json_obj = <?php $a = mysql_query("SELECT * FROM spec_apt_reports WHERE id = '$_SESSION[id]'");
	while($row = mysql_fetch_array($a)){
		echo json_encode($row);
	};?>;
	
	var count = Object.keys(json_obj).length;						
	count = (count/2) - 1;	

	for(var i = 1; i <= count; i++){
		var elmt = "#checkbox-" + parseInt(i);								
		if(json_obj[i] == 1){
			$(elmt).attr("checked",true).checkboxradio("refresh");
		}
	}
}

</script>	

</head>


<body>

	<!-- Displays the users settings-->
	<div id = "airports" class="ui-body ui-body-a"> 
		<h2>CURRENT SETTINGS FOR: <?php echo $_SESSION['username'];?> </h2>
		

		<!--Form shows and sets values for user weather limits -->
		<form method="post" action="updateSettings.php">
			
			<formLabel>Limitations</formLabel>

			<label for="slider-1">Visibility: SM <= will be highlighted</label>
			<input type="range" name="slider-1" id="slider-1" value="3" min="0" max="10" step="0.25" data-highlight="true" />	
			
			<label for="slider-2">Ceiling: (100s of feet)<= will be highlighted</label>
			<input type="range" name="slider-2" id="slider-2" value="20" min="0" max="100" step="1" data-highlight="true" />	

			<label for="slider-3">Any Clouds: (100s of feet)<= will be highlighted</label>
			<input type="range" name="slider-3" id="slider-3" value="20" min="0" max="100" step="1" data-highlight="true" />

			<label for="slider-4">Wind Speed (KTS) >= will be highlighted</label>
			<input type="range" name="slider-4" id="slider-4" value="2" min="0" max="75" step="1" data-highlight="true" />

			<label for="slider-5">Low Temperature (C): Temps lower will be highlighted</label>
			<input type="range" name="slider-5" id="slider-5" value="0" min="-40" max="55" step="1" data-highlight="true" />

			<label for="slider-6">High Temperature (C): Temps Higher will be highlighted</label>
			<input type="range" name="slider-6" id="slider-6" value="20" min="-40" max="55" step="1" data-highlight="true" />

			<label for="slider-7">Temp/Dewpoint Spread (C) <= will be highlighted (-1 = off)</label>
			<input type="range" name="slider-7" id="slider-7" value="2" min="-1" max="20" step="1" data-highlight="true" />
			
			<label for="slider-8">Metar Age (Hours) >= will be highlighted</label>
			<input type="range" name="slider-8" id="slider-8" value="2" min=".5" max="24" step=".5" data-highlight="true" />		
			
			<label for="slider-9">TAF Age (Hours) >= will be highlighted</label>
			<input type="range" name="slider-9" id="slider-9" value="24" min="0" max="30" step="1" data-highlight="true" />		

			<br><br><formLabel>Wx/Apt Phenomena</formLabel>
			
			<fieldset data-role="controlgroup">
				
				<input type="checkbox" name="checkbox-1" id="checkbox-1" class="custom" data-mini="true" />
				<label for="checkbox-1">SLPNO (SeaLevel Pressure N/A)</label>

				<input type="checkbox" name="checkbox-2" id="checkbox-2" class="custom" data-mini="true" />
				<label for="checkbox-2">RVRNO (RVR not available)</label>

				<input type="checkbox" name="checkbox-3" id="checkbox-3" class="custom" data-mini="true" />
				<label for="checkbox-3">SNINCR (Snow increasing rapidly)</label>

				<input type="checkbox" name="checkbox-4" id="checkbox-4" class="custom" data-mini="true" />
				<label for="checkbox-4">PRESRR (Pressure rising rapidly)</label>

				<input type="checkbox" name="checkbox-5" id="checkbox-5" class="custom" data-mini="true" />
				<label for="checkbox-5">PRESFR (Pressure rising rapidly)</label>

				<input type="checkbox" name="checkbox-6" id="checkbox-6" class="custom" data-mini="true" />
				<label for="checkbox-6">ACFTMSHP (Aircraft Mishap)</label>

				<input type="checkbox" name="checkbox-7" id="checkbox-7" class="custom" data-mini="true" />
				<label for="checkbox-7">LTG (Lightning)</label>

				<input type="checkbox" name="checkbox-8" id="checkbox-8" class="custom" data-mini="true" />
				<label for="checkbox-8">FZRANO (Frz Rain info N/A)</label>

				<input type="checkbox" name="checkbox-9" id="checkbox-9" class="custom" data-mini="true" />
				<label for="checkbox-9">FROPA (Frontal Passage)</label>

				<input type="checkbox" name="checkbox-10" id="checkbox-10" class="custom" data-mini="true" />
				<label for="checkbox-10">VISNO (Visibility Info N/A)</label>

				<input type="checkbox" name="checkbox-11" id="checkbox-11" class="custom" data-mini="true" />
				<label for="checkbox-11">WSHFT (Wind Shift)</label>

				<input type="checkbox" name="checkbox-12" id="checkbox-12" class="custom" data-mini="true" />
				<label for="checkbox-12">TSNO (Thunderstorm Info N/A)</label>

				<input type="checkbox" name="checkbox-13" id="checkbox-13" class="custom" data-mini="true" />
				<label for="checkbox-13">PK WND (Peak Wind Report)</label>
			</fieldset>

			<br>CURRENTLY ALL PRECIPITATION REPORTED SHOULD BE HIGHLIGHTED<BR>
			<!--precip settings will go here-->
			<input type="submit" name="updateSettings" value="Submit Changes">
		</form>
		<input type="button" value="Home" onclick="window.location.href='new_wx.php'" />

	</div>
	
</body>
</html>