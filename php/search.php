<?php

    //this file is to get all the you users who aren't friend/blocked/pending on the logged user's list 
    //names given are according to the search input (first_name or last_name starts with the input chars)
    include "connection.php";
    session_start();
    $user_id = $_SESSION["user_id"];
    $search = $_POST["search"];
    $s = $search.'%';
    $status = 3;

    $sql1 ="SELECT * FROM `users` WHERE (`first_name` LIKE ? OR `last_name` LIKE ?) AND `id` <> ? AND `id` NOT IN (SELECT `friend_id` FROM `connections` WHERE `user_id`= ?) AND `id` NOT IN (SELECT `friend_id` from `connections` WHERE `user_id`= ? AND `status`=?)"; 
    $stmt1 = $connection->prepare($sql1);
    $stmt1->bind_param('ssssss', $s, $s, $user_id, $user_id, $user_id, $status);
    $stmt1->execute();
    $result = $stmt1->get_result();

    $users_array = [];
    while($row = $result->fetch_assoc()){
        $users_array[] = $row;
       
    }
    
    $users_json = json_encode($users_array);
    echo $users_json;

?>
