
<!DOCTYPE html>

<?php
session_start(); // Start the session

// Check if the user is logged in by checking if the name is set in the session
if (!isset($_SESSION['name'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.html");
    exit();
}
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskia - Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <p class="heading"><b>Taskia</b></p>
        <div class="lists">
            <button class="hm"><h4>Panel</h4></button>
            <a href="tasks.php" class="linka"><button class="hm"><h4>Tasks</h4></button></a>
            <button class="hm"><h4>Members</h4></button>
            <a href="logout.php" class="linka"><button class="hm"><h4>Logout</h4></button></a>
        </div>
    </header>
    <main>
        <div class="dashboardL">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> to your dashboard</h2>
            <p>Check your daily tasks and happy working</p>
        </div>
        <div class="dashboardL">
            
        </div>
    </main>
    <script src="main.js"></script>
</body>
</html>
