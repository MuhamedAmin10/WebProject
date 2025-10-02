<?php
session_start();
require_once('includes/db.php'); // Adjust path if needed

// Check if the user is already logged in
if (isset($_SESSION['admin'])) {
    header("Location: admin/dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Query the database for the admin user
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    // Verify plain-text password (for testing only)
    if ($admin && $password === $admin['mot_de_passe']) {
        $_SESSION['admin'] = $admin['id'];
        header("Location: admin/dashboard.php");
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
    <link rel="stylesheet" href="assets/style.css"> 
</head>
<body>
<?php include('includes/header.php'); ?>

    <div class="login-container">
        <h2>Admin Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Admin Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>
    <?php include('includes/footer.php'); ?>
</body>
</html>
