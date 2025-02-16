
<?php
// Définir la couleur d'arrière-plan de la bannière
$bgColor = "#416D9B";

// Contenu du texte de la bannière
$text = "Quiz & Découverte";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page avec Bannière et Boutons</title>
    <style>
        /* Style de la bannière */
        .banniere {
            background-color: <?php echo $bgColor; ?>;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-family: Arial, sans-serif;
            font-weight: bold;
        }

        /* Style général du corps de la page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f0f0f0;
        }

        /* Conteneur des boutons */
        .container {
            text-align: center;
            margin-top: 50px;
        }

        /* Style des boutons */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        /* Effet au survol des boutons */
        .btn:hover {
            background-color: #45a049;
            align-items: center;
        }
    </style>
</head>
<body>

    <!-- Bannière avec texte centré -->
    <div class="banniere">
        <?php echo $text; ?>
    </div>

    <!-- Conteneur pour les boutons -->
    <div class="container">
        <a href="ajouter.php" class="btn">Ajouter</a>
        <a href="modifier.php" class="btn">Modifier</a>
    </div>

</body>
</html>