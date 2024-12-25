<?php

require_once $_SERVER['DOCUMENT_ROOT'] .'/SneakerHome/database/connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/SneakerHome/models/registermodel.php';

$name_error = "";
$email_error = "";
$password_error = "";
$confirm_password_error = "";
$name = "";
$email = "";
$password = "";
$confirm_password = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    
    // Validate the input fields
    if (!validate_username($name)) {
        $name_error = "Invalid username";
    }
    if (!validate_email($email)) {
        $email_error = "Invalid email";
    }
    if (!validate_password($password)) {
        $password_error = "Password must be at least 6 characters.";
    }
    if ($password !== $confirm_password) {
        $confirm_password_error = "Passwords do not match.";
    }
    // Kiểm tra xem email có bị trùng không
    if (check_email_exists($db, $email)) {
        $email_error = "Email is already registered.";
    }
    // If all fields are valid, proceed with registration
    if (empty($name_error) && empty($email_error) && empty($password_error) && empty($confirm_password_error)) {
        $registration_result = register_user($db, $name, $email, $password, 'user');

        if ($registration_result) {
            // Registration successful, redirect to the login page
            header('Location: ../views/loginview.php');
exit();

        } else {
            echo "Registration failed. Please try again.";
        }
    }
}

require_once $_SERVER['DOCUMENT_ROOT'] .'/SneakerHome/views/registerview.php';
?>
