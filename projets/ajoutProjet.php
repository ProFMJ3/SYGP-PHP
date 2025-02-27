<?php


//include("../auth/config.php");
include_once("../auth/ConfigClass.php");
$pdo = ConfigClass::pdo();

include_once("../projets/ProjetClass.php");
session_start();
if (!isset($_SESSION['idUser'])){
    //die("Vous devez être connecté pour créer un projet.");
    header('Location: ../auth/connexion.php');
    exit();

}else{



    try {


    if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['nom'], $_POST['description'],$_POST['dateFin'])) {
        $message1 = "";
        $message2 = "";
        $nom = htmlspecialchars($_POST['nom']);
        $desc = htmlspecialchars($_POST['description']);
        $dateFin = htmlspecialchars($_POST['dateFin']);
        $idUser = $_SESSION['idUser'];

            //Controle

        $verification = $pdo->prepare("SELECT idProjet FROM Projets WHERE nomProjet = ? AND idUser!=?");
        $verification->execute(array($nom, $idUser));

        $nomTrouve= $verification->fetch();
        if ($nomTrouve){
            $errors[] = "Vous avez déja utilisé ce nom de projet !!";
        }



//            $sql = $pdo->prepare('INSERT INTO Projets(nomProjet, descriptions, dateFin, idUser)VALUES (:nomProjet, :descriptions, :dateFin, :idUser)');
//            $result = $sql->execute(array(
//                    'nomProjet'=>$nom,
//                    'descriptions'=>$desc,
//                    'dateFin'=>$dateFin,
//                    'idUser'=>$idUser,
//            ));

            $projet = new ProjetClass(null, $nom, $desc, $dateFin, null, $idUser, null);
            $projet->nouveauProjet();


            if ($projet) {
                $messageSuccess = $nom . " est créé avec succès";
                //header('Location: ../Dashboard/dash.php');
                //exit();
            } else {

                echo("Une erreur s'est survenu");

            }


    }

    }catch(Exception $e){
        $message2 ="Une erreur s'est survenu".$e ->getMessage();


    }

}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>SYGP</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container{
            max-width: 500px;
            margin: 100px auto;
            background-color: #fff;
            padding: 20px 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;

        }

        h2 {
            margin-top: 0;
            color: blue;
            text-align: center;
            font-weight: bold;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;

        }

        input[type="text"], input[type="date"], input[type="number"],textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }


        textarea {
            resize: none;
        }
        form{

        }

        .container input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;

        }

        .container input[type="submit"]:hover {
            background-color: #0056b3;


        }

        p {
            color: red;
            font-weight: bold;
        }

        .center{
            display: flex;
            justify-content: center;


        }
        .btn-cont {
            display: flex;
            justify-content: space-between; /* Place les liens aux extrémités gauche et droite */
            align-items: center;
            padding: 10px;
            margin: 20px 0;
            background-color: lightgray;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);

            height: 100px;
        }

        .btn-acceuil a ,
        .btn-liste a  {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.3s ease;

        }

        .btn-acceuil a:hover,
        .btn-liste a:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .taches-success{
            font-weight: bold;
            font-size: 20px;
            position:relative;
            animation: bougermessage 5s linear infinite ;


        }
        @keyframes bougermessage {
            from {

                left: -150px
            }to {
                 left: 150px;
             }

        }

    </style>
</head>
<body>

<div class="btn-cont">
    <div class="btn-acceuil">
        <a href="../Dashboard/acceuil.php" class="btn btn-primary">Acceuil</a>
    </div>
    <?php if (!empty($messageSuccess)) : ?>
        <div class="taches-success" style="color: #0056b3;"><?= $messageSuccess; ?></div>
    <?php endif; ?>

    <div class="btn-liste">
        <a href="../Dashboard/dash.php" class="btn btn-primary">Dashborad</a>
</div>
</div>
<div class="container">

    <h2> Nouveau Projet</h2>
    <a class="btn btn-primary" href="../Dashboard/dash.php">Dashboard</a>
    <form action="" method="POST">
<!--        --><?php //if (!empty($message1)) : ?>
<!--            <div style="color: blue;">--><?php //= $message1; ?><!--</div>-->
<!--        --><?php //endif; ?>
        <div>
            <label for="nom">Nom du projet :</label>
            <input type="text" id="nom" name="nom" placeholder="Ex: Application de gestion étudiants" required>
        </div>

        <div>
            <label for="description">Description :</label>
            <textarea id="description" name="description" rows="6" cols="60" placeholder="Décrire un peu votre projet ici..." required></textarea><br>
        </div>

        <div>
            <label for="dateFin">Date Fin de projet :</label>
            <input type="date" id="dateFin" name="dateFin">
        </div>

        <div class="center">
            <input  type="submit" value="Créer Projet">
        </div>
        <?php if (!empty($message2)):?>
            <div style="color: red;"><?= $message2; ?></div>
        <?php endif; ?>
    </form>
</div>






</body>
</html>