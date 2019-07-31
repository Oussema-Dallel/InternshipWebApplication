<?php
session_start();
$defaultpass = false;
$containName = false;
include("connexion.php");
if(!isset ($_SESSION['id']))
    header('Location: index.php');
include("connexion.php");

        $sql= "SELECT * FROM `users` WHERE id=".$_SESSION['id'];
        $res = $conn->query($sql);
        $row = $res->fetch_assoc();
        if(isset($row["name"]) && $row["name"]!="")  {
               $containName = true;
        }

    if(isset($_POST['password']))
    {
        
        $nom=$_POST['lastname'];
        $prenom=$_POST['name'];
        $password=$_POST['password'];
       if(md5($row["defaultpassword"])== md5( $password)) {
                
              $defaultpass = true;
            }
       if($defaultpass==false)
        {
        if($containName==false) {
        $sql = "UPDATE `leoni`.`users` SET `name` ='".$_POST['name']."', `lastname` ='".$_POST['lastname']."' , `password` = MD5('".$_POST['password']."') WHERE `users`.`id`=".$_SESSION['id'];
            } else {
             $sql = "UPDATE `leoni`.`users` SET `password` = MD5('".$_POST['password']."') WHERE `users`.`id`=".$_SESSION['id'];
        }
        $result = $conn->query($sql);
        header('Location: deconnexion.php'); 
       
        }
    }
          
?>
<?php include("header.php"); ?>
<div class="title">
	  <h2>Veuillez configurer votre profile</h2>
		</div>
        <form id="form1" method="post" action="">
        <?php if($containName==false)  { ?>
            
            <input name="lastname" type="text" placeholder="Nom" size="20" class="x" required/><br />
            <input name="name" type="text" placeholder="prenom" size="60" required/><br />
        <?php } ?>
        <input name="password" type="text" placeholder="Nouveau mot de passe" size="60" required/><br /> 
            <?php 
            if($defaultpass) {
                
        ?>
            
            <div class="warning" id="warning">
            <p>Veuillez reessayer </p>
            </div>
        <?php
                }
        ?>
		<input name="Confirmer" type="submit" value="Confirmer" class="connexion" />
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
