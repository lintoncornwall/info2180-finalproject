<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

// Admin-only access
requireAdmin();

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname  = trim($_POST['lastname'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $password  = $_POST['password'] ?? '';
    $role      = $_POST['role'] ?? 'Member';

    // validating
    if ($firstname === '') $errors[] = "First name is required.";
    if ($lastname === '')  $errors[] = "Last name is required.";
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }
    if ($password === '' || strlen($password) < 6) {
        $errors[] = "Password is required (min 6 characters).";
    }
    if (!in_array($role, ['Admin', 'Member'], true)) {
        $errors[] = "Invalid role selected.";
    }

    // Checking email 
    if (empty($errors)) {
        $check = $pdo->prepare("SELECT id FROM Users WHERE email = :email LIMIT 1");
        $check->execute(['email' => $email]);
        if ($check->fetch()) {
            $errors[] = "That email is already in use.";
        }
    }

    // Insert new user
    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            INSERT INTO Users (firstname, lastname, email, password, role)
            VALUES (:firstname, :lastname, :email, :password, :role)
        ");

        $stmt->execute([
            'firstname' => $firstname,
            'lastname'  => $lastname,
            'email'     => $email,
            'password'  => $hash,
            'role'      => $role
        ]);

        $success = "User created successfully.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add User</title>
  <link rel="stylesheet" href="../assets/crm.css">
</head>
<body>
  <h1>Add New User</h1>

  <p><a href="dashboard.php">Back to Dashboard</a> | <a href="logout.php">Logout</a></p>

  <?php if (!empty($errors)): ?>
    <div style="color: red;">
      <ul>
        <?php foreach ($errors as $e): ?>
          <li><?php echo htmlspecialchars($e); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?php if ($success): ?>
    <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
  <?php endif; ?>

  <form method="POST" action="add_user.php">
    <label>First Name</label><br>
    <input type="text" name="firstname" required><br><br>

    <label>Last Name</label><br>
    <input type="text" name="lastname" required><br><br>

    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <label>Role</label><br>
    <select name="role">
      <option value="Member">Member</option>
      <option value="Admin">Admin</option>
    </select><br><br>

    <button type="submit">Create User</button>
  </form>
</body>
</html>
