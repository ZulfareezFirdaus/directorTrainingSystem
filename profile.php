<?php 
    session_start();
    if(isset($_SESSION['unlock_key'])){
        include("./system/dbconn.php");
        mysqli_select_db($dbconn_ipadManagement, 'ipadManagement');
        
		//for display the information of user login
		$sql_users = "SELECT * FROM users WHERE email_users = '".$_SESSION['unlock_key']."' ";
		$query_users = mysqli_query($dbconn_ipadManagement,$sql_users);
		$dataUsers = mysqli_fetch_assoc($query_users);
        
        if(password_verify('p@ssword1234',$dataUsers['password_users'])){
			header("Location: ./changePassword.php");
		}
		else{
			
		}
        
        $dateregistered_staff = date('d F Y', strtotime($dataUsers['dateregistered_users']));
    }
    else{
        header("Location: ./");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Profile - iPad Management System Company Secretary Department </title>
    <link rel="icon" type="image/png" sizes="5x5" href="./system/images/logo.png">
    <link href="./system/css/style.css" rel="stylesheet">
    <link href="./system/css/themify-icons.css" rel="stylesheet">
    <script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
  <link rel="stylesheet" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">
  </head>

<body>
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    
    <div id="main-wrapper">
        <div class="nav-header">
        <a href="./" class="brand-logo">
          <img class="logo-abbr" src="./system/images/logo-text.png" alt="">
          <img class="logo-compact" src="./system/images/logo-text.png" alt="">
          <img class="brand-title" src="./system/images/logo-text.png" alt="">
        </a>
        <div class="nav-control">
          <div class="hamburger">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
          </div>
        </div>
      </div>
        <div class="header ">
        <div class="header-content">
          <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
              <div class="header-left"></div>
              <ul class="navbar-nav header-right">
                <li class="nav-item dropdown notification_dropdown">
                  <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                    <i class="mdi mdi-bell"></i>
                    <div class="pulse-css"></div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <ul class="list-unstyled">
                      <li class="media dropdown-item">
                        <span class="success">
                          <i class="ti-user"></i>
                        </span>
                        <div class="media-body">
                          <a href="#">
                            <p>
                              <strong>Martin</strong> has added a <strong>customer</strong> Successfully
                            </p>
                          </a>
                        </div>
                        <span class="notify-time">3:20 am</span>
                      </li>
                    </ul>
                    <a class="all-notification" href="#">See all notifications <i class="ti-arrow-right"></i>
                    </a>
                  </div>
                </li>
                <li class="nav-item dropdown header-profile">
                  <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                    <i class="mdi mdi-account"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a href="./profile.php" class="dropdown-item">
                      <i class="icon-user"></i>
                      <span class="ml-2">Profile </span>
                    </a>
                    <a onclick="doSomethingSpecial()" href="#" class="dropdown-item">
                      <i class="icon-key"></i>
                      <span class="ml-2">Logout </span>
                    </a>
                  </div>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
        
        <div class="quixnav">
        <div class="quixnav-scroll">
          <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>
            <li>
              <a href="./iPadManagementSystem/">
                <i class="icon ti-layout-grid2"></i>
                <span class="nav-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-label">Form</li>
            <li>
              <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                <i class="icon ti-write"></i>
                <span class="nav-text">Registration</span>
              </a>
              <ul aria-expanded="false">
                <li><a href="./iPadManagementSystem/form/newIpad.php">New Ipad</a></li>
                <li><a href="./iPadManagementSystem/form/newOwner.php">New User</a></li>
                <li><a href="./iPadManagementSystem/form/newDept.php">New Department</a></li>
              </ul>
            </li>
            <li class="nav-label">Data</li>
            <li>
              <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                <i class="icon ti-archive"></i>
                <span class="nav-text">Record</span>
              </a>
              <ul aria-expanded="false">
                <li><a href="./iPadManagementSystem/data/iPad/listiPad.php?status=AlliPad" aria-expanded="false">iPad</a></li>
                <li><a href="./iPadManagementSystem/data/owner/listOwner.php?status=AllOwner" aria-expanded="false">User</a></li>
                <li><a href="./iPadManagementSystem/data/dept/listDept.php" aria-expanded="false">Department</a></li>
              </ul>
            </li>
            <li class="nav-label">Search</li>
            <li>
              <a href="./iPadManagementSystem/search/ipadtracking.php" aria-expanded="false">
                <i class="icon ti-search"></i>
                <span class="nav-text">iPad Tracking</span>
              </a>
            </li>
            <?php if($dataUsers['status_users'] != '0'){ ?>
            <li class="nav-label">Personal</li>
            <li>
              <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                <i class="icon ti-lock"></i>
                <span class="nav-text">Administration</span>
              </a>
              <ul aria-expanded="false">
                <li>
                  <a href="./iPadManagementSystem/admin/adduser.php">Add Staff</a>
                </li>
                <li>
                  <a href="./iPadManagementSystem/admin/listuser.php">List Staff</a>
                </li>
              </ul>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
        
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0 boxShadow">
                    <div class="col-sm-6 p-md-0">
                      <div class="welcome-text">
                        <h4>Hi, <?php echo ucwords($dataUsers['name_users']) ?></h4>
                        <p class="mb-0">Company Secretary Department </p>
                        <p class="mb-0" style="margin-top:-4px;"><?php echo $dataUsers['email_users'] ?></p>
                      </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./iPadManagementSystem/">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="./profile.php">Profile</a></li>
                        </ol>
                    </div>
                  </div>
                <!-- row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="profile">
                            <div class="profile-head">
                                <div class="photo-content">
                                    <div class="cover-photo" style="background:url(./system/images/bg-03.jpeg)"></div>
                                </div>
                                <div class="profile-info">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-8">
                                            <div class="row">
                                                <div class="col-xl-7 col-sm-4 border-right-1 prf-col">
                                                    <div class="profile-name">
                                                        <h4 class="text-primary"><?php echo ucwords($dataUsers['name_users']) ?></h4>
                                                        <p>Company Secretary Department</p>
                                                    </div>
                                                </div>
                                                <div class="col-xl-5 col-sm-4 border-right-1 prf-col">
                                                    <div class="profile-email">
                                                        <h4 class="text-muted"><?php echo $dataUsers['email_users'] ?></h4>
                                                        <p>Email</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item"><a href="#about-me" data-toggle="tab" class="nav-link active  show">Personal Information</a>
                                            </li>
                                            <li class="nav-item"><a href="#profile-settings" data-toggle="tab" class="nav-link">Update Details</a>
                                            </li>
                                            <li class="nav-item"><a href="#password-settings" data-toggle="tab" class="nav-link">Change Password</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="about-me" class="tab-pane fade active show">
                                                <div class="profile-personal-info">
                                                    <h4 class="text-primary mb-4" style="margin-top:20px;">Personal Information</h4>
                                                    <div class="row mb-4">
                                                        <div class="col-3">
                                                            <h5 class="f-w-500">Name <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-9 font-color-black"><span><?php echo ucwords($dataUsers['name_users']) ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-3">
                                                            <h5 class="f-w-500">Email <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-9 font-color-black"><span><?php echo $dataUsers['email_users'] ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-3">
                                                            <h5 class="f-w-500">Status <span class="pull-right">:</span></h5>
                                                        </div>
                                                        <div class="col-9 font-color-black">
                                                            <?php if($dataUsers['status_users'] == '0'){ ?>
                                                                <span>Normal Staff</span>
                                                            <?php  }else if($dataUsers['status_users'] == '1'){ ?>
                                                                <span>Administrator</span>
                                                            <?php }else if($dataUsers['status_users'] == '2'){ ?>
                                                                <span>Developer</span>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-3">
                                                            <h5 class="f-w-500">Date Register <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-9 font-color-black"><span><?php echo $dateregistered_staff ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="profile-settings" class="tab-pane fade">
                                                <div class="pt-3">
                                                    <div class="settings-form">
                                                        <h4 class="text-primary" style="margin-top:5px;">Update Details</h4>
                                                        <form>
                                                            <div class="form-group" style="margin-top:15px;">
                                                                 <label class="col-lg-12 col-form-label" for="val-password">Name
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <input type="text" value="<?php echo ucwords($dataUsers['name_users']) ?>" name="val-usersName" id="val-usersName" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                 <label class="col-lg-12 col-form-label" for="val-password">Email
                                                                    <span class="text-danger">&nbsp;&nbsp;&nbsp;Cannot be changed!</span>
                                                                </label>
                                                                <input type="text" value="<?php echo $dataUsers['email_users'] ?>" name="val-usersEmail" id="val-usersEmail" class="form-control" disabled>
                                                                <input type="hidden" value="<?php echo $dataUsers['ID_users'] ?>" name="val-usersID" id="val-usersID" class="form-control">
                                                            </div><br>
                                                            <button class="btn btn-primary" type="button" id="btnPreviewUpdateUser">Update</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="password-settings" class="tab-pane fade">
                                                <div class="pt-3">
                                                    <div class="settings-form">
                                                        <h4 class="text-primary" style="margin-top:5px;">Change Password</h4>
                                                        <form class="form-valide" >
                                                            <div class="form-group row">
                                                                <label class="col-lg-12 col-form-label" for="val-password">Current Password
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <div class="col-lg-12">
                                                                    <input type="password" class="form-control" id="val-CurrentPassword" name="val-CurrentPassword" placeholder="Enter the password..">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-12 col-form-label" for="val-password">New Password
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <div class="col-lg-12">
                                                                    <input type="password" class="form-control" id="val-password" name="val-password" placeholder="Enter the password..">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-12 col-form-label" for="val-password">Confirm New Password
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <div class="col-lg-12">
                                                                    <input type="password" class="form-control" id="val-passwordConfirmed" name="val-passwordConfirmed" placeholder="Enter the confirm password..">
                                                                    <input type="hidden" value="<?php echo $dataUsers['ID_users'] ?>" name="val-usersID" id="val-usersID" class="form-control">
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <button class="btn btn-primary" type="button" id="btnPreviewChangePassword" >Update</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="basicModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Staff Information Details</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="usersDetails"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btnSaveChangeUser">Change</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="basicModalPassword">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Staff Password Details</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="PasswordDetails"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btnConfirmChangePassword">Change</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <div class="copyright">
                <p>© Hak Cipta 2022 <a href="https://www.pnb.com.my/" target="_blank">Permodalan Nasional Berhad</a>. Hak Cipta Terpelihara. </p>
            </div>
        </div>
    </div>
    
    <script src="./system/vendor/global/global.min.js"></script>
    <script src="./system/js/quixnav-init.js"></script>
    <script src="./system/js/custom.min.js"></script>
    <script src="./system/vendor/jquery-validation/jquery.validate.min.js"></script>
	<script src="./system/jquery.js"></script>
    <script src="./system/js/plugins-init/jquery.validate-init.js"></script>
    

</body>

</html>