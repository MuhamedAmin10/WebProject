<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require_once('../includes/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM produits WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: dashboard.php");
exit;
?>
