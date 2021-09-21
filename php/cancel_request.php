<?php

    // this file is for the friend to cancel his request and notification will be send for both parties
    include "connection.php";
    session_start();
    $user_id = $_SESSION["user_id"];
    $user_name = $_SESSION["user_name"];
    $cancel_id = $_GET["cancel_id"];
    echo $cancel_id;

    $sql = "SELECT * FROM `users` WHERE `id` = ?"; 
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s",$cancel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
        
    if(!empty($row)){
        $cancel_name = $row["first_name"]." ". $row["last_name"];
    }

    $user_notification = "you canceled ". $cancel_name . " friend request";
    $cancel_notification = $user_name . " canceled his friend request";
    
    $sql1 = "DELETE FROM `connections` WHERE `user_id` = ? AND `friend_id` = ?;"; 
    $stmt1 = $connection->prepare($sql1);
    $stmt1->bind_param("ss",$user_id, $cancel_id);
    $stmt1->execute();
       
    $sql3 = "INSERT INTO `notifications` (`user_id`, `text`) VALUES (?, ?)"; 
    $stmt3 = $connection->prepare($sql3);
    $stmt3->bind_param("ss",$user_id, $user_notification);
    $stmt3->execute();
    
    $sql4 = "INSERT INTO `notifications` (`user_id`, `text`) VALUES (?, ?)"; 
    $stmt4 = $connection->prepare($sql4);
    $stmt4->bind_param("ss",$cancel_id, $cancel_notification);
    $stmt4->execute();

    $arr = [];
    $arr ["msg"] = "canceled";

    $json_msg = json_encode ($arr);
    echo $json_msg;
    


?>