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
  <meta charset="utf-8">
  <title>CSPP 53001 TBP</title>
  <link rel="stylesheet" type="text/css" href="http://reset5.googlecode.com/hg/reset.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
<head>
</head>
<body>
	<h1>Welcome to my TBP app!</h1>
	<div id="joinbox">Click <a href="join.html">here</a> to join!</div>
	<div id="signinbox">Click <a href="signin.html">here</a> to sign in!</div>
	<div id="homefeed">';
$query = '(SELECT \'number of users\' AS table_name, COUNT(*) AS table_size
 FROM users)
UNION
(SELECT \'number of tweets sent\' AS table_name, COUNT(*) AS table_size
 FROM tweets)
UNION
(SELECT \'tags\' AS table_name, COUNT(*) AS table_size
 FROM tags)
UNION
(SELECT \'locations\' AS table_name, COUNT(*) AS table_size
 FROM locationtags)';
$result = mysqli_query($dbcon, $query)
	or die('Query failed: ' . mysqli_error($dbcon));

//print the results

print '<table border=\"1\">';
//print '<tr><td>table name</td><td>number in table</td></tr>';
while ($tuple = mysqli_fetch_array($result, MYSQLI_BOTH)){
	print '<tr>';
	print "<td>$tuple[0]</td>";
	print "<td>$tuple[1]</td>";
	print '</tr>';
}
print '</table>';
print '</div></body></html>';
//free the result
mysqli_free_result($result);

//close connection
mysqli_close($dbcon);
?>
