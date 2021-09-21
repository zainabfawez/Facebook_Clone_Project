<?php

    // these queries are for the user who logged to decline his friends requests 
    //and notifications will be send to both parties
    include "connection.php";
    session_start();
    $user_id = $_SESSION["user_id"];
    $user_name = $_SESSION["user_name"];  
    $add_id = $_GET["add_id"]; //the id of the user to be added (he will recieve a request)
    $status = 2; // pending status
 
    $sql = "SELECT * FROM `users` WHERE `id` = ?"; 
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $add_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
        
    if(!empty($row)){
        $add_name = $row["first_name"]." ". $row["last_name"];
    }

    $user_notification = "you sent ". $add_name . " a friend request." ;
    $add_notification = "you have a friend request from ". $user_name;

    $sql1 = "INSERT INTO `connections` (`user_id`,`friend_id`, `status`) VALUES (?, ?, ?)"; 
    $stmt1 = $connection->prepare($sql1);
    $stmt1->bind_param("sss",$user_id, $add_id, $status);
    $stmt1->execute();
    
    $sql3 = "INSERT INTO `notifications` (`user_id`, `text`) VALUES (?, ?)"; 
    $stmt3 = $connection->prepare($sql3);
    $stmt3->bind_param("ss",$user_id, $user_notification);
    $stmt3->execute();

    $sql4 = "INSERT INTO `notifications` (`user_id`, `text`) VALUES (?, ?)"; 
    $stmt4 = $connection->prepare($sql4);
    $stmt4->bind_param("ss",$add_id, $add_notification);
    $stmt4->execute();

    $arr = [];
    $arr ["msg"] = "request sent";

    $json_msg = json_encode ($arr);
    echo $json_msg;

?>