<?php
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
    $companyName = $_POST['CompanyName'];
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $phone = $_POST['Phone'];
    $password = password_hash($_POST['Password'], PASSWORD_DEFAULT); // Hashing the password for security

    // Prepare an SQL statement to insert the form data into the database
    $stmt = $conn->prepare("INSERT INTO comapanies (company_name, name, email, phone, password) VALUES (?, ?, ?, ?, ?)");

    // Check if the preparation was successful
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("sssss", $companyName, $name, $email, $phone, $password);

    // Execute the statement and check if it was successful
    if ($stmt->execute()) {
        // Redirect to login.html after successful insertion
        header("Location: login.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

