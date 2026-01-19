<?php
require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../models/Address.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/ActivityLog.php';

class CustomerController
{
    /* =========================
       ACCESS CONTROL
    ========================== */
    private function requireCustomer(): void
    {
        if (($_SESSION['user_role'] ?? '') !== 'customer') {
            header('Location: index.php');
            exit;
        }
    }

    /* =========================
       DASHBOARD
    ========================== */
    public function dashboard(): void
    {
        $this->requireCustomer();
        $books = Book::all(true);
        include __DIR__ . '/../views/customer/dashboard.php';
    }

    public function books(): void
    {
        $this->requireCustomer();
        $books = Book::all(true);
        include __DIR__ . '/../views/customer/books.php';
    }

    /* =========================
       ADDRESS
    ========================== */
    public function address(): void
    {
        $this->requireCustomer();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $addr = trim($_POST['address'] ?? '');
            Address::upsert((int)$_SESSION['user_id'], $addr);
            ActivityLog::log((int)$_SESSION['user_id'], 'Updated shipping address');
            $success = 'Address saved.';
        }

        $addr = Address::get((int)$_SESSION['user_id']);
        include __DIR__ . '/../views/customer/address.php';
    }

    /* =========================
       ORDER HISTORY
    ========================== */
    public function orders(): void
    {
        $this->requireCustomer();

        $user_id = (int)$_SESSION['user_id'];
        $orders = Order::history($user_id);

        include __DIR__ . '/../views/customer/orders.php';
    }

    /* =========================
       CART
    ========================== */
    public function cart(): void
    {
        $this->requireCustomer();

        $cart = $_SESSION['cart'] ?? [];
        $addr = Address::get((int)$_SESSION['user_id']);

        $subtotal = 0.0;
        foreach ($cart as $item) {
            $subtotal += (float)$item['price'];
        }

        $shipping = ($subtotal > 0) ? 50.00 : 0.00;
        $vat = round($subtotal * 0.02, 2);
        $grandTotal = round($subtotal + $shipping + $vat, 2);

        include __DIR__ . '/../views/customer/cart.php';
    }

    public function addToCart(): void
    {
        $this->requireCustomer();

        // ONE book per order logic
        $_SESSION['cart'] = [[
            'title' => (string)($_POST['title'] ?? ''),
            'price' => (float)($_POST['price'] ?? 0)
        ]];

        header('Location: index.php?page=cart');
        exit;
    }

    public function removeFromCart(): void
    {
        $this->requireCustomer();
        unset($_SESSION['cart']);
        header('Location: index.php?page=cart');
        exit;
    }

    /* =========================
       CONFIRM ORDER (CORRECTED)
    ========================== */
    public function confirmOrder(): void
    {
        $this->requireCustomer();

        $user_id = (int)$_SESSION['user_id'];
        $shipping_address = trim($_POST['shipping_address'] ?? '');

        if ($shipping_address === '') {
            $addr = Address::get($user_id);
            $shipping_address = $addr['address'] ?? 'N/A';
        }

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            header('Location: index.php?page=cart');
            exit;
        }

        // ONE book per order
        $book_title = trim($cart[0]['title'] ?? 'Unknown Book');
        $subtotal   = (float)$cart[0]['price'];

        $shipping_cost = 50.00;
        $vat   = round($subtotal * 0.02, 2);
        $total = round($subtotal + $shipping_cost + $vat, 2);

        // ✅ CORRECT PARAMETER ORDER
        Order::create(
            $user_id,
            $book_title,
            $subtotal,
            $shipping_cost,
            $vat,
            $total,
            $shipping_address
        );

        ActivityLog::log($user_id, 'Placed a new order');

        unset($_SESSION['cart']);

        header('Location: index.php?page=orders');
        exit;
    }

    /* =========================
       REMOVE ORDER
    ========================== */
    public function removeOrder(): void
    {
        $this->requireCustomer();

        $orderId = (int)($_POST['order_id'] ?? 0);
        $user_id = (int)$_SESSION['user_id'];

        if ($orderId > 0) {
            Order::delete($orderId, $user_id);
            ActivityLog::log($user_id, 'Removed order history row');
        }

        header('Location: index.php?page=orders');
        exit;
    }
}
