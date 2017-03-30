<html>
<body>
<h2>Create New Account</h2>
<form id="register" action="newAccountAction.php" method="post">  <!--not sure if these can all be post-->
	<p>Email <input type="text" name="newEmail" size="15" maxlength="50" /></p>

	<p>Password <input type="password" name="createPassword" size="15" maxlength="30" /></p>

	<p>Confirm Password <input type="password" name="confirmPassword" size="15" maxlength="30" /></p>
	
	<input type="checkbox" name="termsAndConditions" value="agreed" /> Agree to terms and conditions</br></br>

	<input type="submit" value="Press to Submit"/>
</form>

	<div id="errorMessages"></div>
	
<script src="jquery-1.11.2.min.js"></script>	
<script>
$('#register').on('submit',function(e){					//When the form with ID register is submitted, this function is called
	e.preventDefault();									//the default of going to a new page is prevented
	var details = $('#register').serialize();			//form data collected by serialize function
	$.post('newAccountAction.php',details,function(data){
		$('#errorMessages').html(data);
		});	//form data sent to php file, when its returned the html data is posted
	});
</script>		
	</body>
</html>
