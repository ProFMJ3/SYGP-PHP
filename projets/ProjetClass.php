<?php

include_once("../auth/ConfigClass.php");


class ProjetClass
{
    protected $idProjet;
    protected $nomProjet;
    protected $description;
    protected $dateFin;
    protected $dateModification;
    protected $idUser;
    protected $etat;


    // Getters
    public function getNomProjet() {
        return $this->nomProjet;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getDateFin() {
        return $this->dateFin;
    }




    // Setters
    public function setNomProjet($newNomProjet) {
        $this->nomProjet = $newNomProjet;
    }

    public function setDescription($newDescription)
    {
        $this->description = $newDescription;
    }

    public function setDateFin($newDateFin)
    {
        $this->dateFin = $newDateFin;
    }



    public function __construct($idProjet, $nomProjet, $description, $dateFin,  $dateModification, $idUser, $etat)
    {

        $this->idProjet = $idProjet;
        $this->nomProjet = $nomProjet;
        $this->description = $description;
        $this->dateFin = $dateFin;
        $this->dateModification = $dateModification;
        $this->idUser = $idUser;
        $this->etat = $etat;


    }

    public function nouveauProjet()
    {
        try {
            $pdo = ConfigClass::pdo();


            $sql1 = $pdo->prepare('INSERT INTO Projets(nomProjet, descriptions, dateFin, idUser)VALUES (:nomProjet, :descriptions, :dateFin, :idUser)');
            $result = $sql1->execute(array(
                'nomProjet' => $this->nomProjet,
                'descriptions' => $this->description,
                'dateFin' => $this->dateFin,
                'idUser' => $this->idUser,
            ));

        } catch (Exception $e) {
            echo "Erreur " . $e->getMessage();
        }



    }
    public function editerProjet()
    {
        try {

            $pdo = ConfigClass::pdo();
            $sql2 = $pdo->prepare("UPDATE Projets SET nomProjet=:n, descriptions=:d, dateFin=:df, dateModification =:dm WHERE idProjet =:idProjet");
            $result = $sql2->execute(array(
                'n'=>$this->nomProjet,
                'd'=>$this->description,
                'df'=>$this->dateFin,
                'dm'=>$this->dateModification,
                'idProjet'=>$this->idProjet,
            ));
        }catch (Exception $e){
            echo "Une erreur s'est produite".$e->getMessage();
        }


    }
}