<!DOCTYPE html>
<html>

<head>
    <title>Game Level 2: Order letters in descending order</title>
    <link rel="stylesheet" href="stylelevel.css">
</head>

<body>
    <div class="container">
        <div class="user-info">
            <?php
            // start the session and display the welcome message and the number of lives left for the user
            session_start();

            // retrieve the numLives value from the query parameter
            $numLives = $_GET['numLives'] ?? '';
            // update the numLives session variable
            $_SESSION['numLives'] = $numLives;
            echo "<p>Welcome, " . $_SESSION['username'] . "!</p>";
            echo "<p>Number of lives left: " . ($_SESSION['numLives'] ?? '') . "</p>";
            ?>
        </div>
        <h1>Game Level 2: Order letters in descending order</h1>
        <p>A set of 6 different letters generated randomly is shown below. Please use the form to write them in
            descending
            order (from z to a).</p>
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
            <input type="text" name="letters" id="letters" maxlength="6" required>
            <input type="submit" name="submit" value="Submit">
        </form>
        <?php
        // check if the form has been submitted
        if (isset($_POST['submit'])) {
            $original_letters = str_split(strtolower($_POST['original']));
            $ordered_letters = str_split(strtolower($_POST['letters']));

            arsort($original_letters); // change rsort to arsort to sort in descending order
        
            // check if the letters entered are the same as the ones displayed and in the correct order
            if ($ordered_letters === $original_letters) {
                echo "<p>Correct - Your letters have been correctly ordered in descending order.</p>";
                echo "<button onclick=\"location.href='level3.php';\">Go to the Next Level</button>";
            }
            // check if the letters entered are not the same as the ones displayed
            elseif (count(array_intersect($ordered_letters, $original_letters)) == 0) {
                echo "<p>Incorrect - All your letters are different than ours.</p>";
                echo "<button onclick=\"location.reload();\">Try Again this Level</button>";

                // decrement the number of lives by 1 each time the user loses the game
                decrement_lives();
            }
            // check if the letters entered are partially correct
            elseif (count(array_intersect($ordered_letters, $original_letters)) != count($original_letters)) {
                echo "<p>Incorrect - Some of your letters are different than ours.</p>";
                echo "<button onclick=\"location.reload();\">Try Again this Level</button>";
                // decrement the number
            } else {
                echo "<p>Incorrect - Your letters are not in the correct order.</p>";
                echo "<button onclick=\"location.reload();\">Try Again this Level</button>";

                // decrement the number of lives by 1 each time the user loses the game
                decrement_lives();
            }
        }
        ?>
    </div>
</body>

</html>