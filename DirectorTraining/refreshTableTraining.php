<?php

    session_start();
    include("./system/dbconn.php");

    $sql_organiser = "SELECT * FROM organiser";
    $query_organiser = mysqli_query($dbconn,$sql_organiser);
    $count_organiser = mysqli_num_rows($query_organiser);

    $sql_training = "SELECT director.*, organiser.*, TrainingProgram.* FROM TrainingProgram
    INNER JOIN director ON director.ID_director = TrainingProgram.ID_director
    INNER JOIN organiser ON organiser.ID_organiser = TrainingProgram.ID_organiser
    WHERE director.ID_director = '".$_SESSION['ID_directorReserve']."' ORDER BY TrainingProgram.StartDate_trainingProgram ASC ";
    $query_training = mysqli_query($dbconn,$sql_training);
    $data_training = mysqli_fetch_assoc($query_training);
    $Count_training = mysqli_num_rows($query_training);

    $sql_director = "SELECT * FROM director WHERE ID_director = '".$data_training['ID_director']."' ";
    $query_director = mysqli_query($dbconn,$sql_director);
    $count_director = mysqli_num_rows($query_director);
    $data_director = mysqli_fetch_assoc($query_director);

    $i = 1;

?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">LIST OF DIRECTOR'S TRAINING <?php echo date("Y"); ?> - <?php echo $data_director['Name_director'] ?></h4>
    </div><br>
    <div>
        <div class="row justify-content-md-center">
            <div class="col-lg-12">
                <center>
                    <?php if($Count_training > 0){ ?>
                        <button type="button" onclick="printDiv('printThisDiv')" class="btn btn-success" ><i class="ti-printer"></i> &nbsp;&nbsp;Print List</button>
                    <?php } ?>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" ><i class="ti-plus"></i>&nbsp;&nbsp; Add Training/Program</button>
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
                            <td width="40%"><?php echo nl2br($data['Name_trainingProgram']) ?></td>
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

<script>
$('.updateTraining').click(function(e) {
    e.preventDefault();
    var idTrainingProgram = $(this).attr("id");
    var status = "updateTraining";

    $.ajax({  
        url:"./system/process.php",  
        method:"POST",  
        dataType: "json",
        data:{status:status,idTrainingProgram:idTrainingProgram},  
        success:function(data){ 
            $("#modalUpdate").modal('show');
            $('#updateTraining').html(data);
        }  
   });
});
    
$('.deleteTraining').click(function(e) {
    e.preventDefault();
    var idTrainingProgramDelete = $(this).attr("id");

    var status = "deleteTraining";

    if (confirm('Are you sure want to permanently delete this ? ' )) {
        $.ajax({  
            url:"./system/process.php",  
            method:"POST",  
            dataType: "json",
            data:{status:status,idTrainingProgramDelete:idTrainingProgramDelete},  
            success:function(data){ 
                if ($.trim(data) === "Success") {
                    $("#tableTrainingList").load("refreshTableTraining.php");
                    Swal.fire(
                      'Success',
                      '1 Row Deleted Successfully!',
                      'success'
                    );
                }
                else if ($.trim(data) === "Failed") {
                    Swal.fire(
                      'Error',
                      'Please try again later!',
                      'error'
                    );
                }
            }  
       });
    }
});
</script>