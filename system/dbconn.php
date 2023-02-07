
<?php

//$username = "epiz_27743608";
//$password = "7pz3gvq0";
//$hostname = "sql112.epizy.com";
//$dbname = "epiz_27743608_laracream"; 

$username = "root";
$password = "";
$hostname = "localhost";

$dbconn_directorTraining = mysqli_connect($hostname, $username, $password);
$dbconn_ipadManagement = mysqli_connect($hostname, $username, $password);

//***************** for indicator *****************



mysqli_select_db($dbconn_ipadManagement, 'ipadManagement');

$sql_noti = "SELECT * FROM notifications WHERE timeStamp_noti LIKE CONCAT(CURRENT_DATE(),'%') LIMIT 4 ";
$query_noti = mysqli_query($dbconn_ipadManagement,$sql_noti);

$sql_noti_count = "SELECT * FROM notifications ";
$query_noti_count = mysqli_query($dbconn_ipadManagement,$sql_noti_count);
$count_noti = mysqli_num_rows($query_noti_count);

//for display the total of all ipad
$sql_Users = "SELECT * FROM users ";
$query_Users = mysqli_query($dbconn_ipadManagement,$sql_Users);
$AllUsers = mysqli_num_rows($query_Users);

//for display the total of all ipad
$sql_Dept = "SELECT * FROM department ";
$query_Dept = mysqli_query($dbconn_ipadManagement,$sql_Dept);
$AllDept = mysqli_num_rows($query_Dept);

//for display the total of all ipad
$sql_all = "SELECT * FROM ipad WHERE delete_ipad = '0' ";
$query_all = mysqli_query($dbconn_ipadManagement,$sql_all);
$AlliPad = mysqli_num_rows($query_all);

//for display the total of new ipad 
$sql_new = "SELECT * FROM ipad WHERE status_ipad = '0' && delete_ipad = '0' ";
$query_new = mysqli_query($dbconn_ipadManagement,$sql_new);
$NewiPad = mysqli_num_rows($query_new);

//for display the total of inUse ipad 
$sql_inuse = "SELECT * FROM ipad WHERE status_ipad = '1' && delete_ipad = '0' ";
$query_inuse = mysqli_query($dbconn_ipadManagement,$sql_inuse);
$InUseiPad = mysqli_num_rows($query_inuse);

//for display the total of returned ipad 
$sql_returned = "SELECT * FROM ipad WHERE status_ipad = '2' && delete_ipad = '0' ";
$query_returned = mysqli_query($dbconn_ipadManagement,$sql_returned);
$ReturnediPad = mysqli_num_rows($query_returned);

//for display the total of owner
$sql_allOwner = "SELECT * FROM owner ";
$query_allOwner = mysqli_query($dbconn_ipadManagement,$sql_allOwner);
$AllOwner = mysqli_num_rows($query_allOwner);

//for display the total of new owner
$sql_newOwner = "SELECT * FROM owner WHERE status_owner = '0' ";
$query_newOwner = mysqli_query($dbconn_ipadManagement,$sql_newOwner);
$NewOwner = mysqli_num_rows($query_newOwner);

//for display the total of existing owner
$sql_extOwner = "SELECT * FROM owner WHERE status_owner = '1' ";
$query_extOwner = mysqli_query($dbconn_ipadManagement,$sql_extOwner);
$ExistingOwner = mysqli_num_rows($query_extOwner);

//for display the total of existing owner
$sql_oldOwner = "SELECT * FROM owner WHERE status_owner = '2' ";
$query_oldOwner = mysqli_query($dbconn_ipadManagement,$sql_oldOwner);
$OldOwner = mysqli_num_rows($query_oldOwner);

//for display the total of department
$sql_deptAll = "SELECT * FROM department";
$query_deptAll = mysqli_query($dbconn_ipadManagement,$sql_deptAll);
$deptAll = mysqli_num_rows($query_deptAll);

if (mysqli_connect_errno())
{
	echo "failed to connect to MySQLi: " . mysqli_connect_error();
}

?>