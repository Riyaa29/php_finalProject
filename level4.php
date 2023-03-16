<!DOCTYPE html>
<html>

<head>
    <title>Level 4: Order numbers in descending order</title>
    <link rel="stylesheet" href="stylelevel.css">
</head>

<body>
    <h1>Level 4: Order numbers in descending order</h1>
    <p>A set of 6 different numbers generated randomly is shown below. Please use the form to write them in ascending
        order (from a to z).</p>
    <?php
    // include the session_helper.php file
    include 'session-helper.php';
    // call the initialize_session() function to initialize the session variables
    initialize_session();

    // Generate a set of 6 random numbers between 0 and 100
    $numbers = array();
    while (count($numbers) < 6) {
        $num = rand(0, 100);
        if (!in_array($num, $numbers)) {
            $numbers[] = $num;
        }
    }

    ?>

    <p><strong>Numbers to order:</strong>
        <?php echo implode(", ", $numbers); ?>
    </p>
    <form method="post">
        <label for="numbers">Order the numbers:</label>
        <input type="hidden" name="original" id="original"
            value="<?php echo htmlspecialchars(implode(', ', $numbers)); ?>">
        <input type="text" name="numbers" id="numbers" maxlength="30">
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    // check if the form has been submitted
    if (isset($_POST['submit'])) {
        $original_numbers = explode(' ', $_POST['original']);
        $ordered_numbers = explode(' ', $_POST['numbers']);

        rsort($original_numbers);

        // check if the numbers entered are the same as the ones displayed and in the correct order
        if ($ordered_numbers === $original_numbers) {
            echo "<p>Correct - Your numbers have been correctly ordered in descending order.</p>";
            echo "<button onclick=\"location.href='level4.php';\">Go to the Next Level</button>";
        }
        // check if the numbers entered are not the same as the ones displayed
        elseif (count(array_intersect($ordered_numbers, $original_numbers)) == 0) {
            echo "<p>Incorrect - All your numbers are different than ours.</p>";
            echo "<button onclick=\"location.reload();\">Try Again this Level</button>";

            // decrement the number of lives by 1 each time the user loses the game
            decrement_lives();
        }
        // check if the numbers entered are partially correct
        elseif (count(array_intersect($ordered_numbers, $original_numbers)) != count($original_numbers)) {
            echo "<p>Incorrect - Some of your numbers are different than ours.</p>";
            echo "<button onclick=\"location.reload();\">Try Again this Level</button>";

            // decrement the number of lives by 1 each time the user loses the game
            decrement_lives();
        }
        // check if the numbers entered are the same as the ones displayed but in the wrong order
        else {
            echo "<p>Incorrect - Your numbers have not been correctly ordered in descending order.</p>";
            echo "<button onclick=\"location.reload();\">Try Again this Level</button>";

            // decrement the number of lives by 1 each time the user loses the game
            decrement_lives();
        }
    }
    ?>

</body>

</html>