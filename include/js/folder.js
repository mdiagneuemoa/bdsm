
function createFolders(org,orgLay,folderid,foldername,potentialid,rapport)
{
	alert("test");
}

function createFolderss(obj,Lay,folderFatherId,folderFatherName,potentialid,folderType){
	var tagName = document.getElementById(Lay);
    var leftSide = findPosX(obj);
    var topSide = findPosY(obj);
    var maxW = tagName.style.width;
    var widthM = maxW.substring(0,maxW.length-2);
	
	$('folderFatherName').innerHTML = folderFatherName;
	$('folderFather_id').value = folderFatherId;
	$('folderPotential_id').value = potentialid;
	$('folder_type').value = folderType;
	if(Lay == 'editdiv') 
    {
        leftSide = leftSide - 225;
        topSide = topSide - 125;
    }else if(Lay == 'transferdiv')
	{
		leftSide = leftSide - 10;
	        topSide = topSide;
	}
    var IE = document.all?true:false;
    if(IE)
   {
    if($("repposition1"))
    {
	if(topSide > 1200)
	{
		topSide = topSide-250;
	}
    }
   }
	
    var getVal = eval(leftSide) + eval(widthM);
    if(getVal  > document.body.clientWidth ){
        leftSide = eval(leftSide) - eval(widthM);
        tagName.style.left = leftSide + 34 + 'px';
    }
    else
        tagName.style.left= leftSide + 'px';
    tagName.style.top= topSide + 'px';
    tagName.style.display = 'block';
    tagName.style.visibility = "visible";
	$('folder_name').focus();
	
}
function closeFolderCreate()
{
        $('folder_id').value = '';
        $('folder_name').value = '';
        $('folder_desc').value='';
        fninvsh('orgLay')
}

function AddFolder()
{
        var fldrname=getObj('folder_name').value;
		var fldrdesc=getObj('folder_desc').value;
		var fldFatherId=getObj('folderFather_id').value;
		var fldPotentialId=getObj('folderPotential_id').value;
		var fldType=getObj('folder_type').value;
		//alert(fldrname+":"+fldrdesc+":"+fldFatherId+":"+fldPotentialId+":"+fldType);

        if(fldrname.replace(/^\s+/g, '').replace(/\s+$/g, '').length==0)
        {
                alert("Nom Dossier vide");
                return false;
        }
        if(fldrname.replace(/^\s+/g, '').replace(/\s+$/g, '').length>=21)
        {
                alert("Nom Dossier trop long");
                return false;i
        }
        if(fldrdesc.replace(/^\s+/g, '').replace(/\s+$/g, '').length>=51)
        {
                alert("Descrption Dossier trop longue");
                return false;
        }
		if(fldFatherId.replace(/^\s+/g, '').replace(/\s+$/g, '').length==0)
        {
                alert("Dossier parent vide");
                return false;
        }
		if(fldrname.match(/['"\\%+]/) || fldrdesc.match(/['"\\%+]/))
        {
                alert("Caractères spéciaux non autorisés");
                return false;
        }	
		if(fldrname.match(/[?]+$/) || fldrname.match(/[?]+/))
		{
			alert("Caractères spéciaux non autorisés");
			return false;
		}
                
		fninvsh('orgLay');
		var foldername = encodeURIComponent(getObj('folder_name').value);
		var folderdesc = encodeURIComponent(getObj('folder_desc').value);
		
		foldername = foldername.replace(/^\s+/g, '').replace(/\s+$/g, '');
		foldername = foldername.replace(/&/gi,'*amp*');
		folderdesc = folderdesc.replace(/^\s+/g, '').replace(/\s+$/g, '');
		folderdesc = folderdesc.replace(/&/gi,'*amp*');
		getObj('folder_name').value = '';
		getObj('folder_desc').value = '';
		var mode = getObj('fldrsave_mode').value;
		if(mode == 'save')
		{
				url ='&savemode=Save&foldername='+foldername+'&folderdesc='+folderdesc+'&folderFatherId='+fldFatherId+'&potentialId='+fldPotentialId+'&folderType='+fldType;
		}
		getObj('fldrsave_mode').value = 'save';
		$('status').style.display = 'block';
		new Ajax.Request(
							'index.php',
							{
								queue: {position: 'end', scope: 'command'},
								method: 'post',
								postBody: 'action=DocumentsAjax&mode=ajax&file=SaveFolder&module=Documents'+url,
								onComplete: function(response) 
								{
										var item = response.responseText;
										//alert(item);
										$('status').style.display = 'none';
										if(item.indexOf('NOT_PERMITTED') > -1)
										{
											//$('lblError').innerHTML = "<table cellpadding=0 cellspacing=0 border=0 width=100%><tr><td class=small bgcolor=red><font color=white size=2><b>You are not permitted to do this operation.</b></font></td></tr></table>";
											//setTimeOutFn();
											alert(" Vous n'êtes pas autorisé à créer un Dossier");
										}
										else if(item.indexOf('FAILURE') > -1)
										{
											//$('lblError').innerHTML = "<table cellpadding=0 cellspacing=0 border=0 width=100%><tr><td class=small bgcolor=red><font color=white size=2><b>Unable to add Folder. Please try again.</b></font></td></tr></table>";
											//setTimeOutFn();	
											
											alert(" Echec d'ajout de Dossier");
										}
										else if(item.indexOf('DUPLICATE_FOLDERNAME') > -1)
										{
											alert(" ce nom de Dossier existe déja");
										}
										else
										{
											//getObj("ListViewContents").innerHTML = item;
											window.location.reload(true); 
										}
								}	
							}
						);
}


function DeleteFolderCheck(folderId,folderName,folderType)
{
        
		gtempfolderId = folderId;
		gtempfolderName = folderName;
		gtempfolderType= folderType;
		new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: "module=Documents&action=DocumentsAjax&mode=ajax&file=DeleteFolder&deletechk=true&folderid="+gtempfolderId+"&folderType="+gtempfolderType,
                        onComplete: function(response) 
						{
							var item = response.responseText;
							//alert("test");
							if(item.indexOf("NOT_PERMITTED",1) > -1)
							{
								alert(alert_arr.NOT_PERMITTED);
								return false;
							}
							else if(item.indexOf("FAILURE",1) > -1)
							{
									alert("Imposible de supprimer ce Dossier car il n'est pas vide!")
									return false;
							}
							else
							{
								
								if(confirm("Etes-vous sure de vouloir supprimer le dossier :"+gtempfolderName+" ?"))
								{
										DeleteFolder(gtempfolderId,gtempfolderType);                            
								}
								//alert("A supprimer");
							}
		                }
		        }
        );
}

function DeleteFolder(folderId,folderType)
{
	$('status').style.display = "block";
        new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: "module=Documents&action=DocumentsAjax&mode=ajax&file=DeleteFolder&folderid="+folderId+"&folderType="+folderType,
                        onComplete: function(response) {
                                        var item = response.responseText;
										$('status').style.display = "none";
                                        if(item.indexOf("FAILURE") > -1)
                                                alert('Erreur de suppression du dossier.Reessayer plutard!');
                                        else
										{
											//$('ListViewContents').innerHTML = item;
											window.location.reload(true); 
										}	

		               }
                }
        );
}
