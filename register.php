<html>
<head>
    <title>My first PHP website</title>
</head>
<body>
    <h2>Registration Page</h2>
    <a href="index.php">Click here to go back</a><br/><br/>
    <form action="register.php" method="post">
        Enter Username: <input type="text" name="username" required="required"/> <br/>
        Enter Password: <input type="password" name="password" required="required" /> <br/>
        <input type="submit" value="Register"/>
    </form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include('db.php');
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to the database
    // $mysqli = new mysqli("localhost", "root", "", "first_db");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Check if username already exists
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Username already exists!');</script>";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        // Insert new user
        $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed);  // In real applications, hash password!
        $stmt->execute();
        echo "<script>alert('Successfully Registered!');</script>";
    }

    $stmt->close();
    $mysqli->close();
}
?>
