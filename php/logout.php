<?php

    include "connection.php";

    session_start();
    session_unset();
    session_destroy();
   
    header('location: ../login1.html');
    exit();

?>