<?php
  require "header.php";
 ?>

    <main>
      <?php
      require 'includes/dbh.inc.php';

      if (isset($_SESSION['username'])){
        $username = $_SESSION['username'];
      }
      if (!isset($_GET['username'])){
        $sql = "SELECT uidUsers FROM users";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
          header("Location: ../index.php?error=sqlerrorselect");
          exit();
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        echo "<h2>Atleti Regionali</h2>";
        echo "<ul>";
        if (isset($username)){
          echo '<li><a href=vediRegionali.php?username='.$username.'>Miei</a></li>';
          echo '<br>';
        }
        while ($row = mysqli_fetch_assoc($result)){
          if (!isset($username) || $row['uidUsers'] != $username){
            echo '<li><a href=vediRegionali.php?username='.$row['uidUsers'].'>'.$row['uidUsers'].'</a></li>';
          }
        }
        echo "</ul>";
      } else{
        $sql = "SELECT * FROM regionali WHERE uidUsers=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
          header("Location: ../index.php?error=sqlerrorselect");
          exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $_GET['username']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        if ($row > 0){
          if (isset($username) && $_GET['username'] == $username){
            echo "<h2>Miei atleti regionali</h2>";
          } else{
            echo "<h2>Atleti regionali di ".$_GET['username']."</h2>";
          }
          $nomiCognomi = explode(",", $row['nomi']);
          echo "<ul>";
          for ($i = 0; $i < 9; $i++){
            $tmp = explode(".", $nomiCognomi[$i]);
            echo '<li><a href="atleta.php?nome='.$tmp[0].'&cognome='.$tmp[1].'">'.$tmp[0].' '.$tmp[1].'</a></li>';
          }
          echo "</ul>";
          if (isset($username) && $_GET['username'] == $username){
            echo "<p style='font-size: 1.2em;'><a href='inserisciRegionali.php'>Modifica regionali</a></li>";
          }
        } else{
          if (isset($username) && $_GET['username'] == $username){
            echo "<p style='font-size: 1.2em;'>Non hai inserito i tuoi atleti regionali</p>";
            echo "<p style='font-size: 1.2em;'><a href='inserisciRegionali.php'>Inserisci regionali</a></li>";
          } else{
            echo "<p style='font-size: 1.2em;'>L'utente ".$_GET['username']." non ha inserito i suoi atleti regionali</p>";
          }
        }
      }

       ?>
    </main>

<?php
  require "footer.php"
 ?>
