<?php

require_once 'DB.php';
header('Content-Type: text/html; charset=UTF-8');

$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm-password'] ?? '';

if (empty($username) || empty($email) || empty($password) || empty($confirm_password)){
    echo "<div class='alert alert-danger'>All fields are required</div>";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo "<div class='alert alert-danger'>Invalid email address</div>";
    exit;
}

if($password != $confirm_password){
    echo "<div class='alert alert-danger'>Password do not match</div>";
    exit;
}

$stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ? ");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows() > 0){
    echo "<div class='alert alert-danger'>Email is already registered</div>";
    exit;
}
$stmt->close();

$hashed_password = password_hash($password, PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES(?,?,?)");
$stmt->bind_param("sss",$username,$email,$hashed_password);
if ($stmt->execute()){
    echo "<div class='alert alert-warning'>Registration successfull.</div>";
}else {
    echo "<div class='alert alert-warning'>Something went wrong.</div>";
}
$stmt->close();
$conn->close();

?>