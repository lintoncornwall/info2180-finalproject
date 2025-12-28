<?php
session_start();
require_once 'db.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] !== 'Admin') {
    header("Location: dashboard.php");
    exit;
}


$stmt = $pdo->query("
    SELECT firstname, lastname, email, role, created_at
    FROM users
    ORDER BY created_at DESC
");

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users | Dolphin CRM</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <h1>Users</h1>
        <a href="add-user.php" class="btn-primary">+ Add User</a>
    </div>

    <table class="users-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></td>
                    <td><?= htmlspecialchars($user['email']); ?></td>
                    <td><?= htmlspecialchars($user['role']); ?></td>
                    <td><?= htmlspecialchars($user['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

</body>
</html>
