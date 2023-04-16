<!DOCTYPE html>
<html>

<head>
    <title>Level 4: Order numbers in descending order</title>
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
        <h1>Level 4: Order numbers in descending order</h1>
        <p>A set of 6 different numbers generated randomly is shown below. Please use the form to write them in
            descending
            order (from largest to smallest). Separate each number with a comma (e.g., 1,2,23,45,9,90).</p>
        <?php
        include 'session-helper.php';
        initialize_session();
        $numbers = generate_random_numbers(6);
        ?>

        <p><strong>Numbers to order:</strong>
            <?php echo implode(", ", $numbers); ?>
        </p>
        <form method="post">
            <label for="numbers" style="color: white;">Order the numbers:</label>
            <input type="hidden" name="original" id="original" maxlength="6"
                value="<?php echo implode(",", $numbers) ?>">
            <input type="text" name="numbers" id="numbers" maxlength="30">
            <input type="submit" name="submit" value="Submit">
        </form>

        <?php
        // check if the form has been submitted
        if (isset($_POST['submit'])) {

            $original_numbers = explode(',', $_POST['original']);
            $ordered_numbers = explode(',', $_POST['numbers']);
            rsort($original_numbers); // sort in descending order
        
            // check if the numbers entered are the same as the ones displayed and in the correct order
            if ($ordered_numbers === $original_numbers) {
                echo "<p>Correct - Your numbers have been correctly ordered in descending order.</p>";
                echo "<p>You have " . $_SESSION['numLives'] . " lives remaining.</p>";
                // pass the updated numLives value to the next page
                $numLives = $_SESSION['numLives'] ?? '';
                if (isset($_SESSION['level']) && $_SESSION['level'] < 6) {
                    echo "<button onclick=\"location.href='level" . ($_SESSION['level'] + 1) . ".php?numLives=" . $numLives . "';\">Go to the Next Level</button>";
                    echo "<button onclick=\"location.href='login.php?stop=1';\">Stop this Session</button>";
                } else {
                    // if it's the last level
                    echo "<button onclick=\"location.href='level5.php';\">Next Level</button>";
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
                    echo "<p>The correct answer was: " . implode("", $original_numbers) . "</p>";
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
                    $diff_numbers = array_diff($ordered_numbers, $original_numbers);
                    if (count($diff_numbers) == count($ordered_numbers)) {
                        // if all the numbers or numbers entered are different (not similar) than the ones displayed
                        echo "<p>Incorrect - All your numbers are different than ours</p>";
                    } elseif (count($diff_numbers) == 0) {
                        // if all the numbers or numbers entered are the same displayed and their order is correct
                        echo "<p>Correct - Your numbers have been correctly ordered in ascending order.</p>";
                    } else {
                        // if some of the numbers or numbers entered are different than the ones displayed
                        echo "<p>Incorrect - Some of your numbers are different than ours</p>";
                    }
                    // display the remaining lives and prompt the user to guess again
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