<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("config.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'], $_POST['email'], $_POST['telephone'], $_POST['password'], $_POST['passwordConfirm'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];

    $errors = [];

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Adresse email invalide.';
    }

    // Validation du numéro de téléphone
    if (!preg_match("/^\+?[0-9]{10,15}$/", $telephone)) {
        $errors[] = 'Numéro de téléphone invalide.';
    }

    // Validation du nom d'utilisateur
    if (!preg_match("/^[a-zA-Z0-9_]{3,20}$/", $username)) {
        $errors[] = 'Nom d\'utilisateur invalide.';
    }

    // Validation du mot de passe
    if (strlen($password) < 8) {
        $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
    }

    // Vérification des mots de passe
    if ($password !== $passwordConfirm) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO auth_systeme (email, username, password, telephone) VALUES (:email, :username, :password, :telephone)";
        $stmt = $pdo->prepare($sql);

        $result = $stmt->execute([
            'email' => $email,
            'username' => $username,
            'password' => $hashed_password,
            'telephone' => $telephone,
        ]);

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
