<?php
include ("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['todo'])) {
    if (isset($_POST['editId']) && $_POST['editId'] != "") {

        $sql = "UPDATE todos SET todo = :todo WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['todo' => $_POST['todo'], 'id' => $_POST['editId']]);
    } else {

        $sql = "INSERT INTO todos (todo, status) VALUES (:todo, 0)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['todo' => $_POST['todo']]);
    }
    header("Location: " . $_SERVER['PHP_SELF']);
}


if (isset($_GET['delete'])) {
    $sql = "DELETE FROM todos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $_GET['delete']]);
    header("Location: " . $_SERVER['PHP_SELF']);
}


if (isset($_GET['toggle'])) {
    $sql = "UPDATE todos SET status = NOT status WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $_GET['toggle']]);
    header("Location: " . $_SERVER['PHP_SELF']);
}


$sql = "SELECT * FROM todos";
$stmt = $pdo->query($sql);
$todos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            vertical-align: middle;
        }

        .task-column {
            width: 80%;
        }

        .done {
            text-decoration: line-through;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: calc(100% - 90px);
            padding: 8px;
            margin-right: 10px;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .delete-button {
            color: #dc3545;
        }

        .edit-button {
            color: #ffc107;
        }

        .toggle-button {
            color: #28a745;
        }

        td.actions {
            text-align: center;
        }

        td.actions a {
            margin: 0 5px;
        }

        .toggle-button,
        .completed-button {
            color: #28a745;
        }

        .completed-button {
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>My Todo's</h1>
        <form method="POST">
            <input type="text" name="todo" required placeholder="Add task..." />
            <button type="submit">Add</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th class="task-column">Task</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($todos as $todo): ?>
                    <tr>
                        <td class="<?= $todo['status'] ? 'done' : '' ?>"><?= htmlspecialchars($todo['todo']) ?></td>
                        <td class="actions">
                            <?php if ($todo['status']): ?>
                                <a href="?toggle=<?= $todo['id'] ?>" class="completed-button"><i class="fas fa-undo"></i></a>
                                <a href="?delete=<?= $todo['id'] ?>" class="delete-button"><i class="fas fa-trash-alt"></i></a>
                            <?php else: ?>
                                <a href="?toggle=<?= $todo['id'] ?>" class="toggle-button"><i
                                        class="fas fa-check-circle"></i></a>
                                <a href="edit.php?id=<?= $todo['id'] ?>" class="edit-button"><i class="fas fa-edit"></i></a>
                                <a href="?delete=<?= $todo['id'] ?>" class="delete-button"><i class="fas fa-trash-alt"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>