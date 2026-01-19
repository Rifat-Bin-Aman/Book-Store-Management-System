<?php
// models/Order.php

require_once __DIR__ . '/../config/Database.php';

class Order
{
    /* =========================
       ORDER HISTORY (CUSTOMER)
    ========================== */
public static function history(int $user_id): array
{
    $db = Database::getConnection();

    $stmt = $db->prepare("
        SELECT 
            id,
            book_title,
            order_date,
            shipping_address,
            subtotal,
            shipping_cost,
            vat,
            total,
            status,
            created_at
        FROM orders
        WHERE user_id = ?
        ORDER BY id DESC
    ");

    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}


    /* =========================
       CREATE ORDER (RETURNS ORDER ID)
    ========================== */
public static function create(
    int $user_id,
    string $book_title,
    float $subtotal,
    float $shipping_cost,
    float $vat,
    float $total,
    string $shipping_address
): bool {
    $db = Database::getConnection();

    $stmt = $db->prepare("
        INSERT INTO orders
        (user_id, book_title, order_date, shipping_address, subtotal, shipping_cost, vat, total)
        VALUES (?, ?, CURDATE(), ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "issdddd",
        $user_id,
        $book_title,
        $shipping_address,
        $subtotal,
        $shipping_cost,
        $vat,
        $total
    );

    return $stmt->execute();
}

    /* =========================
       ADD ORDER ITEM (BOOK)
    ========================== */
    public static function addItem(
        int $order_id,
        int $book_id,
        string $book_title,
        float $price,
        int $quantity
    ): void {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            INSERT INTO order_items
            (order_id, book_id, book_title, price, quantity)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "iisdi",
            $order_id,
            $book_id,
            $book_title,
            $price,
            $quantity
        );

        $stmt->execute();
    }

    /* =========================
       GET ITEMS OF AN ORDER
    ========================== */
    public static function getItemsByOrder(int $order_id): array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT 
                book_title,
                price,
                quantity
            FROM order_items
            WHERE order_id = ?
        ");

        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /* =========================
       DELETE ORDER
    ========================== */
    public static function delete(int $id, int $user_id): bool
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            DELETE FROM orders
            WHERE id = ? AND user_id = ?
        ");

        $stmt->bind_param("ii", $id, $user_id);
        return $stmt->execute();
    }
}
