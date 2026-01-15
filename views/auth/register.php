<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
<div class="card">
<h2>Create Account</h2>

<form method="post">
    <input type="text" name="name" placeholder="Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Register</button>
</form>
</div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
