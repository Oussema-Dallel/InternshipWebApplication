<?php
    include("connexion.php");
    $id=$_GET['id'];
    $datedebut=$_GET['datedebut'];
    $datefin=$_GET['datefin'];
function convertToHoursMins($time, $format = '%d:%d') {
    settype($time, 'integer');
    if ($time < 1) {
        return 0;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}
function convertToHoursSec($time, $format = '%d:%d') {
    settype($time, 'integer');
    if ($time < 1) {
        return 0;
    }
    $hours = floor($time / 3600);
    $minutes = ($time % 3600);
    return sprintf($format, $hours, $minutes);
}
     $sql = "SELECT * FROM `equipements` where `id_table` = ".$id ;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($result->num_rows == 0) {
        echo("<p>Table non trouvé !</p>");
    }elseif($datefin<$datedebut || $row['date_entree']>$datedebut) {
        echo("<p>Date Erronnée !</p>");
    }
    else {
        $nbinterventions=0;
        $tempsintervention=0;
        $sql="SELECT COUNT(*) as Nombre FROM `bondetravail` WHERE id_table = ".$id." AND date_debut_travaux between '".$datedebut."' and '".$datefin."';";
         $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $nbinterventions= $row['Nombre'];
        }
         $sql="SELECT SUM((DATEDIFF(`date_fin_travaux`,`date_debut_travaux`)*1440)+(TIME_TO_SEC(TIMEDIFF(`heure_fin_travaux`,`heure_debut_travaux`))/60)) as Nombre FROM `bondetravail` WHERE id_table = ".$id." AND date_debut_travaux between '".$datedebut."' and '".$datefin."';";
         $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $tempsintervention= $row['Nombre'];
        }
        
        //echo(convertToHoursMins($tempsintervention));
        
        $sql="SELECT SUM((DATEDIFF(`date_debut_travaux`,`date_ot`)*1440)+(TIME_TO_SEC(TIMEDIFF(`heure_debut_travaux`,`temps_ot`))/60)) as Nombre FROM `bondetravail` WHERE id_table = ".$id." AND date_debut_travaux between '".$datedebut."' and '".$datefin."';";
         $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $tempsimo= $row['Nombre'];
        }
         $mtbf=0;
        $mttrr=0;
        $mtimo=0;
        if($nbinterventions!=0) {
        $mtbf=date_diff(date_create($datedebut),date_create($datefin))->format("%a")*1440-($tempsimo+$tempsintervention)/$nbinterventions;
        $mttrr=$tempsintervention/$nbinterventions;
        $mtimo=$tempsimo/$nbinterventions;
            }
        ?>
<div class="crudtable bilantable">
        <table id="bilantable">
            <tr>
                <td colspan="2">
                    Statistiques  du table <?php echo($id); ?> de  <?php echo($datedebut); ?> à  <?php echo($datefin); ?>
                </td>
            </tr>
            <tr>
                <td>
                    Nombre d'interventions
                </td>
                <td>
                    <?php echo($nbinterventions); ?>
                </td>
            </tr>
            <tr>
                <td>
                    Temps d'interventions totale
                </td>
                <td>
                    <?php echo(convertToHoursMins($tempsintervention)); ?>
                </td>
            </tr>
            <tr>
                <td>
                    Temps d'immobilisation totale
                </td>
                <td>
                    <?php echo(convertToHoursMins($tempsimo)) ?>
                </td>
            </tr>
            <tr>
                <td>
                    Moyenne Temps Bon Fonctionnement
                </td>
                <td>
                    <?php echo(convertToHoursMins($mtbf)); ?>
                </td>
            </tr>
            <tr>
                <td>
                    Moyenne Temps Technique de réparation
                </td>
                <td>
                    <?php echo(convertToHoursMins($mttrr)); ?>
                </td>
            </tr>
            <tr>
                <td>
                    Moyenne Temps immobilisation
                </td>
                <td>
                    <?php echo(convertToHoursMins($mtimo)); ?>
                </td>
            </tr>

        </table>
     
</div>


<?php
        function createDateRangeArray($strDateFrom,$strDateTo)
{
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.

    // could test validity of dates here but I'm already doing
    // that in the main script

    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}        
       
 
?>

<?php
       if(sizeof(createDateRangeArray($datedebut,$datefin))>2) { ?> 
<script>
        
$(function () {
    <?php $chart=$_GET['chart']; ?>
    $('#container<?php echo($chart); ?>').highcharts({
        exporting: {
         enabled: false
},
            credits: {
        enabled: false
      },
        chart: {
            zoomType: 'x'
        },
        title: {
            text: 'Graphes',
            x: -10 //center
        },
        xAxis: {
            categories: [
                        <?php 
                            $jours=createDateRangeArray($datedebut,$datefin);
                            for($i=0;$i<sizeof($jours);$i++){
                                echo("'".$jours[$i]."' ,");
                            }
                             ?>
                        ]
        },
        yAxis: {
            title: {
                text: 'Durée (Heures)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: 'H'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'Temps d\'interventions',
            data: [<?php
          $sql="SELECT date_debut_travaux,date_fin_travaux,heure_debut_travaux,heure_fin_travaux FROM `bondetravail` WHERE id_table = ".$id." AND date_debut_travaux between '".$datedebut."' and '".$datefin."';";
         $result = $conn->query($sql);
        $dd=$datedebut;
        $nbre=$result->num_rows;
        while($row = $result->fetch_assoc()) {

             $nbredeszeros=createDateRangeArray($dd,$row['date_debut_travaux']);
             for($i=1;$i<sizeof($nbredeszeros);$i++){
              echo("0".","); 
             }
            if(date_create($row['date_fin_travaux'])>date_create($datefin)) {
            $jours=createDateRangeArray($row['date_debut_travaux'],$datefin);
                }else {
            $jours=createDateRangeArray($row['date_debut_travaux'],$row['date_fin_travaux']);

            }
            for($i=0;$i<sizeof($jours);$i++){
                         if($i==0) {
                             
                             echo date_diff(date_create("24:00:00"),date_create($row['heure_debut_travaux']))->format("%h.%i").",";
                           } 
                 
                            elseif($i==sizeof($jours)-1) {
                                            if(date_create($row['date_fin_travaux'])>date_create($datefin)) {
                                                    echo("24".",");
                                                }else {
                                                    echo(date("G.i", strtotime($row['heure_fin_travaux'])).",");  

            }
                                
                            }else {
                                echo("24".",");
                            }
                 
            }
            $nbre--;
            $dd=$row['date_fin_travaux'];
            if($nbre==0) {
                $nbredeszeros=createDateRangeArray($dd,$datefin);
             for($i=1;$i<sizeof($nbredeszeros);$i++){
              echo("0".","); 
             }
            }
            }
        ?>]
            
            
            
        }, {
            name: 'Temps d\'immobilisation',
            data: [<?php
          $sql="SELECT date_debut_travaux,date_ot,heure_debut_travaux,temps_ot FROM `bondetravail` WHERE id_table = ".$id." AND date_debut_travaux between '".$datedebut."' and '".$datefin."';";
         $result = $conn->query($sql);
        $dd=$datedebut;
        $nbre=$result->num_rows;
        while($row = $result->fetch_assoc()) {

             $nbredeszeros=createDateRangeArray($dd,$row['date_ot']);
             for($i=1;$i<sizeof($nbredeszeros);$i++){
              echo("0".","); 
             }
            if(date_create($row['date_debut_travaux'])>date_create($datefin)) {
            $jours=createDateRangeArray($row['date_ot'],$datefin);
                }else {
            $jours=createDateRangeArray($row['date_ot'],$row['date_debut_travaux']);

            }
            for($i=0;$i<sizeof($jours);$i++){
                         if($i==0) {
                             if(date_create($row['date_ot'])<date_create($dd)) {
                                                    echo("24".",");
                                                }else {
                                                    
 echo date_diff(date_create("24:00:00"),date_create($row['temps_ot']))->format("%h.%i").",";
            }
                            
                           } 
                 
                            elseif($i==sizeof($jours)-1) {
                                            if(date_create($row['date_debut_travaux'])>date_create($datefin)) {
                                                    echo("0".",");
                                                }else {
                                                    echo(date("G.i", strtotime($row['heure_debut_travaux'])).",");  

            }
                                
                            }
                else {
                                 echo(date("G.i", strtotime($row['heure_debut_travaux'])).","); 
                               
                            }
                 
            }
            $nbre--;
            $dd=$row['date_debut_travaux'];
            if($nbre==0) {
                $nbredeszeros=createDateRangeArray($dd,$datefin);
             for($i=1;$i<sizeof($nbredeszeros);$i++){
              echo("0".","); 
             }
            }
            }
        ?>]
        }]
    });
});
</script>

    <?php
                                                                }
    }

?>
        