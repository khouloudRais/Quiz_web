
<?php
session_start();
$host = 'localhost';
$dbname = 'quiz';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion: " . $e->getMessage();
    exit;
}

// Vérifier si l'ID du quiz est présent dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de quiz manquant. Veuillez sélectionner un quiz à modifier.");
}

$quiz_id = (int) $_GET['id']; // On s'assure que l'ID est un entier

// Récupérer les détails du quiz
$stmt = $pdo->prepare("SELECT * FROM quizzes WHERE id = :id");
$stmt->execute([':id' => $quiz_id]);
$quiz = $stmt->fetch();

if (!$quiz) {
    die("Quiz introuvable.");
}

// Récupérer les questions du quiz
$stmt = $pdo->prepare("SELECT * FROM questions WHERE quiz_id = :quiz_id");
$stmt->execute([':quiz_id' => $quiz_id]);
$questions = $stmt->fetchAll();

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quiz_title = $_POST['quiz_title'];
    $questions = $_POST['question']; // Les questions
    $answers = $_POST['answer']; // Les réponses "Vrai" ou "Faux"

    // Mise à jour du titre du quiz
    $stmt = $pdo->prepare("UPDATE quizzes SET title = :title WHERE id = :id");
    $stmt->execute([':title' => $quiz_title, ':id' => $quiz_id]);

    // Mise à jour des questions et réponses
    foreach ($questions as $index => $question) {
        if (!empty($question) && isset($answers[$index])) {
            $stmt = $pdo->prepare("UPDATE questions SET question_text = :question, answer = :answer WHERE id = :id");
            $stmt->execute([
                ':question' => $question,
                ':answer' => $answers[$index], // Réponse "Vrai" ou "Faux"
                ':id' => $questions[$index]['id']
            ]);
        }
    }

    echo "Le quiz a été mis à jour avec succès !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Quiz</title>
    <style>
        /* Centrage du formulaire */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f9;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"], select {
            width: 100%;
            padding: 8px;
            margin: 8px 0 16px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #416D9B;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #354e74;
        }

        .question-item {
            margin-bottom: 20px;
        }

        #add-question {
            background-color: #416D9B;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #add-question:hover {
            background-color: #354e74;
        }

        .question-item input[type="text"], .question-item select {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h1>Modifier le Quiz : <?= htmlspecialchars($quiz['title']) ?></h1>

        <label for="quiz_title">Titre du quiz :</label>
        <input type="text" name="quiz_title" id="quiz_title" value="<?= htmlspecialchars($quiz['title']) ?>" required><br><br>

        <div id="questions-container">
            <h3>Questions</h3>
            <?php foreach ($questions as $index => $question): ?>
                <div class="question-item">
                    <label for="question[]">Question <?= $index + 1 ?> :</label>
                    <input type="text" name="question[]" value="<?= htmlspecialchars($question['question_text']) ?>" required><br><br>

                    <label for="answer[]">Réponse :</label>
                    <select name="answer[]" required>
                        <option value="Vrai" <?= $question['answer'] === 'Vrai' ? 'selected' : '' ?>>Vrai</option>
                        <option value="Faux" <?= $question['answer'] === 'Faux' ? 'selected' : '' ?>>Faux</option>
                    </select><br><br>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="submit">Mettre à jour le quiz</button>
    </form>

  
</body>
</html>