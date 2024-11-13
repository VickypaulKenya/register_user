<?php

$host="localhost";
$username="root";
$password="";
$db_name="chat_db";

try{
    $pdo=new PDO("mysql:host=$host;dbname=$db_name; 
    charset=utf8",$username,$password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  header("Location: ../index.php");
}
catch(PDOException $e){
   die("Not connected:".$e->getMessage());
}

