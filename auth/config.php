<?php

    $host = 'localhost';
    $db = 'sygp';
    $user = 'root';
    $pass = 'Jules1012#';
    $charset = 'utf8';
//    ini_set('display_errors', 1);
//    ini_set('display_startup_errors', 1);
//    error_reporting(E_ALL);



    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
        echo 'Yes, Connection is successful !!';
    } catch (Exception $e) {
       echo("Une erreur s'est produite");
    }
?>

