<!DOCTYPE html>
<html>

<head>
    <title>Game Level 2: Order letters in descending order</title>
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
        <h1>Game Level 2: Order letters in descending order</h1>
        <p>A set of 6 different letters generated randomly is shown below. Please use the form to write them in
            descending
            order (from z to a). Enter letters without a comma or a space (e.g., abcdef).</p>
        <?php
        include 'session-helper.php';
        initialize_session();
        $letters = generate_random_letters(6);
        ?>

        <p><strong>Letters to order:</strong>
            <?php echo implode(", ", $letters); ?>
        </p>

        <form method="post">
            <label for="letters" style="color: white;">Order the letters:</label>
            <input type="hidden" name="original" id="original" maxlength="6"
                value="<?php echo implode("", $letters) ?>">
            <input type="text" name="letters" id="letters" maxlength="6" required>
            <input type="submit" name="submit" value="Submit">
        </form>
        <?php
        // check if the form has been submitted
        if (isset($_POST['submit'])) {
            $original_letters = str_split(strtolower($_POST['letters']));
            $ordered_letters = str_split(strtolower($_POST['letters']));
            rsort($ordered_letters); // sort the letters in descending order
        
            // check if the letters entered are the same as the ones displayed and in the correct order
            if ($ordered_letters === $original_letters) {
                echo "<p>Correct - Your letters have been correctly ordered in descending order.</p>";
                echo "<p>You have " . $_SESSION['numLives'] . " lives remaining.</p>";
                // pass the updated numLives value to the next page
                $numLives = $_SESSION['numLives'] ?? '';

                if (isset($_SESSION['level']) && $_SESSION['level'] < 6) {
                    // if it's not the last level
                    echo "<button onclick=\"location.href='level" . ($_SESSION['level'] + 1) . ".php?numLives=" . $numLives . "';\">Go to the Next Level</button>";
                    echo "<button onclick=\"location.href='login.php?stop=1';\">Stop this Session</button>";
                } else {
                    // if it's the last level
                    echo "<button onclick=\"location.href='level3.php';\">Next Level</button>";
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
                    echo "<p>The correct answer was: " . implode("", $original_letters) . "</p>";
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
                    // if there are remaining lives, allow the player to guess again
                    $diff_letters = array_diff($ordered_letters, $original_letters);
                    if (count($diff_letters) == count($ordered_letters)) {
                        // if all the letters entered are different than the ones displayed
                        echo "<p>Incorrect - All your letters are different than ours</p>";
                    } else {
                        // if some of the numbers or letters entered are different than the ones displayed
                        echo "<p>Incorrect - Some of your letters are different than ours</p>";
                    }
                    echo "<p>You have " . $_SESSION['numLives'] . " lives remaining.</p>";
                    echo "<p>Guess again!</p>";
                    echo "<button onclick=\"location.href='login.php';\">Sign Out</button>";
                }
            }
        }


        ?>
    </div>
</body>

</html>