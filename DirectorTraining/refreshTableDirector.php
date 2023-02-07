<?php

    session_start();
    include("./system/dbconn.php");

    $sql_director = "SELECT * FROM director";
    $query_director = mysqli_query($dbconn,$sql_director);
    $count_director = mysqli_num_rows($query_director);

    $sql_organiser = "SELECT * FROM organiser";
    $query_organiser = mysqli_query($dbconn,$sql_organiser);
    $count_organiser = mysqli_num_rows($query_organiser);

    $i = 1;

?>
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

<script>
    $('.updateDirector').click(function(e) {
        e.preventDefault();
        var idDirector = $(this).attr("id");
        var status = "updateDirector";

        $.ajax({  
            url:"./system/process.php",  
            method:"POST",  
            dataType: "json",
            data:{status:status,idDirector:idDirector},  
            success:function(data){ 
                $("#modalUpdate").modal('show');
                $('#updateDirector').html(data);
            }  
       });
    });
</script>