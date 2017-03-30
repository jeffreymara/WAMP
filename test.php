<html>
<?php
//////////VALIDATION DO NOT CHANGE////////////////////////////////////////////////////////////
session_start();	
require_once("functions.php");
$token = $_SESSION['user_token']= md5(uniqid());   //Creates Session token				
if(validate_session()==true){						//if the user is already logged in, they are redirected to their inbox. 
	$loginUser = $_SESSION['login_user'];
	header("Location: inbox.php?email=$loginUser");}
else{
if(isset($_COOKIE['cookie'])){
	list($user,$token,$mac) = explode(':',$_COOKIE['cookie']);  //cookie is not getting validated, only checking to ensure it exists
	$loginUser = $user;
	do_not_remember_me_signIn($loginUser);	;
	header("Location: inbox.php?email=$loginUser");}
	}
//////////VALIDATION DO NOT CHANGE////////////////////////////////////////////////////////////
echo $_COOKIE['cookie'];
?>
<head><title>PHP Test</title></head>
<body>

<h3>Welcome to ShareBar</h2>

<!--Username Input-->

<form action="signInAction.php" method="post" id="signIn">  <!--not sure if these can all be post-->
	<p>Email <input id="email" type="text" name="email" size="15" maxlength="30" /></p>

<!--Password-->
	<p>Password <input id="password" type="password" name="password" size="15" maxlength="30" /></p>
	
		<input type="checkbox" name="cookie" checked="yes">Stay signed in</input>

<!--Button-->
	</br><input type="submit" value="Press to Submit"/>
	<input type="hidden" name="token" value="<?php echo $token; ?>" /> <!--Sends session token to next page -->
</form>
<div id="errorMessage"></div>

<a href="newAccount.php" target="_blank">Create New Account</a>

<?php
$cxn=mysqli_connect("localhost","root","","usertest")  //connects to sql server, in future put this information in hidden file
	or die ("Could Not Connect1");						//this message printed if connection fails
$password = mysqli_query($cxn,"SELECT password FROM login WHERE email = 'jeff'")	//selects password column from login table where user is jeff
	or die("NOPE!");
$row1 = mysqli_fetch_row($password);			//puts data received from $password into numeric array (could also be associative where words descrive the array objects
$numberofrows = mysqli_num_rows($password); //finds size of array
?>
<script src="jquery-1.11.2.min.js"></script>		<!--This grabs the JQuery Library -->
<script>
$('#signIn').on('submit',function(e){					
	e.preventDefault();									
	var details = $('#signIn').serialize();			
	$.post('signInAction.php',details,function(data){
	$('#errorMessage').html(data);});	
	});
$('#email,#password').on('focus',function(e){
	$('#errorMessage').html("");});

	</script>		
</body></html>