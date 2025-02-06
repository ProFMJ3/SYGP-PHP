<?php

class ConfigClass
{
    public static function pdo()

    {
        $host = 'localhost';
        $db = 'sygp';
        $user = 'root';
        $pass = 'Jules1012#';
        $charset = 'utf8';


        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);

            return $pdo;

        } catch (Exception $e) {
            echo("Une erreur s'est produite".$e->getMessage());
        }


    }

}