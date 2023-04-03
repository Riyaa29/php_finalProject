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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
  $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
  $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);

  // Check if any field is empty
  if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($full_name) || empty($phone_number)) {
    $error_empty = "Please fill in all fields.";
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

  // Validate password and confirm password
  if (strlen($password) < 8) {
    $error_password = "Password must be at least 8 characters long.";
  }
  if ($password !== $confirm_password) {
    $error_confirm_password = "Passwords do not match.";
  }

  if (empty($error_empty) && empty($error_username) && empty($error_password) && empty($error_confirm_password)) {
    $query = "INSERT INTO player (username, email, password, full_name, phone_number) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt === false) {
      die("mysqli_prepare() failed: " . mysqli_error($conn));
    }
    else{
      echo "User has been registered!";
      
    }
    // // Hash the password
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // if ($hashed_password === false) {
    //   die("Password hash failed.");
    // }

    mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $password, $full_name, $phone_number);
    if (mysqli_stmt_execute($stmt)) {
      header("");
      exit();
    } else {
      die("Registration failed: " . mysqli_error($conn));
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
}

// If the form hasn't been submitted yet, show the registration form
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
  </style>
</head>

<body>
  <div class="container registration">
    <h1>Registration</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" placeholder="Enter your username" required><br><br>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required><br><br>

      <label for="password">Password:</label>
      <div class="eye-icon">
        <input type="password" id="password" name="password" placeholder="Enter your password" class="password-field"
          required>
        <button class="toggle-password" type="button">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path
              d="M12 4c-4.4 0-8 3.6-8 8s3.6 8 8 8 8-3.6 8-8 s-3.6-8-8-8zm0 14.5c-3.3 0-6-2.7-6-6s2.7-6 6-6 6 2.7 6 6-2.7 6-6 6zm0-11c-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5 2.5-1.1 2.5-2.5-1.1-2.5-2.5-2.5zm0 3c-.6 0-1 .4-1 1s.4 1 1 1 1-.4 1-1-.4-1-1-1z" />
          </svg>
        </button>
      </div><br><br>

      <label for="confirm_password">Confirm Password:</label>
      <div class="eye-icon">
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password"
          class="password-field" required>
        <button class="toggle-password" type="button">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path
              d="M12 4c-4.4 0-8 3.6-8 8s3.6 8 8 8 8-3.6 8-8 s-3.6-8-8-8zm0 14.5c-3.3 0-6-2.7-6-6s2.7-6 6-6 6 2.7 6 6-2.7 6-6 6zm0-11c-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5 2.5-1.1 2.5-2.5-1.1-2.5-2.5-2.5zm0 3c-.6 0-1 .4-1 1s.4 1 1 1 1-.4 1-1-.4-1-1-1z" />
          </svg>
        </button>
      </div><br><br>

      <label for="full_name">Full Name:</label>
      <input type="text" id="full_name" name="full_name" placeholder="Enter your Full name"><br><br>

      <label for="phone_number">Phone Number:</label>
      <input type="text" id="phone_number" name="phone_number" placeholder="Enter your phone number"><br><br>

      <input type="submit" value="Register">
    </form>
  </div>
</body>

</html>