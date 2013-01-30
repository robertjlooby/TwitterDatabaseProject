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
if($user==""){
	$user = NULL;
}
if(is_null($user)){
	print 'Error: username must be specified!<br>';
}else{
	$query = "SELECT username
		FROM users
		WHERE username='$user'";
	$result = mysqli_query($dbcon, $query)
		or die('Query failed: ' . mysqli_error($dbcon));
	if(mysqli_num_rows($result)==0){
		print "Account for $user not found!<br>";
		print "Click <a href=\"join.html\">here</a> to join!<br>";
		print "Click <a href=\"signin.html\">here</a> to sign in with a different usernamer!<br>";
	}else{
		print "Welcome back $user!<br>";
		print "Click <a href=\"usrhome.php?username=$user\">here</a> to continue to your homepage.";
	}
}
print '</body></html>';
//free the result
mysqli_free_result($result);

//close connection
mysqli_close($dbcon);
?>
