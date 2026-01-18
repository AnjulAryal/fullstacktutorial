<?php
    $server = "localhost";
    $database="workshop8";
    $username="root";
    $password="";

    try{
    $pdo = new PDO("mysql:host=$server;dbname=$database",$username,$password);
    echo "Successfully connected to database";
  }catch(PDOException $e){
      echo("Unable to connect");
  }
?>