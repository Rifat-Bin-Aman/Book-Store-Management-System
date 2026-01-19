<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="card" style="max-width:520px;margin:20px auto;">
  <h2>Login</h2>

  <?php if (!empty($error)): ?>
    <div class="alert error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="post" data-validate="true" novalidate>
    <label>Email</label>
    <input type="email" name="email" placeholder="Email" data-rule="required email" required>

    <label style="margin-top:12px;">Password</label>
    <input type="password" name="password" placeholder="Password" data-rule="required min4" required>

    <button type="submit" style="margin-top:14px;">Login</button>
  </form>

  <p style="margin-top:12px;">
    New user? <a href="index.php?page=register">Create new account</a>
  </p>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
