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
$tweetid = $_REQUEST['tweet'];
$query = "INSERT IGNORE
	INTO resends (tweetid, username)
	VALUES ('$tweetid', '$user')";
$result = mysqli_query($dbcon, $query)
	or die('Query failed: ' . mysqli_error($dbcon));
print '<p>Tweet resent!<br>';
print "Click <a href=\"usrhome.php?username=$user\">here</a> to return to your homepage.";
print '</body></html>';
//close connection
mysqli_close($dbcon);
?>
