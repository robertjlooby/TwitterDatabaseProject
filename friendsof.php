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

$user = $_REQUEST['username'];
$query = "(SELECT friend2 AS 'friend'
	FROM friendswith
	WHERE friend1='$user')
	UNION
	(SELECT friend1 AS 'friend'
	FROM friendswith
	WHERE friend2='$user')";
$result = mysqli_query($dbcon, $query)
	or die('Query failed: ' . mysqli_error($dbcon));

//print the results
print "The friends of $user are:<br>";
print '<ul>';
while ($tuple = mysqli_fetch_row($result)){
	print "<li>$tuple[0]</li>";
}
print '</ul>';

//free the result
mysqli_free_result($result);

//close connection
mysqli_close($dbcon);
?>
