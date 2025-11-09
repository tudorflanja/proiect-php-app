# 🧮 PHP + MySQL Student–Course Management System

This web-based project implements a relational database management system built using **PHP** and **MySQL**.  
It allows users to manage students, courses, and their enrollments through a clean and functional CRUD interface, demonstrating the use of **foreign keys**, **relational integrity**, and **cascade delete operations**.

---

## 🚀 Features

- 📋 **Full CRUD Functionality** – Create, read, update, and delete records for students, courses, and enrollments  
- 🔗 **Relational Database Design** – Implements one-to-many relationships between parent and child tables  
- 💣 **Cascade Deletion** – Automatically deletes related enrollments when a student or course is removed  
- 🔍 **Search and Filter** – Quickly find records using name or email filters  
- 🔐 **User Authentication (Optional)** – Login system using sessions and hashed passwords  
- 🎨 **Responsive Layout** – Simple, readable interface with reusable components (header, footer, navigation)

---

## 🧰 Technologies Used

- **PHP 8.x** – Server-side scripting and business logic  
- **MySQL 5.7+** – Relational database system  
- **HTML5 / CSS3** – Frontend structure and styling  
- **XAMPP** – Local development environment (Apache + MySQL)  
- **PDO (PHP Data Objects)** – Secure database connection and queries  
- **phpMyAdmin** – Database administration and management tool  

---

## 🛠️ Application Overview

The application provides a modular structure consisting of three main entities:

- **Students** – Stores basic student information (name, email, registration date)  
- **Courses** – Defines available courses and professors  
- **Enrollments** – Connects students to courses (child table with two foreign keys)  

The `enrollments` table ensures that deleting a student or course automatically removes all corresponding enrollment records through **ON DELETE CASCADE** constraints.

---

## 💻 How It Works

1. The user logs in with the default credentials (`admin / admin123`).  
2. Through the navigation bar, they can manage:
   - 🧑‍🎓 **Students** – Add, edit, delete, and search for student data  
   - 📘 **Courses** – Create or modify course information and instructors  
   - 🔗 **Enrollments** – Link a student to one or more courses  
3. All data is handled securely via prepared SQL statements using PDO.  
4. Cascade deletion maintains relational consistency automatically.  
5. The session-based authentication system protects all CRUD operations.

---

## 📂 Project Structure

- `assets/` – Contains CSS styling for layout and UI elements  
- `inc/` – Common includes: database connection, authentication, header, and footer  
- `students/` – CRUD operations for students  
- `courses/` – CRUD operations for courses  
- `enrollments/` – CRUD operations for enrollments  
- `db/` – SQL dump or schema for database creation  
- `login.php` – User authentication page  
- `logout.php` – Ends the user session  
- `users_seed.php` – Script that creates a default admin user  
- `test_db.php` – Verifies successful connection to the MySQL database  

---

## ▶️ How to Run the Project

You can run the application locally using **XAMPP** or deploy it on a web server.

### Option 1: Run Locally (XAMPP)

1. **Install XAMPP**  
   Download and install from [https://www.apachefriends.org](https://www.apachefriends.org).

2. **Start Services**  
   Open the XAMPP Control Panel → Start **Apache** and **MySQL**.

3. **Import the Database**
   - Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin)  
   - Create a new database named `proiect_php`  
   - Import the SQL file from `db/dump.sql`

4. **Place the Project Folder**
   - Copy the entire `proiect_php_app` folder into your `htdocs` directory:
     ```
     C:\xampp\htdocs\
     ```

5. **Access the Application**
   - In your browser, open:
     ```
     http://localhost/proiect_php_app/login.php
     ```

6. **Login Credentials**
   Username: admin
   Password: admin123

---

### Option 2: Deploy Online (Web Hosting)

1. Upload the `proiect_php_app` folder to your web server (e.g., `public_html/`).  
2. Create a new MySQL database and import the file `dump.sql`.  
3. Update the file `inc/db.php` with your database credentials.  
4. Access the project through your hosting domain, for example: https://yourdomain.com/proiect_php_app

---

## 🗄️ Database Schema

The database consists of three related tables:

```sql
CREATE DATABASE IF NOT EXISTS proiect_php
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE proiect_php;

CREATE TABLE students (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
email VARCHAR(120) UNIQUE NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE courses (
id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(120) NOT NULL,
professor VARCHAR(120),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE enrollments (
id INT AUTO_INCREMENT PRIMARY KEY,
student_id INT NOT NULL,
course_id INT NOT NULL,
enroll_date DATE DEFAULT (CURRENT_DATE),
FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
UNIQUE KEY uq_student_course (student_id, course_id)
);
```

