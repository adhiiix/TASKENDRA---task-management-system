<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskia</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <p class="heading"><b>Taskia</b></p>
        <div class="lists">
            <a href="dashboard.php" class="linka"><button class="hm"><h4>Panel</h4></button></a>
            <a href="tasks.php" class="linka"><button class="hm"><h4>Tasks</h4></button></a>
            <button class="hm"><h4>Members</h4></button>
            <a href="logout.php" class="linka"><button class="hm"><h4>Logout</h4></button></a>
        </div>
    </header>
    <main>
        <form class="addtasksL" method="POST" action="addtasks.php">
            <div class="descS">
                <div>
                    <label for="title">Task Title:</label><br>
                    <input type="text" name="title" id="title" required>
                </div><br>
                <div>
                    <label for="description">Description:</label><br>
                    <textarea name="description" id="description" rows="5" cols="33" required></textarea>
                </div><br>
                <div>
                    <label for="assignee">Assignee:</label><br>
                    <input type="text" name="assignee" id="assignee" required>
                </div><br>
                <div>
                    <label for="deadline">Deadline:</label><br>
                    <input type="date" name="deadline" id="deadline" required>
                </div><br>
                <div class="addB">
                    <button type="submit">Add Task</button>
                </div>
            </div>
        </form>
    </main>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $assignee = $_POST['assignee'];
    $deadline = $_POST['deadline'];

    // Insert task details into the database
    $stmt = $conn->prepare("INSERT INTO tasks (title, description, assignee, deadline) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $assignee, $deadline);

    if ($stmt->execute()) {
        echo "Task added successfully!";
        // Optionally redirect to tasks page after adding
        header("Location: tasks.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
