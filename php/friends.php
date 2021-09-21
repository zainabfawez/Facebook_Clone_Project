<?php

     //this file is to get all friends of the logged user and display it in the friends.html page
    include "connection.php";
    session_start();
    $user_id = $_SESSION["user_id"];
    $status = 1;


    $sql1 = "SELECT u.* FROM `users` as u,`connections` as c WHERE c.`user_id` = ? and c.`status` = ? and u.`id`=c.`friend_id` "; 
    $stmt1 = $connection->prepare($sql1);
    $stmt1->bind_param("ss",$user_id, $status);
    $stmt1->execute();
    $result = $stmt1->get_result();

    $friends_array = [];
    while($row = $result->fetch_assoc()){
        $friends_array[] = $row;
       
    }
    
    $friends_json = json_encode($friends_array);
    echo $friends_json;

?>
