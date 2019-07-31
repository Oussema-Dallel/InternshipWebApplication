<?php
session_start();
if(!isset ($_SESSION['id']))
    header('Location: index.php');
include("connexion.php");
include("header.php"); 
?>
        <div class="title" id="formx">
	       <h2>Statistiques et graphes sur BT</h2>
		</div>
        <form class="compterendu bilan" method="post" onsubmit="getbilan(); return false;">
        <table border="0">
            <tr>
                <td>
                     <input name="tabledecontrole" type="text" placeholder="Table de controle Electrique" class="x" value="" required />
                </td>
                <td>
                    <input name="datedebut" type="text" placeholder="Date Debut" class="x dpicker" value="" required />
                </td>
                <td>
                     <input name="datefin" type="text" placeholder="Date Fin" size="20" class="x dpicker" value="" required />
                </td>
                 <td>
                    <input type="submit" class="connexion" value="Générer Rapport" />
                </td>
                </tr>
            <tr>
               
            </tr>
        </table>  
        </form>
     <input class="connexion bilanaddnew" onclick="addfields(); location.href='#formx'" value="Comparer avec" style="display:none;"/>
    <div id="onebilandata">
    <div id="bilandata">
        
    </div>
    <div id="container1"></div>
    </div>

    <div id="twobilandata">
    <div id="bilandata2">
        
    </div>
     <div id="container2" ></div>
    </div>

	</div>

    
	
	
</div>

<div id="copyright">
	<p> Leoni &copy; - <?php echo(date('Y')); ?></p>
</div>
    <script>
        var i=1;
        startTime();
        $(".dpicker").datepicker({
            inline: true,dateFormat: 'yy-mm-dd'
        });
        function getbilan() {
            $(function () {
                id=$("input[name='tabledecontrole']").val();
                datedebut=$("input[name='datedebut']").val();
                datefin=$("input[name='datefin']").val();
                url="bilandata.php?id="+id+"&datedebut="+datedebut+"&datefin="+datefin;
                if(i==1) {
                $(".bilanaddnew").show();
                
                $.get(url+"&chart=1", function (data) {
                   
                    $("#bilandata").html(data);
                       
                });
                      }else {
                            $.get(url+"&chart=2", function (data) {
                   
                   $("#bilandata2").html(data);
                       
                });
                            
                        }
            });
        }
        function addfields() {
            i=2;
            $(".bilanaddnew").hide();
            $("input[name='tabledecontrole']").val("");
            $("input[name='datedebut']").val("");
            $("input[name='datefin']").val("");
           
        }
        
        
        
        
        
        
    </script>

</body>
</html>
