<?php
 $succesajout=0;
 //$succesupdate=0;
session_start();
if(!isset ($_SESSION['id']))
    header('Location: index.php');
include("connexion.php");

if(isset($_GET['delete']) && ($_SESSION['role']==2)) {

    $table=htmlspecialchars($_GET['table']);
    $sql = "DELETE FROM `leoni`.`equipements` WHERE `equipements`.`id_table` = ".$table;
    $result = $conn->query($sql);
}
if(isset($_POST['table'])  && isset($_GET['add']) && ($_SESSION['role']==2)) {
    $sql = "SELECT * FROM `equipements` where `id_table` = ".$_POST['table'];
    $result = $conn->query($sql);
     if ($result->num_rows == 0) {
    $sql = "INSERT INTO `leoni`.`equipements` (`id_table`, `PS_equipement`, `segment`, `type`, `date_entree`) VALUES ('".htmlspecialchars($_POST['table'])."', '".htmlspecialchars($_POST['PS'])."', '".$_POST['segment']."', '".$_POST['type']."', '".$_POST['date_entree']."');";
    $result = $conn->query($sql);
    $succesajout=1;
   
    header('Location: equipements.php');    
           } else {
         
          $succesajout=2;
     }
}
?>

<?php include("header.php"); ?>
         <?php
        // Ajout utilisateur (si add=1 )
    if(isset($_GET['add'])) {
        ?>
         <div class="title">
            <h2>Ajout equipement</h2>
            <hr />
		</div>
        <?php
        if($succesajout==2) { ?>
        <p>Table déja trouvé</p>
        <?php } ?>
        
        <form id="form1" method="post" action="">
            <input name="table" type="text" placeholder="Table de CE" size="20" class="x" required/><br />
            <select class="role" name="PS" required>
                <option value="" selected disabled>PS</option>
                <option value="AVW">AVW</option>
                <option value="MB">MB</option>
                <option value="SI">SI</option>
                <option value="MFA-IWR">MFA-IWR</option>
                <option value="MFA-MRA">MFA-MRA</option>
                <option value="MFA-WJIT">MFA-WJIT</option>
                <option value="BMW">BMW</option>
            </select>
            <input name="segment" type="text" placeholder="Segment" size="20" class="x" required/><br />
                <select class="role" name="type" required>
                <option value="" selected disabled>Type</option>
                <option value="TSK">TSK</option>
                <option value="BAK">BAK</option>
                <option value="MPB">MPB</option>
                <option value="CASS">CASS</option>
                <option value="VISSEUSE">VISSEUSE</option>
                <option value="WEE">WEE</option>
            </select>
            <input name="date_entree" type="text" placeholder="Date d'entree en production" size="20" class="x" id="dpicker" required/>
            <br />
            
            <input name="Connexion" type="submit" value="Ajout" class="connexion" />
		</form>     
            
        <?php 
    } else {
       
        if($_SESSION['role']==2)
        { ?>
         <div class="title">
            <h2>Gestion des equipements</h2>
            <hr />
		</div>
<?php } else {
            ?>
<div class="title">
            <h2>Consultation des equipements</h2>
            <hr />
		</div>
        <?php } 
        if($_SESSION['role']==2)
        { ?>
        <a href="equipements.php?add=1" class="add">Ajouter equipement</a>
        <?php 
        }
        ?>
        <div class="crudtable">
        <table border="0">
            <tr>
                <td>Table de CE</td>
                <td>PS</td>
                <td>Segment</td>
                <td>Type</td>
                <td>Date d'entree en prduction</td>
                 <?php 
        if($_SESSION['role']==2)
        { ?>
                <td>Actions</td>
             <?php 
        }
        ?>    
            </tr>
       
        <?php

    $sql = "SELECT * FROM `equipements`";
    $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
           ?>
          <tr>
              <td><?php echo($row['id_table']); ?></td>
              <td><?php if(isset($row['PS_equipement'])) echo($row['PS_equipement']); else echo (" --- "); ?></td>
              <td><?php if(isset($row['segment'])) echo($row['segment']);else echo (" --- "); ?></td>
              <td><?php if(isset($row['type'])) echo($row['type']); ?></td>
              <td><?php if(isset($row['date_entree'])) echo($row['date_entree']); ?></td>
                <?php 
        if($_SESSION['role']==2)
        { ?>
              <td>
                    <a onclick="confirmdelete('equipements.php?delete=1&table=<?php echo($row['id_table']); ?>'); return false;" href="#"><img src="images/delete.png" alt="Supprimer" /></a>
              </td>
               <?php 
        }
        ?>        
            </tr>
        <?php } ?>
        </table>
            <div id="dialog-confirm" title="Confirmer la suppression" style="display:none;">
                <p>êtes vous sûr de supprimer cet equipement ?</p>
            </div>
</div>
        <?php } ?>
	</div>
    
	
	
</div>

<div id="copyright">
	<p> Leoni &copy; - <?php echo(date('Y')); ?></p>
</div>
    <script>
    startTime();
        
        function confirmdelete(i) {
             $( "#dialog-confirm" ).dialog({
                autoOpen: false,
                resizable: false,
                height:220,
                width: 320,
                modal: true,
                 buttons: {
                        "Supprimer": function() {
                          $( this ).dialog( "close" );
                             window.location=i;
                        },
                        "Annuler": function() {
                          $( this ).dialog( "close" );
                        }
                  }
                });
             $( "#dialog-confirm" ).dialog( "open" );

        }
       
    </script>
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script>
$("#dpicker").datepicker({
	inline: true,dateFormat: 'yy-mm-dd'
});
</script>
</body>
</html>
