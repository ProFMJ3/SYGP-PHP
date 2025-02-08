<?php

include_once("ConfigClass.php");

class UserClass
{
    protected $idUser;
    protected $username;
    protected $email;
    protected $passwords;
    //protected $dateInscription;
    protected $dateModification;

    // Constructeur
    public function __construct($idUser, $username, $email, $passwords,$dateModification)
    {
        $this->idUser = $idUser;
        $this->username = $username;
        $this->email = $email;
        $this->passwords = $passwords;
        //$this->dateInscription = $dateInscription;
        $this->dateModification = $dateModification;
    }

    // Getters
    public function getIdUser() {
        return $this->idUser;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPasswords() {
        return $this->passwords;
    }

//    public function getDateInscription() {
//        return $this->dateInscription;
//    }

    // Setters
    public function setUsername($username) {
        $this->username = $username;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->passwords = $password;
    }

    // Ajouter un nouvel utilisateur
    public function newUser()
    {
        try {
            $pdo = ConfigClass::pdo();
            $sql = "INSERT INTO users (email, username, passwords) VALUES (:email, :username, :password)";
            $stmt = $pdo->prepare($sql);

            $result = $stmt->execute(array(
                'email' => $this->email,
                'username' => $this->username,
                'password' => $this->passwords,
            ));
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    // Mettre à jour un utilisateur
    public function modifierUser()
    {
        //$dateModification = date("Y-m-d") .' '. date("H:i:s");
        try {
            $pdo = ConfigClass::pdo();
            $sql = "UPDATE Users SET email=:email, username=:username, passwords=:password WHERE idUser =:idUser";
            $stmt = $pdo->prepare($sql);

            $result = $stmt->execute(array(
                'email' => $this->email,
                'username' => $this->username,
                'password' => $this->passwords,
                'idUser' => $this->idUser,
            ));
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
