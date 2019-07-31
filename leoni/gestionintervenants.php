<?php
 $succesajout=0;
 //$succesupdate=0;
session_start();
if(!isset ($_SESSION['id']))
    header('Location: index.php');
include("connexion.php");

if(isset($_GET['delete']) && ($_SESSION['role']==2)) {
    $id_inter=htmlspecialchars($_GET['id_intervenant']);
    $sql = "DELETE FROM `leoni`.`intervenant` WHERE `intervenant`.`id_intervenant` = ".$id_inter;
    $result = $conn->query($sql);
}
if(isset($_POST['id_intervenant'])  && isset($_GET['add']) && ($_SESSION['role']==2)) {
    $sql = "INSERT INTO `leoni`.`intervenant` (`id_intervenant`, `nom_inter`, `prenom_inter`, `cout_horaire`) VALUES ('".htmlspecialchars($_POST['id_intervenant'])."', '".$_POST['nom_inter']."', '".$_POST['prenom_inter']."', '".$_POST['cout_horaire']."');";
    $result = $conn->query($sql);
    $succesajout=1;
    
}
?>

<?php include("header.php"); ?>
    
         <?php
        // Ajout utilisateur (si add=1 )
    if(isset($_GET['add'])) {
        ?>
         <div class="title">
            <h2>Ajout intervenant</h2>
            <hr />
		</div>
        <?php
        if($succesajout) { ?>
        <p>Ajout avec succés</p>
        <?php } ?>
        
        <form id="form1" method="post" action="">
            <input name="id_intervenant" type="text" placeholder="Matricule" size="20" class="x"/><br />
            <input name="nom_inter" type="text" placeholder="Nom" size="60" /><br />
            <input name="prenom_inter" type="text" placeholder="Prenom" size="20" class="x"/><br />
            <input name="cout_horaire" type="text" placeholder="Cout horaire" size="20" class="x"/><br />
            <br />
            
            <input name="Connexion" type="submit" value="Ajout" class="connexion" />
		</form>     
            
        <?php 
    } else {
        ?>
         <div class="title">
            <h2>Gestion des intervenants</h2>
            <hr />
		</div>
        <?php 
        if($_SESSION['role']==2)
        { ?>
        <a href="gestionintervenants.php?add=1" class="add">Ajouter intervenant</a>
        <?php 
        }
        ?>
        <div class="crudtable">
        <table border="0">
            <tr>
                <td>Matricule</td>
                <td>Nom</td>
                <td>Prenom</td>
                <td>Cout horaire</td>
                 <?php 
        if($_SESSION['role']==2)
        { ?>
                <td>Actions</td>
             <?php 
        }
        ?>    
            </tr>
       
        <?php

    $sql = "SELECT * FROM `intervenant`";
    $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
           ?>
          <tr>
              <td><?php echo($row['id_intervenant']); ?></td>
              <td><?php if(isset($row['nom_inter'])) echo($row['nom_inter']); else echo (" --- "); ?></td>
              <td><?php if(isset($row['prenom_inter'])) echo($row['prenom_inter']);else echo (" --- "); ?></td>
              <td><?php if(isset($row['cout_horaire'])) echo($row['cout_horaire']); ?></td>
                <?php 
        if($_SESSION['role']==2)
        { ?>
              <td>
                    <a href="gestionintervenants.php?delete=1&id_intervenant=<?php echo($row['id_intervenant']); ?>"><img src="images/delete.png" alt="Supprimer" /></a>
              </td>
               <?php 
        }
        ?>        
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
