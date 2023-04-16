<?php

function initialize_session()
{

    // connect to the database
    $conn = mysqli_connect("localhost", "root", "", "kidsGames");

    // check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // get the user's number of lives from the database
    $username = $_SESSION['username'];
    $sql = "SELECT numLives FROM player WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    // check if the query execution was successful
    if ($result === false) {
        die("Query failed: " . mysqli_error($conn));
    }

    // check if the result set contains any rows
    if (mysqli_num_rows($result) > 0) {
        // fetch the results and store them in the session
        $row = mysqli_fetch_assoc($result);
        $_SESSION['numLives'] = $row['numLives'];
    } else {
        // set the default number of lives to 6
        $_SESSION['numLives'] = 6;
    }

    // close the database connection
    mysqli_close($conn);
}



function update_lives($username, $numLives)
{
    // connect to the database
    $conn = mysqli_connect("localhost", "root", "", "kidsGames");

    // check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // check if the number of lives is less than zero
    if ($numLives < 0) {
        $numLives = 0;
    }

    // check if the number of lives is greater than 6
    if ($numLives > 6) {
        $numLives = 6;
    }

    // update the user's number of lives in the database
    $stmt = $conn->prepare("UPDATE player SET numLives=? WHERE username=?");
    if (!$stmt) {
        printf("Error: %s\n", $conn->error);
        exit();
    }
    $stmt->bind_param("is", $numLives, $username);
    $stmt->execute();
    $stmt->close();

    // close the database connection
    mysqli_close($conn);
}

function check_game_over()
{
    // check if the user has any lives left
    if ($_SESSION['numLives'] <= 0) {
        // user has lost the game
        echo "Game over!";
        // end the session
        session_destroy();
        header("Location: login.php");
        exit();
    }
    $conn = mysqli_connect("localhost", "root", "", "kidsGames");

    // check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $username = $_SESSION['username'];
    $session_time = date("Y-m-d H:i:s");
    $sql = "UPDATE player SET session_time='$session_time' WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    // check if the query execution was successful
    if ($result === false) {
        die("Query failed: " . mysqli_error($conn));
    }

}

function decrement_lives()
{
    if (isset($_SESSION['numLives'])) {
        $_SESSION['numLives'] -= 1;
        $username = $_SESSION['username'];
        $numLives = $_SESSION['numLives'];
        // update the numLives value in the database
        $conn = mysqli_connect("localhost", "root", "", "kidsGames");
        $stmt = $conn->prepare("UPDATE player SET numLives=? WHERE username=?");
        if (!$stmt) {
            printf("Error: %s\n", $conn->error);
            exit();
        }
        $stmt->bind_param("is", $numLives, $username);
        $stmt->execute();
        $stmt->close();
        // close the database connection
        mysqli_close($conn);
    }
}

function check_fail()
{
    $conn = mysqli_connect("localhost", "root", "", "kidsGames");

    // check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $username = $_SESSION['username'];
    $sql = "Update player SET result='fail' WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    // check if the query execution was successful
    if ($result === false) {
        die("Query failed: " . mysqli_error($conn));
    }
}
function check_pass()
{
    $conn = mysqli_connect("localhost", "root", "", "kidsGames");

    // check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $username = $_SESSION['username'];
    $sql = "Update player SET result='pass' WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    // check if the query execution was successful
    if ($result === false) {
        die("Query failed: " . mysqli_error($conn));
    }
}

function generate_random_letters($num)
{
    $letters = array();
    for ($i = 0; $i < $num; $i++) {
        $letter = chr(rand(97, 122));
        while (in_array($letter, $letters)) {
            $letter = chr(rand(97, 122));
        }
        $letters[] = $letter;
    }
    return $letters;
}

function generate_random_numbers($num)
{
    $numbers = array();
    for ($i = 0; $i < $num; $i++) {
        $number = rand(0, 100);
        while (in_array($number, $numbers)) {
            $number = rand(0, 100);
        }
        $numbers[] = $number;
    }
    return $numbers;
}