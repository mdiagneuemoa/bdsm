<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>FICHE D'INSCRIPTION DES TIERS DES ORGANES DE L'UEMOA</title>
        
        <link href="styles/site.css" rel="stylesheet" type="text/css" />
        <link href="styles/nav.css" rel="stylesheet" type="text/css" />
        <link href="styles/header.css" rel="stylesheet" type="text/css" />
        <link href="styles/footer.css" rel="stylesheet" type="text/css" />
        
        <link href="styles/pages/carrieres.css" rel="stylesheet" type="text/css" />
        <link href="styles/modal.css" rel="stylesheet" type="text/css" />

        <link href="styles/mobile.css" rel="stylesheet" type="text/css" />
        <link href="styles/print.css" media="print" rel="stylesheet" type="text/css" />
    </head>
    <script type='text/javascript'>
   function recupLogin ()
    {
        if(window.XMLHttpRequest)
            xhr = new XMLHttpRequest ();
        else if (window.ActiveXObject("Microsoft.XMLHTTP"))
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        else
        {  
            alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
            return;
        }
        alert(xhr.UserName);
    }
</script>
    <body>

       <div id="divContainer">
 
					<div id="form-addcontact" >
						<form id="candidatform" action="tiersuemoa.php" method="post">
						<script type='text/javascript'>
						  var obj = new ActiveXObject('WScript.Network');
						  document.write('<input type="hidden" name="windows_logon_user" value='+obj.UserName+'>');
						</script>
						  <fieldset>
							<legend>IDENTIFICATION DES TIERS</legend>
									* Bien vouloir remplir la fiche sans abréviation

						</fieldset>	   
						  <div>
							<a href="#" onclick="recupLogin()">test</a><button type=submit id="savecategorie">Enregistrer</button>&nbsp;&nbsp;

						  </div>
						  </div>
						  
						   
						</form>
							
						</div>
					</td>
				</tr>
			</table>	
			</div>
					</div>
				</form>
        <footer class="page-footer">
            <div class="container">
                <p>
                    &#169; 	2016 DSI / Commission UEMOA
                </p>
            </div>
        </footer>
  		<script src="scripts/jquery.min.js" type="text/javascript"></script>
        <script src="scripts/pages/carrieres.js" type="text/javascript"></script>

    </body>
</html>
