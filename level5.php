<!DOCTYPE html>
<html>

<head>
    <title>Level 5: Identify first and last letters</title>
    <link rel="stylesheet" href="levelstyle.css">
</head>

<body>
    <div class="container">
        <div class="user-info">
            <?php
            // start the session and display the welcome message and the number of lives left for the user
            session_start();
            echo "<p>Welcome, " . $_SESSION['username'] . "!</p>";
            ?>
        </div>
        <h1>Level 5: Identify first and last letters</h1>
        <p>A set of 6 different letters generated randomly is shown below. Please use the form to write the first letter
            and
            the last letter (in alphabetical order). </p>
        <?php
        include 'session-helper.php';
        initialize_session();
        $letters = generate_random_letters(6);

        // get the first and last letter of the set
        $first_letter = min($letters);
        $last_letter = max($letters);

        ?>

        <p><strong>Letters to identify first and last:</strong>
            <?php echo implode(", ", $letters); ?>
        </p>

        <form method="post">

            <label for="first_letter" style="color: white;">First letter:</label>
            <input type="text" name="first_letter" id="first_letter" maxlength="1" required>
            <br><br>
            <label for="last_letter" style="color: white;">Last letter:</label>
            <input type="text" name="last_letter" id="last_letter" maxlength="1" required>
            <br><br>
            <input type="submit" name="submit" value="Submit">
            <input type="hidden" name="original_first_letter" value="<?php echo $first_letter; ?>">
            <input type="hidden" name="original_last_letter" value="<?php echo $last_letter; ?>">
        </form>

        <?php
        // check if the form has been submitted
        if (isset($_POST['submit'])) {
            $original_first_letter = $_POST['original_first_letter'];
            $original_last_letter = $_POST['original_last_letter'];
            $user_first_letter = strtolower($_POST['first_letter']);
            $user_last_letter = strtolower($_POST['last_letter']);

            // check if the letters entered are correct
            if ($user_first_letter === $original_first_letter && $user_last_letter === $original_last_letter) {
                echo "<p>Correct - You have identified the first and last letters of the set.</p>";
                echo "<p>You have " . $_SESSION['numLives'] . " lives remaining.</p>";
                // pass the updated numLives value to the next page
                $numLives = $_SESSION['numLives'] ?? '';
                if (isset($_SESSION['level']) && $_SESSION['level'] < 6) {
                    echo "<button onclick=\"location.href='level" . ($_SESSION['level'] + 1) . ".php?numLives=" . $numLives . "';\">Go to the Next Level</button>";
                    echo "<button onclick=\"location.href='login.php?stop=1';\">Stop this Session</button>";
                } else {
                    // if it's the last level
                    echo "<button onclick=\"location.href='level6.php';\">Next Level</button>";
                    echo "<button onclick=\"location.href='level1.php';\">Play Again</button>";
                    echo "<button onclick=\"location.href='login.php';\">Sign Out</button>";

                    if ($_SESSION['numLives'] < 0) {
                        // if the user loses the game
                        echo "<p>Game Over. You have run out of lives.</p>";
                        check_game_over();
                    }
                }
            } else {
                // decrease numLives by 1
                decrement_lives();

                if ($_SESSION['numLives'] <= 0) {
                    // if there are no more lives, end the game
                    echo "<p>Game Over. You have run out of lives.</p>";
                    echo "<p>The correct First letter was : " . implode("", [$original_last_letter]) . "</p>";
                    echo "<p>The correct Last letter was : " . implode("", [$original_first_letter]) . "</p>";
                    check_fail();
                    $_SESSION['numLives'] = 6; // reset lives to 6
                    update_lives($_SESSION['username'], $_SESSION['numLives']);
                    check_game_over();
                    echo "<button onclick=\"location.href='index.php';\">Home Page</button>";
                    echo "<button onclick=\"location.href='level1.php';\">Play Again</button>";
                    echo "<button onclick=\"location.href='login.php';\">Sign Out</button>";

                } else if (isset($_POST['playAgain'])) {
                    // if the user has no lives left and clicks "Play Again"
                    $_SESSION['numLives'] = 6; // reset lives to 6
                    update_lives($_SESSION['username'], $_SESSION['numLives']);
                    header("Location: level1.php"); // start a new game
                } else {
                    // if the user has remaining lives, offer another chance to guess
                    if ($user_first_letter === $original_first_letter && $user_last_letter === $original_last_letter) {
                        // if the guess is correct, display a success message
                        echo "<p>Correct - You have identified the first and last letters of the set.</p>";
                    } else if ($user_first_letter !== $original_first_letter && $user_last_letter !== $original_last_letter) {
                        // if the guess has no correct letters, display a failure message
                        echo "<p>Incorrect. You have " . $_SESSION['numLives'] . " lives remaining.</p>";
                        echo "<p>Guess again!</p>";

                    } else if ($user_first_letter !== $original_first_letter && $user_last_letter === $original_last_letter) {
                        // if the guess has no correct letters, display a failure message
                        echo "<p>The first letter you entered is incorrect! </p>";
                        echo "<p>Incorrect. You have " . $_SESSION['numLives'] . " lives remaining.</p>";
                        echo "<p>Guess again!</p>";
                    } else if ($user_first_letter === $original_first_letter && $user_last_letter !== $original_last_letter) {
                        // if the guess has no correct letters, display a failure message
                        echo "<p>The last letter you entered is incorrect! </p>";
                        echo "<p>Incorrect. You have " . $_SESSION['numLives'] . " lives remaining.</p>";
                        echo "<p>Guess again!</p>";
                        echo "<button onclick=\"location.href='login.php';\">Sign Out</button>";
                    }
                }
            }
        }
        ?>

    </div>

</body>

</html>