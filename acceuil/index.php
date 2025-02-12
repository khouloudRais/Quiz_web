<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="acceuil.css">
</head>
<body>
    <header>
        <h1>Quiz & Découverte!</h1>
    </header>
    
    <nav>
        <ul>
            <li><a href="#accueil">Accueil</a></li>
            <li><a href="#apropos">À propos</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#connexion" class="btn-connexion">Connexion</a></li>
        </ul>
    </nav>

    <div class="main-container">
        <div class="section">
        <img src="image/culture.webp" alt="Culture générale" class="section-image">
            <h2>Culture générale</h2>
            <p>Testez vos connaissances en culture générale avec cette catégorie.</p>
            <a href="culture.php" class="btn">Commencer</a>
            

        </div>

        <div class="section">
        <img src="image/sport.jpeg" alt="Sport" class="section-image">
            <h2>Sport</h2>
            <p>Défiez-vous dans cette catégorie de sport</p>
            <a href="sport.php" class="btn">Commencer</a>
           
        </div>

        <div class="section">
        <img src="image/histoire.jpg" alt="Histoire" class="section-image">
            <h2>Histoire</h2>
            <p>Testez vos connaissances en histoire</p>
            <a href="histoire.php" class="btn">Commencer</a>
          
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Quiz & Découverte. Tous droits réservés.</p>
    </footer>
</body>
</html>
