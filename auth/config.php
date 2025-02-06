<?php

    $host = 'localhost';
    $db = 'sygp';
    $user = 'root';
    $pass = 'Jules1012#';
    $charset = 'utf8';


    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
        //echo 'Yes, Connection is successful !!';
    } catch (Exception $e) {
       echo("Une erreur s'est produite");
    }
?>

