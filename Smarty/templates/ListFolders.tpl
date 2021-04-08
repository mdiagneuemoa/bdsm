{*<!--
/*********************************************************************************
  ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
   * ("License"); You may not use this file except in compliance with the License
   * The Original Code is:  vtiger CRM Open Source
   * The Initial Developer of the Original Code is vtiger.
   * Portions created by vtiger are Copyright (C) vtiger.
   * All Rights Reserved.
  *
 ********************************************************************************/
-->*}

<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<style type="text/css">
a.x {ldelim}
		color:black;
		text-align:center;
		text-decoration:none;
		padding:2px;
		font-weight:bold;
{rdelim}
	
a.x:hover {ldelim}
		color:#333333;
		text-decoration:underline;
		font-weight:bold;
{rdelim}

ul {ldelim}color:black;{rdelim}	 
	
.drag_Element{ldelim}
	position:relative;
	left:0px;
	top:0px;
	padding-left:2px;
	padding-right:5px;
	border:0px dashed #CCCCCC;
	visibility:hidden;
{rdelim}

#Drag_content{ldelim}
	position:absolute;
	left:0px;
	top:0px;
	padding-left:2px;
	padding-right:5px;
	background-color:#000066;
	color:#FFFFFF;
	border:1px solid #CCCCCC;
	font-weight:bold;
	display:none;
{rdelim}
</style>
<script>
 if(!e)
  window.captureEvents(Event.MOUSEMOVE);

//  window.onmousemove= displayCoords;
//  window.onclick = fnRevert;
  
   function displayCoords(event) 
	 {ldelim}
				var move_Element = document.getElementById('Drag_content').style;
				if(!event){ldelim}
						move_Element.left = e.pageX +'px' ;
						move_Element.top = e.pageY+10 + 'px';	
				{rdelim}
				else{ldelim}
						move_Element.left = event.clientX +'px' ;
					    move_Element.top = event.clientY+10 + 'px';	
				{rdelim}
	{rdelim}
  
	  function fnRevert(e)
	  {ldelim}
		  	if(e.button == 2){ldelim}
				document.getElementById('Drag_content').style.display = 'none';
				hideAll = false;
				parentId = "Head";
	    		parentName = "DEPARTMENTS";
			    childId ="NULL";
	    		childName = "NULL";
			{rdelim}
	{rdelim}

</script>

<table border=0 cellspacing=0 cellpadding=2 width=100% >
	<tr>
		<td colspan="2">
			<table border=0 cellspacing=0 cellpadding=5>
				<tr>
					<td class="big" nowrap><strong>{$MOD.LBL_LIST_FOLDERS_CREATED}</strong></td>
					<td class="small" align=right>&nbsp;</td>
				</tr>
			</table>
			<hr>
		</td>
	</tr>
	<tr>
		<td>
			<div id='RoleTreeFull'  onMouseMove="displayCoords(event)"> 
				{include file='FolderTree.tpl'}
		    </div>
		</td>
		<td>	
			<div style="display:none;width:350px;" id="orgLay" class="layerPopup" >
			<script language="JavaScript" type="text/javascript" src="include/js/folder.js"></script>

				<form name="ajoutDossier">
				<table  cellspacing=0 cellpadding=0 border=0 width=80%>
					<tr>
						<td class="genHeaderSmall" align="center">{$MOD.LBL_ADD_NEW_FOLDER}</td>
					</tr>
					<tr>
						<td class="small">
							<table border=0 celspacing=0 cellpadding=5 width=100% align=center >
							<tr>
								<td align="right" nowrap class="cellLabel small"><font color="red">*</font>&nbsp;<b>{$MOD.LBL_FOLDER_NAME}</b></td>
								<td align="left" class="cellText small">
									<input id="folder_id" name="folderId" type="hidden" value=''>
									<input id="fldrsave_mode" name="folderId" type="hidden" value='save'>
									<input id="folder_name" name="folderName" class="txtBox" type="text" MAXLENGTH=20><br>Maximum 20
								</td>
							</tr>
							<tr>
								<td class="cellLabel small" align="right" nowrap><b>{$MOD.LBL_FOLDER_DESC}</b></td>
								<td class="cellText small" align="left"><input id="folder_desc" name="folderDesc" class="txtBox" type="text" MAXLENGTH=50><br>Maximum 50</td>
							 </tr>
							 <tr>
								<td class="cellLabel small" align="right" nowrap><b>{$MOD.LBL_FOLDER_FATHER}</b></td>
								<td class="cellText small" align="left">
								<input id="folderFather_id" name="folderFatherId" type="hidden" value=''>
								<input id="folderPotential_id" name="potentialId" type="hidden">
								<input id="folder_type" name="folderType" type="hidden">
								<input name="createFolder" type="hidden">
								<div id="folderFatherName"></div>
								</td>
							 </tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class="small" align="center">
							<input name="save" value=" &nbsp;{$APP.LBL_SAVE_BUTTON_LABEL}&nbsp; " class="crmbutton small save" onClick="AddFolder();" type="button">&nbsp;&nbsp;
							<input name="cancel" value=" {$APP.LBL_CANCEL_BUTTON_LABEL} " class="crmbutton small cancel" onclick="closeFolderCreate();" type="button">
						</td>
					</tr>
				</table>
				</form>
			</div>
		</td>
	</tr>
</table>
			
<script language="javascript" type="text/javascript">
	var hideAll = false;
	var parentId = "";
	var parentName = "";
	var childId ="NULL";
	var childName = "NULL";

		
	
	 function get_parent_ID(obj,currObj)
	 {ldelim}
			var leftSide = findPosX(obj);
    			var topSide = findPosY(obj);
			var move_Element = document.getElementById('Drag_content');
		 	childName  = document.getElementById(currObj).innerHTML;
			childId = currObj;
			move_Element.innerHTML = childName;
			move_Element.style.left = leftSide + 15 + 'px';
			move_Element.style.top = topSide + 15+ 'px';
			move_Element.style.display = 'block';
			hideAll = true;	
	{rdelim}
	
	function put_child_ID(currObj)
	{ldelim}
			var move_Element = $('Drag_content');
	 		parentName  = $(currObj).innerHTML;
			parentId = currObj;
			move_Element.style.display = 'none';
			hideAll = false;	
			if(childId == "NULL")
			{ldelim}
//				alert("Please Select the Node");
				parentId = parentId.replace(/user_/gi,'');
				window.location.href="index.php?module=Settings&action=RoleDetailView&parenttab=Settings&roleid="+parentId;
			{rdelim}
			else
			{ldelim}
				childId = childId.replace(/user_/gi,'');
				parentId = parentId.replace(/user_/gi,'');
				new Ajax.Request(
  					'index.php',
				        {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
					        method: 'post',
					        postBody: 'module=Users&action=UsersAjax&file=RoleDragDrop&ajax=true&parentId='+parentId+'&childId='+childId,
						onComplete: function(response) {ldelim}
							if(response.responseText != alert_arr.ROLE_DRAG_ERR_MSG)
							{ldelim}
						                $('RoleTreeFull').innerHTML=response.responseText;
						                hideAll = false;
							        parentId = "";
						                parentName = "";
						                childId ="NULL";
								childName = "NULL";
						        {rdelim}
						        else
						                alert(response.responseText);
			                        {rdelim}
				        {rdelim}
				);
			{rdelim}
	{rdelim}

	function fnVisible(Obj)
	{ldelim}
			if(!hideAll)
				document.getElementById(Obj).style.visibility = 'visible';
	{rdelim}

	function fnInVisible(Obj)
	{ldelim}
		document.getElementById(Obj).style.visibility = 'hidden';
	{rdelim}

	function addForder(forderid,foldername)
	{ldelim}
		document.getElementById("addFolder").style.display = 'block';
		document.getElementById("folderFatherName").innerHTML=foldername;
		document.form['ajoutDossier'].folderFatherId.value=folderid;
		//window.open("modules/HReports/addFolder.php?record"+forderid+"&parenttab=Espace Rapportage","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=300, height=300");
		
	{rdelim}
	
	function CancelAddForder()
	{ldelim}
		document.getElementById("addFolder").style.display = 'none';
	{rdelim}
	
	function saveFolder()
	{ldelim}
		/*
		var folderFatherId = document.form['ajoutDossier'].folderFatherId.value;
		var foldername = document.form['ajoutDossier'].folderName.value;
		var folderDesc = document.form['ajoutDossier'].folderDesc.value;
		document.form['ajoutDossier'].action="index.php?action=CallRelatedList&module=Potentials&record"+folderFatherId+"=&parenttab=Sales";
		*/
		document.form['ajoutDossier'].createFolder.value="yes";
		document.getElementById("addFolder").style.display = 'none';
		/*
		new Ajax.Request(
  					'index.php',
				        {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
					        method: 'post',
					        postBody: 'module=Users&action=UsersAjax&file=RoleDragDrop&ajax=true&parentId='+parentId+'&childId='+childId,
						onComplete: function(response) {ldelim}
							if(response.responseText != alert_arr.ROLE_DRAG_ERR_MSG)
							{ldelim}
						                $('RoleTreeFull').innerHTML=response.responseText;
						                hideAll = false;
							        parentId = "";
						                parentName = "";
						                childId ="NULL";
								childName = "NULL";
						        {rdelim}
						        else
						                alert(response.responseText);
			                        {rdelim}
				        {rdelim}
				);*/
	{rdelim}

function showhide(argg,imgId)
{ldelim}
	var harray=argg.split(",");
	var harrlen = harray.length;	
	var i;
	for(i=0; i<harrlen; i++)
	{ldelim}
		var x=document.getElementById(harray[i]).style;
        	if (x.display=="none")
        	{ldelim}
           		x.display="block";
			document.getElementById(imgId).src="{'minus.gif'|@vtiger_imageurl:$THEME}";
         	{rdelim}
        	else
		{ldelim}
			x.display="none";
			document.getElementById(imgId).src="{'plus.gif'|@vtiger_imageurl:$THEME}";
		{rdelim}
	{rdelim}
{rdelim}

function showhide2(argg,imgId,dossierId)
{ldelim}
	var harray=argg.split(",");
	var harrlen = harray.length;	
	var i;
	for(i=0; i<harrlen; i++)
	{ldelim}
		var x=document.getElementById(harray[i]).style;
        	if (x.display=="none")
        	{ldelim}
           		x.display="block";
			document.getElementById(imgId).src="{'minus.gif'|@vtiger_imageurl:$THEME}";
			document.getElementById(dossierId).src="{'dossier-ouvert.gif'|@vtiger_imageurl:$THEME}";
         	{rdelim}
        	else
		{ldelim}
			x.display="none";
			document.getElementById(imgId).src="{'plus.gif'|@vtiger_imageurl:$THEME}";
			document.getElementById(dossierId).src="{'dossier-ferme.gif'|@vtiger_imageurl:$THEME}";
		{rdelim}
	{rdelim}
{rdelim}

</script>
