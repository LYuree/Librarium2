<?php

require("sensitive_info.php");


$dsn = "mysql:host=localhost;port=3306;dbname=librarium;charset=utf8";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try{
    $pdo = new PDO($dsn, "$db_server_username", "$db_server_password", $options);
}catch (PDOException $e) {
    $pdo = null;
    echo 'Подключение не удалось: ' . $e->getMessage(); 
    exit;
}
?>

