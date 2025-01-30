<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Gestion de projets</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        header {
            text-align: center;
            background-color: forestgreen;
            color: white;
            padding: 20px 10px;
        }

        h1{
            color:green;
        }


        .content-btn {
            text-align: center;
            margin-top: 30px;
        }

        .btn {
            margin: 10px;
            padding: 10px 20px;

            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            font-size: 1rem;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .description {
            text-align: center;
            margin: 30px auto;
            max-width: 600px;
            line-height: 1.6;
            font-size: 16px;
            font-familly3

        }

        footer {
            text-align: center;
            padding: 15px 10px;
            background-color: tan;
            font-size: 0.9rem;
            margin-top: 30px;
            border-top-right-radius: 5px;
            border-top-left-radius: 5px;
        }
        image-dash{
            width: 100vh;
            max-width: 100vh;
            background-size: cover;

        }
    </style>
</head>
<body>

    <header class="navbar1" >

        <nav class="navbar navbar-expand-lg " style="background-color:white; margin-bottom: 0">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" style="background-color: green; color:white;  border-radius:5px" href="#">SYGP</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Acceuil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">A propos</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Fonctionnalités
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>



                    </ul>
                    <form class="d-flex"  style="gap: 10px">

                            <a href="../auth/connexion.php" class="btn btn-success">Se Connecter</a>
                            <a href="../auth/inscription.php" class="btn btn-success">S'inscrire</a>


                    </form>
                    
                </div>
                
                
            </div>
        </nav>
    </header>


<div class="content-btn">
    <h1  >Bienvenue sur notre plateforme SYGP</h1>
    <h2>Facilitez la gestion de vos projets informatiques en toute simplicité</h2>

</div>
    <div class="description">
        <p>
            Optimisez la gestion de vos tâches, suivez les délais, collaborez avec votre équipe et recevez des notifications en temps réel. Notre application vous aide à centraliser toutes vos informations de projet au même endroit pour une productivité maximale.
        </p>
    </div>
<div class="image-dash">
    <h4 style="text-align: center; color: #0dcaf0">Voici la présentation du dashboard de notre application</h4>
    <img src="../assets/img/dashboard.png" alt="img">
</div>


<footer>
    <p>&copy; 2025 SYGP : Système deGestion de Projets - Tout droits réservées  </p>
</footer>


</body>
<script src="../assets/js/bootstrap.min.js" ></script>
</html>
