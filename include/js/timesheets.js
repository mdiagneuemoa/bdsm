var listInterventionsId = new Array();
var intervention = new Array(5);
var nbinterventions;
function init()
{
	//form.dureeTotale.value='00:00';
	nbinterventions=0;
	document.getElementById('tabIntervs').nextID=1;
	document.getElementById('dureeT').appendChild(document.createTextNode("00:00"));
	var tabInterv = document.getElementById('tabIntervs');
	tabInterv.appendChild(trNoIntervention());
}
function addIntervForm(form)
{
	document.getElementById('interv').style.display='block';
	form.date_interv.value = form.start_date.value;
	//form.account_name.value="";
	//form.potential_name.value="";
	//intervtask = form.intervtask.value;
	//durationInterv = form.duration_interv.value;
}
function calculDuration(duree,form,op)
{
	var dureet=duree.split(":");
	var dureeTotalet=(form.dureeTotale.value).split(":");
	var dureemin = parseInt(dureet[0])*60+parseInt(dureet[1]);
	var dureeTotalemin = parseInt(dureeTotalet[0])*60+parseInt(dureeTotalet[1]);
	var result = 0;
	var reste = 0;
	if(op=="add")
	{
		result = (dureeTotalemin+dureemin)/60;
		reste = (dureeTotalemin+dureemin)%60;
	}else
	if(op=="sous")
	{
		result = (dureeTotalemin-dureemin)/60;
		reste = (dureeTotalemin-dureemin)%60;
	}
	var resteString = reste.toString();
	if(resteString.length==1) {resteString="0"+resteString;}
	//alert(result.toString()+":"+resteString);
	return(result.toString()+":"+resteString);
}
function addToListIntervs(form)
{
	//alert(form.duration_interv.value+"-"+form.dureeTotale.value);
	
	dateInterv = form.date_interv.value;
	clientInterv = form.account_name.value;
	dossierClientInterv = form.potential_name.value;
	intervtask = form.intervtask.value;
	durationInterv = form.duration_interv.value;
	
	var tabInterv = document.getElementById('tabIntervs');
	var trTodell = document.getElementById("nonInterv");
	if(trTodell!=null) 	tabInterv.removeChild(trTodell);
	var item = new IntervItem(form,tabInterv.nextID,dateInterv,clientInterv,dossierClientInterv,intervtask,durationInterv);
    tabInterv.appendChild(item);
	document.getElementById('interv').style.display='none';   
	form.dureeTotale.value  = calculDuration(durationInterv,form,"add");
	nbinterventions++;
	tabInterv.nextID++;
	var dureetot = document.getElementById('dureeT');
	 dureetot.replaceChild(document.createTextNode(form.dureeTotale.value),dureetot.firstChild);
	 var datObj;
	 var str; 
	 var url = "&ID="+tabInterv.nextID-1+"&date="+dateInterv+"&client="+clientInterv+"&dossierClient="+dossierClientInterv+"&tache="+intervtask+"&duree="+durationInterv+"&dureeTot="+form.dureeTotale.value;
	 
        new Ajax.Request(
            'index.php',
             {
                     queue: {position: 'end', scope: 'command'},
                     method: 'post',
					postBody:"module=Timesheets&action=TimesheetAjax&ajax=true&file=interventions&addInterv=true"+url,
                     onComplete: function(response)
					 {
                         var str = response.responseText;
						//if(str.indexOf('FAILURE') > -1)
						//{
						//	alert(" Echec d'ajout de Dossier");
						//}
						//else
						  // alert(str);
						  //duree.appendChild(document.createTextNode(str));
                     }
             }
                        );
	
}

function delToListIntervs(id,durationInterv,action)
{
	var form = document.getElementById('formTmsht');
	var tabInterv = document.getElementById('tabIntervs');
	if(confirm("Etes-vous sure de vouloir supprimer cette intervention?"))
	{

		form.dureeTotale.value  = calculDuration(durationInterv,form,"sous");
		var dureetot = document.getElementById('dureeT');
		 dureetot.replaceChild(document.createTextNode(form.dureeTotale.value),dureetot.firstChild);
		 remove(tabInterv,'tr_'+id);
		 var datObj;
		 var str; 
		 var url = "module=Timesheets&action=TimesheetAjax&ajax=true&file=interventions&dellInterv="+action+"&ID="+id+"&dureeTot="+form.dureeTotale.value;;
	        new Ajax.Request(
	            'index.php',
	             {
	                     queue: {position: 'end', scope: 'command'},
	                     method: 'post',
						 postBody:url,
	                     onComplete: function(response)
	                     {
	                        
	                     }
	             }
	                        );
		
	}
}

function IntervItem(form,trID,dateInterv,client,dossierClient,intervtask,durationInterv)
{

    var tbody = document.createElement('tbody');
	var id="tr_"+trID;
	tbody.setAttribute("id",id);
	// création du td image suppression
	var img = document.createElement('img');
    img.setAttribute("src", "themes/images/remove.gif");
	img.style.border="0";
   	aDelete = document.createElement('a');
	aDelete.onclick=function(){delToListIntervs(form,trID,"add")};
	aDelete.href="#";
    //aDelete.href="javascript:onclick=delToListIntervs("+form+",intervs,"+trID+");void(0)";
    aDelete.appendChild(img);
	td1 = document.createElement('td');
	td1.style.textAlign = "center";
	td1.appendChild(aDelete);
	td2 = document.createElement('td');
    td2.appendChild(document.createTextNode(dateInterv));
	td2.style.textAlign = "center";
    td3	= document.createElement('td');
    td3.appendChild(document.createTextNode(client));
    td3.style.textAlign = "center";
	td4	= document.createElement('td');
    td4.appendChild(document.createTextNode(dossierClient));
    td4.style.textAlign = "center";
	td5	= document.createElement('td');
    td5.appendChild(document.createTextNode(intervtask));
    td5.style.textAlign = "center";
	td6	= document.createElement('td');
	td6.id="duration_"+trID;
    td6.appendChild(document.createTextNode(durationInterv));
    td6.style.textAlign = "center";
    tr = document.createElement('tr');
    tr.appendChild(td1);
    tr.appendChild(td2);
	tr.appendChild(td3);
	tr.appendChild(td4);
	tr.appendChild(td5);
	tr.appendChild(td6);
	tbody.appendChild(tr);
    return tbody;
}

function trNoIntervention()
{
	
	var tbody = document.createElement('tbody');
	var id="nonInterv";
	tbody.setAttribute("id",id);
	// création du td image suppression
	td1 = document.createElement('td');
	td1.style.textAlign = "center";
	td1.setAttribute("colspan",6);
	td1.appendChild(document.createTextNode("Aucune intervention saisie..."));
	tr = document.createElement('tr');
    tr.appendChild(td1);
    tbody.appendChild(tr);
    return tbody;
}

function deleteInterv(scriptid)
{
    var item = interventions.findByScriptId( scriptid );
    interventions.remove( scriptid );
	
	
}

function findByTrId(table,ids) {
        for( i = 0; i < table.childNodes.length; i++ ) {
			if ( table.childNodes[i].id == ids ) {
				return table.childNodes[i];
            }
		}
		return null;
}

function remove(table,ids) {
        var item = findByTrId(table,ids);
        if ( table.removeChild(item)) {
            return;
        }
       // table.removeChild(item) = true;
        new Effect.BlindUp( findByTrId(table,ids),
                { duration: .5});
    }

function formValidateTimesheet()
{
	// validation for Timesheet hodar crm
		if (getObj('timesheetname').value.replace(/^\s+/g, '').replace(/\s+$/g, '').length==0) 
		{
			alert("Nom Feuille de Temps "+alert_arr.CANNOT_BE_EMPTY);
			getObj('timesheetname').focus();
           	return false;
		}	
		if (getObj('consultantname').value.replace(/^\s+/g, '').replace(/\s+$/g, '').length==0) 
		{
			alert("Nom Consultant "+alert_arr.CANNOT_BE_EMPTY);
			getObj('consultantname').focus();
           	return false;
		}	
		if (getObj('start_date') != null && getObj('start_date').value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
		{	
			if (!dateValidate('start_date','Periode Debut',"OTH"))
			return false
		}else
		{
			alert("Periode Debut "+alert_arr.CANNOT_BE_EMPTY);
			getObj('start_date').focus();
           	return false;
		}
		if (getObj('due_date') != null && getObj('due_date').value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
		{	
			if (!dateValidate('due_date','Periode Fin',"OTH"))
				return false
			if (!dateComparison('due_date','Periode Fin','start_date','Periode Debut',"GE"))
				return false
		}
		else
		{
			alert("Periode Fin "+alert_arr.CANNOT_BE_EMPTY);
			getObj('due_date').focus();
           	return false;
		}
		if (nbinterventions==0)
		{
			alert("Vous devez saisir au moins une intervention");
			return false
		}
		return true;
}
function formValidateIntervention()
{
	
		if (getObj('date_interv') != null && getObj('date_interv').value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
		{	
			if (!dateValidate('date_interv','Date Intervention',"OTH"))
			return false
			if (!dateComparison('date_interv','Date Intervention','start_date','Periode Debut',"GE"))
				return false
			if (!dateComparison('due_date','Periode Fin','date_interv','Date Intervention',"GE"))
				return false	
		}else
		{
			alert("Date Intervention "+alert_arr.CANNOT_BE_EMPTY);
			getObj('date_interv').focus();
           	return false;
		}
		if (getObj('account_id')  != null && getObj('account_id') .value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
		{	
			if (getObj('account_id').value.length!=0)
			{
				if (!intValidate('account_id',"Customer"))
					return false
			}
		}
		else
		{
			alert("Client "+alert_arr.CANNOT_BE_EMPTY);
			getObj('account_id').focus();
           	return false;
		}
		if (getObj('potential_id')  != null && getObj('potential_id') .value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
		{	
			if (getObj('potential_id').value.length!=0)
			{
				if (!intValidate('potential_id',"Potential"))
					return false
			}
		}else
		{
			alert("Dossier Client "+alert_arr.CANNOT_BE_EMPTY);
			getObj('potential_id').focus();
           	return false;
		}
		return true;
}

function intervList(table)
{
    table.interventions = this;
    this.table = table;
    this.nextId = 1;
    this.add = function(item) {
        item.style.display = 'none';
        //this.div.insertBefore( item, this.div.firstChild );
        this.div.appendChild( item );
        new Effect.BlindDown( item, {duration: .5} );
    }

    this.findByScriptId = function(scriptid) {
        for( i = 0; i < this.table.childNodes.length; i++ ) {
            if ( this.table.childNodes[i].scriptid == scriptid ) {
                return this.table.childNodes[i];
            }
        }
        return null;
    }

    this.remove = function( scriptId ) {
        var item = this.findByScriptId( scriptId );
        if ( item.removing ) {
            return;
        }
        item.removing = true;
        new Effect.BlindUp(this.findByScriptId(scriptId),
                { duration: .5});
    }

    return this;
}
