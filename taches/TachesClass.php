<?php

include_once("../auth/ConfigClass.php");


class TachesClass
{
    protected $idTache;
    protected $nomTache;
    protected $description;
    protected $dateCreation;
    protected $dateEcheance;
    protected $priorite;
    protected $statut;
    protected $progession;
    protected $cheminficier;

    protected $idProjet;

    protected $idUser;
    protected $dateModification;


    // Getters
    public function getNomTache() {
        return $this->nomTache;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getDateEcheance() {
        return $this->dateEcheance;
    }




    // Setters
    public function setNomTache($newNomTache) {
        $this->nomProjet = $newNomTache;
    }

    public function setDescription($newDescription)
    {
        $this->description = $newDescription;
    }

    public function setDateEchance($newDateEcheance)
    {
        $this->dateEcheance = $newDateEcheance;
    }



    public function __construct($idTache, $nomTache, $description, $dateEcheance, $priorite, $statut, $progession, $cheminficier, $idProjet, $idUser, $dateModification)
    {

        $this->idTache = $idTache;
        $this->nomTache = $nomTache;
        $this->description = $description;
        $this->dateEcheance = $dateEcheance;
        $this->priorite = $priorite;
        $this->statut = $statut;
        $this->progession = $progession;
        $this->cheminficier = $cheminficier;
        $this->idProjet = $idProjet;
        $this->idUser = $idUser;
        $this->dateModification = $dateModification;


    }

    public function nouveauTache()
    {
        try {
            $pdo = ConfigClass::pdo();


            $sql1 = $pdo->prepare("INSERT INTO Taches(nomTache, descriptions, dateEcheance, priorite, fichier, idProjet, idUser)VALUES (:nomTache, :descriptions,:dateEcheance, :priorite,:fichier, :idProjet, :idUser)");
            $result = $sql1->execute(array(
                'nomTache'=>$this->nomTache,
                'descriptions'=>$this->description,
                'dateEcheance'=>$this->dateEcheance,
                'priorite'=> $this->priorite,
                'fichier'=>$this->cheminficier,
                'idProjet'=>$this->idProjet,
                'idUser'=>$this->idUser,
            ));

        } catch (Exception $e) {
            echo "Erreur " . $e->getMessage();
        }



    }
    public function editerTache()
    {
        try {

            $pdo = ConfigClass::pdo();

            $sql2 = $pdo->prepare("UPDATE Taches SET nomTache=:nn, descriptions=:nd, statut=:nstatut, progression=:npro, dateModification=:dm WHERE idTache =:idTache");
            $result = $sql2->execute(array(
                'nn'=>$this->nomTache,
                'nd'=>$this->description,
                //'ndEcheance'=>$ndEcheance,
                'nstatut'=>$this->statut,
                'npro'=>$this->progession,
                'dm'=>$this->dateModification,
                'idTache'=>$this->idTache,
            ));

        }catch (Exception $e){
            echo "Une erreur s'est produite".$e->getMessage();
        }


    }
}