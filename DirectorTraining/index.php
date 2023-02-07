<?php

    session_start();
    include("./system/dbconn.php");
    
    mysqli_select_db($dbconn_directorTraining, 'directorTraining');
    mysqli_select_db($dbconn_ipadManagement, 'ipadManagement');
    
    $sql_users = "SELECT * FROM users WHERE email_users = '".$_SESSION['unlock_key']."' ";
    $query_users = mysqli_query($dbconn_ipadManagement,$sql_users);
    $dataUsers = mysqli_fetch_assoc($query_users);

    $sql_director = "SELECT * FROM director";
    $query_director = mysqli_query($dbconn_directorTraining,$sql_director);
    $count_director = mysqli_num_rows($query_director);

    $sql_organiser = "SELECT * FROM organiser";
    $query_organiser = mysqli_query($dbconn_directorTraining,$sql_organiser);
    $count_organiser = mysqli_num_rows($query_organiser);

    $sql_training = "SELECT director.*, organiser.*, TrainingProgram.* FROM TrainingProgram
    INNER JOIN director ON director.ID_director = TrainingProgram.ID_director
    INNER JOIN organiser ON organiser.ID_organiser = TrainingProgram.ID_organiser ";
    $query_training = mysqli_query($dbconn_directorTraining,$sql_training);
    $Count_training = mysqli_num_rows($query_training);

    $i = 1;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>PNB - Permodalan Nasional Berhad </title>
    <link rel="icon" type="image/png" sizes="16x16" href="./system/images/logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="./system/css/style.css" rel="stylesheet">
    <link href="./system/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
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
            <a href="index.html" class="brand-logo">
                <img class="logo-abbr" src="./system/images/logo-text.png" alt="">
                <img class="logo-compact" src="./system/images/logo-text.png" alt="">
                <img class="brand-title" src="./system/images/logo-text.png" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <a href="../dashboard.php" class="fa fa-home" style="font-size:30px;padding-top:2px;"></a>
                        </div>

                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="mdi mdi-account"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="./page-login.html" class="dropdown-item">
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
                    <li class="nav-label first">Menu</li>
                    <li>
                        <a href="./" aria-expanded="false"><i class="material-icons">apps</i><span class="nav-text">Main Menu</span></a>
                    </li>
                    <li class="nav-label">Director</li>
                    <li>
                        <a href="ListDirector.php" aria-expanded="false"><i class="material-icons">person</i><span class="nav-text">List Director</span></a>
                    </li>
                    <li class="nav-label">Configuration</li>
                    <li>
                        <a href="ListDirector.php" aria-expanded="false"><i class="material-icons">settings</i><span class="nav-text">Settings</span></a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0 boxShadow">
                    <div class="col-sm-6 p-md-0">
                      <div class="welcome-text">
                        <h4><?php echo ucwords($dataUsers['name_users']) ?></h4>
                        <p class="mb-0">Secetary Department </p>
                        <p class="mb-0" style="margin-top:-4px;"><?php echo $dataUsers['email_users'] ?></p>
                      </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                          <a href="./">Dashboard</a>
                        </li>
                      </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">List of Director's <?php echo date("Y"); ?></h4><button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" ><i class="ti-plus"></i>&nbsp;&nbsp; Add Training/Program</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-height" id="refreshTable">
                                    <table class="table mb-0">
                                        <?php if($count_director > 0){ ?>
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Director Name</th>
                                                <th>Total Training</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($query_director as $data) {
                                                $sql_training02 = "SELECT director.*, organiser.*, TrainingProgram.* FROM TrainingProgram
                                                            INNER JOIN director ON director.ID_director = TrainingProgram.ID_director
                                                            INNER JOIN organiser ON organiser.ID_organiser = TrainingProgram.ID_organiser
                                                            WHERE director.ID_director = '".$data['ID_director']."' ";
                                                $query_training02 = mysqli_query($dbconn_directorTraining,$sql_training02);
                                                $Count_training02 = mysqli_num_rows($query_training02);
                                            ?>
                                            <tr>
                                                <td width="10%" align="center" ><?php echo $i ?>.</td>
                                                <td width="50%" ><span><?php echo ucwords($data['Name_director']); ?></span></td>
                                                <td align="center" width="20%"><?php echo $Count_training02 ?></td>
                                                <td width="20%" > 
                                                    <form action="viewTrainingList.php" method="POST">
                                                        <input type="hidden" name="ID_director" value="<?php echo ucwords($data['ID_director']); ?>">
                                                        <button class= "btn btn-warning">
                                                            <i class="ti-view-list-alt" style="position:relative;top:1px;"></i> &nbsp;&nbsp;View List
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php $i++; } ?>
                                        </tbody>
                                        <?php }else{ ?>
                                            <center>
                                                <img width="60%" src="system/images/no_pic.png"><br><br><br>
                                            </center>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade bd-example-modal-lg" id="modalInsert" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form class="modal-content" id="myform">
                                <div class="modal-header">
                                    <h5 class="modal-title">Director Training Form</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card-body">
                                        <div class="basic-form">
                                            <div class="form-group row">
                                                <label class="col-lg-12 col-form-label">Director Name</label>
                                                <div class="col-lg-12">
                                                    <?php if($count_director > 0){ ?>
                                                        <select class="form-control Name_director" id="SelectDirector">
                                                            <option value="" >Select director name </option>
                                                            <?php foreach($query_director as $data_01) { ?>
                                                                <option value="<?php echo $data_01['Name_director']; ?>" ><?php echo ucwords($data_01['Name_director']); ?></option>
                                                            <?php } ?>
                                                            <option value="InputText" >Other </option>
                                                        </select>
                                                    <?php }else{ ?>
                                                        <input type="text" class="form-control Name_director" placeholder="Enter the director name">
                                                    <?php } ?>
                                                        <input type="hidden" class="form-control Count_director" value="<?php echo $count_director; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row" id="SelectDirectorInput" style="display:none;">
                                                <label class="col-lg-12 col-form-label">Director Name</label>
                                                <div class="col-lg-12">
                                                    <input type="text" class="form-control Name_SelectDirector" id="Name_SelectDirector" placeholder="Enter the director name" >
                                                    <div id="alertValidateName_directorExist" style="display:none;color:red;margin-top:1px;" >Director name is already registered!</div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-12 col-form-label">Training/Program Attended</label>
                                                <div class="col-lg-12">
                                                    <textarea class="form-control Name_trainingProgram" id="Name_trainingProgram" placeholder="Enter the training/program title" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-12 col-form-label">Organiser/Speaker</label>
                                                <div class="col-lg-12">
                                                    <input type="text" class="form-control Name_organiser" placeholder="Enter the organiser/speaker">
                                                    <input type="hidden" class="form-control Count_organiser" value="<?php echo $count_organiser; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-6" style="padding-left:0">
                                                    <label class="col-lg-12 col-form-label">Start Date of Training/Program</label>
                                                    <div class="col-lg-12">
                                                        <input class="form-control StartDate_trainingProgram" type="date" id="StartDate_trainingProgram" placeholder="Choose the start training/program date"  >
                                                    </div>
                                                </div>
                                                <div class="col-lg-6" style="padding-right:0">
                                                    <label class="col-lg-12 col-form-label">End Date of Training/Program</label>
                                                    <div class="col-lg-12">
                                                        <input class="form-control EndDate_trainingProgram" type="date" id="EndDate_trainingProgram" placeholder="Choose the end training/program date"  >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="submitTraining">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3" id="CountIndicator">
                        <center>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="stat-widget-one card-body">
                                        <div class="stat-icon d-inline-block">
                                            <i class="ti-user text-primary border-primary"></i>
                                        </div><br>
                                        <div class="stat-content d-inline-block">
                                            <div class="stat-text">Total Director</div>
                                            <div class="stat-digit"><?php echo $count_director ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="stat-widget-one card-body">
                                        <div class="stat-icon d-inline-block">
                                            <i class="ti-blackboard text-success border-success"></i>
                                        </div><br>
                                        <div class="stat-content d-inline-block">
                                            <div class="stat-text">Total Organiser</div>
                                            <div class="stat-digit"><?php echo $count_organiser ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="#" target="_blank">Quixkit</a> 2019</p>
                <p>Distributed by <a href="https://themewagon.com/" target="_blank">Themewagon</a></p> 
            </div>
        </div>


    </div>
    <!-- Required vendors -->
    <script src="./system/vendor/global/global.min.js"></script>
    <script src="./system/js/quixnav-init.js"></script>
    <script src="./system/js/custom.min.js"></script>
    <script src="./system/jquery.js"></script>
    <script src="./system/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="./system/js/plugins-init/sweetalert.init.js"></script>

</body>

</html>