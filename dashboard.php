<!-- dashboard.php - Dashboard -->
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

$username = $_SESSION['username'];
$query = "SELECT * FROM students WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    echo "<h1>Welcome, " . htmlspecialchars($user['name']) . "</h1>";
    echo "<p>Email: " . htmlspecialchars($user['email']) . "</p>";
    echo "<p>Course: " . htmlspecialchars($user['course']) . "</p>";
    echo "<p>Age: " . htmlspecialchars($user['age']) . "</p>";
    echo '<a href="logout.php">Logout</a>';
} else {
    echo "User not found.";
}
?>

