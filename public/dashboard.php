<?php
require_once __DIR__ . '/../includes/auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/crm.css">
</head>
<body>
    <h1>Dashboard</h1>
    <p>You are logged in as <?php echo htmlspecialchars($_SESSION['user']['firstname']); ?>.</p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>

