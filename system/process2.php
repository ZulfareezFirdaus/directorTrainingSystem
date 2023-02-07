<?php

session_start();
include("./dbconn.php");

mysqli_select_db($dbconn_ipadManagement, 'ipadManagement');

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
		if(password_verify($password,$data_login['password_users'])){
			$sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has login',NOW())";
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

//for assign owner page (assignOwner.php)
//insert the data of owner and ipad into database
if($_POST["status"] == "submitAssignOwner")
{
    $ownerID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ownerID']);
	$ipadID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST["ipadID"]);
    
	$sql_assignOwner = "INSERT INTO rental_return (ID_owner,ID_ipad,status_ipadOwner,dateassigned_ipadOwner,ID_users) 
    values ('".$ownerID."','".$ipadID."','1',NOW(),'".$dataUsers['ID_users']."')";
    $query_assignOwner = mysqli_query($dbconn_ipadManagement, $sql_assignOwner);
    
    if($query_assignOwner){
        $sql_updateiPad = "UPDATE ipad SET status_ipad = '1' WHERE ID_ipad = '".$ipadID."' ";
        $query_updateiPad = mysqli_query($dbconn_ipadManagement, $sql_updateiPad);
			
        if($query_updateiPad){
            $sql_updateOwner = "UPDATE owner SET status_owner = '1' WHERE ID_owner = '".$ownerID."' ";
            $query_updateOwner = mysqli_query($dbconn_ipadManagement, $sql_updateOwner);
            
            if($query_updateOwner){
                $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has assigned iPad to the user',NOW())";
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
		$output = "Failed";
	}
}

//for add new owner page (newOwner.php)
//insert owner information into database 
if($_POST["status"] == "submitInfoOwner")
{
    $ownerName = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ownerName']);
    $ownerDept = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ownerDept']);
    $addDept = mysqli_real_escape_string($dbconn_ipadManagement,$_POST["addDept"]);
    
    if($addDept != ""){
        $sql = "INSERT INTO department (name_dept) values ('".$ownerDept."')";
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

//for Add owner (newOwner.php)
//display the owner preview information modal
if($_POST["status"] == "previewInfoOwner")
{
    $ownerName = mysqli_real_escape_string($dbconn_ipadManagement,$_POST["ownerName"]);
    $ownerDept = mysqli_real_escape_string($dbconn_ipadManagement,$_POST["ownerDept"]);
    $addDept = mysqli_real_escape_string($dbconn_ipadManagement,$_POST["addDept"]);
    
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
                                <td>".ucwords($data['remarks_ipad'])."</td>
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
                                <td>".$data['name_owner']."</td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td>".$data['name_dept']."</td>
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
                <td>".ucwords($data['assetType_ipad'])."</td>
                <td>".ucwords($data['modelType_ipad'])."</td>
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

    $sql_ipad = " SELECT * FROM ipad WHERE rfidno_ipad = '".$rfidno."' && delete_ipad = '0' ";
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
                                <th>Device Name</th>
                                <td>".$data_ipad['assetType_ipad']."</td>
                            </tr>
                            <tr>
                                <th>Model Name</th>
                                <td>".$data_ipad['modelType_ipad']."</td>
                            </tr>
                            <tr>
                                <th>RFID No.</th>
                                <td>1020000700".$data_ipad['rfidno_ipad']."</td>
                            </tr>
                            <tr>
                                <th>Serial No.</th>
                                <td>".$data_ipad['serialNo_ipad']."</td>
                            </tr>
                        </thead>
                    </table>
                    <br>
                    <table class='table table-bordered table-responsive'>
                        <thead>
                            <tr>
                                <th colspan='2' style='text-align:center;'>Owner Information</th>
                            </tr>
                            <tr>
                                <th width='22%' >Name</th>
                                <td>".$data_owner['name_owner']."</td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td>".$data_owner['name_dept']."</td>
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
                                <td>".$data['assetType_ipad']."</td>
                            </tr>
                            <tr>
                                <th>Model Name</th>
                                <td>".$data['modelType_ipad']."</td>
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
                                <th colspan='2' style='text-align:center;'>Owner Information</th>
                            </tr>
                            <tr>
                                <th width='22%' >Name</th>
                                <td>".$data['name_owner']."</td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td>".$data['name_dept']."</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
                ";
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
    
    if($_POST["remarks"] != ""){
        $remarks = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['remarks']);
    }
    else{
        $remarks = 'None';
    }
 
    $sql = "INSERT INTO ipad (modelType_ipad,assetType_ipad,rfidno_ipad,serialNo_ipad,dateregistered_ipad,remarks_ipad,status_ipad,box_ipad,adapter_ipad,wire_ipad,accesories_ipad,otherAccessories_ipad,ID_users,delete_ipad) values ('".$assetType."','1020000".$rfidno."','".$sirino."',NOW(),'".$remarks."','0','".$box."','".$adapter."','".$cable."','".$accesories."','".$detailAccessories."','".$dataUsers['ID_users']."','0')";
    $query = mysqli_query($dbconn_ipadManagement, $sql);
    
    if($query){
        $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has inserted the new iPad',NOW())";
        $query_notification = mysqli_query($dbconn_ipadManagement, $sql_notification);
        {
            $output = "Success";
        }
        $_SESSION['serialNo'] = $sirino;
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
    
    $sql = "UPDATE ipad SET modelType_ipad = '".$modelType."', assetType_ipad = '".$assetType."', rfidno_ipad = '1020000".$rfidno."', dateupdated_ipad = NOW(), dateregistered_ipad = '".$dateregistered."', remarks_ipad = '".$remarks."', box_ipad = '".$box."', adapter_ipad = '".$adapter."', wire_ipad = '".$cable."', otherAccessories_ipad = '".$detailAccessories."', accesories_ipad = '".$accesories."'
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

//preview Inuse owner & iPad information (modal)
if($_POST["status"] == "viewDetailsInUse")
{
    $ipadOwnerID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ipadOwnerID']);
    
    $sql_ipadOwner = "
    SELECT ipad.*,owner.*,rental_return.*,department.*,users.*,rental.* FROM rental_return
    INNER JOIN ipad ON ipad.ID_ipad = rental_return.ID_ipad
    INNER JOIN owner ON owner.ID_owner = rental_return.ID_owner
    INNER JOIN department ON department.ID_dept = owner.ID_dept
    INNER JOIN rental ON rental.ID_rental = rental_return.ID_rental
    INNER JOIN users ON users.ID_users = rental.ID_users
    WHERE rental_return.ID_rentalReturn = '".$ipadOwnerID."' AND ipad.delete_ipad = '0'";
    $query_ipadOwner = mysqli_query($dbconn_ipadManagement,$sql_ipadOwner);
    $data_ipadOwner = mysqli_fetch_assoc($query_ipadOwner);

    $_SESSION['actions'] = $data_ipadOwner['ID_rentalReturn'];
    $dateassigned_ipadOwner = date('d F Y', strtotime($data_ipadOwner['dateassigned_ipadOwner']));
    
    if($query_ipadOwner != ""){
        $outputs = "
            <div class='modal-header'>
                <h5 class='modal-title'>".ucwords($data_ipadOwner['name_owner'])." iPad Details</h5>
                <button type='button' class='close' data-dismiss='modal'><span>&times;</span>
                </button>
            </div>
            <div class='modal-body' >
                <div class='row'>
                  <div class='col-lg-6 mb-12'>
                    <div class='alert alert-dark'><center><b>iPad Information</b></center></div>
                    <table class='table table-bordered' >
                        <tr>
                            <th width='30%'><b>Device Name</b></th>
                            <td style='text-transform:capitalize' > ".ucwords($data_ipadOwner['assetType_ipad'])."</td>
                        </tr>
                        <tr>
                            <th width='30%'><b>Model Name</b></th>
                            <td style='text-transform:capitalize' > ".ucwords($data_ipadOwner['modelType_ipad'])."</td>
                        </tr>
                        <tr>
                            <th width='30%'><b>RFID No.</b></th>
                            <td style='text-transform:capitalize' >1020000700".$data_ipadOwner['rfidno_ipad']."</td>
                        </tr>
                        <tr>
                            <th width='30%'><b>Serial No.</b></th>
                            <td style='text-transform:capitalize' >".strtoupper($data_ipadOwner['serialNo_ipad'])."</td>
                        </tr>
                    </table>
                  </div>
                  <div class='col-lg-6 mb-12'>
                    <div class='alert alert-dark'><center><b>User Information</b></center></div>
                    <table class='table table-bordered' >
                        <tr>
                            <th width='30%'><b>Name</b></th>
                            <td style='text-transform:capitalize' > ".ucwords($data_ipadOwner['name_owner'])."</td>
                        </tr>
                        <tr>
                            <th width='30%'><b>Department</b></th>
                            <td style='text-transform:capitalize' >".ucwords($data_ipadOwner['name_dept'])."</td>
                        </tr>
                    </table>
                  </div>
                </div>
                <div class='row'>
                  <div class='col-lg-6 mb-12'>
                    <div class='alert alert-dark'><center><b>Loan Information</b></center></div>
                    <table class='table table-bordered' >
                        <tr>
                            <th width='30%'><b>Staff In Charge</b></th>
                            <td style='text-transform:capitalize' > ".ucwords($data_ipadOwner['name_users'])."</td>
                        </tr>
                        <tr>
                            <th width='30%'><b>Date Assigned</b></th>
                            <td style='text-transform:capitalize' >".$dateassigned_ipadOwner."</td>
                        </tr>
                    </table>
                  </div>
                  <div class='col-lg-6 mb-12'>
                    <div class='alert alert-dark'><center><b>Fixed asset receipt</b></center></div>
                        <center>
                        <button type='button' class='btn btn-rounded btn-warning btn-download addDateDownload' id='".$data_ipadOwner['ID_rentalReturn']."'>&nbsp;&nbsp;&nbsp;&nbsp;Download&nbsp;<i class='ti ti-download color-warning'></i></button>
                         &nbsp;
                        <button type='button' class='btn btn-rounded btn-info btn-download addDateView' id='".$data_ipadOwner['ID_rentalReturn']."' >&nbsp;&nbsp;&nbsp;&nbsp;View&nbsp;<i class='ti ti-eye color-warning' ></i></button><br><br>
                        <center>
                    <div class='alert alert-dark'><center><b>Upload Fixed asset receipt</b></center></div>
                        </center>";
                    
                    if($data_ipadOwner['fixedassetform'] == ""){
                $outputs .= "
                <div id='load'>
                        <center>
                        <button type='button' id='myButton' onclick='myFunction()' class='btn btn-rounded btn-success btn-download'>&nbsp;&nbsp;&nbsp;&nbsp;Upload&nbsp;<i class='ti ti-upload color-success'></i></button>
                        </center>
                        <form id='uploadFile' method='POST' enctype='multipart/form-data'>
                            <div id='myDIV' style='display:none'>
                                <div class='input-group'>
                                    <div class='custom-file'>
                                        <input type='file' id='pdfFile' name='pdfFile' class='custom-file-input'>
                                        <input type='hidden' id='status' name='status' value='submitFile'>
                                        <input type='hidden' id='fileID' name='fileID' value='".$data_ipadOwner['ID_rentalReturn']."'>
                                        <label class='custom-file-label' >Choose file</label>
                                    </div>
                                    <div class='input-group-append'>
                                        <input class='btn btn-primary' type='submit' name='submit' value='Submit' >
                                    </div>
                                </div>
                            </div>
                        </form><br>
                        <div id='pdfFile-error' class='invalid-feedback animated fadeInUp' style='display: none;'>Please select the file</div>";
                    }else{
                    
            $outputs .= "
                        <center>
                        <a href='../system".$data_ipadOwner['fixedassetform']."' class='btn btn-rounded btn-warning btn-download' download>&nbsp;&nbsp;&nbsp;&nbsp;Download&nbsp;<i class='ti ti-download color-warning'></i></a>
                        &nbsp;
                        <a href='../system".$data_ipadOwner['fixedassetform']."' type='button' class='btn btn-rounded btn-info btn-download' target='blank'>&nbsp;&nbsp;&nbsp;&nbsp;View&nbsp;<i class='ti ti-eye color-warning' ></i></a>
                        &nbsp;
                        <button type='button' class='btn btn-rounded btn-danger btn-download' >&nbsp;&nbsp;&nbsp;&nbsp;Delete&nbsp;<i class='ti ti-trash color-warning' ></i></button>
                        
                        </center>
                        </div>
                        
                        ";
                        
                        
                        
                    }
                $outputs .= "</div>
                </div>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-light' data-dismiss='modal'>Close</button>
            </div>";
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
                                <th width='30%'><b>Owner Name</b></th>
                                <td style='text-transform:capitalize' > ".$data_owner['name_owner']."</td>
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
    $accesories = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['accesories']);
    $cover = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['cover']);
    $screen = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['screen']);
    $otherdamage = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['otherdamage']);
    
    $sql_return = "INSERT INTO returnIpad (screen_return,cover_return,cable_return,adapter_return,box_return,otherdamage_return,accesories_return)
     VALUES ('".$screen."','".$cover."','".$cable."','".$adapter."','".$box."','".$otherdamage."','".$accesories."')";
    $query_return = mysqli_query($dbconn_ipadManagement,$sql_return);
    $last_returnid = mysqli_insert_id($dbconn_ipadManagement);
    
    if($query_return){
        $sql_update = "UPDATE rental_return SET ID_return = '".$last_returnid."', status_ipadOwner = '2' WHERE ID_owner = '".$ownerID."' AND ID_ipad = '".$ipadID."' AND status_ipadOwner = '1' ";
        $query_update = mysqli_query($dbconn_ipadManagement,$sql_update);
        
        if($query_update){
            $sql_updateiPad = "UPDATE ipad SET status_ipad = '2' WHERE ID_ipad = '".$ipadID."' && delete_ipad = '0' ";
            $query_updateiPad = mysqli_query($dbconn_ipadManagement, $sql_updateiPad);

            if($query_updateiPad){
                $sql_updateOwner = "UPDATE owner SET status_owner = '2' WHERE ID_owner = '".$ownerID."' ";
                $query_updateOwner = mysqli_query($dbconn_ipadManagement, $sql_updateOwner);

                if($query_updateOwner){
                    $sql_notification = "INSERT INTO notifications (name_noti,details_noti,timeStamp_noti) values ('".$dataUsers['name_users']."', 'has receive the return iPad',NOW())";
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


//======================== Done ============================

//Assign user kepada ipad (modal)
if($_POST["status"] == "AssignUser")
{
    $ipadID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ipadID']);
    
    $sql = "SELECT * FROM ipad WHERE ID_ipad = '".$ipadID."' && delete_ipad = '0' ";
    $query = mysqli_query($dbconn_ipadManagement,$sql);
    $data = mysqli_fetch_assoc($query);
    
    if($data['condition_ipad'] == 0){
        $condition = "New";
    }
    else{
        $condition = "Used";
    }
    
    if($data['remarks_ipad'] == ""){
        $remarks_ipad = "None";
    }
    else{
        $remarks_ipad = $data['remarks_ipad'];
    }
    
    $sql_ownerDistinct = "SELECT DISTINCT(name_owner),ID_owner,status_owner FROM owner";
	$query_ownerDistinct = mysqli_query($dbconn_ipadManagement,$sql_ownerDistinct);

    if($query){
        $outputs .= "
            <div class='modal-header'>
                <h5 class='modal-title'>Assign User</h5>
                <button type='button' class='close' data-dismiss='modal'><span>&times;</span>
                </button>
            </div>
            <div class='modal-body' >
                <div class='row'>
                  <div class='col mb-12'>
                    <div class='alert alert-dark'><center><b>iPad Information</b></center></div>
                    <table class='table table-bordered' >
                        <tr>
                            <th width='30%'><b>Device Name</b></th>
                            <td style='text-transform:capitalize' > ".ucwords($data['assetType_ipad'])."</td>
                            <input type='hidden' id='ipadID' class='ipadID' name='ipadID' value='".$data['ID_ipad']."'>
                        </tr>
                        <tr>
                            <th width='30%'><b>Model Name</b></th>
                            <td style='text-transform:capitalize' > ".ucwords($data['modelType_ipad'])."</td>
                            <input type='hidden' id='ipadID' class='ipadID' name='ipadID' value='".$data['ID_ipad']."'>
                        </tr>
                        <tr>
                            <th width='30%'><b>RFID No.</b></th>
                            <td>1020000700".$data['rfidno_ipad']."0000</td>
                        </tr>
                        <tr>
                            <th width='30%'><b>Serial No.</b></th>
                            <td style='text-transform:uppercase' >".$data['serialNo_ipad']."</td>
                        </tr>
                        <tr>
                            <th width='30%'><b>Condition</b></th>
                            <td style='text-transform:capitalize' >".$condition."</td>
                        </tr>
                        <tr>
                            <th width='30%'><b>Remarks</b></th>
                            <td style='text-transform:capitalize' >".$remarks_ipad."</td>
                        </tr>
                    </table>
                  </div>
                  <div class='col mb-12'>
                    <div class='alert alert-dark'><center><b>User Information</b></center></div>
                    <select id='SelectOwnerID' class='form-control SelectOwnerID' placeholder='Pick a state...'>
                        <option value=''>Please select</option>";
        
                        while( $dataOwner = mysqli_fetch_array($query_ownerDistinct))
                        {
                            if($dataOwner['status_owner'] == '1'){
                                $outputs .= "<option value='".$dataOwner['ID_owner']."' disabled>".ucwords($dataOwner['name_owner'])."</option>";
                            }
                            else{ 
                                $outputs .= "<option value='".$dataOwner['ID_owner']."'>".ucwords($dataOwner['name_owner'])."</option>";
                            } 
                        }
                        $outputs .= "
                        <option value='others'>Others...</option>
                    </select><br>
                    <span id='addNewUser' style='display:none'>
                    <div class='form-group row'>
                        <label class='col-lg-12 col-form-label' for='val-ownerName'>Name
                            <span class='text-danger'>*</span>
                        </label>
                        <div class='col-lg-12'>
                            <input type='text' class='form-control' id='val-ownerName' name='val-ownerName' placeholder='Enter the owner name..'>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label class='col-lg-12 col-form-label' for='val-ownerDept'>Department / Division
                            <span class='text-danger'>*</span>
                        </label>
                        <div class='col-lg-12'>
                            <input type='text' class='form-control val-ownerDept' id='val-ownerDept' name='val-ownerDept' placeholder='Enter the department / division name..'>
                        </div>
                    </div>
                    </span>
                    <table class='table table-bordered' id='detailsOwner' >
                    </table>
                  </div>
                </div>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-light' data-dismiss='modal'>Close</button>
                <!-- Go to Function (B) -->
                <button type='button' class='btn btn-primary' id='btnNextAssignOwner' disabled='disabled'>Submit</button>
            </div>
            ";
    }
}

//Assign ipad kepada user (modal)
if($_POST["status"] == "AssignIpad")
{
    $ownerID = mysqli_real_escape_string($dbconn_ipadManagement,$_POST['ownerID']);
    
    $sql = "SELECT owner.*,department.* FROM owner
    INNER JOIN department ON owner.ID_dept = department.ID_dept
    WHERE owner.ID_owner = '".$ownerID."' ";
    $query = mysqli_query($dbconn_ipadManagement,$sql);
    $data = mysqli_fetch_assoc($query);
    
    $sql_ipadDistinct = "SELECT DISTINCT assetType_ipad,modelType_ipad,ID_ipad,status_ipad,rfidno_ipad,serialNo_ipad FROM ipad WHERE delete_ipad = '0'";
	$query_ipadDistinct = mysqli_query($dbconn_ipadManagement,$sql_ipadDistinct);

    if($query){
        $outputs .= "
            <div class='modal-header'>
                <h5 class='modal-title'>Assign iPad</h5>
                <button type='button' class='close' data-dismiss='modal'><span>&times;</span>
                </button>
            </div>
            <div class='modal-body' >
                <div class='row'>
                  <div class='col mb-12'>
                    <div class='alert alert-dark'><center><b>User Information</b></center></div>
                    <table class='table table-bordered' >
                        <tr>
                            <th width='30%'><b>Name</b></th>
                            <td style='text-transform:capitalize' > ".$data['name_owner']."</td>
                            <input type='hidden' id='ownerID' class='ownerID' name='ownerID' value='".$data['ID_owner']."'>
                        </tr>
                        <tr>
                            <th width='30%'><b>Department</b></th>
                            <td style='text-transform:capitalize' >".$data['name_dept']."</td>
                        </tr>
                    </table>
                  </div>
                  <div class='col mb-12'>
                    <div class='alert alert-dark'><center><b>iPad Information</b></center></div>
                    <select id='SelectIpadID' class='form-control SelectIpadID' placeholder='Pick a state...'>
                        <option value=''>Please select</option>";
        
                        while( $dataIpad = mysqli_fetch_array($query_ipadDistinct))
                        {
                            if($dataIpad['status_ipad'] == '1'){
                                $outputs .= "<option value='".$dataIpad['ID_ipad']."' disabled>1020000700".$dataIpad['rfidno_ipad']." - ".strtoupper($dataIpad['serialNo_ipad'])."</option>";
                            }
                            else{ 
                                $outputs .= "<option value='".$dataIpad['ID_ipad']."'>1020000700".$dataIpad['rfidno_ipad']." - ".strtoupper($dataIpad['serialNo_ipad'])."</option>";
                            } 
                        }
                        $outputs .= "
                    </select><br>
                    <table class='table table-bordered' id='detailsIpad' ></table>
                  </div>
                </div>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-light' data-dismiss='modal'>Close</button>
                <!-- Go to Function (B) -->
                <button type='button' class='btn btn-primary' id='btnNextAssignIpad' disabled='disabled'>Submit</button>
            </div>
            ";
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
                                <td style='text-transform:capitalize' >".ucwords($data_ipad['assetType_ipad'])."</td>
								<input type='hidden' id='ipadID' name='ipadID' value='".$data_ipad['ID_ipad']."'>
                            </tr>
                            <tr>
                                <th width='30%'><b>Model Name</b></th>
                                <td style='text-transform:capitalize' >".ucwords($data_ipad['modelType_ipad'])."</td>
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

    
    if($query_owner != ""){
        $outputs = "
        <tr>
            <th colspan='2'><center><b>User Information</b></center></th>
        </tr>
        <tr>
            <th width='30%'><b>Name</b></th>
            <td style='text-transform:capitalize' >".$data_owner['name_owner']."</td>
        </tr>
        <tr>
            <th width='30%'><b>Department</b></th>
            <td style='text-transform:capitalize' >".$data_owner['name_dept']."</td>
        </tr>";
    }
}



    if($output){
        echo json_encode($output); 
    }else{
        echo $outputs; 
    }

?>

<script>
    $('#SelectOwnerID').change(function(){
        var ownerID = $('#SelectOwnerID').val() ;
        
        if(ownerID == ''){
            $('#btnNextAssignOwner').prop('disabled', true);
            $('#detailsOwner').hide();
            $('#addNewUser').hide();
        }
        else if(ownerID == 'others') {
            $('#addNewUser').show().fadeIn(1800);
            $('#detailsOwner').hide();
            
            $('#btnNextAssignOwner').prop('disabled', true);

            function validateNextButton() {
                var buttonDisabled = $('#val-ownerDept').val().trim() === '' || $('#val-ownerName').val().trim() === '';
                $('#btnNextAssignOwner').prop('disabled', buttonDisabled);
            }

            $('#val-ownerDept').on('keyup', validateNextButton);
            $('#val-ownerName').on('keyup', validateNextButton);
            
        } else if(ownerID != 'others') {
            var status = "detailsOwner";
            $('#btnNextAssignOwner').removeAttr('disabled');
            
            $.ajax({  
                url:"../system/process.php",  
                method:"POST",  
                dataType: "json",
                data:{status:status,ownerID:ownerID},  
                success:function(data){ 
                     $('#detailsOwner').show();
                     $('#detailsOwner').html(data);
                     $('#addNewUser').hide();
                }  
           });
        }
    });
    
    $('#btnNextAssignOwner').click(function() {
    var status = "submitAssignOwner";
	var ipadID = $("#ipadID").val();
    var ownerID = $("#SelectOwnerID").val();
        
    if(ownerID == ""){
       $(".form-valide").valid();
    }

    if(ownerID != "" ){ 
        $.ajax({
          url: "../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            ipadID : ipadID,
            ownerID : ownerID
          },
          success: function(data) {
              swal({
                   title: "Successfully!",
                   text: "Assign User Successfully!",
                   type: "success",
                   showCancelButton: false,
                   confirmButtonColor: "#3085d6",
                   confirmButtonText: "Done",
                   closeOnConfirm: false
                }, function () {
                      window.location.href='form/assignipadreceipt.php'; 
                });
          },
            error: function() {
				alert('Error occured');
			}
        });
    }
  });
    
    $('#SelectIpadID').change(function(){
        var ipadID = $('#SelectIpadID').val() ;
        
        if(ipadID != '') {
            var status = "detailsIpad";
            $('#btnNextAssignIpad').removeAttr('disabled');
            $.ajax({  
                url:"../system/process.php",  
                method:"POST",  
                dataType: "json",
                data:{status:status,ipadID:ipadID},  
                success:function(data){ 
                     $('#detailsIpad').show();
                     $('#detailsIpad').html(data);
                }  
           }); 
        }
        else{
            $('#btnNextAssignIpad').prop('disabled', true);
            $('#detailsIpad').hide();
        }
    });
    
 $('#btnNextAssignIpad').click(function() {
    var status = "submitAssignOwner";
    
    var ipadID = $("#SelectIpadID").val();
    var ownerID = $("#ownerID").val();

    if(ipadID == ""){
       $(".form-valide").valid();
    }

    if(ownerID != "" && ipadID != "" ){ 
        $.ajax({
          url: "../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            ipadID : ipadID,
            ownerID : ownerID
          },
          success: function(data) {
              swal({
                   title: "Successfully!",
                   text: "Assign iPad Successfully!",
                   type: "success",
                   showCancelButton: false,
                   confirmButtonColor: "#3085d6",
                   confirmButtonText: "Done",
                   closeOnConfirm: false
                }, function () {
                      window.location.href='form/assignipadreceipt.php'; 
                });
          },
            error: function() {
				alert('Error occured');
			}
        });
    }
  });
    
            
    $("#uploadFile").submit (function (event){
        event.preventDefault();
        var formData = new FormData(this);
  
            $.ajax({
              url: "../system/process.php",
              method: "POST",
              dataType:"json",
              contentType: false,
              cache: false,
              processData:false,
              data: formData,
              success: function(data) {
                  if ($.trim(data) === "Failed"){
                      swal("Error!", "Please check the internet connection!", "error");
                  }
                  else if ($.trim(data) === "Faileds"){
                      swal("Error!", "Only .PDF format is allowed!", "warning");
                  }
                  else {
                    swal("Successfully!", "Upload Form Successfully!", "success");
                      $("#load").load("../system/ipad/uploadFixedReceipt.php", {
                           fileID: data
                       });
                  }
              },
                error: function() {
                    alert('Error occured');
                }
            });
    });
    
    $('.addDateView').click(function() {
        var ipadOwnerID = $(this).attr("id");
        var status = "displayDateView";

        if(ipadOwnerID != "" ){ 
            $.ajax({
              url: "../system/process.php",
              method: "POST",
                dataType:"json",
              data: {
                status: status,
                ipadOwnerID : ipadOwnerID
              },
              success: function(data) {
                    $('#basicModalDetailsView').html(data);
                    $("#basicModalDateView").modal('show');
                    $("#basicModal").modal('hide');
              },
                error: function() {
                    alert('Error occured');
                }
            });
        }
    });
    
    $('.addDateDownload').click(function() {
        var ipadOwnerID = $(this).attr("id");
        var status = "displayDateDownload";

        if(ipadOwnerID != "" ){ 
            $.ajax({
              url: "../system/process.php",
              method: "POST",
                dataType:"json",
              data: {
                status: status,
                ipadOwnerID : ipadOwnerID
              },
              success: function(data) {
                    $('#basicModalDetailsDownload').html(data);
                    $("#basicModalDateDownload").modal('show');
                    $("#basicModal").modal('hide');
              },
                error: function() {
                    alert('Error occured');
                }
            });
        }
    });
    
</script>
