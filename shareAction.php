<?PHP
$email = $_GET["email"];
echo "This is share Action $email";
?>

<form>
<input type="text" name="receivers" size="15" maxlength="30" placeholder="To:" /></p>
<input type="text" name="link" size="50" maxlength="50" placeholder="Link"/></p>
<textarea name="message" cols="20" rows="4">Include a message.</textarea>
</br><input type="submit" value="Send Message"/>
</form>