<?php
session_start();
include("../auth/config.php");
if (isset($_SESSION['idUser'])){
    $idUser = $_SESSION['idUser'];
//    header('Location: ../auth/connexion.php');



//
//nomTache VARCHAR(100),
//    description TEXT,
//    dateDebut DATETIME,
//    dateEcheance DATE,
//    priorite VARCHAR(100),
//    progression VARCHAR(50),
//    idProjet INT,
//    idUser INT,


    if ($_SERVER["REQUEST_METHOD"]== 'POST' && isset($_POST['nom'], $_POST['description'], $_POST['priorite'], $_POST['dateEcheance'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $desc = htmlspecialchars($_POST['description']);
        //$statut  = "A Faire";
        $dateEcheance = htmlspecialchars($_POST['dateEcheance']);
        $projetId = htmlspecialchars($_POST['projet']);


        $message =[];

        if (isset($_POST['add_file']) && $_FILES['file']['error'] ==0) {
            $fichier = $_FILES['file'];
            $dossierTelechargement = 'FichiersTaches/';
            $type = ['image/png','image/jpeg', 'image/jpg', 'application/pdf'];


            if(!in_array($fichier['type'], $type)) {
                $message[] = "Type de fichiers autorisés sont : png, jpg, jpeg, pdf, docx";
            }


            //nommer le fichier pour éviter les fichiers de meme noms
            $nomFichierSoumis = basename($fichier['name']);
            $nouveauNom =  uniqid() . "_" . $nomFichierSoumis;
            $cheminFichier = $dossierTelechargement .$nouveauNom;

            if (!move_uploaded_file($fichier['tmp_name'], $cheminFichier)) {
                $message[] = "Erreur lors du téléchargement du fichier. Veuillez Télécharger le fichier !!";
            }


            $sql = $pdo->prepare("INSERT INTO Taches(nomTaches, descriptions, dateEcheance, priorite, fichier, idProjet, idUser)VALUES (:nomTaches, :descriptions,:dateEcheance,:cheminFichier, :idProjet, :idUser)");
            $result = $sql->execute(array(
                'nomTaches'=>$nom,
                'descriptions'=>$desc,
                'dateEcheance'=>$dateEcheance,
                'cheminFichier'=>$cheminFichier,
                'idProjet'=>$projetId,
                'idUser'=>$idUser,
            ));

            if ($result) {
                $messageSuccess = $nom ."Taches est ajouté avec succès";
                //header('Location: ../Dashboard/dash.php');
            } else {
                $message[] = "taches n'est pas ajouté";
            }


        }else{
            $message[] = "Veuillez remplir tous les champs";
        }


    }
}else{
    header('Location: ../auth/connexion.php');
    exit();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

        .container h2 {
            margin-top: 0;
            color: blue;
            text-align: center;
            font-weight: bold;

        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight:bolder;

        }

        input[type="text"], input[type="date"], input[type="time"], input[type="number "], textarea, select {
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

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
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

    </style>
</head>
<body>
<div class="container">
    <h2> Nouvelle Tâche</h2>


    <form action="" method="post">
        <div>
            <label for="menu">Projet</label>
            <select name="menu" id="menu">


                <option value="" disabled selected>Selectionnez le Projet</option>
                <?php
                $sql = $pdo->prepare("SELECT idProjet, nomProjet FROM Projets WHERE idUser = ?");

                if($sql->execute(array($idUser))){
                    ?>
                    <?php
                    while ($val = $sql->fetch())
                    {
                        ?>

                        <option value="<?=htmlspecialchars($val['idProjet']);?>"> <?php echo($val['nomProjet']);?></option>

                        <?php
                    } ;
                }else{
                    ?>
                    <option class="aucun-projet">Vous n'avez créé aucun projet</option>
                    <?php
                }


                ?>

            </select>
        <div>
            <label for="nom">Nom de la Tâche :</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div>
            <label for="description">Description :</label>
            <textarea id="description" name="description" rows="4" cols="40" placeholder="Tapez votre message ici..."></textarea><br>

        </div>

        <label for="file">Ajoutez un fichier :</label>
        <input style="width: 100%;padding: 10px; margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;" type="file" name="file" id="file" accept=".jpg, .png, .pdf">



        <div>
            <label for="dateEcheance">Date d'Echéance :</label>
            <input type="date" id="dateEcheance" name="dateEcheance">
        </div>



        <div>
            <label for="priorite">Priorité :</label>
            <select id="priorite" name="priorite" >
                <option value="Select" disabled selected >Select</option>
                <option value="Moyenne">Moyenne</option>
                <option value="Elevée">Elevée</option>
                <option value="Faible">Faible</option>
            </select>

            <?php

            ?>
        </div>
<!--        <div>-->
<!--            <label for="progression">Progression :</label>-->
<!--            <input style="width: 100%;-->
<!--            padding: 10px;-->
<!--            margin-bottom: 10px;-->
<!--            border: 1px solid #ccc;-->
<!--            border-radius: 4px;-->
<!--            font-size: 16px;" type="number" id="progression" name="progression" min="0" max="100" value="0" >-->
<!--        </div>-->
            <?php if (!empty($message)) : ?>
                <div style="color: red;"><?= $message; ?></div>
            <?php endif; ?>
        <div class="center">
            <input type="submit" value="Ajouter">
        </div>
    </form>
</div>


</body>
</html>