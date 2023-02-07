<?php

    session_start();
    include("./system/dbconn.php");

    $sql_organiser = "SELECT * FROM organiser";
    $query_organiser = mysqli_query($dbconn,$sql_organiser);
    $count_organiser = mysqli_num_rows($query_organiser);

?> 
    <option value="" >Select organiser/speaker </option>
    <?php foreach($query_organiser as $data_03) { ?>
        <option value="<?php echo $data_03['Name_organiser']; ?>" ><?php echo ucwords($data_03['Name_organiser']); ?></option>
    <?php } ?>
    <option value="InputText" >Other </option>