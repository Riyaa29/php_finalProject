<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Registration Form</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1>Registration Form</h1>
    <form action="registeration.php" method="post">
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

<?php
// Assuming the connection to the database has already been established
$conn = mysqli_connect("localhost", "username", "password", "database_name");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    // Check if username already exists in the database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $error_username = "Sorry, this username already exists. Please, choose another one.";
    }

    // Check if passwords match
    if ($password != $confirm_password) {
        $error_password = "Sorry, you entered 2 different passwords.";
    }

    // Check if first name is not empty
    if (empty($first_name)) {
        $error_first_name = "Sorry, your first name cannot be empty.";
    }

    // Check if last name does not start with a digit
    if (preg_match('/^\d/', $last_name)) {
        $error_last_name = "Sorry, your last name cannot start with a digit or number.";
    }

    // If no errors, insert user into database
    if (empty($error_username) && empty($error_password) && empty($error_first_name) && empty($error_last_name)) {
        $query = "INSERT INTO users (username, password, first_name, last_name) VALUES ('$username', '$password', '$first_name', '$last_name')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            header("Location: login.php");
            exit();
        } else {
            $error_general = "Sorry, something went wrong. Please try again later.";
        }
    }
}
?>