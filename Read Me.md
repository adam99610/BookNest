# 📚 BookNest - Online Bookstore Project

BookNest is a secure, database-driven online bookstore developed as part of a Level 5 Software Development module. The application allows users to browse a catalogue of books, register and log in, manage their shopping cart, and place orders. An admin dashboard allows privileged users to manage books, users, and orders via a clean, secure interface.

---

## 📦 Overview

The primary goal of this project was to create a fully functional CRUD-driven bookstore website where:

- Users can register, log in, browse, and purchase books.
- Users can manage their own orders.
- Admins can manage books, users, and orders.
- The system ensures security, accessibility, and usability best practices.

This project was built using **PHP**, **MySQL**, **JavaScript**, and **CSS** within a local **UwAmp** server environment.

---

## ⚙️ Technologies Used

- **PHP 8+**
- **MySQL 8+**
- **JavaScript (ES6)**
- **HTML5 / CSS3**
- **UwAmp** (for local hosting and database management)
- **phpMyAdmin** (for database administration)

---

## 📂 Project Structure

booknest/
│
├── admin/ # Admin pages (dashboard, manage users/books/orders)
│ ├── dashboard.php
│ ├── manage_users.php
│ ├── manage_books.php
│ ├── manage_orders.php
│
├── includes/ # Config, functions, shared header/footer
│ ├── config.php
│ ├── functions.php
│ ├── header.php
│ ├── footer.php
│
├── pages/ # Public pages for user interaction
│ ├── index.php
│ ├── register.php
│ ├── login.php
│ ├── cart.php
│ ├── order_confirmation.php
│
├── process/ # Form handlers (registration, login, checkout)
│ ├── register_process.php
│ ├── login_process.php
│ ├── add_to_cart.php
│ ├── checkout_process.php
│
├── sql/ # SQL database schema
│ ├── booknest_schema.sql
│
├── css/
│ └── styles.css
│
└── README.md # Project documentation (this file)


---

## 📥 Installation & Setup

### 📦 Requirements:
- UwAmp / XAMPP / WAMP (with PHP 8+ and MySQL)
- phpMyAdmin for database management

### 📝 Steps:

1. Clone or copy the project files to your `www/` directory (e.g. `C:/UwAmp/www/booknest`).
2. Start UwAmp server and phpMyAdmin.
3. In phpMyAdmin:
   - Create a database named `booknest`.
   - Import `sql/booknest_schema.sql` into the `booknest` database.
4. Edit `/includes/config.php` with your database credentials:

```php
$mysqli = new mysqli("localhost", "root", "", "booknest");
