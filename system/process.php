<?php

session_start();
include("./dbconn.php");

//mysqli_select_db($dbconn_ipadManagement, 'ipadManagement');

$outputs = "";

if(isset($_SESSION['unlock_key'])){
    //for display the information of user login
    $sql_users = "SELECT * FROM users WHERE email_users = '".$_SESSION['unlock_key']."' ";
    $query_users = mysqli_query($dbconn_ipadManagement,$sql_users);
    $dataUsers = mysqli_fetch_assoc($query_users);
}


// ============== CRUD Database ================

//for login page (login.php)
//validate the email & password 
if($_POST["status"] == "LoginSystem")
{
    $email = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['email']);
    $password = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['password']);
    
    $sql_login = "SELECT * FROM users WHERE email_users = '".$email."' ";
    $query_login = mysqli_query($dbconn_ipadManagement,$sql_login);
	$data_login = mysqli_fetch_assoc($query_login);
    
    if($query_login){
        if($password == 'p@ssword1234'){
            $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$data_login['name_users']."', 'has login to the system',NOW())";
            $query_notification = mysqli_query($dbconn_ipadManagement, $sql_notification);
            {
                $output = "SuccessNew";
            }
            $_SESSION['unlock_key'] = $email;
        }
        else if(password_verify($password,$data_login['password_users'])){
            $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$data_login['name_users']."', 'has login to the system',NOW())";
            $query_notification = mysqli_query($dbconn_ipadManagement, $sql_notification);
            {
                $output = "Success";
            }
            $_SESSION['unlock_key'] = $email;
        }
        else{
            $output = 'Failed';
        }
    }
    else{
        $output = 'Failed';
    }
}


//for change password page (changepassword.php)
//change the default password
if($_POST["status"] == "ConfirmPassword")
{
    $password = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['password']);
    $usersPassword = password_hash($password,PASSWORD_DEFAULT);

    $sql_password = "UPDATE users SET password_users = '".$usersPassword."' WHERE email_users = '".$_SESSION['unlock_key']."' ";
    $query_password = mysqli_query($dbconn_ipadManagement,$sql_password);
    
    if($query_password){
        
        $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has changed the password',NOW())";
        $query_notification = mysqli_query($dbconn_ipadManagement, $sql_notification);
        {
            $output = "Success";
        }
    }
    else{
		$output = "Failed";
	}
}

if($_POST["status"] == "CheckPassword")
{
    $password = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['password']);
    $CurrentPassword = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['CurrentPassword']);
    $email = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['usersEmail']);
    $usersPassword = password_hash($password,PASSWORD_DEFAULT);
    
    $sql_check = "SELECT * FROM users WHERE email_users = '".$email."' ";
    $query_check = mysqli_query($dbconn_ipadManagement,$sql_check);
	$data_check = mysqli_fetch_assoc($query_check);
    
    if(password_verify($CurrentPassword,$data_check['password_users'])){
        $sql_password = "UPDATE users SET password_users = '".$usersPassword."' WHERE email_users = '".$_SESSION['unlock_key']."' ";
        $query_password = mysqli_query($dbconn_ipadManagement,$sql_password);

        if($query_password){
            
            $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has changed the password',NOW())";
            $query_notification = mysqli_query($dbconn_ipadManagement, $sql_notification);
            {
                $output = "Success";
            }
        }
        else{
            $output = "Failed";
        }
    }
    else{
        $output = "Wrong";
    }
}

//for add user page (adduser.php)
//insert the user information into database
if($_POST["status"] == "submitInfoUser")
{
    $usersName = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['usersName']);
    $usersEmail = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['usersEmail']);
	$usersPassword = password_hash('p@ssword1234',PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (name_users,email_users,password_users,dateregistered_users,status_users) values ('".ucfirst($usersName)."','".$usersEmail."','".$usersPassword."',NOW(),'0')";
    $query = mysqli_query($dbconn_ipadManagement, $sql);
    
    if($query){
        $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has inserted the new staff',NOW())";
        $query_notification = mysqli_query($dbconn_ipadManagement, $sql_notification);
        {
            $output = "Success";
        }
    }
	else{
		$output = "Failed";
	}
}

if($_POST["status"] == "submitInfoUpdateUser")
{
    $usersName = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['usersName']);
    $usersEmail = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['usersEmail']);
	$usersID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['usersID']);
    
    $sql = "UPDATE users SET name_users = '".$usersName."' , email_users = '".$usersEmail."' WHERE ID_users = '".$usersID."' ";
    $query = mysqli_query($dbconn_ipadManagement, $sql);
    
    if($query){
        $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has updated the profile info',NOW())";
        $query_notification = mysqli_query($dbconn_ipadManagement, $sql_notification);
        {
            $output = "Success";
        }
    }
	else{
		$output = "Failed";
	}
}

//for assign owner page (assignOwner.php)
//insert the data of owner and ipad into database
if($_POST["status"] == "submitAssignOwner")
{
    $ownerID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ownerID']);
	$ipadID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST["ipadID"]);
    
	$sql_rental = "INSERT INTO rental (dateassigned,ID_users) 
    values (NOW(),'".$dataUsers['ID_users']."')";
    $query_rental = mysqli_query($dbconn_ipadManagement, $sql_rental);
    $last_rental = mysqli_insert_id($dbconn_ipadManagement);
    
    if($query_rental){
        $sql_assignOwner = "INSERT INTO rental_return (ID_owner,ID_ipad,status_ipadOwner,ID_rental) 
        values ('".$ownerID."','".$ipadID."','1','".$last_rental."')";
        $query_assignOwner = mysqli_query($dbconn_ipadManagement, $sql_assignOwner);
        $last_assignOwner = mysqli_insert_id($dbconn_ipadManagement);

        if($query_assignOwner){
            $sql_updateiPad = "UPDATE ipad SET status_ipad = '1' WHERE ID_ipad = '".$ipadID."' ";
            $query_updateiPad = mysqli_query($dbconn_ipadManagement, $sql_updateiPad);

            if($query_updateiPad){
                $sql_updateOwner = "UPDATE owner SET status_owner = '1' WHERE ID_owner = '".$ownerID."' ";
                $query_updateOwner = mysqli_query($dbconn_ipadManagement, $sql_updateOwner);

                if($query_updateOwner){
                    $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has assigned the user with an iPad',NOW())";
                    $query_notification = mysqli_query($dbconn_ipadManagement, $sql_notification);
                    {
                        $output = "Success";
                    }
                    $_SESSION['ipadOwner'] = $last_assignOwner;
                }
                else{
                    $output = "Failed";
                }
            }
        }
        else{
            $output = "Failed";
        }
    }
}

//for add new owner page (newOwner.php)
//insert owner information into database 
if($_POST["status"] == "submitInfoOwner")
{
    $ownerName = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ownerName']);
    $ownerDept = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ownerDept']);
    $addDept = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['addDept']);
    
    if($addDept != ""){
        $sql = "INSERT INTO department (name_dept,timestamp_dept,ID_users) values ('".$ownerDept."',NOW(),'".$dataUsers['ID_users']."')";
        $query = mysqli_query($dbconn_ipadManagement, $sql);
        $last_Deptid = mysqli_insert_id($dbconn_ipadManagement);

        if($query){
            $sql = "INSERT INTO owner (name_owner,ID_dept,status_owner,dateregistered_owner,ID_users) values ('".$ownerName."','".$last_Deptid."','0',NOW(),'".$dataUsers['ID_users']."')";
            $query = mysqli_query($dbconn_ipadManagement, $sql);
            $last_Ownerid = mysqli_insert_id($dbconn_ipadManagement);

            if($query){
                $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has inserted the new user',NOW())";
                $query_notification = mysqli_query($dbconn_ipadManagement, $sql_notification);
                {
                    $output = "Success";
                }
                $_SESSION['ID_owner'] = $last_Ownerid;
            }
            else{
                $output = "Failed";
            }
        }
    }
    else{
        $sql = "INSERT INTO owner (name_owner,ID_dept,status_owner,dateregistered_owner,ID_users) values ('".$ownerName."','".$ownerDept."','0',NOW(),'".$dataUsers['ID_users']."')";
        $query = mysqli_query($dbconn_ipadManagement, $sql);
        $last_Ownerid = mysqli_insert_id($dbconn_ipadManagement);

        if($query){
                $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has inserted the new user',NOW())";
                $query_notification = mysqli_query($dbconn_ipadManagement, $sql_notification);
                {
                    $output = "Success";
                }
            $_SESSION['ID_owner'] = $last_Ownerid;
        }
        else{
            $output = "Failed";
        }
    }
}

if($_POST["status"] == "submitUpdateInfoOwner")
{
    $ownerName = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ownerName']);
    $ownerDept = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ownerDept']);
    $addDept = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['addDept']);
    $IDowner = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['IDowner']);
    
    if($addDept != ""){
        $sql = "INSERT INTO department (name_dept,timestamp_dept,ID_users) values ('".$ownerDept."',NOW(),'".$dataUsers['ID_users']."')";
        $query = mysqli_query($dbconn_ipadManagement, $sql);
        $last_Deptid = mysqli_insert_id($dbconn_ipadManagement);

        if($query){
            $sql = "UPDATE owner SET name_owner = '".$ownerName."' ,ID_dept = '".$last_Deptid."' WHERE ID_owner = '".$IDowner."' ";
            $query = mysqli_query($dbconn_ipadManagement, $sql);

            if($query){
                $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has updated the user information',NOW())";
                $query_notification = mysqli_query($dbconn_ipadManagement, $sql_notification);
                {
                    $output = "Success";
                }
            }
            else{
                $output = "Failed";
            }
        }
    }
    else{
        $sql = "UPDATE owner SET name_owner = '".$ownerName."' ,ID_dept = '".$ownerDept."' WHERE ID_owner = '".$IDowner."' ";
        $query = mysqli_query($dbconn_ipadManagement, $sql);

        if($query){
            $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has updated the user information',NOW())";
            $query_notification = mysqli_query($dbconn_ipadManagement, $sql_notification);
            {
                $output = "Success";
            }
        }
        else{
            $output = "Failed";
        }
    }
}

if($_POST["status"] == "submitInfoDept")
{
    $ownerDept = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ownerDept']);
    
    if($ownerDept != ""){
        $sql = "INSERT INTO department (name_dept,timestamp_dept,ID_users) values ('".$ownerDept."',NOW(),'".$dataUsers['ID_users']."')";
        $query = mysqli_query($dbconn_ipadManagement, $sql);
        $last_Deptid = mysqli_insert_id($dbconn_ipadManagement);

        if($query){
                $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has inserted the new department',NOW())";
                $query_notification = mysqli_query($dbconn_ipadManagement, $sql_notification);
                {
                    $output = "Success";
                }
            }
            else{
                $output = "Failed";
            }
    }
}

if($_POST["status"] == "submitUpdateInfoDept")
{
    $ownerDept = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ownerDept']);
    $IDdept = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['IDdept']);
    
    if($ownerDept != ""){
        $sql = "UPDATE department set name_dept = '".$ownerDept."' WHERE ID_dept = '".$IDdept."' ";
        $query = mysqli_query($dbconn_ipadManagement, $sql);

        if($query){
                $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has updated the department information',NOW())";
                $query_notification = mysqli_query($dbconn_ipadManagement, $sql_notification);
                {
                    $output = "Success";
                }
            }
            else{
                $output = "Failed";
            }
    }
}




// ============== Preview Modal ================

//for Add User page (adduser.php)
//display the user preview information modal 
if($_POST["status"] == "previewInfoUser")
{
    $usersName = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['usersName']);
    $usersEmail = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['usersEmail']);

	$output = "
	<div class='alert alert-secondary solid '>Please Check the Details Before Submiting!</div>
		<div class='row'>
		  <div class='col mb-12'>
			<table class='table table-bordered' >
				<tr>
					<th width='30%'><b>Name</b></th>
					<td>".ucwords($usersName)."</td>
					<input type='hidden' id='val-assetType' name='val-assetType' value='".$usersName."'>
				</tr>
				<tr>
					<th width='30%'><b>Email</b></th>
					<td>".$usersEmail."</td>
					<input type='hidden' id='val-assetType' name='val-assetType' value='".$usersEmail."'>
				</tr>
				<tr>
					<th width='30%'><b>Password</b></th>
					<td>p@ssword1234</td>
					<input type='hidden' id='val-assetType' name='val-assetType' value='p@ssword1234'>
				</tr>
			</table>
		  </div>
		</div>";
}

if($_POST["status"] == "previewInfoUpdateUser")
{
    $usersName = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['usersName']);
    $usersEmail = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['usersEmail']);
    $usersID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['usersID']);

	$output = "
	<div class='alert alert-secondary solid '>Please Check the Details Before Submiting!</div>
		<div class='row'>
		  <div class='col mb-12'>
			<table class='table table-bordered' >
				<tr>
					<th width='30%'><b>Name</b></th>
					<td>".ucwords($usersName)."</td>
					<input type='hidden' id='val-usersName' name='val-usersName' value='".$usersName."'>
				</tr>
				<tr>
					<th width='30%'><b>Email</b></th>
					<td>".$usersEmail."</td>
					<input type='hidden' id='val-usersEmail' name='val-usersEmail' value='".$usersEmail."'>
                    <input type='hidden' id='val-usersID' name='val-usersID' value='".$usersID."'>
				</tr>
			</table>
		  </div>
		</div>";
}

if($_POST["status"] == "previewInfoUpdatePassword")
{
    $CurrentPassword = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['CurrentPassword']);
    $password = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['password']);
    $passwordConfirmed = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['passwordConfirmed']);
    $usersID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['usersID']);

	$output = "
	<div class='alert alert-secondary solid '>Please Check the Details Before Submiting!</div>
		<div class='row'>
		  <div class='col mb-12'>
			<table class='table table-bordered' >
				<tr>
					<th width='30%'><b>New Password</b></th>
					<td>".$password."</td>
					<input type='hidden' id='val-password' name='val-password' value='".$password."'>
				</tr>
				<tr>
					<th width='30%'><b>Confirm New Password</b></th>
					<td>".$passwordConfirmed."</td>
					<input type='hidden' id='val-passwordConfirmed' name='val-passwordConfirmed' value='".$passwordConfirmed."'>
                    <input type='hidden' id='val-usersID' name='val-usersID' value='".$usersID."'>
                    <input type='hidden' id='val-CurrentPassword' name='val-CurrentPassword' value='".$CurrentPassword."'>
				</tr>
			</table>
		  </div>
		</div>";
}

//for Add owner (newOwner.php)
//display the owner preview information modal
if($_POST["status"] == "previewInfoOwner")
{
    $ownerName = mysqli_real_escape_string($dbconn_ipadManagement,$_POST["ownerName"]);
    $ownerDept = mysqli_real_escape_string($dbconn_ipadManagement,$_POST["ownerDept"]);
    $addDept = mysqli_real_escape_string($dbconn_ipadManagement,$_POST["addDept"]);
    $IDowner = mysqli_real_escape_string($dbconn_ipadManagement,$_POST["IDowner"]);
    
    if($addDept == ""){
        $sql = "SELECT * FROM department WHERE ID_dept = '".$ownerDept."' ";
        $query = mysqli_query($dbconn_ipadManagement,$sql);
        $data = mysqli_fetch_assoc($query);
        
        $ownerDepts = $data['name_dept'];
    }
    else{
        $ownerDepts = $ownerDept;
    }
    
    if($ownerName != ""){
        $output = "
            <div class='alert alert-secondary solid '>Please Check the Details Before Submiting!</div>
                <div class='row'>
                  <div class='col mb-12'>
                    <table class='table table-bordered' >
                        <tr>
                            <th width='30%'><b>Name</b></th>
                            <td style='text-transform:uppercase' >".$ownerName."</td>
                            <input type='hidden' id='val-ownerName' name='val-ownerName' value='".$ownerName."'>
                        </tr>
                        <tr>
                            <th width='30%'><b>Department</b></th>
                            <td style='text-transform:uppercase' >".$ownerDepts."</td>
                            <input type='hidden' id='val-ownerDept' name='val-ownerDept' value='".$ownerDept."'>
                            <input type='hidden' id='val-addDept' name='val-addDept' value='".$addDept."'>
                            <input type='hidden' id='IDowner' name='val-addDept' value='".$IDowner."'>
                        </tr>
                    </table>
                  </div>
                </div>";
    }
}

if($_POST["status"] == "previewInfoDept")
{
    $ownerDept = mysqli_real_escape_string($dbconn_ipadManagement,$_POST["ownerDept"]);
    
    if($ownerDept != ""){
        $output = "
            <div class='alert alert-secondary solid '>Please Check the Details Before Submiting!</div>
                <div class='row'>
                  <div class='col mb-12'>
                    <table class='table table-bordered' >
                        <tr>
                            <th width='30%'><b>Department</b></th>
                            <td style='text-transform:uppercase' >".$ownerDept."</td>
                            <input type='hidden' id='val-ownerDept' name='val-ownerDept' value='".$ownerDept."'>
                        </tr>
                    </table>
                  </div>
                </div>";
    }
}

//for view ipad info (listipad.php)
//display the ipad and owner preview information modal
if($_POST["status"] == "viewIpad")
{
    $sirino = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['serialNo']);
    
    $sql = "
    SELECT ipad.*,owner.*,department.*,rental_return.* FROM rental_return 
    INNER JOIN owner ON owner.ID_owner = rental_return.ID_owner 
    INNER JOIN ipad ON ipad.ID_ipad = rental_return.ID_ipad 
    INNER JOIN department ON owner.ID_dept = department.ID_dept
    WHERE ipad.serialNo_ipad = '".$sirino."' ";
    $query = mysqli_query($dbconn_ipadManagement,$sql);
    $numRows = mysqli_num_rows($query);
    
    
    if($numRows > 0){
        $data = mysqli_fetch_assoc($query);
    }
    else{
        $sql = " SELECT * FROM ipad WHERE serialNo_ipad = '".$sirino."' && delete_ipad = '0' ";
        $query = mysqli_query($dbconn_ipadManagement,$sql);
        $data = mysqli_fetch_assoc($query);
        
        $data['name_owner'] = "Not Assigned";
        $data['name_dept'] = "Not Assigned";
    }
    
    if($query){
        $output = "
            <div class='card-body'>
                <div class='table-responsive'>
                    <table class='table table-bordered table-responsive-sm'>
                        <thead>
                            <tr>
                                <th colspan='2' style='text-align:center;'>iPad Information</th>
                            </tr>
                            <tr>
                                <th>Device Name</th>
                                <td>".ucwords($data['assetType_ipad'])."</td>
                            </tr>
                            <tr>
                                <th>Model Name</th>
                                <td>".ucwords($data['modelType_ipad'])."</td>
                            </tr>
                            <tr>
                                <th>RFID No.</th>
                                <td>1020000700".$data['rfidno_ipad']."</td>
                            </tr>
                            <tr>
                                <th>Serial No.</th>
                                <td>".$data['serialNo_ipad']."</td>
                            </tr>
                            <tr>
                                <th>Date Register</th>
                                <td>".$data['dateregistered_ipad']."</td>
                            </tr>
                            <tr>
                                <th>Remarks</th>
                                <td>".$data['remarks_ipad']."</td>
                            </tr>
                        </thead>
                    </table>
                    <br>
                    <table class='table table-bordered table-responsive-sm'>
                        <thead>
                            <tr>
                                <th colspan='2' style='text-align:center;'>User Information</th>
                            </tr>
                            <tr>
                                <th width='22%' >Name</th>
                                <td>".ucwords($data['name_owner'])."</td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td>".ucwords($data['name_dept'])."</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
                ";
    }
    
}

//for list all ipad (listipad.php)
//will refresh the table after submit
if($_POST["status"] == "tableUpdateiPad"){
    
    $sql_all = "SELECT * FROM ipad";
    $query_all = mysqli_query($dbconn_ipadManagement,$sql_all);
    
    while($data = mysqli_fetch_array($query_all)){    
        $output = "
            <tr>
                <td>".$data['assetType_ipad']."</td>
                <td>".$data['modelType_ipad']."</td>
                <td>".$data['serialNo_ipad']."</td>
                <td>1020000700".$data['rfidno_ipad']."</td>
                <td>".$data['dateregistered_ipad']."</td>
                <td width='25%'>
                    <div class='row'>
                        <div class='col-lg-2 '>
                            <input type='hidden' class='val-siriNo' name='val-siriNo' value='".$data['serialNo_ipad']."'>
                            <button type='button' class='btn btn-primary' id='updateIpad' >
                                <i class='fa fa-pencil'></i>
                            </button>
                        </div>
                        <div class='col-lg-2 '>
                            <button type='button' class='btn btn-info'>
                                <i class='fa fa-external-link'></i>
                            </button>
                        </div>&nbsp;
                        <div class='col-lg-2 '>
                            <button type='button' class='btn btn-danger'>
                                <i class='fa fa-trash'></i>
                            </button>
                        </div>
                    </div>
                </td>
            </tr>";
        }
}

//for view ipad and owner info (assignIpad.php)
//display the ipad and owner preview information modal
if($_POST["status"] == "previewInfoAssignIpad")
{
    $rfidno = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['rfidno']);
    $IDowner = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['IDowner']);

    $sql_ipad = " SELECT * FROM ipad WHERE ID_ipad = '".$rfidno."' && delete_ipad = '0' ";
    $query_ipad = mysqli_query($dbconn_ipadManagement,$sql_ipad);
    $data_ipad = mysqli_fetch_assoc($query_ipad);
    
    if($query_ipad){
        $sql_owner = " SELECT owner.*,department.* FROM owner
        INNER JOIN department ON owner.ID_dept = department.ID_dept
        WHERE owner.ID_owner = '".$IDowner."' ";
        $query_owner = mysqli_query($dbconn_ipadManagement,$sql_owner);
        $data_owner = mysqli_fetch_assoc($query_owner);
    }
    
    if($query_owner){
        $output = "
            <div class='card-body'>
                <div class='table-responsive'>
                    <table class='table table-bordered table-responsive'>
                        <thead>
                            <tr>
                                <th colspan='2' style='text-align:center;'>iPad Information</th>
                            </tr>
                            <tr>
                                <th width='22%' >Device Name</th>
                                <td>".ucwords($data_ipad['assetType_ipad'])."</td>
                                <input type='hidden' value=".$data_ipad['ID_ipad']." id='ipadID' >
                            </tr>
                            <tr>
                                <th width='22%' >Model Name</th>
                                <td>".ucwords($data_ipad['modelType_ipad'])."</td>
                            </tr>
                            <tr>
                                <th>RFID No.</th>
                                <td>1020000700".$data_ipad['rfidno_ipad']."</td>
                            </tr>
                            <tr>
                                <th>Serial No.</th>
                                <td>".strtoupper($data_ipad['serialNo_ipad'])."</td>
                            </tr>
                        </thead>
                    </table>
                    
                    <table class='table table-bordered table-responsive'>
                        <thead>
                            <tr>
                                <th colspan='2' style='text-align:center;'>User Information</th>
                            </tr>
                            <tr>
                                <th width='22%' >Name</th>
                                <td>".ucwords($data_owner['name_owner'])."</td>
                                <input type='hidden' value=".$data_owner['ID_owner']." id='ownerID' >
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td>".ucwords($data_owner['name_dept'])."</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
                ";
    }
    
}

//for view owner info (listipad.php)
//display the ipad and owner preview information modal
if($_POST["status"] == "viewIpad")
{
    $sirino = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['serialNo']);
    
    $sql = "
    SELECT ipad.*,owner.*,department.*,rental_return.* FROM rental_return 
    INNER JOIN owner ON owner.ID_owner = rental_return.ID_owner 
    INNER JOIN ipad ON ipad.ID_ipad = rental_return.ID_ipad 
    INNER JOIN department ON owner.ID_dept = department.ID_dept
    WHERE ipad.serialNo_ipad = '".$sirino."' && ipad.delete_ipad = '0' ";
    $query = mysqli_query($dbconn_ipadManagement,$sql);
    $numRows = mysqli_num_rows($query);
    
    
    if($numRows > 0){
        $data = mysqli_fetch_assoc($query);
    }
    else{
        $sql = " SELECT * FROM ipad WHERE serialNo_ipad = '".$sirino."' && delete_ipad = '0' ";
        $query = mysqli_query($dbconn_ipadManagement,$sql);
        $data = mysqli_fetch_assoc($query);
        
        $data['name_owner'] = "Not Assigned";
        $data['name_dept'] = "Not Assigned";
    }
    
    if($query){
        $output = "
            <div class='card-body'>
                <div class='table-responsive'>
                    <table class='table table-bordered table-responsive-sm'>
                        <thead>
                            <tr>
                                <th colspan='2' style='text-align:center;'>iPad Information</th>
                            </tr>
                            <tr>
                                <th>Device Name</th>
                                <td>".ucwords($data['assetType_ipad'])."</td>
                            </tr>
                            <tr>
                                <th>Model Name</th>
                                <td>".ucwords($data['modelType_ipad'])."</td>
                            </tr>
                            <tr>
                                <th>RFID No.</th>
                                <td>1020000700".$data['rfidno_ipad']."</td>
                            </tr>
                            <tr>
                                <th>Serial No.</th>
                                <td>".$data['serialNo_ipad']."</td>
                            </tr>
                            <tr>
                                <th>Date Register</th>
                                <td>".$data['dateregistered_ipad']."</td>
                            </tr>
                            <tr>
                                <th>Remarks</th>
                                <td>".$data['remarks_ipad']."</td>
                            </tr>
                        </thead>
                    </table>
                    <br>
                    <table class='table table-bordered table-responsive-sm'>
                        <thead>
                            <tr>
                                <th colspan='2' style='text-align:center;'>User Information</th>
                            </tr>
                            <tr>
                                <th width='22%' >Name</th>
                                <td>".ucwords($data['name_owner'])."</td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td>".ucwords($data['name_dept'])."</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
                ";
    }
    
}




    

// ========== From Function (A) ==========

//display the iPad information from the new iPad form modal
if($_POST["status"] == "btnNextNewiPad")
{
    $assetType = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['assetType']);
    $modelType = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['modelType']);
    $rfidno = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['rfidno']);
    $sirino = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['sirino']);
    $box = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['box']);
    $adapter = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['adapter']);
    $cable = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['cable']);
    $accesories = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['accesories']);
    $detailAccessories = json_encode($_POST['detailAccessories']);

    if($_POST["remarks"] != ""){
        $remarks = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['remarks']);
    }
    else{
        $remarks = 'None';
    }

    if($box == "1"){
        $boxs = "Include";
        $box_data = '1';
    }
    else{
        $boxs = "Not Include";
        $box_data = '0';
    }
    
    if($adapter == "1"){
         $adapters = "Include";
        $adapter_data = '1';
    }
    else{
        $adapters = "Not Include";
        $adapter_data = '0';
    }
    
    if($cable == "1"){
        $cables = "Include";
        $cable_data = '1';
    }
    
    else{
        $cables = "Not Include";
        $cable_data = '0';
    }
    
    if($accesories == "1"){
        $accesoriess= $detailAccessories;
        $accesoriess = str_replace( array( '"' ), '', $accesoriess);
        $accesoriess = str_replace(array( '[', ']' ), '', $accesoriess);
        $accesories_data = '1';
    }
    else{
        
        $accesoriess = "Not Include";
        $accesories_data = '0';
    }


    if($assetType != ""){
        $output = "
                <div class='alert alert-secondary solid '>Please Check the Details Before Submiting!</div>
                    <div class='row'>
                      <div class='col mb-12'>
                        <table class='table table-bordered' >
                            <tr>
                                <th width='30%'><b>Device Name</b></th>
                                <td style='text-transform:capitalize' > ".$assetType."</td>
                                <input type='hidden' id='val-assetType' class='val-assetType' name='val-assetType' value='".$assetType."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>Model Name</b></th>
                                <td style='text-transform:capitalize' > ".$modelType."</td>
                                <input type='hidden' id='val-modelType' class='val-modelType' name='val-modelType' value='".$modelType."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>RFID Number</b></th>
                                <td>1020000700".$rfidno."</td>
                                <input type='hidden' id='val-rfidno' name='val-rfidno' value='".$rfidno."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>Serial Number</b></th>
                                <td style='text-transform:uppercase' >".$sirino."</td>
                                <input type='hidden' id='val-sirino' name='val-sirino' value='".$sirino."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>Remarks</b></th>
                                <td style='text-transform:capitalize' >".$remarks."</td>
                                <input type='hidden' id='val-remarks' name='val-remarks' value='".$remarks."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>Box</b></th>
                                <td style='text-transform:capitalize' >".$boxs."</td>
                                <input type='hidden' class='val-boxs' id='val-boxs' name='val-box' value='".$box_data."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>Adapter</b></th>
                                <td style='text-transform:capitalize' >".$adapters."</td>
                                <input type='hidden' class='val-adapters' id='val-adapters' name='val-adapter' value='".$adapter_data."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>Cable</b></th>
                                <td style='text-transform:capitalize' >".$cables."</td>
                                <input type='hidden' class='val-cables' id='val-cables' name='val-cable' value='".$cable_data."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>Other Acces.</b></th>
                                <td style='text-transform:capitalize' > $accesoriess </td>
                                <input type='hidden' class='val-accesoriess' id='val-accesoriess' name='val-accesories' value='".$accesories_data."'>
                                <input type='hidden' class='val-detailAccessories' id='val-detailAccessoriess' name='val-detailAccessories' value='".$accesoriess."'>
                            </tr>
                        </table>
                      </div>
                    </div>";
    }
}

// ========== From Function (B) ==========

//insert ipad information into database 
if($_POST["status"] == "submitInfoIpad")
{
    $assetType = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['assetType']);
    $modelType = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['modelType']);
    $rfidno = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['rfidno']);
    $sirino = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['sirino']);
    $box = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['box']);
    $adapter = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['adapter']);
    $cable = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['cable']);
    $accesories = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['accesories']);
    $detailAccessories = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['detailAccessories']);
    
    if($_POST["remarks"] != "None"){
        $remarks = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['remarks']);
    }
    else{
        $remarks = '';
    }
    
    if($accesories == '1'){
        
        $sql = "INSERT INTO ipad (assetType_ipad,modelType_ipad,rfidno_ipad,serialNo_ipad,dateregistered_ipad,remarks_ipad,status_ipad,box_ipad,adapter_ipad,wire_ipad,accesories_ipad,ID_users,delete_ipad,condition_ipad) values ('".$assetType."','".$modelType."','".$rfidno."','".$sirino."',NOW(),'".$remarks."','0','".$box."','".$adapter."','".$cable."','".$accesories."','".$dataUsers['ID_users']."','0','0')";
        $query = mysqli_query($dbconn_ipadManagement, $sql);
        $last_returnid_ipad = mysqli_insert_id($dbconn_ipadManagement);
        
        if($query){
            $detailAccessories= explode(",", $detailAccessories);
            $detailAccessories = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $detailAccessories);
            $detailAccessories = str_replace(array( '[', ']' ), '', $detailAccessories);
            $cnt = count($detailAccessories);
            
            for($i=0;$i<$cnt;$i++)
            {
                $sql = "INSERT INTO Accesories_ipad (name_accesories,ID_ipad) values ('".$detailAccessories[$i]."','".$last_returnid_ipad."')";
                $query = mysqli_query($dbconn_ipadManagement, $sql);
            }
        }
    }
    else{
        $sql = "INSERT INTO ipad (assetType_ipad,modelType_ipad,rfidno_ipad,serialNo_ipad,dateregistered_ipad,remarks_ipad,status_ipad,box_ipad,adapter_ipad,wire_ipad,accesories_ipad,ID_users,delete_ipad,condition_ipad) values ('".$assetType."','".$modelType."','".$rfidno."','".$sirino."',NOW(),'".$remarks."','0','".$box."','".$adapter."','".$cable."','".$accesories."','".$dataUsers['ID_users']."','0','0')";
        $query = mysqli_query($dbconn_ipadManagement, $sql);
    }
 
    
    
    if($query){
        $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has inserted the new iPad',NOW())";
        $query_notification = mysqli_query($dbconn_ipadManagement, $sql_notification);
        {
            $output = "Success";
        }
        $_SESSION['serialNo'] = $sirino;
    }
    else{
        $output = "Failed";
    }
}


//for update ipad page (listIpad.php)
//insert ipad update information into database
if($_POST["status"] == "saveupdateIpad"){
    
    $assetType = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['assetType']);
    $modelType = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['modelType']);
    $rfidno = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['rfidno']);
    $sirino = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['sirino']);
    $remarks = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['remarks']);
    $box = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['box']);
    $adapter = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['adapter']);
    $cable = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['cable']);
    $accesories = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['accesories']);
    $detailAccessories = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['detailAccessories']);
    $dateregistered = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['dateregistered']);
    
    $sql = "UPDATE ipad SET assetType_ipad = '".$assetType."',modelType_ipad = '".$modelType."', rfidno_ipad = '".$rfidno."', dateupdated_ipad = NOW(), dateregistered_ipad = '".$dateregistered."', remarks_ipad = '".$remarks."', box_ipad = '".$box."', adapter_ipad = '".$adapter."', wire_ipad = '".$cable."', otherAccessories_ipad = '".$detailAccessories."', accesories_ipad = '".$accesories."', delete_ipad ='0'
    WHERE serialNo_ipad = '".$sirino."' ";
    $query = mysqli_query($dbconn_ipadManagement,$sql);
    
    if($query){
            $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has updated the iPad information',NOW())";
            $query_notification = mysqli_query($dbconn_ipadManagement, $sql_notification);
            {
                $output = "Success";
            }
    }
    else{
        $output = "Failed";
    }
}

//for preview return ipad
if($_POST["status"] == "ReturnIpad")
{
    $ipadID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ipadID']);
    $ownerID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ownerID']);
    $box = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['box']);
    $adapter = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['adapter']);
    $cable = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['cable']);
    $accesories = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['accesories']);
    $cover = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['cover']);
    $screen = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['screen']);
    $otherdamage = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['otherdamage']);
    $damageDescribe = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['damageDescribe']);
    
    $sql_ipad = "SELECT * FROM ipad WHERE ID_ipad = '".$ipadID."' && delete_ipad = '0' ";
    $query_ipad = mysqli_query($dbconn_ipadManagement,$sql_ipad);
    $data_ipad = mysqli_fetch_assoc($query_ipad);
    
    $sql_owner = "SELECT * FROM owner WHERE ID_owner = '".$ownerID."' ";
    $query_owner = mysqli_query($dbconn_ipadManagement,$sql_owner);
    $data_owner = mysqli_fetch_assoc($query_owner);

    if($box == "1"){
        $boxs = "Include";
    }
    else{
        $boxs = "Not Include";
    }
    if($adapter == "1"){
         $adapters = "Good Condition";
    }
    else{
        $adapters = "Broken  Condition @ Missing";
    }
    if($cable == "1"){
        $cables = "Good Condition";
    }
    else{
        $cables = "Broken Condition @ Missing";
    }
    
    if($screen == "0"){
        $screens = "Good Condition";
    }
    else{
        $screens = "Broken Condition";
    }
    if($cover == "0"){
        $covers = "Good Condition";
    }
    else{
        $covers = "Broken Condition";
    }
    if($accesories == "1"){
        $accesoriess = "Include";
    }
    else{
        $accesoriess = "Not Include";
    }
    if($otherdamage == "1"){
        $otherdamages = $damageDescribe;
    }
    else{
        $otherdamages = "None";
    }


    if($accesories != ""){
        $output = "
                <div class='alert alert-secondary solid '>Please Check the Details Before Submiting!</div>
                    <div class='row'>
                      <div class='col mb-12'>
                        <table class='table table-bordered' >
                            <tr>
                                <th width='30%'><b>User Name</b></th>
                                <td style='text-transform:capitalize' > ".ucwords($data_owner['name_owner'])."</td>
                                <input type='hidden' id='ownerID' class='ownerID' name='ownerID' value='".$data_owner['ID_owner']."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>RFID Number</b></th>
                                <td>1020000700".$data_ipad['rfidno_ipad']."</td>
                                <input type='hidden' id='ipadID' name='ipadID' value='".$data_ipad['ID_ipad']."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>Screen</b></th>
                                <td style='text-transform:capitalize' >".$screens."</td>
                                <input type='hidden' class='val-screens' id='val-screen' name='val-screen' value='".$screen."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>Case</b></th>
                                <td style='text-transform:capitalize' >".$covers."</td>
                                <input type='hidden' class='val-covers' id='val-cover' name='val-cover' value='".$cover."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>Cable</b></th>
                                <td style='text-transform:capitalize' >".$cables."</td>
                                <input type='hidden' class='val-cables' id='val-cable' name='val-cable' value='".$cable."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>Power Adapter</b></th>
                                <td style='text-transform:capitalize' >".$adapters."</td>
                                <input type='hidden' class='val-adapters' id='val-adapter' name='val-adapter' value='".$adapter."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>Box</b></th>
                                <td style='text-transform:capitalize' >".$boxs."</td>
                                <input type='hidden' class='val-boxs' id='val-box' name='val-box' value='".$box."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>Other Acces.</b></th>
                                <td style='text-transform:capitalize' >".$accesoriess."</td>
                                <input type='hidden' class='val-accesoriess' id='val-accesories' name='val-accesories' value='".$accesories."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>Other Signs</b></th>
                                <td style='text-transform:capitalize' >".$otherdamages."</td>
                                <input type='hidden' class='val-otherdamages' id='val-otherdamage' name='val-otherdamage' value='".$otherdamages."'>
                            </tr>
                        </table>
                      </div>
                    </div>";
    }
}

//for preview return
if($_POST["status"] == "submitInfoReturnIpad")
{
    $ipadID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ipadID']);
    $ownerID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ownerID']);
    $box = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['box']);
    $adapter = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['adapter']);
    $cable = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['cable']);
    $cover = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['cover']);
    $screen = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['screen']);
    $otherdamage = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['otherdamage']);
    
    $sql_return = "INSERT INTO `return`(`screen_return`, `cover_return`, `cable_return`, `adapter_return`, `box_return`, `otherdamage_return`, `datereturned`, `ID_users`)
     VALUES ('".$screen."','".$cover."','".$cable."','".$adapter."','".$box."','".$otherdamage."',NOW(),'".$dataUsers['ID_users']."')";
    $query_return = mysqli_query($dbconn_ipadManagement,$sql_return);
    $last_returnid = mysqli_insert_id($dbconn_ipadManagement);
    
    if($query_return){
        $sql_update = "UPDATE rental_return SET ID_return = '".$last_returnid."', status_ipadOwner = '2' WHERE ID_owner = '".$ownerID."' AND ID_ipad = '".$ipadID."' AND status_ipadOwner = '1' ";
        $query_update = mysqli_query($dbconn_ipadManagement,$sql_update);
        
        if($query_update){
            
            $sql_updateiPad = "UPDATE ipad SET status_ipad = '2',condition_ipad = '1' WHERE ID_ipad = '".$ipadID."' AND delete_ipad = '0' ";
            $query_updateiPad = mysqli_query($dbconn_ipadManagement, $sql_updateiPad);

            if($query_updateiPad){
                $sql_updateOwner = "UPDATE owner SET status_owner = '2' WHERE ID_owner = '".$ownerID."' ";
                $query_updateOwner = mysqli_query($dbconn_ipadManagement, $sql_updateOwner);

                if($query_updateOwner){
                    $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has received the return iPad',NOW())";
                    $query_notification = mysqli_query($dbconn_ipadManagement, $sql_notification);
                    {
                        $output = "Success";
                    }
                    $_SESSION['ipadReturn'] = $last_returnid;
                }
                else{
                    $output = "Failed";
                }
            }
        }
        else{
            $output = "Failed";
        }
    }
    

   
}

//preview owner & iPad information (modal)
if($_POST["status"] == "previewInfoAssignOwner")
{
    $ownerID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ownerID']);
	$ipadID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ipadID']);

    $sql_owner = "SELECT owner.*,department.* FROM owner INNER JOIN department ON
    department.ID_dept = owner.ID_dept WHERE owner.ID_owner = '".$ownerID."' ";
    $query_owner = mysqli_query($dbconn_ipadManagement,$sql_owner);
    $data_owner = mysqli_fetch_assoc($query_owner);
    
    $sql_ipad = "SELECT * FROM ipad WHERE ID_ipad = '".$ipadID."' && delete_ipad = '0' ";
    $query_ipad = mysqli_query($dbconn_ipadManagement,$sql_ipad);
    $data_ipad = mysqli_fetch_assoc($query_ipad);

    
    if($query_owner != ""  && $query_ipad != ""){
        $output = "
                <div class='alert alert-secondary solid '> Please Check the Details Before Submiting!</div>
                    <div class='row'>
                      <div class='col mb-12'>
                        <table class='table table-bordered' >
                            <tr>
                                <th colspan='2'><center><b>iPad Information</b></center></th>
                            </tr>
							<tr>
                                <th width='30%'><b>Device Name</b></th>
                                <td style='text-transform:capitalize' >".$data_ipad['assetType_ipad']."</td>
								<input type='hidden' id='ipadID' name='ipadID' value='".$data_ipad['ID_ipad']."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>Model Name</b></th>
                                <td style='text-transform:capitalize' >".$data_ipad['modelType_ipad']."</td>
								<input type='hidden' id='ipadID' name='ipadID' value='".$data_ipad['ID_ipad']."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>RFID No.</b></th>
                                <td style='text-transform:uppercase' >1020000700".$data_ipad['rfidno_ipad']."</td>
                            </tr>
							<tr>
                                <th width='30%'><b>Serial No.</b></th>
                                <td style='text-transform:uppercase' >".$data_ipad['serialNo_ipad']."</td>
                            </tr>
                        </table>
						<table class='table table-bordered' >
                            <tr>
                                <th colspan='2'><center><b>User Information</b></center></th>
                            </tr>
							<tr>
                                <th width='30%'><b>Name</b></th>
                                <td style='text-transform:uppercase' >".ucwords($data_owner['name_owner'])."</td>
                                <input type='hidden' id='ownerID' name='ownerID' value='".$data_owner['ID_owner']."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>Department</b></th>
                                <td style='text-transform:uppercase' >".ucwords($data_owner['name_dept'])."</td>
                            </tr>
                        </table>
                      </div>
                    </div>";
    }
}

//preview owner & iPad information (modal)
if($_POST["status"] == "detailsOwner")
{
    $ownerID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ownerID']);
    
    $sql_owner = "SELECT owner.*,department.* FROM owner
    INNER JOIN department ON department.ID_dept = owner.ID_dept WHERE owner.ID_owner = '".$ownerID."' ";
    $query_owner = mysqli_query($dbconn_ipadManagement,$sql_owner);
    $data_owner = mysqli_fetch_assoc($query_owner);

    
        $output = "
        <tr>
            <th colspan='2'><center><b>User Information</b></center></th>
        </tr>
        <tr>
            <th width='30%'><b>Name</b></th>
            <td style='text-transform:capitalize' >".ucwords($data_owner['name_owner'])."</td>
        </tr>
        <tr>
            <th width='30%'><b>Department</b></th>
            <td style='text-transform:capitalize' >".ucwords($data_owner['name_dept'])."</td>
        </tr>";
}

//preview owner & iPad information (modal)
if($_POST["status"] == "detailsIpad")
{
    $ipadID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ipadID']);
    
    $sql_ipad = "SELECT * FROM ipad WHERE ID_ipad = '".$ipadID."' ";
    $query_ipad = mysqli_query($dbconn_ipadManagement,$sql_ipad);
    $data_ipad = mysqli_fetch_assoc($query_ipad);
    
    if($data_ipad['condition_ipad'] == '0'){
        $condition = 'New';
    }
    else{
        $condition = 'Used';
    }
    
    if($data_ipad["remarks"] != ""){
        $remarks = $data_ipad["remarks"];
    }
    else{
        $remarks = 'None';
    }

    
        $output = "
        <tr>
            <th colspan='2'><center><b>iPad Information</b></center></th>
        </tr>
        <tr>
            <th width='30%'><b>Device:</b></th>
            <td style='text-transform:capitalize' >".$data_ipad['assetType_ipad']."</td>
        </tr>
        <tr>
            <th width='30%'><b>Model:</b></th>
            <td style='text-transform:capitalize' >".$data_ipad['modelType_ipad']."</td>
        </tr>
        <tr>
            <th width='30%'><b>RFID No. :</b></th>
            <td style='text-transform:capitalize' >1020000700".$data_ipad['rfidno_ipad']."0000</td>
        </tr>
        <tr>
            <th width='30%'><b>Serial No. :</b></th>
            <td style='text-transform:capitalize' >".strtoupper($data_ipad['serialNo_ipad'])."</td>
        </tr>
        <tr>
            <th width='30%'><b>Condition :</b></th>
            <td >".$condition."</td>
        </tr>
        <tr>
            <th width='30%'><b>Remarks :</b></th>
            <td style='text-transform:capitalize' >".$remarks."</td>
        </tr>
        ";
}

//insert the data of owner and ipad into database
if($_POST["status"] == "checkRfidNo")
{
    $rfidNo = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['rfidNo']);
    
	$sql = "SELECT * FROM ipad WHERE rfidno_ipad = '".$rfidNo."' ";
    $query = mysqli_query($dbconn_ipadManagement, $sql);
    $data_rfid = mysqli_fetch_assoc($query);
    
    if($data_rfid['rfidno_ipad'] == $rfidNo && $rfidNo != "" ){
        $output = "Success";
    }
	else{
		$output = "Failed";
	}
}

if($_POST["status"] == "checkSerialNo")
{
    $serialNo = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['serialNo']);
    
	$sql = "SELECT * FROM ipad WHERE serialNo_ipad = '".$serialNo."' ";
    $query = mysqli_query($dbconn_ipadManagement, $sql);
    $data_serial = mysqli_fetch_assoc($query);
    
    if($data_serial['serialNo_ipad'] == $serialNo && $serialNo != "" ){
        $output = "Success";
    }
	else{
		$output = "Failed";
	}
}

if($_POST["status"] == "submitFile")
{
    $pdfFile = $_FILES["pdfFile"]["name"] ;
    $tmp = $_FILES["pdfFile"]["tmp_name"] ;
    $fileID = $_POST["fileID"] ;
    
    $valid_extensions = array('pdf');
    $path = dirname(__FILE__) .'/iPad/fileUpload/';

    $ext = strtolower(pathinfo($pdfFile, PATHINFO_EXTENSION));
    $final_file = rand(1000,1000000).$pdfFile;

    if(in_array($ext, $valid_extensions)){ 
        $path = $path.strtolower($final_file); 

        if(move_uploaded_file($tmp,$path)) 
        {
            $path = '/iPad/fileUpload/'.strtolower($final_file);
            $sql = "UPDATE rental_return SET fixedassetform = '".$path."' WHERE ID_ipadOwner = '".$fileID."' ";
            $query = mysqli_query($dbconn_ipadManagement, $sql);

            if($query){
                $output = $path;
            }
            else{
                $output = "Failed";
            }

        }
        else{
            $output = "Failed";
        }
    } 
    else{
        $output = "Faileds";
    }
}

if($_POST["status"] == "submitFileReturn")
{
    $pdfFile = $_FILES["pdfFile"]["name"] ;
    $tmp = $_FILES["pdfFile"]["tmp_name"] ;
    $fileID = $_POST["fileID"] ;
    
    $valid_extensions = array('pdf');
    $path = dirname(__FILE__) .'/iPad/fileUpload/';

    $ext = strtolower(pathinfo($pdfFile, PATHINFO_EXTENSION));
    $final_file = rand(1000,1000000).$pdfFile;

    if(in_array($ext, $valid_extensions)){ 
        $path = $path.strtolower($final_file); 

        if(move_uploaded_file($tmp,$path)) 
        {
            $path = '/iPad/fileUpload/'.strtolower($final_file);
            $sql = "UPDATE rental_return SET returnfixedassetform = '".$path."' WHERE ID_ipadOwner = '".$fileID."' ";
            $query = mysqli_query($dbconn_ipadManagement, $sql);

            if($query){
                $output = $path;
            }
            else{
                $output = "Failed";
            }

        }
        else{
            $output = "Failed";
        }
    } 
    else{
        $output = "Faileds";
    }
}

if($_POST["status"] == "displayDateView")
{
        $ipadID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ipadOwnerID']);
    
        $output = "
            <span style='color:black;font-weight:500'>Enter Date :</span><br>
            <input type='date' class='form-control' name='dateAssign' required>
            <input type='hidden' name='actions' value='".$ipadID."'>
            <input type='hidden' name='ACTION' value='VIEW'>
        ";
}

if($_POST["status"] == "displayDateDownload")
{
        $ipadID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ipadOwnerID']);
    
        $output = "
            <span style='color:black;font-weight:500'>Enter Date :</span><br>
            <input type='date' class='form-control' name='dateAssign' required>
            <input type='hidden' name='actions' value='".$ipadID."'>
            <input type='hidden' name='ACTION' value='DOWNLOAD'>
        ";
}

    echo json_encode($output); 

?>



