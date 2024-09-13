# PHP Authentication System

This project implements a simple authentication system using PHP, covering the following features:
- User Registration
- User Login
- Dashboard (Accessed after successful login)

## Requirements

1. **Web Server**: Apache, Nginx, or any other server that can run PHP.
2. **PHP**: Version 7.2 or later.
3. **MySQL Database**: You'll need a MySQL database to store user data.
4. **Create Database Table**: The system uses a table named `tbl_users` to store user details. You need to create this table before using the registration and login functionality.

### Create `tbl_users` Table

To set up the necessary table for storing user information, run the following SQL query in your MySQL database:

```sql
CREATE TABLE tbl_users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    address TEXT NOT NULL
);
```

This table structure includes:
- `id`: A unique identifier for each user (auto-incremented).
- `username`: Stores the user's email (must be unique).
- `password`: Stores the hashed password.
- `first_name`: The user's first name.
- `last_name`: The user's last name.
- `address`: The user's address.

## Overview

### File Structure

- **register.php**: Handles user registration.
- **login.php**: Handles user login.
- **dashboard.php**: The main dashboard, accessible only after a successful login.
- **validation.php**: A separate PHP file containing email validation logic.
- **connection.php**: Manages database connection.
- **README.md**: This file.

## Features

1. **User Registration**:
    - Users can register by providing their username (email), password, first name, last name, and address.
    - The form validates email addresses to ensure users provide valid email formats.
    - Passwords are hashed before being stored in the database for added security.
    - If the user is already registered, they can be redirected to the login page.

2. **User Login**:
    - Users can log in by providing their email and password.
    - Passwords are validated by comparing the entered password with the stored hashed password.
    - If the credentials are correct, the user is redirected to the dashboard. Otherwise, an error message is displayed.

3. **Dashboard**:
    - The dashboard is accessible only after a user successfully logs in.
    - It includes a logout button to terminate the session.

### Flow Description

1. **Registration Flow**:
   - The user fills out a registration form with email, password, first name, last name, and address.
   - Upon form submission:
     - The system uses a separate email validation function (`validateEmail`) to check if the entered email address is valid.
     - The password is hashed using PHP's `password_hash()` function for secure storage.
     - The user data, including the hashed password, is inserted into the database.

2. **Login Flow**:
   - The user enters their email and password on the login page.
   - Upon form submission:
     - The entered email is validated using the `validateEmail()` function from a separate PHP file.
     - The entered password is verified against the hashed password stored in the database using `password_verify()`.
     - If the verification is successful, the user is redirected to the dashboard, and a session is started.
     - If login fails, an error message is displayed.

3. **Dashboard Flow**:
   - Once logged in, the user can access the dashboard page.
   - The dashboard shows a welcome message and a logout button.
   - Upon clicking the logout button, the session is destroyed, and the user is redirected to the login page.

---

## Key Components

### 1. **Email Validation (`validation.php`)**
We placed the email validation logic in a separate file for **reusability**. Both `login.php` and `register.php` can include this file to validate emails without duplicating the logic across multiple scripts.

- **Why validate emails?**  
   Ensuring that users enter valid email addresses reduces the likelihood of errors or spammy submissions. The `validateEmail` function checks if the provided email matches the general pattern of a valid email address.

### 2. **Password Hashing (`password_hash`)**
When users register, their passwords are hashed using the `password_hash()` function before being stored in the database.

- **Why use `password_hash`?**  
   Storing plain-text passwords in the database is a major security risk. `password_hash()` uses a one-way hashing algorithm, making it almost impossible for attackers to reverse-engineer and retrieve the original password if they gain access to the database.

### 3. **Password Verification (`password_verify`)**
During login, the entered password is verified using `password_verify()`. This function compares the hashed password stored in the database with the plain-text password entered by the user.

- **Why use `password_verify`?**  
   Since passwords are stored in a hashed form, you can't directly compare the stored password with the entered one. `password_verify()` ensures that the hashed password and the entered password match without needing to know the original plain-text password.

### 4. **HTML Escaping (`htmlspecialchars`)**
When displaying user input or error messages, we use `htmlspecialchars()` to escape special characters like `<`, `>`, and `&`.

- **Why use `htmlspecialchars`?**  
   This helps prevent **Cross-Site Scripting (XSS)** attacks. Without `htmlspecialchars()`, malicious users could inject harmful HTML or JavaScript code into your web pages by submitting forms with code snippets instead of plain text. Escaping special characters ensures that user input is treated as plain text and not executable code.

---

## Conclusion

This system is a basic but secure way to manage user authentication in PHP. By using strong password hashing, input validation, and proper security measures like escaping HTML, the project helps protect against common security vulnerabilities while providing a clean and reusable codebase.