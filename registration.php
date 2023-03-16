<?php
// Connect to database
$conn = mysqli_connect("localhost", "root", "", "kidsgames");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if (isset($_POST["create"])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
  $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
  $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);

  // Check if username already exists in the database
  $query = "SELECT * FROM player WHERE username = ?";
  $stmt = mysqli_prepare($conn, $query);
  if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $username);
    if (mysqli_stmt_execute($stmt)) {
      $result = mysqli_stmt_get_result($stmt);
      if (mysqli_num_rows($result) > 0) {
        $error_username = "Sorry, this username already exists. Please choose another one.";
      }
    } else {
      echo "Error executing statement: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
  } else {
    echo "Error preparing statement: " . mysqli_error($conn);
  }

  // Validate password and confirm password
  if (strlen($password) < 8) {
    $error_password = "Password must be at least 8 characters long.";
  }
  if ($password !== $confirm_password) {
    $error_confirm_password = "Passwords do not match.";
  }

  // If no errors, insert user into database
  if (empty($error_username) && empty($error_password) && empty($error_first_name) && empty($error_last_name) && empty($error_confirm_password)) {
    $query = "INSERT INTO player (username, password, first_name, last_name) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt === false) {
      die("mysqli_prepare() failed: " . mysqli_error($conn));
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    if ($hashed_password === false) {
      die("Password hash failed.");
    }

    mysqli_stmt_bind_param($stmt, "ssss", $username, $hashed_password, $first_name, $last_name);
    if (mysqli_stmt_execute($stmt)) {
      header("Location: login.php");
      exit();
    } else {
      $error_general = "Sorry, something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt);
  }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Registration Form</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1>Registration Form</h1>
  <form action="./registration.php" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required>

    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" required>

    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" required>

    <input type="submit" name="create" value="Create">
    <input type="submit" name="signin" value="Sign-In">
  </form>
</body>

</html>