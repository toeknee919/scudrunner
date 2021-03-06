<?php session_start();
/*
Author: 	Anthony Hess
File: 		new_wx.php
Purpose: 	This is the main page for testing the weather bolding features. It calls
			a php program "display2.php" which then retreives the weather reports for 
			the airport identifiers listed in that file. That retreives these reports by 
			calling a python script csvSearch.py which searches csv files on the system which contain the 
			current weather reports that NOAA publishes. These reports come out every 5 minues and 
			can be updated on the computer system by calling "load_CSV_met.py" or load_CSV_taf.py.
*/

			if(!isset($_SESSION['id'])){ 
				header("Location: signin.php"); 
			}

			include('dataControl/dbconnect.php');

			?>

			<!DOCTYPE html>
			<html>
			<head>
				<meta charset="utf-8"/>
				<meta name="viewport" content="width=device-width, initial-scale=1"/> 
				<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" /> -->
				<script type="text/javascript" src="javascript/jquery-1.11.0.min.js"></script>
				<script type="text/javascript" src="javascript/jquery.mobile-1.3.2.min.js"></script>
				<script type="text/javascript" src="javascript/formatWx.js"></script>
				<script type="text/javascript" src="javascript/bootstrap.min.js"></script>
				<title>Personal Weather Data</title>


				<style>
				body{
					height: 100%;
					max-width: 600px;
					background-color: #555555;
					margin: 0 auto;
					color:#555555;
				}
				h2{
					color:#777777;
					text-shadow:0px 1px 0px rgba(255,255,255,0), 0px 4px 15px rgba(0,0,0,1.7);
					text-align: center;
					max-width: 600px;
					
				}
				h4{
					color:#33bbcc;
					text-align: center;
					margin-bottom: 0px;
				}
				#loadwx{
					max-width: 600px;
					min-height:100%;
					background: linear-gradient(#4d4d4d, #3f3f3f, #7c7c7c);
					margin: 0 auto;
					border:8px solid;
					border-color: #949494;
				}
				#airportID{
					margin-left:15px;
					margin-bottom: 10px;
					background-color: transparent;
					color: transparent;
					text-shadow: 0px 2px 3px rgba(255,255,255,0.5);
					font-size: 16px;
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
				#notams{
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
				#lep{
					max-width: 600px;
					width:95%;
					font-size: 10px;
					background-color: #555555;
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
				#rep{
					max-width: 600px;
					font-size: 10px;
					background-color: #555555;
					color:#ffffff;
					font:sans-serif;
					text-shadow: none;
					border:3px solid;
					border-color: #555555;
					border-radius: 3px;
					margin: 0 auto;


				}
				div.airportweather{
					margin:7px;
					padding: 3px;
					background: linear-gradient(#575555, #5A5656, #353133);
					border: 2px solid;
					border-color: #333;
					border-radius: 3px;
					box-shadow: 5px 3px 3px #333;
				}

				.ui-input-text{
					width: 60px !important;
					display:inline-block;
				}
				label{
					color:white;
					text-shadow: none;
				}
				#user{
					text-shadow: none;
					color:#ffffff;
					background-color: #949494;
				}
				b{
					color: #33bbcc;
				}
				input[type=button]{	
					width:120px;
					border-radius: 3px;
					border:none;
					color:white;
					background-color: #33bbcc;	
					height:26px;
					margin-left:15px;

				}
				tab{
					margin-left: 15px;
				}
				#reportForm{
					max-width: 300px;
					color:white;
					margin:15px;
					padding: 7px;
					border-radius: 3px;
					box-shadow: 3px 3px 3px #333;
					font-size: 16px;
					border:1px solid;
					border-color: #848484;

				}
				textarea.ui-input-text{
					width:100% !important;
					color:black;
				}
				input.ui-input-text{
					color:black;
				}
				input#sub, input#apt, input.body-button{
					color:black;
					border-radius: 3px;
				}

				input.head-button{
					float:right;
					height:20px;
					width:75px;
					margin-left:3px;
				}
				input[type=submit]{
					color: black;
					font-size: 16px;
				}

				</style>



				<script type="text/javascript">	

	//*******************************************************************
	// while the window loads, metars and tafs will be edited then loaded
	//*******************************************************************
	window.onload = function(){
		
		//check if session started to reload the last weather requested (set inside displayApt.php)
		var a = "<?php echo $_SESSION['home_apt'];?>";
		if(a){
			Airport(a);
		}
		else{
			console.log("Home airport not found, home value = " + a);					
		}
	}

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
	        var wx_lim = <?php $a = mysql_query("SELECT * FROM wx_limitations WHERE id = '$_SESSION[id]'");
	        while($row = mysql_fetch_array($a)){
	        	echo json_encode($row);
	        };?>;
	        
	        var apt_rep = <?php $a = mysql_query("SELECT * FROM spec_apt_reports WHERE id = '$_SESSION[id]'");
	        while($row = mysql_fetch_array($a)){
	        	echo json_encode($row);
	        };?>;
	        
	        all = boldline(all, wx_lim, apt_rep);
	        document.getElementById("all").innerHTML = all;
	        $('#rep').load(document.URL +  ' #rep');
	    },

	    error: function () {
	    	$('#test').html('Bummer: there was an error!');
	    }
	});

		document.getElementById("metar-label").innerHTML = "Metar and TAF For " + t.toUpperCase();
		document.getElementById("notam-label").innerHTML = "Notams For " + t.toUpperCase();
		document.getElementById("notams").innerHTML = "Loading Notams";


		$.ajax({
			url:'dataControl/notamreq.php',
			type: "GET",
			data: {'airport': t },
			complete: function (data) {
				n = data.responseText;
				document.getElementById("notams").innerHTML = n;
			},

			error: function () {
				$('#test').html('Bummer: there was an error!');
			}
		});

		$('#apt').val(''); 
	}

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


	</script>


</head>

<body>
	
	<!-- This is the form for getting a weather report-->
	<div id = "loadwx">
		
		<div id="user">User: <?php echo $_SESSION['username'];?>
			
			<input type="button" value="Settings" class="head-button" onclick="window.location.href='weax_database.php'"/>
			<input type="button" value="Sign Out" class="head-button" onclick="window.location.href='signin.php'"/>
			
		</div>
		<h2>Scud Runner Weather</h2>
		
		
		<form id = "airportID" role="search">
			<label>Airport 4 letter ID:</label><br>
			<span>
				<input type="text" maxlength="4" name="apt" id="apt"  />
				<input type="button" id="sub" class="body-button" onclick="Airport(document.getElementById('apt').value)" value="Get Weather"/>
			</span>
		</form>


		<!--Displays the metar/tafs-->
		<h4 id="metar-label"></h4>
		<div id="all"></div>

		<h4 id="notam-label"></h4>
		<div id="notams">Loading</div>
		<!--Displays user reports for specified airport-->
		<div id ="lep">
			<div id = "rep"> 
				<label>HERE ARE THE MOST RECENT AIRPORT COMMENTS FOR: <?php echo $_SESSION['apid'];?></label><br> 
				<?php 
				$_SESSION['apid'];
				$sql = mysql_query("SELECT * FROM airport_reports WHERE airport_id = '$_SESSION[apid]' ORDER BY time_added desc");
				while ($row = mysql_fetch_array($sql)){
					$sql2 = mysql_query("SELECT * FROM wx_user WHERE id='$row[submitter_id]' LIMIT 1");
					$row2 = mysql_fetch_array($sql2);
					echo "<div class='airportweather'>AT: " . $row['time_added'] . "<br>USER: " . $row2['username'] . "<br><tab>REMARK: " . $row['report_comment'] . "</div>";
				}
				?>
			</div>
		</div>
		<!--<input type="button" class="body-button" value="Report Conditions" onclick="generate_report_form()"/>-->

		
		<div id="reportForm">
			<form action="report_upload.php" method="POST" name="wx_report_form" id="wx_report_form"  enctype="multipart/form-data">
				Airport ID: <input type="text" maxlength="4" name="apt_report_id" id="apt_report_id" /><br>
				Airport Comments: <textarea cols="40" rows="8" name="textarea-1" id="textarea-1" maxlength="250" ></textarea>
				<!--<br>Give us an image:<br><input type="file" name="pic" accept="image/*" ><br>-->
				<input type="submit" name="submit_report" value="Submit Airport Report"/>
			</form>
		</div>
	</div>

</body>
</html>