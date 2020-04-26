<?php

require "readWeb.inc.php";

if (isset($_POST['inserisciNazionali-submit'])){
  require 'dbh.inc.php';

  session_start();
  $username = $_SESSION['username'];
  $nn = array();
  $nc = array();
  for ($i = 0; $i < 11; $i++){
    array_push($nn, removeSpace($_POST['n'.$i.'n']));
    array_push($nc, removeSpace($_POST['n'.$i.'c']));
  }
  $inserisci = "";
  $fineurl = "";
  $empty = false;
  $valid = true;
  for ($i = 0; $i < 11; $i++){
    $inserisci .= $nn[$i].".".$nc[$i];
    if ($i != 10){
      $inserisci .= ",";
    }
    $nvuoto = false;
    if (empty($nn[$i])){
      $nvuoto = true;
    }
    $cvuoto = false;
    if (empty($nc[$i])){
      $cvuoto = true;
    }
    if ($nvuoto || $cvuoto){
      $empty = true;
    }
    $nvalido = true;
    if (!isAlpha($nn[$i])){
      $nvalido = false;
    }
    $cvalido = true;
    if (!isAlpha($nc[$i])){
      $cvalido = false;
    }
    if (!$nvalido || !$cvalido){
      $valid = false;
    }
    if (!$nvuoto && $nvalido){
      $fineurl .= "&n".$i."n=".$nn[$i];
    } else{
      $fineurl .= "&n".$i."n=";
    }
    if (!$cvuoto && $cvalido){
      $fineurl .= "&n".$i."c=".$nc[$i];
    } else{
      $fineurl .= "&n".$i."c=";
    }
  }
  if ($empty == true){
    header("Location: ../inserisciNazionali.php?error=emptyfields".$fineurl);
    exit();
  } else if ($valid == false){
    header("Location: ../inserisciNazionali.php?error=invalidfields".$fineurl);
    exit();
  }
  $sql = "SELECT uidUsers FROM nazionali WHERE uidUsers=?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../inserisciNazionali.php?error=sqlerrorprep");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $resultCheck = mysqli_stmt_num_rows($stmt);
  if ($resultCheck > 0){
    $sql = "UPDATE nazionali SET nomi=? WHERE uidUsers=?";
    //$sql = "DELETE FROM regionaleprova WHERE uidUsers=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../inserisciNazionali.php?error=lollo");
      exit();
    }
    //mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_bind_param($stmt, "ss", $inserisci, $username);
    mysqli_stmt_execute($stmt);
  } else{
    $sql = "INSERT INTO nazionali (uidUsers, nomi) VALUES (?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../inserisciNazionali.php?error=sqlerrorinsert");
      exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $inserisci);
    mysqli_stmt_execute($stmt);
  }
  $_SESSION['nn'] = array();
  $_SESSION['nc'] = array();
  for ($i = 0; $i < 11; $i++){
    $_SESSION['nn'][$i] = $nn[$i];
    $_SESSION['nc'][$i] = $nc[$i];
  }
  header("Location: ../inserisciNazionali.php?formazione=success");
  exit();
} else{
  header("Location: ../index.php");
  exit();
}
