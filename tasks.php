<?php
session_start(); // Start the session

// Check if the user is logged in by checking if the name is set in the session
if (!isset($_SESSION['name'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.html");
    exit();
}

// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = "1234"; // Replace with your MySQL password
$dbname = "taskia"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the delete action if a task is being deleted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_task'])) {
    $task_id = $_POST['task_id'];

    // Prepare and execute the deletion query
    $delete_stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    if ($delete_stmt === false) {
        die("Error in delete statement preparation: " . $conn->error);
    }
    $delete_stmt->bind_param("i", $task_id);
    $delete_stmt->execute();
    $delete_stmt->close();
}

// Get the logged-in user's name from the session
$user_name = $_SESSION['name'];

// Fetch tasks assigned to the logged-in user
$stmt = $conn->prepare("SELECT id, title, description, assignee, deadline FROM tasks WHERE assignee = ?");
if ($stmt === false) {
    die("Error in select statement preparation: " . $conn->error);
}

$stmt->bind_param("s", $user_name);
$stmt->execute();
$stmt->bind_result($task_id, $task_title, $description, $assignee, $deadline);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskia - Tasks</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px 20px; /* Adjust padding for more space between columns */
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .delete-btn {
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: rgb(189, 189, 189);
        }
    </style>
</head>
<body>
<header>
        <p class="heading"><b>Taskia</b></p>
        <div class="lists">
            <a href="dashboard.php" class="linka"><button class="hm"><h4>Panel</h4></button></a>
            <button class="hm"><h4>Tasks</h4></button>
            <button class="hm"><h4>Members</h4></button>
            <a href="logout.php" class="linka"><button class="hm"><h4>Logout</h4></button></a>
        </div>
    </header><br>
    <main>
        <div class="tasksH">
            <p>Tasks</p>
            <a href="addtasks.php" class="linka"><button>Add</button></a>
        </div>
        <div class="tasksH">
            <table>
                <thead>
                    <tr>
                        <th>Task Title</th>
                        <th>Description</th>
                        <th>Assignee</th>
                        <th>Deadline</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($stmt->fetch()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task_title); ?></td>
                        <td><?php echo htmlspecialchars($description); ?></td>
                        <td><?php echo htmlspecialchars($assignee); ?></td>
                        <td><?php echo htmlspecialchars($deadline); ?></td>
                        <td>
                            <form method="POST" action="tasks.php">
                                <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
                                <button type="submit" name="delete_task" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
