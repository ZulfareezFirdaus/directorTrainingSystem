<?php

session_start();
include("./dbconn.php");

mysqli_select_db($dbconn_directorTraining, 'directorTraining');

if($_POST["status"] == "trainingProgram")
{
    $dateProgramStart = mysqli_real_escape_string($dbconn_directorTraining,$_POST['dateProgramStart']);
    $dateProgramEnd = mysqli_real_escape_string($dbconn_directorTraining,$_POST['dateProgramEnd']);
    $nameProgram = mysqli_real_escape_string($dbconn_directorTraining,$_POST['nameProgram']);
	$nameOrganiser = mysqli_real_escape_string($dbconn_directorTraining,$_POST['nameOrganiser']);
    $nameDirector = mysqli_real_escape_string($dbconn_directorTraining,$_POST['nameDirector']);
    $popNameOrganiser = mysqli_real_escape_string($dbconn_directorTraining,$_POST['popNameOrganiser']);
    $popNameDirector = mysqli_real_escape_string($dbconn_directorTraining,$_POST['popNameDirector']);
    
    //kalau organiser baru tapi director lama
    if($popNameOrganiser != "" && $popNameDirector == ""){
        
        $sql_select = "SELECT * FROM director WHERE Name_director LIKE '%".$nameDirector."%' ";
        $query_select = mysqli_query($dbconn_directorTraining, $sql_select);
        $data_select = mysqli_fetch_assoc($query_select);
        
        $sql_01 = "INSERT INTO organiser (Name_organiser) values ('".ucfirst($nameOrganiser)."')";
        $query_01 = mysqli_query($dbconn_directorTraining, $sql_01);
        $last_organiserID = mysqli_insert_id($dbconn_directorTraining);
        
        if($query_01){
            $sql_02 = "INSERT INTO TrainingProgram (Name_trainingProgram,StartDate_trainingProgram,EndDate_trainingProgram,timestamp,ID_director,ID_organiser) 
            values ('".ucfirst($nameProgram)."','".$dateProgramStart."','".$dateProgramEnd."',NOW() ,'".$data_select['ID_director']."','".$last_organiserID."' )";
            $query_02 = mysqli_query($dbconn_directorTraining, $sql_02);
            
            if($query_02){
                $output = "Success";
                $_SESSION['ID_directorReserve'] = $data_select['ID_director'];
            }
            else{
                $output = "Failed";
            }
        }
    }
    
    //kalau director baru tapi organiser lama
    if($popNameDirector != "" && $popNameOrganiser == ""){
        
        $sql_select = "SELECT * FROM organiser WHERE Name_organiser LIKE '%".$nameOrganiser."%' ";
        $query_select = mysqli_query($dbconn_directorTraining, $sql_select);
        $data_select = mysqli_fetch_assoc($query_select);
        
        $sql = "INSERT INTO director (Name_director) values ('".ucfirst($nameDirector)."')";
        $query = mysqli_query($dbconn_directorTraining, $sql);
        $last_directorID = mysqli_insert_id($dbconn_directorTraining);
        
        $sql_02 = "INSERT INTO TrainingProgram (Name_trainingProgram,StartDate_trainingProgram,EndDate_trainingProgram,timestamp,ID_director,ID_organiser) 
        values ('".ucfirst($nameProgram)."','".$dateProgramStart."','".$dateProgramEnd."',NOW() ,'".$last_directorID."','".$data_select['ID_organiser']."' )";
        $query_02 = mysqli_query($dbconn_directorTraining, $sql_02);

        if($query_02){
            $output = "Success";
            $_SESSION['ID_directorReserve'] = $data_select['ID_director'];
        }
        else{
            $output = "Failed";
        }
    }
    
    //kalau director & organiser lama
    if($popNameOrganiser == "" && $popNameDirector == ""){
        
        $sql_selectDirector = "SELECT * FROM director WHERE Name_director LIKE '%".$nameDirector."%' ";
        $query_selectDirector = mysqli_query($dbconn_directorTraining, $sql_selectDirector);
        $data_selectDirector = mysqli_fetch_assoc($query_selectDirector);
        
        $sql_selectOrganiser = "SELECT * FROM organiser WHERE Name_organiser LIKE '%".$nameOrganiser."%' ";
        $query_selectOrganiser = mysqli_query($dbconn_directorTraining, $sql_selectOrganiser);
        $data_selectOrganiser = mysqli_fetch_assoc($query_selectOrganiser);
        
        $sql_02 = "INSERT INTO TrainingProgram (Name_trainingProgram,StartDate_trainingProgram,EndDate_trainingProgram,timestamp,ID_director,ID_organiser) 
        values ('".ucfirst($nameProgram)."','".$dateProgramStart."','".$dateProgramEnd."',NOW() ,'".$data_selectDirector['ID_director']."','".$data_selectOrganiser['ID_organiser']."' )";
        $query_02 = mysqli_query($dbconn_directorTraining, $sql_02);

        if($query_02){
            $output = "Success";
            $_SESSION['ID_directorReserve'] = $data_selectDirector['ID_director'];
        }
        else{
            $output = "Failed";
        }
    }
    
    //kalau director & organiser baru
    if($popNameOrganiser != "" && $popNameDirector != ""){
         $sql = "INSERT INTO director (Name_director) values ('".$nameDirector."')";
         $query = mysqli_query($dbconn_directorTraining, $sql);
         $last_directorID = mysqli_insert_id($dbconn_directorTraining);

         if($query){
            $sql_01 = "INSERT INTO organiser (Name_organiser) values ('".$nameOrganiser."')";
            $query_01 = mysqli_query($dbconn_directorTraining, $sql_01);
            $last_organiserID = mysqli_insert_id($dbconn_directorTraining);

            if($query_01){
                $sql_02 = "INSERT INTO TrainingProgram (Name_trainingProgram,StartDate_trainingProgram,EndDate_trainingProgram,timestamp,ID_director,ID_organiser) 
                values ('".ucfirst($nameProgram)."','".$dateProgramStart."','".$dateProgramEnd."',NOW() ,'".$last_directorID."','".$last_organiserID."' )";
                $query_02 = mysqli_query($dbconn_directorTraining, $sql_02);

                if($query_02){
                    $output = "Success";
                    $_SESSION['ID_directorReserve'] = $last_directorID;
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
             $output = "Failed";
         }
     }
}

if($_POST["status"] == "addDirector")
{
    $nameDirector = mysqli_real_escape_string($dbconn_directorTraining,$_POST['nameDirector']);
    
    $sql = "INSERT INTO director (Name_director) values ('".$nameDirector."')";
    $query = mysqli_query($dbconn_directorTraining, $sql);
    
    if($query){
        $output = "Success";
    }
    else{
        $output = "Failed";
    }
}

if($_POST["status"] == "updateDataDirector")
{
    $nameDirector = mysqli_real_escape_string($dbconn_directorTraining,$_POST['nameDirector']);
    $idDirector = mysqli_real_escape_string($dbconn_directorTraining,$_POST['idDirector']);
    
    $sql = " UPDATE director SET Name_director = '".$nameDirector."' WHERE ID_director = '".$idDirector."' ";
    $query = mysqli_query($dbconn_directorTraining, $sql);
    
    if($query){
        $output = "Success";
    }
    else{
        $output = "Failed";
    }
}

if($_POST["status"] == "updateDirector")
{
    $idDirector = mysqli_real_escape_string($dbconn_directorTraining,$_POST['idDirector']);
    
    $sql_Director = "SELECT * FROM director WHERE ID_director = '".$idDirector."' ";
    $query_Director = mysqli_query($dbconn_directorTraining, $sql_Director);
    $data_Director = mysqli_fetch_assoc($query_Director);
    
    $output = '
    <div class="card-body">
        <div class="basic-form">
            <div class="form-group row">
                <label class="col-lg-12 col-form-label">Director Name</label>
                <div class="col-lg-12">
                    <input type="hidden" id="ID_director" value="'.$data_Director['ID_director'].'" >
                    <input type="text" class="form-control" id="Name_director" placeholder="Enter the director name" value="'.$data_Director['Name_director'].'" >
                </div>
            </div>
        </div>
    </div>';
    
}

if($_POST["status"] == "updateTraining")
{
    $idTrainingProgram = mysqli_real_escape_string($dbconn_directorTraining,$_POST['idTrainingProgram']);
    
    $sql_TrainingProgram = "
    SELECT director.*, organiser.*, TrainingProgram.* FROM TrainingProgram
    INNER JOIN director ON director.ID_director = TrainingProgram.ID_director
    INNER JOIN organiser ON organiser.ID_organiser = TrainingProgram.ID_organiser
    WHERE TrainingProgram.ID_trainingProgram = '".$idTrainingProgram."' ";
    $query_TrainingProgram = mysqli_query($dbconn_directorTraining, $sql_TrainingProgram);
    $data_TrainingProgram = mysqli_fetch_assoc($query_TrainingProgram);
    
    $output = '
    <div class="card-body">
        <div class="basic-form">
            <div class="form-group row">
                <label class="col-lg-12 col-form-label">Director Name</label>
                <div class="col-lg-12">
                    <input type="text" class="form-control Name_director" id="Name_director" placeholder="Enter the director name" value="'.$data_TrainingProgram['Name_director'].'" >
                    <input type="hidden" class="form-control ID_trainingProgram" id="ID_trainingProgram"  value="'.$data_TrainingProgram['ID_trainingProgram'].'" >
                    <input type="hidden" class="form-control ID_director" id="ID_director"  value="'.$data_TrainingProgram['ID_director'].'" >
                    <input type="hidden" class="form-control ID_organiser" id="ID_organiser"  value="'.$data_TrainingProgram['ID_organiser'].'" >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-12 col-form-label">Training/Program Attended</label>
                <div class="col-lg-12">
                    <textarea class="form-control textAreaName_trainingProgram" name="textAreaName_trainingProgram" id="textAreaName_trainingProgram" placeholder="Enter the training/program title" style="white-space: pre-wrap;" rows="5" value="'.$data_TrainingProgram['Name_trainingProgram'].'" >'.$data_TrainingProgram['Name_trainingProgram'].'</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-12 col-form-label">Organiser/Speaker</label>
                <div class="col-lg-12">
                    <input type="text" class="form-control Name_organiser" id="Name_organiser" value="'.$data_TrainingProgram['Name_organiser'].'" placeholder="Enter the organiser/speaker">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6" style="padding-left:0">
                    <label class="col-lg-12 col-form-label">Start Date of Training/Program</label>
                    <div class="col-lg-12">
                        <input class="form-control InputStartDate_trainingProgram" type="date" id="InputStartDate_trainingProgram" value="'.$data_TrainingProgram['StartDate_trainingProgram'].'" placeholder="Choose the start training/program date"  >
                    </div>
                </div>
                <div class="col-lg-6" style="padding-right:0">
                    <label class="col-lg-12 col-form-label">End Date of Training/Program</label>
                    <div class="col-lg-12">
                        <input class="form-control InputEndDate_trainingProgram" type="date" id="InputEndDate_trainingProgram"  value="'.$data_TrainingProgram['EndDate_trainingProgram'].'" placeholder="Choose the end training/program date"   >
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';
    
}

if($_POST["status"] == "updateDataTraining")
{
    $dateProgramStart = mysqli_real_escape_string($dbconn_directorTraining,$_POST['dateProgramStart']);
    $dateProgramEnd = mysqli_real_escape_string($dbconn_directorTraining,$_POST['dateProgramEnd']);
    $nameProgram = mysqli_real_escape_string($dbconn_directorTraining,$_POST['nameProgram']);
	$nameOrganiser = mysqli_real_escape_string($dbconn_directorTraining,$_POST['nameOrganiser']);
    $nameDirector = mysqli_real_escape_string($dbconn_directorTraining,$_POST['nameDirector']);
    $idDirector = mysqli_real_escape_string($dbconn_directorTraining,$_POST['idDirector']);
    $idOrganiser = mysqli_real_escape_string($dbconn_directorTraining,$_POST['idOrganiser']);
    $idTrainingProgram = mysqli_real_escape_string($dbconn_directorTraining,$_POST['idTrainingProgram']);
    
    $sql = " UPDATE director SET Name_director = '".$nameDirector."' WHERE ID_director = '".$idDirector."' ";
    $query = mysqli_query($dbconn_directorTraining, $sql);
    
    if($query){
        $sql1 = " UPDATE organiser SET Name_organiser = '".$nameOrganiser."' WHERE ID_organiser = '".$idOrganiser."' ";
        $query1 = mysqli_query($dbconn_directorTraining, $sql1);
        
        if($query1){
            $sql2 = " UPDATE TrainingProgram SET Name_trainingProgram = '".$nameProgram."' , StartDate_trainingProgram = '".$dateProgramStart."', EndDate_trainingProgram = '".$dateProgramEnd."' WHERE ID_trainingProgram = '".$idTrainingProgram."' ";
            $query2 = mysqli_query($dbconn_directorTraining, $sql2);
            
            if($query2){
                $_SESSION['ID_directorReserve'] = $idDirector;
                $output = "Success";
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
        $output = "Failed";
    }
}

if($_POST["status"] == "validateName_director")
{
    $nameDirector = mysqli_real_escape_string($dbconn_directorTraining,$_POST['nameDirector']);
    
    $sql_director = "SELECT * FROM director WHERE Name_director = '".$nameDirector."' ";
    $query_director = mysqli_query($dbconn_directorTraining,$sql_director);
    $data_director = mysqli_num_rows($query_director);
    
    if($data_director > 0){
        $output = "Success";
    }
    else{
        $output = "Failed";
    }
}

if($_POST["status"] == "validateName_organiser")
{
    $nameOrganiser = mysqli_real_escape_string($dbconn_directorTraining,$_POST['nameOrganiser']);
    
    $sql_organiser = "SELECT * FROM organiser WHERE Name_organiser = '".$nameOrganiser."' ";
    $query_organiser = mysqli_query($dbconn_directorTraining,$sql_organiser);
    $data_organiser = mysqli_num_rows($query_organiser);
    
    if($data_organiser > 0){
        $output = "Success";
    }
    else{
        $output = "Failed";
    }
}

if($_POST["status"] == "deleteTraining")
{
    $idTrainingProgram = mysqli_real_escape_string($dbconn_directorTraining,$_POST['idTrainingProgramDelete']);
    
    $sql = "DELETE FROM TrainingProgram WHERE ID_trainingProgram = '".$idTrainingProgram."' ";
    $query = mysqli_query($dbconn_directorTraining, $sql);
    
    if($query){
        $output = "Success";
    }
    else{
        $output = "Failed";
    }
}

    echo json_encode($output); 

?>
