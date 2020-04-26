<?php

if (isset($_POST['selezionaGare-submit'])){
  session_start();
  $_SESSION['gareSelezionate'] = array();
  for ($i = 0; $i < count($_SESSION['gareTotali']); $i++){
    if (isset($_POST['r'.$i])){
      array_push($_SESSION['gareSelezionate'], $_POST['r'.$i]);
    }
  }
  header("Location: ../classifica.php");
  exit();
} else{
  header("Location: ../index.php");
  exit();
}
