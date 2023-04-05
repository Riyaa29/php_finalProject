<!DOCTYPE html>
<html>

<head>
    <title>Game Over</title>
    <style>
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #ccc;
            text-align: center;
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        h1 {
            font-size: 36px;
            margin-top: 0px;
        }

        p {
            font-size: 24px;
            margin-bottom: 30px;
        }

        button {
            background-color: #ff5722;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 20px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #e64a19;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // Logout user
            $.ajax({
                url: "logout.php",
                type: "POST",
                success: function () {
                    console.log("User logged out");
                }
            });

            // Reset lives in database
            $.ajax({
                url: "resetlives.php",
                type: "POST",
                success: function () {
                    console.log("Lives reset");
                }
            });
        });
    </script>
</head>

<body>
    <div class="container">
        <h1>Game Over</h1>
        <p>Your lives have been reset to 6.</p>
        <a href="index.php"><button>Back to Index Page</button></a>
    </div>
</body>

</html>