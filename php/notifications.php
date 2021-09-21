<?php

     //this file is to get all notifications of the logged user and display it in the notifications.html page
    include "connection.php";
    session_start();
    $user_id = $_SESSION["user_id"];



    $sql1 = "SELECT * FROM `notifications` WHERE `user_id` = ?  ORDER BY `id` DESC "; 
    $stmt1 = $connection->prepare($sql1);
    $stmt1->bind_param("s",$user_id);
    $stmt1->execute();
    $result = $stmt1->get_result();

    $notifications_array = [];
    while($row = $result->fetch_assoc()){
        $notifications_array[] = $row;
       
    }
    
    $notifications_json = json_encode($notifications_array);
    echo $notifications_json;

?>
