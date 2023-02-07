
<?php

$username = "root";
$password = "";
$hostname = "localhost"; 

$dbconn_directorTraining = mysqli_connect($hostname, $username, $password);
$dbconn_ipadManagement = mysqli_connect($hostname, $username, $password);

if (mysqli_connect_errno())
{
	echo "failed to connect to MySQLi: " . mysqli_connect_error();
}

?>