<?php
// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kidsgames";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$error_username = "";
$error_email = "";
$error_password = "";
$error_confirm_password = "";
$error_full_name = "";
$error_phone_number = "";
$registration_successful = false;



// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
  $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
  $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);

  // Check if any field is empty
  if (empty($username)) {
    $error_username = "Please enter your username.";
  }
  if (empty($email)) {
    $error_email = "Please enter your email.";
  }
  if (empty($password)) {
    $error_password = "Please enter a password.";
  }
  if (empty($confirm_password)) {
    $error_confirm_password = "Please confirm your password.";
  }
  if (empty($full_name)) {
    $error_full_name = "Please enter your full name.";
  }
  if (empty($phone_number)) {
    $error_phone_number = "Please enter your phone number.";
  }

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

  // Validate email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error_email = "Invalid email format.";
  }

  // Validate password and confirm password
  if (strlen($password) < 8) {
    $error_password = "Password must be at least 8 characters long.";
  }
  if ($password !== $confirm_password) {
    $error_confirm_password = "Passwords do not match.";
  }

  // Check if there are any errors
  if (empty($error_username) && empty($error_email) && empty($error_password) && empty($error_confirm_password) && empty($error_full_name) && empty($error_phone_number)) {
    // All inputs are valid, insert new user into database
    $query = "INSERT INTO player (username, email, password, full_name, phone_number, numLives, registration_time, session_time) VALUES (?, ?, ?, ?, ?, 6, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt === false) {
      die("mysqli_prepare() failed: " . mysqli_error($conn));
    }

    // Bind parameters
    $registration_time = date("Y-m-d H:i:s");
    $session_time = $registration_time;
    mysqli_stmt_bind_param($stmt, "sssssss", $username, $email, $password, $full_name, $phone_number, $registration_time, $session_time);
        if (mysqli_stmt_execute($stmt)) {
      // Set registration successful flag
      $registration_successful = true;
      echo '<script>document.getElementById("success-message").style.display = "block";</script>';
    } else {
      echo "Error executing statement: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
  }
  mysqli_close($conn);

}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Registration</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 50px;
      background-color: rgba(0, 0, 0, 0.7);
      border-radius: 10px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
    }

    .registration input[type="submit"] {
      background-color: #0077be;
    }

    .registration input[type="submit"]:hover {
      background-color: #005ea6;
    }

    .password-field {
      margin-right: 10px;
    }

    .eye-icon {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      right: 0;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
    }

    .password-input {
      width: 100%;
      max-width: 580px;
    }

    #success-message {
      text-align: center;
      color: black;
    }

    #success-message button {
      background-color: #0077be;
      color: #ffffff;
      border: none;
      padding: 12px 24px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
      border-radius: 4px;
      transition-duration: 0.4s;
    }

    #success-message button:hover {
      background-color: #005ea6;
      color: #ffffff;
    }
  </style>
</head>

<body>
  <div id="success-message" style="display:none;">
    <p>User has been registered!</p>
    <button onclick="goToLoginPage()">Go to Login Page</button>
    <button onclick="goToHomePage()">Go to Home Page</button>
  </div>

  <div class="container registration">
    <h1>Registration</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" placeholder="Enter your username" required>
      <span class="error">
        <?php echo $error_username; ?>
      </span>
      <br><br>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required>
      <span class="error">
        <?php echo $error_email; ?>
      </span>
      <br><br>
      <label for="password">Password:</label>
      <div class="eye-icon">
        <input type="password" id="password" name="password" placeholder="Enter your password"
          class="password-field password-input" required>
        <button class="toggle-password" type="button">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path
              d="M12 4c-4.4 0-8 3.6-8 8s3.6 8 8 8 8-3.6 8-8 s-3.6-8-8-8zm0 14.5c-3.3 0-6-2.7-6-6s2.7-6 6-6 6 2.7 6 6-2.7 6-6 6zm0-11c-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5 2.5-1.1 2.5-2 5-2.5-2.5-2.5-2.5z">
            </path>
          </svg>
        </button>
      </div>
      <span class="error">
        <?php echo $error_password; ?>
      </span>
      <br><br>
      <label for="confirm_password">Confirm Password:</label>
      <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password"
        class="password-input" required>
      <span class="error">
        <?php echo $error_confirm_password; ?>
      </span>
      <br><br>
      <label for="full_name">Full Name:</label>
      <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>
      <span class="error">
        <?php echo $error_full_name; ?>
      </span>
      <br><br>
      <label for="phone_number">Phone Number:</label>
      <input type="text" id="phone_number" name="phone_number" placeholder="Enter your phone number" required>
      <span class="error">
        <?php echo $error_phone_number; ?>
      </span>
      <br><br>
      <input type="submit" value="Register">
    </form>
  </div>
  </form>
  </div>


  <script>
    document.querySelector('.toggle-password').addEventListener('click', function () {
      const passwordField = document.getElementById('password');
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
      } else {
        passwordField.type = 'password';
      }
    });

    function goToLoginPage() {
      window.location.href = "login.php";
    }
    function goToHomePage() {
      window.location.href = "index.php";
    }

    // Show success message if registration was successful
    <?php if ($registration_successful) { ?>
      document.getElementById("success-message").style.display = "block";
    <?php } ?>
  </script>
</body>

</html>