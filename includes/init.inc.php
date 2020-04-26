<?php
  require 'includes/dbh.inc.php';
  require 'includes/readDatabase.inc.php';
  require 'includes/readWeb.inc.php';

  if (isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    if (!isset($_SESSION['fn'])){
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
      if (isset($row['nomi'])){
        $_SESSION['fn'] = array();
        $_SESSION['fc'] = array();
        $nomiCognomi = explode(",", $row['nomi']);
        for ($i = 0; $i < 7; $i++){
          $tmp = explode(".", $nomiCognomi[$i]);
          array_push($_SESSION['fn'], $tmp[0]);
          array_push($_SESSION['fc'], $tmp[1]);
        }
      }
    }
    if (!isset($_SESSION['rn'])){
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
      if (isset($row['nomi'])){
        $_SESSION['rn'] = array();
        $_SESSION['rc'] = array();
        $nomiCognomi = explode(",", $row['nomi']);
        for ($i = 0; $i < 9; $i++){
          $tmp = explode(".", $nomiCognomi[$i]);
          array_push($_SESSION['rn'], $tmp[0]);
          array_push($_SESSION['rc'], $tmp[1]);
        }
      }
    }
    if (!isset($_SESSION['nn'])){
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
      if (isset($row['nomi'])){
        $_SESSION['nn'] = array();
        $_SESSION['nc'] = array();
        $nomiCognomi = explode(",", $row['nomi']);
        for ($i = 0; $i < 11; $i++){
          $tmp = explode(".", $nomiCognomi[$i]);
          array_push($_SESSION['nn'], $tmp[0]);
          array_push($_SESSION['nc'], $tmp[1]);
        }
      }
    }
  }

  if (!isset($_SESSION['utenti'])){
    $_SESSION['utenti'] = getUtenti();
  }

  $file = "data/text/classificaAtleti.txt";
  if (file_exists($file)){
    $fp = fopen($file, "r");
    $_SESSION['punteggi'] = array();
    $_SESSION['nomi'] = array();
    while ($data = fscanf($fp, "%d %[^\n]\n")){
      list($punteggio, $nome) = $data;
      array_push($_SESSION['punteggi'], $punteggio);
      array_push($_SESSION['nomi'], $nome);
    }
    fclose($fp);
  }

  $_SESSION['databaseAtleti'] = readPageFromFile(getPath("database/totale.txt"));

  $_SESSION['gareTotali'] = array("regionale1", "regionale2", "inverno", "pisa");
  $_SESSION['gareSelezionate'] = array();
  for ($i = 0; $i < count($_SESSION['gareTotali']); $i++){
    $gara = $_SESSION['gareTotali'][$i];
    array_push($_SESSION['gareSelezionate'], $gara);
    $file = "data/text/classifica".$gara.".txt";
    if (file_exists($file)){
      $_SESSION['utenti'.$gara] = array();
      $_SESSION['punteggi'.$gara] = array();
      $fp = fopen($file, "r");
      while ($classifica = fscanf($fp, "%d %s")){
        list($punteggio, $utente) = $classifica;
        array_push($_SESSION['punteggi'.$gara], $punteggio);
        array_push($_SESSION['utenti'.$gara], $utente);
      }
      fclose($fp);
    }
    $file = "data/text/".$gara."Iscritti.txt";
    if (file_exists($file)){
      $_SESSION['iscritti'.$gara] = readPageFromFile($file);
    }
    $file = "data/text/".$gara."Risultati.txt";
    if (file_exists($file)){
      $_SESSION['risultati'.$gara] = readPageFromFile($file);
    }
  }

  $admantx = 'admantx-euaspb/3.1 (+https://www.admantx.com/service-fetcher.html)';
  $lolloCell = 'Mozilla/5.0 (Linux; Android 9; Mi MIX 2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Mobile Safari/537.36';
  $lolloPc = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36';
  if (isset($_SERVER['REMOTE_ADDR']) && isset($_SERVER['HTTP_USER_AGENT'])){
      $ip = $_SERVER['REMOTE_ADDR'];
      $agent = $_SERVER['HTTP_USER_AGENT'];
      if ($agent != $admantx && $agent != $lolloCell && $agent != $lolloPc){
        $file = fopen("data/text/entra.txt", "a");
        fprintf($file, "%s", getData());
        fprintf($file, " ip: %s", $ip);
        fprintf($file, " agent: %s", $agent);
        fprintf($file, "\n");
        fclose($file);
      }
  }
