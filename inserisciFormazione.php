<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  require "includes/readDatabase.inc.php";
  require "includes/readWeb.inc.php";

  if (!isset($_GET['r0'])){
    list($nomi, $cognomi) = getRegionali($_SESSION['username']);
    $fineurl = "";
    for ($i = 0; $i < 9; $i++){
      $fineurl .= "&r".$i."=";
      if (isset($_SESSION['fn'])){
        $ce = false;
        for ($s = 0; $s < 7; $s++){
          if ($nomi[$i] == $_SESSION['fn'][$s] && $cognomi[$i] == $_SESSION['fc'][$s]){
            $ce = true;
          }
        }
        if ($ce === true){
          $fineurl .= "si";
        } else{
          $fineurl .= "no";
        }
      } else{
        $fineurl .= "no";
      }
    }
    if (!isset($_GET['formazione'])){
      header("Location: inserisciFormazione.php?".$fineurl);
      exit();
    } else{
      header("Location: inserisciFormazione.php?formazione=".$_GET['formazione'].$fineurl);
      exit();
    }
  }
  require "header.php";
 ?>

    <main>
      <h2>Inserisci Formazione</h2>
      <form action="includes/inserisciFormazione.inc.php" method="post">
      <?php
        $username = $_SESSION['username'];
        list($nomi, $cognomi) = getRegionali($username);
        if (isset($_GET['error'])){
          if ($_GET['error'] == 'seleziona'){
            echo "<p class='error'>Devi selezionare 7 atleti</p>";
          }
        } else if (isset($_GET['formazione']) && $_GET['formazione'] == 'success'){
          echo "<p class='success'>Formazione inserita con successo e classifica aggiornata</p>";
        } else{
          echo "<p>Seleziona 7 atleti</p>";
        }
        echo '<fieldset style="width: 65%;">
                <legend>Tuoi atleti regionali</legend>';
                for ($i = 0; $i < 9; $i++){
                  $link = "inserisciFormazione.php?";
                  for ($s = 0; $s < 9; $s++){
                    $link .= "&r".$s."=";
                    if ($s != $i){
                      $link .= $_GET['r'.$s];
                    } else{
                      if ($_GET['r'.$s] == "si"){
                        $link .= "no";
                      } else{
                        $link .= "si";
                      }
                    }
                  }
                  echo <<<EOD
                      <input onclick="location.href='
EOD;
                  echo $link;
                  echo <<<EOD
                      ';
EOD;
                  echo   '" type="radio" id="r'.$i.'" name="r'.$i.'" value="'.$nomi[$i].'.'.$cognomi[$i].'"';
                  if (isset($_GET['r'.$i])){
                    if ($_GET['r'.$i] == "si"){
                      echo ' checked>
                            <label class="success" for="r'.$i.'">'.$nomi[$i].' '.$cognomi[$i].'</label><br/>';
                    } else{
                      echo '>
                        <label class="error" for="r'.$i.'">'.$nomi[$i].' '.$cognomi[$i].'</label><br/>';
                    }
                  }
                }
        echo  '</fieldset>';
      ?>
        <br>
        <button type="submit" name="inserisciFormazione-submit">Seleziona</button>
      </form>
    </main>

<?php
  require "footer.php"
 ?>
