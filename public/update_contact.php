<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contactId = $_POST['contact_id'];
    $type = $_POST['type'];

    // Validation
    if (!in_array($type, ['Lead', 'Sales'])) {
        http_response_code(400);
        echo "Invalid contact type";
        exit;
    }

    $sql = "UPDATE Contacts
            SET type = :type, updated_at = NOW()
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':type' => $type,
        ':id'   => $contactId
    ]);

    echo "Contact type updated successfully";
}
 

