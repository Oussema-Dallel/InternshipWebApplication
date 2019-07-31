
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Leoni | Interface de Gestion de maintenance</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<!--<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900|Quicksand:400,700|Questrial" rel="stylesheet" />-->
<link href="css/default.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/fonts.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/jquery-ui.css" rel="stylesheet" type="text/css" media="all" />
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/globalize.js"></script>
<script type="text/javascript" src="js/globalize.culture.de-DE.js"></script>
<script src="js/highcharts.js"></script>
<script src="js/exporting.js"></script>
</head>
<body>
<div id="header-wrapper">
	<div id="header" class="container">
        <div id="tools">
            <a href="#" onclick="toggleFullScreen()" id="fullscreen">Passer en mode plein écran</a>
            <p id="date"></p>
            <p id="time"></p>
        </div>
		<div id="logo">
        	<a href="workspace.php"><img src="images/leoni_logo.png" /></a>
		</div>
        <?php
        $defaultpassxx=false;
         $sql = "SELECT * FROM `users` WHERE `id`=".$_SESSION['id'];
    $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            if(md5($row["defaultpassword"])== $row["password"]) {
                
              $defaultpassxx = true;
            }
        }
        if(!$defaultpassxx) { ?>
        <div id="menu">
			<ul> <?php 
                            if($_SESSION['role']==2) {
                                ?>
                <li><a href="#" title="">Gestion</a>
                    <ul>
                        <li><a href="equipements.php" title="">Gestion des équipements</a></li>
                          
                        <li><a href="gestionutilisateurs.php" title="">Gestion des utilisateurs</a></li>
                        
                    </ul>
                </li>
                <?php
                            } else {
                        ?>
                 <li><a href="equipements.php" title="">Consultation des équipements</a>
                     <?php } ?>
                <?php if($_SESSION['role']==0) { ?>
                <li><a href="bontravail.php" title="">Demande des travaux</a></li>
                <?php  } else if($_SESSION['role']==1) { 
                 $sql = "SELECT COUNT(*)  as somme from bondetravail B,equipements E,users U where U.id= B.id_demandeur AND B.etat = 'attente_technicien' AND B.id_table= E.id_table AND E.PS_equipement = '".$_SESSION['PS']."';";
                $result = $conn->query($sql);
                $followingdata = $result->fetch_assoc();
                ?>
                
                <li><a href="bontravail.php" title="">Suivi des bons de travail<sup><?php echo $followingdata["somme"];?></sup></a></li>
                <?php } ?>
                <li><a href="historique.php" title="">Historique</a></li>
                <li><a href="bilan.php" title="">Bilan</a></li>
                <li><a href="#" title="">Profile</a>
                    <ul>
                        <li><a href="parametres.php" title="">Paramétres</a></li>
                        <li><a href="deconnexion.php" title="">Deconnexion</a></li>
                    </ul>
				</li>
			</ul>
		</div>
        <?php } ?>
	</div>
</div>
<div class="wrapper">
	<div id="welcome" class="container">