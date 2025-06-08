# OCSEcommerce Project

## Overview
OCSEcommerce is a secure, full-featured e-commerce platform built with PHP, MySQL, and JavaScript.  
The system includes user registration and login, product management, admin controls, activity logging, and more.  

This project demonstrates best practices in web application security including password hashing, session management, and role-based access control.

---

## Features
- User registration and secure login system  
- Admin dashboard with user management and activity logs  
- Product inventory management (Add, Edit, Delete)  
- Secure password hashing with `password_hash()`  
- Session-based authentication with role checks  
- Clean and responsive user interface  

---

## Getting Started

### Prerequisites
- PHP 8.x or higher  
- MySQL 5.x or higher  
- XAMPP or equivalent local development environment  
- Web browser  

### Installation Steps

1. **Clone or Download the Repository**  
   Download the project files from this GitHub repository.

2. **Import Database**  
   - Open [phpMyAdmin](http://localhost/phpmyadmin)  
   - Create a new database named `ocs_store` (or as specified in `config.php`)  
   - Import the `db.sql` file located in the root directory to create tables and seed data

3. **Configure Database Connection**  
   - Open `config.php`  
   - Update the database credentials (`$host`, `$user`, `$pass`, `$dbname`) to match your local environment

4. **Run the Project**  
   - Place the project folder in your web server root (e.g., `htdocs` for XAMPP)  
   - Access the project in your browser: `http://localhost/ocsecommerce`

---

## Project Structure

