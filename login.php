<?php
session_start(); // Start the session

// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = "1234"; // Replace with your MySQL password
$dbname = "taskia";   // Replace with your database name

// Create connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    // Prepare an SQL statement to select the user's password and name using the provided email
    $stmt = $conn->prepare("SELECT password, name FROM comapanies WHERE email = ?");
    
    // Check if the preparation was successful
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if any user exists with the provided email
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword, $name);
        $stmt->fetch();

        // Verify the provided password against the hashed password
        if (password_verify($password, $hashedPassword)) {
            // Store the user's name and email in session variables
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;

            // Redirect to the dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that email.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
