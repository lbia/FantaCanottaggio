<?php
require "header.php";
require "includes/regionale.inc.php";

function printGara($gara, $nome, $cognome)
{
  startSession();
  $iscritti = $_SESSION['iscritti' . $gara];
  $risultati = $_SESSION['risultati' . $gara];
  echo '<h3>Risultati ' . getNomeLungo($gara) . '</h3>';
  printGaraTipoRegionale($gara, $iscritti, $risultati, $nome, $cognome);
}

function printGaraTipoRegionale($gara, $iscritti, $risultati, $nome, $cognome)
{
  list($punteggio, $nonIscritto) = getPunteggioGara($gara, $nome, $cognome);
  list($posizioni, $barca, $categoria, $sesso, $finale) = getRisultatiTipoRegionale($risultati, $nome, $cognome);
  $catAtleta = getDatiIscrittiTipoRegionale($iscritti, $nome, $cognome)[0];
  echo '<p>Punteggio: ' . $punteggio . '</p>';
  if ($nonIscritto) {
    echo "<p class='error'>Attenzione: L'atleta non risulta iscritto a tutte le gare in cui ha gareggiato</p>";
  }
  if (!empty($posizioni)) {
    echo '<table>';
    echo '<tr>';
    echo '<th align="center">Posizione</th>
            <th align="center">Barca</th>
            <th align="center">Gara</th>
            <th align="center">Categoria</th>
            <th align="center">Superiore</th>';
    echo '</tr>';
    for ($i = 0; $i < count($posizioni); $i++) {
      if ($finale[$i] !== false) {
        if (isCatSupReg($categoria[$i], $catAtleta[$i])) {
          $catSup = "si";
        } else {
          $catSup = "no";
        }
        $link = '<a href="gara.php?gara=' . $gara . '&barca=' . $barca[$i] . '&categoria=' . $categoria[$i] .
          '&sesso=' . $sesso[$i] . '&finale=' . $finale[$i] . '">';
        echo '<tr>';
        echo '<td align="center">';
        if ($categoria[$i] !== false) {
          echo $link . $posizioni[$i] . '</a>';
        } else {
          echo $posizioni[$i];
        }
        echo '</td><td align="left">';
        if ($categoria[$i] !== false) {
          echo $link . $barca[$i] . '</a>';
        } else {
          echo $barca[$i];
        }
        echo '</td><td align="left">' . $finale[$i] . '</td>';
        if ($categoria[$i] !== false) {
          echo '<td align="left">' . $categoria[$i];
        } else {
          echo '<td class="error" align="left">senza punti';
        }
        echo ' ' . $sesso[$i] . '</td>
                <td align="center">' . $catSup . '</td>';
        echo '</tr>';
      }
    }
    echo '</table>';
  } else {
    echo "<p>L'atleta non ha gareggiato</p>";
  }
}
?>

<main>
  <?php
  if (isset($_GET['nome']) && isset($_GET['cognome'])) {
    $nome = $_GET['nome'];
    $cognome = $_GET['cognome'];
    echo '<h2 style="display: inline; margin-right: 4px;">Atleta</h2>
          <h2 style="display: inline;"><a style="color: black; text-decoration: underline;" href="atleta.php?nome=' . $nome . '&cognome=' . $cognome . '">' . $nome . ' ' . $cognome . '</a></h2>';
    $allenatore = getPossessore($nome . ' ' . $cognome);
    if ($allenatore !== false) {
      echo '<br>';
      echo '<p style="display: inline-block; height: 10px; margin-right: 4px;">FantaAllenatore:</p>';
      echo '<p style="display: inline-block; height: 10px;"><a style="color: black; text-decoration: underline;" href=profilo.php?username=' . $allenatore . '>' . $allenatore . '</a></p>';
    } else {
      echo "<p>L'atleta è libero</p>";
    }
    if (!isset($_GET['gara'])) {
      echo '<table style="margin-top: 15px;">';
      echo '<tr><th align="left">Gara</th><th>Punteggio</th></tr>';
      for ($i = 0; $i < count($_SESSION['gareTotali']); $i++) {
        echo '<tr>';
        $gara = $_SESSION['gareTotali'][$i];
        $punteggio = getPunteggioGara($gara, $nome, $cognome)[0];
        if (isPresenteGara($gara, $nome, $cognome)) {
          echo '<td align="left"><a class="success"';
        } else {
          echo '<td align="left"><a class="error"';
        }
        echo ' href="atleta.php?nome=' . $nome . '&cognome=' . $cognome . '&gara=' . $gara . '">' . getNomeLungo($gara) . '</a></td>';
        echo '<td align="center">' . $punteggio . '</td>';
        echo '</tr>';
      }
      echo '</table>';
    } else {
      $gara = $_GET['gara'];
      printGara($gara, $nome, $cognome);
    }
  } else if (isset($_GET['mode']) && $_GET['mode'] == 'cerca') {
    echo '<h2>Cerca atleta</h2>';
    echo '<p>Scrivi almeno tre lettere del nome o del cognome</p>';
    if (isset($_GET['error'])) {
      if ($_GET['error'] == 'nouser') {
        echo "<p class='error'>L'atleta cercato non esiste</p>";
      }
    }
  ?>
    <form action="includes/searchInvio.inc.php" method="post">
      <input type="text" name="name" placeholder="Cerca atleta..." id="searchBox" oninput=search(this.value)>
    </form>
    <ul id="dataViewer"></ul>
    <script src="javascript/main.js"></script>
  <?php
  }
  ?>
  <br>
</main>

<?php
require "footer.php"
?>