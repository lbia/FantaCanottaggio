<?php
  require "header.php";
 ?>

    <main>
      <h3>Inserisci Nazionali</h3>
      <form action="includes/inserisciNazionali.inc.php" method="post">
        <?php
          if (isset($_GET['error'])){
            if ($_GET['error'] == "emptyfields"){
              echo '<p class="error">Riempi tutti i campi</p>';
            } else if ($_GET['error'] == "invalidfields"){
              echo "<p class='error'>Gli atleti non devono contenere caratteri strani, numeri o doppi spazi</p>";
            } else{
              echo '<p class="error">Errore</p>';
            }
          } else if (isset($_GET['formazione']) && $_GET['formazione'] == 'success'){
            echo "<p class='success'>Atleti nazionali inseriti con successo</p>";
          }
          echo '<ul>';
          for ($i = 0; $i < 11; $i++){
            echo '<li><input type="text" name="n'.$i.'n" placeholder="Nome"';
            if (isset($_GET["n".$i."n"])){
              echo 'value="'.$_GET["n".$i."n"].'"';
            } else if (isset($_SESSION["nn"][$i])){
              echo 'value="'.$_SESSION["nn"][$i].'"';
            }
            echo '><input type="text" name="n'.$i.'c" placeholder="Cognome"';
            if (isset($_GET["n".$i."c"])){
              echo 'value="'.$_GET["n".$i."c"].'"';
            } else if (isset($_SESSION["nc"][$i])){
              echo 'value="'.$_SESSION["nc"][$i].'"';
            }
            echo "></li>";
          }
          echo '</ul>';
         ?>
         <button type="submit" name="inserisciNazionali-submit">Inserisci</button>
      </form>
    </main>

<?php
  require "footer.php"
 ?>
