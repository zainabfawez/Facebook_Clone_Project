<?php

    // this file is for the user who logged to remove  a specific notification 
    include "connection.php";
    session_start();
    $user_id = $_SESSION["user_id"];
    $notification_id = $_GET["notification_id"];
  
    
    $sql1 = "DELETE FROM `notifications` WHERE `id` = ?;"; 
    $stmt1 = $connection->prepare($sql1);
    $stmt1->bind_param("s", $notification_id);
    $stmt1->execute();
   

    $arr = [];
    $arr ["msg"] = "notification removed";

    $json_msg = json_encode ($arr);
    echo $json_msg;
    


?>