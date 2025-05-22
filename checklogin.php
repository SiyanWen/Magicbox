<?php
include('db.php'); // Assuming db.php contains the database connection code
session_start();

$username = trim($_POST['username']);
$password = trim($_POST['password']);

$stmt = $mysqli->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($db_password);
    $stmt->fetch();

    if (password_verify($password, $db_password)) {
        $_SESSION['user'] = $username;
        header("Location: home.php");
        exit();
    } else {
        echo "<script>alert('Incorrect Password!'); window.location.assign('login.php');</script>";
    }
} else {
    echo "<script>alert('Incorrect Username!'); window.location.assign('login.php');</script>";
}


$stmt->close();
$mysqli->close();
?>
