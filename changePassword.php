<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>PNB - iPad Management System Secetary Dept </title>
    <link rel="icon" type="image/png" sizes="5x5" href="./images/logo.png">
    <link href="./system/css/style.css" rel="stylesheet">
    
    <script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
    <link rel="stylesheet" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css"> 

</head>

<body class="h-100">
    <div id="overlay"></div>
    <div class="authincation h-100">
        <div class="container-fluid h-100" >
            <div class="row justify-content-center h-100 align-items-center" >
                    <div class="authincation-content" style="z-index:99;position:relative;">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="form-validation">
                                    <div class="auth-form" >
                                    <h4 class="text-center mb-4">Set a new password</h4>
                                    <form class="form-valide">
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
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="button" class="btn btn-primary btn-block" id="btnConfirmPassword">Log In</button>
                                        </div>
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


    <script src="./system/vendor/global/global.min.js"></script>
    <script src="./system/js/quixnav-init.js"></script>
    <script src="./system/js/custom.min.js"></script>
    <script src="./system/vendor/jquery-validation/jquery.validate.min.js"></script>
	<script src="./system/jquery.js"></script>
    <script src="./system/js/plugins-init/jquery.validate-init.js"></script>
	

</body>

</html>