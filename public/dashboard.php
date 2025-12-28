<?php
require_once __DIR__ . '/../includes/auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dolphin CRM - Dashboard</title>
  <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

<div class="layout">

  <!-- Sidebar -->
  <aside class="sidebar">
    <h2>Dolphin CRM</h2>
    <ul>
      <li class="active"><a href="dashboard.php">Home</a></li>
      <li><a href="new_contact.php">New Contact</a></li>

      <?php if (isAdmin()): ?>
        <li><a href="users.php">Users</a></li>
      <?php endif; ?>

      <li class="logout"><a href="logout.php">Logout</a></li>
    </ul>
  </aside>

  <!-- Main -->
  <main class="content">

    <header class="top-bar">
      <h1>Dashboard</h1>
      <span class="welcome">
        Logged in as <?php echo htmlspecialchars($_SESSION['user']['firstname']); ?>
      </span>
      <button class="add-btn">+ Add Contact</button>
    </header>

    <div class="filter-bar">
      <span>Filter By:</span>
      <button class="active">All</button>
      <button>Sales Leads</button>
      <button>Support</button>
      <button>Assigned to me</button>
    </div>

    <section class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Company</th>
            <th>Type</th>
            <th></th>
          </tr>
        </thead>
        <tbody>

          <!-- Static placeholder rows for now -->
          <tr>
            <td>Mr. Michael Scott</td>
            <td>michael.scott@paper.co</td>
            <td>The Paper Company</td>
            <td><span class="badge sales">SALES LEAD</span></td>
            <td><a href="#">View</a></td>
          </tr>

          <tr>
            <td>Mr. Dwight Schrute</td>
            <td>dwight@paper.co</td>
            <td>The Paper Company</td>
            <td><span class="badge support">SUPPORT</span></td>
            <td><a href="#">View</a></td>
          </tr>

          <tr>
            <td>Ms. Pam Beesley</td>
            <td>pam@dunder.co</td>
            <td>Dunder Mifflin</td>
            <td><span class="badge sales">SALES LEAD</span></td>
            <td><a href="#">View</a></td>
          </tr>

        </tbody>
      </table>
    </section>

  </main>
</div>

<script src="../assets/js/dashboard.js"></script>
</body>
</html>
