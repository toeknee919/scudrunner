<?php session_start(); 
// Author: 	Tony Hess
// File: 	UpdateSettings.php
// Purpose: This file is used for updatting the user settings when
//          they press the submit button on the weax_database.php page


if(isset($_POST['updateSettings'])){ 

    $dbHost = "localhost";   //Location Of Database/localhost 
    $dbUser = "toeknee919";           		 //Database User Name 
    $dbPass = "portland";            //Database Password 
    $dbDatabase = "toeknee919";    			//Database Name 
     
    $db = mysql_connect($dbHost,$dbUser,$dbPass)or die("Error connecting to database."); 
    //Connect to the database 
    mysql_select_db($dbDatabase, $db)or die("Couldn't select the database."); 
 
 //set the slider variables for limitations (wx_limitations)
    $s1 = $_POST['slider-1'];
    $s2 = $_POST['slider-2'];
    $s3 = $_POST['slider-3'];
    $s4 = $_POST['slider-4'];
    $s5 = $_POST['slider-5'];
    $s6 = $_POST['slider-6'];
    $s7 = $_POST['slider-7'];
    $s8 = $_POST['slider-8'];
    $s9 = $_POST['slider-9'];

//set the radio button variables for Phenomena (spec_apt_reports)
    $c1 = ($_POST['checkbox-1'] == on ? 1 : 0);
    $c2 = ($_POST['checkbox-2'] == on ? 1 : 0);
    $c3 = ($_POST['checkbox-3'] == on ? 1 : 0);
    $c4 = ($_POST['checkbox-4'] == on ? 1 : 0);
    $c5 = ($_POST['checkbox-5'] == on ? 1 : 0);
    $c6 = ($_POST['checkbox-6'] == on ? 1 : 0);
    $c7 = ($_POST['checkbox-7'] == on ? 1 : 0);
    $c8 = ($_POST['checkbox-8'] == on ? 1 : 0);
    $c9 = ($_POST['checkbox-9'] == on ? 1 : 0);
    $c10 = ($_POST['checkbox-10'] == on ? 1 : 0);
    $c11 = ($_POST['checkbox-11'] == on ? 1 : 0);
    $c12 = ($_POST['checkbox-12'] == on ? 1 : 0);
    $c13 = ($_POST['checkbox-13'] == on ? 1 : 0);

    // update the limitations table		
	$sql = mysql_query("UPDATE wx_limitations SET visibility='$s1',
                                                    ceilings='$s2',
                                                    anyCloud='$s3',
                                                    wind_limit='$s4',
                                                    l_temp='$s5',
                                                    h_temp='$s6',
                                                    temp_dew_spread='$s7',
                                                    metar_vtime='$s8',
                                                    taf_vtime='$s9' 
                                                    WHERE id = '$_SESSION[id]'");	
    if(!$sql){
        echo "Query to limitations failed";
    }

    // update the special airpot conditions table
    $sql = mysql_query("UPDATE spec_apt_reports SET slpno='$c1',
                                                    rvrno='$c2',
                                                    snincr='$c3',
                                                    presrr='$c4',
                                                    presfr='$c5',
                                                    acft_mshp='$c6',
                                                    ltg='$c7',
                                                    fzrano='$c8',
                                                    fropa='$c9',
                                                    visno='$c10',
                                                    wshft='$c11',
                                                    tsno='$c12',
                                                    pk_wnd='$c13' WHERE id = '$_SESSION[id]'");

    if(!$sql){
        echo "Query to limitations failed";
    }
	
    // back to the metar report page	
	printf("<html><body><script>window.location.href='new_wx.php'</script>");  // go to the page
    exit; 
    



}else{    //If the form button wasn't submitted go to the login page 
	session_unset();
    header('Location: signin.php');
	exit; 
}

?>