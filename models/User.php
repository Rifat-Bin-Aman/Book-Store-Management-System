<?php
require_once __DIR__ . '/../config/database.php';

class User {

    public static function create($name, $email, $password) {
        global $conn;
        $password = password_hash($password, PASSWORD_DEFAULT);

        return mysqli_query($conn,
            "INSERT INTO users (name,email,password)
             VALUES ('$name','$email','$password')"
        );
    }

    public static function findByEmail($email) {
        global $conn;
        return mysqli_fetch_assoc(
            mysqli_query($conn,
                "SELECT * FROM users WHERE email='$email'")
        );
    }
}
