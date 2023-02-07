<?php

    session_start();
    include("./system/dbconn.php");
    mysqli_select_db($dbconn_directorTraining, 'directorTraining');
    mysqli_select_db($dbconn_ipadManagement, 'ipadManagement');
    
    $sql_users = "SELECT * FROM users WHERE email_users = '".$_SESSION['unlock_key']."' ";
    $query_users = mysqli_query($dbconn_ipadManagement,$sql_users);
    $dataUsers = mysqli_fetch_assoc($query_users);

    $sql_director = "SELECT * FROM director WHERE ID_director = '".$_POST['ID_director']."'";
    $query_director = mysqli_query($dbconn_directorTraining,$sql_director);
    $count_director = mysqli_num_rows($query_director);
    $data_director = mysqli_fetch_assoc($query_director);

    $sql_organiser = "SELECT * FROM organiser";
    $query_organiser = mysqli_query($dbconn_directorTraining,$sql_organiser);
    $count_organiser = mysqli_num_rows($query_organiser);

    $sql_training = "SELECT director.*, organiser.*, TrainingProgram.* FROM TrainingProgram
    INNER JOIN director ON director.ID_director = TrainingProgram.ID_director
    INNER JOIN organiser ON organiser.ID_organiser = TrainingProgram.ID_organiser
    WHERE director.ID_director = '".$_POST['ID_director']."' ORDER BY TrainingProgram.StartDate_trainingProgram ASC ";
    $query_training = mysqli_query($dbconn_directorTraining,$sql_training);
    $data_training = mysqli_fetch_assoc($query_training);
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
            <a href="./" class="brand-logo">
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
                            
                        </div>

                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="mdi mdi-account"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="./app-profile.html" class="dropdown-item">
                                        <i class="icon-user"></i>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="./email-inbox.html" class="dropdown-item">
                                        <i class="icon-envelope-open"></i>
                                        <span class="ml-2">Inbox </span>
                                    </a>
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
                            <li class="breadcrumb-item"><a href="./">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">View Training List</a></li>
                      </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12" id="tableTrainingList" >
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">LIST OF DIRECTOR'S TRAINING <?php echo date("Y"); ?> - <?php echo $data_director['Name_director'] ?></h4>
                            </div><br>
                            <div>
                                <div class="row justify-content-md-center">
                                    <div class="col-lg-12">
                                        <center>
                                            <?php if($Count_training > 0){ ?>
                                                <form action="./listReceipt.php" method="POST" >
                                                    <input type="hidden" name="ACTION" value="VIEW">
                                                    <input type="Hidden" name="ID_director" value="<?php echo $data_director['ID_director'] ?>">
                                                    <button type="submit"  class="btn btn-success" ><i class="ti-printer"></i> &nbsp;&nbsp;Print List</button>
                                                </form>
                                            <?php } ?>
                                                <form>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" ><i class="ti-plus"></i>&nbsp;&nbsp; Add Training/Program</button>
                                                </form>
                                        </center>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive table-height">
                                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                            <?php if($Count_training > 0){ ?>
                                            <thead>
                                                <tr>
                                                    <th scope="col">No.</th>
                                                    <th scope="col">Date of Training/Program</th>
                                                    <th scope="col">Training/Program Attended</th>
                                                    <th scope="col">Organiser</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($query_training as $data) { ?>
                                                <tr>
                                                    <td align="center"><?php echo $i ?>.</td>
                                                    <td><?php if($data['StartDate_trainingProgram'] != $data['EndDate_trainingProgram']){ ?>
                                                            <center><?php echo date('d F Y', strtotime($data['StartDate_trainingProgram'])) ?><br><b>to</b><br><?php echo date('d F Y', strtotime($data['EndDate_trainingProgram'])) ?></center>
                                                        <?php } else {?>
                                                            <center><?php echo date('d F Y', strtotime($data['StartDate_trainingProgram'])) ?></center>
                                                        <?php } ?>

                                                    </td>
                                                    <td width="40%">
                                                        <?php echo nl2br($data['Name_trainingProgram']) ?>
                                                        <input type="hidden" id="Name_trainingProgramDelete" value="<?php echo $data['Name_trainingProgram'] ?>">
                                                        <input type="hidden" id="StartDate_trainingProgramDelete" value="<?php echo $data['StartDate_trainingProgram'] ?>">
                                                        <input type="hidden" id="EndDate_trainingProgramDelete" value="<?php echo $data['EndDate_trainingProgram'] ?>">
                                                        <input type="hidden" id="Name_organiserDelete" value="<?php echo $data['Name_organiser'] ?>">
                                                    </td>
                                                    <td><?php echo $data['Name_organiser'] ?></td>
                                                    <td width="15%"><center>
                                                            <button type="button" id="<?php echo $data['ID_trainingProgram'] ?>" class="btn btn-info updateTraining" >Edit <i class="ti-pencil-alt"></i></button><br>
                                                            <button type="button" id="<?php echo $data['ID_trainingProgram'] ?>" class="btn btn-danger deleteTraining" style="margin-top:5px">Delete <i class="ti-trash"></i></button>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php $i++; } ?>
                                            </tbody>
                                            <?php }else{ ?>
                                            <center>
                                                <img width="40%" src="system/images/no_pic.png"><br><br><br>
                                            </center>
                                            <?php } ?>
                                        </table>
                                    </div>
                                    <div id="printThisDiv" style="display:none;">
                                        <div style="padding:50px;padding-top:10px;">
                                            <div class="card-header">
                                                <h4 class="card-title" style="font-size:20px;">LIST OF DIRECTOR'S TRAINING 2021 - <?php echo $data_training['Name_director'] ?></h4><br><br><br><br>
                                            </div>
                                            <div class="table-responsive tablePrint">
                                                <table class="table table-bordered verticle-middle table-responsive-sm" style="width:100%">
                                                    <thead>
                                                        <tr >
                                                            <th scope="col" style="border-color:black !important;font-size:15px !Important;background:lightgrey !important;">No.</th>
                                                            <th scope="col" style="border-color:black !important;font-size:15px !Important;background:lightgrey !important;">Date of Training/ Program</th>
                                                            <th scope="col" style="border-color:black !important;font-size:15px !Important;background:lightgrey !important;">Training/Program Attended</th>
                                                            <th scope="col" style="border-color:black !important;font-size:15px !Important;background:lightgrey !important;">Organiser</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i='1';
                                                        foreach($query_training as $data) { ?>
                                                        <tr>
                                                            <td style="border-color:black !important;font-size:14px !Important;text-align:center;"><?php echo $i ?>.</td>
                                                            <td style="border-color:black !important;font-size:14px !Important;"><?php echo date('d F Y', strtotime($data['StartDate_trainingProgram'])) ?></td>
                                                            <td style="border-color:black !important;font-size:14px !Important;"><?php echo nl2br($data['Name_trainingProgram']) ?></td>
                                                            <td style="border-color:black !important;font-size:14px !Important;"><?php echo $data['Name_organiser'] ?></td>
                                                        </tr>
                                                        <?php $i++; } ?>
                                                    </tbody>
                                                </table>
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
                                        <input type="text" class="form-control Name_director" placeholder="Enter the director name" value="<?php echo $data_director['Name_director'] ?>">
                                        <input type="hidden" class="form-control Count_director" value="<?php echo $count_director; ?>">
                                    </div>
                                </div>
                                <div class="form-group row" id="SelectDirectorInput" style="display:none;">
                                    <label class="col-lg-12 col-form-label">Director Name</label>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control Name_SelectDirector" placeholder="Enter the director name" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label">Training/Program Attended</label>
                                    <div class="col-lg-12">
                                        <textarea class="form-control Name_trainingProgram" id="Name_trainingProgram" placeholder="Enter the training/program title" style="white-space: pre-wrap;" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label">Organiser/Speaker</label>
                                    <div class="col-lg-12">
                                        <?php if($count_organiser > 0){ ?>
                                            <select class="form-control Name_organiser" id="SelectOrganiser">
                                                <option value="" >Select organiser/speaker </option>
                                                <?php foreach($query_organiser as $data_03) { ?>
                                                    <option value="<?php echo $data_03['Name_organiser']; ?>" ><?php echo ucwords($data_03['Name_organiser']); ?></option>
                                                <?php } ?>
                                                <option value="InputText" >Other </option>
                                            </select>
                                        <?php }else{ ?>
                                            <input type="text" class="form-control Name_organiser" placeholder="Enter the organiser/speaker">
                                        <?php } ?>
                                            <input type="hidden" class="form-control Count_organiser" value="<?php echo $count_organiser; ?>">
                                    </div>
                                </div>
                                <div class="form-group row" id="SelectOrganiserInput" style="display:none;">
                                    <label class="col-lg-12 col-form-label">Organiser/Speaker</label>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control Name_SelectOrganiser" placeholder="Enter the organiser/speaker" >
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
        
        <div class="modal fade bd-example-modal-lg" id="modalUpdate" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" id="myform">
                    <div class="modal-header">
                        <h5 class="modal-title">Director Training Form Update</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="updateTraining">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateDataTraining">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="#" target="_blank">Quixkit</a> 2019</p>
            </div>
        </div>

        
    </div>
    
    <script src="./system/vendor/global/global.min.js"></script>
    <script src="./system/js/quixnav-init.js"></script>
    <script src="./system/js/custom.min.js"></script>
    <script src="./system/jquery.js"></script>
    <script src="./system/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="./system/js/plugins-init/sweetalert.init.js"></script>
    



</body>

</html>