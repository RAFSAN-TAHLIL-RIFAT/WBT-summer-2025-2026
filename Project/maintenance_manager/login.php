<?php require_once "login_process.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manager Login</title>
  <link rel="stylesheet" href="login.css?v=1">
</head>

<body>
  <form class="card" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
    <header class="card-header">
      <span class="badge">MAINTENANCE MANAGER</span>
      <h1>Sign in to your account</h1>
    </header>

    <div class="field">
      <label for="email">Email address</label>
      <input type="email" id="email" name="email" placeholder="manager@company.com" value="<?= $email ?>">
      <?php if ($emailErr): ?><span class="error"><?= $emailErr ?></span><?php endif; ?>
    </div>

    <div class="field">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Enter your password">
      <?php if ($passwordErr): ?><span class="error"><?= $passwordErr ?></span><?php endif; ?>
    </div>

    <div class="field checkbox-field">
      <label for="remember">
        <input type="checkbox" id="remember" name="remember" value="1" <?= $remember ? "checked" : "" ?>>
        Remember me
      </label>
    </div>

    <?php if ($authErr): ?><span class="error global-error"><?= $authErr ?></span><?php endif; ?>

    <div class="buttons">
      <button type="submit" class="btn-primary">Login</button>
      <button type="reset" class="btn-secondary">Reset</button>
    </div>
  </form>
</body>

</html>