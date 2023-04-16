<!DOCTYPE html>
<html>

<head>
    <title>Level 6: Identify the minimum and the maximum number</title>
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
        <h1>Level 6: Identify the minimum and the maximum number</h1>
        <p>A set of 6 different letters generated randomly is shown and the user must use the form available
            to write the minimum number and the maximum number (from the order 0 to 100). </p>
        <?php
        include 'session-helper.php';
        initialize_session();
        $numbers = generate_random_numbers(6);

        // get the first and last letter of the set
        $min_number = min($numbers);
        $max_number = max($numbers);


        ?>

        <p><strong>Numbers to identify min and max:</strong>
            <?php echo implode(", ", $numbers); ?>
        </p>

        <form method="post">
            <label for="min_number" style="color: white;">Minimum number:</label>
            <input type="text" name="min_number" id="min_number" maxlength="3">
            <br><br>
            <label for="max_number" style="color: white;">Maximum number:</label>
            <input type="text" name="max_number" id="max_number" maxlength="3">
            <br><br>
            <input type="submit" name="submit" value="Submit">
            <input type="hidden" name="original_minimum_number" value="<?php echo $min_number; ?>">
            <input type="hidden" name="original_maximum_number" value="<?php echo $max_number; ?>">
        </form>

        <?php
        // check if the form has been submitted
        if (isset($_POST['submit'])) {
            $original_minimum_number = explode(',', $_POST['original_minimum_number']);
            $original_maximum_number = explode(',', $_POST['original_maximum_number']);
            $user_minimum_number = explode(',', $_POST['min_number']);
            ;
            $user_maximum_number = explode(',', $_POST['max_number']);

            // check if the letters entered are correct
            if ($user_minimum_number === $original_minimum_number && $user_maximum_number === $original_maximum_number) {
                echo "<p>Correct - You have identified the minimum and maximum numbers of the set.</p>";
                echo "<p>You have won the game with " . $_SESSION['numLives'] . " lives remaining.</p>";
                check_pass();
                $_SESSION['numLives'] = 6; // reset lives to 6
                update_lives($_SESSION['username'], $_SESSION['numLives']);
                // pass the updated numLives value to the next page
                $numLives = $_SESSION['numLives'] ?? '';
                if (isset($_SESSION['level']) && $_SESSION['level'] < 6) {
                    echo "<button onclick=\"location.href='level" . ($_SESSION['level'] + 1) . ".php?numLives=" . $numLives . "';\">Go to the Next Level</button>";
                    echo "<button onclick=\"location.href='login.php?stop=1';\">Stop this Session</button>";
                } else {
                    // if it's the last level
                    echo "<button onclick=\"location.href='index.php';\">Home Page</button>";
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
                    echo "<p>The correct Minimum Number was : " . implode("", [$original_maximum_number]) . "</p>";
                    echo "<p>The correct Maximum Number was : " . implode("", [$original_minimum_number]) . "</p>";
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
                    if ($user_minimum_number === $original_minimum_number && $user_maximum_number === $original_maximum_number) {
                        // if the guess is correct, display a success message
                        echo "<p>Correct - You have identified the minimum and maximum numbers of the set.</p>";
                        echo "<p>You have won the game with " . $_SESSION['numLives'] . " lives remaining.</p>";
                        check_pass();
                        $_SESSION['numLives'] = 6; // reset lives to 6
                        update_lives($_SESSION['username'], $_SESSION['numLives']);

                        echo "<button onclick=\"location.href='index.php';\">Home Page</button>";
                        echo "<button onclick=\"location.href='level1.php';\">Play Again</button>";
                        echo "<button onclick=\"location.href='login.php';\">Sign Out</button>";
                    } else if ($user_minimum_number !== $original_minimum_number && $user_maximum_number !== $original_maximum_number) {
                        // if the guess has no correct letters, display a failure message
                        echo "<p>Incorrect. You have " . $_SESSION['numLives'] . " lives remaining.</p>";
                        echo "<p>Guess again!</p>";

                    } else if ($user_minimum_number !== $original_minimum_number && $user_maximum_number === $original_maximum_number) {
                        // if the guess has no correct numbers, display a failure message
                        echo "<p>The first number you entered is incorrect! </p>";
                        echo "<p>Incorrect. You have " . $_SESSION['numLives'] . " lives remaining.</p>";
                        echo "<p>Guess again!</p>";
                    } else if ($user_minimum_number === $original_minimum_number && $user_maximum_number !== $original_maximum_number) {
                        // if the guess has no correct numbers, display a failure message
                        echo "<p>The last number you entered is incorrect! </p>";
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