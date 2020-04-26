<?php

require 'readWeb.inc.php';

session_start();
$cerca = $_POST['name'];
$data = searchNomeDatabase($_SESSION['databaseAtleti'], $cerca);
if ($data !== false){
  echo json_encode($data);
} else{
  echo json_encode(0);
}
