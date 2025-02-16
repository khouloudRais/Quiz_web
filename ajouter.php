<?php
session_start();

// Configuration de la base de données
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

// Classe pour gérer l'ajout d'un quiz
class Quiz
{
    private $pdo;
    private $title;
    private $questions;
    private $answers;

    public function __construct($pdo, $title, $questions, $answers)
    {
        $this->pdo = $pdo;
        $this->title = $title;
        $this->questions = $questions;
        $this->answers = $answers;
    }

    public function ajouterQuiz()
    {
        // Insertion du quiz dans la base de données
        $stmt = $this->pdo->prepare("INSERT INTO quizzes (title) VALUES (:title)");
        $stmt->execute([':title' => $this->title]);
        $quiz_id = $this->pdo->lastInsertId(); // Récupérer l'ID du dernier quiz inséré

        // Ajout des questions et réponses
        foreach ($this->questions as $index => $question) {
            if (!empty($question) && isset($this->answers[$index])) {
                $stmt = $this->pdo->prepare("INSERT INTO questions (quiz_id, question_text, answer) VALUES (:quiz_id, :question, :answer)");
                $stmt->execute([
                    ':quiz_id' => $quiz_id,
                    ':question' => $question,
                    ':answer' => $this->answers[$index]
                ]);
            }
        }
        return "Le quiz a été ajouté avec succès !";
    }
}

// Traitement du formulaire d'ajout de quiz
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quiz_title'])) {
    $quiz_title = $_POST['quiz_title'];
    $questions = $_POST['question']; // Les questions
    $answers = $_POST['answer']; // Les réponses (Vrai ou Faux)

    // Créer une instance de la classe Quiz et ajouter le quiz
    $quiz = new Quiz($pdo, $quiz_title, $questions, $answers);
    $message = $quiz->ajouterQuiz();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Quiz</title>
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
        <h1>Ajouter un nouveau quiz</h1>

        <label for="quiz_title">Titre du quiz :</label>
        <input type="text" name="quiz_title" id="quiz_title" required><br><br>

        <div id="questions-container">
            <h3>Questions</h3>
            <div class="question-item">
                <label for="question[]">Question 1 :</label>
                <input type="text" name="question[]" required><br><br>
                <label for="answer[]">Réponse :</label>
                <select name="answer[]" required>
                    <option value="Vrai">Vrai</option>
                    <option value="Faux">Faux</option>
                </select><br><br>
            </div>
        </div>

        <button type="button" id="add-question">Ajouter une question</button><br><br>

        <button type="submit">Ajouter le quiz</button>

        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    </form>

    <script>
        // Ajout dynamique de questions
        document.getElementById('add-question').addEventListener('click', function() {
            const container = document.getElementById('questions-container');
            const questionCount = container.getElementsByClassName('question-item').length + 1;
            const questionItem = document.createElement('div');
            questionItem.classList.add('question-item');
            questionItem.innerHTML = ` 
                <label for="question[]">Question ${questionCount} :</label>
                <input type="text" name="question[]" required><br><br>
                <label for="answer[]">Réponse :</label>
                <select name="answer[]" required>
                    <option value="Vrai">Vrai</option>
                    <option value="Faux">Faux</option>
                </select><br><br>
            `;
            container.appendChild(questionItem);
        });
    </script>
</body>
</html>