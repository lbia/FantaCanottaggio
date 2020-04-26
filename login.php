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
    <header class="main-header">
    <?php
      echo '<div class="titolo">
              <h1>FantaCanottaggio</h1>';
              if (isset($_GET['error'])){
                if ($_GET['error'] == "emptyfields"){
                  echo '<p class="error">Riempi tutti i campi</p>';
                } else if ($_GET['error'] == "invaliduid"){
                  echo '<p class="error">Username invalido</p>';
                } else if ($_GET['error'] == "wrongpassword"){
                  echo '<p class="error">Username o password sbagliati</p>';
                } else{
                  echo '<p class="error">Errore</p>';
                }
              } else if (isset($_GET['signup']) && $_GET['signup'] == "success"){
                echo '<p class="success">Ti sei registrato correttamente</p>';
              }
      echo    '<form action="includes/login.inc.php" method="post">
              <input type="text" name="uid" placeholder="Username..."';
              if (isset($_GET['uid'])){
                echo ' value='.$_GET['uid'];
              }
      echo    '><input type="password" name="pwd" placeholder="Password...">
              <button type="submit" name="login-submit">Login</button>';
    ?>
              </form>
              <!--
              <br>
              <div>
                <p style="display: inline;">Non ti sei ancora registrato?</p>
                <p style="display: inline; margin-left: 4px;"><a href="signup.php">Registrati</a></p>
              </div>
              -->
              <div>
                <p style="display: inline-block;">Torna alla</p>
                <p style="display: inline; margin-left: 4px;"><a href="index.php">Home</a></p>
              </div>
            </div>
          </header>
