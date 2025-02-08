<?php
session_start();

//include("../auth/config.php");
$message = [];
$messageErreur="";
include_once("../auth/ConfigClass.php");
$pdo = ConfigClass::pdo();
include_once("TachesClass.php");

if (isset($_SESSION['idUser'])){
    $idUser = $_SESSION['idUser'];
//    header('Location: ../auth/connexion.php');



    if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['nom'], $_POST['description'], $_POST['priorite'], $_POST['dateEcheance'],$_POST['projet'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $desc = htmlspecialchars($_POST['description']);
        $priorite = $_POST['priorite'];
        //$statut  = "A Faire";
        $dateEcheance = htmlspecialchars($_POST['dateEcheance']);
        $idProjet = $_POST['projet'];




        ///if (isset($_POST['add_file']) && $_FILES['file']['error'] ==0) {
        if (isset($_FILES['file'])) {
            $fichier = $_FILES['file'];
            $dossierTelechargement = 'FichiersTaches/';
            $type = ['image/png','image/jpeg', 'image/jpg', 'application/pdf'];


            if(!in_array($fichier['type'], $type)) {
                $message[] = "Type de fichiers autorisés sont : png, jpg, jpeg, pdf, docx";
            }
//            else{


                //nommer le fichier pour éviter les fichiers de meme noms
                $nomFichierSoumis = basename($fichier['name']);
                $nouveauNom =  uniqid() . "_" . $nomFichierSoumis;
                $cheminFichier = $dossierTelechargement .$nouveauNom;

//                if (!move_uploaded_file($fichier['tmp_name'], $cheminFichier)) {
//                    //$valide =True;
//                    $message[] = "Erreur lors du téléchargement du fichier. Veuillez Télécharger le fichier !!";
//                }
//                }


        }else{
            $cheminFichier = null;
        }

//        $sql = $pdo->prepare("INSERT INTO Taches(nomTache, descriptions, dateEcheance, priorite, fichier, idProjet, idUser)VALUES (:nomTache, :descriptions,:dateEcheance, :priorite,:fichier, :idProjet, :idUser)");
//        $result = $sql->execute(array(
//            'nomTache'=>$nom,
//            'descriptions'=>$desc,
//            'dateEcheance'=>$dateEcheance,
//            'priorite'=> $priorite,
//            'fichier'=>$cheminFichier,
//            'idProjet'=>$idProjet,
//            'idUser'=>$idUser,
//        ));

        if(empty($message)){


            $tache = new TachesClass(null, $nom, $desc, $dateEcheance, $priorite, null, null, $cheminFichier, null, $idProjet, $idUser);
            $tache->nouveauTache();

            if ($tache) {
                $pro = $pdo->prepare("SELECT nomProjet FROM  Projets WHERE idProjet =?");
                $pro->execute(array($idProjet));

                $nm =$pro ->fetch(PDO::FETCH_ASSOC);
                $messageSuccess = "Tâche ' " . $nom ." ' a été ajouté avec succès au projet". ' '.$nm['nomProjet'] ;
                //header('Location: ../Dashboard/dash.php');
            }else {

                $message[]= "Erreur lors de l'ajout";
            }

        }else {

            $messageErreur = implode('<br>', $message);
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

        input[type="text"], input[type="datetime-local"], input[type="file"], textarea, select {
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
        input:focus, textarea:focus, select:focus{
            border-color: blue;
            outline: none;
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
            background-color: gray;
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
    <h2> Nouvelle Tâche</h2>


    <form action="" method="POST" enctype="multipart/form-data" >
        <div>

            <label for="projet">Projet</label>
            <select name="projet" id="projet" required>


                <option value="" disabled selected>Selectionnez le Projet</option>
                <?php
                $sql = $pdo->prepare("SELECT idProjet, nomProjet FROM Projets WHERE idUser = ?");

                if($sql->execute(array($idUser))){
                    ?>
                    <?php
                    while ($val = $sql->fetch())
                    {
                        ?>

                        <option name="projet" id="projet" value="<?=htmlspecialchars($val['idProjet']);?>"> <?php echo($val['nomProjet']);?></option>

                        <?php
                    } ;
                }else{
                    ?>
                    <option class="aucun-projet">Vous n'avez créé aucun projet, Veuillez un Projet d'abord !!</option>
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
            <textarea id="description" name="description" rows="4" cols="40" required placeholder="Tapez votre message ici..."></textarea><br>

        </div>
        <div>
            
            <label for="file">Ajoutez un fichier(Optionnel) :</label>
            <input type="checkbox"  id="activer" onclick="ActiverChampFile()" >

            <input class="form-control form-control-lg" type="file" name="file" id="file" accept=".jpg, .png,.jpeg, .pdf" disabled >
            
        </div>
            



        <div>
            <label for="dateEcheance">Date d'Echéance :</label>
            <input type="datetime-local" id="dateEcheance" name="dateEcheance" required>
        </div>



        <div>
            <label for="priorite">Priorité :</label>
            <select id="priorite" name="priorite"  required >
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

            <?php if (!empty($messageErreur)) : ?>
                <div style="color: red;"><?= $messageErreur; ?></div>
            <?php endif; ?>
        <div class="center">
            <input type="submit" value="Ajouter">
        </div>
    </form>
</div>

<script>
    function ActiverChampFile() {
        let checkbox = document.getElementById("activer");
        let file = document.getElementById("file");


        // Activer/Désactiver le champ fichier
        file.disabled = !checkbox.checked;
    }
</script>


</body>



</html>