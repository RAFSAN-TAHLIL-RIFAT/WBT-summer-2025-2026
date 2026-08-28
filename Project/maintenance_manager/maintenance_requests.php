<?php require_once "maintenance_process.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Maintenance Requests</title>
  <link rel="stylesheet" href="maintenance.css?v=1">
</head>

<body>
  <div class="app-container">
    <aside class="sidebar">
      <div class="sidebar-brand">BUS SYSTEM</div>
      <ul class="nav-menu">
        <li class="nav-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="nav-item active"><a href="maintenance_requests.php">Maintenance Requests</a></li>
        <li class="nav-item"><a href="spare_parts.php">Spare Parts</a></li>
        <li class="nav-item"><a href="service_history.php">Service History</a></li>
        <li class="nav-item logout-link"><a href="logout.php">Logout</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <div class="top-bar">
        <div class="page-title">
          <h1>Maintenance Requests</h1>
        </div>
      </div>

      <div class="content-card">
        <h2 class="card-title">Create New Request</h2>

        <?php if (!empty($successMsg)): ?>
          <div class="msg-success"><?= htmlspecialchars($successMsg); ?></div>
        <?php endif; ?>

        <form action="maintenance_requests.php" method="POST">
          <input type="hidden" name="action" value="create_request">

          <div class="form-group">
            <label for="bus_id">Select Bus</label>
            <select name="bus_id" id="bus_id" class="form-control">
              <option value="">-- Choose a Bus --</option>
              <?php while ($bus = mysqli_fetch_assoc($buses_result)): ?>
                <option value="<?= $bus['bus_id']; ?>" <?= ($bus_id == $bus['bus_id']) ? 'selected' : ''; ?>>
                  <?= htmlspecialchars($bus['bus_number']) . " (" . htmlspecialchars($bus['name']) . ")"; ?>
                </option>
              <?php endwhile; ?>
            </select>
            <?php if (!empty($busErr)): ?>
              <div class="msg-error"><?= $busErr; ?></div><?php endif; ?>
          </div>

          <div class="form-group">
            <label for="issue">Issue Description</label>
            <textarea name="issue" id="issue" class="form-control" rows="3"
              placeholder="Describe the mechanical issue..."><?= htmlspecialchars($issue); ?></textarea>
            <?php if (!empty($issueErr)): ?>
              <div class="msg-error"><?= $issueErr; ?></div><?php endif; ?>
          </div>

          <button type="submit" class="btn-submit">Submit Request</button>
        </form>
      </div>

      <div class="content-card">
        <h2 class="card-title">All Maintenance Requests</h2>
        <table class="data-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Bus Details</th>
              <th>Issue Description</th>
              <th>Status</th>
              <th>Update Status</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($requests_result) > 0): ?>
              <?php while ($req = mysqli_fetch_assoc($requests_result)): ?>
                <tr>
                  <td>#<?= $req['request_id']; ?></td>
                  <td>
                    <strong><?= htmlspecialchars($req['bus_number']); ?></strong><br><small><?= htmlspecialchars($req['bus_name']); ?></small>
                  </td>
                  <td><?= htmlspecialchars($req['issue']); ?></td>
                  <td>
                    <span class="badge-status status-<?= $req['status']; ?>">
                      <?= str_replace('_', ' ', $req['status']); ?>
                    </span>
                  </td>
                  <td>
                    <select class="status-select" onchange="location = this.value;">
                      <option value="">Change...</option>
                      <option
                        value="maintenance_requests.php?action=update_status&id=<?= $req['request_id']; ?>&status=pending">
                        Pending</option>
                      <option
                        value="maintenance_requests.php?action=update_status&id=<?= $req['request_id']; ?>&status=in_progress">
                        In Progress</option>
                      <option
                        value="maintenance_requests.php?action=update_status&id=<?= $req['request_id']; ?>&status=done">Done
                      </option>
                      <option
                        value="maintenance_requests.php?action=update_status&id=<?= $req['request_id']; ?>&status=cancelled">
                        Cancelled</option>
                    </select>
                  </td>
                  <td><?= date('Y-m-d H:i', strtotime($req['created_at'])); ?></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" style="text-align: center; color: #94a3b8;">No maintenance requests found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </main>
  </div>
</body>

</html>