<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/ActivityLog.php';

class AuthController
{
    private function redirectByRole(string $role): void
    {
        if ($role === 'admin') {
            header('Location: index.php?page=admin_dashboard');
        } elseif ($role === 'employee') {
            header('Location: index.php?page=employee_dashboard');
        } else {
            header('Location: index.php?page=customer_dashboard');
        }
        exit;
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($email === '' || $password === '') {
                $error = 'Email and password are required.';
                include __DIR__ . '/../views/auth/login.php';
                return;
            }

            $user = User::findByEmail($email);

            if ($user) {
                $dbPass = (string)($user['password'] ?? '');
                $ok = false;

                if (password_verify($password, $dbPass)) {
                    $ok = true;
                } elseif ($dbPass === $password) {
                    // Legacy: plain password stored in DB
                    $ok = true;
                    User::ensureHashedPassword((int)$user['id'], $password);
                }

                if ($ok) {
                    if (($user['status'] ?? 'active') !== 'active') {
                        $error = 'Your account is inactive. Contact admin.';
                        include __DIR__ . '/../views/auth/login.php';
                        return;
                    }

                    $_SESSION['user_id'] = (int)$user['id'];
                    $_SESSION['user_role'] = $user['role'] ?? 'customer';

                    ActivityLog::log((int)$user['id'], 'Logged in');

                    $this->redirectByRole($_SESSION['user_role']);
                }
            }

            $error = 'Invalid email or password.';
        }

        include __DIR__ . '/../views/auth/login.php';
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $errors = [];
            if ($name === '') $errors[] = 'Name is required.';
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
            if (strlen($password) < 4) $errors[] = 'Password must be at least 4 characters.';

            if (User::findByEmail($email)) $errors[] = 'Email already exists.';

            if (empty($errors)) {
                User::createCustomer($name, $email, $password);
                ActivityLog::log(null, 'New customer registered: ' . $email);

                echo "<script>alert('Account created successfully');window.location='index.php?page=login';</script>";
                exit;
            }
        }

        include __DIR__ . '/../views/auth/register.php';
    }

    public function logout(): void
    {
        if (isset($_SESSION['user_id'])) {
            ActivityLog::log((int)$_SESSION['user_id'], 'Logged out');
        }
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}
