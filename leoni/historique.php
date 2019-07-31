<?php
session_start();
if(!isset ($_SESSION['id']))
    header('Location: index.php');
include("connexion.php");
if(isset($_GET['validate'])) {
    
    
    $sql = "UPDATE `leoni`.`bondetravail` SET 
        `etat` = 'fini'
        WHERE `bondetravail`.`num_ot` = ".htmlspecialchars($_GET['validate']).";";
    $result = $conn->query($sql);
}
include("header.php"); ?>

<div class="title">
   
	  <h2>Historique des bons de travail</h2>
		</div>
        <div class="crudtable" >
        <table border="0">
            <tr>
                <td>ID</td>
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
            <?php
    $sql = "SELECT * from bondetravail B,equipements E,users U  where U.id= B.id_demandeur AND B.etat != 'attente_technicien' AND B.id_table= E.id_table ORDER BY UNIX_TIMESTAMP(date_ot) DESC ;";
    $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
           ?>
            <tr id="printableArea" <?php if($row['etat'] =='fini') { ?> style="background-color:#d2ffc4;"<?php } ?>>
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
                     <?php if($_SESSION['role']== 2 && $row['etat'] =='attente_chef') { ?>
                     <a href="historique.php?validate=<?php echo($row['num_ot']) ?>"><img src="images/approve.png" alt="remplir" /></a>

                     <?php } ?>
                    <a href="#" onclick="ZoomElem(<?php if(isset($row['num_ot'])) echo($row['num_ot']); else echo (0); ?>)"><img src="images/zoom.png" alt="Print" /></a>
              </td>
            </tr>
            <?php } ?>
            </table>
        </div>
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
