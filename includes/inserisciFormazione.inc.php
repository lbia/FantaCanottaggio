<?php

if (isset($_POST['inserisciFormazione-submit'])){
  require 'dbh.inc.php';
  require 'readDatabase.inc.php';

  session_start();
  $username = $_SESSION['username'];
  $fn = array();
  $fc = array();
  list($nomi, $cognomi) = getRegionali($username);
  $fineurl = "";
  for ($i = 0; $i < 9; $i++){
    $fineurl .= "&r".$i."=";
    if (isset($_POST['r'.$i])){
      $fineurl .= "si";
      $tmp = explode(".", $_POST['r'.$i]);
      array_push($fn, $tmp[0]);
      array_push($fc, $tmp[1]);
    } else{
      $fineurl .= "no";
    }
  }
  if (count($fn) != 7){
    header("Location: ../inserisciFormazione.php?error=seleziona".$fineurl);
    exit();
  }
  $inserisci = "";
  for ($i = 0; $i < 7; $i++){
    $inserisci .= $fn[$i].".".$fc[$i];
    if ($i != 6){
      $inserisci .= ",";
    }
  }
  $sql = "SELECT uidUsers FROM garareg1 WHERE uidUsers=?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../inserisciFormazione.php?error=sqlerrorprep");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $resultCheck = mysqli_stmt_num_rows($stmt);
  if ($resultCheck > 0){
    $sql = "UPDATE garareg1 SET nomi=? WHERE uidUsers=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../inserisciFormazione.php?error=lollo");
      exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $inserisci, $username);
    mysqli_stmt_execute($stmt);
  } else{
    $sql = "INSERT INTO garareg1 (uidUsers, nomi) VALUES (?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../inserisciFormazione.php?error=sqlerrorinsert");
      exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $inserisci);
    mysqli_stmt_execute($stmt);
  }
  $_SESSION['fn'] = array();
  $_SESSION['fc'] = array();
  for ($i = 0; $i < 7; $i++){
    $_SESSION['fn'][$i] = $fn[$i];
    $_SESSION['fc'][$i] = $fc[$i];
  }
  header("Location: loadClassifica.inc.php");
  exit();
} else{
  header("Location: ../index.php");
  exit();
}
