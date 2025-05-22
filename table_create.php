<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "first_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if ($conn->query("DROP TABLE list") === TRUE) {
  echo "Table list dropped successfully<br>";
} else {
  echo "Error dropping table: " . $conn->error;
}
// sql to create table
$sql = "CREATE TABLE list (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
details TEXT NOT NULL,
date_posted VARCHAR(30) NOT NULL,
time_posted TIME NOT NULL,
date_edited VARCHAR(30) NOT NULL,
time_edited TIME NOT NULL,
is_plaintext VARCHAR(5) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
  echo "Table list created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}

$conn->close();
?>