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
$text = $_REQUEST['text'];
$tag = $_REQUEST['tag'];
$location = $_REQUEST['location'];
if($user==""){
	$user = NULL;
}
if($text==""){
	$text = NULL;
}
if($tag==""){
	$tag = NULL;
}
if($location==""){
	$location = NULL;
}
if(is_null($user) or is_null($text)){
	print 'Error: cannot send a blank text!<br>';
}else{
	//add tag and location to DB if necessary
	$query = "INSERT IGNORE
		INTO tags (tagname)
		VALUES ('$tag')";
	$result = mysqli_query($dbcon, $query)
		or die('Query failed: ' . mysqli_error($dbcon));
	$query = "INSERT IGNORE
		INTO locationtags (locationname)
		VALUES ('$location')";
	$result = mysqli_query($dbcon, $query)
		or die('Query failed: ' . mysqli_error($dbcon));
	//send the tweet
	$query = "INSERT IGNORE
		INTO tweets (text, locationstamp)
		VALUES ('$text', '$location')";
	$result = mysqli_query($dbcon, $query)
		or die('Query failed: ' . mysqli_error($dbcon));
	//update sends, tagged, taggedat
	$query = "INSERT IGNORE
		INTO sends (username, tweetid)
		VALUES ('$user', LAST_INSERT_ID())";
	$result = mysqli_query($dbcon, $query)
		or die('Query failed: ' . mysqli_error($dbcon));
	$query = "INSERT IGNORE
		INTO tagged (tagname, tweetid)
		VALUES ('$tag', LAST_INSERT_ID())";
	$result = mysqli_query($dbcon, $query)
		or die('Query failed: ' . mysqli_error($dbcon));
	$query = "INSERT IGNORE
		INTO taggedat (locationtag, tweetid)
		VALUES ('$location', LAST_INSERT_ID())";
	$result = mysqli_query($dbcon, $query)
		or die('Query failed: ' . mysqli_error($dbcon));

	print '<p>Tweet sent!<br>';
	print "Click <a href=\"usrhome.php?username=$user\">here</a> to return to your homepage.";
}
print '</body></html>';
//close connection
mysqli_close($dbcon);
?>
