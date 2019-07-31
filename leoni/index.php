<?php
$wrong=false;
session_start();
if(isset($_SESSION['id']))
    header('Location: workspace.php');
include("connexion.php");
if(isset($_POST['id'])) {
    $id=$_POST['id'];
    $password=$_POST['password'];
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if($row["id"]==$id && md5($password)== $row["password"]) {	
               session_destroy();
               session_start();
               $_SESSION['id'] = $id;
               $_SESSION['role'] = $row["role"];
               $_SESSION['name'] = $row["name"];
               $_SESSION['lastname'] = $row["lastname"];
               $_SESSION['PS'] = $row["PS"];
               header('Location: workspace.php');
            }
        }
        $wrong = true;
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Leoni | Interface de Gestion de maintenance</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900|Quicksand:400,700|Questrial" rel="stylesheet" />
<link href="css/default.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/fonts.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/functions.js"></script>

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
        	<img src="images/leoni_logo.png" />
		</div>
	</div>
</div>
<div class="wrapper">
	<div id="welcome" class="container">
    	
<div class="title">
	  <h2>Bienvenue à l'Application de Gestion de maintenance</h2>
		</div>
		<form id="form1" method="post" action="">
		<input name="id" type="text" placeholder="Matricule" size="20" class="x"/ required><br />
		<input name="password" type="password" placeholder="Mot de passe" size="60" required/><br />
        <?php 
            if($wrong) {
        ?>
            <div class="warning">
            <p>Le matricule ou le mot de passe saisi est incorrect. </p>
            </div>
        <?php
                }
        ?>
		<input name="Connexion" type="submit" value="Connexion" class="connexion" />
		</form>
         
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
