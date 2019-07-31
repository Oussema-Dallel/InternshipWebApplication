<?php
$defaultpass = false;
session_start();
if(!isset ($_SESSION['id']))
    header('Location: index.php');
include("connexion.php");
include("header.php"); ?>
    	<div class="vspace"></div>
<div class="title">
	  <h2>Bienvenue <?php if(isset($_SESSION['name'])) echo($_SESSION['name']." "); ?>à votre espace de gestion.</h2>
		</div>
        
        <?php 
            if($defaultpassxx) {
        ?>
            <div class="warning">
            <p>Veuillez configurer votre profile <a href="parametres.php" title="">ici</a>.</p>
            </div>
        <?php
                }
        ?>
		<div class="vspace"></div>
         
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
