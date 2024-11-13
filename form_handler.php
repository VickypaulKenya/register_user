<?php
session_start();
include_once("config/db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $errors = [];

    try {
        // Log the POST data for debugging purposes
        file_put_contents("logs/error.log", print_r($_POST, TRUE), FILE_APPEND);

        // Validate username
        if (empty($username)) {
            $errors['usernameError'] = "Username field cannot be empty";
        }

        // Validate email
        if (!empty($email)) {
            // Check if the email already exists in the database
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $email_exist = $stmt->fetchColumn();

            if ($email_exist) {
                $errors["emailError"] = "This email <span style='color:green'>" . $email . "</span> is already registered. Please use another email.";
            }
        } else {
            $errors["emailError"] = "Email field cannot be empty";
        }

        // Validate password
        if (!empty($password)) {
            if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
                $errors['passwordError'] = "Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.";
            }
        } else {
            $errors["passwordError"] = "Password field cannot be empty";
        }

        // If there are errors, save them in the session and redirect back to the form
        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["old"] = [
                "username" => $username,
                "email" => $email,
                "password" => $password
            ];
            header("Location: index.php");
            exit(); // Ensure no further code is executed after the redirect
        }

        // Hash the password before saving it to the database
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database
        $sql = "INSERT INTO users (username, email, pwd) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $email, $password_hash]);

        // Redirect to the login page after successful registration
        header("Location: login.php");
        exit(); // Ensure no further code is executed after the redirect

    } catch (PDOException $th) {
        // Log the error details to a log file for debugging
        file_put_contents("logs/errors.log", date('Y-m-d H:i:s') . " - Error: " . $th->getMessage() . "\n", FILE_APPEND);

        // Set a general error message for the user
        $_SESSION["errors"]["generalError"] = "An unexpected error occurred. Please try again later.";

        // Redirect the user back to the form page
        header("Location: index.php");
        exit(); // Ensure no further code is executed after the redirect
    }
}
?>
