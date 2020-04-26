<?php
  require "header.php";
 ?>

    <main>
      <?php
      require 'includes/dbh.inc.php';
      require 'includes/readDatabase.inc.php';
      require 'includes/readWeb.inc.php';

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
        echo "<h2>Formazioni</h2>";
        echo "<ul>";
        if (isset($username)){
          echo '<li><a href=formazione.php?username='.$username.'>Mia</a></li>';
          echo '<br>';
        }
        while ($row = mysqli_fetch_assoc($result)){
          if (!isset($username) || $row['uidUsers'] != $username){
            echo '<li><a href=formazione.php?username='.$row['uidUsers'].'>'.$row['uidUsers'].'</a></li>';
          }
        }
        echo "</ul>";
      } else{
        $sql = "SELECT * FROM garareg1 WHERE uidUsers=?";
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
            echo "<h2>Mia formazione</h2>";
          } else{
            echo "<h2>Formazione di ".$_GET['username']."</h2>";
          }
          $nomiCognomi = explode(",", $row['nomi']);
          echo "<ul>";
          for ($i = 0; $i < 7; $i++){
            $tmp = explode(".", $nomiCognomi[$i]);
            echo '<li><a href="atleta.php?nome='.$tmp[0].'&cognome='.$tmp[1].'">'.$tmp[0].' '.$tmp[1].'</li>';
          }
          echo "</ul>";
          if (isset($username) && $_GET['username'] == $username){
            if (getRegionali($username) !== false){
              $anno = getAnno();
              $mese = getMese();
              $giorno = getGiorno();
              $ora = getOra();
              $minuti = getMinuti();
              $secondi = getSecondi();
              if ($anno == 2020 && $mese == 3 && $giorno == 4){
                echo "<p style='font-size: 1.2em;'><a href='inserisciFormazione.php'>Modifica la formazione</a></li>";
              } else{
                echo '<p class="error" style="font-size: 1.2em;">Non puoi più modificare la formazione</p>';
              }
            }
          }
        } else{
          if (isset($username) && $_GET['username'] == $username){
            echo "<p style='font-size: 1.2em;'>Non hai inserito la formazione</p>";
            if (getRegionali($username) !== false){
              $anno = getAnno();
              $mese = getMese();
              $giorno = getGiorno();
              $ora = getOra();
              $minuti = getMinuti();
              $secondi = getSecondi();
              if ($anno == 2020 && $mese == 3 && $giorno == 4){
                echo "<p style='font-size: 1.2em;'><a href='inserisciFormazione.php'>Inserisci la formazione</a></li>";
              } else{
                echo '<p class="error" style="font-size: 1.2em;">Non puoi più inserire la formazione</p>';
              }
            } else{
              echo "<p style='font-size: 1.2em;' class='error'>Non hai inserito i tuoi atleti regionali</li>";
              echo "<p style='font-size: 1.2em;'><a href='inserisciRegionali.php'>Inserisci regionali</a></li>";
            }
          } else{
            echo "<p style='font-size: 1.2em;'>L'utente ".$_GET['username']." non ha inserito la formazione</p>";
          }
        }
      }

       ?>
    </main>

<?php
  require "footer.php"
 ?>
