<?php

    // these queries are for the user who logged to accept his friends requests
    // and notifications will be send to both parties
    include "connection.php";
    session_start();
    $user_id = $_SESSION["user_id"];
    $user_name = $_SESSION["user_name"];
    $request_id = $_GET["request_id"];
    $status = 1; //friend status
 
    $sql = "SELECT * FROM `users` WHERE `id` = ?"; 
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $request_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
        
    if(!empty($row)){
        $request_name = $row["first_name"]." ". $row["last_name"];
    }

    $user_notification = "you accepted ". $request_name . " friend request." ;
    $request_notification = $user_name . " has accepted your friend request.";
    
    $sql1 = "UPDATE `connections` SET `status` = ? WHERE `user_id` = ? AND `friend_id` = ?"; 
    $stmt1 = $connection->prepare($sql1);
    $stmt1->bind_param("sss",$status, $user_id, $request_id);
    $stmt1->execute();
   
    $sql2 = "INSERT INTO `connections` (`user_id`,`friend_id`, `status`) VALUES (?, ?, ?)"; 
    $stmt2 = $connection->prepare($sql2);
    $stmt2->bind_param("sss", $request_id, $user_id, $status);
    $stmt2->execute();
    
    $sql3 = "INSERT INTO `notifications` (`user_id`, `text`) VALUES (?, ?)"; 
    $stmt3 = $connection->prepare($sql3);
    $stmt3->bind_param("ss",$user_id, $user_notification);
    $stmt3->execute();

    $sql4 = "INSERT INTO `notifications` (`user_id`, `text`) VALUES (?, ?)"; 
    $stmt4 = $connection->prepare($sql4);
    $stmt4->bind_param("ss",$request_id, $request_notification);
    $stmt4->execute();

    $arr = [];
    $arr ["msg"] = "accepted";

    $json_msg = json_encode ($arr);
    echo $json_msg;

?>