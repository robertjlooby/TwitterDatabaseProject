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
$query = "SELECT text, username, tweetid
	FROM tweets JOIN sends
	USING (tweetid)
	WHERE username IN 
		(SELECT friend2 AS 'friends'
		FROM friendswith
		WHERE friend1='$user'
		UNION
		SELECT friend1 AS 'friends'
		FROM friendswith
		WHERE friend2='$user')
	OR username IN 
		(SELECT followed
		FROM follows
		WHERE follower='$user')
	OR username IN
		(SELECT username
		FROM resends
		WHERE tweetid=tweets.tweetid)
	ORDER BY timestmp DESC";
$result = mysqli_query($dbcon, $query)
	or die('Query failed: ' . mysqli_error($dbcon));

//print the results
print "<h1>This is the homescreen of $user:</h1><br>";
print '<table border="1">';
print '<tr><th>tweet text</th><th>sender</th><th>retweet</th></tr>';
while ($tuple = mysqli_fetch_array($result, MYSQLI_BOTH)){
	print '<tr>';
	print "<td>$tuple[0]</td>";
	print "<td><a href=\"usrwall.php?username=$user&walluser=$tuple[1]\">$tuple[1]</a></td>";
	print "<td><a href=\"retweet.php?username=$user&tweet=$tuple[2]\">retweet</a></td>";
	print '</tr>';
}
print '</table>';
print "<form method=get action='sendtweet.php'>
		Send a tweet:
		<input type='text' name='text'>
		Tag:
		<input type='text' name='tag'>
		Location:
		<input type='text' name='location'>
		<input type='hidden' name='username' value='$user'>
		<input type='submit' value='Submit'>
	</form>";
print "<form method=get action='usrwall.php'>
		View another user's wall (ex. b96):
		<input type='text' name='walluser'>
		<input type='hidden' name='username' value='$user'>
		<input type='submit' value='Submit'>
	</form>";
print "<form method=get action='addfriend.php'>
		Request to be friends with another user (ex. b96):
		<input type='text' name='tofriend'>
		<input type='hidden' name='username' value='$user'>
		<input type='submit' value='Submit'>
	</form>";
print "<form method=get action='addfollow.php'>
		Begin following another user (ex. b96):
		<input type='text' name='tofollow'>
		<input type='hidden' name='username' value='$user'>
		<input type='submit' value='Submit'>
	</form>";
print "<form method=get action='newtagged.php'>
		See tweets with a given tag (ex. bno):
		<input type='text' name='tag'>
		Include subtags?
		<input type='checkbox' name='incsubs' value='1'>
		<input type='hidden' name='username' value='$user'>
		<input type='submit' value='Submit'>
	</form>";
print "<form method=get action='newtaggedat.php'>
		See tweets from a given locaiton (ex. MBB):
		<input type='text' name='locationtag'>
		Include sublocations?
		<input type='checkbox' name='incsubs' value='1'>
		<input type='hidden' name='username' value='$user'>
		<input type='submit' value='Submit'>
	</form>";
$query2 = "SELECT requester
	   FROM friendrequest
	   WHERE requested='$user'";
$result2 = mysqli_query($dbcon, $query2)
	or die('Query failed: ' . mysqli_error($dbcon));
if(mysqli_num_rows($result2)!=0){
	print '<p>You have pending friend requests from:<br>';
	while ($tuple = mysqli_fetch_array($result2, MYSQLI_BOTH)){
		print "$tuple[0]: click <a href=\"friendaccept.php?username=$user&tofriend=$tuple[0]\">here</a> to accept!<br>";
	}
	print '</p>';
}
print '<p>Click <a href="final.php">here</a> to logout.</p>';
print "<p><a href=\"edittags.php?username=$user\">Help us maintain our tag hierarchy!</a></p>";
print '</body></html>';


//free the result
mysqli_free_result($result);
mysqli_free_result($result2);

//close connection
mysqli_close($dbcon);
?>
