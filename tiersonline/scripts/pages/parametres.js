(function () {
    
	var editionEnCours = false;
	var sauve = false;
  


  var moncomptelink = document.getElementById("moncomptelink");
	var monagendalink = document.getElementById("monagendalink");
	var mesconsigneslink = document.getElementById("mesconsigneslink");
 
	
	$('#editconsigneaccueil').click( function() {
	document.getElementById("consigneaccueil").readOnly=false;
	document.getElementById("consigneaccueil").focus(); 
	 });
	 
	 $('#editconsigneaccueil').blur( function() {
		alert('save consigneaccueil');
	 });
	 
	$('#editconsignereponse').click( function() {
	document.getElementById("consignereponse").readOnly=false;
	document.getElementById("consignereponse").focus(); 
	 });

	$('#editconsigneautre').click( function() {
	document.getElementById("consigneautre").readOnly=false;
	document.getElementById("consigneautre").focus(); 
	 });	 
	var showmoncompte = function() {
       	document.getElementById("moncompte").style.display='block';
		document.getElementById("monagenda").style.display='none';
		document.getElementById("mesconsignes").style.display='none';

    };
	var showmonagenda = function() {
		 	document.getElementById("moncompte").style.display='none';
		document.getElementById("monagenda").style.display='block';
		document.getElementById("mesconsignes").style.display='none';

    };
	var showmesconsignes = function() {
		document.getElementById("moncompte").style.display='none';
		document.getElementById("monagenda").style.display='none';
		document.getElementById("mesconsignes").style.display='block';

    };
  
	var paramClickEventListener = function() {
		moncomptelink.addEventListener("click", showmoncompte, false);
	    monagendalink.addEventListener("click", showmonagenda, false);
	    mesconsigneslink.addEventListener("click", showmesconsignes, false);
    };

	paramClickEventListener();

}());





function configservice()
{
	var configmonservice =  document.getElementById('configmonservice');
	var moncompte =  document.getElementById('moncompte');
	var mesconsignes =  document.getElementById('mesconsignes');
	var mesalertes =  document.getElementById('mesalertes');
	var monagenda =  document.getElementById('monagenda');

	var configservice =  document.getElementById('configservice');
	var compte =  document.getElementById('compte');
	var consignes =  document.getElementById('consignes');
	var alertes =  document.getElementById('alertes');
	var agenda =  document.getElementById('agenda');

	configmonservice.style.display='block';
	moncompte.style.display='none';
	mesconsignes.style.display='none';
	mesalertes.style.display='none';
	monagenda.style.display='none';

	//configservice.className = 'dvtSelectedCell';
	compte.className = 'dvtUnSelectedCell';
	consignes.className = 'dvtUnSelectedCell';
	//alertes.className = 'dvtUnSelectedCell';
	agenda.className = 'dvtUnSelectedCell';

}

function paramcompte()
{

	var configmonservice =  document.getElementById('configmonservice');
	var moncompte =  document.getElementById('moncompte');
	var mesconsignes =  document.getElementById('mesconsignes');
	var mesalertes =  document.getElementById('mesalertes');
	var monagenda =  document.getElementById('monagenda');

	var configservice =  document.getElementById('configservice');
	var compte =  document.getElementById('compte');
	var consignes =  document.getElementById('consignes');
	var alertes =  document.getElementById('alertes');
	var agenda =  document.getElementById('agenda');

	configmonservice.style.display='none';
	moncompte.style.display='block';
	mesconsignes.style.display='none';
	mesalertes.style.display='none';
	monagenda.style.display='none';

	//configservice.className = 'dvtUnSelectedCell';
	compte.className = 'dvtSelectedCell';
	consignes.className = 'dvtUnSelectedCell';
	//alertes.className = 'dvtUnSelectedCell';
	agenda.className = 'dvtUnSelectedCell';

}

function paramconsignes()
{

	var configmonservice =  document.getElementById('configmonservice');
	var moncompte =  document.getElementById('moncompte');
	var mesconsignes =  document.getElementById('mesconsignes');
	var mesalertes =  document.getElementById('mesalertes');
	var monagenda =  document.getElementById('monagenda');

	var configservice =  document.getElementById('configservice');
	var compte =  document.getElementById('compte');
	var consignes =  document.getElementById('consignes');
	var alertes =  document.getElementById('alertes');
	var agenda =  document.getElementById('agenda');

	configmonservice.style.display='none';
	moncompte.style.display='none';
	mesconsignes.style.display='block';
	mesalertes.style.display='none';
	monagenda.style.display='none';

	//configservice.className = 'dvtUnSelectedCell';
	compte.className = 'dvtUnSelectedCell';
	consignes.className = 'dvtSelectedCell';
	//alertes.className = 'dvtUnSelectedCell';
	agenda.className = 'dvtUnSelectedCell';

}

function paramalertes()
{

	var configmonservice =  document.getElementById('configmonservice');
	var moncompte =  document.getElementById('moncompte');
	var mesconsignes =  document.getElementById('mesconsignes');
	var mesalertes =  document.getElementById('mesalertes');
	var monagenda =  document.getElementById('monagenda');

	var configservice =  document.getElementById('configservice');
	var compte =  document.getElementById('compte');
	var consignes =  document.getElementById('consignes');
	var alertes =  document.getElementById('alertes');
	var agenda =  document.getElementById('agenda');

	configmonservice.style.display='none';
	moncompte.style.display='none';
	mesconsignes.style.display='none';
	mesalertes.style.display='block';
	monagenda.style.display='none';

	configservice.className = 'dvtUnSelectedCell';
	compte.className = 'dvtUnSelectedCell';
	consignes.className = 'dvtUnSelectedCell';
	alertes.className = 'dvtSelectedCell';
	agenda.className = 'dvtUnSelectedCell';

	
}


function paramagenda()
{

	var configmonservice =  document.getElementById('configmonservice');
	var moncompte =  document.getElementById('moncompte');
	var mesconsignes =  document.getElementById('mesconsignes');
	var mesalertes =  document.getElementById('mesalertes');
	var monagenda =  document.getElementById('monagenda');

	var configservice =  document.getElementById('configservice');
	var compte =  document.getElementById('compte');
	var consignes =  document.getElementById('consignes');
	var alertes =  document.getElementById('alertes');
	var agenda =  document.getElementById('agenda');

	configmonservice.style.display='none';
	moncompte.style.display='none';
	mesconsignes.style.display='none';
	mesalertes.style.display='none';
	monagenda.style.display='block';

	//configservice.className = 'dvtUnSelectedCell';
	compte.className = 'dvtUnSelectedCell';
	consignes.className = 'dvtUnSelectedCell';
	//alertes.className = 'dvtUnSelectedCell';
	agenda.className = 'dvtSelectedCell';

	
}
