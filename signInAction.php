<html>
<?php
session_start(); //starts PHP session
require_once("functions.php");
if($_POST['token']!=$_SESSION['user_token']){
	session_destroy();
	header("Location: 404.php");} //checks the session token
//verifies an email has been entered
if(empty($_POST['email'])){			
	echo "</br>You forgot to enter your email.</br>";	
	exit();}
//verifies a password has been entered
if(empty($_POST['password'])){	
	echo "</br>You forgot to enter your password.</br>";	
	exit();}

$email = $_POST['email'];

$cxn=mysqli_connect("localhost","root","","usertest")  
	or die ("Could Not Connect1");	
$searchResult = mysqli_query($cxn,"SELECT email FROM login WHERE email='$email'");
if(mysqli_num_rows($searchResult)!=0){
	$passwordSearch = mysqli_query($cxn, "SELECT password FROM login WHERE email='$email'");
	$password = mysqli_fetch_row($passwordSearch);
		if($password[0]==crypt($_POST['password'],$password[0])){
			do_not_remember_me_signIn($email);					//creates session upon signing in
				if($_POST['cookie']){
						create_cookie($email);
				}
				
			echo "<meta http-equiv=\"refresh\" content=\"0;url=inbox.php?email=$email\" />";
			exit();}
		else{
			echo "username and password do not match";}}
else{
	echo "</br>This email has not been registered</br>";}

?>
</html>

