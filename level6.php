<!DOCTYPE html>
<html>

<head>
    <title>Level 6: Identify the minimum and the maximum number</title>
    <link rel="stylesheet" href="stylelevel.css">
</head>

<body>
    <h1>Level 6: Identify the minimum and the maximum number</h1>
    <p>A set of 6 different letters generated randomly is shown below. Please use the form to write the first letter and
        the last letter (in alphabetical order).</p>
    <div>
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

        // get the first and last letter of the set
        $min_number = min($numbers);
        $max_number = max($numbers);

        ?>

        <body>
            <div class="container">
                <p><strong>Numbers to identify min and max:</strong>
                    <?php echo implode(", ", $numbers); ?>
                </p>

                <form method="post">
                    <label for="min_number">Minimum number:</label>
                    <input type="text" name="min_number" id="min_number" maxlength="2">
                    <br><br>
                    <label for="max_number">Maximum number:</label>
                    <input type="text" name="max_number" id="max_number" maxlength="2">
                    <br><br>
                    <input type="submit" name="submit" value="Submit">
                    <input type="hidden" name="original_min_number" value="<?php echo $min_number; ?>">
                    <input type="hidden" name="original_max_number" value="<?php echo $max_number; ?>">
                </form>

                <?php
                // check if the form has been submitted
                if (isset($_POST['submit'])) {
                    $original_min_number = $_POST['original_min_number'];
                    $original_max_number = $_POST['original_max_number'];
                    $user_min_number = strtolower($_POST['min_number']);
                    $user_max_number = strtolower($_POST['max_number']);

                    // check if the numbers entered are correct
                    if ($user_min_number == $original_min_number && $user_max_number == $original_max_number) {
                        echo "<p>Correct - You have identified the minimum and maximum numbers of the set.</p>";
                        echo '<button onclick="location.href=\'index.php\';">Home Page</button>';
                        echo '<button onclick="location.href=\'logout.php\';">Sign Out</button>';
                        echo '<button onclick="location.href=\'level1.php\';">Play Again</button>';
                        // end the session
                        session_destroy();
                        exit;
                    } elseif (!is_numeric($user_min_number) || !is_numeric($user_max_number)) {
                        echo "<p>Please enter valid numbers.</p>";
                    } else {
                        echo "<p>Incorrect - The program will now exit.</p>";
                    }
                }
                ?>




        </body>

</html>