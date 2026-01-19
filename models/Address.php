<?php
// models/Address.php

require_once __DIR__ . '/../config/database.php';

class Address
{
    // Get address row by user_id
    public static function get(int $user_id): ?array
    {
        $conn = db();

        $stmt = $conn->prepare("SELECT * FROM addresses WHERE user_id = ? LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();
        return $row ?: null;
    }

    // Insert or update shipping address (single row per user)
    public static function upsert(int $user_id, string $address): bool
    {
        $conn = db();

        // Ensure one-row-per-user logic
        $existing = self::get($user_id);

        if ($existing) {
            $stmt = $conn->prepare("UPDATE addresses SET address = ? WHERE user_id = ?");
            $stmt->bind_param("si", $address, $user_id);
            return $stmt->execute();
        } else {
            $stmt = $conn->prepare("INSERT INTO addresses (user_id, address) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $address);
            return $stmt->execute();
        }
    }
}
