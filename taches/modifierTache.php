<?php


//include("../auth/config.php");

include_once("../auth/ConfigClass.php");
$pdo = ConfigClass::pdo();
include_once("TachesClass.php");

session_start();
if (!isset($_SESSION['idUser'])){
    header('Location: ../auth/connexion.php');
    exit();

}else{

    if (isset($_GET['idTache'])){
        $idTache = $_GET['idTache'];

        $recuperation = $pdo->prepare("SELECT nomTache, descriptions, statut, progression FROM Taches WHERE idTache =?");
        $recuperation->execute(array($idTache));
        $valeurs = $recuperation->fetch();
        if($valeurs){
            $nom = $valeurs['nomTache'];
            $desc = $valeurs['descriptions'];
            $staut = $valeurs['statut'];
            $prog = $valeurs['progression'];

        }


    try {

        if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['nom'], $_POST['description'], $_POST['statut'],$_POST['progression'])) {

            $message2 = "";
            $nn = htmlspecialchars($_POST['nom']);
            $nd = htmlspecialchars($_POST['description']);
            $nstatut = $_POST['statut'];
            $npro = intval($_POST['progression']);
            $dateModification = date('Y-m-d') . ' ' . date('H:i:s');

//
//            $sql = $pdo->prepare("UPDATE Taches SET nomTache=:nn, descriptions=:nd, statut=:nstatut, progression=:npro, dateModification=:dm WHERE idTache =:idTache");
//            $result = $sql->execute(array(
//                'nn'=>$nn,
//                'nd'=>$nd,
//                //'ndEcheance'=>$ndEcheance,
//                'nstatut'=>$nstatut,
//                'npro'=>$npro,
//                'dm'=>$dateModification,
//                'idTache'=>$idTache,
//            ));
            $tacheModification = new TachesClass($idTache, $nn, $nd,  null, null, $nstatut, $npro, null, null, null, $dateModification);
            $tacheModification->editerTache();


            if ($tacheModification) {
                //$messageSuccess = "Tâche " . $nn ." a été modifié avec succès au projet"
                header('Location: ../projets/userProjets.php');
                exit();
            } else {
                echo("Une erreur s'est survenu");
            }


        }

    }catch(Exception $e){
        $message2 ="Une erreur s'est survenu".$e->getMessage();

    }

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

        input[type="text"], input[type="datetime-local"], input[type="number"], textarea, select {
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
        .btn-cont {
            display: flex;
            justify-content: space-between; /* Place les liens aux extrémités gauche et droite */
            align-items: center;
            padding: 10px;
            margin: 20px 0;
            background-color: gray;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 80px;

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
    <h2>Modification Tâche</h2>


    <form action="" method="POST" enctype="multipart/form-data" >

        <div>
            <label for="nom">Nom de la Tâche :</label>
            <input type="text" id="nom" name="nom" value="<?= $nom;?>" required>
        </div>
        <div>
            <label for="description">Description :</label>
            <textarea id="description" name="description"  rows="4" cols="40" required placeholder="Tapez votre message ici..."><?php echo $desc; ?> </textarea><br>

        </div>
            <div>
                <label for="statut">Statut :</label>
                <select name="statut" id="statut">

                    <option value="A faire "<?= $staut == 'A faire' ?'selected':''; ?>>A faire</option>
                    <option value="En cours "<?= $staut == 'En cours' ?'selected':''; ?>>En cours</option>
                    <option value="Terminé" "<?= $staut == 'Terminé' ?'selected':''; ?>>Terminé</option>
                </select>
            </div>

        <div>

            <label for="file">Ajoutez un fichier :</label>
            <input type="checkbox"  id="activer" onclick="ActiverChampFile()" >

            <input style="width: 100%;padding: 10px; margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;" type="file" name="file" id="file" accept=".jpg, .png,.jpeg, .pdf" disabled>

        </div>



        <div>
            <label for="progression">Progression :</label>
            <input type="number" id="progression"  value="<?= $prog;?>" name="progression" min="0" max="100" >
        </div>

            <?php if (!empty($messageErreur)) : ?>
                <div style="color: red;"><?= $messageErreur; ?></div>
            <?php endif; ?>
        <div class="center">
            <input type="submit" value="Ajouter">
        </div>
    </form>
</div>


</body>



</html>