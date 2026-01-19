Book Haven (Book Store Management System)
=======================================

Roles
-----
1) Admin
2) Employee
3) Customer

Key Features
------------
Common (all roles)
- Login / Logout
- Customer registration
- My Profile: view + edit (name, email, mobile, address)
- Change password

Admin
- Dashboard: total users + recent activity logs
- Add employees (create employee accounts)
- Delete employees (AJAX)
- Manage books (add, edit, delete)
- Assign employee work schedule

Employee
- View all books
- Update book availability (available/unavailable) via AJAX
- View own work schedule

Customer
- Browse available books
- Live search books (AJAX)
- Session-based cart (add/remove)
- Confirm order (checkout)
- Manage shipping address
- View order history (and remove a history row)

Installation (XAMPP)
-------------------
1) Copy the project folder to:
   C:\xampp\htdocs\Book-Store-Management-System-main\

2) Start XAMPP services:
   - Apache
   - MySQL

3) Create and import database:
   - Open phpMyAdmin: http://localhost/phpmyadmin
   - Create database: bookhaven
   - Import the SQL file:
     assets/db-file/bookhaven.sql

4) Configure DB credentials (if needed):
   - File: config/database.php
   - Default values:
     host=localhost, user=root, pass='', db=bookhaven

5) Run the project:
   - Login page:
     http://localhost/Book-Store-Management-System-main/index.php?page=login

Default Accounts (from seed data)
--------------------------------
Admin
- Email: admin@bookhaven.test
- Password: admin1234

Employee
- Email: employee@bookhaven.test
- Password: employee1234

Customer
- Email: customer@bookhaven.test
- Password: customer1234

Notes
-----
- This project uses query-string routing (index.php?page=...). mod_rewrite is not required.
- Seed passwords are plain text to make first login easy. After the first successful login, the system automatically upgrades them to secure password_hash() values.
