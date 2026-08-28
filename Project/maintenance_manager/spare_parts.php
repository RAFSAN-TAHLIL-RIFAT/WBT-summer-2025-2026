<?php require_once "spare_parts_process.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Spare Parts Inventory</title>
  <link rel="stylesheet" href="spare_parts.css?v=1">
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
          <h1>Spare Parts Inventory</h1>
        </div>
      </div>

      <div class="content-card">
        <h2 class="card-title">Add New Spare Part</h2>

        <?php if (!empty($successMsg)): ?>
          <div class="msg-success"><?= htmlspecialchars($successMsg); ?></div>
        <?php endif; ?>

        <form action="spare_parts.php" method="POST">
          <input type="hidden" name="action" value="create_part">

          <div class="form-grid">
            <div class="form-group">
              <label for="part_name">Part Name</label>
              <input type="text" name="part_name" id="part_name" class="form-control" placeholder="e.g. Brake Pad"
                value="<?= htmlspecialchars($part_name); ?>">
              <?php if (!empty($partNameErr)): ?>
                <div class="msg-error"><?= $partNameErr; ?></div><?php endif; ?>
            </div>

            <div class="form-group">
              <label for="stock_quantity">Stock Quantity</label>
              <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" placeholder="0"
                min="0" value="<?= htmlspecialchars($stock_quantity); ?>">
              <?php if (!empty($stockErr)): ?>
                <div class="msg-error"><?= $stockErr; ?></div><?php endif; ?>
            </div>

            <div class="form-group">
              <label for="unit_price">Unit Price ($)</label>
              <input type="number" step="0.01" name="unit_price" id="unit_price" class="form-control" placeholder="0.00"
                min="0" value="<?= htmlspecialchars($unit_price); ?>">
              <?php if (!empty($priceErr)): ?>
                <div class="msg-error"><?= $priceErr; ?></div><?php endif; ?>
            </div>
          </div>

          <button type="submit" class="btn-submit">Add Part to Inventory</button>
        </form>
      </div>

      <div class="content-card">
        <h2 class="card-title">Inventory Stock List</h2>
        <table class="data-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Part Name</th>
              <th>Unit Price</th>
              <th>Current Stock</th>
              <th>Update Stock</th>
              <th>Last Updated</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($parts_result) > 0): ?>
              <?php while ($part = mysqli_fetch_assoc($parts_result)): ?>
                <tr>
                  <td>#<?= $part['part_id']; ?></td>
                  <td><strong><?= htmlspecialchars($part['part_name']); ?></strong></td>
                  <td>$<?= number_format($part['unit_price'], 2); ?></td>
                  <td>
                    <?php if ($part['stock_quantity'] < 5): ?>
                      <span class="badge-low-stock"><?= $part['stock_quantity']; ?> (Low)</span>
                    <?php else: ?>
                      <span class="badge-in-stock"><?= $part['stock_quantity']; ?> units</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <form action="spare_parts.php" method="POST" class="stock-update-form">
                      <input type="hidden" name="action" value="update_stock">
                      <input type="hidden" name="part_id" value="<?= $part['part_id']; ?>">
                      <input type="number" name="new_stock" class="input-stock" value="<?= $part['stock_quantity']; ?>"
                        min="0">
                      <button type="submit" class="btn-update">Save</button>
                    </form>
                  </td>
                  <td><?= date('Y-m-d H:i', strtotime($part['updated_at'])); ?></td>
                  <td>
                    <a href="spare_parts.php?action=delete&id=<?= $part['part_id']; ?>" class="btn-delete"
                      onclick="return confirm('Are you sure you want to delete this part?');">Delete</a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" style="text-align: center; color: #94a3b8;">No spare parts found in inventory.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </main>
  </div>
</body>

</html>