<?php

require "readWeb.inc.php";

if (isset($_POST['inserisciRegionali-submit'])){
  require 'dbh.inc.php';

  session_start();
  $username = $_SESSION['username'];
  $rn = array();
  $rc = array();
  for ($i = 0; $i < 9; $i++){
    array_push($rn, removeSpace($_POST['r'.$i.'n']));
    array_push($rc, removeSpace($_POST['r'.$i.'c']));
  }
  $inserisci = "";
  $fineurl = "";
  $empty = false;
  $valid = true;
  for ($i = 0; $i < 9; $i++){
    $inserisci .= $rn[$i].".".$rc[$i];
    if ($i != 8){
      $inserisci .= ",";
    }
    $nvuoto = false;
    if (empty($rn[$i])){
      $nvuoto = true;
    }
    $cvuoto = false;
    if (empty($rc[$i])){
      $cvuoto = true;
    }
    if ($nvuoto || $cvuoto){
      $empty = true;
    }
    $nvalido = true;
    if (!isAlpha($rn[$i])){
      $nvalido = false;
    }
    $cvalido = true;
    if (!isAlpha($rc[$i])){
      $cvalido = false;
    }
    if (!$nvalido || !$cvalido){
      $valid = false;
    }
    if (!$nvuoto && $nvalido){
      $fineurl .= "&r".$i."n=".$rn[$i];
    } else{
      $fineurl .= "&r".$i."n=";
    }
    if (!$cvuoto && $cvalido){
      $fineurl .= "&r".$i."c=".$rc[$i];
    } else{
      $fineurl .= "&r".$i."c=";
    }
  }
  if ($empty == true){
    header("Location: ../inserisciRegionali.php?error=emptyfields".$fineurl);
    exit();
  } else if ($valid == false){
    header("Location: ../inserisciRegionali.php?error=invalidfields".$fineurl);
    exit();
  }
  $sql = "SELECT uidUsers FROM regionali WHERE uidUsers=?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../inserisciRegionali.php?error=sqlerrorprep");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $resultCheck = mysqli_stmt_num_rows($stmt);
  if ($resultCheck > 0){
    $sql = "UPDATE regionali SET nomi=? WHERE uidUsers=?";
    //$sql = "DELETE FROM regionaleprova WHERE uidUsers=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../inserisciRegionali.php?error=lollo");
      exit();
    }
    //mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_bind_param($stmt, "ss", $inserisci, $username);
    mysqli_stmt_execute($stmt);
  } else{
    $sql = "INSERT INTO regionali (uidUsers, nomi) VALUES (?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../inserisciRegionali.php?error=sqlerrorinsert");
      exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $inserisci);
    mysqli_stmt_execute($stmt);
  }
  $_SESSION['rn'] = array();
  $_SESSION['rc'] = array();
  for ($i = 0; $i < 9; $i++){
    $_SESSION['rn'][$i] = $rn[$i];
    $_SESSION['rc'][$i] = $rc[$i];
  }
  header("Location: ../inserisciRegionali.php?formazione=success");
  exit();
} else{
  header("Location: ../index.php");
  exit();
}
