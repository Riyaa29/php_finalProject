<?php

function initialize_session() {
    // start the session if it hasn't been started already
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // initialize session variables
    if (!isset($_SESSION['lives'])) {
        $_SESSION['lives'] = 6;
    }
    if (!isset($_SESSION['level'])) {
        $_SESSION['level'] = 1;
    }
}

function check_game_over() {
    // check if the user has any lives left
    if ($_SESSION['lives'] <= 0) {
        // user has lost the game
        echo "Game over!";
        // end the session
        session_destroy();
        exit;
    }
}

function decrement_lives() {
    // decrement the number of lives by 1 each time the user makes a wrong attempt
    $_SESSION['lives']--;

    // display the number of lives remaining
    echo "You have " . $_SESSION['lives'] . " lives left.";

    // check if the user has any lives left
    check_game_over();
}

?>
