<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

header('Content-Type: application/json');

// Optional filter
$filter = $_GET['filter'] ?? 'all';

try {
    $sql = "
        SELECT 
            id,
            title,
            firstname,
            lastname,
            email,
            company,
            type
        FROM Contacts
    ";

    $params = [];

    if ($filter === 'sales') {
        $sql .= " WHERE type = ?";
        $params[] = 'Sales Lead';
    } elseif ($filter === 'support') {
        $sql .= " WHERE type = ?";
        $params[] = 'Support';
    } elseif ($filter === 'assigned') {
        $sql .= " WHERE assigned_to = ?";
        $params[] = $_SESSION['user']['id'];
    }

    $sql .= " ORDER BY created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $contacts = $stmt->fetchAll();

    echo json_encode($contacts);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Failed to load contacts'
    ]);
}
