<?php

    // these queries are for the user to unBlock his blocked friends and notifications will be send to both parties
    include "connection.php";
    session_start();
    $user_id = $_SESSION["user_id"];
    $user_name = $_SESSION["user_name"];
    $blocked_id = $_GET["blocked_id"];
    $status = 1; //friend status
 
    $sql = "SELECT * FROM `users` WHERE `id` = ?"; 
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $blocked_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
        
    if(!empty($row)){
        $blocked_name = $row["first_name"]." ". $row["last_name"];
    }

    $user_notification = "you unBlocked ". $blocked_name ;
    $blocked_notification = $user_name . " has unBlocked you";
    
    $sql1 = "UPDATE `connections` SET `status` = ? WHERE `user_id` = ? AND `friend_id` = ?"; 
    $stmt1 = $connection->prepare($sql1);
    $stmt1->bind_param("sss",$status, $user_id, $blocked_id);
    $stmt1->execute();
   
    $sql2 = "INSERT INTO `connections` (`user_id`, `friend_id`, `status`) VALUES (?, ?, ?)"; 
    $stmt2 = $connection->prepare($sql2);
    $stmt2->bind_param("sss",$blocked_id, $user_id, $status);
    $stmt2->execute();
    
    $sql3 = "INSERT INTO `notifications` (`user_id`, `text`) VALUES (?, ?)"; 
    $stmt3 = $connection->prepare($sql3);
    $stmt3->bind_param("ss",$user_id, $user_notification);
    $stmt3->execute();

    $sql4 = "INSERT INTO `notifications` (`user_id`, `text`) VALUES (?, ?)"; 
    $stmt4 = $connection->prepare($sql4);
    $stmt4->bind_param("ss",$blocked_id, $blocked_notification);
    $stmt4->execute();

    $arr = [];
    $arr ["msg"] = "unBlocked";

    $json_msg = json_encode ($arr);
    echo $json_msg;

?>