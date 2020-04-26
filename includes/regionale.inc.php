<?php

require "readWeb.inc.php";
require "readDatabase.inc.php";

function getNomeLungo($gara){
  if ($gara == "regionale1"){
    return "Regionale 1 2019";
  } else if ($gara == "regionale2"){
    return "Regionale 2 2019";
  } else if ($gara == "inverno"){
    return "Inverno sul Po";
  } else if ($gara == "pisa"){
    return "Pisa 2x 4-";
  }
}

function startSession(){
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
}

startSession();

function isPresenteGara($gara, $nome, $cognome){
  return isPresenteTipoRegionale($_SESSION['iscritti'.$gara], $nome, $cognome);
}

function getPunteggioGara($gara, $nome, $cognome){
  return getPunteggioTipoRegionale($_SESSION['iscritti'.$gara], $_SESSION['risultati'.$gara], $nome, $cognome);
}

function calculatePunteggioGara($gara, $nomi, $cognomi){
  return calculatePunteggioTipoRegionale($_SESSION['iscritti'.$gara], $_SESSION['risultati'.$gara], $nomi, $cognomi);
}

/*
function isPresenteGara($gara, $nome, $cognome){
  if ($gara == "regionale1"){
    return isPresenteRegionale1($nome, $cognome);
  } else if ($gara == "inverno"){
    return isPresenteInverno($nome, $cognome);
  } else if ($gara == "pisa"){
    return isPresentePisa($nome, $cognome);
  }
}

function getPunteggioGara($gara, $nome, $cognome){
  if ($gara == "regionale1"){
    return getPunteggioRegionale1($nome, $cognome);
  } else if ($gara == "inverno"){
    return getPunteggioInverno($nome, $cognome);
  } else if ($gara == "pisa"){
    return getPunteggioPisa($nome, $cognome);
  }
}

function calculatePunteggioGara($gara, $nomi, $cognomi){
  if ($gara == "regionale1"){
    return calculatePunteggioRegionale1($nomi, $cognomi);
  } else if ($gara == "inverno"){
    return calculatePunteggioInverno($nomi, $cognomi);
  } else if ($gara == "pisa"){
    return calculatePunteggioPisa($nomi, $cognomi);
  }
}

function isPresenteRegionale1($nome, $cognome){
  $iscritti = readPageFromFile(getPath("regionale1Iscritti.txt"));
  return isPresenteTipoRegionale($iscritti, $nome, $cognome);
}

function getPunteggioRegionale1($nome, $cognome){
  $iscritti = readPageFromFile(getPath("regionale1Iscritti.txt"));
  $risultati = readPageFromFile(getPath("regionale1Risultati.txt"));
  return getPunteggioTipoRegionale($iscritti, $risultati, $nome, $cognome);
}

function calculatePunteggioRegionale1($nomi, $cognomi){
  $punteggio = 0;
  for ($p = 0; $p < count($nomi); $p++){
    $punteggio += getPunteggioRegionale1($nomi[$p], $cognomi[$p])[0];
  }
  return $punteggio;
}

function isPresenteInverno($nome, $cognome){
  $iscritti = readPageFromFile(getPath("invernoIscritti.txt"));
  return isPresenteTipoRegionale($iscritti, $nome, $cognome);
}

function getPunteggioInverno($nome, $cognome){
  $iscritti = readPageFromFile(getPath("invernoIscritti.txt"));
  $risultati = readPageFromFile(getPath("invernoRisultati.txt"));
  return getPunteggioTipoRegionale($iscritti, $risultati, $nome, $cognome);
}

function calculatePunteggioInverno($nomi, $cognomi){
  $punteggio = 0;
  for ($p = 0; $p < count($nomi); $p++){
    $punteggio += getPunteggioInverno($nomi[$p], $cognomi[$p])[0];
  }
  return $punteggio;
}

function isPresentePisa($nome, $cognome){
  $iscritti = readPageFromFile(getPath("pisaIscritti.txt"));
  return isPresenteTipoRegionale($iscritti, $nome, $cognome);
}

function getPunteggioPisa($nome, $cognome){
  $iscritti = readPageFromFile(getPath("pisaIscritti.txt"));
  $risultati = readPageFromFile(getPath("pisaRisultati.txt"));
  return getPunteggioTipoRegionale($iscritti, $risultati, $nome, $cognome);
}

function calculatePunteggioPisa($nomi, $cognomi){
  $punteggio = 0;
  for ($p = 0; $p < count($nomi); $p++){
    $punteggio += getPunteggioPisa($nomi[$p], $cognomi[$p])[0];
  }
  return $punteggio;
}*/
