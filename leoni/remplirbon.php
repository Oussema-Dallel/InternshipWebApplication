<?php
session_start();
if(!isset ($_SESSION['id']))
    header('Location: index.php');
include("connexion.php");
$succesajout=0;
 $id=$_GET['id'];
if(isset($_POST['Description'])) {
    
    $id_tech = $_SESSION['id'];
    isset($_POST['codedef1']) ? $codedef1 = $_POST['codedef1'] : $codedef1 = NULL;
    isset($_POST['Description']) ? $Description = htmlspecialchars($_POST['Description']) : $Description = NULL;
    isset($_POST['codedef2']) ? $codedef2 = $_POST['codedef2'] : $codedef2 = NULL;
    isset($_POST['codedef3']) ? $codedef3 = $_POST['codedef3'] : $codedef3 = NULL;
    isset($_POST['datedebut']) ? $datedebut = $_POST['datedebut'] : $datedebut = NULL;
    isset($_POST['heuredebut']) ? $heuredebut = $_POST['heuredebut'] : $heuredebut = NULL;
    isset($_POST['datefin']) ? $datefin = $_POST['datefin'] : $datefin = NULL;
    isset($_POST['heurefin']) ? $heurefin = $_POST['heurefin'] : $heurefin = NULL;
    isset($_POST['mnp_aut']) ? $mnp_aut = $_POST['mnp_aut'] : $mnp_aut = NULL;
    isset($_POST['matricules'][0]) && $_POST['matricules'][0]!="" ? $matints = $_POST['matricules'] : $matints = NULL;
    isset($_POST['heures'][0]) && $_POST['heures'][0]!=""  ? $heureints = $_POST['heures'] : $heureints = NULL;
    $intervenants = array();
    if($matints!=NULL && $heureints!=NULL) {
        for($i=0;$i<count($matints);$i++) {
            if($matints[$i]!=NULL && $matints[$i]!="" && $heureints[$i]!=NULL && $heureints[$i]!="") {
                $intervenants[$i]=array();
                $intervenants[$i]['intervenant'] = $matints[$i];
                $intervenants [$i]['heures'] =  $heureints[$i];
                $query = "SELECT COUNT(*) as x from users where id=".$matints[$i];
                $result = $conn->query($query);
                $row = $result->fetch_assoc();
                if($row["x"]==0) $succesajout=2;
            }    
        }
    }
    
if($succesajout==0) {  
$sql = "UPDATE `leoni`.`bondetravail` SET 
        `code_def1` = '".$codedef1."',
        `description_traveaux` = '".$Description."',
        `id_tech` = '".$id_tech."',
        `code_def2` = '".$codedef2."',
        `code_def3` = '".$codedef3."',
        `date_debut_travaux` = '".$datedebut."',
        `heure_debut_travaux` = '".$heuredebut."',
        `date_fin_travaux` = '".$datefin."',
        `heure_fin_travaux` = '".$heurefin."',
        `mnp_aut` = '".$mnp_aut."',
        `etat` = 'attente_chef',
        `technicien_supp` = '".serialize($intervenants)."'
    WHERE `bondetravail`.`num_ot` = ".$id.";";
    $result = $conn->query($sql);
    $succesajout=1;
}
}  
include("header.php");
    $sql = "SELECT * from bondetravail B,equipements E,users U where U.id= B.id_demandeur AND B.id_table= E.id_table AND B.num_ot = ".$id." AND E.PS_equipement = '".$_SESSION['PS']."';";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

?>
        <div class="title">
   
	  <h2>Compte rendu du bon de travail N&deg; <?php if(isset($row['num_ot'])) echo($row['num_ot']); else echo (" --- "); ?></h2>
		</div>
    <div class="warning">
            <p><?php 
                if($succesajout==1) echo "Succés d'envoi ";
                if($succesajout==2) echo "Matricule d'intervenant non existant "; 
        ?></p>
            </div>
        <div class="crudtable" >
        <table border="0" >
            <tr>
            
                <td>Demandeur</td>
                <td>Nom &amp; Prénom</td>
                <td>Segment</td>
                <td>Equipement</td>
                <td>Date d'arrêt</td>
                <td>Heure d'arrêt</td>
                <td>Description</td>
                <td>Remarques</td>
                
            </tr>
            <tr id="printableArea">
                <td><?php if(isset($row['id_demandeur'])) echo($row['id_demandeur']); else echo (" --- "); ?></td>
                <td><?php if(isset($row['name'])) echo($row['name']); else echo (" --- "); ?> <?php if(isset($row['lastname'])) echo($row['lastname']); else echo (" --- "); ?></td>
                <td><?php if(isset($row['segment'])) echo($row['segment']); else echo (" --- "); ?></td>
                <td>T<?php if(isset($row['id_table'])) echo($row['id_table']); else echo (" --- "); ?></td>
                <td><?php if(isset($row['date_ot'])) echo($row['date_ot']); else echo (" --- "); ?></td>
                <td><?php if(isset($row['temps_ot'])) echo($row['temps_ot']); else echo (" --- "); ?></td>
                <td><?php if(isset($row['description_panne'])) echo($row['description_panne']); else echo (" --- "); ?></td>
                <td><?php if(isset($row['remarque'])) echo($row['remarque']); else echo (" --- "); ?></td>
            </tr>
            </table>
        </div>

         <form id="form1" method="post" action="" class="compterendu">
             
             
             
             <table border="0" class="compterendu">
                 <tr>
                    <td colspan="2"> 
                        <input name="datedebut" type="text" placeholder="Date Debut" class="x dpicker" value="<?php if(isset($row['date_debut_travaux']) && $row['etat'] == 'attente_chef') echo($row['date_debut_travaux']);?>" required />
                        <input name="heuredebut" type="text" placeholder="Heure Debut"  class="x spinner" value="<?php if(isset($row['heure_debut_travaux']) && $row['etat'] == 'attente_chef') echo($row['heure_debut_travaux']);?>" required /></td>
                     <td colspan="2">
                        <input name="datefin" type="text" placeholder="Date Fin" size="20" class="x dpicker" value="<?php if(isset($row['date_fin_travaux']) && $row['etat'] == 'attente_chef') echo($row['date_fin_travaux']);  ?>" required />
                        <input name="heurefin" type="text" placeholder="Heure Fin" class="x spinner" value="<?php if(isset($row['heure_fin_travaux']) && $row['etat'] == 'attente_chef') echo($row['heure_fin_travaux']); ?>" required />
                     </td>
                 </tr>
                   <tr>
                    <td colspan="2"> 
                        <textarea name="Description" placeholder="Description travaux" class="compterendu" required><?php if(isset($row['description_traveaux']) && $row['etat'] == 'attente_chef') echo($row['description_traveaux']); ?></textarea>
                     </td>
                       <td colspan="2">
                            <div id="dynamicMat">
                                    Matricule Intervenant 1<br><input type="text" name="matricules[]">
                                    
                             </div>
                           <div id="dynamicHeure">
                           Heures Prestées<br><input type="text" name="heures[]">
                           </div>
                            <input type="button" value="Ajouter Intervenant" onClick="addInput();" class="connexion">


                       </td>
                 </tr>
                <tr>
                    <td>
                        <select name="mnp_aut" required>
                            <option value=""  <?php echo(!isset($row['mnp_aut']) || $row['mnp_aut']=='' ? "selected" : ""); ?> disabled>Type Maintenance</option>
                            <option value="0"  <?php echo($row['mnp_aut'] == '0' ? "selected" : ""); ?>>MNP - Maintenance non plannifié</option>
                            <option value="1" <?php echo($row['mnp_aut'] == '1' ? "selected" : ""); ?>>AUT - Travaux divers et améliorations</option>
                        </select>
                    </td>
                    <td>
                    <select name="codedef1" required>
                        <option value="" <?php echo(!isset($row['code_def1']) || $row['code_def1']=='' ? "selected" : ""); ?> disabled>Code Defaut 1 (What)</option>
                        <option value="Mecanique" <?php echo($row['code_def1'] == 'Mecanique' ? "selected" : ""); ?>>Mecanique</option>
                        <option value="Electrique" <?php echo($row['code_def1'] == 'Electrique' ? "selected" : ""); ?>>Electrique</option>
                        <option value="Pneumatique" <?php echo($row['code_def1'] == 'Pneumatique' ? "selected" : ""); ?>>Pneumatique</option>
                        <option value="Logiciel" <?php echo($row['code_def1'] == 'Logiciel' ? "selected" : ""); ?>>Logiciel</option>
                        <option value="Hydrautique" <?php echo($row['code_def1'] == 'Hydrautique' ? "selected" : ""); ?>>Hydrautique</option>
                        <option value="Maintenance" <?php echo($row['code_def1'] == 'Maintenance' ? "selected" : ""); ?>>Maintenance</option>
                        <option value="Inspection" <?php echo($row['code_def1'] == 'Inspection' ? "selected" : ""); ?>>Inspection</option>
                    </select>
                    </td>
                    <td>
                        <select name="codedef2" required >
                            <option value="" <?php echo(!isset($row['code_def2']) || $row['code_def2']=='' ? "selected" : ""); ?> disabled>Code Defaut 2 (Why)</option>
                            <option value="Cassure" <?php echo($row['code_def2'] == 'Cassure' ? "selected" : ""); ?>>Cassure</option>
                            <option value="Usure" <?php echo($row['code_def2'] == 'Usure' ? "selected" : ""); ?>>Usure</option>
                            <option value="Saleté" <?php echo($row['code_def2'] == 'Saleté' ? "selected" : ""); ?>>Saleté</option>
                            <option value="Blockage" <?php echo($row['code_def2'] == 'Blockage' ? "selected" : ""); ?>>Blockage</option>
                            <option value="Desserage" <?php echo($row['code_def2'] == 'Desserage' ? "selected" : ""); ?>>Desserage</option>
                            <option value="Surchage" <?php echo($row['code_def2'] == 'Surchage' ? "selected" : ""); ?>>Surchage</option>
                            <option value="Mauvaiseutilisation" <?php echo($row['code_def2'] == 'Mauvaiseutilisation' ? "selected" : ""); ?>>Mauvaise utilisation</option>
                            <option value="Mauvaisereglage" <?php echo($row['code_def2'] == 'Mauvaisereglage' ? "selected" : ""); ?>>Mauvaise Reglage</option>
                            <option value="AlimentationElectriqueAir" <?php echo($row['code_def2'] == 'AlimentationElectriqueAir' ? "selected" : ""); ?>>Alimentation Electrique-Air</option>
                            <option value="Courtcircuit" <?php echo($row['code_def2'] == 'Courtcircuit' ? "selected" : ""); ?>>Court circuit</option>
                        </select>
                    </td>
                    <td>
                        <input value="<?php if(isset($row['code_def3']) && $row['etat'] == 'attente_chef') echo($row['code_def3']); ?>" name="codedef3" type="text" placeholder="Code Defaut 3 (Where)" class="x" required />
                    </td>
                 </tr>
             </table>
             
             
           
            <input name="Confirmer" type="submit" value="Confirmer" class="connexion" />
		</form>
        
	</div>
    
	
	
</div>

<div id="copyright">
	<p> Leoni &copy; - <?php echo(date('Y')); ?></p>
</div>
    <script>
    $.widget( "ui.timespinner", $.ui.spinner, {
    options: {
      // seconds
      step: 60 * 1000,
      // hours
      page: 60
    },
 
    _parse: function( value ) {
      if ( typeof value === "string" ) {
        // already a timestamp
        if ( Number( value ) == value ) {
          return Number( value );
        }
        return +Globalize.parseDate( value );
      }
      return value;
    },
 
    _format: function( value ) {
      return Globalize.format( new Date(value), "t" );
    }
  });
        
    startTime();
    $(".dpicker").datepicker({
        inline: true,dateFormat: 'yy-mm-dd'
    });
    Globalize.culture("de-DE");
    $( ".spinner" ).timespinner();
        
        
        
       var counter = 1;
var limit = 5;
function addInput(){
     if (counter == limit)  {
          alert("Vous avez atteint la limite d'ajout des intervenants");
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "Matricule Intervenant " + (counter + 1) + " <br><input type='text' name='matricules[]'>";
          document.getElementById("dynamicMat").appendChild(newdiv);
         var newdiv = document.createElement('div');
          newdiv.innerHTML = "Heures Prestées <br><input type='text' name='heures[]'>";
          document.getElementById("dynamicHeure").appendChild(newdiv);
          counter++;
     }
}
    </script>
</body>
</html>
