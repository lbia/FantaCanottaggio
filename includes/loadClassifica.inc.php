<?php

require "regionale.inc.php";

function ricaricaClassifica($gara){
  $utenti = getUtenti();
  $punteggi = array();
  foreach ($utenti as $username){
    $formazione = getFormazioneGara($gara, $username);
    if ($formazione !== false){
      list($nomi, $cognomi) = $formazione;
      $punteggio = calculatePunteggioGara($gara, $nomi, $cognomi);
      array_push($punteggi, $punteggio);
    } else{
      array_push($punteggi, 0);
    }
  }
  list($utentiOrdinati, $punteggiOrdinati) = ordinaClassifica($utenti, $punteggi);
  $_SESSION['utenti'.$gara] = array();
  $_SESSION['punteggi'.$gara] = array();
  $file = fopen("../data/text/classifica".$gara.".txt", "w");
  for ($i = 0; $i < count($utentiOrdinati); $i++){
    array_push($_SESSION['utenti'.$gara], $utentiOrdinati[$i]);
    array_push($_SESSION['punteggi'.$gara], $punteggiOrdinati[$i]);
    fprintf($file, "%d %s\n", $punteggiOrdinati[$i], $utentiOrdinati[$i]);
  }
  fclose($file);
}

for ($i = 0; $i < count($_SESSION['gareTotali']); $i++){
  ricaricaClassifica($_SESSION['gareTotali'][$i]);
}
if (isset($_POST['loadClassifica-submit'])){
  header("Location: ../classifica.php?ricarica=success");
  exit();
} else{
  header("Location: ../inserisciFormazione.php?formazione=success");
  exit();
}
