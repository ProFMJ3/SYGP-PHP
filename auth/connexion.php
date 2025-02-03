<?php

include("config.php");
session_start();

$message = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'],$_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = :username";
    $req = $pdo->prepare($sql);
    $req->execute(array('username' =>$username));
    $user = $req->fetch();

    if ($user && $password == $user['passwords']) {


        //session_regenerate_id(true);
        $_SESSION['idUser'] = $user['idUser'];
        $_SESSION['username'] = $user['username'];
        //session_regenerate_id(true);
        header('Location: ../Dashboard/dash.php');
        //header('Location: test.php');
        exit();
    } else {
        $message = 'Mauvais identifiants';

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
    <title>CONNEXION</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

    <style>
    body{
    margin: 0;
    padding: 0;
    background-color: green;
    }
    h2{
        margin-top: 5px;
        margin-bottom: 40px;
        font-weight: bold;
        text-align: center;
        font-family:"Times New Roman";

    }
    .div1{
    padding-bottom: 50px;
    padding-top: 30px;
    color: green;
    background-color: green;
    border-radius: 10px;
    align-items: center;

    }
    .container{
    max-width: 400px;
    margin: 100px auto;
    background-color: #fff;
    padding: 20px 30px;
    border-radius: 8px;
    align-items: center;
    text-align: center;
    display: flex;
    flex-direction: column;





    }
    /*form{
    background-color: white;
    border-radius: 10px;
    }*/
    label{
    font-weight: bold;
    margin-bottom: -5px;
    }
    input{
    border-radius: 5px;
    width: 80%;
    margin: 15px;
    height: 30px;
    border: 2px solid darkgray;
    }

    input::placeholder{
    font-weight: lighter;
    font-family: "Times New Roman", sans-serif;
    color: gray;


    }
    button{
    color: green;
    background-color: orange;
    border-radius: 15px;
    font-weight: bolder;
    cursor: pointer;
    border: none;
    padding: 10px 20px;


    }
    button:hover{
    background-color: gold;
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

    </style>
</head>
<body>


<div class="div1">

    <form action="" method="POST">
        <div class="container">
            <h2 style="color: black" >CONNEXION</h2>

            <label for="username">Nom d'utilisateur</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Ex: dupont3" required>

            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>

            <button type="submit">Se connecter</button>
            <?php if (!empty($message)):?>
                <div style="color: red;"><?= $message; ?></div>
            <?php endif; ?>
            <a href="inscription.php" type="submit">Inscription</a>

        </div>



    </form>
</div>
<script src="../assets/js/bootstrap.min.js"></script>

</body>
</html>