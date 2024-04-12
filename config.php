<?php 
    $server = "localhost";
    $user = "root";
    $password = "";
    $dbName = "todophp";

    try {

        $pdo=new PDO("mysql:host=".$server.";dbname=".$dbName.";charset=utf8",$user,$password);
        

    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }

?>