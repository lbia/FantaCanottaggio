<?php

function getUtenti(){
  require 'dbh.inc.php';
  $utenti = array();
  $sql = "SELECT uidUsers FROM users";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../index.php?error=sqlerrorselect");
    exit();
  }
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  while ($row = mysqli_fetch_assoc($result)){
    array_push($utenti, $row['uidUsers']);
  }
  return $utenti;
}

function getRegionali($username){
  require 'dbh.inc.php';
  $nomi = array();
  $cognomi = array();
  $sql = "SELECT * FROM regionali WHERE uidUsers=?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../index.php?error=sqlerrorselect");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);
  if ($row > 0){
    $nomiCognomi = explode(",", $row['nomi']);
    for ($i = 0; $i < 9; $i++){
      $tmp = explode(".", $nomiCognomi[$i]);
      array_push($nomi, $tmp[0]);
      array_push($cognomi, $tmp[1]);
    }
    return array($nomi, $cognomi);
  } else{
    return false;
  }
}

function getNazionali($username){
  require 'dbh.inc.php';
  $nomi = array();
  $cognomi = array();
  $sql = "SELECT * FROM nazionali WHERE uidUsers=?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../index.php?error=sqlerrorselect");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);
  if ($row > 0){
    $nomiCognomi = explode(",", $row['nomi']);
    for ($i = 0; $i < 11; $i++){
      $tmp = explode(".", $nomiCognomi[$i]);
      array_push($nomi, $tmp[0]);
      array_push($cognomi, $tmp[1]);
    }
    return array($nomi, $cognomi);
  } else{
    return false;
  }
}

function getPossessore($cerca){
  $utenti = getUtenti();
  for ($i = 0; $i < count($utenti); $i++){
    $username = $utenti[$i];
    $regionali = getRegionali($username);
    $nazionali = getNazionali($username);
    if ($regionali !== false){
      list($rnomi, $rcognomi) = $regionali;
      for ($r = 0; $r < count($rnomi); $r++){
        if (strpos($cerca, $rnomi[$r]) !== false && strpos($cerca, $rcognomi[$r]) !== false){
          return $username;
        }
      }
    }
    if ($nazionali !== false){
      list($nnomi, $ncognomi) = $nazionali;
      for ($n = 0; $n < count($nnomi); $n++){
        if (strpos($cerca, $nnomi[$n]) !== false && strpos($cerca, $ncognomi[$n]) !== false){
          return $username;
        }
      }
    }
  }
  return false;
}

function getFormazioneGara($gara, $username){
  if ($gara == "regionale1"){
    return getFormazioneRegionale1($username);
  } else if ($gara == "regionale2"){
    return getFormazioneRegionale1($username);
  } else if ($gara == "inverno"){
    return getFormazioneRegionale1($username);
  } else if ($gara == "pisa"){
    return getFormazioneRegionale1($username);
  }
}

function getFormazioneRegionale1($username){
  require 'dbh.inc.php';
  $nomi = array();
  $cognomi = array();
  $sql = "SELECT * FROM garareg1 WHERE uidUsers=?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../index.php?error=sqlerrorselect");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);
  if ($row > 0){
    $nomiCognomi = explode(",", $row['nomi']);
    for ($i = 0; $i < 7; $i++){
      $tmp = explode(".", $nomiCognomi[$i]);
      array_push($nomi, $tmp[0]);
      array_push($cognomi, $tmp[1]);
    }
    return array($nomi, $cognomi);
  } else{
    return false;
  }
}
