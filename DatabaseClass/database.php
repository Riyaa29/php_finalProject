<?php
session_start();
    class Database
    {
        function __construct($user,$pass)
        {
            $_SESSION["name"]=$user;
            $_SESSION['password']=$pass;
        }
    }

?>