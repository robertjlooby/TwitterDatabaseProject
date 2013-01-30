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
$supertag = $_REQUEST['supertag'];
$subtag = $_REQUEST['subtag'];
if($supertag==""){
	$supertag = NULL;
}
if($subtag==""){
	$subtag = NULL;
}
if(is_null($supertag) or is_null($subtag)){
	print 'Error: must specify both supertag and subtag!<br>';
}else{
	//add tags to DB if necessary
	$query = "INSERT IGNORE
		INTO tags (tagname)
		VALUES ('$supertag'), ('$subtag')";
	$result = mysqli_query($dbcon, $query)
		or die('Query failed: ' . mysqli_error($dbcon));
	//add subtag relationship
	$query = "INSERT IGNORE
		INTO subtagof (generaltagname, specifictagname)
		VALUES ('$supertag', '$subtag')";
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
