<?php

    // these queries are for the user to block his friends and notifications will be send to both parties
    include "connection.php";
    session_start();
    $user_id = $_SESSION["user_id"];
    $user_name = $_SESSION["user_name"];
    $friend_id = $_GET["friend_id"];
    $status = 3; //  block status     
    $sql = "SELECT * FROM `users` WHERE `id` = ?"; 
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s",$friend_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
        
    if(!empty($row)){
        $friend_name = $row["first_name"]." ". $row["last_name"];
    }

    $user_notification = "you blocked ". $friend_name ;
    $friend_notification = $user_name . " has blocked you";
    
    $sql1 = "UPDATE `connections` SET `status` = ? WHERE `user_id` = ? AND `friend_id` = ?"; 
    $stmt1 = $connection->prepare($sql1);
    $stmt1->bind_param("sss",$status, $user_id, $friend_id);
    $stmt1->execute();
   

    $sql2 = "DELETE FROM `connections` WHERE `user_id` = ? AND `friend_id` = ?;"; 
    $stmt2 = $connection->prepare($sql2);
    $stmt2->bind_param("ss", $friend_id, $user_id);
    $stmt2->execute();

    
    $sql3 = "INSERT INTO `notifications` (`user_id`, `text`) VALUES (?, ?)"; 
    $stmt3 = $connection->prepare($sql3);
    $stmt3->bind_param("ss",$user_id, $user_notification);
    $stmt3->execute();

    
    $sql4 = "INSERT INTO `notifications` (`user_id`, `text`) VALUES (?, ?)"; 
    $stmt4 = $connection->prepare($sql4);
    $stmt4->bind_param("ss",$friend_id, $friend_notification);
    $stmt4->execute();

    $arr = [];
    $arr ["msg"] = "blocked";

    $json_msg = json_encode ($arr);
    echo $json_msg;
    



?>