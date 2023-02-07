<?php
 
    session_start();
    session_destroy();
    unset($_SESSION['unlock_key']);
    header("Location:./");
 
?>