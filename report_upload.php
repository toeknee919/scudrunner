<?php session_start();
//used for placing image in database from the report form

    //connect to database
    if(!isset($_SESSION['id'])){ 
    	header("Location: signin.php"); 
   	}

    
 
    include('dataControl/dbconnect.php');


    //if someone submits a report and no image
    if(isset($_POST['submit_report']) and $_POST['pic'] == null){
 			$ap_id = strtoupper($_POST['apt_report_id']);

            //check that its a 4 letter identifier, exit if not
            if(!preg_match("/^[a-zA-Z0-9_]{4}$/", $ap_id)){
                printf("<html><body><script>window.location.href='new_wx.php'</script>"); // go to sign in
                exit;
                }

            else{
            $com =  mysql_real_escape_string($_POST['textarea-1']);
            $uid = $_SESSION['id'];
 	
                //query for inserting comment with no image
		 		$sql = "INSERT into airport_reports (airport_id, report_comment, submitter_id) VALUES ('$ap_id','$com','$uid')";
				
                
                if (!mysql_query($sql,$db)){
                    die('Error1: ' . mysql_error()); 
                    }// back to the metar report page  

                else{  
                    printf("<html><body><script>window.location.href='new_wx.php'</script>");  // go to the page
                    exit;
                }
			} 

        }
?>