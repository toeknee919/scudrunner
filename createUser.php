<?php session_start(); 
// Author: 	Tony Hess
// Email: 	
// File: 	CreateUser
// Purpose: This file is used for verifying that the account the user is creating can be used 
//			and then adds the user and their information to the database.

if(isset($_POST['create'])){ 
	
	include('dataControl/dbconnect.php');
 
 

    $usr = mysql_real_escape_string($_POST['CRname']); 
    $pas =  mysql_real_escape_string($_POST['CRpassword']);
	$apt = strtoupper($_POST['CRairport']);
	$email =  mysql_real_escape_string($_POST['CRemail']);



///////////////////// Checks each entry meets criteria
	if (!preg_match("/^[a-zA-Z0-9+.*]{6,}$/", $pas)) {
		$_SESSION['errors'] = array("Your password did not meet the criteria."); 
		header("Location: UserCreateForm.php"); // go to try again
		exit;
	} 
		
	if (!preg_match("/^[a-zA-Z0-9_]{6,}$/", $usr)) {
		$_SESSION['errors'] = array("Your username did not meet the criteria of 6 or more letters or numbers."); 
		header("Location: UserCreateForm.php"); // go to try again
		exit;
	} 
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$_SESSION['errors'] = array("Please enter a valid email."); 
		header("Location: UserCreateForm.php"); // go to try again
		exit;
	}
	if (!preg_match("/^[a-zA-Z0-9]{4}$/", $apt)) {
		$_SESSION['errors'] = array("Airport needs to be a 4 letter identifier."); 
		header("Location: UserCreateForm.php"); // go to try again
		exit;
	} 
////////////////////


	//verifys username can be used
    $sql = mysql_query("SELECT * FROM wx_user WHERE username='$usr'"); 
	$count = mysql_num_rows($sql);
	
    if($count >= 1){ 
		$_SESSION['errors'] = array("Username already used, please try again."); 
        header("Location: UserCreateForm.php"); 
        exit; 
    } 
    
    //hash the password
    $pas = hash("sha256", $pas);
	
	//inserts the name/pword and email into DB
	$sql="INSERT INTO wx_user (username, password, email, total_visits, home_apt) VALUES ('$_POST[CRname]','$pas','$_POST[CRemail]', 0, '$apt')";

		if (!mysql_query($sql,$db)){
		  die('Error1: ' . mysql_error()); }

	//get the new users id # assigned to them
	$sql = mysql_query("SELECT id FROM wx_user  
        				WHERE username='$usr' AND 
        				password='$pas' 
        				LIMIT 1");	  

	if(mysql_num_rows($sql) == 1){ 
        $row = mysql_fetch_array($sql); 
        }

    $newid = $row['id'];


    //gives the user tables for settings 
	$sql="INSERT INTO wx_limitations(id) VALUES ('$newid')";
	if (!mysql_query($sql,$db)){
		  die('Error1: ' . mysql_error()); }

	$sql="INSERT INTO spec_apt_reports(id) VALUES ('$newid')";
	if (!mysql_query($sql,$db)){
		  die('Error1: ' . mysql_error()); }

	$sql="INSERT INTO wx_conditions(id) VALUES ('$newid')";
	if (!mysql_query($sql,$db)){
		  die('Error1: ' . mysql_error()); }
		
		else{		
			$_SESSION['errors'] = array("Your account has been created. Please log in."); 
			printf("<html><body><script>window.location.href='signin.php'</script>"); // go to sign in
			exit;	
			}		
	}

else{    //If the form button wasn't submitted go to the login page 
    header("Location: signin.php");     
    exit; 
}

?>
