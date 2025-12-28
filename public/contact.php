<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

$contact_id = $_GET['id'] ?? null;

if (!$contact_id) {
    die("Contact not found.");
}

// Fetch contact
$stmt = $pdo->prepare("
    SELECT c.*, 
           u.firstname AS assigned_firstname,
           u.lastname AS assigned_lastname,
           creator.firstname AS creator_firstname,
           creator.lastname AS creator_lastname
    FROM Contacts c
    JOIN Users u ON c.assigned_to = u.id
    JOIN Users creator ON c.created_by = creator.id
    WHERE c.id = ?
");
$stmt->execute([$contact_id]);
$contact = $stmt->fetch();

if (!$contact) {
    die("Contact not found.");
}

// Fetch notes
$notesStmt = $pdo->prepare("
    SELECT n.*, u.firstname, u.lastname
    FROM Notes n
    JOIN Users u ON n.created_by = u.id
    WHERE n.contact_id = ?
    ORDER BY n.created_at DESC
");
$notesStmt->execute([$contact_id]);
$notes = $notesStmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Details</title>
    <link rel="stylesheet" href="../assets/css/contact.css">
</head>
<body>

<h2><?= htmlspecialchars($contact['title']) ?> <?= htmlspecialchars($contact['firstname']) ?> <?= htmlspecialchars($contact['lastname']) ?></h2>

<p>
    Created on <?= date('F j, Y', strtotime($contact['created_at'])) ?>
    by <?= htmlspecialchars($contact['creator_firstname'] . ' ' . $contact['creator_lastname']) ?>
</p>

<p>
    Updated on <?= date('F j, Y', strtotime($contact['updated_at'])) ?>
</p>

<div class="contact-details">
    <p><strong>Email:</strong> <?= htmlspecialchars($contact['email']) ?></p>
    <p><strong>Telephone:</strong> <?= htmlspecialchars($contact['telephone']) ?></p>
    <p><strong>Company:</strong> <?= htmlspecialchars($contact['company']) ?></p>
    <p><strong>Assigned To:</strong> <?= htmlspecialchars($contact['assigned_firstname'] . ' ' . $contact['assigned_lastname']) ?></p>
</div>

<div class="actions">
    <button>Assign to me</button>
    <button>Switch to <?= $contact['type'] === 'Sales Lead' ? 'Support' : 'Sales Lead' ?></button>
</div>

<hr>

<h3>Notes</h3>

<?php foreach ($notes as $note): ?>
    <div class="note">
        <strong><?= htmlspecialchars($note['firstname'] . ' ' . $note['lastname']) ?></strong>
        <p><?= htmlspecialchars($note['comment']) ?></p>
        <small><?= date('F j, Y \a\t g:ia', strtotime($note['created_at'])) ?></small>
    </div>
<?php endforeach; ?>

<hr>

<h3>Add a note about <?= htmlspecialchars($contact['firstname']) ?></h3>

<form method="POST" action="add_note.php">
    <textarea name="comment" required></textarea>
    <input type="hidden" name="contact_id" value="<?= $contact_id ?>">
    <button type="submit">Add Note</button>
</form>

</body>
</html>
