
<?php


//include('../auth/config.php');
include_once("../auth/ConfigClass.php");
$pdo = ConfigClass::pdo();

include_once("../projets/ProjetClass.php");
session_start();

//Vérifier si l'utilisateur est connecté
if(isset($_SESSION['idUser'])) {


    $idUser = $_SESSION['idUser'];

//    try {
//
//
//
//
//
//
//
//        }else{
//            echo ("Une erreur s'est survenue lors de l'affichage !!");
//        }
//
//
//
//
//
//
//
//
//
//
//
//
//    }catch (Exception $e){
//        echo ("Une erreur s'est produite");
//    }
//
//
}
else{
    header('Location: ../auth/connexion.php');
    exit();

}


//session_destroy()
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">




    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding-bottom: 100px;
            height: 100vh;
        }

        header {
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            width: 100%;
            height: 100vh;
            margin: 0;
            background-color: whitesmoke;
            padding: 20px 30px;
            /*box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);*/
            border-radius: 8px;
            position: fixed;
            overflow-y: auto;
            z-index: 1000;

        }

        h2 {
            color: white;
        }
        p {
            color: #555;
        }


        .dashboard-container h2 {
            margin: 0;
            padding: 0;
        }

        .dashboard-container .sidebar{
            margin-left: -30px;
        }
        .sidebar{
            height: 80%;
            background-color: #343a40;
            margin: 0 auto;
            border-top-right-radius: 10px;
            z-index: 1000;
            overflow-y: auto;
            border-bottom-right-radius: 10px;
            min-width: 15%;
            position:revert;
            padding-bottom:50px;



        }
        a{
            display: flex;
            margin-top: 20px;
            cursor: pointer;
            padding: 10px 20px;
            text-decoration: none;


        }
        .sidebar a {
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057; /* Couleur au survol */
        }
        .content {
            display: flex;
            justify-content: center;
            gap: 10px;
            text-align: center;
            height: 80px;
            padding: 1px 10px;
            margin: 0 ;
            background-color: #343a40;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;

        }
        .content a{
            align-content: center;
            height: 55px;
            border-width: 5px;
            border-color: white;
            color: white;

        }

        .decon{
            display: flex;
            margin-top: 20px;
            color: white;
            background-color:green;
            border-radius: 10px;
            font-weight: bolder;
            cursor: pointer;
            padding: 10px 20px;
            text-decoration: none;
            border: black;

        }

        .bi {
            color: #00aeff;
        }

        .colla p{
            color: black;

        }


        .projet{
            width:100%;
            max-width:100vh;
            height: 50%;
            max-height: 100vh;
            margin:auto;
            border-radius:10px;
            padding-left: 10px;
            border: 2px solid darkgrey;
            background-color: whitesmoke;
            font-family: 'Times New Roman', sans-serif;
            box-shadow: 0 3px 10px rgba(0,1,0,0.2);


        }

        .projet h1{
            margin-bottom:30px;
            margin-top:20px;
            text-align: center;
            color: blue;
            font-weight: bold;
            font-size: 22px;
        }



        .projet-details p{
            padding-top: 10px;
            justify-content: right;
            font-weight: normal;
            color: black;
            font-size: 20px;
        }

        .projet-details .btn{
            font-weight: bold;
            font-size: 20px
        }
        .center{
            display: flex;
            text-align: center;
            margin-bottom:20px ;
            justify-content: center;




        }


        .div-taches{

            flex-direction: column;
        }

        .taches{
            display: flex;
            flex-direction: column;
            gap:10px;
            margin-bottom: 20px;

        }
        .taches p{
            align-items: center;
            text-align: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
            display: flex;

        }

        .taches  .center {
            height: 20px;
            font-size: 18px;
            align-content: center;
            align-items: center;
            margin-bottom: 30px;

        }



        .div-taches h3{
            text-align: center;
        }
        .div-taches a {
            text-decoration: none;
        }
        .div-taches p{
            gap:10px;
        }








    </style>
</head>
<body>





<div class="dashboard-container" >
    <div style="padding-bottom: 100px; ">
        <div class="content fixed-top d-flex" >

            <a class="btn btn-success"  href="../Dashboard/acceuil.php">Acceuil </a>

            <a class="btn btn-success" href="../projets/ajoutProjet.php">New Project</a>
            <a class="btn btn-success" href="../taches/ajoutTaches.php">New Task</a>
            <a class="btn btn-success" href="#">Assigner</a>

            <form style="height: 50px" action="../projets/collaboration.php" method="POST" class="d-flex gap-3 mt-4 g-3">
                <div>
                    <?php
                    //if ($messa)
                    ?>
                </div>
                <label style="color: white; font-weight: bold" for="nom" class="form-label ">Collaboration</label>
                <select  class="form-select" name="projet" id="projet" required>


                    <option class="form-control" value="" disabled selected> Select the Projet</option>
                    <?php
                    try {


                        $etat = "En cours";
                        $sql = $pdo->prepare("SELECT idProjet, nomProjet FROM Projets WHERE idUser =? AND etat =? ");

                        if($sql->execute(array($idUser, $etat))){
                            ?>
                            <?php
                            while ($resultats = $sql->fetch())
                            {
                                ?>

                                <option class="form-control" value="<?=htmlspecialchars($resultats['idProjet']);?>"> <?php echo(($resultats['nomProjet'])); ?> </option>

                                <?php
                            } ;
                        }
                    }catch (Exception $e){
                        echo('Erreur '.$e->getMessage());
                    }



                    ?>
                </select>

                <input class="form-control"  type="text" id="nom" name="nom" placeholder="username du collaborateur" required>
                <button type="submit" class="btn btn-primary " href="#">Collaborer</button>

            </form>
        </div>

    </div>

    <!-- <h2 style="text-align: center; background-color: #343a40; padding: 0; border-bottom-right-radius: 8px;" class="mb-5 " >Bienvenue sur votre tableau de bord</h2>-->

    <div class="d-flex" style="margin:0;">
        <!-- Menu de navigation -->
        <div class="sidebar p-3">
            <h4 class="text-white">Mon Dashboard</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="../Dashboard/dash.php"> <i class="bi bi-house-fill"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="userProjets.php"><i class="bi bi-folder"></i> Mes Projets</a>
                    <ul class="nav flex-column ms-3">

                        <li class="nav-item">
                            <a class="nav-link" href="userCollaboration.php"><i class="bi bi-check-circle"></i>Mes collabirations</a>
                        </li>
                        <li class="nav-item">


                            <a class="nav-link" href="#"><i class="bi bi-people"></i> Membres du Projet</a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../auth/userCompte.php"><i class="bi bi-person"></i> Mon Compte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-bell"></i> Notifications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../auth/inscription.php"><i class="bi bi-person-plus"></i> Nouveau Compte</a>
                </li>
                <li>
                    <a class="decon" href="../auth/deconnexion.php"> <i class="bi bi-person-fill-dash"></i> Se déconnecter</a>
                </li>
            </ul>
        </div>

        <div class="projet">


            <?php

            if(isset($_GET['idProjet'])){
                $idProjet = $_GET['idProjet'];

                //Récupérer les taches sur chaque projet
                $infoProjet = $pdo->prepare("SELECT idProjet, nomProjet, descriptions, dateCreation, dateFin, etat FROM Projets WHERE idProjet = ?");
                $infoProjet->execute(array($idProjet));

                $info = $infoProjet->fetch(PDO::FETCH_ASSOC);


                if($info)

                {?>
                    <div class="projet-details">
                        <h1>Projet : <?php echo $info['nomProjet'] ;?> </h1>

                        <p><strong>Description   </strong> :  <?php echo $info['dateCreation'] ;?>  </p>
                        <p><strong>Etat : </strong>  <?php echo $info['etat'] ;?>  </p>
                        <span style="color: red; font-weight: bold; font-size: 22px" ><strong>Date échéance :<strong> <?php echo $info['dateFin'];?> </span>

                        <div class="center">
                            <a  href="modifierProjet.php?idProjet=<?= $info['idProjet'] ;?>" class="btn btn-outline-primary">Modifier le projet</a>
<!--                            <a  href="collaboration.php?idProjet=--><?php //= $info['idProjet'] ;?><!--" class="btn btn-primary" >Collaborateur</a>-->

                        </div>

                    </div>

                    <div class="div-taches">
                        <h3>Les Tâches</h3>
                        <div class="taches">


                            <?php
                            //Récupérer les taches sur chaque projet
                            $sqltaches = $pdo->prepare("SELECT idTache, nomTache, dateEcheance, statut  FROM Taches WHERE idProjet = ?");

                            $sqltaches->execute(array($info['idProjet']));

                            $taches = $sqltaches->fetchAll(PDO::FETCH_ASSOC);
                            if ($taches){


                            foreach ($taches as $tache)
                            {?>
                                <p> Tache : <?php echo $tache['nomTache'] .'  --  '; echo' Date échéance :  '. $tache['dateEcheance'].' --- ' ; echo 'statut : '. $tache['statut'] . '  ';?>  <a href="../taches/afficheTache.php?idTache=<?= $tache['idTache'] ;?>" class="btn-primary">  Plus </a> </p>


                            <?php
                            }?>
                             <?php

                            }else
                            {?>



                                <p>Aucune tâche créée</p>
                                <div class="center">
                                    <a href="../taches/ajoutTaches.php" class="btn btn-primary"> Ajouter une tâche </a>

                                </div>

                            <?php
                            }

                            ?>

                        </div>

                    </div>



                    <?php
                }
            }


            ?>

        </div>




    </div>



</div>




</div>



<footer class="mon-footer" >
    <p>Vos données sont biens protégés. </p>
</footer>

<script>
    function CollabortionSucces(){
        return console("Collaboration a été effectué avec succès !!");
    }
</script>
</body>
</html>