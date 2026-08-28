<?php require_once "dashboard_process.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Manager Dashboard</title>
    <link rel="stylesheet" href="dashboard.css?v=2">
</head>

<body>
    <div class="app-container">
        <aside class="sidebar">
            <div class="sidebar-brand">BUS SYSTEM</div>
            <ul class="nav-menu">
                <li class="nav-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a href="maintenance_requests.php">Maintenance Requests</a></li>
                <li class="nav-item"><a href="spare_parts.php">Spare Parts</a></li>
                <li class="nav-item"><a href="service_history.php">Service History</a></li>
                <li class="nav-item logout-link"><a href="logout.php">Logout</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="top-bar">
                <div class="page-title">
                    <h1>Maintenance Overview</h1>
                </div>
                <div class="user-info">
                    Logged in as: <strong><?= htmlspecialchars($manager_name); ?></strong>
                </div>
            </div>

            <?php if (mysqli_num_rows($service_due_result) > 0): ?>
                <div class="alert-box">
                    <strong>⚠️ Service Due Alert:</strong> One or more buses have exceeded their trip limit and require
                    servicing.
                </div>
            <?php endif; ?>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-title">Pending Requests</div>
                    <div class="stat-value"><?= mysqli_num_rows($pending_req_result); ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Low Stock Parts</div>
                    <div class="stat-value" style="color: #dc2626;"><?= mysqli_num_rows($low_stock_result); ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Service Alerts</div>
                    <div class="stat-value" style="color: #d97706;"><?= mysqli_num_rows($service_due_result); ?></div>
                </div>
            </div>

            <div class="content-card">
                <h2 class="card-title">Pending Maintenance Requests</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Req ID</th>
                            <th>Bus Number</th>
                            <th>Issue</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($pending_req_result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($pending_req_result)): ?>
                                <tr>
                                    <td>#<?= $row['request_id']; ?></td>
                                    <td><?= htmlspecialchars($row['bus_number']); ?></td>
                                    <td><?= htmlspecialchars($row['issue']); ?></td>
                                    <td><span class="badge-pending"><?= ucfirst($row['status']); ?></span></td>
                                    <td><?= $row['created_at']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: #94a3b8;">No pending maintenance requests
                                    found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="content-card">
                <h2 class="card-title">Low Stock Spare Parts</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Part ID</th>
                            <th>Part Name</th>
                            <th>Current Stock</th>
                            <th>Unit Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($low_stock_result) > 0): ?>
                            <?php while ($part = mysqli_fetch_assoc($low_stock_result)): ?>
                                <tr>
                                    <td>#<?= $part['part_id']; ?></td>
                                    <td><?= htmlspecialchars($part['part_name']); ?></td>
                                    <td class="text-danger"><?= $part['stock_quantity']; ?> left</td>
                                    <td>$<?= number_format($part['unit_price'], 2); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center; color: #94a3b8;">All spare parts are sufficiently
                                    stocked.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</body>

</html>