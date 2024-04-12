<?php 
    $server = "localhost";
    $user = "root";
    $password = "";
    $dbName = "todophp";

    try {

        $baglanti=new PDO("mysql:host=".$server.";dbname=".$dbName.";charset=utf8",$user,$password);
        echo "veritabanına bağlandı";

    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }

?>