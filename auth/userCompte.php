
<?php

session_start();

//Vérifier si l'utilisateur est connecté
if (isset($_SESSION['idUser'])) {

    include('../auth/config.php');
    //Récupérer l'ID
    $idUser = $_SESSION['idUser'];

    try {
        //Récupérer les projets de chaque utilisateur
        $profil = $pdo->prepare("SELECT idUser, username, email, passwords, dateInscription FROM Users WHERE idUser = ?");
        $profil->execute(array($idUser));

        $info= $profil->fetch(PDO::FETCH_ASSOC);

        //Avoir le nombre de projets crée par chaque user
        $requete2 = $pdo->prepare("SELECT COUNT(*) FROM projets WHERE idUser = ?");
        $requete2->execute(array($idUser));
        $n = $requete2->fetchColumn();


        //Les collaborateurs de chaque projet

        //$requete3 = $pdo->prepare("SELECT COUNT(*), idUser FROM collabraton WHERE idProjet =?");


        //$requete3->execute(array($projets['idProjet']));







    }catch (Exception $e){
        echo ("Une erreur s'est produite");
    }

}else{
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

        a{
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

        .profil{
            width:50%;
            max-width:100vh;
            height: 50%;
            max-height: 80vh;
            margin:auto;
            border-radius:10px;
            padding-left: 10px;
            border: 2px solid darkgrey;
            background-color: darkgray;
            font-family: 'Times New Roman', sans-serif;
            box-shadow: 0 3px 10px rgba(0,1,0,0.2);

        }

        .profil h1{
            padding-bottom:30px;
            text-align: center;
            color: white;
            font-weight: bold;
        }



        .profil-details p{
            padding-top: 10px;
            justify-content: right;
            font-weight: normal;
            color: black;
        }



        .center{
            justify-content: center;
            text-align: center;
            align-content: center;
            margin-bottom: 20px;

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

        </div>

    </div>

    <!-- <h2 style="text-align: center; background-color: #343a40; padding: 0; border-bottom-right-radius: 8px;" class="mb-5 " >Bienvenue sur votre tableau de bord</h2>-->

    <div class="d-flex" style="margin:0;">

        <div class="sidebar p-3">
            <h4 class="text-white">Mon Dashboard</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="../Dashboard/dash.php"> <i class="bi bi-house-fill"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../projets/userProjets.php"><i class="bi bi-folder"></i> Mes Projets</a>
                    <ul class="nav flex-column ms-3">

                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="bi bi-check-circle"></i> Tâches</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="bi bi-people"></i> Membres du Projet</a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-person"></i> Mon Compte</a>
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


        <div class="profil">

            <?php

            if($info) {



                    $collaboration = $pdo->prepare("SELECT COUNT(idProjet) AS nbreCollaboration FROM Collaboration WHERE idUser =?");
                    $collaboration->execute(array($idUser));

                    $nC = $collaboration->fetchColumn();

                    ?>


                        <h1>L'information de votre compte </h1>
                        <div class="profil-details" >
                            <p> <strong>Projets créés :</strong>  <?php echo $n; ?></p>
                            <p> <strong>Collaborations :</strong> <?php echo $nC; ?> projet(s) </p>
                            <p><strong>Date d'inscription :</strong> <?php echo ($info['dateInscription']); ?> </p>
                            <p><strong>Nom d'utilisateur :</strong><?php echo ($info['username']); ?> </p>
                            <p><strong>Email :</strong> <?php echo htmlspecialchars($info['email']); ?>  </p>
                            <p><strong>Mot de passe :</strong>  <?php echo str_repeat('*',strlen($info['passwords'])); ?>  </p>

                            <div class="center" >
                                <a href=" ../projets/modifierProjet.php?idUser= <?=$info['idUser'];?>" style="color: white" class="btn btn-success"> Modifier Profil <i class="fas fa-edit" ></i> </a>

                            </div>

                        </div>



                    <?php

            }
            ?>
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