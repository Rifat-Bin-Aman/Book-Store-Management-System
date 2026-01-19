<?php include __DIR__ . '/../layout/header.php'; ?>

<h2>Your Cart</h2>

<?php if (empty($cart)): ?>
  <p>Your cart is empty.</p>
<?php else: ?>

  <?php foreach ($cart as $index => $item): ?>
    <div class="card" style="display:flex; justify-content:space-between; align-items:center;">
      <div>
        <strong><?= htmlspecialchars($item['title'] ?? '') ?></strong><br>
        Price: ৳<?= htmlspecialchars($item['price'] ?? '') ?>
      </div>

      <form method="post" action="index.php?page=remove_from_cart">
        <input type="hidden" name="index" value="<?= (int)$index ?>">
        <button type="submit" class="btn danger">Remove</button>
      </form>
    </div>
  <?php endforeach; ?>

  <div class="card">
    <p>Subtotal: ৳<?= htmlspecialchars($subtotal) ?></p>
    <p>Shipping Cost: ৳<?= htmlspecialchars($shipping) ?></p>
    <p>VAT (2%): ৳<?= number_format($vat, 2) ?></p>
    <hr>
    <h3>Total Bill: ৳<?= number_format($grandTotal, 2) ?></h3>
  </div>

  <div class="card" style="max-width:760px;">
    <h3>Confirm Order</h3>
    <form method="post" action="index.php?page=confirm_order" data-validate="true" novalidate>
      <label>Shipping Address</label>
      <textarea name="address" placeholder="Enter shipping address" data-rule="required" required><?= htmlspecialchars($addr['address'] ?? '') ?></textarea>
      <button type="submit" style="margin-top:14px;">Confirm Order</button>
    </form>
    <p class="muted" style="margin-top:10px;">You can also save a default address from <a href="index.php?page=address">Shipping Address</a>.</p>
  </div>

<?php endif; ?>

<?php include __DIR__ . '/../layout/footer.php'; ?>
