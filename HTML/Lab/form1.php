<?php require_once "form1_process.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create your workspace</title>
  <!-- ?v=2 forces the browser to reload the updated stylesheet instead of a cached copy -->
  <link rel="stylesheet" href="form1.css?v=2">
</head>

<body>
  <!-- novalidate turns off the browser's own checks so the PHP validation runs -->
  <form class="card" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
    <header class="card-header">
      <span class="badge">GET STARTED</span>
      <h1>Create your workspace</h1>
    </header>

    <div class="field">
      <label for="name">Full name</label>
      <input type="text" id="name" name="name" placeholder="Jane Doe" value="<?= $name ?>">
      <?php if ($nameErr): ?><span class="error"><?= $nameErr ?></span><?php endif; ?>
    </div>

    <div class="field">
      <label for="phone">Phone number</label>
      <input type="number" id="phone" name="phone" placeholder="5551234567" value="<?= $phone ?>">
      <?php if ($phoneErr): ?><span class="error"><?= $phoneErr ?></span><?php endif; ?>
    </div>

    <div class="field">
      <label for="dob">Date of birth</label>
      <input type="date" id="dob" name="dob" value="<?= $dob ?>">
      <?php if ($dobErr): ?><span class="error"><?= $dobErr ?></span><?php endif; ?>
    </div>

    <div class="field">
      <label for="email">Work email</label>
      <input type="email" id="email" name="email" placeholder="jane@company.com" value="<?= $email ?>">
      <?php if ($emailErr): ?><span class="error"><?= $emailErr ?></span><?php endif; ?>
    </div>

    <div class="field">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="At least 8 characters">
      <?php if ($passwordErr): ?><span class="error"><?= $passwordErr ?></span><?php endif; ?>
    </div>

    <div class="field checkbox-field">
      <label for="updates">
        <input type="checkbox" id="updates" name="updates" value="1" <?= $updates ? "checked" : "" ?>>
        Email me product updates and tips
      </label>
      <?php if ($updatesErr): ?><span class="error"><?= $updatesErr ?></span><?php endif; ?>
    </div>

    <div class="field checkbox-field">
      <label for="terms">
        <input type="checkbox" id="terms" name="terms" value="1" <?= $terms ? "checked" : "" ?>>
        I agree to the Terms & Privacy Policy
      </label>
      <?php if ($termsErr): ?><span class="error"><?= $termsErr ?></span><?php endif; ?>
    </div>

    <?php if ($dbErr): ?><span class="error"><?= $dbErr ?></span><?php endif; ?>

    <div class="buttons">
      <button type="submit" class="btn-primary">Create workspace</button>
      <button type="reset" class="btn-secondary">Reset</button>
    </div>
  </form>

  <?php if ($isValid): ?>
    <section class="card summary">
      <h2>Registration received</h2>
      <table class="result-table">
        <tr><td>Full Name</td><td><?= $name ?></td></tr>
        <tr><td>Phone Number</td><td><?= $phone ?></td></tr>
        <tr><td>Date of Birth</td><td><?= $dob ?></td></tr>
        <tr><td>Work Email</td><td><?= $email ?></td></tr>
        <tr><td>Product Updates</td><td><?= $updates ? "Yes" : "No" ?></td></tr>
        <tr><td>Terms & Policy</td><td><?= $terms ? "Agreed" : "Not Agreed" ?></td></tr>
      </table>
    </section>
  <?php endif; ?>
</body>

</html>