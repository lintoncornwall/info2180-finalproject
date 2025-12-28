<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $title = $_POST['title'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $company = $_POST['company'];
        $type = $_POST['type'];
        $assigned_to = $_POST['assigned_to'];
        $created_by = $_SESSION['user']['id'];

        // ENUM validation for type
        $allowedTypes = ['Sales Lead', 'Support'];
        if (!in_array($type, $allowedTypes)) {
            die("Invalid contact type.");
        }

        $stmt = $pdo->prepare("
            INSERT INTO Contacts 
            (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by)
            VALUES 
            (:title, :firstname, :lastname, :email, :telephone, :company, :type, :assigned_to, :created_by)
        ");

        $stmt->execute([
            ':title' => $title,
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':email' => $email,
            ':telephone' => $telephone,
            ':company' => $company,
            ':type' => $type,
            ':assigned_to' => $assigned_to,
            ':created_by' => $created_by
        ]);

        // Redirect after successful insert
        header("Location: dashboard.php");
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Contact</title>
    <link rel="stylesheet" href="../assets/css/contact.css">
</head>
<body>

<h2>Add New Contact</h2>

<form method="POST" action="new_contact.php">

    <label>Title</label>
    <select name="title" required>
        <option value="">Select Title</option>
        <option value="Mr">Mr</option>
        <option value="Ms">Ms</option>
        <option value="Mrs">Mrs</option>
        <option value="Dr">Dr</option>
    </select>

    <label>First Name</label>
    <input type="text" name="firstname" required>

    <label>Last Name</label>
    <input type="text" name="lastname" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Telephone</label>
    <input type="text" name="telephone" required>

    <label>Company</label>
    <input type="text" name="company" required>

    <label>Type</label>
    <select name="type" required>
        <option value="">Select Type</option>
        <option value="Sales Lead">Sales Lead</option>
        <option value="Support">Support</option>
    </select>

    <label>Assigned To (User ID)</label>
    <input type="number" name="assigned_to" required>

    <button type="submit">Save</button>

</form>

</body>
</html>
