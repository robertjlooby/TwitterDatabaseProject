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

$query = '(SELECT \'follows\' AS table_name, COUNT(*) AS table_size
 FROM follows)
UNION
(SELECT \'friendswith\' AS table_name, COUNT(*) AS table_size
 FROM friendswith)
UNION
(SELECT \'locationtags\' AS table_name, COUNT(*) AS table_size
 FROM locationtags)
UNION
(SELECT \'resends\' AS table_name, COUNT(*) AS table_size
 FROM resends)
UNION
(SELECT \'sends\' AS table_name, COUNT(*) AS table_size
 FROM sends)
UNION
(SELECT \'sublocationof\' AS table_name, COUNT(*) AS table_size
 FROM sublocationof)
UNION
(SELECT \'subtagof\' AS table_name, COUNT(*) AS table_size
 FROM subtagof)
UNION
(SELECT \'tagged\' AS table_name, COUNT(*) AS table_size
 FROM tagged)
UNION
(SELECT \'taggedat\' AS table_name, COUNT(*) AS table_size
 FROM taggedat)
UNION
(SELECT \'tags\' AS table_name, COUNT(*) AS table_size
 FROM tags)
UNION
(SELECT \'tweets\' AS table_name, COUNT(*) AS table_size
 FROM tweets)
UNION
(SELECT \'users\' AS table_name, COUNT(*) AS table_size
 FROM users)';
$result = mysqli_query($dbcon, $query)
	or die('Query failed: ' . mysqli_error($dbcon));

//print the results
print "The tables in $database database are:<br>";
print '<table border=\"1\">';
print '<tr><td>table name</td><td>number in table</td></tr>';
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
