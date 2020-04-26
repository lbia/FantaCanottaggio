<?php
  require "header.php";
  require "includes/regionale.inc.php";
 ?>

    <main>
      <?php
        if (empty($_GET) || isset($_GET['ricarica'])){
          echo '<h2>Classifica</h2>';
          if (isset($_GET['ricarica']) && $_GET['ricarica'] == 'success'){
            echo '<p class="success">Classifica ricaricata correttamente</p>';
          }
          if (isset($_SESSION['username'])){
            echo '<form action="includes/loadClassifica.inc.php" method="post">
                    <button type="submit" name="loadClassifica-submit">Ricarica classifica</button>
                  </form>';
          }
          echo '<p>Gare Selezionate: ';
          for ($i = 0; $i < count($_SESSION['gareSelezionate']); $i++){
            $gara = $_SESSION['gareSelezionate'][$i];
            $nomeGara = getNomeLungo($gara);
            echo $nomeGara;
            if ($i != count($_SESSION['gareSelezionate']) - 1){
              echo ', ';
            }
          }
          echo '</p>';
          echo '<p><a href="selezionaGare.php">Seleziona gare da contare nella classifica</a></p>';
          echo '<table>';
          echo '<tr>';
          echo '<th align="left">Utente</th><th>Posizone</th><th>Punteggio</th>';
          echo '</tr>';
          $utenti = getUtenti();
          $classifica = array();
          for ($i = 0; $i < count($utenti); $i++){
            $classifica[$utenti[$i]] = 0;
          }
          for ($i = 0; $i < count($_SESSION['gareSelezionate']); $i++){
            $gara = $_SESSION['gareSelezionate'][$i];
            for ($s = 0; $s < count($_SESSION['utenti'.$gara]); $s++){
              $utente = $_SESSION['utenti'.$gara][$s];
              $punteggio = $_SESSION['punteggi'.$gara][$s];
              $classifica[$utente] += $punteggio;
            }
          }
          list($utentiOrdinati, $punteggiOrdinati) = ordinaClassificaGenerale($classifica, $utenti);
          for ($i = 0; $i < count($utentiOrdinati); $i++){
            echo '<tr>';
            echo '<td align="left"><a href="classifica.php?username='.$utentiOrdinati[$i].'">'.$utentiOrdinati[$i].'</a></td>
                  <td align="center">'.($i + 1).'</td>
                  <td align="center">'.$punteggiOrdinati[$i].'</td>';
            echo '</tr>';
          }
          echo '</table>';
        } else if (isset($_GET['mode']) && $_GET['mode'] == 'atleti2019'){
          echo '<h2>Classifica atleti 2019</h2>';
          echo '<ul>';
          for ($i = 0; $i < count($_SESSION['punteggi']); $i++){
            echo '<li>'.$_SESSION['punteggi'][$i].' '.$_SESSION['nomi'][$i].'</li>';
          }
          echo '</ul>';
        } else if (isset($_GET['username']) && isset($_GET['gara'])){
          $username = $_GET['username'];
          $gara = $_GET['gara'];
          $formazione = getFormazioneGara($gara, $username);
          echo '<h2 style="display: inline; margin-right: 3px;">Punteggi di</h2>
                <h2 style="display: inline;"><a style="color: black; text-decoration: underline;" href="profilo.php?username='.$username.'">'.$username.'</a></h2>';
          echo '<h3>Gara '.getNomeLungo($gara).'</h3>';
          if (isset($_SESSION['risultati'.$gara])){
            if ($formazione !== false){
              list($nomi, $cognomi) = $formazione;
              $punnteggioTot = calculatePunteggioGara($gara, $nomi, $cognomi);
              echo '<p>Punteggio: '.$punnteggioTot.'</p>';
              echo '<ul>';
              for ($i = 0; $i < 7; $i++){
                list($punteggio, $nonIscritto) = getPunteggioGara($gara, $nomi[$i], $cognomi[$i]);
                $presente = isPresenteGara($gara, $nomi[$i], $cognomi[$i]);
                if ($presente){
                  echo '<li><p class="success" style="display: inline; margin-right: 4px;">presente</p>'.$punteggio.
                       ' <a href="atleta.php?nome='.$nomi[$i].'&cognome='.$cognomi[$i].'&gara='.$gara.'">'.$nomi[$i].' '.$cognomi[$i].'</a></li>';
                } else{
                  echo '<li><p class="error" style="display: inline; margin-right: 18px;">assente</p>'.$punteggio.
                       ' <a href="atleta.php?nome='.$nomi[$i].'&cognome='.$cognomi[$i].'&gara='.$gara.'">'.$nomi[$i].' '.$cognomi[$i].'</a></li>';
                }
              }
              echo '</ul>';
            } else{
              echo "<p>L'utente non ha inserito la formazione</p>";
            }
          } else{
            if ($formazione !== false){
              list($nomi, $cognomi) = $formazione;
              echo '<p>Punteggio: 0</p>';
              echo '<ul>';
              for ($i = 0; $i < 7; $i++){
                $presente = isPresenteGara($gara, $nomi[$i], $cognomi[$i]);
                if ($presente){
                  echo '<li><p class="success" style="display: inline; margin-right: 4px;">presente</p>'.$nomi[$i].' '.$cognomi[$i].'</li>';
                } else{
                  echo '<li><p class="error" style="display: inline; margin-right: 4px;">assente</p>'.$nomi[$i].' '.$cognomi[$i].'</li>';
                }
              }
              echo '</ul>';
            } else{
              echo "<p>L'utente non ha inserito la formazione</p>";
            }
          }
        } else if (isset($_GET['username'])){
          $username = $_GET['username'];
          echo '<h2 style="display: inline; margin-right: 3px;">Punteggi di</h2>
                <h2 style="display: inline;"><a style="color: black; text-decoration: underline;" href="profilo.php?username='.$username.'">'.$username.'</a></h2>';
          echo '<br><br>';
          echo '<table>';
          echo '<tr><th align="left">Gara</th><th>Posizione</th><th>Punteggio</th></tr>';
          for ($i = 0; $i < count($_SESSION['gareTotali']); $i++){
            echo '<tr>';
            $gara = $_SESSION['gareTotali'][$i];
            $formazione = getFormazioneGara($gara, $username);
            if ($formazione !== false){
              list($nomi, $cognomi) = $formazione;
              $punteggio = calculatePunteggioGara($gara, $nomi, $cognomi);
            } else{
              $punteggio = 0;
            }
            echo '<td align="left"><a href="classifica.php?username='.$username.'&gara='.$gara.'">'.getNomeLungo($gara).'</a></td>';
            $posizioneClassifica = -1;
            for ($c = 0; $c < count($_SESSION['utenti'.$gara]); $c++){
              if ($_SESSION['utenti'.$gara][$c] == $username){
                $posizioneClassifica = $c + 1;
                break;
              }
            }
            echo '<td align="center">'.$posizioneClassifica.'</td>';
            echo '<td align="center">'.$punteggio.'</td>';
            echo '</tr>';
          }
          echo '</table>';
        } else{
          header("Location: ../index.php");
          exit();
        }
      ?>
      <br>
    </main>

<?php
  require "footer.php"
 ?>
