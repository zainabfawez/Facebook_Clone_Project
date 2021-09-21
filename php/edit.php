<?php

    include "connection.php";
    session_start();

    $user_id = $_SESSION["user_id"];
    $fname = $_POST["first_name"];
    $lname = $_POST["last_name"];
    $email = $_POST["email"];
    $pass = $_POST["password"];
   
    $sql = "UPDATE `users` SET `email`= ?, `password` = ?, `first_name` = ?, `last_name` = ? WHERE `id` = ?";
    $hash = hash('sha256', $pass);
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssss", $email, $hash, $fname, $lname, $user_id);
    $stmt->execute();

    $response = [];
    $response["response"] = "ok";

    $response_json = json_encode ($response);
    echo $response_json



?>