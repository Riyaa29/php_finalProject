<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Order Quest</title>
  <style>
    /* basic styling */
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f2f5;
    }

    header,
    footer {
      background-color: #212529;
      color: white;
      padding: 10px;
    }

    nav {
      background-color: #495057;
      color: white;
      padding: 10px;
    }

    article {
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    /* navigation links */
    nav a {
      display: inline-block;
      color: white;
      margin-right: 10px;
      text-decoration: none;
      padding: 8px 15px;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    nav a:hover {
      background-color: #212529;
    }

    /* form labels */
    form label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
      color: #212529;
    }

    /* form inputs */
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ced4da;
      border-radius: 4px;
      box-sizing: border-box;
      font-size: 16px;
      color: #212529;
    }

    input[type="submit"] {
      background-color: #007bff;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
      background-color: #0069d9;
    }

    /* form errors */
    .error {
      color: red;
      font-style: italic;
      margin-bottom: 10px;
    }

    /* game summary */
    .game-summary {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 20px;
    }

    .game-summary img {
      width: 400px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      margin-bottom: 20px;
    }

    .game-summary h2 {
      font-size: 36px;
      margin-bottom: 10px;
      text-align: center;
    }

    .game-summary p {
      font-size: 18px;
      text-align: justify;
      line-height: 1.5;
      max-width: 800px;
      margin-bottom: 10px;
    }
  </style>
</head>

<body>
  <header>
    <h1 style="text-align:center">Order Quest</h1>
  </header>
  <nav>
    <a href="login.php">Login</a>
    <a href="registration.php">Registration</a>
    <a href="history.php">History</a>
  </nav>
  <div class="game-summary"
    style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/5/59/Five_ivory_dice.jpg'); background-size: cover; background-position: center center; height: 400px; display: flex; align-items: center; justify-content: center; text-align: center; color: white;">
    <p style="font-size: 1.8em;">Join the adventure and become the ultimate order fulfiller in this thrilling game. Use
      your strategy and time management skills to deliver the correct items to customers and earn points. But be
      careful, the clock is ticking and mistakes are costly!</p>
  </div>
  <article
    style="text-align: justify; padding: 20px; background-color: #D3D3D3; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);">
    <p style="font-size: 18px;">"Order Quest" is a game that challenges players to order a set of numbers or letters in
      ascending or descending order, identify the first and last letters, or find the minimum and maximum numbers in a
      set. The game has six levels, and players must complete each level to progress to the next. Each level has a form
      for the player to enter their answers, and a result message is displayed indicating whether the answer is correct
      or incorrect.</p>
    <p style="font-size: 18px;">If the player wins the game, they are congratulated, and if they lose all six lives,
      it's game over. The game allows players to play with numbers from 0 to 100 and alphabet letters from a to z, lower
      case or/and uppercase. The game interface is designed to be intuitive and user-friendly, with buttons for sign
      out, stop session, play again, and home page. The game is programmed in PHP, HTML, and styling, and can be
      accessed through a web browser.</p>
  </article>
  <footer style="text-align:center">
    <p>Developed by Riya Nagpal, Inna Maximova & Malav Desai</p>
  </footer>

</body>

</html>