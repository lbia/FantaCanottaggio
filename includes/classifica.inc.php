<?php

require "regionale.inc.php";

if (isset($_GET['username']) && isset($_GET['gara'])){
  $username = $_GET['username'];
  $gara = $_GET['gara'];
  $formazione = getFormazioneGara($gara, $username);
  echo '<h2 style="display: inline; margin-right: 3px;">Punteggi di</h2>
        <h2 style="display: inline;"><a style="color: black;" href="profilo.php?username='.$username.'">'.$username.'</a></h2>';
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
        <h2 style="display: inline;"><a style="color: black;" href="profilo.php?username='.$username.'">'.$username.'</a></h2>';
  echo '<br><br>';
  echo '<table>';
  echo '<tr><th align="left">Gara</th><th>Punteggio</th></tr>';
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
    echo '<td align="center">'.$punteggio.'</td>';
    echo '</tr>';
  }
  echo '</table>';
} else{
  header("Location: ../index.php");
  exit();
}
