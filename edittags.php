<?php
print '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
<head>
  <meta charset="utf-8">
  <title>CSPP 53001 TBP</title>
  <link rel="stylesheet" type="text/css" href="http://reset5.googlecode.com/hg/reset.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>';
$user = $_REQUEST['username'];
print '<h2>Thank you for helping us maintain our tag hierarchy!</h2>';
print "<form method=get action='addsubtag.php'>
		What is the supertag?
		<input type='text' name='supertag'>
		What is the subtag?
		<input type='text' name='subtag'>
		<input type='hidden' name='username' value='$user'>
		<input type='submit' value='Submit'>
	</form>";
print "<form method=get action='addsublocation.php'>
		What is the superlocation?
		<input type='text' name='superlocation'>
		What is the sublocation?
		<input type='text' name='sublocation'>
		<input type='hidden' name='username' value='$user'>
		<input type='submit' value='Submit'>
	</form>";
print "<p>Click <a href=\"usrhome.php?username=$user\">here</a> to return to your homescreen.</p>";
print '<p>Click <a href="final.php">here</a> to logout.</p>';
print '</body></html>';
?>
