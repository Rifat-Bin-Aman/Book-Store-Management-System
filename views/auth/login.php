<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
<div class="card">
<h2>Login</h2>

<form method="post">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>

<p>
    New user?
    <a href="index.php?page=register">Create new account</a>
</p>
</div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
