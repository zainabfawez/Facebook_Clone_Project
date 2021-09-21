<?php

    // this file is for the friend to remove/ unffriend his friends nad notification will be send for both parties
    include "connection.php";
    session_start();
    $user_id = $_SESSION["user_id"];
    $user_name = $_SESSION["user_name"];
    $friend_id = $_GET["friend_id"];
    $status = 1; // frined status
    
    $sql = "SELECT * FROM `users` WHERE `id` = ?"; 
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s",$friend_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
        
    if(!empty($row)){
        $friend_name = $row["first_name"]." ". $row["last_name"];
    }

    $user_notification = "you removed ". $friend_name . " from your friends list";
    $friend_notification = $user_name . " has removed you from his/her friend list";
    
    $sql1 = "DELETE FROM `connections` WHERE (user_id = ? AND friend_id = ?) AND status = ?;"; 
    $stmt1 = $connection->prepare($sql1);
    $stmt1->bind_param("sss",$user_id, $friend_id, $status);
    $stmt1->execute();
   

    $sql2 = "DELETE FROM `connections` WHERE (user_id = ? AND friend_id = ?) AND status = ?;"; 
    $stmt2 = $connection->prepare($sql2);
    $stmt2->bind_param("sss",$friend_id, $user_id, $status);
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
    $arr ["msg"] = "removed";

    $json_msg = json_encode ($arr);
    echo $json_msg;
    


?>