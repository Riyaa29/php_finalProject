<!DOCTYPE html>
<html>

<head>
    <title>Level 1: Order letters in ascending order</title>
    <link rel="stylesheet" href="stylelevel.css">
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>

<body>
    <div class="container">
        <div class="user-info">
            <?php
            // start the session and display the welcome message and the number of lives left for the user
            session_start();
            $numLives = $_SESSION['numLives'] ?? '';
            echo "<p>Welcome, " . $_SESSION['username'] . "!</p>";
            echo "<p>Number of lives left: " . ($_SESSION['numLives'] ?? '') . "</p>";
            ?>
        </div>
        <h1>Level 1: Order letters in ascending order</h1>
        <p>A set of 6 different letters generated randomly is shown below. Please use the form to write them in
            ascending
            order (from a to z).</p>
        <?php
        // include the session_helper.php file
        include 'session-helper.php';
        // call the initialize_session() function to initialize the session variables
        initialize_session();

        // generate 6 random letters
        $letters = array();
        for ($i = 0; $i < 6; $i++) {
            $letter = chr(rand(97, 122)); // generate a random lowercase letter
            while (in_array($letter, $letters)) { // make sure the letter is not repeated
                $letter = chr(rand(97, 122));
            }
            $letters[] = $letter;
        }

        ?>

        <p><strong>Letters to order:</strong>
            <?php echo implode(", ", $letters); ?>
        </p>

        <form method="post">

            <label for="letters">Order the letters:</label>
            <input type="hidden" name="original" id="original" maxlength="6"
                value="<?php echo implode("", $letters) ?>">
            <input type="text" name="letters" id="letters" maxlength="6">
            <input type="submit" name="submit" value="Submit">
        </form>

        <?php
        // check if the form has been submitted
        if (isset($_POST['submit'])) {
            $original_letters = str_split(strtolower($_POST['original']));
            $ordered_letters = str_split(strtolower($_POST['letters']));

            sort($original_letters);

            // check if the letters entered are the same as the ones displayed and in the correct order
            if ($ordered_letters === $original_letters) {
                echo "<p>Correct - Your letters have been correctly ordered in ascending order.</p>";
                // pass the updated numLives value to the next page
                $numLives = $_SESSION['numLives'] ?? '';
                echo "<button onclick=\"location.href='level2.php?numLives=" . $numLives . "';\">Go to the Next Level</button>";
            }
            // check if the letters entered are not the same as the ones displayed
            elseif (count(array_intersect($ordered_letters, $original_letters)) == 0) {
                echo "<p>Incorrect - All your letters are different than ours.</p>";
                echo "<button onclick=\"location.reload();\">Try Again this Level</button>";

                // decrement the number of lives by 1 each time the user loses the game
                decrement_lives();
                $_SESSION['numLives']--;

                // check if the user has run out of lives
                check_game_over();
            }
            // check if the letters entered are partially correct
            elseif (count(array_intersect($ordered_letters, $original_letters)) != count($original_letters)) {
                echo "<p>Incorrect - Some of your letters are different than ours.</p>";
                echo "<button onclick=\"location.reload();\">Try Again this Level</button>";
            }

        }
        ?>


    </div>
</body>

</html>