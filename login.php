<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include 'connection.php'; // Include the connection file
include 'validation.php'; // Include the validation file to validate email


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Validate the email format using regex
        validateEmail($username);

        // Prepare and execute SQL query to get the hashed password
        $stmt = $conn->prepare("SELECT password FROM tbl_users WHERE username = ?");
        $stmt->bind_param("s", $username); // 's' denotes a single string parameter
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Fetch the row
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            // Verify the entered password with the hashed password
            if (password_verify($password, $hashed_password)) {
                // Set session variable and redirect on successful login
                $_SESSION['loggedin'] = true;
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }

        // Close statement
        $stmt->close();

    } catch (InvalidEmailException $e) {
        // Display custom error message for invalid email
        $error = $e->errorMessage();
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h2>Login Page</h2>
            <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
            <form action="login.php" method="post">
                <label for="username">Username (Email):</label>
                <input type="text" id="username" name="username" required><br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>

                <button type="submit">Login</button>
            </form>

            <div class="login-link">
                <p>New User? <a href="register.php">Register here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
