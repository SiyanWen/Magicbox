<html>
	<head>
		<title>My first PHP website</title>
	</head>
	<?php
	session_start(); //starts the session
	if($_SESSION['user']){ //checks if user is logged in
	}
	else{
		header("location:index.php"); // redirects if user is not logged in
	}
	$user = $_SESSION['user']; //assigns user value
	$id_exists = false;
	?>
	<body>
		<h2>Home Page</h2>
		<p>Hello <?php Print "$user"?>!</p> <!--Displays user's name-->
		<a href="logout.php">Click here to logout</a><br/><br/>
		<a href="home.php">Return to Home page</a>
		<h2 align="center">Currently Selected</h2>
		<table border="1px" width="100%">
			<tr>
				<th>Id</th>
				<th>Details</th>
				<th>Post Time</th>
				<th>Edit Time</th>
				<th>Text Post</th>
			</tr>
			<?php
				if(!empty($_GET['id']))
				{
					$id = $_GET['id'];
					$_SESSION['id'] = $id;
					$id_exists = true;
					include('db.php');
					$stmt = $mysqli->prepare("Select * from list Where id = ?"); // SQL Query
					$stmt->bind_param("i", $id); // Bind the parameter
					$stmt->execute(); // Execute the query
					$result = $stmt->get_result(); // Get the result
					$stmt->close(); // Close the statement
					if($result-> num_rows > 0)
					{
						while($row = $result->fetch_assoc())
						{
							Print "<tr>";
								Print '<td align="center">'. $row['id'] . "</td>";
								if($row['is_plaintext'] == 'no')
								{
									echo "<td ><pre><code>" . $row['details'] . "</code></pre></td>";
								}
								else
								{
									echo '<td align="center">' . htmlspecialchars($row['details']) . "</td>";
								}
								Print '<td align="center">'. $row['date_posted']. " - ". $row['time_posted']."</td>";
								Print '<td align="center">'. $row['date_edited']. " - ". $row['time_edited']. "</td>";
								Print '<td align="center">'. $row['is_plaintext']. "</td>";
							Print "</tr>";
						}
					}
					else
					{
						$id_exists = false;
					}
					$mysqli->close();
				}
			?>
		</table>
		<br/>
		<?php if ($id_exists): ?>
			<form action="edit.php" method="POST">
				Enter new detail: <input type="text" name="details" required/><br/>
				Plain text post? <input type="checkbox" name="is_plaintext[]" value="yes"/><br/>
				<input type="submit" value="Update List"/>
			</form>
		<?php else: ?>
			<h2 align="center">There is no data to be edited.</h2>
		<?php endif; ?>
	</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (!isset($_SESSION['id'])) {
        header("Location: home.php");
        exit();
    }

    $id = $_SESSION['id'];
    $details = $_POST['details'];
    $is_plaintext = (isset($_POST['is_plaintext']) && in_array("yes", $_POST['is_plaintext'])) ? "yes" : "no";
	$dateTime = new DateTimeImmutable('now', new DateTimeZone('America/New_York'));
    $time = $dateTime->format('H:i:s');
    $date = $dateTime->format('M d, Y');

    include('db.php');

    $stmt = $mysqli->prepare("UPDATE list SET details = ?, is_plaintext = ?, date_edited = ?, time_edited = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $details, $is_plaintext, $date, $time, $id);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();

    header("Location: home.php");
    exit();
}
?>