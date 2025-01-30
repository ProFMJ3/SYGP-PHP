
<?php
//try{
$connexion = new PDO('mysql:host=localhost;dbname=fastfood;charset =utf8','root','Jules1012#');

//echo("Connexion réussie")
$dateCommande = '0000-00-00 00:00';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $menu = htmlspecialchars($_POST['menu']);
    $client = htmlspecialchars($_POST['client']);
    $qte = htmlspecialchars($_POST['quantite']);
    $prix = htmlspecialchars($_POST['prixTotal']);
    $dateCommande =  $_POST['dateCommande'];

//        $cl = $connexion->prepare("SELECT clientId FROM clients WHERE nomClient=?");
//        $cl->execute(array($client));
//        $clId = $cl->fetchColumn();
//
//        $mn = $connexion->prepare("SELECT menuId FROM menus WHERE menuId=?");
//        $mn->execute(array($client));
//        $mnId = $cl->fetchColumn();


    $sql = $connexion->prepare("INSERT INTO commandes(quantite, prixTotal,dateCommande, menuId, clientId ) VALUES(:qte, :pt,:dt,:mnId,:clId)");
    $sql->execute(array(
        'qte'=>$qte,
        'pt'=>$prix,
        'dt'=>$dateCommande,
        'mnId'=>$menu,
        'clId'=>$client,

    ));
    if($sql) {
        echo("Commande " . $menu . " de " . $client . " a été ajouté avec succès");
        header("Location: listeCommandes.php");
        exit();
    }
}

//}catch (Exception $e){
//echo ("Une erreur s'est produite !!!");
//}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../menu/style.css">

    <title>ajoutClients</title>
    <style>

        body {
            font-family: "Times New Roman", sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .content {
            max-width: 400px;
            margin: 100px auto;
            background-color: #fff;
            padding: 20px 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            margin-top: 0;
            color: green;
            font-weight:bold;
        }

        label, option{
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight:bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button{
            background-color: green;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;

        }

        button:hover {
            background-color: greenyellow;
        }
        .center{
            display:flex;
            text-align:center;
            justify-content: center;
        }


        .btn{
            margin-top: 50px;
        }
        .btn:hover{
            background-color: green;
        }
    </style>
</head>
<body>

<header style="background-color: green; width: 100%" >

    <nav class="navbar navbar-expand-lg" >
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">FASTFOOD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                    <a class="nav-link" href="../menus/listeMenu.php">Menus</a>
                    <a class="nav-link" href="../clients/listeClients.php">Clients</a>
                    <a class="nav-link" href="../Commandes/listeCommandes.php" >Commandes</a>
                </div>
            </div>
        </div>
    </nav>
</header>

<a href="listeCommandes.php" class="btn btn-success">Listes de commandes</a>

<div class="content">
    <h2>AJOUT COMMANDE</h2>
    <form action="" method="POST">

        <div>
            <label for="menu">Menu</label>
            <select name="menu" id="menu">


                <option value="" disabled selected><--Choisissez le ménu--></option>
                <?php
                $sql = $connexion->prepare("SELECT menuId, nomMenu FROM menus");

                if($sql->execute()){
                    ?>
                    <?php
                    while ($menu = $sql->fetch())
                    {
                        ?>

                        <option value="<?=htmlspecialchars($menu['menuId']);?>"> <?php echo(htmlspecialchars($menu['nomMenu'])); ?> </option>

                        <?php
                    } ;
                }


                ?>

            </select>

        </div>
        <div>


            <label for="client">Nom du Client</label>
            <select name="client" id="client">

                <option value="" disabled selected><--Choisissez le ménu--></option>
                <?php
                $sql2 = $connexion->prepare("SELECT clientId, CONCAT(nomClient,' ', prenomsClient) AS nomComplet FROM clients");

                if($sql2->execute()){
                    ?>
                    <?php
                    while ($client = $sql2->fetch(PDO::FETCH_ASSOC))
                    {
                        $nc = $client['nomComplet'];
                        ?>

                        <option value="<?=htmlspecialchars(($client['clientId']));?>"> <?= htmlspecialchars($nc); ?> </option>

                        <?php
                    } ;
                }


                ?>


            </select>
            <!--            <input type="text" name="nom" id="nom" placeholder="Entrer le nom du menu" required>-->
        </div>


        <div>
            <label for="quantite">Quantité acheté</label>
            <input type="number" id="quantite" name="quantite"  required>

        </div>
        <div>
            <label for="prixTotal">Total</label>
            <input type="number" name="prixTotal" id="prixTotal" required>

        </div>

        <div>
            <label for="date">Date</label>
            <input type="datetime-local" id="dateCommande" name="dateCommande" required>

        </div>

        <div class="center">
            <button type="submit" >Ajouter</button>

        </div>


</div>
</form>

</div>



<script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>