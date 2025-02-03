
<?php

session_start();

 //Vérifier si l'utilisateur est connecté
if (isset($_SESSION['idUser'])) {

    include('../auth/config.php');
    //Récupérer l'ID
    $idUser = $_SESSION['idUser'];

    try {
        //Récupérer les projets de chaque utilisateur
        $requete1 = $pdo->prepare("SELECT idProjet, nomProjet, descriptions, dateCreation, dateFin, etat FROM Projets WHERE idUser = ?");
        $requete1->execute(array($idUser));

        $projets= $requete1->fetchAll(PDO::FETCH_ASSOC);

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



        .projets{
            width:100%;
            height: 500px;
            min-height: 100vh;
            align-items: center;
            margin: auto;
            border-radius: 10px;
            flex-direction: column;
            gap:10px;




        }

        .projets h1{
            padding-bottom:30px ;
            text-align: center;
            justify-content: center;
            color: green;
            font-family: 'Times New Roman';
            flex-direction: column;
            align-items: center;

        }

        .projet-every{
            max-width:100vh;
            margin:30px auto;
            border-radius:10px;
            background-color: #F8F9FA;
            display: flex;
            flex-direction: column;
            padding-bottom: 50px;
            align-items: center;
            border:2px solid #00796B;



        }



        .projet-every p{
            text-align: center;
            padding-top: 10px;
            display: flex;
            justify-content: center;
            font-weight: normal;
            font-family: "Times New Roman", sans-serif;

        }
        .projet-every h4{
            padding-bottom:20px ;
            text-align: center;
            justify-content: center;
            color: green;
            font-family: 'Times New Roman', sans-serif;
            align-content: center;
            justify-items: center;
            font-weight: bold;



        }
        .descriptionProjet{
            color: black;
            text-align: justify;
            line-height: 1.6;
            font-size: 16px;
            margin: 10px 0;
            background-color: rgba(0, 123, 255, 0.05);
            padding: 10px;
            border-radius: 8px;
        }

        .projet-every a{
            justify-content: center;

        }

        .aucun-projet{
            text-align: center;
            justify-items: center;
            justify-content: center;
            align-content: center;
            font-weight: bold;
            font-family: "Arial Black";
            font-size: 30px;


        }


        form a:hover{
            background-color:darkblue;
            color:darkorange;

        }

        .center{
            justify-content: center;
            text-align: center;
            align-content: center;
            margin-bottom: 20px;

        }

        .btn1{
            background-color: #FFA500;
            transition: background-color 0.3s ease;

        }
        /*footer{
            margin-top: 100px;
            padding-top:100px;
        }
        .mon-footer{
            text-align: center;

            font-family: "Times New Roman",sans-serif;
            color: grey;
            position: fixed;
            margin-top: 100px;


        }*/



    </style>
</head>
<body>





    <div class="dashboard-container" >
        <div style="padding-bottom: 100px; ">
        <div class="content fixed-top d-flex" >

            <a class="btn btn-success"  href="acceuil.php">Acceuil </a>

            <a class="btn btn-success" href="../projets/ajoutProjet.php">New Project</a>
            <a class="btn btn-success" href="../taches/ajoutTaches.php">New Task</a>
            <a class="btn btn-success" href="#">Assigner</a>

            <form style="height: 50px" action="../projets/collaboration.php" method="POST" class="d-flex gap-3 mt-4 g-3">
                <div>
                    <?php if (!empty($messageSuccess)) : ?>
                        <div class="taches-success" style="color: #0056b3;"><?= $messageSuccess; ?></div>
                    <?php endif; ?>
                </div>
                <label style="color: white; font-weight: bold" for="nom" class="form-label ">Collaboration</label>
                <select  class="form-select" name="projet" id="projet" required>




                        <option class="form-control" value="" disabled selected> Select the Projet</option>
                        <?php
                        $sql = $pdo->prepare("SELECT idProjet, nomProjet FROM Projets WHERE idUser =?");

                        if($sql->execute(array($idUser))){
                            ?>
                            <?php
                            while ($resultats = $sql->fetch())
                            {
                                ?>

                                <option class="form-control" value="<?=htmlspecialchars($resultats['idProjet']);?>"> <?php echo(($resultats['nomProjet'])); ?> </option>

                                <?php
                            } ;
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
                        <a class="nav-link active" href="#"> <i class="bi bi-house-fill"></i> Dashboard</a>
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


            <div class="projets">

                <?php

                    if($projets ) {

                       echo ("<h1 class='titre' >Vous avez créé $n Projet(s)</h1>");
                        foreach($projets as $projet){
                            $requete3 = $pdo->prepare("SELECT COUNT(idUser) AS nbreCollaboration FROM Collaboration WHERE  idProjet =?");
                            $requete3->execute(array($projet['idProjet']));

                            //$valeurs = $requete3->fetch();
                            $valeurs = $requete3->fetch(PDO::FETCH_ASSOC);

                            ?>
                                <div class="projet-every" >

                                    <h4 class="titreProjet"><?php echo ($projet['nomProjet']); ?> Crée : <?php echo $projet['dateCreation']; ?> </h4>


                                    <label for=""> </label>
                                    <p class="descriptionProjet">DESCRIPTION DU PROJET : <?php echo ($projet['descriptions']); ?> </p>
                                    <p style="color: gold; font-weight: bold; font-size: 20px "> <?php echo htmlspecialchars($projet['etat']); ?>  </p>
                                    <span style="color: red; font-weight: bold"> DEADLINE : <?php echo htmlspecialchars($projet['dateFin']); ?>  </span>
                                    <span style="color: black; font-weight: bold"> Nombre de Collaborateurs : <?php echo intval($valeurs['nbreCollaboration']); ?> </span>

                                    <a href="../taches/ajoutTaches.php" class=" btn-success">Vos Tâches</a>
                                    <div class="center">
                                        <a href=" ../projets/modifierProjet.php?idProjet= <?=$projet['idProjet'];?>" style="color: white" class="btn1 btn-warning"><i class="fas fa-edit"></i>   Modifier le projet</a>


                                    </div>
                                </div>



                <?php
                        }

                    }else{
                        ?>
                        <p class="aucun-projet" >Vous n'avez créé aucun projet</p>
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