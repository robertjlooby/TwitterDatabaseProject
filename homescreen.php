<?php
//Connection parameters
$host = 'cspp53001.cs.uchicago.edu';
$username = 'robertl';
$password = 'doublysecret';
$database = 'robertlDB';

//Attempt to connect
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());

$user = $_REQUEST['username'];
$query = "SELECT text, username
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
	ORDER BY timestmp";
$result = mysqli_query($dbcon, $query)
	or die('Query failed: ' . mysqli_error($dbcon));

//print the results
print "This is the homescreen of $user:<br>";
print '<table border=\"1\">';
print '<tr><td>tweet</td><td>sender</td></tr>';
while ($tuple = mysqli_fetch_array($result, MYSQLI_BOTH)){
	print '<tr>';
	print "<td>$tuple[0]</td>";
	print "<td>$tuple[1]</td>";
	print '</tr>';
}
print '</table>';

//free the result
mysqli_free_result($result);

//close connection
mysqli_close($dbcon);
?>
