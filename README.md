# User Authentication System with PHP AND MYSQL with PDO

## Setup

1. Clone the repository into the htdocs folder.
2. Configure the DATABASE credentials in `database.php` file inside the config folder. 
3. Configure the EMAIL credentials in `email.php` file inside the config folder. 
4. Import `users` table schema into your MySQL database.
5. Run the application by accessing `register.php`, `login.php` and `dashboard` pages.

## Requirements

- PHP Version: 7.x or higher
- Database: MySQL

## Software Requirements

- Server: Apache server (e.g., XAMPP, WAMP)
- Editor: Visual Studio Code or any text editor of your choice.

## Features

- User registration, login, and logout using PDO.
- Sanitized and validated inputs when registration.
- CSRF protection and password hashing.
- Validate login credentials and Managed user sessions.

## Additional Features

- Remember me (Users to stay logged in across sessions)
- Email verification (Verifies the user's email upon registration)

## Vendor

- Installed `PHPMailer` used to sending mail for email verification

## Links

- http://localhost/peopleone/index.php   (Login Page)
- http://localhost/peopleone/register.php  (Register Page)
- http://localhost/peopleone/dashboard.php  (Dashboard Page)






