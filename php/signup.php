<?php

include "connection.php";


if(isset($_POST["first_name"]) && $_POST["first_name"] != "" ) {
    $first_name = $_POST["first_name"];
}else{
    die ("Enter your first name");
}

if(isset($_POST["last_name"]) && $_POST["last_name"] != "" ) {
    $last_name = $_POST["last_name"];
}else{
    die ("Enter your last name");
}

if(isset($_POST["email"]) && $_POST["email"] != "" ) {
    $email = $_POST["email"];
}else{
    die ("Enter a valid email");
}

if(isset($_POST["password"]) && $_POST["password"] != "" ) {
    $password = $_POST["password"];
}else{
    die ("Enter a password");
}
if(isset($_POST["confirmPassword"]) && $_POST["confirmPassword"] != "" && $_POST["confirmPassword"]==$_POST["password"]  ) {
     $confirmPassword = $_POST["confirmPassword"];
 }else{
     die ("Passwords Mismatch");
}

//checking if the email is already in the database:
   

    $sql1="SELECT `email` from `users` where `email`=? "; 
    $stmt1 = $connection->prepare($sql1);
    $stmt1->bind_param("s",$email);
    $stmt1->execute();
    $result = $stmt1->get_result();
    $row = $result->fetch_assoc();

    if(empty($row)) {
        $sql2 = "INSERT INTO `users` (`email`,`password`,`first_name`, `last_name`) VALUES ( ?, ?, ?, ?);";
        $hash = hash('sha256', $password);
        $stmt2 = $connection->prepare($sql2);
        $stmt2->bind_param("ssss",$email,$hash,$first_name,$last_name);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        header("Location:../login1.html");
    }else{
        header("location: ../signup.html");
    }
    


         
    
    
    
    
?>

   