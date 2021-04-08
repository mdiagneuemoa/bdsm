<?php /* Smarty version 2.6.18, created on 2009-10-08 10:18:25
         compiled from ListFolders.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'ListFolders.tpl', 288, false),)), $this); ?>

<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<style type="text/css">
a.x {
		color:black;
		text-align:center;
		text-decoration:none;
		padding:2px;
		font-weight:bold;
}
	
a.x:hover {
		color:#333333;
		text-decoration:underline;
		font-weight:bold;
}

ul {color:black;}	 
	
.drag_Element{
	position:relative;
	left:0px;
	top:0px;
	padding-left:2px;
	padding-right:5px;
	border:0px dashed #CCCCCC;
	visibility:hidden;
}

#Drag_content{
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
}
</style>
<script>
 if(!e)
  window.captureEvents(Event.MOUSEMOVE);

//  window.onmousemove= displayCoords;
//  window.onclick = fnRevert;
  
   function displayCoords(event) 
	 {
				var move_Element = document.getElementById('Drag_content').style;
				if(!event){
						move_Element.left = e.pageX +'px' ;
						move_Element.top = e.pageY+10 + 'px';	
				}
				else{
						move_Element.left = event.clientX +'px' ;
					    move_Element.top = event.clientY+10 + 'px';	
				}
	}
  
	  function fnRevert(e)
	  {
		  	if(e.button == 2){
				document.getElementById('Drag_content').style.display = 'none';
				hideAll = false;
				parentId = "Head";
	    		parentName = "DEPARTMENTS";
			    childId ="NULL";
	    		childName = "NULL";
			}
	}

</script>

<table border=0 cellspacing=0 cellpadding=2 width=100% >
	<tr>
		<td colspan="2">
			<table border=0 cellspacing=0 cellpadding=5>
				<tr>
					<td class="big" nowrap><strong><?php echo $this->_tpl_vars['MOD']['LBL_LIST_FOLDERS_CREATED']; ?>
</strong></td>
					<td class="small" align=right>&nbsp;</td>
				</tr>
			</table>
			<hr>
		</td>
	</tr>
	<tr>
		<td>
			<div id='RoleTreeFull'  onMouseMove="displayCoords(event)"> 
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'FolderTree.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		    </div>
		</td>
		<td>	
			<div style="display:none;width:350px;" id="orgLay" class="layerPopup" >
			<script language="JavaScript" type="text/javascript" src="include/js/folder.js"></script>

				<form name="ajoutDossier">
				<table  cellspacing=0 cellpadding=0 border=0 width=80%>
					<tr>
						<td class="genHeaderSmall" align="center"><?php echo $this->_tpl_vars['MOD']['LBL_ADD_NEW_FOLDER']; ?>
</td>
					</tr>
					<tr>
						<td class="small">
							<table border=0 celspacing=0 cellpadding=5 width=100% align=center >
							<tr>
								<td align="right" nowrap class="cellLabel small"><font color="red">*</font>&nbsp;<b><?php echo $this->_tpl_vars['MOD']['LBL_FOLDER_NAME']; ?>
</b></td>
								<td align="left" class="cellText small">
									<input id="folder_id" name="folderId" type="hidden" value=''>
									<input id="fldrsave_mode" name="folderId" type="hidden" value='save'>
									<input id="folder_name" name="folderName" class="txtBox" type="text" MAXLENGTH=20><br>Maximum 20
								</td>
							</tr>
							<tr>
								<td class="cellLabel small" align="right" nowrap><b><?php echo $this->_tpl_vars['MOD']['LBL_FOLDER_DESC']; ?>
</b></td>
								<td class="cellText small" align="left"><input id="folder_desc" name="folderDesc" class="txtBox" type="text" MAXLENGTH=50><br>Maximum 50</td>
							 </tr>
							 <tr>
								<td class="cellLabel small" align="right" nowrap><b><?php echo $this->_tpl_vars['MOD']['LBL_FOLDER_FATHER']; ?>
</b></td>
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
							<input name="save" value=" &nbsp;<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
&nbsp; " class="crmbutton small save" onClick="AddFolder();" type="button">&nbsp;&nbsp;
							<input name="cancel" value=" <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
 " class="crmbutton small cancel" onclick="closeFolderCreate();" type="button">
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
	 {
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
	}
	
	function put_child_ID(currObj)
	{
			var move_Element = $('Drag_content');
	 		parentName  = $(currObj).innerHTML;
			parentId = currObj;
			move_Element.style.display = 'none';
			hideAll = false;	
			if(childId == "NULL")
			{
//				alert("Please Select the Node");
				parentId = parentId.replace(/user_/gi,'');
				window.location.href="index.php?module=Settings&action=RoleDetailView&parenttab=Settings&roleid="+parentId;
			}
			else
			{
				childId = childId.replace(/user_/gi,'');
				parentId = parentId.replace(/user_/gi,'');
				new Ajax.Request(
  					'index.php',
				        {queue: {position: 'end', scope: 'command'},
					        method: 'post',
					        postBody: 'module=Users&action=UsersAjax&file=RoleDragDrop&ajax=true&parentId='+parentId+'&childId='+childId,
						onComplete: function(response) {
							if(response.responseText != alert_arr.ROLE_DRAG_ERR_MSG)
							{
						                $('RoleTreeFull').innerHTML=response.responseText;
						                hideAll = false;
							        parentId = "";
						                parentName = "";
						                childId ="NULL";
								childName = "NULL";
						        }
						        else
						                alert(response.responseText);
			                        }
				        }
				);
			}
	}

	function fnVisible(Obj)
	{
			if(!hideAll)
				document.getElementById(Obj).style.visibility = 'visible';
	}

	function fnInVisible(Obj)
	{
		document.getElementById(Obj).style.visibility = 'hidden';
	}

	function addForder(forderid,foldername)
	{
		document.getElementById("addFolder").style.display = 'block';
		document.getElementById("folderFatherName").innerHTML=foldername;
		document.form['ajoutDossier'].folderFatherId.value=folderid;
		//window.open("modules/HReports/addFolder.php?record"+forderid+"&parenttab=Espace Rapportage","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=300, height=300");
		
	}
	
	function CancelAddForder()
	{
		document.getElementById("addFolder").style.display = 'none';
	}
	
	function saveFolder()
	{
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
				        {queue: {position: 'end', scope: 'command'},
					        method: 'post',
					        postBody: 'module=Users&action=UsersAjax&file=RoleDragDrop&ajax=true&parentId='+parentId+'&childId='+childId,
						onComplete: function(response) {
							if(response.responseText != alert_arr.ROLE_DRAG_ERR_MSG)
							{
						                $('RoleTreeFull').innerHTML=response.responseText;
						                hideAll = false;
							        parentId = "";
						                parentName = "";
						                childId ="NULL";
								childName = "NULL";
						        }
						        else
						                alert(response.responseText);
			                        }
				        }
				);*/
	}

function showhide(argg,imgId)
{
	var harray=argg.split(",");
	var harrlen = harray.length;	
	var i;
	for(i=0; i<harrlen; i++)
	{
		var x=document.getElementById(harray[i]).style;
        	if (x.display=="none")
        	{
           		x.display="block";
			document.getElementById(imgId).src="<?php echo vtiger_imageurl('minus.gif', $this->_tpl_vars['THEME']); ?>
";
         	}
        	else
		{
			x.display="none";
			document.getElementById(imgId).src="<?php echo vtiger_imageurl('plus.gif', $this->_tpl_vars['THEME']); ?>
";
		}
	}
}

function showhide2(argg,imgId,dossierId)
{
	var harray=argg.split(",");
	var harrlen = harray.length;	
	var i;
	for(i=0; i<harrlen; i++)
	{
		var x=document.getElementById(harray[i]).style;
        	if (x.display=="none")
        	{
           		x.display="block";
			document.getElementById(imgId).src="<?php echo vtiger_imageurl('minus.gif', $this->_tpl_vars['THEME']); ?>
";
			document.getElementById(dossierId).src="<?php echo vtiger_imageurl('dossier-ouvert.gif', $this->_tpl_vars['THEME']); ?>
";
         	}
        	else
		{
			x.display="none";
			document.getElementById(imgId).src="<?php echo vtiger_imageurl('plus.gif', $this->_tpl_vars['THEME']); ?>
";
			document.getElementById(dossierId).src="<?php echo vtiger_imageurl('dossier-ferme.gif', $this->_tpl_vars['THEME']); ?>
";
		}
	}
}

</script>