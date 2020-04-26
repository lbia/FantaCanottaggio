<?php
  require "header.php";
 ?>

    <main>
      <h3>Inserisci Regionali</h3>
      <form action="includes/inserisciRegionali.inc.php" method="post">
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
            echo "<p class='success'>Atleti regionali inseriti con successo</p>";
          }
          echo '<ul>';
          for ($i = 0; $i < 9; $i++){
            echo '<li><input type="text" name="r'.$i.'n" placeholder="Nome"';
            if (isset($_GET["r".$i."n"])){
              echo 'value="'.$_GET["r".$i."n"].'"';
            } else if (isset($_SESSION["rn"][$i])){
              echo 'value="'.$_SESSION["rn"][$i].'"';
            }
            echo '><input type="text" name="r'.$i.'c" placeholder="Cognome"';
            if (isset($_GET["r".$i."c"])){
              echo 'value="'.$_GET["r".$i."c"].'"';
            } else if (isset($_SESSION["rc"][$i])){
              echo 'value="'.$_SESSION["rc"][$i].'"';
            }
            echo "></li>";
          }
          echo '</ul>';
         ?>
         <button type="submit" name="inserisciRegionali-submit">Inserisci</button>
        </ul>
      </form>
    </main>

<?php
  require "footer.php"
 ?>
