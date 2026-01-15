<?php
require_once __DIR__ . '/../config/database.php';

class AjaxController {

    public function searchBooks() {
        global $conn;

        $q = $_GET['q'] ?? '';
        $q = mysqli_real_escape_string($conn, $q);

        // search only available books
        $result = mysqli_query($conn,
            "SELECT * FROM books 
             WHERE available=1 AND title LIKE '%$q%'"
        );

        // return JSON
        $books = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $books[] = $row;
        }

        header('Content-Type: application/json');
        echo json_encode($books);
        exit;
    }
}
