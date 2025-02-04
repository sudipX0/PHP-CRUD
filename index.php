<?php
session_start();
include 'db.php';

$is_logged_in = isset($_SESSION['user_id']);

if ($is_logged_in) {
    $user_id = $_SESSION['user_id'];

    // Handle Task Addition
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_task'])) {
        $task = trim($_POST['task']);
        if (!empty($task)) {
            $stmt = $conn->prepare("INSERT INTO tasks (user_id, task) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $task);
            if ($stmt->execute()) {
                header("Location: index.php");  // Refresh the page to show the added task
                exit();
            }
            $stmt->close();
        }
    }

    // Handle Task Update (Edit)
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_task'])) {
        $task_id = $_POST['task_id'];
        $task = trim($_POST['task']);
        if (!empty($task)) {
            $stmt = $conn->prepare("UPDATE tasks SET task=? WHERE id=? AND user_id=?");
            $stmt->bind_param("sii", $task, $task_id, $user_id);
            $stmt->execute();
            $stmt->close();
            header("Location: index.php");
            exit();
        }
    }

    // Handle Task Deletion
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_task'])) {
        $task_id = $_POST['task_id'];
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id=? AND user_id=?");
        $stmt->bind_param("ii", $task_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch tasks
$tasks = [];
if ($is_logged_in) {
    $result = $conn->query("SELECT * FROM tasks WHERE user_id = $user_id");
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | My Website</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <?php include 'header.php'; ?>

    <div class="max-w-6xl mx-auto bg-white p-6 mt-6 rounded-xl shadow-lg flex-1 mb-20">
        <h1 class="text-3xl font-bold text-center text-indigo-600 mb-2">Welcome to MTM</h1>
        <p class="text-sm text-gray-500 text-center mb-8">Track your daily tasks and stay organized.</p>

        <?php if ($is_logged_in): ?>
            <!-- <h2 class="text-xl font-semibold text-gray-700 mb-4">Manage Your Tasks</h2> -->

            <!-- Task Addition Form -->
            <form method="POST" class="mb-4 flex items-center space-x-4">
                <input type="text" name="task" placeholder="Enter new task" class="p-2 w-full border border-gray-300 rounded-lg" required>
                <button type="submit" name="add_task" class="bg-indigo-500 text-white p-2 rounded-lg hover:bg-indigo-600 transition w-32 text-center">Add Task</button>
            </form>

            <ul class="space-y-4">
                <?php if (!empty($tasks)): ?>
                    <?php foreach ($tasks as $task): ?>
                        <li class="relative flex justify-between items-start bg-gray-50 p-4 rounded-lg shadow">
                            <form method="POST" style="display: inline;" class="flex items-center space-x-2 w-full">
                                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">

                                <!-- Show task text or input field for editing -->
                                <?php if (isset($_GET['edit']) && $_GET['edit'] == $task['id']): ?>
    <div class="flex w-full items-center">
        <input type="text" name="task" value="<?php echo htmlspecialchars($task['task']); ?>" class="p-2 w-full border border-gray-300 rounded-lg" required>
        <button type="submit" name="edit_task" class="bg-indigo-500 text-white p-2 rounded-lg hover:bg-indigo-600 transition w-32 text-center ml-4">Save</button>
        <button type="submit" name="delete_task" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition w-32 text-center ml-4" onclick="return confirm('Are you sure you want to delete this task?');">Delete</button>
    </div>
<?php else: ?>
    <span class="text-lg flex-grow"><?php echo htmlspecialchars($task['task']); ?></span>
    <a href="index.php?edit=<?php echo $task['id']; ?>" class="text-blue-500 hover:text-blue-700 ml-auto">
        <i class="fas fa-pencil-alt"></i>
    </a>
<?php endif; ?>

                            </form>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500">No tasks available. Add a new task!</p>
                <?php endif; ?>
            </ul>

            <?php else: ?>
    <!-- Show Image for Not Logged In Users -->
    <div class="text-center mb-6">
        <img src="images/home.png" alt="Welcome Image" class="mx-auto w-128 h-128">
    </div>

    <!-- Login / Sign Up Message -->
    <p class="text-gray-700 text-center">Please <a href="login.html" class="text-indigo-500 hover:text-indigo-700">Log In</a> or <a href="signup.html" class="text-indigo-500 hover:text-indigo-700">Sign Up</a> to manage tasks.</p>
<?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>
