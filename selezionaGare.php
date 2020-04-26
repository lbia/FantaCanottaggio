<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_GET['r0'])){
  $fineurl = "";
  for ($i = 0; $i < count($_SESSION['gareTotali']); $i++){
    $fineurl .= "&r".$i."=";
    $ce = false;
    for ($s = 0; $s < count($_SESSION['gareSelezionate']); $s++){
      if ($_SESSION['gareSelezionate'][$s] == $_SESSION['gareTotali'][$i]){
        $ce = true;
        break;
      }
    }
    if ($ce){
      $fineurl .= "si";
    } else{
      $fineurl .= "no";
    }
  }
  header("Location: selezionaGare.php?".$fineurl);
  exit();
}
require "header.php";
require "includes/regionale.inc.php";
 ?>

    <main>
      <h2>Gare svolte</h2>
      <form action="includes/selezionaGare.inc.php" method="post">
      <?php
        echo "<p>Seleziona le gare che vuoi contare nella classifica</p>";
        echo '<fieldset style="width: 65%;">
                <legend>Gare svolte</legend>';
                for ($i = 0; $i < count($_SESSION['gareTotali']); $i++){
                  $link = "selezionaGare.php?";
                  for ($s = 0; $s < count($_SESSION['gareTotali']); $s++){
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
                  $gara = $_SESSION['gareTotali'][$i];
                  $nomeGara = getNomeLungo($gara);
                  echo   '" type="radio" id="r'.$i.'" name="r'.$i.'" value="'.$gara.'"';
                  if (isset($_GET['r'.$i])){
                    if ($_GET['r'.$i] == "si"){
                      echo ' checked>
                            <label class="success" for="r'.$i.'">'.$nomeGara.'</label><br/>';
                    } else{
                      echo '>
                        <label class="error" for="r'.$i.'">'.$nomeGara.'</label><br/>';
                    }
                  }
                }
        echo  '</fieldset>';
      ?>
        <br>
        <button type="submit" name="selezionaGare-submit">Seleziona</button>
      </form>
    </main>

<?php
  require "footer.php"
 ?>
