<?php require_once "service_history_process.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Service History</title>
  <link rel="stylesheet" href="service_history.css?v=1">
</head>

<body>
  <div class="app-container">
    <aside class="sidebar">
      <div class="sidebar-brand">BUS SYSTEM</div>
      <ul class="nav-menu">
        <li class="nav-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a href="maintenance_requests.php">Maintenance Requests</a></li>
        <li class="nav-item"><a href="spare_parts.php">Spare Parts</a></li>
        <li class="nav-item active"><a href="service_history.php">Service History</a></li>
        <li class="nav-item logout-link"><a href="logout.php">Logout</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <div class="top-bar">
        <div class="page-title">
          <h1>Bus Service History</h1>
        </div>
      </div>

      <div class="content-card">
        <h2 class="card-title">Record Bus Service</h2>

        <?php if (!empty($successMsg)): ?>
          <div class="msg-success"><?= htmlspecialchars($successMsg); ?></div>
        <?php endif; ?>

        <form action="service_history.php" method="POST">
          <input type="hidden" name="action" value="record_service">
          
          <div class="form-grid">
            <div class="form-group">
              <label for="bus_id">Select Bus</label>
              <select name="bus_id" id="bus_id" class="form-control">
                <option value="">-- Choose Bus --</option>
                <?php while ($bus = mysqli_fetch_assoc($buses_result)): ?>
                  <option value="<?= $bus['bus_id']; ?>" <?= ($bus_id == $bus['bus_id']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($bus['bus_number']) . " (" . htmlspecialchars($bus['name']) . ")"; ?>
                  </option>
                <?php endwhile; ?>
              </select>
              <?php if (!empty($busErr)): ?><div class="msg-error"><?= $busErr; ?></div><?php endif; ?>
            </div>

            <div class="form-group">
              <label for="cost">Service Cost ($)</label>
              <input type="number" step="0.01" name="cost" id="cost" class="form-control" placeholder="0.00" value="<?= htmlspecialchars($cost); ?>">
              <?php if (!empty($costErr)): ?><div class="msg-error"><?= $costErr; ?></div><?php endif; ?>
            </div>

            <div class="form-group">
              <label for="part_id">Used Spare Part (Optional)</label>
              <select name="part_id" id="part_id" class="form-control">
                <option value="">-- None --</option>
                <?php while ($part = mysqli_fetch_assoc($parts_result)): ?>
                  <option value="<?= $part['part_id']; ?>">
                    <?= htmlspecialchars($part['part_name']) . " (Stock: " . $part['stock_quantity'] . ")"; ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="part_quantity">Part Quantity Used</label>
              <input type="number" name="part_quantity" id="part_quantity" class="form-control" placeholder="0" min="0">
            </div>

            <div class="form-group full-width">
              <label for="service_type">Service Details / Work Done</label>
              <textarea name="service_type" id="service_type" class="form-control" rows="3" placeholder="e.g. Engine oil change, brake pad replacement..."><?= htmlspecialchars($service_type); ?></textarea>
              <?php if (!empty($serviceTypeErr)): ?><div class="msg-error"><?= $serviceTypeErr; ?></div><?php endif; ?>
            </div>
          </div>

          <button type="submit" class="btn-submit">Record Service</button>
        </form>
      </div>

      <div class="content-card">
        <h2 class="card-title">Completed Services Log</h2>
        <table class="data-table">
          <thead>
            <tr>
              <th>Service ID</th>
              <th>Bus Details</th>
              <th>Service Details</th>
              <th>Cost</th>
              <th>Service Date</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($history_result) > 0): ?>
              <?php while ($log = mysqli_fetch_assoc($history_result)): ?>
                <tr>
                  <td>#<?= $log['service_id']; ?></td>
                  <td><strong><?= htmlspecialchars($log['bus_number']); ?></strong><br><small><?= htmlspecialchars($log['bus_name']); ?></small></td>
                  <td><?= htmlspecialchars($log['service_type']); ?></td>
                  <td class="cost-tag">$<?= number_format($log['cost'], 2); ?></td>
                  <td><?= date('Y-m-d H:i', strtotime($log['service_date'])); ?></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="5" style="text-align: center; color: #94a3b8;">No service history records found.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </main>
  </div>
</body>

</html>