<?php include __DIR__ . '/../layout/header.php'; ?>

<h2 style="text-align:center;">Book List</h2>

<input type="text" id="searchBox" placeholder="Search book by name...">

<div id="bookContainer" class="book-grid">
  <?php foreach ($books as $b): ?>
    <div class="card book-card">
      <img src="assets/book.png" class="book-img" alt="Book">

      <h3><?= htmlspecialchars($b['title'] ?? '') ?></h3>
      <p><?= htmlspecialchars($b['author'] ?? '') ?></p>
      <p><strong>৳<?= htmlspecialchars($b['price'] ?? '') ?></strong></p>

      <form method="post" action="index.php?page=add_to_cart">
        <input type="hidden" name="book_id" value="<?= (int)($b['id'] ?? 0) ?>">
        <input type="hidden" name="title" value="<?= htmlspecialchars($b['title'] ?? '') ?>">
        <input type="hidden" name="price" value="<?= htmlspecialchars($b['price'] ?? '') ?>">
        <button type="submit">Add to Cart</button>
      </form>
    </div>
  <?php endforeach; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
