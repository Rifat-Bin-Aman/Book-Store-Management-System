<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="card" style="max-width:720px;margin:10px auto;">
  <h3>Shipping Address</h3>

  <?php if (!empty($success)): ?>
    <div class="alert success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <form method="post" data-validate="true" novalidate>
    <label>Address</label>
    <textarea name="address" placeholder="Enter your full shipping address" data-rule="required" required><?= htmlspecialchars($addr['address'] ?? '') ?></textarea>

    <button type="submit" style="margin-top:14px;">Save Address</button>
  </form>

  <p class="muted" style="margin-top:10px;">
    Tip: When you confirm an order from your cart, this address will be used.
  </p>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
