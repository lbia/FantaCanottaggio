<?php

require_once 'readWeb.inc.php';
require_once 'readDatabase.inc.php';

function pri($fp, $linea){
  fprintf($fp, "%s\n", $linea);
}

function writeDatabseAtleti($file, $nomeDest){
  $data = array();
  $fp = fopen(getPath($nomeDest), 'w');
  for ($i = 0; $i < count($file); $i++){
    if (strpos($file[$i], "<font style='font-size: 8pt;'><b><i>") !== false){
      $linea = $file[$i];
      $len = strlen($linea) - 4;
      $pos = 0;
      $errore = false;
      while (!($linea[$pos] == '<' && $linea[$pos + 1] == '/' && $linea[$pos + 2] == 'i' && $linea[$pos + 3] == '>')){
        if ($pos >= $len){
          $errore = true;
          break;
        }
        $pos++;
      }
      if ($errore){
        continue;
      }
      $linea = substr($linea, $pos);
      while (strpos($linea, "<font style='font-size: 8pt;'><br>") !== false){
        $len = strlen($linea) - 4;
        $pos = 0;
        $errore = false;
        while (!($linea[$pos] == '<' && $linea[$pos + 1] == 'b' && $linea[$pos + 2] == 'r' && $linea[$pos + 3] == '>')){
          if ($pos >= $len){
            $errore = true;
            break;
          }
          $pos++;
        }
        if ($errore){
          break;
        }
        $pos += 4;
        $nome = '';
        $errore = false;
        while ($linea[$pos] != '<'){
          if ($pos >= $len){
            $errore = true;
            break;
          }
          $nome .= $linea[$pos];
          $pos++;
        }
        if ($errore){
          break;
        }
        $posTrattino = strpos($nome, "-");
        if ($posTrattino === false || $nome[$posTrattino - 1] != " "){
          if (checkPresenteFile($data, $nome) === false){
            fprintf($fp, "%s\n", $nome);
            $data[] = $nome;
          }
        }
        $linea = substr($linea, $pos);
      }
    }
  }
  fclose($fp);
}

function appendDatabseAtleti($file, $nomeDest){
  $data = readPageFromFile(getPath($nomeDest));
  $fp = fopen(getPath($nomeDest), 'a');
  for ($i = 0; $i < count($file); $i++){
    if (strpos($file[$i], "<font style='font-size: 8pt;'><b><i>") !== false){
      $linea = $file[$i];
      $len = strlen($linea) - 4;
      $pos = 0;
      $errore = false;
      while (!($linea[$pos] == '<' && $linea[$pos + 1] == '/' && $linea[$pos + 2] == 'i' && $linea[$pos + 3] == '>')){
        if ($pos >= $len){
          $errore = true;
          break;
        }
        $pos++;
      }
      if ($errore){
        continue;
      }
      $linea = substr($linea, $pos);
      while (strpos($linea, "<font style='font-size: 8pt;'><br>") !== false){
        $len = strlen($linea) - 4;
        $pos = 0;
        $errore = false;
        while (!($linea[$pos] == '<' && $linea[$pos + 1] == 'b' && $linea[$pos + 2] == 'r' && $linea[$pos + 3] == '>')){
          if ($pos >= $len){
            $errore = true;
            break;
          }
          $pos++;
        }
        if ($errore){
          break;
        }
        $pos += 4;
        $nome = '';
        $errore = false;
        while ($linea[$pos] != '<'){
          if ($pos >= $len){
            $errore = true;
            break;
          }
          $nome .= $linea[$pos];
          $pos++;
        }
        if ($errore){
          break;
        }
        $posTrattino = strpos($nome, "-");
        if ($posTrattino === false || $nome[$posTrattino - 1] != " "){
          if (checkPresenteFile($data, $nome) === false){
            fprintf($fp, "%s\n", $nome);
            $data[] = $nome;
          }
        }
        $linea = substr($linea, $pos);
      }
    }
  }
  fclose($fp);
}

function checkPresenteFile($data, $nome){
  if (empty($data)){
    return false;
  }
  $len = count($data);
  for ($i = 0; $i < $len; $i++){
    if (strpos($data[$i], $nome) !== false){
      return true;
    }
  }
  return false;
}
