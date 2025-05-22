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
    <body>
        <?php
            echo "<p>Hello World!</p>";
        ?>
        <a href="login.php">Click here to login</a> <br/>
        <a href="register.php">Click here to register</a>
    
        <br/>
        <h2 align="center">List</h2>
        <table width="100%" border="1px">
            <tr>
                <th>Id</th>
                <th>Details</th>
                <th>Post Time</th>
                <th>Edit Time</th>
            </tr>

            <?php
            // $mysqli = new mysqli("localhost","root","","first_db");
            include('db.php');

            $sql = "SELECT * FROM list WHERE is_plaintext='yes'";
            $result = $mysqli -> query($sql);

            while ($row = $result -> fetch_assoc()) {
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
                echo "</tr>";
            }

            // Free result set
            $result -> free_result();

            $mysqli -> close();


            // // Connect to MySQL
            // $conn = mysqli_connect("localhost", "root", "", "first_db");

            // // Check connection
            // if (!$conn) {
            //     die("Connection failed: " . mysqli_connect_error());
            // }

            // // Query posts from the list table
            // $query = "SELECT * FROM list WHERE public='yes'";
            // $result = mysqli_query($conn, $query);

            // while ($row = mysqli_fetch_assoc($result)) {
            //     echo "<tr>";
            //     echo '<td align="center">' . $row['id'] . "</td>";
            //     echo '<td align="center">' . $row['details'] . "</td>";
            //     echo '<td align="center">' . $row['date_posted'] . " - " . $row['time_posted'] . "</td>";
            //     echo '<td align="center">' . $row['date_edited'] . " - " . $row['time_edited'] . "</td>";
            //     echo "</tr>";
            // }

            // mysqli_close($conn);
            ?>
        </table>
    </body>
</html>