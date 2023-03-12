<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Password Modification Form</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1>Password Modification Form</h1>
    <form action="password-modification.php" method="post">
    <label for="existing-username">Existing Username:</label>
    <input type="text" id="existing-username" name="existing-username" required>
    
    <label for="new-password">New Password:</label>
    <input type="password" id="new-password" name="new-password" required>
    
    <label for="confirm-new-password">Confirm New Password:</label>
    <input type="password" id="confirm-new-password" name="confirm-new-password" required>
    
    <input type="submit" name="modify" value="Modify">
    <input type="submit" name="sign-in" value="Sign-In">
</form>
  </body>
</html>

<?php
// Check if the form has been submitted
if(isset($_POST['modify'])) {
  // Retrieve form data
  $existing_username = $_POST['existing-username'];
  $new_password = $_POST['new-password'];
  $confirm_new_password = $_POST['confirm-new-password'];

  // Check if the new password matches the confirm password
  if($new_password != $confirm_new_password) {
    echo "Passwords do not match.";
  }
  else {
    // Code to update the user's password in the database goes here
    // ...

    echo "Password updated successfully!";
  }
}
else if(isset($_POST['sign-in'])) {
  // Redirect the user to the login form
  header("Location: login-form.php");
  exit();
}
?>