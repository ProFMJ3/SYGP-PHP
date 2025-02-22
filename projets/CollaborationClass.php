<?php
include_once("../auth/ConfigClass.php");



class CollaborationClass
{
    protected $dateCollaboration;
    protected $idUser;
    protected $idProjet;


    function  __construct($dateCollaboration, $idProjet, $idUser)
    {
        $this->dateCollaboration=$dateCollaboration;
        $this->idProjet=$idProjet;
        $this->idUser=$idUser;



    }
    function nouveauCollaboration()
    {
        $pdo = ConfigClass::pdo();
        try {

            $sql = $pdo->prepare("INSERT INTO Collaboration(dateCollaboration, idProjet, idUser) VALUES (:dC,:iP, :iu)");
            $sql->execute(array(
                'dC'=>$this->dateCollaboration,
                'iP'=>$this->idProjet,
                'iu'=>$this->idUser,
            ));
        }catch (Exception $e){
            echo ("Une erreur ".$e->getMessage());
        }

    }

}