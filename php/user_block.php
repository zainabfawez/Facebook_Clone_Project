<?php

    // these queries are for the user who logged to decline his friends requests 
    //and notifications will be send to both parties
    include "connection.php";
    session_start();
    $user_id = $_SESSION["user_id"];
    $user_name = $_SESSION["user_name"];  
    $block_id = $_GET["block_id"]; //the id of the user(not a friend) to be blocked
    $status = 3; // blocking status
 
    $sql = "SELECT * FROM `users` WHERE `id` = ?"; 
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $block_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
        
    if(!empty($row)){
        $block_name = $row["first_name"]." ". $row["last_name"];
    }

    $user_notification = "you blocked ". $block_name  ;
  
    $sql1 = "INSERT INTO `connections` (`user_id`,`friend_id`, `status`) VALUES (?, ?, ?)"; 
    $stmt1 = $connection->prepare($sql1);
    $stmt1->bind_param("sss",$user_id, $block_id, $status);
    $stmt1->execute();
   
    $sql2 = "INSERT INTO `connections` (`user_id`,`friend_id`, `status`) VALUES (?, ?, ?)"; 
    $stmt2 = $connection->prepare($sql2);
    $stmt2->bind_param("sss", $block_id, $user_id, $status);
    $stmt2->execute();
    
    $sql3 = "INSERT INTO `notifications` (`user_id`, `text`) VALUES (?, ?)"; 
    $stmt3 = $connection->prepare($sql3);
    $stmt3->bind_param("ss",$user_id, $user_notification);
    $stmt3->execute();

    $arr = [];
    $arr ["msg"] = "user blocked";

    $json_msg = json_encode ($arr);
    echo $json_msg;

?>