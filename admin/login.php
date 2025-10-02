<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once('../includes/db.php'); // make sure this path is correct

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit();
}

// Handle login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Look for admin in DB
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    // For plain text password (testing only)
    if ($admin && $password === $admin['mot_de_passe']) {
        $_SESSION['admin'] = $admin['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="admin-container">
        <h2>Admin Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Admin Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        <a href="../index.html" class="btn" style="margin-top: 15px; display: inline-block;">← Back to Home</a>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>
</body>
</html>
