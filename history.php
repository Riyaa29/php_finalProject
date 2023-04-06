<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kidsGames";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the history view
$sql = "SELECT session_time, user_id, full_name, result, numLives FROM player";
$result = $conn->query($sql);

// Display history table
echo "<table>";
echo "<tr><th>ID</th><th>Full Name</th><th>Result</th><th>Number of Lives</th><th>Date/Time</th></tr>";
while ($row = $result->fetch_assoc()) {
  echo "<tr><td>".$row['user_id']."</td><td>".$row['full_name']."</td><td>".$row['result']."</td><td>".$row['numLives']."</td><td>".$row['session_time']."</td></tr>";
}
echo "</table>";

// Close the database connection
$conn->close();
?>