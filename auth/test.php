<?php
//$dateNow = date('Y-m-d');
//$heure =date('H:i:s');
//$dateHeure = $dateNow . ' ' . $heure;
//echo($dateHeure);
//
//$dateCommande = date('Y-m-d') . ' ' . date('H:i:s');
//echo ($dateCommande);
//

//Les collaborateurs de chaque projet




session_start();
include('config.php');
 //Vérifier si l'utilisateur est connecté
if (isset($_SESSION['idUser'])) {


    //Récupérer l'ID
    $idUser = $_SESSION['idUser'];

//    try {
        //Récupérer les projets de chaque utilisateur

        $requete1 = $pdo->prepare("SELECT idProjet, nomProjet, descriptions, dateCreation, dateFin, etat FROM Projets WHERE idUser = ?");
        $requete1->execute(array($idUser));

        $projets= $requete1->fetchAll(PDO::FETCH_ASSOC);
        //$p = $projets['idProjet'];

        //Avoir le nombre de projets crée par chaque user
        $requete2 = $pdo->prepare("SELECT COUNT(*) FROM projets WHERE idUser = ?");
        $requete2->execute(array($idUser));
        $n = $requete2->fetchColumn();






    foreach ($projets as $projet)
    {                  //LEFT JOIN menus ON commandes.menuId = menus.menuId LEFT JOIN clients ON commandes.clientId = clients.clientId ");
        //echo($projet['idProjet']);
        $requete3 = $pdo->prepare("SELECT Users.username, Users.email FROM Collaboration LEFT JOIN Users ON Collaboration.idUser = Users.idUser WHERE  idProjet =?");
        $requete3->execute(array($projet['idProjet']));

        if ($requete3){
            $valeurs = $requete3->fetchAll(PDO::FETCH_ASSOC);
            foreach($valeurs as $val)
            {
                echo ('</br>'.$projet['idProjet']. ' ' .$val['username'] . ' ' . $val['email']) . '</br>';


            }

        }else{
            echo ('Aucun');
        }
        //$valeurs = $requete3->fetch();




        }


// git config --global core.autocrlf true






//    }catch (Exception $e){
//        echo ("Une erreur s'est produite");
//    }

}else{
    header('Location: ../auth/connexion.php');
    exit();

}


//session_destroy()
?>
