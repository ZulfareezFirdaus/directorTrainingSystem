<?php

    session_start();
    include("./system/dbconn.php");

    $sql_director = "SELECT * FROM director";
    $query_director = mysqli_query($dbconn,$sql_director);
    $count_director = mysqli_num_rows($query_director);

    $sql_organiser = "SELECT * FROM organiser";
    $query_organiser = mysqli_query($dbconn,$sql_organiser);
    $count_organiser = mysqli_num_rows($query_organiser);

    $sql_training = "SELECT director.*, organiser.*, TrainingProgram.* FROM TrainingProgram
    INNER JOIN director ON director.ID_director = TrainingProgram.ID_director
    INNER JOIN organiser ON organiser.ID_organiser = TrainingProgram.ID_organiser ";
    $query_training = mysqli_query($dbconn,$sql_training);
    $Count_training = mysqli_num_rows($query_training);

?> 
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
    <div class="col-lg-12">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="ti-ruler-pencil text-warning border-warning"></i>
                </div><br>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">Total Training</div>
                    <div class="stat-digit"><?php echo $Count_training ?></div>
                </div>
            </div>
        </div>
    </div>
</center>