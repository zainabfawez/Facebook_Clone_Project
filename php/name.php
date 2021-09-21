<?php

    // this fill is only to get the full  user_name of the logged user from login.php to display it in all the home pages
    
    include "connection.php";
    session_start();
  
    $user_name = $_SESSION["user_name"];
    $user_name_json = json_encode($user_name);
    echo $user_name_json;
 
    
?>