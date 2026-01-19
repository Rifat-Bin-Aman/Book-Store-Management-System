<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <div class="card">
        <h2>Order History</h2>

        <?php if (empty($orders)): ?>
            <p>No orders found.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Book Title</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Line Total</th>
                        <th>Shipping Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                        <tr>
                            <td><?= htmlspecialchars($o['order_date']) ?></td>
                            <td><?= htmlspecialchars($o['book_title']) ?></td>
                            <td>1</td>
                            <td>৳<?= number_format($o['subtotal'], 2) ?></td>
                            <td>৳<?= number_format($o['subtotal'], 2) ?></td>
                            <td><?= htmlspecialchars($o['shipping_address']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
