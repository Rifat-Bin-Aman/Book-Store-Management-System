<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'bookhaven';

echo "===================================\n";
echo "BookHeaven Database Connection Test\n";
echo "===================================\n\n";

try {
    // Test 1: Connect to MySQL server
    echo "1. Connecting to MySQL server...\n";
    $conn = new mysqli($host, $user, $pass);
    
    if ($conn->connect_error) {
        echo "   ✗ Failed: " . $conn->connect_error . "\n";
        exit(1);
    }
    
    echo "   ✓ Connected to MySQL server\n\n";
    
    // Test 2: Check if database exists
    echo "2. Checking database '$db'...\n";
    $result = $conn->query("SHOW DATABASES LIKE '$db'");
    
    if ($result && $result->num_rows > 0) {
        echo "   ✓ Database exists\n\n";
    } else {
        echo "   ✗ Database NOT found\n";
        echo "   Please run: C:\\xampp\\php\\php.exe setup_db.php\n";
        exit(1);
    }
    
    // Test 3: Connect to database
    echo "3. Connecting to database '$db'...\n";
    $dbConn = new mysqli($host, $user, $pass, $db);
    
    if ($dbConn->connect_error) {
        echo "   ✗ Failed: " . $dbConn->connect_error . "\n";
        exit(1);
    }
    
    echo "   ✓ Connected to database\n\n";
    
    // Test 4: Check tables
    echo "4. Checking database tables:\n";
    $tables = ['users', 'books', 'orders', 'addresses', 'employee_schedules', 'activity_logs'];
    
    $allFound = true;
    foreach ($tables as $table) {
        $result = $dbConn->query("SHOW TABLES LIKE '$table'");
        
        if ($result && $result->num_rows > 0) {
            $countResult = $dbConn->query("SELECT COUNT(*) as cnt FROM $table");
            $row = $countResult->fetch_assoc();
            $cnt = $row['cnt'] ?? 0;
            echo "   ✓ $table ($cnt rows)\n";
        } else {
            echo "   ✗ $table (MISSING)\n";
            $allFound = false;
        }
    }
    
    echo "\n";
    
    // Test 5: Check seed data
    echo "5. Checking seed data:\n";
    $users = $dbConn->query("SELECT COUNT(*) as cnt FROM users")->fetch_assoc();
    $books = $dbConn->query("SELECT COUNT(*) as cnt FROM books")->fetch_assoc();
    
    echo "   ✓ Users: " . $users['cnt'] . "\n";
    echo "   ✓ Books: " . $books['cnt'] . "\n";
    
    echo "\n===================================\n";
    
    if ($allFound && $users['cnt'] > 0 && $books['cnt'] > 0) {
        echo "✓✓✓ ALL TESTS PASSED ✓✓✓\n";
        echo "===================================\n\n";
        echo "The application is ready to use!\n\n";
        echo "Access at: http://localhost/BookHeaven/index.php?page=login\n\n";
        echo "Default Credentials:\n";
        echo "  Admin:    admin@bookhaven.test / admin1234\n";
        echo "  Employee: employee@bookhaven.test / employee1234\n";
        echo "  Customer: customer@bookhaven.test / customer1234\n";
    } else {
        echo "✗ SOME TESTS FAILED\n";
        echo "===================================\n";
        exit(1);
    }
    
    $dbConn->close();
    $conn->close();
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
