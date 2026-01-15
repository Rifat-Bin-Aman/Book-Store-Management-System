<?php
require_once 'config/database.php';

class Book {
    public static function all() {
        global $conn;
        return mysqli_query($conn, "SELECT * FROM books WHERE available=1");
    }
}
