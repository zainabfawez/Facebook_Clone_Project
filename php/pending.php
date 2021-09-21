<?php
 
    // this file is to get the sent friends requests of the logged user in the pending.html page
    include "connection.php";
    session_start();
    $user_id = $_SESSION["user_id"];
    $status = 2;


    $sql1 = "SELECT u.* FROM `users` as u,`connections` as c WHERE c.`user_id` = ? and c.`status` = ? and u.`id`= c.`friend_id` "; 
    $stmt1 = $connection->prepare($sql1);
    $stmt1->bind_param("ss",$user_id, $status);
    $stmt1->execute();
    $result = $stmt1->get_result();

    $requests_array = [];
    while($row = $result->fetch_assoc()){
        $requests_array[] = $row;
       
    }
    
    $requests_json = json_encode($requests_array);
    echo $requests_json;

?>