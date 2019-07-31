<?php
 $succesajout=0;
 $succesupdate=0;
session_start();
if(!isset ($_SESSION['id']))
    header('Location: index.php');
include("connexion.php");

if(isset($_GET['delete'])) {
    $id=htmlspecialchars($_GET['id']);
    $sql = "DELETE FROM `leoni`.`users` WHERE `users`.`id` = ".$id;
    $result = $conn->query($sql);
}
if(isset($_POST['defaultpassword']) && isset($_GET['add'])) {
    $sql = "INSERT INTO `leoni`.`users` (`id`, `name`, `lastname`, `password`, `defaultpassword`, `addedby`, `role`, `PS`) VALUES ('".htmlspecialchars($_POST['id'])."', NULL, NULL, '".md5($_POST['defaultpassword'])."', '".$_POST['defaultpassword']."','".$_SESSION['id']."','".$_POST['role']."','".$_POST['ps']."');";
    $result = $conn->query($sql);
    $succesajout=1;
     header('Location: gestionutilisateurs.php');  
    
}
if(isset($_POST['defaultpassword']) && isset($_GET['update']) && isset($_GET['id'])) {
    $sql = "UPDATE `leoni`.`users` SET `defaultpassword` = '".$_POST['defaultpassword']."',  `password` = '".md5($_POST['defaultpassword'])."', `role` = '".$_POST['role']."', `PS` = '".$_POST['ps']."' WHERE `users`.`id` = ".$_GET['id'];
    $result = $conn->query($sql);
    $succesupdate=1;
    header('Location: gestionutilisateurs.php'); 
}
?>
<?php include("header.php"); ?>


    <?php
        // Ajout utilisateur (si add=1 )
    if(isset($_GET['add'])) {
        ?>
         <div class="title">
            <h2>Ajout utilisateur</h2>
            <hr />
		</div>
        <?php
        if($succesajout) { ?>
        <p>Ajout avec succés</p>
        <?php } ?>
        <form id="form1" method="post" action="">
            <input name="id" type="text" placeholder="Matricule" size="20" class="x" required/><br />
            <input name="defaultpassword" type="text" placeholder="Mot de passe par défaut" size="60" id="defaultpassword" required/>
            <button onclick="makepass();return false;" class="generate">Génerer Aléatoirement</button>
           <select name="ps" class="role">
                <option value="AVW">AVW</option>
                <option value="MB">MB</option>
                <option value="SI">SI</option>
                <option value="MFA-IWR">MFA-IWR</option>
                <option value="MFA-MRA">MFA-MRA</option>
                <option value="MFA-WJIT">MFA-WJIT</option>
                <option value="BMW">BMW</option>
            </select>
             <select name="role" class="role">
                <option value="0">Demandeur</option>
                <option value="1">Technicien</option>
                <option value="2">Chef d'equipe</option>
            </select>
            <input name="Connexion" type="submit" value="Ajout" class="connexion" />
		</form>     
            
            
        <?php
    } elseif (isset($_GET['update'])) {
        $sql = "SELECT * FROM `users` WHERE `id`=".$_GET['id'];
        $result = $conn->query($sql);
        
        while($row = $result->fetch_assoc()) {

        
        ?>
        
     <div class="title">
            <h2>Mise à jour de l'utilisateur N°<?php echo($row['id']); ?></h2>
            <hr />
		</div>
        <?php
        if($succesupdate) { ?>
        <p>mise à jour avec succés</p>
        <?php } ?>

        <form id="form1" method="post" action="">
            <input name="defaultpassword" type="text" placeholder="Mot de passe par défaut" size="60"  value="<?php echo($row['defaultpassword']); ?>" id="defaultpassword" required/>
            <button onclick="makepass();return false;" class="generate">Génerer Aléatoirement</button>
           <select name="ps" class="role">
                <option value="AVW" <?php echo($row['PS'] == 'AWV' ? "selected" : ""); ?>>AVW</option>
                <option value="MB" <?php echo($row['PS'] == 'MB' ? "selected" : ""); ?>>MB</option>
                <option value="SI" <?php echo($row['PS'] == 'SI' ? "selected" : ""); ?>>SI</option>
                <option value="MFA-IWR" <?php echo($row['PS'] == 'MFA-IWR' ? "selected" : ""); ?>>MFA-IWR</option>
                <option value="MFA-MRA" <?php echo($row['PS'] == 'MFA-MRA' ? "selected" : ""); ?>>MFA-MRA</option>
                <option value="MFA-WJIT" <?php echo($row['PS'] == 'MFA-WJIT' ? "selected" : ""); ?>>MFA-WJIT</option>
                <option value="BMW" <?php echo($row['PS'] == 'BMW' ? "selected" : ""); ?>>BMW</option>
            </select>
             <select name="role" class="role">
                <option value="0"  <?php echo($row['role'] == 0 ? "selected" : ""); ?>>Demandeur</option>
                <option value="1"  <?php echo($row['role'] == 1 ? "selected" : ""); ?>>Technicien</option>
                <option value="2"  <?php echo($row['role'] == 2 ? "selected" : ""); ?>>Chef d'equipe</option>
            </select>
            <input name="Connexion" type="submit" value="Mise à jour" class="connexion" />
		</form>  
        
    <?php } } else { 
    ?>
        <div class="title">
            <h2>Gestion des utilisateurs</h2>
            <hr />
		</div>
        <a href="gestionutilisateurs.php?add=1" class="add">Ajouter utilisateur</a>
        <div class="crudtable">
        <table border="0">
            <tr>
                <td>Matricule</td>
                <td>Nom</td>
                <td>Prénom</td>
                <td>Mot de passe initiale</td>
                <td>PS</td>
                <td>Ajouté par</td>
                <td>Titre</td>
                <td>Actions</td>
            </tr>
       
        <?php

    $sql = "SELECT * FROM `users`";
    $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
           ?>
          <tr>
              <td><?php echo($row['id']); ?></td>
              <td><?php if(isset($row['lastname'])) echo($row['lastname']); else echo (" --- "); ?></td>
              <td><?php if(isset($row['name'])) echo($row['name']);else echo (" --- "); ?></td>
              <td><?php if(isset($row['defaultpassword'])) echo($row['defaultpassword']);else echo (" changé "); ?></td>
              <td><?php if(isset($row['PS'])) echo($row['PS']); ?></td>
              <td><?php if(isset($row['addedby'])) echo($row['addedby']); else echo (" --- ");?></td>
              <td><?php if(isset($row['role'])) {if($row['role'] == 1) { echo("Technicien");} elseif($row['role'] == 0) {echo("Demandeur"); } else {echo("Chef d'equipe");}} ?></td>
              
              <td>
                    <a href="gestionutilisateurs.php?update=1&id=<?php echo($row['id']); ?>"><img src="images/Check.png" alt="Mise a jour" /></a>
                  <?php $link="gestionutilisateurs.php?delete=1&id=".$row['id']; ?>
                    <a href="#" onclick="confirmdelete('<?php echo $link; ?>'); return false;"><img src="images/delete.png" alt="Supprimer" /></a>
              </td>
              
            </tr>
        <?php } ?>
        </table>
            <div id="dialog-confirm" title="Confirmer la suppression" style="display:none;">
                <p>êtes vous sûr de supprimer cet utilisateur ?</p>
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
</body>
</html>
