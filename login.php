<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1>Login Form</h1>
    <form action="login.php" method="post">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <input type="submit" name="connect" value="Connect">
      <input type="submit" name="signup" value="Sign-Up">
    </form>
  </body>
</html>

<?php
session_start();

// Check if the form has been submitted
if (isset($_POST['connect'])) {
  // Retrieve the form data
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Check if the username and password are correct
  if ($username == 'correct_username' && $password == 'correct_password') {
    // Start a new session and redirect to the game page
    $_SESSION['username'] = $username;
    header('Location: game.php');
    exit();
  } else {
    // Display an error message
    echo 'Sorry, you entered a wrong username! <a href="password-modification.php">Forgotten? Please, change your password.</a>';
  }
} else if (isset($_POST['signup'])) {
  // Redirect to the sign-up page
  header('Location: registration.php');
  exit();
}
?>
