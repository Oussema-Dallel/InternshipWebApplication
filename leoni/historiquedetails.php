    <?php
session_start();
if(!isset ($_SESSION['id']))
    header('Location: index.php');

include("connexion.php");
$id=$_GET['id'];
    $sql = "SELECT * from bondetravail B,equipements E,users U where U.id= B.id_demandeur AND B.id_table= E.id_table AND B.num_ot = ".$id." AND E.PS_equipement = '".$_SESSION['PS']."';";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $sql = "SELECT * from bondetravail B,equipements E,users U where U.id= B.id_tech AND B.id_table= E.id_table AND B.num_ot = ".$id." AND E.PS_equipement = '".$_SESSION['PS']."';";
    $result = $conn->query($sql);
    $row2 = $result->fetch_assoc();
           ?>
<html>
    <head><title>Bon De travail</title>
    </head>
    <body>
    <div style=" font-family: Helvetica;">
        <img src="images/leoni_logo_print_version.png" alt="" style=" float: right;padding: 0.5em 0 1em;"/>
    <h1 style="text-align: left;">BON DE TRAVAIL N&deg; : <?php if(isset($row['num_ot'])) echo($row['num_ot']); else echo (" --- "); ?></h1>
<table border="0" style="border: 1px solid black;padding: 22px;border-collapse: collapse;width: 100%;vertical-align:top">
    <tr>
                <td style="border: 1px solid black;padding: 22px;"><b>Matricule :</b> <?php if(isset($row['id_demandeur'])) echo($row['id_demandeur']); else echo (" --- "); ?></td>
                <td style="border: 1px solid black;padding: 22px;"><b>Demandeur :</b> <?php if(isset($row['name'])) echo($row['name']); else echo (" --- "); ?> <?php if(isset($row['lastname'])) echo($row['lastname']); else echo (" --- "); ?></td>
                <td style="border: 1px solid black;padding: 22px;"><b>Segment : </b><?php if(isset($row['segment'])) echo($row['segment']); else echo (" --- "); ?></td>
    </tr>
    <tr>
                <td style="border: 1px solid black;padding: 22px;"><b>Equipement :</b> T<?php if(isset($row['id_table'])) echo($row['id_table']); else echo (" --- "); ?></td>
                <td style="border: 1px solid black;padding: 22px;"><b>Date d'arr&ecirc;t :</b> <?php if(isset($row['date_ot'])) echo($row['date_ot']); else echo (" --- "); ?></td>
                <td style="border: 1px solid black;padding: 22px;"><b>Heure d'arr&ecirc;t :</b> <?php if(isset($row['temps_ot'])) echo($row['temps_ot']); else echo (" --- "); ?></td>
    </tr>
    
    <tr>
                <td colspan="2" style="border: 1px solid black;padding: 22px;"><b>Description :</b> <?php if(isset($row['description_panne'])) echo($row['description_panne']); else echo (" --- "); ?></td>
                <td colspan="1" style="border: 1px solid black;padding: 22px;"><b>Remarques :</b> <?php if(isset($row['remarque'])) echo($row['remarque']); else echo (" --- "); ?></td> 
     </tr>
    
     <tr>
                <td colspan="2" style="border: 1px solid black;padding: 22px;"><b>Nom et pr&eacute;nom Technicien :</b> <?php if(isset($row2['name'])) echo($row2['name']); else echo (" --- "); ?> <?php if(isset($row2['lastname'])) echo($row2['lastname']); else echo (" --- "); ?></td>
                <td colspan="1" style="border: 1px solid black;padding: 22px;"><b>Matricule :</b> <?php if(isset($row['id_tech'])) echo($row['id_tech']); else echo (" --- "); ?></td> 
     </tr>
    
    
    <tr>
                <td colspan="1" style="border: 1px solid black;padding: 22px;"><b>Re&ccedil;u le :</b></td>
                <td colspan="2" style="border: 1px solid black;padding: 22px;text-align:center;"><?php if(isset($row['date_debut_travaux'])) echo($row['date_debut_travaux']); else echo (" --- "); ?>  <?php if(isset($row['heure_debut_travaux'])) echo($row['heure_debut_travaux']); else echo (" --- "); ?></td> 
     </tr>
    
    <tr>
                <td colspan="1" style="border: 1px solid black;padding: 22px;"><b>Fin le :</b></td>
                <td colspan="2" style="border: 1px solid black;padding: 22px;text-align:center;"><?php if(isset($row['date_fin_travaux'])) echo($row['date_fin_travaux']); else echo (" --- "); ?>  <?php if(isset($row['heure_fin_travaux'])) echo($row['heure_fin_travaux']); else echo (" --- "); ?></td> 
     </tr>
    
    
    <tr>
                <td colspan="2" style="border: 1px solid black;padding: 22px;"><b>Description des travaux :</b> <?php if(isset($row['description_traveaux'])) echo($row['description_traveaux']); else echo (" --- "); ?></td>
                <td colspan="1" style="border: 1px solid black;padding: 22px;"><b>Type maintenance :</b> <?php if(isset($row['mnp_aut']) && $row['mnp_aut'] ==0) echo("MNP - Maintenance non plannifi&eacute;"); elseif(isset($row['mnp_aut']) && $row['mnp_aut'] ==1) echo("AUT - Travaux divers et améliorations"); else echo (" --- "); ?></td> 
     </tr>
    <tr>
                <td style="border: 1px solid black;padding: 22px;"><b>Code D&eacute;faut 1 :</b> <?php if(isset($row['code_def1'])) echo($row['code_def1']); else echo (" --- "); ?></td>
                <td style="border: 1px solid black;padding: 22px;"><b>Code D&eacute;faut 2 :</b> <?php if(isset($row['code_def2'])) echo($row['code_def2']); else echo (" --- "); ?></td>
                <td style="border: 1px solid black;padding: 22px;"><b>Code D&eacute;faut 3 :</b> <?php if(isset($row['code_def3'])) echo($row['code_def3']); else echo (" --- "); ?></td>
    </tr>
    
    <?php 
        $i=0;
        foreach(unserialize($row['technicien_supp']) as $intervenant) {
            if($i==0) {?>
                 <tr>
                <td style="border: 1px solid black;padding: 22px;"><b>Nom et Pr&eacute;nom Intervenant :</b></td>
                     <td style="border: 1px solid black;padding: 22px;"><b>Matricule</b></td>
                <td style="border: 1px solid black;padding: 22px;"><b>Heures prest&eacute;es</b></td>
                  </tr>     
           <?php }
             $sql = "SELECT * from users where id=".$intervenant['intervenant'].";";
    $result = $conn->query($sql);
    $nometprenom = $result->fetch_assoc();
                ?>
                   <tr>
                <td style="border: 1px solid black;padding: 22px;"><b><?php echo($nometprenom['name']); ?> <?php echo($nometprenom['lastname']); ?></b></td>
                     <td style="border: 1px solid black;padding: 22px;"><?php echo($intervenant['intervenant']); ?></td>
                <td style="border: 1px solid black;padding: 22px;"><?php echo($intervenant['heures']); ?></td>
                  </tr>    
        <?php
            
           
            $i++;
        }
            
            ?>

    
    </table>
    </div>
       <script>
        window.print();
        
        </script>
    </body>
    
</html>