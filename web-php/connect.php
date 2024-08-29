<?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    try {      
        $conn = new PDO("mysql:host=$servername;dbname=reqis_db;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "เชื่อมต่อสำเร็จ";
    } catch(PDOException $e) {
        echo "การเชื่อมต่อล้มเหลว: " . $e->getMessage();
    }
?>
