<?php session_start(); 
// Author: 	Tony Hess
// File:    weatherSession
// Purpose: This file is used for verifying that the account the user is trying to log into 
//			exists and sends them on to their own page.


if(isset($_POST['submit'])){ 

    include('dataControl/dbconnect.php');
    
    
    $usr = mysql_real_escape_string($_POST['username']); 
    $pas =  mysql_real_escape_string($_POST['password']);

    //hash the password and check
    $pas = hash("sha256", $pas);

    $sql = mysql_query("SELECT * FROM wx_user  
        WHERE username='$usr' AND 
        password='$pas' 
        LIMIT 1"); 
    
    
		//if the user exists, they will be logged in		
    if(mysql_num_rows($sql) == 1){ 
        $row = mysql_fetch_array($sql); 
        
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username']; 
        $_SESSION['email'] = $row['email'];

        //increment user visit count
        mysql_query("UPDATE wx_user 
            SET total_visits = total_visits + 1
            WHERE id = '$_SESSION[id]'");

		printf("<html><body><script>window.location.href='new_wx.php'</script>");  // go to the page
        exit; 
    }
		// if they dont exist they will be sent back to try again
    else{ 
          $_SESSION['errors'] = array("Username or Password not found."); 
          header('Location: signin.php'); 
          exit; 
    } 
}

else{    //If the form button wasn't submitted go to the login page 
    session_unset();
    header('Location: signin.php');
    exit; 
}

?>



