<?php
// public/dashboard.php
global $pdo;
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../modules/auth.php';
require_once __DIR__ . '/../modules/access.php';

require_login(); // redirects to login if not logged in

// session is available now
$name = $_SESSION['name'] ?? 'User';
$role = $_SESSION['role_name'] ?? 'Guest';

// fetch some metrics for demo: total users and counts per role
$totalUsers = (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$stmt = $pdo->query('SELECT r.role_name, COUNT(u.id) AS cnt FROM roles r LEFT JOIN users u ON u.role_id = r.id GROUP BY r.id');
$roleCounts = $stmt->fetchAll();
$labels = [];
$values = [];
foreach ($roleCounts as $row) {
    $labels[] = $row['role_name'];
    $values[] = (int)$row['cnt'];
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Dashboard — <?=htmlspecialchars($role)?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="assets/css/styles.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>
<div class="app">
    <aside class="sidebar" id="sidebar">
        <div class="brand">Staff Portal</div>
        <div class="profile">
            <strong><?=htmlspecialchars($name)?></strong>
            <small><?=htmlspecialchars($role)?></small>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>

                <?php if ($role === 'Admin'): ?>
                    <li><a href="#manage">Manage Staff</a></li>
                    <li><a href="#reports">Reports</a></li>
                    <li><a href="#settings">Settings</a></li>
                <?php endif; ?>

                <?php if ($role === 'HR'): ?>
                    <li><a href="#employees">Employee Profiles</a></li>
                <?php endif; ?>

                <?php if ($role === 'Sales'): ?>
                    <li><a href="#clients">Clients</a></li>
                <?php endif; ?>

                <li><a href="logout.php" class="danger">Logout</a></li>
            </ul>
        </nav>
        <button class="sidebar-toggle" id="sidebarToggle">☰</button>
    </aside>

    <main class="main">
        <header class="topbar">
            <h2>Welcome, <?=htmlspecialchars($name)?> — <small><?=htmlspecialchars($role)?></small></h2>
        </header>

        <section class="grid">
            <div class="card card-sm">
                <h3>Total staff</h3>
                <p class="big"><?=$totalUsers?></p>
            </div>

            <div class="card card-sm">
                <h3>Your Role</h3>
                <p class="big"><?=htmlspecialchars($role)?></p>
            </div>

            <!-- role-specific quick actions -->
            <div class="card">
                <h3>Quick actions</h3>
                <div class="actions">
                    <?php if ($role === 'Admin'): ?>
                        <a class="btn" href="#manage">Create staff</a>
                        <a class="btn" href="#reports">Generate report</a>
                    <?php elseif ($role === 'HR'): ?>
                        <a class="btn" href="#employees">View employees</a>
                    <?php elseif ($role === 'Sales'): ?>
                        <a class="btn" href="#clients">View clients</a>
                    <?php else: ?>
                        <p>Contact admin for more permissions.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Chart card -->
            <div class="card">
                <h3>Users by role</h3>
                <canvas id="roleChart" width="400" height="180" data-labels='<?=json_encode($labels)?>' data-values='<?=json_encode($values)?>'></canvas>
            </div>
        </section>

        <footer class="footer">
            <small>Staff Portal — Demo • Secure sessions • RBAC example</small>
        </footer>
    </main>
</div>

<script src="assets/js/scripts.js"></script>
<script>
    // create chart from embedded data attributes
    (function(){
        const canvas = document.getElementById('roleChart');
        const labels = JSON.parse(canvas.dataset.labels);
        const values = JSON.parse(canvas.dataset.values);
        const ctx = canvas.getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Users',
                    data: values,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    })();
</script>
</body>
</html>

