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

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
  <title>History</title>
  <style>
    /* Shared styles for all pages */
    body {
      background-image: url('https://cdn2.vectorstock.com/i/1000x1000/33/11/background-blue-abstract-website-pattern-vector-3523311.jpg');
      background-size: cover;
      background-position: center;
      font-family: 'Roboto', sans-serif;
      color: #fff;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 50px;
      background-color: rgba(0, 0, 0, 0.7);
      border-radius: 10px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
    }

    h1 {
      text-align: center;
      margin-bottom: 50px;
      font-size: 32px;
      text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 50px;
    }

    table th {
      background-color: #222;
      color: #fff;
      text-align: left;
      padding: 10px;
    }

    table td {
      border: 1px solid #ccc;
      padding: 10px;
    }

    /* Specific styles for this page */
    table tr:nth-child(even) {
      background-color: rgba(255, 255, 255, 0.1);
    }

    table tr:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>History</h1>
    <table>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Result</th>
        <th>Number of Lives</th>
        <th>Date/Time</th>
      </tr>
      <?php
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['user_id'] . "</td><td>" . $row['full_name'] . "</td><td>" . $row['result'] . "</td><td>" . $row['numLives'] . "</td><td>" . $row['session_time'] . "</td></tr>";
      }
      ?>
    </table>
  </div>
</body>

</html>