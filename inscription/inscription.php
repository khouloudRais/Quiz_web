<?php
class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "utilisateurs";
    public $conn;

    // Connexion à la base de données
    public function connect() {
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }
    }
}


require_once 'Database.php';

class Utilisateur {
    private $username;
    private $email;
    private $password;
    private $confirm_password;
    private $db;

    public function __construct($username, $email, $password, $confirm_password) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->confirm_password = $confirm_password;
        $this->db = new Database();
    }

    // Vérifier si les mots de passe correspondent
    public function validerMotDePasse() {
        return $this->password === $this->confirm_password;
    }

    // Hacher le mot de passe
    public function hashPassword() {
        return password_hash($this->password, PASSWORD_DEFAULT);
    }

    // Enregistrer l'utilisateur dans la base de données
    public function enregistrer() {
        if ($this->validerMotDePasse()) {
            $hashed_password = $this->hashPassword();
            $conn = $this->db->connect();

            // Préparer la requête d'insertion
            $stmt = $conn->prepare("INSERT INTO utilisateurs (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $hashed_password);

            // Exécuter la requête
            if ($stmt->execute()) {
                return "Inscription réussie !";
            } else {
                return "Erreur lors de l'inscription.";
            }
        } else {
            return "Les mots de passe ne correspondent pas.";
        }
    }
}

require_once 'Database.php';

class Utilisateur {
    private $username;r
    private $email;
    private $password;
    private $confirm_password;
    private $db;

    public function __construct($username, $email, $password, $confirm_password) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->confirm_password = $confirm_password;
        $this->db = new Database();
    }

    // Vérifier si les mots de passe correspondent
    public function validerMotDePasse() {
        return $this->password === $this->confirm_password;
    }

    // Hacher le mot de passe
    public function hashPassword() {
        return password_hash($this->password, PASSWORD_DEFAULT);
    }

    // Enregistrer l'utilisateur dans la base de données
    public function enregistrer() {
        if ($this->validerMotDePasse()) {
            $hashed_password = $this->hashPassword();
            $conn = $this->db->connect();

            // Préparer la requête d'insertion
            $stmt = $conn->prepare("INSERT INTO utilisateurs (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $hashed_password);

            // Exécuter la requête
            if ($stmt->execute()) {
                return "Inscription réussie !";
            } else {
                return "Erreur lors de l'inscription.";
            }
        } else {
            return "Les mots de passe ne correspondent pas.";
        }
    }
}
?>








<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Connexion</title>
</head>
<body>

    <h2>inscription</h2>
    <form action="#" method="POST">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="confirm_password">Confirmer le mot de passe :</label>
    <input type="password" id="confirm_password" name="confirm_password" required><br><br>

    <input type="submit" value="S'inscrire">
</form>


</body>
</html>
