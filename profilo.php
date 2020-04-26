<?php
  require "header.php";
 ?>

    <main>
      <?php
      require 'includes/dbh.inc.php';
      require 'includes/readDatabase.inc.php';

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
        echo '<h2 style="margin-left: 140px;">Profili</h2>';
        $si = '<td align="center"><p class="success" style="display: inline;">si</p></td>';
        $no = '<td align="center"><p class="error" style="display: inline;">no</p></td>';
        echo '<table>';
        echo '<tr>
                <th align="left">Utente</th>
                <th><a style="color: black;" href="vediRegionali.php">Regionali</a></th>
                <th><a style="color: black;" href="vediNazionali.php">Nazionali</a></th>
                <th><a style="color: black;" href="formazione.php">Formazione</a></th>
             </tr>';
        if (isset($username)){
          echo '<tr>';
          echo '<td align="left"><a href=profilo.php?username='.$username.'>Io</a></td>';
          $inserita = true;
          if (getRegionali($username) === false){
            $inserita = false;
          }
          if ($inserita){ echo $si; } else{ echo $no; }
          $inserita = true;
          if (getNazionali($username) === false){
            $inserita = false;
          }
          if ($inserita){ echo $si; } else{ echo $no; }
          $inserita = true;
          if (getFormazioneRegionale1($username) === false){
            $inserita = false;
          }
          if ($inserita){ echo $si; } else{ echo $no; }
          echo '</tr>';
          echo '<tr height="10px"></tr>';
        }
        while ($row = mysqli_fetch_assoc($result)){
          if (!isset($username) || $row['uidUsers'] != $username){
            echo '<tr>';
            echo '</td><td align="left"><a href=profilo.php?username='.$row['uidUsers'].'>'.$row['uidUsers'].'</a></td>';
            $inserita = true;
            if (getRegionali($row['uidUsers']) === false){
              $inserita = false;
            }
            if ($inserita){
              echo $si;
            } else{
              echo $no;
            }
            $inserita = true;
            if (getNazionali($row['uidUsers']) === false){
              $inserita = false;
            }
            if ($inserita){
              echo $si;
            } else{
              echo $no;
            }
            $inserita = true;
            if (getFormazioneRegionale1($row['uidUsers']) === false){
              $inserita = false;
            }
            if ($inserita){
              echo $si;
            } else{
              echo $no;
            }
            echo '</tr>';
          }
        }
        echo '</table>';
      } else{
        if (isset($username) && $_GET['username'] == $username){
          echo '<h2 style="display: inline; margin-right: 5px;">Profilo</h2>
                <h2 style="display: inline;"><a style="color: black; text-decoration: underline;" href="classifica.php?username='.$username.'">mio</a></h2>';
        } else{
          echo '<h2 style="display: inline; margin-right: 5px;">Profilo di</h2>
                <h2 style="display: inline;"><a style="color: black; text-decoration: underline;" href="classifica.php?username='.$_GET['username'].'">'.$_GET['username'].'</a></h2>';
        }
        echo '<h3>Atleti</h3>
              <ul>';
        if (getRegionali($_GET['username']) === false){
          echo '<li><a class="error" href="vediRegionali.php?username='.$_GET['username'].'">Regionali</a></li>';
        } else{
          echo '<li><a class="success" href="vediRegionali.php?username='.$_GET['username'].'">Regionali</a></li>';
        }
        if (getNazionali($_GET['username']) === false){
          echo '<li><a class="error" href="vediNazionali.php?username='.$_GET['username'].'">Nazionali</a></li>';
        } else{
          echo '<li><a  class="success" href="vediNazionali.php?username='.$_GET['username'].'">Nazionali</a></li>';
        }
        echo '</ul>';
        if (getFormazioneRegionale1($_GET['username']) === false){
          echo '<h3><a class="error" href="formazione.php?username='.$_GET['username'].'">Formazione</a></h3>';
        } else{
          echo '<h3><a class="success" href="formazione.php?username='.$_GET['username'].'">Formazione</a></h3>';
        }
        echo '<h3><a href="classifica.php?username='.$_GET['username'].'">Punteggi</a></h3>';
      }

       ?>
      <br>
    </main>

<?php
  require "footer.php"
 ?>
