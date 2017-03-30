<?PHP
$email = $_GET["email"];
echo "<h3> Welcome to ShareBar $email </h3>";
$cxn=mysqli_connect("localhost","root","","usertest")  
	or die ("Could Not Connect1");	
//get senders
$searchResultSender = mysqli_query($cxn,"SELECT sender FROM messaging where receiver='$email'")
	or die("<b>You have no messages</b>");
$searchResultLink = mysqli_query($cxn,"SELECT link FROM messaging where receiver='$email'")
	or die("");
$searchResultMessage = mysqli_query($cxn,"SELECT message FROM messaging where receiver='$email'")
	or die("");
$nrows = mysqli_num_rows($searchResultSender);
echo "You Have $nrows messages!</br>";
//Make Table
echo "<form id=\"delete\" action=\"deleteMessage.php\">";
echo "<table border=\"2\">";
for($i=0;$i<$nrows;$i++){
	echo"<tr id=$i><td>";
	echo mysqli_fetch_row($searchResultSender)[0];
	echo"</td><td>";
	echo "<a target=\"_blank\" href=";
	$link = mysqli_fetch_row($searchResultLink)[0];
	echo $link;
	echo ">$link</a>";
	echo"</td><td>";
	echo mysqli_fetch_row($searchResultMessage)[0];
	echo"</td><td>";
	echo "<input class=\"$i\" type=\"submit\" value=\"Delete\">";
	echo"</td></tr>";}
echo "</table>";
echo "</form>";
?>
<script src="jquery-1.11.2.min.js"></script>
<script>
$('#delete').on('submit',function(e){					
	e.preventDefault();		
	});
</script>