<?php

    session_start();
    include("./system/dbconn.php");

    $sql_director = "SELECT * FROM director";
    $query_director = mysqli_query($dbconn,$sql_director);
    $count_director = mysqli_num_rows($query_director);

    $i = 1;
 ?>

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
            $query_training02 = mysqli_query($dbconn,$sql_training02);
            $Count_training02 = mysqli_num_rows($query_training02);
        ?>
        <tr>
            <td width="10%" ><?php echo $i ?>.</td>
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