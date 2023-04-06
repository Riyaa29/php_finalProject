<!DOCTYPE html>
<html>

<head>
    <title>Game Level 2: Order letters in descending order</title>
    <style>
        /* set background color */
        body {
            background-image: url('https://img.freepik.com/free-vector/black-wallpaper-with-motion-lines-background_1017-30151.jpg?w=360');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: auto;
        }


        /* style container */
        .container {
            margin: 0 auto;
            width: 60%;
            text-align: center;
            background-image: url('https://i.pinimg.com/originals/00/e8/57/00e857a3c087bfcc085119e0e0aef8e8.gif');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            animation: pulse 4s ease-in-out infinite;
            padding: 50px;
            position: absolute;
            top: 20%;
            left: 15%;
            transform: translate(-50%, -50%);
            border-radius: 20px;
        }



        /* style user info */
        .user-info {
            margin-bottom: 20px;
        }

        /* style h1 */
        h1 {
            font-size: 36px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #fff;
            text-shadow: 1px 1px 1px #000;
        }

        /* style p */
        p {
            font-size: 20px;
            margin-bottom: 20px;
            color: #fff;
            text-shadow: 1px 1px 1px #000;
        }

        /* style form */
        form {
            display: inline-block;
            margin-bottom: 20px;
        }

        /* style input fields */
        input[type="text"] {
            font-size: 20px;
            padding: 10px;
            border-radius: 5px;
            border: 2px solid #ccc;
            box-shadow: inset 0 2px 2px rgba(0, 0, 0, 0.1);
            transition: border-color 0.2s ease-in-out;
        }

        /* animate input fields on focus */
        input[type="text"]:focus {
            border-color: #0099ff;
        }

        /* style submit button */
        input[type="submit"] {
            font-size: 20px;
            padding: 10px;
            border-radius: 5px;
            background-color: #0099ff;
            color: #fff;
            border: none;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
            transition: background-color 0.2s ease-in-out;
        }

        /* animate submit button on hover */
        input[type="submit"]:hover {
            background-color: #007acc;
        }

        /* style result message */
        .result-message {
            font-size: 20px;
            margin-bottom: 20px;
            color: #fff;
            text-shadow: 1px 1px 1px #000;
        }

        /* style button */
        button {
            font-size: 20px;
            padding: 10px;
            border-radius: 5px;
            background-color: #0099ff;
            color: #fff;
            border: none;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
            transition: background-color 0.2s ease-in-out;
            margin-right: 10px;
        }

        /* animate button on hover */
        button:hover {
            background-color: #007acc;
        }

        /* pulse animation */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
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
        }
        else {
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
        }
    }
}


        ?>
    </div>
</body>

</html>