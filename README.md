🧭 Staff Dashboard Management System

A simple **PHP-based staff authentication and dashboard system** that allows users (staff, managers, and admins) to log in and access specific roles and permissions based on their department.  
This project is designed to **strengthen backend logic and server-side programming skills in PHP**, focusing on how authentication, role-based access, and session management work in real systems.

---

## 🎯 Purpose & Motivation

The **main reason behind developing this site** is to:
- Practice and understand **backend business logic** in PHP beyond just syntax.
- Learn how to structure modular applications using **separation of concerns** (config, includes, public files).
- Implement a real-world **authentication module** (login, sessions, and role-based dashboards).
- Prepare for more complex backend systems such as **ERP, CRM, or company intranet portals**.
- Build a foundation for future integration with **APIs, databases, and admin panels**.

This project mirrors what a software engineer might build in small company systems — managing staff logins, department dashboards, and permissions.

---

## ⚙️ Features

- 🔐 Secure login system with password hashing (MD5 / can upgrade to bcrypt)
- 👤 Role-based access (Admin, Manager, Staff)
- 🏢 Department-based permissions
- 🗃️ PDO-based database connection
- 🚪 Logout functionality with session handling
- 💡 Modular and scalable structure (ready for expansion)

---

## 🧱 Tech Stack

| Component | Technology |
|------------|-------------|
| Language | PHP 8+ |
| Database | MySQL (via phpMyAdmin) |
| Frontend | HTML5, CSS3, JavaScript |
| Server | Apache (via XAMPP) |


2. Import the SQL file:
- Open [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
- Create a database named `staff_dashboard`
- Import `/sql/staff_dashboard.sql`

3. Update your database credentials in `config/db.php` if needed:
```php
$host = 'localhost';
$db   = 'staff_dashboard';
$user = 'root';
$pass = '';

Future Improvements

Switch from MD5 to bcrypt for stronger password hashing

Add registration and forgot-password pages

Include role-based dashboard views (e.g., Admin view vs Staff view)

Integrate AJAX for smoother interactions

Use environment variables (.env) for configuration

Implement REST APIs and JWT-based authentication

🧠 Author’s Note

This project was developed as a learning exercise to understand the core business logic of backend systems — particularly:

How authentication flows work in real environments

How to structure code for scalability and maintainability

How PHP interacts with MySQL via PDO

How to debug logical errors efficiently

By building this project from scratch, developers strengthen not only their PHP syntax but also their problem-solving mindset as software engineers.

🧑‍💻 Author

Dennis Kinyua
Software Engineer | Backend Developer | Python & PHP Enthusiast
📧 kinyuadenno1@gmail.com
| Database Library | PDO (PHP Data Objects) |
