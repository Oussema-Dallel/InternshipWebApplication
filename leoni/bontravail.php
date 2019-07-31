<?php
session_start();
if(!isset ($_SESSION['id']))
    header('Location: index.php');
include("connexion.php");
$succesajout=0;
if(isset($_POST['Equipement'])) {
    $equipement = $_POST['Equipement'];
    $description= $_POST['Description'];
    $remarque= $_POST['Remarque'];
    $sql = "SELECT * FROM `equipements` where `id_table` = ".$equipement ;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    $sql = "INSERT INTO `leoni`.`bondetravail` (`num_ot`, `date_ot`, `temps_ot`, `id_demandeur`, `id_table`, `description_panne`, `code_def1`, `description_traveaux`, `id_tech`, `code_def2`, `code_def3`, `remarque`) VALUES (NULL, '" . date("Y-m-d") ."', '" . date("H:i:s") . "', '".$_SESSION['id']."', '".$equipement ."', '".$description."', NULL, '', '', NULL, NULL, '".$remarque."');";
    $result = $conn->query($sql);
    $succesajout=1;
        }
    else { 
    $succesajout=2;
    }
}

?>
<?php include("header.php"); ?>
 <?php if($_SESSION['role']==0) { ?>
<div class="title">
   
	  <h2>Remplir la demande</h2>
		</div>
        <form id="form1" method="post" action="">
            <input name="Equipement" type="text" placeholder="Equipement" size="20" class="x" required/><br />
            <textarea name="Description" placeholder="Description de la panne"></textarea>
            <textarea name="Remarque" placeholder="Remarque"></textarea>
            <div class="clear"></div>
            <input name="Confirmer" type="submit" value="Envoyer" class="connexion" />
		</form>
        <div class="warning">
            <p><?php 
                if($succesajout==1) echo "Succés de demande";
                elseif($succesajout==2) echo "Table non trouvée";
        ?></p>
            </div>
<?php }else{ ?>
        <div class="title">
   
	 
            <?php
    $sql = "SELECT * from bondetravail B,equipements E,users U where U.id= B.id_demandeur AND B.etat = 'attente_technicien' AND B.id_table= E.id_table AND E.PS_equipement = '".$_SESSION['PS']."';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        ?>
             <h2>Suivi des bons de travail</h2>
		</div>
        <div class="crudtable" >
        <table border="0">
            <tr>
                <td>BT N&deg;</td>
                <td>Demandeur</td>
                <td>Nom &amp; Prénom</td>
                <td>Segment</td>
                <td>Equipement</td>
                <td>Date d'arrêt</td>
                <td>Heure d'arrêt</td>
                <td>Description</td>
                <td>Remarques</td>
                 <td>Actions</td>
            </tr>
    <?php } else {
        ?>
             <h2>Pas de bons de travail disponibles </h2>
   <?php }
        while($row = $result->fetch_assoc()) {
           ?>
            <tr id="printableArea">
                 <td><?php if(isset($row['num_ot'])) echo($row['num_ot']); else echo (" --- "); ?></td>
                <td><?php if(isset($row['id_demandeur'])) echo($row['id_demandeur']); else echo (" --- "); ?></td>
                <td><?php if(isset($row['name'])) echo($row['name']); else echo (" --- "); ?> <?php if(isset($row['lastname'])) echo($row['lastname']); else echo (" --- "); ?></td>
                <td><?php if(isset($row['segment'])) echo($row['segment']); else echo (" --- "); ?></td>
                <td>T<?php if(isset($row['id_table'])) echo($row['id_table']); else echo (" --- "); ?></td>
                <td><?php if(isset($row['date_ot'])) echo($row['date_ot']); else echo (" --- "); ?></td>
                <td><?php if(isset($row['temps_ot'])) echo($row['temps_ot']); else echo (" --- "); ?></td>
                <td><?php if(isset($row['description_panne'])) echo($row['description_panne']); else echo (" --- "); ?></td>
                <td><?php if(isset($row['remarque'])) echo($row['remarque']); else echo (" --- "); ?></td>
                 <td>
                    <a href="remplirbon.php?id=<?php if(isset($row['num_ot'])) echo($row['num_ot']); else echo (0); ?>"><img src="images/Check.png" alt="remplir" /></a>
                    <a href="#" onclick="PrintElem(<?php if(isset($row['num_ot'])) echo($row['num_ot']); else echo (0); ?>)"><img src="images/Print.png" alt="Print" /></a>
              </td>
            </tr>
            <?php } ?>
            </table>
        </div>
<?php } ?>
	</div>
    
	
	
</div>

<div id="copyright">
	<p> Leoni &copy; - <?php echo(date('Y')); ?></p>
</div>
    <script>
    startTime();
    </script>
</body>
</html>
