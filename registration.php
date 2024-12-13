<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // Stored as plain text (not recommended)
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    $age = intval($_POST['age']);

    // Validate inputs
    if (empty($username) || empty($password) || empty($name) || empty($email) || empty($course) || $age <= 0) {
        echo "All fields are required and must be valid.";
    } else {
        // Check for duplicate username
        $checkQuery = "SELECT COUNT(*) FROM students WHERE username = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            echo "Username already exists. Try another.";
        } else {
            // Insert the new user
            $insertQuery = "INSERT INTO students (username, password, name, email, course, age) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param('sssssi', $username, $password, $name, $email, $course, $age);

            if ($stmt->execute()) {
                echo "Registration successful.";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <h2>Student Registration form with session</h1>
    <form method="POST">
        <label>Username: <input type="text" name="username" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <label>Name: <input type="text" name="name" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Course: <input type="text" name="course" required></label><br>
        <label>Age: <input type="number" name="age" required></label><br>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</body>
</html>

