<?php
     // this file is to get all the blocked friends of the logged user from database
    include "connection.php";
    session_start();
    $user_id = $_SESSION["user_id"];
    $status = 3;


    $sql1 = "SELECT u.* FROM `users` as u, `connections` as c WHERE c.`user_id` = ? and c.`status` = ? and u.`id`=c.`friend_id` "; 
    $stmt1 = $connection->prepare($sql1);
    $stmt1->bind_param("ss",$user_id, $status);
    $stmt1->execute();
    $result = $stmt1->get_result();

    $blocked_array = [];
    while($row = $result->fetch_assoc()){
        $blocked_array[] = $row;
       
    }
    
    $blocked_json = json_encode($blocked_array);
    echo $blocked_json;

?>
