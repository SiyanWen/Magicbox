<html>
	<head>
		<style type="text/css">
			table, th, td {
				border: 1px solid white;
				border-collapse: collapse;
			}
			th, td {
				background-color: #96D4D4;
			}
		</style>

		<title>My first PHP website</title>

		
		<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

		

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/github.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
		<script>hljs.highlightAll();</script>

    	<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
	</head>
	<?php
	session_start(); //starts the session
	if($_SESSION['user']){ //checks if user is logged in
	}
	else{
		header("location:index.php"); // redirects if user is not logged in
	}
	$user = $_SESSION['user']; //assigns user value
	?>
	<body>
		<h2>Home Page</h2>
		<p>Hello <?php echo "$user"?>!</p> <!--Displays user's name-->
		<a href="logout.php">Click here to logout</a><br/><br/>
		<form action="add.php" method="POST">
			Add more to list: <textarea name="details" rows="5" cols="30"></textarea><br/>
			Plain text post? <input type="checkbox" name="is_plaintext[]" value="yes"/><br/>
			<input type="submit" value="Add to list"/>
		</form>
		<h2 align="center">My list</h2>
		<table border="1px" width="100%">
			<tr>
				<th>Id</th>
				<th>Details</th>
				<th>Post Time</th>
				<th>Edit Time</th>
				<th>Edit</th>
				<th>Delete</th>
				<th>Text Post</th>
			</tr>
			<?php
				include('db.php');

				$sql = "SELECT * FROM list";
				$result = $mysqli -> query($sql);

				while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
					// $details = file_get_contents('cpp_copy.cpp');
					echo "<tr>";
					echo '<td align="center">' . $row['id'] . "</td>";
					if($row['is_plaintext'] == 'no')
					{
						echo "<td ><pre><code>" . $row['details'] . "</code></pre></td>";
					}
					else
					{
						echo '<td align="center">' . $row['details'] . "</td>";
					}

					echo '<td align="center">' . $row['date_posted'] . " - " . $row['time_posted'] . "</td>";
					echo '<td align="center">' . $row['date_edited'] . " - " . $row['time_edited'] . "</td>";
					echo '<td align="center"><a href="edit.php?id='. $row['id'] .'">edit</a> </td>';
					echo '<td align="center"><a href="#" onclick="myFunction('.$row['id'].')">delete</a> </td>';
					echo '<td align="center">'. $row['is_plaintext']. "</td>";
					echo "</tr>";
				}

				$result -> free_result();

				$mysqli -> close();
			?>
		</table>
		<script>
			function myFunction(id)
			{
			var r=confirm("Are you sure you want to delete this record?");
			if (r==true)
			  {
			  	window.location.assign("delete.php?id=" + id);
			  }
			}
		</script>
	</body>
</html>