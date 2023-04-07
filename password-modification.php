<?php
// Check if the form has been submitted
if (isset($_POST['modify'])) {
    // Retrieve form data
    $existing_username = $_POST['existing-username'];
    $new_password = $_POST['new-password'];
    $confirm_new_password = $_POST['confirm-new-password'];

    // Check if the new password matches the confirm password
    if ($new_password != $confirm_new_password) {
        echo "Passwords do not match.";
    } else {
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

        // Update password in the players table
        $sql = "UPDATE player SET password=? WHERE username=?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("ss", $new_password, $existing_username);

        if ($stmt->execute()) {
            echo "<p style='color: black; text-align: center;'>Password updated successfully!</p>";
        } else {
            echo "Error updating password: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Password Modification Form</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function redirectToLogin() {
            window.location.href = "login.php";
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Password Modification Form</h1>
        <form action="password-modification.php" method="post">
            <label for="existing-username">Existing Username:</label>
            <input type="text" id="existing-username" name="existing-username" required>

            <label for="new-password">New Password:</label>
            <input type="password" id="new-password" name="new-password" required>

            <label for="confirm-new-password">Confirm New Password:</label>
            <input type="password" id="confirm-new-password" name="confirm-new-password" required>

            <input type="submit" name="modify" value="Modify">
            <input type="submit" name="sign-in" value="Sign-In" onclick="redirectToLogin()">
        </form>
    </div>
</body>

</html>
