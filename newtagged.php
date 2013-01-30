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
$subs = $_REQUEST['incsubs'];
$tag = $_REQUEST['tag'];
if(isset($_REQUEST['incsubs']) && $subs=='1'){
$subs=1;
$query = "SELECT text, username, tagname
	FROM tweets JOIN tagged
	USING (tweetid)
	JOIN sends
	USING (tweetid)
	WHERE tagname IN
		(SELECT specifictagname
		FROM subtagof
		WHERE generaltagname='$tag')
	OR tagname='$tag'
	ORDER BY timestmp DESC";
}else{
$subs=0;
$query = "SELECT text, username, tagname
	FROM tweets JOIN tagged
	USING (tweetid)
	JOIN sends
	USING (tweetid)
	WHERE tagname='$tag'
	ORDER BY timestmp DESC";
}
$result = mysqli_query($dbcon, $query)
	or die('Query failed: ' . mysqli_error($dbcon));

//print the results
if($subs==0){
	print "<h1>Tweets tagged $tag:</h1><br>";
}else{
	print "<h1>Tweets tagged $tag (or a subtag of $tag):</h1><br>";
}
print '<table border="1">';
print '<tr><th>tweet</th><th>sender</th>';
if($subs==1){
	print '<th>tag</th>';
}
print '</tr>';
while ($tuple = mysqli_fetch_array($result, MYSQLI_BOTH)){
	print '<tr>';
	print "<td>$tuple[0]</td>";
	print "<td><a href=\"usrwall.php?username=$user&walluser=$tuple[1]\">$tuple[1]</a></td>";
	if($subs==1){
		print "<td>$tuple[2]</td>";
	}
	print '</tr>';
}
print '</table>';
print "<p>Click <a href=\"usrhome.php?username=$user\">here</a> to return to your homescreen.</p>";
print '<p>Click <a href="final.php">here</a> to logout.</p>';
print '</body></html>';


//free the result
mysqli_free_result($result);

//close connection
mysqli_close($dbcon);
?>
