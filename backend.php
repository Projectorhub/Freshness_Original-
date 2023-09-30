<?php

// Connecting to the Database
$servername = "localhost";
$username = "root";
$password = "";
$database = "freshness";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Die if connection was not successful
if (!$conn) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
} else {
    echo "Connection was successful<br>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input
    $name = isset($_POST['name1']) ? mysqli_real_escape_string($conn, $_POST['name1']) : '';
    $email = isset($_POST['email1']) ? mysqli_real_escape_string($conn, $_POST['email1']) : '';
    $message = isset($_POST['message1']) ? mysqli_real_escape_string($conn, $_POST['message1']) : '';

    // Debugging statements
    echo "Name: $name<br>";
    echo "Email: $email<br>";
    echo "Message: $message<br>";

    // Check for empty values
    if (empty($name) || empty($email) || empty($message)) {
        die("Error: One or more fields are empty");
    }
}

// Use prepared statement to avoid SQL injection
$sql = "INSERT INTO `contect` (`Name`, `Email`, `Message`) VALUES (?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

// Bind parameters to the statement
mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);

// Execute the statement
if (mysqli_stmt_execute($stmt)) {
    echo "Record inserted successfully";
} else {
    echo "Error: " . mysqli_stmt_error($stmt);
}

// Close the statement
mysqli_stmt_close($stmt);

// Close the connection
mysqli_close($conn);

?>
