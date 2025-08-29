<?php
include_once 'DB.php';
header('Content-Type: text/html; charset=UTF-8');

$email = trim($_POST['email']);
$password = $_POST['password'];

if (empty($email) || empty($password)) {
    echo "<div class='alert alert-danger'>Email or Password is missing</div>";
}

$stmt = $conn->prepare("SELECT user_id, password FROM users WHERE email = ? ");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows() == 0) {
    echo "<div class='alert alert-danger'>No users found with this email</div>";
    exit;
}

$stmt->bind_result($user_id, $hashed_password);
$stmt->fetch();

if (password_verify($password, $hashed_password)) {
    echo "<div class='alert alert-success'>Login Successfull</div>";
} else {
    echo "<div class='alert alert-danger'>Invalid password</div>";
}

$stmt->close();
$conn->close();
