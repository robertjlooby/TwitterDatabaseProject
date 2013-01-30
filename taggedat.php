<?php
//Connection parameters
$host = 'cspp53001.cs.uchicago.edu';
$username = 'robertl';
$password = 'doublysecret';
$database = 'robertlDB';

//Attempt to connect
$dbcon = mysqli_connect($host, $username, $password, $database)
	or die('Could not connect: ' . mysqli_connect_error());
print 'Connected successfully!<br>';

$locationtag = $_REQUEST['locationtag'];
$query = "SELECT text
	FROM tweets JOIN taggedat
	USING (tweetid)
	WHERE locationtag='$locationtag'";
$result = mysqli_query($dbcon, $query)
	or die('Query failed: ' . mysqli_error($dbcon));

//print the results
print "Tweets from #$locationtag:<br>";
print '<table border=\"1\">';
print '<tr><td>tweet</td></tr>';
while ($tuple = mysqli_fetch_array($result, MYSQLI_BOTH)){
	print '<tr>';
	print "<td>$tuple[0]</td>";
	print '</tr>';
}
print '</table>';

//free the result
mysqli_free_result($result);

//close connection
mysqli_close($dbcon);
?>
