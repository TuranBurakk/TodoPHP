<?php
include("config.php");

$todoId = $_GET['id'] ?? null;
if (!$todoId) {
    header('Location: index.php');
    exit;
}

$sql = "SELECT * FROM todos WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $todoId]);
$todo = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedTodo = $_POST['todo'];
    $sql = "UPDATE todos SET todo = :todo WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['todo' => $updatedTodo, 'id' => $todoId]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Todo Düzenle</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], button {
            width: 100%;
            padding: 8px;
            margin-top: 10px;
            box-sizing: border-box;
        }
        button {
            cursor: pointer;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Todo Edit</h1>
        <form method="POST">
            <input type="text" name="todo" value="<?= htmlspecialchars($todo['todo']) ?>" required>
            <button type="submit">Edit</button>
        </form>
    </div>
</body>
</html>
