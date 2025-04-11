<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "spasignup";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connection successful";
}


function cleanInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}


$fullname = cleanInput($_POST['fullname']);
$email = cleanInput($_POST['email']);
$gender = cleanInput($_POST['gender']);
$location = cleanInput($_POST['location']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm-password'];

if ($password !== $confirm_password) {
    die("Passwords do not match.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}


$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("SELECT id FROM customers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    die("This email is already registered.");
}
$stmt->close();


$stmt = $conn->prepare("INSERT INTO customers (fullname, email, gender, location, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $fullname, $email, $gender, $location, $hashedPassword);

if ($stmt->execute()) {
    echo "<h2>Signup successful!</h2><p><a href='index.html'>Go back</a></p>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
