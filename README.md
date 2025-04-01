
# Core PHP Auth

**Core PHP Authentication** package provides essential functionalities for user authentication, including registration, login, JWT token generation, and token verification. It is designed to be simple, flexible, and lightweight for PHP developers.

## Features

- **User Registration**: Hash and store user passwords.
- **User Login**: Authenticate users using email and password, generate JWT token.
- **JWT Token Generation**: Generate JWT token for authenticated users.
- **JWT Token Verification**: Verify JWT tokens for access control to protected routes.
- **Configurable**: Allows you to set a custom JWT secret key for encryption.

## Requirements

- PHP 7.4+ (Recommended PHP 8.0+)
- MySQL or compatible relational database (like MariaDB)
- Composer (for package management)

## Installation

### 1. Install via Composer

To install the package via Composer, run the following command in your terminal or command prompt from your project root:

```bash
composer require prince-rai/core-php-auth
```

This will automatically download and install the package along with its dependencies.

### 2. Configure the Database

You will need to create a database and a **`users`** table to store user information. Here’s the SQL query to create the necessary table:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,      -- User ID (Primary Key)
    name VARCHAR(255) NOT NULL,             -- User Name
    email VARCHAR(255) NOT NULL UNIQUE,     -- User Email (must be unique)
    password VARCHAR(255) NOT NULL          -- User Password (hashed)
);
```

This table stores the user's **ID**, **Name**, **Email** (unique), and **Password** (hashed).

### 3. Configuration File

The JWT secret key is required for signing and verifying JWT tokens. To set this, create a **`config/config.php`** file in your project and configure your secret key (by default we're generating a new one during registeration , so i you wish to modify it you are good to go):

```php
<?php
return [
    'jwt_secret' => 'your-secret-key',  // Change this to a strong secret key
];
```

Replace `'your-secret-key'` with a strong, secure key. This key is used to sign the JWT tokens and must be kept **private**.

---

## Usage

### 1. Register a User

To register a new user, you can use the `register()` method. This method will hash the user's password before storing it in the database.

```php
use CoreAuth\Auth;
use CoreAuth\Database;

$database = new Database();
$auth = new Auth($database);

// Register a user
$name = 'John Doe';
$email = 'john@example.com';
$password = 'password123'; // Ensure the password is strong
$auth->register($name, $email, $password);
```

### 2. Login a User

To log in a user, use the `login()` method. If the credentials are correct, it will return a JWT token.

```php
// Login a user
$email = 'john@example.com';
$password = 'password123';
$user = $auth->login($email, $password);

if ($user) {
    echo 'Login successful! JWT Token: ' . $user['token'];
} else {
    echo 'Invalid credentials!';
}
```

### 3. Protect Routes with JWT Token Verification

To protect routes, verify the JWT token using the `verifyToken()` method.

```php
// Assuming the JWT token is stored in the session
$token = $_SESSION['jwt_token'];  

if ($auth->verifyToken($token)) {
    echo 'Access granted!';
} else {
    echo 'Invalid or expired token!';
}
```

You can use this method to restrict access to certain pages or actions until the user provides a valid JWT token.

---

## Database Details

The package assumes that your database has a **`users`** table with the following structure:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,      -- User ID (Primary Key)
    name VARCHAR(255) NOT NULL,             -- User Full Name
    email VARCHAR(255) NOT NULL UNIQUE,     -- User Email (must be unique)
    password VARCHAR(255) NOT NULL          -- User Password (hashed)
);
```

Ensure that your database is set up correctly before using the package. The table must contain the columns `id`, `name`, `email`, and `password`.

---

## Configuration

- **JWT Secret Key**: The `jwt_secret` in the **`config/config.php`** file is critical for the security of your application. Use a unique and secure key. You can generate a random key using an online tool like [RandomKeygen](https://randomkeygen.com/).
- **Database Connection**: The `Database` class assumes that you're using MySQL. If you're using a different database system, you'll need to adjust the connection details in the `Database.php` file.

---

## Uninstalling the Package

If you want to uninstall the package, you can do so using Composer. Simply run the following command:

```bash
composer remove prince-rai/core-php-auth
```

This will remove the package from your project, and you will also need to delete any related configuration files, such as the `config/config.php` file and any changes you made to your codebase for the authentication logic.

### Database Cleanup

If you no longer need the database table, you can drop the `users` table:

```sql
DROP TABLE users;
```

---

## License

MIT License. See the [LICENSE](LICENSE) file for more details.

---

## How to Contribute

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-name`).
3. Commit your changes (`git commit -m 'Add new feature'`).
4. Push the branch (`git push origin feature-name`).
5. Open a Pull Request on GitHub.

---

## FAQs

### 1. **How do I change the database credentials?**
The database credentials can be modified in the `Database.php` file, where the database connection is set up. You can change the `host`, `dbname`, `username`, and `password` properties accordingly.

### 2. **Can I use this package in a Laravel project?**
Yes, you can integrate this package into a Laravel project by wrapping it in a service provider. However, it's primarily designed for use in pure PHP projects.

### 3. **Is this package production-ready?**
This package is designed to be a simple and flexible solution for authentication. For a production environment, ensure you use HTTPS, proper JWT token expiration times, and strong passwords. It's recommended to review security practices before using it in production.

---

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the available versions, see the [tags on this repository](https://github.com/laravel-princerai/prince-rai-core-php-auth/tags).
