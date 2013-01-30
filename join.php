<?php
//Connection parameters
$host = 'cspp53001.cs.uchicago.edu';
$username = 'robertl';
$password = 'doublysecret';
$database = 'robertlDB';

//Attempt to connect
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());
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
$email = $_REQUEST['email'];
$real = $_REQUEST['realname'];
if($user==""){
	$user = NULL;
}
if($email==""){
	$email = NULL;
}
if($real==""){
	$real = NULL;
}
if(is_null($user) or is_null($email)){
	print 'Error: username and email must be specified!<br>';
}else{
	$query = "INSERT IGNORE
		INTO users
		VALUES ('$user', '$email', '$real')";
	$result = mysqli_query($dbcon, $query)
		or die('Query failed: ' . mysqli_error($dbcon));

	if(mysqli_affected_rows($dbcon) == 0){
	print "Your username is already in use!<br>Please try a different one!";
	}
	else {
	print "Welcome to TBP '$user'!!<br>";
	print "Click <a href=\"usrhome.php?username=$user\">here</a> to continue to your homepage.";
	}
}
print '</body></html>';
//free the result
//mysqli_free_result($result);

//close connection
mysqli_close($dbcon);
?>
