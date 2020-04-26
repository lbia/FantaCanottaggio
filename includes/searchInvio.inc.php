<?php

require 'readWeb.inc.php';

session_start();
$cerca = $_POST['name'];
$data = searchNomeDatabaseEsatto($_SESSION['databaseAtleti'], $cerca);
if ($data !== false){
  $doppio = false;
  if (count($data) > 1){
    $doppio = true;
  }
  if (!$doppio){
    list($nome, $cognome) = getNomeCognome($data[0]);
    $nome = makeFirstUpper(removeNewLine($nome));
    $cognome = makeFirstUpper(removeNewLine($cognome));
    header('Location: ../atleta.php?nome='.$nome.'&cognome='.$cognome);
    exit();
  } else{
    header("Location: ../atleta.php?mode=cerca&error=doppi");
    exit();
  }
} else{
  header("Location: ../atleta.php?mode=cerca&error=nouser");
  exit();
}
