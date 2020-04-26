<?php

function printDonna(){
  echo '<p>&#x1F469;</p>';
}

function printUomo(){
  echo '<p>&#x1F468;</p>';
}

function scrivi($data){
  echo htmlspecialchars($data);
}

function unisciArray($a, $b){
  $c = array();
  for ($i = 0; $i < count($a); $i++){
    array_push($c, $a[$i]);
  }
  for ($i = 0; $i < count($b); $i++){
    array_push($c, $b[$i]);
  }
  return $c;
}

function getData(){
  date_default_timezone_set('Europe/Rome');
  $date = date('Y/m/d H:i:s');
  return $date;
}

function getAnno(){
  date_default_timezone_set('Europe/Rome');
  $date = date('Y/m/d H:i:s');
  $anno = substr($date, 0, 4);
  return $anno;
}

function getMese(){
  date_default_timezone_set('Europe/Rome');
  $date = date('Y/m/d H:i:s');
  $mese = substr($date, 5, 2);
  return $mese;
}

function getGiorno(){
  date_default_timezone_set('Europe/Rome');
  $date = date('Y/m/d H:i:s');
  $giorno = substr($date, 8, 2);
  return $giorno;
}

function getOra(){
  date_default_timezone_set('Europe/Rome');
  $date = date('Y/m/d H:i:s');
  $ora = substr($date, 11, 2);
  return $ora;
}

function getMinuti(){
  date_default_timezone_set('Europe/Rome');
  $date = date('Y/m/d H:i:s');
  $minuti = substr($date, 14, 2);
  return $minuti;
}

function getSecondi(){
  date_default_timezone_set('Europe/Rome');
  $date = date('Y/m/d H:i:s');
  $secondi = substr($date, 17, 2);
  return $secondi;
}

function isAlpha($str){
  $str = removeAccent($str);
  $lenght = strlen($str);
  for ($i = 0; $i < $lenght; $i++){
    if ($str[$i] != " "){
      if (!ctype_alpha($str[$i]) && $str[$i] != '-'){
        return false;
      }
    } else{
      if ($i == 0 || $i == $lenght - 1 || ($i >= 1 && $str[$i - 1] == " ") || ($i < $lenght - 1 && $str[$i + 1] == " ")){
        return false;
      }
    }
  }
  return true;
}

function isAlphaNum($str){
  $str = removeAccent($str);
  $lenght = strlen($str);
  for ($i = 0; $i < $lenght; $i++){
    if ($str[$i] != " "){
      if (!ctype_alnum($str[$i]) && $str[$i] != '-'){
        return false;
      }
    } else{
      if ($i == 0 || $i == $lenght - 1 || ($i >= 1 && $str[$i - 1] == " ") || ($i < strlen($str) - 1 && $str[$i + 1] == " ")){
        return false;
      }
    }
  }
  return true;
}

function removeNewLine($str){
  return trim(preg_replace('/\s\s+/', ' ', $str));
}

function substituteSpace($str){
  for ($i = 0; $i < strlen($str); $i++){
    if ($str[$i] == " "){
      $str[$i] = "_";
    }
  }
  return $str;
}

function reverseSpace($str){
  for ($i = 0; $i < strlen($str); $i++){
    if ($str[$i] == "_"){
      $str[$i] = " ";
    }
  }
  return $str;
}

function removeString($str, $index){
  if (strlen($str) == 0){
    return false;
  }
  return substr($str, 0, $index).substr($str, $index + 1);
}

function removeSpace($str){
  if (strlen($str) == 0){
    return false;
  }
  while ($str[0] == " "){
    $str = removeString($str, 0);
  }
  while ($str[strlen($str) - 1] == " ") {
    $str = removeString($str, strlen($str) - 1);
  }
  return $str;
}

function makeFirstUpper($data){
  if (empty($data)){
    return false;
  }
  $lenght = strlen($data);
  $nome = strtoupper($data[0]);
  for ($i = 1; $i < $lenght; $i++){
    if ($data[$i - 1] == " "){
      $nome .= strtoupper($data[$i]);
    } else{
      $nome .= $data[$i];
    }
  }
  return $nome;
}


function removeAccent($str) {
    $str = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $str);
    $str = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $str);
    $str = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $str);
    $str = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $str);
    $str = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $str);
    $str = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $str);
    return $str;
}

function getPath($nomeFile){
  $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $path = "";
  if (strpos($url, "includes") !== false ||
      strpos($url, "classes") !== false){
    $path .= "../";
  }
  $path .= "data/text/".$nomeFile;
  return $path;
}

function readPage($url){
  $page = fopen($url, "r");
  $file = array();
  while ($line = mb_convert_encoding(fgets($page), "UTF-8", "iso-8859-1")){
    array_push($file, strtolower($line));
  }
  fclose($page);
  return $file;
}

function readPageFromFile($nomeFile){
  $page = fopen($nomeFile, "r");
  $file = array();
  while ($line = fgets($page)){
    array_push($file, strtolower($line));
  }
  fclose($page);
  return $file;
}

function readPageFromFileNoLower($nomeFile){
  $page = fopen($nomeFile, "r");
  $file = array();
  while ($line = fgets($page)){
    array_push($file, $line);
  }
  fclose($page);
  return $file;
}

function savePageToFile($url, $nomeFile){
  $page = fopen($url, "r");
  $file = fopen($nomeFile, "w");
  while ($line = mb_convert_encoding(fgets($page), "UTF-8", "iso-8859-1")){
    fprintf($file, "%s", $line);
  }
  fclose($page);
  fclose($file);
}

function ordinaClassifica($utenti, $punteggi){
  $utentiOrdinati = array();
  $punteggiOrdinati = array();
  for ($i = 0; $i < count($utenti); $i++){
    $maxPunt = -1;
    $indice = -1;
    for ($u = 0; $u < count($utenti); $u++){
      if ($punteggi[$u] !== false && $punteggi[$u] > $maxPunt){
        $maxPunt = $punteggi[$u];
        $indice = $u;
      }
    }
    array_push($utentiOrdinati, $utenti[$indice]);
    array_push($punteggiOrdinati, $punteggi[$indice]);
    $punteggi[$indice] = false;
  }
  return array($utentiOrdinati, $punteggiOrdinati);
}

function ordinaClassificaGenerale($classifica, $utenti){
  $utentiOrdinati = array();
  $punteggiOrdinati = array();
  for ($i = 0; $i < count($utenti); $i++){
    $maxPunt = -1;
    $indice = -1;
    for ($u = 0; $u < count($utenti); $u++){
      $punteggio = $classifica[$utenti[$u]];
      if ($punteggio !== false && $punteggio > $maxPunt){
        $maxPunt = $punteggio;
        $indice = $u;
      }
    }
    array_push($utentiOrdinati, $utenti[$indice]);
    array_push($punteggiOrdinati, $maxPunt);
    $classifica[$utenti[$indice]] = false;
  }
  return array($utentiOrdinati, $punteggiOrdinati);
}

function getBarca($data){
  $barche = array("singolo", "due senza", "doppio", "quattro senza", "quattro di coppia", "otto");
  for ($i = 0; $i < count($barche); $i++){
    if (strpos($data, $barche[$i]) !== false){
      return $barche[$i];
    }
  }
  return false;
}

function getCategoria($data){
  $categorie = array("ragazzi", "junior", "under 23", "senior", "pesi leggeri");
  for ($i = 0; $i < count($categorie); $i++){
    if (strpos($data, $categorie[$i]) !== false){
      return $categorie[$i];
    }
  }
  return false;
}

function getSesso($data){
  if (strpos($data, " m ") !== false){
    return "m";
  } else{
    return "f";
  }
}

function getGara($data){
  $gare = array("semifinale", "finale a", "finale b",
                "finale 1", "finale 2", "finale 3", "finale 4", "finale 5", "finale 6", "finale");
  for ($i = 0; $i < count($gare); $i++){
    if (strpos($data, $gare[$i]) !== false){
      return $gare[$i];
    }
  }
  return false;
}

function getNomeCognome($data){
  $nomi = explode(" ", $data);
  $cognome = $nomi[0];
  for ($i = 1; $i < count($nomi) - 1; $i++){
    $cognome .= ' '.$nomi[$i];
  }
  $nome = $nomi[count($nomi) - 1];
  return array($nome, $cognome);
}

function searchNomeDatabaseEsatto($file, $cerca){
  $cerca = strtolower($cerca);
  if (strlen($cerca) < 3){
    return false;
  }
  $nomi = explode(" ", $cerca);
  $quanti = count($nomi);
  $len = count($file);
  $atleti = array();
  for ($i = 0; $i < $len; $i++){
    $atleta = explode(" ", $file[$i]);
    $trovato = true;
    $numero = 0;
    for ($s = 0; $s < $quanti; $s++){
      $ce = false;
      for ($c = 0; $c < count($atleta); $c++){
        if ($atleta[$c] !== false && removeNewLine($atleta[$c]) == $nomi[$s]){
          $ce = true;
          $atleta[$c] = false;
          $numero++;
          break;
        }
      }
      if ($ce == false){
        $trovato = false;
        break;
      }
    }
    if ($trovato && $numero >= 2){
      $atleti[] = $file[$i];
    }
  }
  if (!empty($atleti)){
    return $atleti;
  } else{
    return false;
  }
}

function searchNomeDatabase($file, $cerca){
  $cerca = strtolower($cerca);
  if (strlen($cerca) < 3){
    return false;
  }
  $nomi = explode(" ", $cerca);
  $quanti = count($nomi);
  $len = count($file);
  $atleti = array();
  for ($i = 0; $i < $len; $i++){
    $atleta = explode(" ", $file[$i]);
    $trovato = true;
    for ($s = 0; $s < $quanti; $s++){
      $ce = false;
      for ($c = 0; $c < count($atleta); $c++){
        if ($atleta[$c] !== false && strpos($atleta[$c], $nomi[$s]) !== false){
          $ce = true;
          $atleta[$c] = false;
          break;
        }
      }
      if ($ce == false){
        $trovato = false;
        break;
      }
    }
    if ($trovato){
      $atleti[] = $file[$i];
    }
  }
  if (!empty($atleti)){
    return $atleti;
  } else{
    return false;
  }
}

function searchNomeTipoRegionale($file, $cerca){
  if (strlen($cerca) < 3){
    return false;
  }
  $cerca = strtolower($cerca);
  $persone = array();
  for ($i = 0; $i < count($file); $i++){
    $pos = strpos($file[$i], $cerca);
    if ($pos !== false && strpos($file[$i], "<font style='font-size: 8pt;'><b><i>") !== false){
      $inizio = $pos;
      $errore = false;
      $linea = $file[$i];
      while ($linea[$inizio - 1] != '>'){
        $inizio--;
        if ($inizio == 0){
          $errore = true;
        }
      }
      $fine = $pos;
      $lunghezza = strlen($linea) - 3;
      while ($linea[$fine + 1] != '<'){
        $fine++;
        if ($fine == $lunghezza){
          $errore = true;
        }
      }
      if ($errore || $linea[$inizio - 2] != 'r' || $linea[$fine + 2] != 'f'){
        continue;
      }
      $per = substr($file[$i], $inizio, $fine - $inizio + 1);
      $posTrattino = strpos($per, "-");
      if ($posTrattino === false || $per[$posTrattino - 1] != " "){
        array_push($persone, $per);
      }
    }
  }
  if (!empty($persone)){
    return $persone;
  } else{
    return false;
  }
}

//non usato
function searchRisultatiTipoRegionale($file, $cerca){
  if (strlen($cerca) < 3){
    return false;
  }
  $posizioni = array();
  $barca = array();
  $categoria = array();
  $sesso = array();
  $gara = array();
  $cerca = strtolower($cerca);
  for ($i = 0; $i < count($file); $i++){
    $pos = strpos($file[$i], $cerca);
    if ($pos !== false){
      $inizio = $pos;
      while ($file[$i][$inizio - 1] != '>'){
        $inizio--;
      }
      $fine = $pos;
      while ($file[$i][$fine + 1] != '<'){
        $fine++;
      }
      $per = substr($file[$i], $inizio, $fine - $inizio + 1);
      $posTrattino = strpos($per, "-");
      if ($posTrattino === false || $per[$posTrattino - 1] != " "){
        $finePosizione = 7;
        while (ctype_digit($file[$i - 3][$finePosizione])){
          $finePosizione++;
        }
        $posizione = substr($file[$i - 3], 6, $finePosizione - 6);
        array_push($posizioni, $posizione);
        $scorri = $i - 5;
        while (strpos($file[$scorri], "<table") === false){
          $scorri -= 5;
        }
        $scorri -= 5;
        $fine = 3;
        while ($file[$scorri][$fine + 1] != '<'){
          $fine++;
        }
        $data = substr($file[$scorri], 3, $fine - 2);
        array_push($barca, getBarca($data));
        array_push($categoria, getCategoria($data));
        array_push($sesso, getSesso($data));
        array_push($gara, getGara($data));
      }
    }
  }
  return array($posizioni, $barca, $categoria, $sesso, $gara);
}

function getRisultatiTipoRegionale($file, $nome, $cognome){
  $posizioni = array();
  $barca = array();
  $categoria = array();
  $sesso = array();
  $gara = array();
  $nomedown = strtolower($nome);
  $cognomedown = strtolower($cognome);
  for ($i = 0; $i < count($file); $i++){
    $pos = strpos($file[$i], $cognomedown);
    if ($pos !== false){
      $inizio = $pos;
      while ($file[$i][$inizio - 1] != '>'){
        $inizio--;
      }
      $fine = $pos;
      while ($file[$i][$fine + 1] != '<'){
        $fine++;
      }
      $per = substr($file[$i], $inizio, $fine - $inizio + 1);
      if (strpos($per, $nomedown) !== false && ($cognomedown != "bosio" || $nomedown != 'giulia' || $file[$i][$fine] == 'a')){
        $posTrattino = strpos($per, "-");
        if ($posTrattino === false || $per[$posTrattino - 1] != " "){
          $finePosizione = 7;
          while (ctype_digit($file[$i - 3][$finePosizione])){
            $finePosizione++;
          }
          $posizione = substr($file[$i - 3], 6, $finePosizione - 6);
          array_push($posizioni, $posizione);
          $scorri = $i - 5;
          while (strpos($file[$scorri], "<table") === false){
            $scorri -= 5;
          }
          $scorri -= 5;
          $fine = 3;
          while ($file[$scorri][$fine + 1] != '<'){
            $fine++;
          }
          $data = substr($file[$scorri], 3, $fine - 2);
          array_push($barca, getBarca($data));
          array_push($categoria, getCategoria($data));
          array_push($sesso, getSesso($data));
          array_push($gara, getGara($data));
        }
      }
    }
  }
  return array($posizioni, $barca, $categoria, $sesso, $gara);
}

function searchDatiIscrittiTipoRegionale($file, $cerca){
  if (strlen($cerca) < 3){
    return false;
  }
  $categoriaAtleta = array();
  $barca = array();
  $categoria = array();
  $sesso = array();
  $gara = array();
  $cerca = strtolower($cerca);
  for ($i = 0; $i < count($file); $i++){
    $pos = strpos($file[$i], $cerca);
    if ($pos !== false){
      $inizio = $pos;
      while ($file[$i][$inizio - 1] != '>'){
        $inizio--;
      }
      $fine = $pos;
      while ($file[$i][$fine + 1] != '<'){
        $fine++;
      }
      $per = substr($file[$i], $inizio, $fine - $inizio + 1);
      $posTrattino = strpos($per, "-");
      if ($posTrattino === false || $per[$posTrattino - 1] != " "){
        if ($file[$i][$fine + 31] == "(" && $file[$i][$fine + 34] == ")"){
          $catAtleta = substr($file[$i], $fine + 32, 2);
          array_push($categoriaAtleta, $catAtleta);
        } else{
          array_push($categoriaAtleta, false);
        }
        $scorri = $i - 3;
        while (strpos($file[$scorri], "<table") === false){
          $scorri -= 3;
        }
        $scorri -= 8;
        $data = $file[$scorri];
        array_push($barca, getBarca($data));
        array_push($categoria, getCategoria($data));
        array_push($sesso, getSesso($data));
        array_push($gara, getGara($data));
      }
    }
  }
  return array($categoriaAtleta, $barca, $categoria, $sesso, $gara);
}

function getDatiIscrittiTipoRegionale($file, $nome, $cognome){
  $categoriaAtleta = array();
  $barca = array();
  $categoria = array();
  $sesso = array();
  $gara = array();
  $nomedown = strtolower($nome);
  $cognomedown = strtolower($cognome);
  for ($i = 0; $i < count($file); $i++){
    $pos = strpos($file[$i], $cognomedown);
    if ($pos !== false){
      $inizio = $pos;
      while ($file[$i][$inizio - 1] != '>'){
        $inizio--;
      }
      $fine = $pos;
      while ($file[$i][$fine + 1] != '<'){
        $fine++;
      }
      $per = substr($file[$i], $inizio, $fine - $inizio + 1);
      if (strpos($per, $nomedown) !== false && ($cognomedown != "bosio" || $nomedown != 'giulia' || $file[$i][$fine] == 'a')){
        $posTrattino = strpos($per, "-");
        if ($posTrattino === false || $per[$posTrattino - 1] != " "){
          if ($file[$i][$fine + 31] == "(" && $file[$i][$fine + 34] == ")"){
            $catAtleta = substr($file[$i], $fine + 32, 2);
            array_push($categoriaAtleta, $catAtleta);
          } else{
            array_push($categoriaAtleta, false);
          }
          $scorri = $i - 3;
          while (strpos($file[$scorri], "<table") === false){
            $scorri -= 3;
          }
          $scorri -= 8;
          $data = $file[$scorri];
          array_push($barca, getBarca($data));
          array_push($categoria, getCategoria($data));
          array_push($sesso, getSesso($data));
          array_push($gara, getGara($data));
        }
      }
    }
  }
  return array($categoriaAtleta, $barca, $categoria, $sesso, $gara);
}

function isCatSupReg($catGara, $catAtleta){
  if ($catGara == "junior" && $catAtleta == "gr"){
    return true;
  }
  if ($catGara == "under 23" || $catGara == "pesi leggeri" || $catGara == "senior"){
    if ($catAtleta == "jn"){
      return true;
    }
  }
  return false;
}

function getPunteggioTipoRegionaleDaPosizione($posizione, $catSup){
  $puntNor = array(0, 32, 26, 22, 18, 16, 14, 12, 10);
  $puntSup = array(0, 48, 39, 33, 27, 24, 21, 18, 15);
  if ($posizione > 8){
    return 5;
  }
  if ($catSup){
    $punteggio = $puntSup[$posizione];
  } else{
    $punteggio = $puntNor[$posizione];
  }
  return $punteggio;
}

function isPresenteTipoRegionale($iscritti, $nome, $cognome){
  list($categoriaAtleta, $ibarca, $icategoria, $isesso, $igara) = getDatiIscrittiTipoRegionale($iscritti, $nome, $cognome);
  if (!empty($categoriaAtleta)){
    return true;
  }
  return false;
}

function getPunteggioTipoRegionale($iscritti, $risultati, $nome, $cognome){
  $punteggio = 0;
  $nonIscritto = false;
  list($categoriaAtleta, $ibarca, $icategoria, $isesso, $igara) = getDatiIscrittiTipoRegionale($iscritti, $nome, $cognome);
  list($posizioni, $rbarca, $rcategoria, $rsesso, $rgara) = getRisultatiTipoRegionale($risultati, $nome, $cognome);
  if (!empty($posizioni)){
    if (count($ibarca) != count($rbarca)){
      $nonIscritto = true;
    }
    for ($i = 0; $i < count($posizioni); $i++){
      if (isset($rbarca[$i]) && isset($ibarca[$i])){
        if ($rgara[$i] !== false && $rcategoria[$i] !== false){
          $catSup = isCatSupReg($rcategoria[$i], $categoriaAtleta[$i]);
          $punteggio += getPunteggioTipoRegionaleDaPosizione($posizioni[$i], $catSup);
        }
      } else{
        $punteggio += getPunteggioTipoRegionaleDaPosizione($posizioni[$i], false);
      }
    }
  }
  return array($punteggio, $nonIscritto);
}

function calculatePunteggioTipoRegionale($iscritti, $risultati, $nomi, $cognomi){
  $punteggio = 0;
  for ($p = 0; $p < count($nomi); $p++){
    $punteggio += getPunteggioTipoRegionale($iscritti, $risultati, $nomi[$p], $cognomi[$p])[0];
  }
  return $punteggio;
}

function getRisultatiGaraTipoRegionale($risultati, $barca, $categoria, $sesso, $gara){
  $ris = array();
  for ($i = 0; $i < count($risultati); $i++){
    $linea = $risultati[$i];
    if (strpos($linea, $barca) !== false && strpos($linea, $categoria) !== false &&
        strpos($linea, ' '.$sesso.' ') !== false && strpos($linea, $gara) !== false){
      $indice = $i + 10;
      while (ctype_digit($risultati[$indice - 3][6])){
        $linea = $risultati[$indice];
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
        $equipaggio = array();
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
            $equipaggio[] = $nome;
          }
          $linea = substr($linea, $pos);
        }
        if (!empty($equipaggio)){
          $ris[] = $equipaggio;
        }
        $indice += 5;
      }
    }
  }
  if (!empty($ris)){
    return $ris;
  } else{
    return false;
  }
}
