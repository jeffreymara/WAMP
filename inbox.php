<html>
<script src="jquery-1.11.2.min.js"></script>
<?PHP
session_start();
session_regenerate_id(true);
require_once("functions.php");
if (validate_session()==false){
	header("location: test.php");}					//ensures that a session exists, otherwise goes to sign in page

$email = $_GET["email"];
//echo $_COOKIE["email"];
//echo $_COOKIE["password"];
echo "</br>";
echo $_COOKIE['cookie'];/////////////////////////////////////////////////////////////////////////////////////////////
//echo $_SESSION['login_user'];
if(isset($_COOKIE['first'])){
echo $_COOKIE['first'];}


?>
<!-- This is the main inbox page-->
<div id="main"></div>

<?php
echo "<div id=\"inbox\">Inbox</div> <div id=\"share\">Share</div> <div id=\"friends\">Friends</div>";
echo " <a id=\"signout\" href=\"test.php\">Sign Out</a>";

//echo $_COOKIE["loggedIn"] . " ";
//echo $_COOKIE["email"];

	// echo "<meta http-equiv=\"refresh\" content=\"0;url=test.php\" />";}

echo 
"<script>
$(document).ready(function(){
$.post('inboxAction.php?email=$email',function(data){
		$('#main').html(data);
		});	
	});
$('#share').on('click',function(e){								
	$.post('shareAction.php?email=$email',function(data){
		$('#main').html(data);
		});	
	});
$('#inbox').on('click',function(e){								
	$.post('inboxAction.php?email=$email',function(data){
		$('#main').html(data);
		});	
	});
$('#friends').on('click',function(e){								
	$.post('friendAction.php?email=$email',function(data){
		$('#main').html(data);
		});	
	});
</script>"
?>
<script>					//This script destroys the user session upon signing off
$('#signout').on('click',function(e){	
	e.preventDefault();
	$.post('signout.php?email=$email',function(data){
		$('#main').html(data);
		});	
	});
</script>
</html>