<?php

include("config.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['passwordConfirm'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];

    //un tableau pour recceuillir les erreurs et
    $errors = [];

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Adresse email invalide.';
    }

    // Validation du nom d'utilisateur
    if (!preg_match("/^[a-zA-Z0-9_]{3,20}$/", $username)) {
        $errors[] = 'Nom d\'utilisateur invalide.';
    }

    // Validation du mot de passe
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
        $errors[] = 'Le mot de passe doit contenir au moins 8 caractères, incluant une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.';
    }

    // Vérification des mots de passe
    if ($password !== $passwordConfirm) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    //hasher le mot de passe

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (email, username, passwords) VALUES (:email, :username, :password)";
        $stmt = $pdo->prepare($sql);

        $result = $stmt->execute(array(
            'email' => $email,
            'username' => $username,
            'password' => $hashed_password,
        ));

        if ($result) {
            $message = 'Inscription réussie!';
            header('Location: connexion.php');
            exit();
        } else {
            $message = 'Erreur lors de l\'inscription.';
        }
    } else {
        $message = implode('<br>', $errors);
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
    <title>INSCRIPTION</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body{
            margin: 0;
            padding: 0;
            background-color: green;
        }
        h2{
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 40px;
            text-align: center;
            color: green;
        }
        .div1{
            padding-bottom: 50px;
            padding-top: 30px;

            background-color: green;
            border-radius: 10px;
            align-items: center;


        }
        .container{
            max-width: 400px;
            margin: 100px auto;
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 30px;
            align-items: center;
            text-align: center;
            display: flex;
            flex-direction: column;
            color: green;
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
            border-radius: 10px;
            width: 80%;
            margin: 15px;
            height: 30px;
            border: 2px solid darkgray;
        }
        input::placeholder{
            font-weight: lighter;
            font-family: "Times New Roman";
            color: gray;
        }
        button{
            color: green;
            background-color: orange;
            border-radius: 50px;
            font-weight: bolder;
            cursor: pointer;
            border: none;
            padding: 10px 20px;
        }
        button:hover{
            background-color: gold;
            color: white;
        }

        p {
            color: red;
            font-weight: bold;
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
            border: white;


        }

    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg " style="background-color:orange; margin-bottom: 0">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SYGP</a>
        </div>
    </nav>
</header>

<div class="div1">


    <form action="inscription.php" method="POST">
        <div class="container">
            <h2>INSCRIPTION</h2>
            <?php if (!empty($message)): ?>
                <p style="color:red"><?= $message ?></p>
            <?php endif; ?>

            <label for="username">Nom d'utilisateur</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Ex: dupont3" required>
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Ex: dupontjean@gmail.com" required>
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password1" placeholder="Password" required>
            <label for="passwordConfirm">Confirm Password</label>
            <input type="password" class="form-control" name="passwordConfirm" id="passwordConfirm" placeholder="Confirm password" required >

            <button type="submit">S'inscrire</button>
            <div>

                <a href='connexion.php' class='btn btn-primary'>Connectez-Vous</a>
                <p style="color: forestgreen">Si Vous avez déja un compte </p>
                <?php

                echo "<a href='#' class='btn1 primary-success'>Continuer avec Google</a>";

                echo "<a href='#' class='btn1 primary-success'>Continuer avec Microsoft</a>";


                ?>

            </div>


        </div>


    </form>

    <p>  </p>
</div>
<script src="../assets/js/bootstrap.min.js" ></script>



</body>
</html>