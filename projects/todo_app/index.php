<?php
require 'config.php';

// Handle add task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_task'])) {
    $task = trim($_POST['task']);
    if ($task !== "") {
        $stmt = $conn->prepare("INSERT INTO tasks (task) VALUES (?)");
        $stmt->bind_param("s", $task);
        $stmt->execute();
        $stmt->close();
    }
}

// Handle mark task as completed
if (isset($_GET['complete'])) {
    $id = intval($_GET['complete']);
    $stmt = $conn->prepare("UPDATE tasks SET is_completed = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Handle delete task
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Fetch tasks
$result = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");
$tasks = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>📝 My To-Do List</h1>
    <form method="POST" class="add-task-form">
        <input type="text" name="task" placeholder="Enter a new task..." required>
        <button type="submit" name="add_task">Add Task</button>
    </form>
    <ul class="task-list">
        <?php foreach ($tasks as $task): ?>
            <li class="<?php echo $task['is_completed'] ? 'completed' : ''; ?>">
                <span><?php echo htmlspecialchars($task['task']); ?></span>
                <div class="actions">
                    <?php if (!$task['is_completed']): ?>
                        <a href="?complete=<?php echo $task['id']; ?>" class="complete-btn">✔️</a>
                    <?php endif; ?>
                    <a href="?delete=<?php echo $task['id']; ?>" class="delete-btn">❌</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>