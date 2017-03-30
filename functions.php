<?php
function password_encrypt($password_to_encrypt){				//For information on how this encryption process works see https://www.youtube.com/watch?v=twpT_bEfVEI
	$hash_format = "$2y$10$";
	$salt = generate_salt();
	$format_and_salt = $hash_format . $salt;
	$hash = crypt($password_to_encrypt, $format_and_salt);
	return $hash;
}

function generate_salt(){
	$unique_random_string = md5(uniqid(mt_rand(), true));
	$base64_string = base64_encode($unique_random_string);
	$modified_base64_string = str_replace('+','.',$base64_string);
	$salt = substr($modified_base64_string, 0 , 22);
	return $salt;
}

function check_token($token){
	if($token != $_SESSION['user_token']){
		unset($_SESSION['user_token']);
	
		exit;}
	else{unset($_SESSION['user_token']);}
}

function do_not_remember_me_signIn($username){
session_regenerate_id(true);
$_SESSION['login_user'] = $username;
$_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
$_SESSION['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
}

function validate_session(){
	if(isset($_SESSION['login_user']) && isset($_SESSION['HTTP_USER_AGENT']) && isset($_SESSION['REMOTE_ADDR'])){
		if($_SESSION['HTTP_USER_AGENT'] == $_SERVER['HTTP_USER_AGENT'] && $_SESSION['REMOTE_ADDR'] == $_SERVER['REMOTE_ADDR']){
			if(isset($_GET["email"])&& $_GET["email"] != $_SESSION['login_user']){
				Return false;}
			else{Return true;}
		}
		else{
			Return false;}}
	else{
	Return false;}
	}
		
////////////////////////COOKIE VALIDATION////////////////////////////////////////////////////////////////////////
function create_cookie($user_email){
//Create Random Token
	$unique_random_string_2 = md5(uniqid(mt_rand(), true));
	$base64_string_2 = base64_encode($unique_random_string_2);
	$modified_base64_string_2 = str_replace('+','.',$base64_string_2);
	$token = substr($modified_base64_string_2, 0 , 128);
//store token in database (NEED TO REMOVE SQL INJECTION)
	$cxn=mysqli_connect("localhost","root","","usertest")  
		or die ("Could Not Connect1");	
	mysqli_query($cxn,"UPDATE login SET userCookie = '$token' WHERE email = '$user_email'");
//make cookie = $user+$token
	$cookie = $user_email . ':' . $token;
//mac equals the above encrypted
	$mac = md5($cookie);
//append cookie with mac
	$cookie .= ':' . $mac;
//set the cookie
	setcookie ('cookie',"$cookie",time()+ 2419200,'/');
}

function cookie_validation(){
if(!isset($_COOKIE['first'])){
	return false;}
//separate cookie into 3 components 2419200
else{
	list($user,$token,$mac) = explode(':',$cookie);
		//ensure that mac still equals the encryption of the other 2
		if($mac !== md5($user . ':' . $token)){
			return false;}
	//secondly ensure that token in database still equals token in cookie
	$cxn=mysqli_connect("localhost","root","","usertest")  
		or die ("Could Not Connect1");	
	$searchResult = mysqli_query($cxn,"SELECT userCookie FROM login WHERE email='$user'");
	$userCookieData = mysqli_fetch_row($searchResult);
		if($userCookieData[0]!=$token){
			return false;}
		else{	
			return true;}
}
}
function timingSafeCompare($safe, $user) {
    $safe .= chr(0);
    $user .= chr(0);
    $safeLen = strlen($safe);
    $userLen = strlen($user);
    $result = $safeLen - $userLen;
    for ($i = 0; $i < $userLen; $i++) {
        $result |= (ord($safe[$i % $safeLen]) ^ ord($user[$i]));}
	if($result === 0){
		return true;}
	else{
		return false;}
}


?>
	