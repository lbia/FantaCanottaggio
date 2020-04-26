<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['utenti'])) {
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans&display=swap" rel="stylesheet">
  <style>
    img[alt="www.000webhost.com"] {
      display: none;
    }
  </style>
  <title>FantaCanottaggio</title>
</head>

<body>
  <header class="main-header">
    <nav class="main-nav">
      <div class="titolo">
        <h1>FantaCanottaggio</h1>
        <img src="data/images/fantacanottaggio.jpg" width="200" height="100">
        <form action="includes/logout.inc.php" method="post">
          <?php
          if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            echo '<p style="display: inline; font-weight: bold;">Username:</p>';
            echo '<p style="display: inline-block; margin-left: 6px;"><a href="profilo.php?username=' . $username . '">' . $username . '</a></p>';
            echo '<button type="submit" name="logout-submit" style="padding: 0.4em; margin-left: 10px;">Logout</button>';
          } else {
            echo '<p style="display: inline;">Vai al</p>';
            echo '<p style="display: inline-block; margin-left: 6px;"><a href="login.php">Login</a></p>';
          }
          ?>
        </form>
      </div>
      <div class="barra">
        <ul>
          <li><a href="home.php">Home</a></li>
          <li><a href="regole.php">Regole</a></li>
          <li><a href="classifica.php">Classifica</a></li>
          <li><a href="profilo.php">Profili</a></li>
          <li><a href="atleta.php?mode=cerca">Atleti</a></li>
        </ul>
      </div>
    </nav>
  </header>