
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>PNB - Secetary Dept </title>
    <link rel="icon" type="image/png" sizes="5x5" href="./system/images/logo.png">
    <link href="./system/css/style.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>  

</head>

<body class="h-100">
    <div id="overlay"></div>
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-lg-4 col-md-5 col-sm-8 col-12 ">
                    <div class="authincation-content" style="z-index:99;position:relative;">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    <form class="form-valide">
                                        <div class="form-group row">
                                            <label class="col-lg-12 col-form-label" for="val-email">Email
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-12">
                                                <input type="email" class="form-control" id="val-email" name="val-email" placeholder="Enter the email..">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-12 col-form-label" for="val-password">Password
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-12">
                                                <input type="password" class="form-control" id="val-password" name="val-password" placeholder="Enter the password..">
                                            </div>
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                                
                                            </div>
                                            <div class="form-group">
                                                <a href="page-forgot-password.html">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="button" class="btn btn-primary btn-block" id="btnLogin">Log In</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Don't have an account? <font class="text-primary" >Contact Admin</font></p>
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