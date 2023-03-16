<!DOCTYPE html>
<html>
<head>
    <title>Level 5: Identify first and last letters</title>
    <link rel="stylesheet" href="stylelevel.css">
</head>
<body>
    <h1>Level 5: Identify first and last letters</h1>
    <p>A set of 6 different letters generated randomly is shown below. Please use the form to write the first letter and
        the last letter (in alphabetical order).</p>
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

// sort($letters); // sort the letters in ascending order

// get the first and last letter of the set
$first_letter = min($letters);
$last_letter = max($letters);

?>

<p><strong>Letters to identify first and last:</strong>
    <?php echo implode(", ", $letters); ?>
</p>

<form method="post">

    <label for="first_letter">First letter:</label>
    <input type="text" name="first_letter" id="first_letter" maxlength="1">
    <br><br>
    <label for="last_letter">Last letter:</label>
    <input type="text" name="last_letter" id="last_letter" maxlength="1">
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
        echo "<button onclick=\"location.href='level6.php';\">Go to the Next Level</button>";
    }
    // check if the first letter entered is incorrect
    elseif ($user_first_letter !== $original_first_letter && $user_last_letter === $original_last_letter) {
        echo "<p>Incorrect - The first letter you entered is not correct.</p>";
        echo "<button onclick=\"location.reload();\">Try Again this Level</button>";
        // decrement the number of lives by 1 each time the user loses the game
        decrement_lives();
            } 
        }
?>
</body>
</html>