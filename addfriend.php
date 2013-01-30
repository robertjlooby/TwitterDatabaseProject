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
$tofriend = $_REQUEST['tofriend'];
$query = "INSERT IGNORE INTO friendrequest
		VALUES ('$user', '$tofriend')";
$result = mysqli_query($dbcon, $query)
	or die('Query failed: ' . mysqli_error($dbcon));
print 'Your friend request has been sent!<br>';
print "If $tofriend responds you will become friends!<br>";
print "Click <a href=\"usrhome.php?username=$user\">here</a> to return to your homepage.";
print '</body></html>';

//close connection
mysqli_close($dbcon);
?>
