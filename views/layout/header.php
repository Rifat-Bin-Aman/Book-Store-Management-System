<!DOCTYPE html>
<html>
<head>
    <title>Bookstore</title>

    <!-- CSS LINK -->
    <link rel="stylesheet" href="/bookstore_1/assets/style.css">
</head>
<body>

<nav class="nav">

    <!-- 🔵 LEFT : Website Name -->
    <div class="nav-left">
        <a href="/bookstore_1/" class="brand">Bookstore</a>
    </div>

    <!-- 🟢 CENTER : Menu -->
    <div class="nav-center">
        <a href="/bookstore_1/">Dashboard</a>
        <a href="/bookstore_1/?page=books">Books</a>
        <a href="/bookstore_1/?page=address">Shipping Address</a>
        <a href="/bookstore_1/?page=orders">Orders</a>
        <a href="/bookstore_1/?page=cart">
            Cart (<?= count($_SESSION['cart'] ?? []) ?>)
        </a>
    </div>

    <!-- 🔴 RIGHT : Logout -->
    <div class="nav-right">
        <a href="/bookstore_1/?page=logout">Logout</a>
    </div>

</nav>
