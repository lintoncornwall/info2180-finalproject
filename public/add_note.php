<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $_POST['comment'];
    $contact_id = $_POST['contact_id'];
    $created_by = $_SESSION['user']['id'];

    $stmt = $pdo->prepare("
        INSERT INTO Notes (contact_id, comment, created_by)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$contact_id, $comment, $created_by]);

    header("Location: contact.php?id=" . $contact_id);
    exit;
}
