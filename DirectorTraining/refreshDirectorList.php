<?php

    session_start();
    include("./system/dbconn.php");

    $sql_director = "SELECT * FROM director";
    $query_director = mysqli_query($dbconn,$sql_director);
    $count_director = mysqli_num_rows($query_director);

 ?>


    <option value="" >Select director name </option>
    <?php foreach($query_director as $data_01) { ?>
        <option value="<?php echo $data_01['Name_director']; ?>" ><?php echo ucwords($data_01['Name_director']); ?></option>
    <?php } ?>
    <option value="InputText" >Other </option>
