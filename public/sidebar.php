<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<aside class="sidebar">
    <div class="sidebar-header">
        <h2> Dolphin CRM</h2>
    </div>

    <nav class="sidebar-nav">
        <a href="dashboard.php">Home</a>
        <a href="new-contact.php">New Contact</a>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'): ?>
            <a href="users.php">Users</a>
        <?php endif; ?>

        <a href="logout.php">Logout</a>
    </nav>
</aside>
