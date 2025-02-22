<?php

include_once ("../auth/ConfigClass.php");
class AssignationClass
{
    protected $dateAssignation;
    protected $idTache;
    protected $idCollaborateur;


    function  __construct($dateAssignation, $idTache, $idCollaborateur)
    {
        $this->dateAssignation=$dateAssignation;
        $this->idTache=$idTache;
        $this->idCollaborateur=$idCollaborateur;



    }
    function nouveauAssignation()
    {
        $pdo = ConfigClass::pdo();
        try {

            $sql = $pdo->prepare("INSERT INTO Assignation(dateAssignation, idTache, idUser) VALUES (:date,:idTache, :idColla)");
            $sql->execute(array(
                'date'=>$this->dateAssignation,
                'idTache'=>$this->idTache,
                'idColla'=>$this->idCollaborateur,
            ));
        }catch (Exception $e){
            echo ("Une erreur ".$e->getMessage());
        }

    }
}