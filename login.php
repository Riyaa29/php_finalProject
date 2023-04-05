<?php
session_start();

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kidsgames";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if (isset($_POST['connect'])) {
    // Retrieve the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate that both fields are not empty
    if (empty($username)) {
        $error_msg = "Username can't be empty.";
    } else if (empty($password)) {
        $error_msg = "Password can't be empty.";
    } else {
        // Prepare the SQL statement
        $sql = "SELECT * FROM player WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);

        // Check if the username and password are correct
        if ($result->num_rows == 1) {
            // Start a new session and redirect to the level1 page
            $_SESSION['username'] = $username;
            $_SESSION['lives'] = 6; // Initialize lives to 6 when the user logs in
            header('Location: level1.php');
            exit();
        } else {
            // Display an error message
            $error_msg = 'Sorry, the username or password you entered is incorrect. <a href="password-modification.php">Forgot your password?</a>';
        }
    }
} else if (isset($_POST['signup'])) {
    // Redirect to the sign-up page
    header('Location: registration.php');
    exit();
}
else if (isset($_POST['homepage'])) {
    // Redirect to the Home page
    header('Location: index.php');
    exit();
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Login Form</h1>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password">

            <div class="form-buttons">
                <input type="submit" name="connect" value="Connect">
                <input type="submit" name="signup" value="Sign Up" href="registration.php">
                <input type="submit" name="homepage" value="Home Page" href="index.php">
            </div>
        </form>

        <?php if (isset($error_msg)): ?>
            <div class="error">
                <?php echo $error_msg; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
