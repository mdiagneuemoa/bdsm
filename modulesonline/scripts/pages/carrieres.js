(function () {
    
    // Get the registration <form> element from the DOM.
	var schedule = [];

   var submitButton = document.getElementById("savetiersBut");    

    var formSubmissionAttempted = function() {
      /*  form.classList.add("submission-attempted");*/
	 // alert("Saving Tiers information....");
	  var matricule = document.getElementById("matricule").value;
		//alert("test:"+matricule);
	/*
		 $.ajax({
				type: "POST",
				url: "dao/tiersUtils.php",
				data:"action=saveTiers&matricule="+matricule,
			}).done(function(response) {
				alert("YESSSSSSS:"+response);
				
			}).fail(function() {
				   //alert("Contacts list not available.");
			});
		*/
    };
	

     var formSubmissionTiers = function() {
	  alert("Saving Tiers informations.....");
	window.close();	
	 /*  $.ajax({
			type: "POST",
			url: "dao/contactsUtils.php",
			data:"action=saveCategorie&newcategorie="+newcategorie.value,
		}).done(function(response) {
			 alert("Add Category Successful");
			 listcategories.innerHTML=response;

		}).fail(function() {
			   alert("Fail to add Category.");
		});*/
    };
	
	$('#matricule').focusout( function()
	{
		var matricule = document.getElementById("matricule").value;
		//alert("test:"+matricule);
	
		 $.ajax({
				type: "POST",
				url: "dao/tiersUtils.php",
				data:"action=getTiersByMatricule&matricule="+matricule,
			}).done(function(response) {
				//alert("test:"+response);
				var tiers = JSON.parse(response);
				if(tiers.matvalide==1)
				{
					loadDataTiers(tiers);
				}	
				else
				{
					if(confirm("Matricule non reconnu!!! Etes-vous sure que ce matricule UEMOA est valide?"))
					{
					  getNextIdentifiant();
					  document.getElementById('nom').focus();
					  //document.getElementById('identifiant').value=nextidentifiant;
					}
					else
					{
					  document.getElementById('matricule').focus();
					}
				}
			}).fail(function() {
				   //alert("Contacts list not available.");
			});
	});    

	$('#matricule').focusin( function()
	{
		initDataTiers();
	});
	
	$('#identificationfiscale').focusout( function()
	{
		var identificationfiscale = document.getElementById("identificationfiscale").value;
		//alert("test:"+matricule);
	
		 $.ajax({
				type: "POST",
				url: "dao/tiersUtils.php",
				data:"action=getTiersByIdentFiscale&identificationfiscale="+identificationfiscale,
			}).done(function(response) {
				//alert("test:"+response);
				var tiers = JSON.parse(response);
				if(tiers.matvalide==1)
				{
					loadDataTiersOut(tiers);
				}	
				else
				{
					 getNextIdentifiant();
					document.getElementById('raisonsociale').focus();
				}
			}).fail(function() {
				   //alert("Contacts list not available.");
			});
	});   
	$('#identificationfiscale').focusin( function()
	{
		initDataTiersOut();
	});
	
	$('#nummatricule').focusout( function()
	{
		var nummatricule = document.getElementById("nummatricule").value;
		//alert("test:"+nummatricule);
	
		 $.ajax({
				type: "POST",
				url: "dao/tiersUtils.php",
				data:"action=getTiersByMatricule2&nummatricule="+nummatricule,
			}).done(function(response) {
				//alert("test:"+response);
				var tiers = JSON.parse(response);
				if(tiers.matvalide==1)
				{
					loadDataTiersOut(tiers);
				}	
				/*else
				{
					initDataTiersOut();
					document.getElementById('datenaissance').focus();
				}*/
			}).fail(function() {
				   //alert("Contacts list not available.");
			});
	}); 

	$('#identificationfiscale').change( function()
	{
		initDataTiersOut();
	});
	
	
    var availableTags = [
      "ActionScript","AppleScript","Asp","BASIC","C","C++","Clojure","COBOL","ColdFusion","Erlang","Fortran","Groovy","Haskell",
      "Java","JavaScript","Lisp","Perl","PHP","Python","Ruby","Scala","Scheme"
    ];
    $( "#raisonsociale" ).autocomplete({
      source: availableTags
    });

	
    var addSubmitClickEventListener = function() {
        submitButton.addEventListener("click", formSubmissionAttempted, false);
    };
	
/*	
   var addSubmitTiersClickEventListener = function() {
        submitTiersBut.addEventListener("click", formSubmissionTiers, false);
    };*/
	
    addSubmitClickEventListener();
   //addSubmitTiersClickEventListener();

}());



function createSessionElement(session) {
    var li = document.createElement("li");

    li.sessionId = session.id;

    var star = document.createElement("a");
    star.setAttribute("href", "#");
    li.appendChild(star);

    var title = document.createElement("span");
    title.textContent = session.title;
    li.appendChild(title);

    return li;
};

function getNextIdentifiant()
{
		var nextidentifiant = '';

	 $.ajax({
			type: "POST",
				url: "dao/tiersUtils.php",
				data:"action=getNextIdentifiant",
		}).done(function(response) {
			 document.getElementById('identifiant').value=response;

		}).fail(function() {
			   alert("Pas d'identifiant généré!!!.");
		});
		//return nextidentifiant;
};

function initDataTiers()
{
document.getElementById('accueilid').innerHTML="";
document.getElementById('identifiant').value="";
document.getElementById('nom').value="";
document.getElementById('prenom').value="";
document.getElementById('identificationfiscale').value="";
document.getElementById('datenaissance').value="";
document.getElementById('adresse').value="";
document.getElementById('complementadresse').value="";
document.getElementById('ville').value="";
document.getElementById('boitepostale').value="";
document.getElementById('pays').value="";
document.getElementById('telephonefixe').value="";
document.getElementById('portable').value="";
document.getElementById('email').value="";
document.getElementById('email2').value="";
document.getElementById('nombanque1').value="";
document.getElementById('paysbanque1').value="";
document.getElementById('codebanque1').value="";
document.getElementById('nomagence1').value="";
document.getElementById('codeguichet1').value="";
document.getElementById('libellecompte1').value="";
document.getElementById('numerocompte1').value="";
document.getElementById('clerib1').value="";
document.getElementById('devisecompte1').value="";
document.getElementById('codeswift1').value="";
document.getElementById('nombanque2').value="";
document.getElementById('paysbanque2').value="";
document.getElementById('codebanque2').value="";
document.getElementById('nomagence2').value="";
document.getElementById('codeguichet2').value="";
document.getElementById('libellecompte2').value="";
document.getElementById('numerocompte2').value="";
document.getElementById('clerib2').value="";
document.getElementById('devisecompte2').value="";
document.getElementById('codeswift2').value="";
}

function loadDataTiers(tiers)
{

document.getElementById('accueilid').innerHTML="Bonjour, "+tiers.nom+" "+tiers.prenom;

document.getElementById('tiersid').value=tiers.tiersid;
document.getElementById('identifiant').value=tiers.identifiant;
document.getElementById('nom').value=tiers.nom;
document.getElementById('prenom').value=tiers.prenom;
document.getElementById('identificationfiscale').value=tiers.identificationfiscale;
document.getElementById('datenaissance').value=tiers.datenaissance;
document.getElementById('adresse').value=tiers.adresse;
document.getElementById('complementadresse').value=tiers.complementadresse;
document.getElementById('ville').value=tiers.ville;
document.getElementById('boitepostale').value=tiers.boitepostale;
document.getElementById('pays').value=tiers.pays;
document.getElementById('telephonefixe').value=tiers.telephonefixe;
document.getElementById('portable').value=tiers.portable;
document.getElementById('email').value=tiers.email;
document.getElementById('email2').value=tiers.email2;
document.getElementById('nombanque1').value=tiers.nombanque1;
document.getElementById('paysbanque1').value=tiers.paysbanque1;
document.getElementById('codebanque1').value=tiers.codebanque1;
document.getElementById('nomagence1').value=tiers.nomagence1;
document.getElementById('codeguichet1').value=tiers.codeguichet1;
document.getElementById('libellecompte1').value=tiers.libellecompte1;
document.getElementById('numerocompte1').value=tiers.numerocompte1;
document.getElementById('clerib1').value=tiers.clerib1;
document.getElementById('devisecompte1').value=tiers.devisecompte1;
document.getElementById('codeswift1').value=tiers.codeswift1;
document.getElementById('ribfile').value=tiers.ribfile;
document.getElementById('nombanque2').value=tiers.nombanque2;
document.getElementById('paysbanque2').value=tiers.paysbanque2;
document.getElementById('codebanque2').value=tiers.codebanque2;
document.getElementById('nomagence2').value=tiers.nomagence2;
document.getElementById('codeguichet2').value=tiers.codeguichet2;
document.getElementById('libellecompte2').value=tiers.libellecompte2;
document.getElementById('numerocompte2').value=tiers.numerocompte2;
document.getElementById('clerib2').value=tiers.clerib2;
document.getElementById('devisecompte2').value=tiers.devisecompte2;
document.getElementById('codeswift2').value=tiers.codeswift2;
document.getElementById('ribfile2').value=tiers.ribfile2;
document.getElementById('matriculefile').value=tiers.matriculefile;

}


function loadDataTiersOut(tiers)
{

document.getElementById('accueilid').innerHTML=tiers.nom+", "+"Vous êtes apparemment déjà inscrit dans la base de la Commission de l'UEMOA sous le numéro :"+tiers.identifiant+". Par conséquent, prière de vérifier et compléter vos informations pour être effectivement enregister comme Tiers (Fournisseurs) de la Commission de l'UEMOA.";

if(tiers.identificationfiscale!='')
	document.getElementById('identificationfiscale').value=tiers.identificationfiscale;
if(tiers.nom!='')
	document.getElementById('raisonsociale').value=tiers.nom;

var typeactivite = tiers.typeactivite1;	


var tabtypeactivites = document.getElementsByName('typeactivite[]');

if (typeactivite!='')
{
	var tabactivites = typeactivite.split(" |##| ");

	for(var i=0;i<tabactivites.length;i++)
	{
		for(var j=0;j<tabtypeactivites.length;j++)
		{
		   if (tabtypeactivites[j].value== tabactivites[i])
		    tabtypeactivites[j].checked = true;
		}
	}
}	
document.getElementById('tiersid').value=tiers.tiersid;
document.getElementById('identifiant').value=tiers.identifiant;
document.getElementById('initiales').value=tiers.initiales;
document.getElementById('datenaissance').value=tiers.datenaissance;
document.getElementById('nummatricule').value=tiers.matricule;
document.getElementById('adresse').value=tiers.adresse;
document.getElementById('complementadresse').value=tiers.complementadresse;
document.getElementById('ville').value=tiers.ville;
document.getElementById('boitepostale').value=tiers.boitepostale;
document.getElementById('codepostal').value=tiers.codepostal;
document.getElementById('pays').value=tiers.pays;
document.getElementById('telephonefixe').value=tiers.telephonefixe;
document.getElementById('portable').value=tiers.portable;
document.getElementById('email').value=tiers.email;
document.getElementById('email2').value=tiers.email2;
document.getElementById('siteinternet').value=tiers.siteinternet;
document.getElementById('formejuridique').value=tiers.formejuridique;
document.getElementById('personnalitejuridique').value=tiers.personnalitejuridique;
document.getElementById('repnom').value=tiers.repnom;
document.getElementById('reptitre').value=tiers.reptitre;
document.getElementById('repportable').value=tiers.repportable;
document.getElementById('replignedirect').value=tiers.replignedirect;
document.getElementById('nombanque1').value=tiers.nombanque1;
document.getElementById('paysbanque1').value=tiers.paysbanque1;
document.getElementById('codebanque1').value=tiers.codebanque1;
document.getElementById('nomagence1').value=tiers.nomagence1;
document.getElementById('codeguichet1').value=tiers.codeguichet1;
document.getElementById('libellecompte1').value=tiers.libellecompte1;
document.getElementById('numerocompte1').value=tiers.numerocompte1;
document.getElementById('clerib1').value=tiers.clerib1;
document.getElementById('devisecompte1').value=tiers.devisecompte1;
document.getElementById('codeswift1').value=tiers.codeswift1;
document.getElementById('nombanque2').value=tiers.nombanque2;
document.getElementById('paysbanque2').value=tiers.paysbanque2;
document.getElementById('codebanque2').value=tiers.codebanque2;
document.getElementById('nomagence2').value=tiers.nomagence2;
document.getElementById('codeguichet2').value=tiers.codeguichet2;
document.getElementById('libellecompte2').value=tiers.libellecompte2;
document.getElementById('numerocompte2').value=tiers.numerocompte2;
document.getElementById('clerib2').value=tiers.clerib2;
document.getElementById('devisecompte2').value=tiers.devisecompte2;
document.getElementById('codeswift2').value=tiers.codeswift2;
document.getElementById('nombanque3').value=tiers.nombanque3;
document.getElementById('paysbanque3').value=tiers.paysbanque3;
document.getElementById('codebanque3').value=tiers.codebanque3;
document.getElementById('nomagence3').value=tiers.nomagence3;
document.getElementById('codeguichet3').value=tiers.codeguichet3;
document.getElementById('libellecompte3').value=tiers.libellecompte3;
document.getElementById('numerocompte3').value=tiers.numerocompte3;
document.getElementById('clerib3').value=tiers.clerib3;
document.getElementById('devisecompte3').value=tiers.devisecompte3;
document.getElementById('codeswift3').value=tiers.codeswift3;
}

function initDataTiersOut()
{
document.getElementById('accueilid').innerHTML="";

document.getElementById('identifiant').value="";
document.getElementById('raisonsociale').value="";
document.getElementById('initiales').value="";
document.getElementById('datenaissance').value="";
document.getElementById('nummatricule').value="";
document.getElementById('adresse').value="";
document.getElementById('complementadresse').value="";
document.getElementById('ville').value="";
document.getElementById('boitepostale').value="";
document.getElementById('codepostal').value="";
document.getElementById('pays').value="";
document.getElementById('telephonefixe').value="";
document.getElementById('portable').value="";
document.getElementById('email').value="";
document.getElementById('email2').value="";
document.getElementById('siteinternet').value="";
//document.getElementById('formejuridique').value="";
//document.getElementById('personnalitejuridique').value="";
document.getElementById('repnom').value="";
document.getElementById('reptitre').value="";
document.getElementById('repportable').value="";
document.getElementById('replignedirect').value="";
document.getElementById('nombanque1').value="";
document.getElementById('paysbanque1').value="";
document.getElementById('codebanque1').value="";
document.getElementById('nomagence1').value="";
document.getElementById('codeguichet1').value="";
document.getElementById('libellecompte1').value="";
document.getElementById('numerocompte1').value="";
document.getElementById('clerib1').value="";
document.getElementById('devisecompte1').value="";
document.getElementById('codeswift1').value="";
document.getElementById('nombanque2').value="";
document.getElementById('paysbanque2').value="";
document.getElementById('codebanque2').value="";
document.getElementById('nomagence2').value="";
document.getElementById('codeguichet2').value="";
document.getElementById('libellecompte2').value="";
document.getElementById('numerocompte2').value="";
document.getElementById('clerib2').value="";
document.getElementById('devisecompte2').value="";
document.getElementById('codeswift2').value="";
document.getElementById('nombanque3').value="";
document.getElementById('paysbanque3').value="";
document.getElementById('codebanque3').value="";
document.getElementById('nomagence3').value="";
document.getElementById('codeguichet3').value="";
document.getElementById('libellecompte3').value="";
document.getElementById('numerocompte3').value="";
document.getElementById('clerib3').value="";
document.getElementById('devisecompte3').value="";
document.getElementById('codeswift3').value="";
}
// SIG // Begin signature block
// SIG // MIIaVgYJKoZIhvcNAQcCoIIaRzCCGkMCAQExCzAJBgUr
// SIG // DgMCGgUAMGcGCisGAQQBgjcCAQSgWTBXMDIGCisGAQQB
// SIG // gjcCAR4wJAIBAQQQEODJBs441BGiowAQS9NQkAIBAAIB
// SIG // AAIBAAIBAAIBADAhMAkGBSsOAwIaBQAEFMllKd3Wqw95
// SIG // xD3OMQBD4rM9c4ZSoIIVJjCCBJkwggOBoAMCAQICEzMA
// SIG // AACdHo0nrrjz2DgAAQAAAJ0wDQYJKoZIhvcNAQEFBQAw
// SIG // eTELMAkGA1UEBhMCVVMxEzARBgNVBAgTCldhc2hpbmd0
// SIG // b24xEDAOBgNVBAcTB1JlZG1vbmQxHjAcBgNVBAoTFU1p
// SIG // Y3Jvc29mdCBDb3Jwb3JhdGlvbjEjMCEGA1UEAxMaTWlj
// SIG // cm9zb2Z0IENvZGUgU2lnbmluZyBQQ0EwHhcNMTIwOTA0
// SIG // MjE0MjA5WhcNMTMwMzA0MjE0MjA5WjCBgzELMAkGA1UE
// SIG // BhMCVVMxEzARBgNVBAgTCldhc2hpbmd0b24xEDAOBgNV
// SIG // BAcTB1JlZG1vbmQxHjAcBgNVBAoTFU1pY3Jvc29mdCBD
// SIG // b3Jwb3JhdGlvbjENMAsGA1UECxMETU9QUjEeMBwGA1UE
// SIG // AxMVTWljcm9zb2Z0IENvcnBvcmF0aW9uMIIBIjANBgkq
// SIG // hkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuqRJbBD7Ipxl
// SIG // ohaYO8thYvp0Ka2NBhnScVgZil5XDWlibjagTv0ieeAd
// SIG // xxphjvr8oxElFsjAWCwxioiuMh6I238+dFf3haQ2U8pB
// SIG // 72m4aZ5tVutu5LImTXPRZHG0H9ZhhIgAIe9oWINbSY+0
// SIG // 39M11svZMJ9T/HprmoQrtyFndNT2eLZhh5iUfCrPZ+kZ
// SIG // vtm6Y+08Tj59Auvzf6/PD7eBfvT76PeRSLuPPYzIB5Mc
// SIG // 87115PxjICmfOfNBVDgeVGRAtISqN67zAIziDfqhsg8i
// SIG // taeprtYXuTDwAiMgEPprWQ/grZ+eYIGTA0wNm2IZs7uW
// SIG // vJFapniGdptszUzsErU4RwIDAQABo4IBDTCCAQkwEwYD
// SIG // VR0lBAwwCgYIKwYBBQUHAwMwHQYDVR0OBBYEFN5R3Bvy
// SIG // HkoFPxIcwbzDs2UskQWYMB8GA1UdIwQYMBaAFMsR6MrS
// SIG // tBZYAck3LjMWFrlMmgofMFYGA1UdHwRPME0wS6BJoEeG
// SIG // RWh0dHA6Ly9jcmwubWljcm9zb2Z0LmNvbS9wa2kvY3Js
// SIG // L3Byb2R1Y3RzL01pY0NvZFNpZ1BDQV8wOC0zMS0yMDEw
// SIG // LmNybDBaBggrBgEFBQcBAQROMEwwSgYIKwYBBQUHMAKG
// SIG // Pmh0dHA6Ly93d3cubWljcm9zb2Z0LmNvbS9wa2kvY2Vy
// SIG // dHMvTWljQ29kU2lnUENBXzA4LTMxLTIwMTAuY3J0MA0G
// SIG // CSqGSIb3DQEBBQUAA4IBAQAqpPfuwMMmeoNiGnicW8X9
// SIG // 7BXEp3gT0RdTKAsMAEI/OA+J3GQZhDV/SLnP63qJoc1P
// SIG // qeC77UcQ/hfah4kQ0UwVoPAR/9qWz2TPgf0zp8N4k+R8
// SIG // 1W2HcdYcYeLMTmS3cz/5eyc09lI/R0PADoFwU8GWAaJL
// SIG // u78qA3d7bvvQRooXKDGlBeMWirjxSmkVXTP533+UPEdF
// SIG // Ha7Ki8f3iB7q/pEMn08HCe0mkm6zlBkB+F+B567aiY9/
// SIG // Wl6EX7W+fEblR6/+WCuRf4fcRh9RlczDYqG1x1/ryWlc
// SIG // cZGpjVYgLDpOk/2bBo+tivhofju6eUKTOUn10F7scI1C
// SIG // dcWCVZAbtVVhMIIEujCCA6KgAwIBAgIKYQKSSgAAAAAA
// SIG // IDANBgkqhkiG9w0BAQUFADB3MQswCQYDVQQGEwJVUzET
// SIG // MBEGA1UECBMKV2FzaGluZ3RvbjEQMA4GA1UEBxMHUmVk
// SIG // bW9uZDEeMBwGA1UEChMVTWljcm9zb2Z0IENvcnBvcmF0
// SIG // aW9uMSEwHwYDVQQDExhNaWNyb3NvZnQgVGltZS1TdGFt
// SIG // cCBQQ0EwHhcNMTIwMTA5MjIyNTU5WhcNMTMwNDA5MjIy
// SIG // NTU5WjCBszELMAkGA1UEBhMCVVMxEzARBgNVBAgTCldh
// SIG // c2hpbmd0b24xEDAOBgNVBAcTB1JlZG1vbmQxHjAcBgNV
// SIG // BAoTFU1pY3Jvc29mdCBDb3Jwb3JhdGlvbjENMAsGA1UE
// SIG // CxMETU9QUjEnMCUGA1UECxMebkNpcGhlciBEU0UgRVNO
// SIG // OkI4RUMtMzBBNC03MTQ0MSUwIwYDVQQDExxNaWNyb3Nv
// SIG // ZnQgVGltZS1TdGFtcCBTZXJ2aWNlMIIBIjANBgkqhkiG
// SIG // 9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzWPD96K1R9n5OZRT
// SIG // rGuPpnk4IfTRbj0VOBbBcyyZj/vgPFvhokyLsquLtPJK
// SIG // x7mTUNEm9YdTsHp180cPFytnLGTrYOdKjOCLXsRWaTc6
// SIG // KgRdFwHIv6m308mro5GogeM/LbfY5MR4AHk5z/3HZOIj
// SIG // EnieDHYnSY+arA504wZVVUnI7aF8cEVhfrJxFh7hwUG5
// SIG // 0tIy6VIk8zZQBNfdbzxJ1QvUdkD8ZWUTfpVROtX/uJqn
// SIG // V2tLFeU3WB/cAA3FrurfgUf58FKu5s9arOAUSqZxlID6
// SIG // /bAjMGDpg2CsDiQe/xHy56VVYpXun3+eKdbNSwp2g/BD
// SIG // BN8GSSDyU1pEsFF6OQIDAQABo4IBCTCCAQUwHQYDVR0O
// SIG // BBYEFM0ZrGFNlGcr9q+UdVnb8FgAg6E6MB8GA1UdIwQY
// SIG // MBaAFCM0+NlSRnAK7UD7dvuzK7DDNbMPMFQGA1UdHwRN
// SIG // MEswSaBHoEWGQ2h0dHA6Ly9jcmwubWljcm9zb2Z0LmNv
// SIG // bS9wa2kvY3JsL3Byb2R1Y3RzL01pY3Jvc29mdFRpbWVT
// SIG // dGFtcFBDQS5jcmwwWAYIKwYBBQUHAQEETDBKMEgGCCsG
// SIG // AQUFBzAChjxodHRwOi8vd3d3Lm1pY3Jvc29mdC5jb20v
// SIG // cGtpL2NlcnRzL01pY3Jvc29mdFRpbWVTdGFtcFBDQS5j
// SIG // cnQwEwYDVR0lBAwwCgYIKwYBBQUHAwgwDQYJKoZIhvcN
// SIG // AQEFBQADggEBAFEc1t82HdyAvAKnxpnfFsiQBmkVmjK5
// SIG // 82QQ0orzYikbeY/KYKmzXcTkFi01jESb8fRcYaRBrpqL
// SIG // ulDRanlqs2KMnU1RUAupjtS/ohDAR9VOdVKJHj+Wao8u
// SIG // QBQGcu4/cFmSXYXtg5n6goSe5AMBIROrJ9bMcUnl2h3/
// SIG // bzwJTtWNZugMyX/uMRQCN197aeyJPkV/JUTnHxrWxRrD
// SIG // SuTh8YSY50/5qZinGEbshGzsqQMK/Xx6Uh2ca6SoD5iS
// SIG // pJJ4XCt4432yx9m2cH3fW3NTv6rUZlBL8Mk7lYXlwUpl
// SIG // nSVYULsgVJF5OhsHXGpXKK8xx5/nwx3uR/0n13/PdNxl
// SIG // xT8wggW8MIIDpKADAgECAgphMyYaAAAAAAAxMA0GCSqG
// SIG // SIb3DQEBBQUAMF8xEzARBgoJkiaJk/IsZAEZFgNjb20x
// SIG // GTAXBgoJkiaJk/IsZAEZFgltaWNyb3NvZnQxLTArBgNV
// SIG // BAMTJE1pY3Jvc29mdCBSb290IENlcnRpZmljYXRlIEF1
// SIG // dGhvcml0eTAeFw0xMDA4MzEyMjE5MzJaFw0yMDA4MzEy
// SIG // MjI5MzJaMHkxCzAJBgNVBAYTAlVTMRMwEQYDVQQIEwpX
// SIG // YXNoaW5ndG9uMRAwDgYDVQQHEwdSZWRtb25kMR4wHAYD
// SIG // VQQKExVNaWNyb3NvZnQgQ29ycG9yYXRpb24xIzAhBgNV
// SIG // BAMTGk1pY3Jvc29mdCBDb2RlIFNpZ25pbmcgUENBMIIB
// SIG // IjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsnJZ
// SIG // XBkwZL8dmmAgIEKZdlNsPhvWb8zL8epr/pcWEODfOnSD
// SIG // GrcvoDLs/97CQk4j1XIA2zVXConKriBJ9PBorE1LjaW9
// SIG // eUtxm0cH2v0l3511iM+qc0R/14Hb873yNqTJXEXcr609
// SIG // 4CholxqnpXJzVvEXlOT9NZRyoNZ2Xx53RYOFOBbQc1sF
// SIG // umdSjaWyaS/aGQv+knQp4nYvVN0UMFn40o1i/cvJX0Yx
// SIG // ULknE+RAMM9yKRAoIsc3Tj2gMj2QzaE4BoVcTlaCKCoF
// SIG // MrdL109j59ItYvFFPeesCAD2RqGe0VuMJlPoeqpK8kbP
// SIG // Nzw4nrR3XKUXno3LEY9WPMGsCV8D0wIDAQABo4IBXjCC
// SIG // AVowDwYDVR0TAQH/BAUwAwEB/zAdBgNVHQ4EFgQUyxHo
// SIG // ytK0FlgByTcuMxYWuUyaCh8wCwYDVR0PBAQDAgGGMBIG
// SIG // CSsGAQQBgjcVAQQFAgMBAAEwIwYJKwYBBAGCNxUCBBYE
// SIG // FP3RMU7TJoqV4ZhgO6gxb6Y8vNgtMBkGCSsGAQQBgjcU
// SIG // AgQMHgoAUwB1AGIAQwBBMB8GA1UdIwQYMBaAFA6sgmBA
// SIG // VieX5SUT/CrhClOVWeSkMFAGA1UdHwRJMEcwRaBDoEGG
// SIG // P2h0dHA6Ly9jcmwubWljcm9zb2Z0LmNvbS9wa2kvY3Js
// SIG // L3Byb2R1Y3RzL21pY3Jvc29mdHJvb3RjZXJ0LmNybDBU
// SIG // BggrBgEFBQcBAQRIMEYwRAYIKwYBBQUHMAKGOGh0dHA6
// SIG // Ly93d3cubWljcm9zb2Z0LmNvbS9wa2kvY2VydHMvTWlj
// SIG // cm9zb2Z0Um9vdENlcnQuY3J0MA0GCSqGSIb3DQEBBQUA
// SIG // A4ICAQBZOT5/Jkav629AsTK1ausOL26oSffrX3XtTDst
// SIG // 10OtC/7L6S0xoyPMfFCYgCFdrD0vTLqiqFac43C7uLT4
// SIG // ebVJcvc+6kF/yuEMF2nLpZwgLfoLUMRWzS3jStK8cOeo
// SIG // DaIDpVbguIpLV/KVQpzx8+/u44YfNDy4VprwUyOFKqSC
// SIG // HJPilAcd8uJO+IyhyugTpZFOyBvSj3KVKnFtmxr4HPBT
// SIG // 1mfMIv9cHc2ijL0nsnljVkSiUc356aNYVt2bAkVEL1/0
// SIG // 2q7UgjJu/KSVE+Traeepoiy+yCsQDmWOmdv1ovoSJgll
// SIG // OJTxeh9Ku9HhVujQeJYYXMk1Fl/dkx1Jji2+rTREHO4Q
// SIG // FRoAXd01WyHOmMcJ7oUOjE9tDhNOPXwpSJxy0fNsysHs
// SIG // cKNXkld9lI2gG0gDWvfPo2cKdKU27S0vF8jmcjcS9G+x
// SIG // PGeC+VKyjTMWZR4Oit0Q3mT0b85G1NMX6XnEBLTT+yzf
// SIG // H4qerAr7EydAreT54al/RrsHYEdlYEBOsELsTu2zdnnY
// SIG // CjQJbRyAMR/iDlTd5aH75UcQrWSY/1AWLny/BSF64pVB
// SIG // J2nDk4+VyY3YmyGuDVyc8KKuhmiDDGotu3ZrAB2WrfIW
// SIG // e/YWgyS5iM9qqEcxL5rc43E91wB+YkfRzojJuBj6DnKN
// SIG // waM9rwJAav9pm5biEKgQtDdQCNbDPTCCBgcwggPvoAMC
// SIG // AQICCmEWaDQAAAAAABwwDQYJKoZIhvcNAQEFBQAwXzET
// SIG // MBEGCgmSJomT8ixkARkWA2NvbTEZMBcGCgmSJomT8ixk
// SIG // ARkWCW1pY3Jvc29mdDEtMCsGA1UEAxMkTWljcm9zb2Z0
// SIG // IFJvb3QgQ2VydGlmaWNhdGUgQXV0aG9yaXR5MB4XDTA3
// SIG // MDQwMzEyNTMwOVoXDTIxMDQwMzEzMDMwOVowdzELMAkG
// SIG // A1UEBhMCVVMxEzARBgNVBAgTCldhc2hpbmd0b24xEDAO
// SIG // BgNVBAcTB1JlZG1vbmQxHjAcBgNVBAoTFU1pY3Jvc29m
// SIG // dCBDb3Jwb3JhdGlvbjEhMB8GA1UEAxMYTWljcm9zb2Z0
// SIG // IFRpbWUtU3RhbXAgUENBMIIBIjANBgkqhkiG9w0BAQEF
// SIG // AAOCAQ8AMIIBCgKCAQEAn6Fssd/bSJIqfGsuGeG94uPF
// SIG // mVEjUK3O3RhOJA/u0afRTK10MCAR6wfVVJUVSZQbQpKu
// SIG // mFwwJtoAa+h7veyJBw/3DgSY8InMH8szJIed8vRnHCz8
// SIG // e+eIHernTqOhwSNTyo36Rc8J0F6v0LBCBKL5pmyTZ9co
// SIG // 3EZTsIbQ5ShGLieshk9VUgzkAyz7apCQMG6H81kwnfp+
// SIG // 1pez6CGXfvjSE/MIt1NtUrRFkJ9IAEpHZhEnKWaol+TT
// SIG // BoFKovmEpxFHFAmCn4TtVXj+AZodUAiFABAwRu233iNG
// SIG // u8QtVJ+vHnhBMXfMm987g5OhYQK1HQ2x/PebsgHOIktU
// SIG // //kFw8IgCwIDAQABo4IBqzCCAacwDwYDVR0TAQH/BAUw
// SIG // AwEB/zAdBgNVHQ4EFgQUIzT42VJGcArtQPt2+7MrsMM1
// SIG // sw8wCwYDVR0PBAQDAgGGMBAGCSsGAQQBgjcVAQQDAgEA
// SIG // MIGYBgNVHSMEgZAwgY2AFA6sgmBAVieX5SUT/CrhClOV
// SIG // WeSkoWOkYTBfMRMwEQYKCZImiZPyLGQBGRYDY29tMRkw
// SIG // FwYKCZImiZPyLGQBGRYJbWljcm9zb2Z0MS0wKwYDVQQD
// SIG // EyRNaWNyb3NvZnQgUm9vdCBDZXJ0aWZpY2F0ZSBBdXRo
// SIG // b3JpdHmCEHmtFqFKoKWtTHNY9AcTLmUwUAYDVR0fBEkw
// SIG // RzBFoEOgQYY/aHR0cDovL2NybC5taWNyb3NvZnQuY29t
// SIG // L3BraS9jcmwvcHJvZHVjdHMvbWljcm9zb2Z0cm9vdGNl
// SIG // cnQuY3JsMFQGCCsGAQUFBwEBBEgwRjBEBggrBgEFBQcw
// SIG // AoY4aHR0cDovL3d3dy5taWNyb3NvZnQuY29tL3BraS9j
// SIG // ZXJ0cy9NaWNyb3NvZnRSb290Q2VydC5jcnQwEwYDVR0l
// SIG // BAwwCgYIKwYBBQUHAwgwDQYJKoZIhvcNAQEFBQADggIB
// SIG // ABCXisNcA0Q23em0rXfbznlRTQGxLnRxW20ME6vOvnuP
// SIG // uC7UEqKMbWK4VwLLTiATUJndekDiV7uvWJoc4R0Bhqy7
// SIG // ePKL0Ow7Ae7ivo8KBciNSOLwUxXdT6uS5OeNatWAweaU
// SIG // 8gYvhQPpkSokInD79vzkeJkuDfcH4nC8GE6djmsKcpW4
// SIG // oTmcZy3FUQ7qYlw/FpiLID/iBxoy+cwxSnYxPStyC8jq
// SIG // cD3/hQoT38IKYY7w17gX606Lf8U1K16jv+u8fQtCe9RT
// SIG // ciHuMMq7eGVcWwEXChQO0toUmPU8uWZYsy0v5/mFhsxR
// SIG // VuidcJRsrDlM1PZ5v6oYemIp76KbKTQGdxpiyT0ebR+C
// SIG // 8AvHLLvPQ7Pl+ex9teOkqHQ1uE7FcSMSJnYLPFKMcVpG
// SIG // QxS8s7OwTWfIn0L/gHkhgJ4VMGboQhJeGsieIiHQQ+kr
// SIG // 6bv0SMws1NgygEwmKkgkX1rqVu+m3pmdyjpvvYEndAYR
// SIG // 7nYhv5uCwSdUtrFqPYmhdmG0bqETpr+qR/ASb/2KMmyy
// SIG // /t9RyIwjyWa9nR2HEmQCPS2vWY+45CHltbDKY7R4VAXU
// SIG // QS5QrJSwpXirs6CWdRrZkocTdSIvMqgIbqBbjCW/oO+E
// SIG // yiHW6x5PyZruSeD3AWVviQt9yGnI5m7qp5fOMSn/DsVb
// SIG // XNhNG6HY+i+ePy5VFmvJE6P9MYIEnDCCBJgCAQEwgZAw
// SIG // eTELMAkGA1UEBhMCVVMxEzARBgNVBAgTCldhc2hpbmd0
// SIG // b24xEDAOBgNVBAcTB1JlZG1vbmQxHjAcBgNVBAoTFU1p
// SIG // Y3Jvc29mdCBDb3Jwb3JhdGlvbjEjMCEGA1UEAxMaTWlj
// SIG // cm9zb2Z0IENvZGUgU2lnbmluZyBQQ0ECEzMAAACdHo0n
// SIG // rrjz2DgAAQAAAJ0wCQYFKw4DAhoFAKCBvjAZBgkqhkiG
// SIG // 9w0BCQMxDAYKKwYBBAGCNwIBBDAcBgorBgEEAYI3AgEL
// SIG // MQ4wDAYKKwYBBAGCNwIBFTAjBgkqhkiG9w0BCQQxFgQU
// SIG // +k2hPwtjW//43UCMiZDgadySh7YwXgYKKwYBBAGCNwIB
// SIG // DDFQME6gJoAkAE0AaQBjAHIAbwBzAG8AZgB0ACAATABl
// SIG // AGEAcgBuAGkAbgBnoSSAImh0dHA6Ly93d3cubWljcm9z
// SIG // b2Z0LmNvbS9sZWFybmluZyAwDQYJKoZIhvcNAQEBBQAE
// SIG // ggEABtYP+MhXLEiALjABbs0tc3DyaoM9rf2KLHaNRtcq
// SIG // envcaYDt5a/IsPFx0ALFfDvBefNY7N3y0/cdPks+Dyzw
// SIG // 8WZ45tN1o5Ip2kubttqGs4lWaTH3+8025bxJ6kgRp9jH
// SIG // lL0xiOfa2GFOnn1TEkiy22r1F7FHU7d1VLt7Au2L42BR
// SIG // +6VaOYpqQ/RUd7fTXjkGy5K50SaAl714CxkCq6JxSN3h
// SIG // MGmfX2BzjoxI07V65lm4oDqN77AOOLHETP44w3awki9n
// SIG // im4fA+CBMrW3LeE9+zKv9MmjK2PFnU/e1/nGS6xKv+eP
// SIG // 36N6uT+C3+pFmQ6j5PIR9t2cRRBzAvzmawtlDKGCAh8w
// SIG // ggIbBgkqhkiG9w0BCQYxggIMMIICCAIBATCBhTB3MQsw
// SIG // CQYDVQQGEwJVUzETMBEGA1UECBMKV2FzaGluZ3RvbjEQ
// SIG // MA4GA1UEBxMHUmVkbW9uZDEeMBwGA1UEChMVTWljcm9z
// SIG // b2Z0IENvcnBvcmF0aW9uMSEwHwYDVQQDExhNaWNyb3Nv
// SIG // ZnQgVGltZS1TdGFtcCBQQ0ECCmECkkoAAAAAACAwCQYF
// SIG // Kw4DAhoFAKBdMBgGCSqGSIb3DQEJAzELBgkqhkiG9w0B
// SIG // BwEwHAYJKoZIhvcNAQkFMQ8XDTEyMTExNDIzNDQ0OVow
// SIG // IwYJKoZIhvcNAQkEMRYEFDyFgE11xy1greMAmq0PrMyh
// SIG // h+U9MA0GCSqGSIb3DQEBBQUABIIBAHzhgOBgfHLUkiCc
// SIG // OCh1tdsm2bR5wSZYwy8VrZDuiUnk36QzDCMo4Xk6f3W5
// SIG // +CIMeAm+2sTcC1sskvE9udEtStsBH/taewBL80HUiXbx
// SIG // qLJo12Hukrw/ysafc8/oboQx/6LeOeaLyHlGGC7biiiv
// SIG // 3XXYcjYCyo84GeGuUGZPppzzVm00hyDj6UsMSIhf/h6D
// SIG // y27YUrQKGvooXqRTdd2brBr8pyNLmlxM8v5BoId+uGUU
// SIG // 7LtxdU21VJ6Fz3uVUhvm7qjjpBLIf4MO1NlOpjKKAV8x
// SIG // yvnMuLTngUEVvLOJm1C2GKEbImS5JShi7FJQ2FScdbPV
// SIG // A6t9v5wuXKlSN4M7n+s=
// SIG // End signature block
