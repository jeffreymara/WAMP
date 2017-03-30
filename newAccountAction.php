<html>
<?php
require_once("functions.php");
if(empty($_POST['termsAndConditions'])){			//verifies that user agreed to terms and conditions
	echo "</br>You must agree to the terms and conditions";	
	exit();}
if($_POST['termsAndConditions']!="agreed"||""){		//entry must be agreed or nothing, this hasnt been tested
	echo "</br>HACKER";
	exit();}
foreach($_POST as $field => $value){		//All fields complete
	if(empty($value)){
		echo "</br> Must fill in all";
		exit();}}
if($_POST['createPassword'] != $_POST['confirmPassword']){	//Passwords match
	echo "</br>Passwords do not match";
	exit();}
if(!filter_var($_POST['newEmail'],FILTER_VALIDATE_EMAIL)){	//validates email
	echo "</br>Not a valid email";
	exit();}
if(strlen($_POST['createPassword'])<6){						//length of password
	echo "</br>Password must be at least 6 characters";
	exit();}
if(!preg_match("/[?,.!@#$%^=+*a-z()A-Z 0-9]/",$_POST['createPassword'])){
	echo "</br> Invalid characters used";
	exit();}
//Sees if email is free
$emailName = $_POST['newEmail'];
$cxn=mysqli_connect("localhost","root","","usertest")  
	or die ("Could Not Connect1");	
$searchResult = mysqli_query($cxn,"SELECT email FROM login WHERE email='$emailName'");
if(mysqli_num_rows($searchResult)!=0){
	echo"</br>This email has already been registered";
	exit();}
?>
<?PHP
		$encrypPass = password_encrypt($_POST['createPassword']);
		$date = date("Y-m-d h:i:sa");
		mysqli_query($cxn,"INSERT INTO login(email,password,validation,creationDate) VALUES('$emailName','$encrypPass','0','$date')");
echo	"<script> 
		document.getElementById('register').innerHTML = 'A verification email has been sent to $emailName'
		</script>"
		//"<meta http-equiv=\"refresh\" content=\"0;url=verificationEmail.php?email=$emailName\" />";
?>

