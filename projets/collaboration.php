<?php

   // include('../auth/config.php');
include_once("../auth/ConfigClass.php");
$pdo = ConfigClass::pdo();
include_once ('CollaborationClass.php');

try {
    $message = array();

    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['nom'], $_POST['projet'])) {
        $nom = htmlspecialchars(trim($_POST['nom']));
        $idProjet= intval($_POST['projet']);
        $date = date('Y-m-d'). ' ' . date('H:i:s');

        $colla = $pdo->prepare("SELECT idUser FROM Users WHERE username =?");
        $colla->execute(array($nom));
        $idUser = $colla->fetchColumn();
        if(!$idUser){
            $message[] ="Ce nom d'utilisateur n'existe pas dans notre base.";
            exit();
        }

//
//        $sql = $pdo->prepare("INSERT INTO Collaboration(dateCollaboration, idProjet, idUser) VALUES (:dC,:iP, :iu)");
//        $sql->execute(array(
//            'dC'=>$date,
//            'iP'=>$idProjet,
//            'iu'=>$idUser,
//        ));
        $collaboration = new  CollaborationClass($date, $idProjet, $idUser);
        $collaboration->nouveauCollaboration();



        if($collaboration){
            $messageSucces = " Collaboration avec " . $nom . " a été éffectué avec Succès";
            header('Location:../Dashboard/dash.php');
            exit();

        }
        else{
            $message[] = "Une erreur: Ajout du collaboration a échoué ";
        }
    }

}catch (Exception $e){
    echo("Erreur".$e->getMessage());
}


?>