<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="card" style="max-width:560px;margin:20px auto;">
  <h2>Create Account (Customer)</h2>

  <?php if (!empty($errors)): ?>
    <div class="alert error">
      <ul style="margin:0;padding-left:18px;">
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" data-validate="true" novalidate>
    <label>Name</label>
    <input type="text" name="name" placeholder="Name" data-rule="required" required>

    <label style="margin-top:12px;">Email</label>
    <input type="email" name="email" placeholder="Email" data-rule="required email" required>

    <label style="margin-top:12px;">Password</label>
    <input type="password" name="password" placeholder="Password" data-rule="required min4" required>

    <button type="submit" style="margin-top:14px;">Register</button>
  </form>

  <p style="margin-top:12px;">
    Already have an account? <a href="index.php?page=login">Login</a>
  </p>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
