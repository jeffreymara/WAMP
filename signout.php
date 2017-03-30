<html>
<?php
//Destroy sessions
session_start();
$email = $_SESSION['login_user'];
session_destroy();

//Destroy Cookies
setcookie ('cookie',"",time()-100,'/');
unset($_COOKIE['cookie']);
$destroyed = "gone";
$cxn=mysqli_connect("localhost","root","","usertest")  
		or die ("Could Not Connect1");	
    mysqli_query($cxn,"UPDATE login SET userCookie = '$destroyed' WHERE email = '$email'");

echo "<script> window.location=\"test.php\"
		</script>"
?>
</html>