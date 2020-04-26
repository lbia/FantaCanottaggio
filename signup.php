<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <style>img[alt="www.000webhost.com"]{display:none;}</style>
    <title>FantaCanottaggio</title>
  </head>
  <body>
    <main>
      <h1>Registrati</h1>
      <?php
        if (isset($_GET['error'])){
          if ($_GET['error'] == "emptyfields"){
            echo '<p class="error">Riempi tutti i campi</p>';
          } else if ($_GET['error'] == "invaliduid"){
            echo "<p class='error'>L'username non deve contenere spazi e caratteri strani</p>";
          } else if ($_GET['error'] == "passwordcheck"){
            echo '<p class="error">La password non corrisponde</p>';
          } else if ($_GET['error'] == "usertaken"){
            echo '<p class="error">Questo username è già stato utilizzato</p>';
          } else{
            echo '<p class="error">Errore</p>';
          }
        }
       ?>
      <form action="includes/signup.inc.php" method="post">
        <input type="text" name="uid" placeholder="Username"
        <?php
          if (isset($_GET['uid'])){
            echo ' value='.$_GET['uid'];
          }
         ?>
        ><input type="password" name="pwd" placeholder="Password">
        <input type="password" name="pwd-repeat" placeholder="Repeat Password">
        <button type="submit" name="signup-submit">Registrati</button>
      </form>
      <br>
      <div>
        <p style="display: inline;">Torna al</p>
        <p style="display: inline; margin-left: 4px;"><a href="login.php">Login</a></p>
      </div>
      <div>
        <p style="display: inline-block;">Torna alla</p>
        <p style="display: inline; margin-left: 4px;"><a href="index.php">Home</a></p>
      </div>
    </main>

<?php
  require "footer.php"
 ?>
