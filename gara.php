<?php
  require 'header.php';
  require 'includes/regionale.inc.php';
 ?>

<main>
  <?php
    if (isset($_GET['gara']) && isset($_GET['barca']) && isset($_GET['categoria']) && isset($_GET['sesso']) && isset($_GET['finale'])){
      $gara = $_GET['gara'];
      $barca = $_GET['barca'];
      $categoria = $_GET['categoria'];
      $sesso = $_GET['sesso'];
      $finale = $_GET['finale'];
      $risultati = getRisultatiGaraTipoRegionale($_SESSION['risultati'.$gara], $barca, $categoria, $sesso, $finale);
      $persone = count($risultati[0]);
      echo "<h2>Risultati gara ".getNomeLungo($gara)."</h2>";
      echo '<p>'.makeFirstUpper($barca).' '.$categoria.' '.$sesso.' '.$finale.'</p>';
      echo '<table>';
      echo '<tr><th>Posizione</th>';
      for ($i = 0; $i < $persone; $i++){
        echo '<th>Atleta</th>';
      }
      echo '</tr>';
      for ($i = 0; $i < count($risultati); $i++){
        $equipaggio = $risultati[$i];
        echo '<tr><td align="center">'.($i + 1).'</td>';
        for ($scorri = 0; $scorri < count($equipaggio); $scorri++){
          $persona = makeFirstUpper($equipaggio[$scorri]);
          list($nome, $cognome) = getNomeCognome($persona);
          echo '<td><a href="atleta.php?nome='.$nome.'&cognome='.$cognome.'">'.$persona.'</td>';
        }
        echo '</td>';
      }
      echo '</table>';
    }
   ?>
</main>

<?php
  require 'footer.php';
 ?>
