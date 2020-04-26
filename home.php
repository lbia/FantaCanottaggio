<?php
require "header.php";
require 'includes/readWeb.inc.php';
?>

<main>
  <div>
    <p style="font-weight: bold; display: inline;">Prossima gara:</p>
    <p style="display: inline; padding: 0.5em;">Regionale a Candia</p>
    <p><a href="lega.php">leghe</a></p>
  </div>
  <!--<p class="error" style="display: inline-block; margin-right: 5px; height: 5px;">Auguri</p>
     <p style="display: inline;">&#x1F469;</p>-->
  <?php
  $anno = getAnno();
  $mese = getMese();
  $giorno = getGiorno();
  $ora = getOra();
  $minuti = getMinuti();
  $secondi = getSecondi();
  echo '<p>Data: ' . $giorno . '/' . $mese . '/' . $anno . ' Ora: ' . $ora . ':' . $minuti . '</p>';
  if (isset($_SESSION['username'])) {
    if ($anno == 2020 && $mese == 3 && $giorno == 4) {
      echo '<div>
                  <p class="error" style="font-weight: bold; display: inline;">ATTENZIONE:</p>
                  <p style="display: inline; margin-left: 4px;">Hai tempo fino alle 0:00 per inserire/aggiornare la formazione</p>
                </div>';
    } else {
      echo '<p>Non puoi più aggiornare la formazione</p>';
    }
  }
  ?>
  <p><a href="atleta.php?mode=cerca">Cerca risultati atleti</a></p>
  <p><a href="classifica.php?mode=atleti2019">Classifica atleti 2019</a></p>
  <h2>Albo d'oro</h2>
  <h3>2019</h3>
  <ul class="albo">
    <li>
      <p>1</p>
      <p><?php printUomo(); ?><p>Ferrero Massimiliano 3809 punti</p>
    </li>
    <li>
      <p>2</p>
      <p><?php printDonna(); ?>Crosio Silvia 3794 punti
    </li>
    <li>
      <p>3</p>
      <p><?php printUomo(); ?>Bianco Lorenzo 3598 punti
    </li>
  </ul>
  <h3>2018</h3>
  <ul class="albo">
    <li>
      <p>1</p>
      <p><?php printDonna(); ?>Crosio Silvia 3914 punti
    </li>
    <li>
      <p>2</p>
      <p><?php printDonna(); ?>Crosio Elena 3794 punti
    </li>
    <li>
      <p>3</p>
      <p><?php printUomo(); ?>Zoppi Filippo 3665 punti
    </li>
  </ul>
  <p class="error">Se trovi errori o problemi scrivi a lollo</p>
  <br>
</main>

<?php
require "footer.php"
?>