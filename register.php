<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'connection.php'; // Include the database connection
include 'validation.php'; // Include the validation file to validate email

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    try {
        // Validate the email format using regex
        validateEmail($_POST['username']);

        $username = htmlspecialchars(trim($_POST['username']));
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
        $first_name = htmlspecialchars(trim($_POST['first_name']));
        $last_name = htmlspecialchars(trim($_POST['last_name']));
        $address = htmlspecialchars(trim($_POST['address']));

        // Insert user data into the tbl_users table
        $sql = "INSERT INTO tbl_users (username, password, first_name, last_name, address) 
                VALUES (?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param("sssss", $username, $password, $first_name, $last_name, $address);
        // s --> String
        // i --> Integer
        // d --> Double/Float
        // b --> binary object


        // Execute the statement
        if ($stmt->execute()) {
            // Success message
            echo "Registration successful!";
            header("Location: login.php");
        } else {
            // Error message
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();

    }catch (InvalidEmailException $e) {
        // Display custom error message for invalid email
        $error = $e->errorMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="register-box">
        <h2>Register</h2>

        <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
        <form action="register.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required><br>

            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" required><br>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" required><br>

            <label for="address">Address:</label>
            <input type="text" name="address" required><br>

            <input type="submit" value="Register">
        </form>

        <div class="login-link">
            <p>Already registered? <a href="login.php">Login here</a></p>
        </div>
    </div>
</div>

</body>
</html>
