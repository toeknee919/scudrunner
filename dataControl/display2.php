<?php
//Author:	Anthony Hess
//File:		display.php
//Purpose: 	this is the file for testing the bolding feature for the METAR/TAF bolder.
// 			This file is called by "new_wx.php" which expects a string in return 
// 			containing metar and taf reports for the airports listed in the $apt array.
// 			This file calls two python scripts which retreive metar and
// 			tafs from csv files on the filesystem. 
//  



$apt = array("KDEN", "KSLC", "KSEA", "KMSP", "KORD", "KJFK", "KIAD", "KMIA","KSFO", 
				"KDFW","KLAX", "KLAS", "KATL");



date_default_timezone_set('UTC');
$output .= "Weather Loaded: " . date ('H:i F jS Y') . " GMT<br>MAJOR HUBS:<br><br><br>";

//prints each airprot in the $homeid array
foreach($apt as $id){
	//search the csv file for each current metar
	$string = "python csvSearch.py ". $id;
	$output .= "<div class=\"airportweather\">";
	$output .= shell_exec($string . " metars");

	//search the csv file for each current taf
	$output .=" <br><br>";
	$output .= shell_exec($string . " tafs");
	$output .= "</div>";
	}
	echo $output

?>


