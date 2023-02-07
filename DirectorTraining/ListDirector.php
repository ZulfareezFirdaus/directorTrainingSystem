<?php

    session_start();
    include("./system/dbconn.php");

    mysqli_select_db($dbconn_directorTraining, 'directorTraining');
    mysqli_select_db($dbconn_ipadManagement, 'ipadManagement');

    $sql_director = "SELECT * FROM director";
    $query_director = mysqli_query($dbconn_directorTraining,$sql_director);
    $count_director = mysqli_num_rows($query_director);

    $sql_organiser = "SELECT * FROM organiser";
    $query_organiser = mysqli_query($dbconn_directorTraining,$sql_organiser);
    $count_organiser = mysqli_num_rows($query_organiser);

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
                        <a href="setting.php" aria-expanded="false"><i class="material-icons">settings</i><span class="nav-text">Settings</span></a>
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
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">View Director List</a></li>
                      </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card"><br>
                            <div class="card-header">
                                <h4 class="card-title">LIST OF DIRECTOR'S <?php echo date("Y"); ?></h4>
                            </div><br>
                            <div id="TableDirector">
                                <div class="row justify-content-md-center">
                                    <div class="col-lg-12">
                                        <center>
                                            <?php if($count_director > 0){ ?>
                                                <button type="button" onclick="printDiv('printThisDiv')" class="btn btn-success" ><i class="ti-printer"></i> &nbsp;&nbsp;Print List</button>
                                            <?php } ?>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" ><i class="ti-plus"></i>&nbsp;&nbsp; Add Director</button>
                                        </center>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive table-height">
                                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                            <?php if($count_director > 0){?>
                                            <thead>
                                                <tr>
                                                    <th scope="col">No.</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($query_director as $data) { ?>
                                                <tr>
                                                    <td align="center"><?php echo $i ?>.</td>
                                                    <td><?php echo $data['Name_director'] ?></td>
                                                    <td width="20%">
                                                        <div class="row">
                                                            <div class="col-12" style="text-align:center;">
                                                                <button type="button" id="<?php echo $data['ID_director'] ?>" class="btn btn-info updateDirector"><i class="ti-pencil-alt"></i> Edit</button>
                                                            </div>
                                                        </div>
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
                                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" style="border-color:black !important;font-size:15px !Important;background:lightgrey !important;">No.</th>
                                                            <th scope="col" style="border-color:black !important;font-size:15px !Important;background:lightgrey !important;">Name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = '1'; foreach($query_director as $data) { ?>
                                                        <tr>
                                                            <td align="center" style="border-color:black !important;font-size:14px !Important;"><?php echo $i ?>.</td>
                                                            <td style="border-color:black !important;font-size:14px !Important;" ><?php echo $data['Name_director'] ?></td>
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
                        <h5 class="modal-title">Director Form</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label">Director Name</label>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control Name_director" placeholder="Enter the director name">
                                        <div id="alertValidateName_directorExist" style="display:none;color:red;margin-top:1px;" >Director name is already registered!</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submitBoard">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="modal fade bd-example-modal-lg" id="modalUpdate" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" id="myform">
                    <div class="modal-header">
                        <h5 class="modal-title">Director Form Update</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="updateDirector">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateDataDirector">Submit</button>
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
    
    <script>
  function printDiv(elem)
  {
      var mywindow = window.open();
      var content = document.getElementById(elem).innerHTML;
      var realContent = document.body.innerHTML;
      mywindow.document.write('<link rel="stylesheet" href="./system/css/style.css ">');
      mywindow.document.write(content);
      mywindow.document.close(); 
      mywindow.focus(); 
      mywindow.print();
      document.body.innerHTML = realContent;
      mywindow.close();
      return true;
  }
  </script>
    
    <script src="./system/vendor/global/global.min.js"></script>
    <script src="./system/js/quixnav-init.js"></script>
    <script src="./system/js/custom.min.js"></script>
    <script src="./system/jquery.js"></script>
    <script src="./system/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="./system/js/plugins-init/sweetalert.init.js"></script>
    



</body>

</html>