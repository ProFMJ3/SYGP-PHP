<?php

//include('../auth/config.php');

include_once("../auth/ConfigClass.php");
$pdo = ConfigClass::pdo();
include_once ("AssignationClass.php");
$errors = [];

if (isset($_GET['idTache'])){
    $idTache = $_GET['idTache'];


    $rec = $pdo->prepare("SELECT idProjet FROM Taches WHERE idTache =?");
    $rec->execute(array($idTache));
    $idProjet = $rec->fetchColumn();

    if ($idProjet===false){
        $errors[]= "le Projet dont la tache appartient n'existe pas !!";
    }




    try {

        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['collaborateur'])) {
            $idCollaborateur = intval($_POST['collaborateur']);
            $date = date('Y-m-d'). ' ' . date('H:i:s');



            if (empty($errors)){

                $sql = $pdo->prepare("INSERT INTO Assignation(dateAssignation, idTache, idUser) VALUES (:date,:idTache, :idColla)");
                $sql->execute(array(
                    'date'=>$date,
                    'idTache'=>$idTache,
                    'idColla'=>$idCollaborateur,
                ));
//                $assignation = new  AssignationClass($date, $idTache, $idCollaborateur);
//                $assignation->nouveauAssignation();


                if($sql){
                    $messageSuccess = " La tache a été assigné avec Succès";
                    header('Location:../Dashboard/dash.php');
                    exit();
                }
            }else{
                $message = implode('</br>', $errors);
            }
        }

    }catch (Exception $e){
        echo("Erreur".$e->getMessage());
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
    <title>Document</title>
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
    <form action="" method="POST" >
        <h1 class="titre" >ASSIGNATION</h1>

        <?php if (!empty($message)) : ?>
            <div style="color: red;"><?= $message; ?></div>
        <?php endif; ?>

        <select  class="form-select" name="collaborateur" id="collaborateur" required>


            <option class="form-control" value="" disabled selected>Choisissez le collaborateur</option>
            <?php
            $collaborateurSql = $pdo->prepare("SELECT Users.idUser, Users.username FROM Collaboration LEFT JOIN Users ON Collaboration.idUser = Users.idUser  WHERE idProjet =?");

            if($collaborateurSql->execute(array($idProjet))){
                ?>
                <?php
                while ($result = $collaborateurSql->fetch())
                {
                    ?>

                    <option class="form-control" value="<?=htmlspecialchars($result['idUser']);?>"> <?php echo(($result['username'])); ?> </option>

                    <?php
                } ;
            }else{
                echo '<option>'. "Vous n'avez aucun collaborateur. Veuillez ajouter collaborateur !!" . '</option>';
            }
            ?>
        </select>


        <div class="center">
            <input type="submit" value="Confirmer">
        </div>
    </form>
</div>

</body>
</html>
