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
$superlocation = $_REQUEST['superlocation'];
$sublocation = $_REQUEST['sublocation'];
if($superlocation==""){
	$superlocation = NULL;
}
if($sublocation==""){
	$sublocation = NULL;
}
if(is_null($superlocation) or is_null($sublocation)){
	print 'Error: must specify both superlocation and sublocation!<br>';
}else{
	//add tags to DB if necessary
	$query = "INSERT IGNORE
		INTO locationtags (locationname)
		VALUES ('$superlocation'), ('$sublocation')";
	$result = mysqli_query($dbcon, $query)
		or die('Query failed: ' . mysqli_error($dbcon));
	//add subtag relationship
	$query = "INSERT IGNORE
		INTO sublocationof (generallocationname, specificlocationname)
		VALUES ('$superlocation', '$sublocation')";
	$result = mysqli_query($dbcon, $query)
		or die('Query failed: ' . mysqli_error($dbcon));
	
	print '<p>Thank you!<br>';
	print "<p><a href=\"edittags.php?username=$user\">Add another entry to the tag hierarchy!</a></p>";
	print "<p>Click <a href=\"usrhome.php?username=$user\">here</a> to return to your homepage.</p>";
}
print '</body></html>';
//close connection
mysqli_close($dbcon);
?>
