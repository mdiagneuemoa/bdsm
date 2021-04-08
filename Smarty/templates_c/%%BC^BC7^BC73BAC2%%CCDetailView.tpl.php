<?php /* Smarty version 2.6.18, created on 2018-11-22 19:33:57
         compiled from CCDetailView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'CCDetailView.tpl', 204, false),array('modifier', 'replace', 'CCDetailView.tpl', 1050, false),array('modifier', 'number_format', 'CCDetailView.tpl', 1506, false),array('modifier', 'count', 'CCDetailView.tpl', 1655, false),array('modifier', 'getTranslatedString', 'CCDetailView.tpl', 1815, false),)), $this); ?>
<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>

<script type="text/javascript" src="include/js/reflection.js"></script>
<script src="include/scriptaculous/scriptaculous.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="include/js/dtlviewajax.js"></script>

<!--
<span id="crmspanid" style="display:none;position:absolute;"  onmouseover="show('crmspanid');">
   <a class="link"  align="right" href="javascript:;"><?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON']; ?>
</a>
</span>
-->
<div id="convertleaddiv" style="display:block;position:absolute;left:225px;top:150px;"></div>
<script>
<?php echo '
var gVTModule = \'{$smarty.request.module}\';
function callConvertLeadDiv(id)
{
        new Ajax.Request(
                \'index.php\',
                {queue: {position: \'end\', scope: \'command\'},
                        method: \'post\',
                        postBody: \'module=Leads&action=LeadsAjax&file=ConvertLead&record=\'+id,
                        onComplete: function(response) {
                                $("convertleaddiv").innerHTML=response.responseText;
				eval($("conv_leadcal").innerHTML);
                        }
                }
        );
}
function showHideStatus(sId,anchorImgId,sImagePath)
{
	oObj = eval(document.getElementById(sId));
	if(oObj.style.display == \'block\')
	{
		oObj.style.display = \'none\';
		eval(document.getElementById(anchorImgId)).src =  \'themes/images/inactivate.gif\';
		eval(document.getElementById(anchorImgId)).alt = \'Display\';
		eval(document.getElementById(anchorImgId)).title = \'Display\';
	}
	else
	{
		oObj.style.display = \'block\';
		eval(document.getElementById(anchorImgId)).src = \'themes/images/activate.gif\';
		eval(document.getElementById(anchorImgId)).alt = \'Hide\';
		eval(document.getElementById(anchorImgId)).title = \'Hide\';
	}
}
<!-- End Of Code modified by SAKTI on 10th Apr, 2008 -->

<!-- Start of code added by SAKTI on 16th Jun, 2008 -->
function setCoOrdinate(elemId){
	oBtnObj = document.getElementById(elemId);
	var tagName = document.getElementById(\'lstRecordLayout\');
	leftpos  = 0;
	toppos = 0;
	aTag = oBtnObj;
	do{					  
	  leftpos  += aTag.offsetLeft;
	  toppos += aTag.offsetTop;
	} while(aTag = aTag.offsetParent);
	
	tagName.style.top= toppos + 20 + \'px\';
	tagName.style.left= leftpos - 276 + \'px\';
}

function getListOfRecords(obj, sModule, iId,sParentTab)
{
		new Ajax.Request(
		\'index.php\',
		{queue: {position: \'end\', scope: \'command\'},
			method: \'post\',
			postBody: \'module=Users&action=getListOfRecords&ajax=true&CurModule=\'+sModule+\'&CurRecordId=\'+iId+\'&CurParentTab=\'+sParentTab,
			onComplete: function(response) {
				sResponse = response.responseText;
				$("lstRecordLayout").innerHTML = sResponse;
				Lay = \'lstRecordLayout\';	
				var tagName = document.getElementById(Lay);
				var leftSide = findPosX(obj);
				var topSide = findPosY(obj);
				var maxW = tagName.style.width;
				var widthM = maxW.substring(0,maxW.length-2);
				var getVal = parseInt(leftSide) + parseInt(widthM);
				if(getVal  > document.body.clientWidth ){
					leftSide = parseInt(leftSide) - parseInt(widthM);
					tagName.style.left = leftSide + 230 + \'px\';
					tagName.style.top = topSide + 20 + \'px\';
				}else{
					tagName.style.left = leftSide + 230 + \'px\';
				}
				setCoOrdinate(obj.id);
				
				tagName.style.display = \'block\';
				tagName.style.visibility = "visible";
			}
		}
	);
}
<!-- End of code added by SAKTI on 16th Jun, 2008 -->
'; ?>

function BackupDocument(form,id,folderid)
{
	if(confirm("<?php echo $this->_tpl_vars['MOD']['LBL_MSG_BACKUP']; ?>
"))
	{
		
		form.return_module.value='Documents'; 
		form.return_action.value='DetailView';
		form.module.value='Documents';
		form.action.value='ListView';
		form.idToBackup.value=id;
		form.folderid.value=folderid;
		form.submit();
		
	}
}

function BackupRapport(form,id,folderid)
{
	if(confirm("Attention!! vous etes sur le point d'archiver ce rapport.\n Une fois fait, il ne sera disponible qu'en consultation."))
	{
	
		form.return_module.value='HReports'; 
		form.return_action.value='DetailView';
		form.module.value='HReports';
		form.action.value='ListView';
		form.folderid.value=folderid;
		form.idToBackup.value=id;
		form.submit();
		
	}
}


function tagvalidate()
{
	if(trim(document.getElementById('txtbox_tagfields').value) != '')
		SaveTag('txtbox_tagfields','<?php echo $this->_tpl_vars['ID']; ?>
','<?php echo $this->_tpl_vars['MODULE']; ?>
');	
	else
	{
		alert("<?php echo $this->_tpl_vars['APP']['PLEASE_ENTER_TAG']; ?>
");
		return false;
	}
}
function DeleteTag(id,recordid)
{
	$("vtbusy_info").style.display="inline";
	Effect.Fade('tag_'+id);
	new Ajax.Request(
		'index.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: "file=TagCloud&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['MODULE']; ?>
Ajax&ajxaction=DELETETAG&recordid="+recordid+"&tagid=" +id,
                        onComplete: function(response) {
						getTagCloud();
						$("vtbusy_info").style.display="none";
                        }
                }
        );
}




//Added to send a file, in Documents module, as an attachment in an email
function sendfile_email()
{
	filename = $('dldfilename').value;
	document.DetailView.submit();
	OpenCompose(filename,'Documents');
}

</script>

<div id="lstRecordLayout" class="layerPopup" style="display:none;width:325px;height:300px;"></div>



<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr>
	<td>
		<?php if ($this->_tpl_vars['MODULE'] == 'Candidats'): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Candidats_Buttons_List.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php else: ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Buttons_List.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php endif; ?>
<!-- Contents -->
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
<tr>
	<!--<td valign=top><img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
"></td>-->
	<td class="showPanelBg" valign=top width=100%>
		<!-- PUBLIC CONTENTS STARTS-->
		<div id="pos" class="small" style="padding:10px" >
		
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%">
			<tr><td>		
		  				 		<span class="dvHeaderText">
				<?php if ($this->_tpl_vars['MODULE'] == 'Documents' || $this->_tpl_vars['MODULE'] == 'HReports'): ?>
					<!-- Pour retourner au dossier du document Hodar CRM -->
					<a href="index.php?action=ListView&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
&folderid=<?php echo $this->_tpl_vars['FOLDERID']; ?>
">
					<img src="<?php echo vtiger_imageurl('dossier-ouvert.gif', $this->_tpl_vars['THEME']); ?>
" border=0>&nbsp;<?php echo $this->_tpl_vars['FOLDERNAME']; ?>
</a> >
				<?php endif; ?>
						 	</td></tr>
		 </table>			 
		<br>
		
		<!-- Account details tabs -->
		<table border=0 cellspacing=0 cellpadding=0 width=95% align=center>
		<?php if ($this->_tpl_vars['MODULE'] == 'Candidats' && $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == '50'): ?>
			<tr><td colspan=2><marquee direction="left" color="red"><font color="red">Dernier d&eacute;lai pour enregister votre candidature &agrave; l'&eacute;dition <?php echo $this->_tpl_vars['BOURSEEDITION']; ?>
, <?php echo $this->_tpl_vars['DELAICANDIDATURE']; ?>
.</font></MARQUEE>
		<?php endif; ?>
		<tr>
			<td>
				<form action="index.php" method="post" name="DetailView" id="form1">
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'DetailViewHidden.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	  
				<input type="hidden" name="validation">
				<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
				<tr>
					<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
					
					<td class="dvtSelectedCell" align=center nowrap><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['SINGLE_MOD']]; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</td>	
					<td class="dvtTabCache" style="width:10px"></td>
									
					
					<td class="dvtTabCache" align="right" style="width:100%">
                    
									
					<?php if ($this->_tpl_vars['MODULE'] == 'Demandes'): ?>
					
					

							<?php if (( $this->_tpl_vars['IS_CHARGEMISSIONDEMANDE'] == '1' ) && ( $this->_tpl_vars['STATUT'] == 'submitted' && ( $this->_tpl_vars['STATUT'] != 'ag_cancelled' && $this->_tpl_vars['STATUT'] != 'ch_cancelled' && $this->_tpl_vars['STATUT'] != 'dir_cancelled' ) )): ?>
					
								<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_ANNULER_CHARGEMISSION_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementDemandes';
												this.form.action.value='EditView';
												this.form.statut.value='ch_cancelled';
												this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
												return AnnulerDemande('Demandes');"
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_ANNULER_CHARGEMISSION_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
							<?php endif; ?>
							<?php if (( $this->_tpl_vars['IS_POSTEURDEMANDE'] == '1' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '20' ) && ( $this->_tpl_vars['STATUT'] != 'ag_cancelled' && $this->_tpl_vars['STATUT'] != 'ch_cancelled' && $this->_tpl_vars['STATUT'] != 'dir_cancelled' )): ?>
								<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_ANNULER_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementDemandes';
												this.form.action.value='EditView';
												this.form.statut.value='ag_cancelled';
												this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
												return AnnulerDemande('Demandes');"
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_ANNULER_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
						
								<?php if ($this->_tpl_vars['STATUT'] == 'umv_denied' || $this->_tpl_vars['STATUT'] == 'open'): ?>
						
										<?php if ($this->_tpl_vars['ISDEMREJETPOURHORSDELAI'] == '1'): ?>
											<input 
												title="<?php echo $this->_tpl_vars['MOD']['LBL_SOUMETTRE_HORSDELAI_BUTTON_LABEL']; ?>
" 
												class="crmbutton small edit" 
												onclick="this.form.return_module.value='Demandes'; 
													this.form.return_action.value='DetailView'; 
													this.form.module.value='TraitementDemandes';
													this.form.action.value='Save';
													this.form.statut.value='submitted_outdeadline';
													this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
													return soumettreDemandeHorsDelai('Demandes');"   
												type="submit" 
												name="Edit" 
												value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_SOUMETTRE_HORSDELAI_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
										<?php endif; ?>
							
										<?php if ($this->_tpl_vars['ISDEMREJETPOURHORSBUDGET'] == '1'): ?>
											<input 
													title="<?php echo $this->_tpl_vars['MOD']['LBL_SOUMETTRE_HORSBUDGET_BUTTON_LABEL']; ?>
" 
													class="crmbutton small edit" 
													onclick="this.form.return_module.value='Demandes'; 
														this.form.return_action.value='DetailView'; 
														this.form.module.value='TraitementDemandes';
														this.form.action.value='Save';
														this.form.statut.value='submitted_outbudget';
														this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
														return soumettreDemandeHorsBudget('Demandes');"   
													type="submit" 
													name="Edit" 
													value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_SOUMETTRE_HORSBUDGET_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
										<?php endif; ?>
							
								<?php endif; ?>
								<?php if ($this->_tpl_vars['STATUT'] == 'open'): ?>
						
									<input title="<?php echo $this->_tpl_vars['MOD']['LBL_SOUMETTRECC_BUTTON_LABEL']; ?>
" class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementDemandes';
												this.form.action.value='Save';
												this.form.statut.value='submitted';
												this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
												return soumettreDemande('Demandes');"   
										type="submit"  
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_SOUMETTRECC_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
													
									<input title="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_KEY']; ?>
" class="crmbutton small edit" onclick="this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.return_action.value='DetailView'; this.form.return_id.value='<?php echo $this->_tpl_vars['ID']; ?>
';this.form.module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
';this.form.action.value='EditView'" type="submit" name="Edit" value="&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
									<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_DUPPLIQUER_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='Demandes';
												this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
												this.form.statut.value='open';
												this.form.isDuplicate.value='true';
												this.form.action.value='EditView';" 
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_DUPPLIQUER_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
					
								<?php endif; ?>	
							
						
							<?php endif; ?>	
						<?php if (( $this->_tpl_vars['CURRENT_USER_PROFIL'] == '22' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '20' || $this->_tpl_vars['IS_INTERIMDIRECTEUR'] == '1' ) && $this->_tpl_vars['STATUT'] == 'submitted'): ?>    								<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_ANNULER_SUP_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementDemandes';
												this.form.action.value='EditView';
												this.form.statut.value='dir_cancelled';
												this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
												return AnnulerDemande('Demandes');"
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_ANNULER_SUP_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
										
								<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_REJET_SUP_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementDemandes';
												this.form.action.value='EditView';
												this.form.statut.value='dir_denied';
												this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
												return RejeterDemande('Demandes');"
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_REJET_SUP_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
						
								
										<input 
												title="<?php echo $this->_tpl_vars['MOD']['LBL_VISER_SUP_BUTTON_LABEL']; ?>
" 
												class="crmbutton small edit" 
												onclick="this.form.return_module.value='Demandes'; 
													this.form.return_action.value='DetailView'; 
													this.form.module.value='TraitementDemandes';
													this.form.action.value='Save';
													this.form.statut.value='dir_accepted';
													this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
													return ViserDemande('Demandes');"   
											type="submit"  
											name="Edit" 
												value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_VISER_SUP_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;							
								
					<?php endif; ?>	

					<?php if (( $this->_tpl_vars['CURRENT_USER_PROFIL'] == '22' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '20' || $this->_tpl_vars['IS_INTERIMDIRCAB'] == '1' ) && $this->_tpl_vars['STATUT'] == 'dir_accepted'): ?> 							<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_REJET_SGCC_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementDemandes';
												this.form.action.value='EditView';
												this.form.statut.value='dc_denied';
												this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
												return RejeterDemande('Demandes');"
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_REJET_SGCC_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
																		
							<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_VISER_SGCC_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='TraitementDemandes';
											this.form.action.value='Save';
											this.form.statut.value='com_accepted';
											this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
											return ViserDemande('Demandes');"   
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_VISER_SGCC_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
							<input title="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_KEY']; ?>
" class="crmbutton small edit" onclick="this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.return_action.value='DetailView'; this.form.return_id.value='<?php echo $this->_tpl_vars['ID']; ?>
';this.form.module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
';this.form.action.value='EditView'" type="submit" name="Edit" value="&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;

						<?php endif; ?>
						
						<?php if (( $this->_tpl_vars['CURRENT_USER_PROFIL'] == '26' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '20' || $this->_tpl_vars['IS_INTERIMRUMV'] == '1' )): ?>  								
							<?php if ($this->_tpl_vars['STATUT'] == 'com_accepted'): ?>
								<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_REJET_UMV_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementDemandes';
												this.form.action.value='EditView';
												this.form.statut.value='umv_denied';
												this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
												return RejeterDemande('Demandes');"
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_REJET_UMV_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
																		
								<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_VISER_UMV_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='TraitementDemandes';
											this.form.action.value='Save';
											this.form.statut.value='umv_accepted';
											this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
											return ViserDemande('Demandes');"   
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_VISER_UMV_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
							<?php endif; ?>
							<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_REMISESIGNE_UMV_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='TraitementDemandes';
											this.form.action.value='Save';
											this.form.statut.value='com_accepted';
											this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
											return RemettreasigneDemande('Demandes');"   
										type="submit"
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_REMISESIGNE_UMV_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;	
										
							<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_REMETTREENPREPA_UMV_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementDemandes';
												this.form.action.value='EditView';
												this.form.statut.value='open';
												this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
												return remettreDemande('Demandes');" 
									type="submit"  
									name="Edit"
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_REMETTREENPREPA_UMV_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
						<input title="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_KEY']; ?>
" class="crmbutton small edit" onclick="this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.return_action.value='DetailView'; this.form.return_id.value='<?php echo $this->_tpl_vars['ID']; ?>
';this.form.module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
';this.form.action.value='EditView'" type="submit" name="Edit" value="&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;

						<?php endif; ?>
						<?php if (( $this->_tpl_vars['IS_PRESIDENTCC'] == '1' || $this->_tpl_vars['IS_INTERIMPRESIDENTCC'] == '1' ) && ( $this->_tpl_vars['STATUT'] == 'umv_accepted' || $this->_tpl_vars['STATUT'] == 'submitted_outdeadline' || $this->_tpl_vars['STATUT'] == 'submitted_outbudget' )): ?> 
							<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_REJET_PRCC_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementDemandes';
												this.form.action.value='EditView';
												this.form.statut.value='pr_denied';
												this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
												this.form.reserver.value='true';
												return RejeterDemande('Demandes');" 
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_REJET_PRCC_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
																		
							<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_VISER_PRCC_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='TraitementDemandes';
											this.form.action.value='Save';
											this.form.statut.value='pr_authorized';
											this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
											return ViserDemande('Demandes');"   
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_VISER_PRCC_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
										
						
						<?php endif; ?>
						
												
						<?php if (( $this->_tpl_vars['CURRENT_USER_PROFIL'] == '26' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '20' || $this->_tpl_vars['IS_INTERIMRUMV'] == '1' ) && ( $this->_tpl_vars['STATUT'] == 'pr_authorized' || $this->_tpl_vars['STATUT'] == 'authorized' )): ?>								<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_GENEREROM_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 

										onclick="this.form.return_module.value='OrdresMission'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='OrdresMission';
												this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
												this.form.statut.value='omgenered';
												this.form.opt.value='omgenered';
												this.form.action.value='EditView';
												this.form.mode.value='create_view';" 
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_GENEREROM_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
										
							<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_REMETTREOMGENERE_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='TraitementDemandes';
											this.form.action.value='Save';
											this.form.statut.value='omgenered';
											this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
											return MettreOMgenereDemande('Demandes');"   
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_REMETTREOMGENERE_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;

							<?php endif; ?>
							<?php if (( $this->_tpl_vars['CURRENT_USER_PROFIL'] == '26' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '20' ) && $this->_tpl_vars['STATUT'] == 'omgenered'): ?>									<input title="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_KEY']; ?>
" class="crmbutton small edit" onclick="this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.return_action.value='DetailView'; this.form.return_id.value='<?php echo $this->_tpl_vars['ID']; ?>
';this.form.module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
';this.form.action.value='EditView'" type="submit" name="Edit" value="&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
							<?php endif; ?>							
					<?php endif; ?>
					<?php if ($this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
													
							<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_CANCELMISSION_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementDemandes';
												this.form.action.value='EditView';
												this.form.statut.value='om_cancelled';
												this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
												return AnnulerMission('OrdresMission');"
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_CANCELMISSION_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
										
							<input title="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_KEY']; ?>
" class="crmbutton small edit" onclick="this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.return_action.value='DetailView'; this.form.return_id.value='<?php echo $this->_tpl_vars['ID']; ?>
';this.form.module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
';this.form.action.value='EditView';this.form.mode.value='edit_view'" type="submit" name="Edit" value="&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_MODIF_OM_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;

							<input title="<?php echo $this->_tpl_vars['MOD']['LBL_OMVERSO_BUTTON_LABEL']; ?>
" class="crmbutton small edit" 
										onclick="window.open('http://ouavlibre01/portailnomade/ordremission/ordremissioncc.php?demandeid=<?php echo $this->_tpl_vars['ID']; ?>
','','');return false;"   
										type="submit"  
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_OMRECTOVERSO_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
										
							<input title="<?php echo $this->_tpl_vars['MOD']['LBL_OMDECOMPTE_BUTTON_LABEL']; ?>
" class="crmbutton small edit" 
										onclick="window.open('http://ouavlibre01/portailnomade/ordremission/decomptecc.php?demandeid=<?php echo $this->_tpl_vars['ID']; ?>
','','');return false;"   
										type="submit"  
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_OMDECOMPTE_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
										
														
																
					<?php endif; ?>
					
										
				  					
														
					<?php if ($this->_tpl_vars['MODULE'] == 'TypeDemandes' || $this->_tpl_vars['MODULE'] == 'TypeIncidents'): ?>
						 
						 <?php if ($this->_tpl_vars['EDIT_PERMISSION'] == 'yes'): ?>
							<input title="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_KEY']; ?>
" class="crmbutton small edit" onclick="this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.return_action.value='DetailView'; this.form.return_id.value='<?php echo $this->_tpl_vars['ID']; ?>
';this.form.module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
';this.form.action.value='EditView'" type="submit" name="Edit" value="&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
						<?php endif; ?>
						 <?php if ($this->_tpl_vars['DELETE'] == 'permitted'): ?>
							<input title="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_KEY']; ?>
" class="crmbutton small delete" onclick="this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.return_action.value='index'; this.form.action.value='Delete'; <?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?> return confirm('<?php echo $this->_tpl_vars['APP']['NTC_ACCOUNT_DELETE_CONFIRMATION']; ?>
') <?php else: ?> return confirm('<?php echo $this->_tpl_vars['APP']['NTC_DELETE_CONFIRMATION']; ?>
') <?php endif; ?>" type="submit"  name="Delete" value="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_LABEL']; ?>
">&nbsp;
						<?php endif; ?>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['CURRENT_USER_PROFIL_ID'] != '50'): ?>
						<?php if ($this->_tpl_vars['privrecord'] != ''): ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" onclick="location.href='index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&viewtype=<?php echo $this->_tpl_vars['VIEWTYPE']; ?>
&action=DetailView&record=<?php echo $this->_tpl_vars['privrecord']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
'" name="privrecord" value="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" src="<?php echo vtiger_imageurl('rec_prev.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
						<?php else: ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" src="<?php echo vtiger_imageurl('rec_prev_disabled.gif', $this->_tpl_vars['THEME']); ?>
">
						<?php endif; ?>							
						<?php if ($this->_tpl_vars['privrecord'] != '' || $this->_tpl_vars['nextrecord'] != ''): ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LBL_JUMP_BTN']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_JUMP_BTN']; ?>
" onclick="var obj = this;var lhref = getListOfRecords(obj, '<?php echo $this->_tpl_vars['MODULE']; ?>
',<?php echo $this->_tpl_vars['ID']; ?>
,'<?php echo $this->_tpl_vars['CATEGORY']; ?>
');" name="jumpBtnIdTop" id="jumpBtnIdTop" src="<?php echo vtiger_imageurl('rec_jump.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
						<?php endif; ?>
						<?php if ($this->_tpl_vars['nextrecord'] != ''): ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" onclick="location.href='index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&viewtype=<?php echo $this->_tpl_vars['VIEWTYPE']; ?>
&action=DetailView&record=<?php echo $this->_tpl_vars['nextrecord']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
'" name="nextrecord" src="<?php echo vtiger_imageurl('rec_next.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
						<?php else: ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" src="<?php echo vtiger_imageurl('rec_next_disabled.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
						<?php endif; ?>
					<?php endif; ?>	
					
				</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td valign=top align=left >                
				 <table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace" style="border-bottom:0;">
				<tr>

					<td align=left>
					<!-- content cache -->
					
				<table border=0 cellspacing=0 cellpadding=0 width=100%>
				<tr><td> 
			 <div id="divaddprodfin" style="display:none;">
			 <input type="hidden" id="numconvention" value=<?php echo $this->_tpl_vars['TICKET']; ?>
></input>
				 <table border=0 cellspacing=1 cellpadding=3 width=100% class="lvt small">
					<tr>
		 				<td class="big3" colspan=5>Ajout d'un produit financier</td>
					</tr>
					<tr>
						<td class="lvtCol">Libell&eacute;</td>
		 				<td class="lvtCol">montant</td>
		 				<td class="lvtCol">Date Effet</td>
		 				<td class="lvtCol">Date Saisie</td>
					</tr>
					<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
					<td><input name="libelleprodfin"  id="libelleprodfin" class="detailedViewTextBox"  type="text" value=""/></td>
					<td><input name="montantprodfin" id="montantprodfin"  class="detailedViewTextBox"  type="text" value=""/></td>
					<td><input name="dateeffetprodfin" id="jscal_field_dateeffetprodfin" type="text" style="border:1px solid #bababa;" size="11" maxlength="10" value="<?php echo $this->_tpl_vars['date_val']; ?>
">
						<img src="<?php echo vtiger_imageurl('btnL3Calendar.gif', $this->_tpl_vars['THEME']); ?>
" id="jscal_trigger_dateeffetprodfin">
					</td>
					<td><input name="dateprodfin" id="jscal_field_dateprodfin" type="text" style="border:1px solid #bababa;" size="11" maxlength="10" value="<?php echo $this->_tpl_vars['date_val']; ?>
">
						<img src="<?php echo vtiger_imageurl('btnL3Calendar.gif', $this->_tpl_vars['THEME']); ?>
" id="jscal_trigger_dateprodfin">
					</td>
					</tr>
					<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
						<td colspan="4" align="center">
							<input type="button" name="submit1" value="Enregister" onclick="saveaddprofin()" >
							<input type="button" name="cancel" value="Annuler" onclick="canceladdprofin()">

						</td>
					</tr>
				</table>
					<script type="text/javascript" id='massedit_calendar_dateeffetprodfin'>
					Calendar.setup ({
						inputField : "jscal_field_dateeffetprodfin", ifFormat : "%d-%m-%Y", showsTime : false, button : "jscal_trigger_dateeffetprodfin", singleClick : true, step : 1
					})
				</script>
				<script type="text/javascript" id='massedit_calendar_dateprodfin'>
					Calendar.setup ({
						inputField : "jscal_field_dateprodfin", ifFormat : "%d-%m-%Y", showsTime : false, button : "jscal_trigger_dateprodfin", singleClick : true, step : 1
					})
				</script>
			</div>
			</td>
			</tr>	
			</form>
			<form action="index.php" method="post" name="DetailView" id="form3">
			<?php if ($this->_tpl_vars['MODULE'] == 'OrdresMission' && ( $this->_tpl_vars['STATUTOM'] == 'om_cancelled' || $this->_tpl_vars['STATUTOM'] == 'dcpc_omcancelled' )): ?>
					<tr><td  class="omcancelled" width=180 height=40><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['STATUTOM']]; ?>
</td></tr>
			<?php endif; ?>	
		<?php if ($this->_tpl_vars['MODULE'] == 'Demandes'): ?>
			<?php if ($this->_tpl_vars['STATUT'] == 'open'): ?>
	
					<tr><td align="left" ><img src="<?php echo vtiger_imageurl('open_cc.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
		
			<?php endif; ?>	
			<?php if ($this->_tpl_vars['STATUT'] == 'submitted'): ?>
				
					<tr><td align="left" ><img src="<?php echo vtiger_imageurl('submitted_cc.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			
			<?php endif; ?>	
			<?php if ($this->_tpl_vars['STATUT'] == 'dir_accepted'): ?>
				
					<tr><td align="left" ><img src="<?php echo vtiger_imageurl('dir_accepted_cc.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			
			<?php endif; ?>
			<?php if ($this->_tpl_vars['STATUT'] == 'dir_cancelled' || $this->_tpl_vars['STATUT'] == 'dir_denied'): ?>
				
					<tr><td align="left" ><img src="<?php echo vtiger_imageurl('dir_denied_cc.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			
			<?php endif; ?>
			<?php if ($this->_tpl_vars['STATUT'] == 'dc_accepted'): ?>
			
					<tr><td align="left" ><img src="<?php echo vtiger_imageurl('dc_accepted_cc.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			
			<?php endif; ?>
			<?php if ($this->_tpl_vars['STATUT'] == 'dc_cancelled' || $this->_tpl_vars['STATUT'] == 'dc_denied'): ?>
				
					<tr><td align="left" ><img src="<?php echo vtiger_imageurl('dc_denied_cc.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			
			<?php endif; ?>
			<?php if ($this->_tpl_vars['STATUT'] == 'com_accepted' || $this->_tpl_vars['STATUT'] == 'pr_accepted'): ?>
				
					<tr><td align="left" ><img src="<?php echo vtiger_imageurl('com_accepeted_cc.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			
			<?php endif; ?>
			<?php if ($this->_tpl_vars['STATUT'] == 'com_cancelled' || $this->_tpl_vars['STATUT'] == 'com_denied' || $this->_tpl_vars['STATUT'] == 'pr_denied'): ?>
				
					<tr><td align="left" ><img src="<?php echo vtiger_imageurl('com_denied_cc.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
				
			<?php endif; ?>
			<?php if ($this->_tpl_vars['STATUT'] == 'umv_denied'): ?>
				
					<tr><td align="left" ><img src="<?php echo vtiger_imageurl('umv_denied_cc.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
				
			<?php endif; ?>
			
			<?php if ($this->_tpl_vars['STATUT'] == 'umv_accepted'): ?>
				
					<tr><td align="left" ><img src="<?php echo vtiger_imageurl('umv_accepted_cc.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			
			<?php endif; ?>
			<?php if ($this->_tpl_vars['STATUT'] == 'omgenered'): ?>
				
					<tr><td align="left" ><img src="<?php echo vtiger_imageurl('omgenered_cc.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			
			<?php endif; ?>
			<?php if ($this->_tpl_vars['STATUT'] == 'authorized' || $this->_tpl_vars['STATUT'] == 'pr_authorized'): ?>
				
					<tr><td align="left" ><img src="<?php echo vtiger_imageurl('authorized_cc.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
				
			<?php endif; ?>
			<?php if ($this->_tpl_vars['STATUT'] == 'dcpc_denied' || $this->_tpl_vars['STATUT'] == 'dcpc_cancelled' || $this->_tpl_vars['STATUT'] == 'pr_denied'): ?>
				
					<tr><td align="left" ><img src="<?php echo vtiger_imageurl('dcpc_denied_cc.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			
			<?php endif; ?>
		<?php endif; ?>
		
		<?php if ($this->_tpl_vars['MODULE'] == 'Candidats' && $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == '50'): ?>
				<tr><td align="right" class="big4">Bonjour, <b><?php echo $this->_tpl_vars['CURRENT_USER_NOMPRENOM']; ?>
</b></td></tr>
				<tr><td class="info" >Veillez mettre &agrave; jour si n&eacute;cessaire vos informations via le boutton "Editer".<br> Une fois vos informations compl&eacutetées, vous devez valider votre inscription afin de confirmer votre candidature.<br>
				Passer le d&eacute;lai de souscription, vous ne pourrez plus modifier vos informations. </td></tr>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
				<tr><td align="right" class="big4">Bonjour, <b><?php echo $this->_tpl_vars['CURRENT_USER_NOMPRENOM']; ?>
</b></td></tr>
				<tr><td class="info" >Veillez compl&eacute;ter vos informations en cliquant sur le boutton "Editer".<br> Si certaines informations non
				modifiables vous sembles erron&eacute;es, veillez vous rapprocher de la DRH.Les agents de la DRH se chargeront de les v&eacute;rifier et les mettre &agrave; jour au besoin.</td></tr>
		<?php endif; ?>
                <tr>
					<td style="padding:5px">
					<!-- Command Buttons -->
				  	<table border=0 cellspacing=0 cellpadding=0 width=100%>
							 
							  <!-- Start of File Include by SAKTI on 10th Apr, 2008 -->
							 <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "./include/DetailViewBlockStatus.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

							 <!-- Start of File Include by SAKTI on 10th Apr, 2008 -->

							<?php $_from = $this->_tpl_vars['BLOCKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['detail']):
?>

							<!-- Detailed View Code starts here-->
							<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
							<!--tr>
				                            <td>&nbsp;</td>
				                            <td>&nbsp;</td>
				                            <td>&nbsp;</td>
							
							</tr-->
					<!--div id="savetraitbut" style="display:none" align=center >
						<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="traitementbut" onclick="this.form.action.value='SaveTraitement';" type="submit" " name="button" value="Enregistrer Livraison" >
					</div-->
							<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr>
											<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
										
								
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES2'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="banqueAgent2header" style="<?php echo $this->_tpl_vars['DISPLAY_COORDBANK2']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES3'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="banqueAgent3header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES4'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="banqueAgent4header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
									</tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES5'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="banqueAgent5header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
									 </tr>
								
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_MERE'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="donneesmereheader" >		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
									 </tr>
								
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_CONJOINT'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="donnesconjointheader" style="<?php echo $this->_tpl_vars['DISPLAY_CONJOINT']; ?>
">		
									<td colspan=4 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT1'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="donneesenfant1header" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT1']; ?>
">		
									<td colspan=4 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT2'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="donneesenfant2header" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT2']; ?>
">		
									<td colspan=4 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
									</tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT3'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="donneesenfant3header" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT3']; ?>
">		
									<td colspan=4 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT4'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="donneesenfant4header" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT4']; ?>
">		
									<td colspan=4 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
									</tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT5'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="donneesenfant5header" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT5']; ?>
">		
									<td colspan=4 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT6'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="donneesenfant6header" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT6']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
								 </tr>
								 <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_CHOIX_ETABLISSEMENT_2'] && $this->_tpl_vars['MODULE'] == 'Candidats'): ?>
									<tr id="donneesenfant6header" style="<?php echo $this->_tpl_vars['DISPLAY_ETABLISSEMENT2']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
								 </tr>
								 <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_CHOIX_ETABLISSEMENT_3'] && $this->_tpl_vars['MODULE'] == 'Candidats'): ?>
									<tr id="donneesenfant6header" style="<?php echo $this->_tpl_vars['DISPLAY_ETABLISSEMENT3']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
								 </tr>
								 <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_2'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="donneesdem2" style="<?php echo $this->_tpl_vars['DISPLAY_DEMANDE2']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
									<td id="statutdem2" class="detailedViewHeader" align="right" style="display:none">
										<select name="statutdemande2" id="statutdemande2"  tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" onchange="showformtraintement2();" class="small" >
											<option value="1">Livr&eacute;</option>
											<option selected value="0">Non Livr&eacute;</option>
										</select>
									</td>	
									<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_2'] && $this->_tpl_vars['DISPLAY_LIVRAISON2']['statut'] == '1' && $this->_tpl_vars['MODULE'] == 'Demandes' && $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == 20): ?>
											<td align="right" ><img src="<?php echo vtiger_imageurl('delivered.png', $this->_tpl_vars['THEME']); ?>
"></td>
									<?php endif; ?>
								 </tr>
								  <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_3'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="donneesdem3" style="<?php echo $this->_tpl_vars['DISPLAY_DEMANDE3']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
									<td id="statutdem3" class="detailedViewHeader" align="right" style="display:none">
										<select name="statutdemande3" id="statutdemande3"  tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" class="small" onchange="showformtraintement3();">
											<option value="1">Livr&eacute;</option>
											<option selected value="0">Non Livr&eacute;</option>
										</select>
									</td>
									<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_3'] && $this->_tpl_vars['DISPLAY_LIVRAISON3']['statut'] == '1' && $this->_tpl_vars['MODULE'] == 'Demandes' && $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == 20): ?>
											<td align="right" ><img src="<?php echo vtiger_imageurl('delivered.png', $this->_tpl_vars['THEME']); ?>
"></td>
									<?php endif; ?>	
								 </tr>
								  <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_4'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="donneesdem4" style="<?php echo $this->_tpl_vars['DISPLAY_DEMANDE4']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
									<td id="statutdem4" class="detailedViewHeader" align="right" style="display:none">
										<select name="statutdemande4" id="statutdemande4"   tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" class="small" onchange="showformtraintement4();">
											<option value="1">Livr&eacute;</option>
											<option selected value="0">Non Livr&eacute;</option>
										</select>
									</td>
									<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_4'] && $this->_tpl_vars['DISPLAY_LIVRAISON4']['statut'] == '1' && $this->_tpl_vars['MODULE'] == 'Demandes' && $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == 20): ?>
											<td align="right" ><img src="<?php echo vtiger_imageurl('delivered.png', $this->_tpl_vars['THEME']); ?>
"></td>
									<?php endif; ?>
								 </tr>
								  <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_5'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="donneesdem5" style="<?php echo $this->_tpl_vars['DISPLAY_DEMANDE5']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
									<td id="statutdem5" class="detailedViewHeader" align="right" style="display:none">
										<select name="statutdemande5" id="statutdemande5"  tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" class="small" onchange="showformtraintement5();">
											<option value="1">Livr&eacute;</option>
											<option selected value="0">Non Livr&eacute;</option>
										</select>
									</td>
									<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_5'] && $this->_tpl_vars['DISPLAY_LIVRAISON5']['statut'] == '1' && $this->_tpl_vars['MODULE'] == 'Demandes' && $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == 20): ?>
											<td align="right" ><img src="<?php echo vtiger_imageurl('delivered.png', $this->_tpl_vars['THEME']); ?>
"></td>
									<?php endif; ?>
								 </tr>
								 
								 								 
								  <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_LIGNE_BUDGETAIRE_2'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="lignebudget2header" style="<?php echo $this->_tpl_vars['DISPLAY_LIGNEBUDGET2']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
								 </tr>
								 <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_LIGNE_BUDGETAIRE_3'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="lignebudget3header" style="<?php echo $this->_tpl_vars['DISPLAY_LIGNEBUDGET3']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
								 </tr>
								 <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_LIGNE_BUDGETAIRE_4'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="lignebudget4header" style="<?php echo $this->_tpl_vars['DISPLAY_LIGNEBUDGET4']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
								 </tr>
								 <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_LIGNE_BUDGETAIRE_5'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="lignebudget5header" style="<?php echo $this->_tpl_vars['DISPLAY_LIGNEBUDGET5']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
								 </tr>
								  <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_FILE_JUSTIFICATIF_2'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="justif2header" style="<?php echo $this->_tpl_vars['DISPLAY_JUSTIFS2']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
								 </tr>

								 
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET2_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet2header" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET2']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
								 </tr>
								 
								 <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET3_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet3header" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET3']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
								 </tr>
								 
								 <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET4_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet4header" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET4']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
								 </tr>
								 
								 <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET5_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet5header" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET5']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
								 </tr>

								 
								 <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET6_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet6header" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET6']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
								 </tr>
								 
								 <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET7_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet7header" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET7']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
								 </tr>
								 
								 <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET8_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet8header" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET8']; ?>
">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
								 </tr>
								  								 
							<!-- This is added to display the existing comments -->
							<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_COMMENTS'] || $this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_COMMENT_INFORMATION']): ?>
							   <tr>
								<td colspan=4 class="dvInnerHeader">
						        	<b><?php echo $this->_tpl_vars['MOD']['LBL_COMMENT_INFORMATION']; ?>
</b>
								</td>
							   </tr>
							   <tr>
							   			<td colspan=4 class="dvtCellInfo"><?php echo $this->_tpl_vars['COMMENT_BLOCK']; ?>
</td>
							   </tr>
							   <!--tr><td>&nbsp;</td></tr-->


						<?php elseif ($this->_tpl_vars['header'] != 'Comments'): ?>
 
						     <tr>
							<?php echo '<td colspan=2 class="dvInnerHeader"><div style="float:left;font-weight:bold;"><div style="float:left;"><a href="javascript:showHideStatus(\'tbl'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?><?php echo '\',\'aid'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?><?php echo '\',\''; ?><?php echo $this->_tpl_vars['IMAGE_PATH']; ?><?php echo '\');">'; ?><?php if ($this->_tpl_vars['BLOCKINITIALSTATUS'][$this->_tpl_vars['header']] == 1): ?><?php echo '<img id="aid'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?><?php echo '" src="'; ?><?php echo vtiger_imageurl('activate.gif', $this->_tpl_vars['THEME']); ?><?php echo '" style="border: 0px solid #000000;" alt="Hide" title="Hide"/>'; ?><?php else: ?><?php echo '<img id="aid'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?><?php echo '" src="'; ?><?php echo vtiger_imageurl('inactivate.gif', $this->_tpl_vars['THEME']); ?><?php echo '" style="border: 0px solid #000000;" alt="Display" title="Display"/>'; ?><?php endif; ?><?php echo '</a></div><b>&nbsp;'; ?><?php echo $this->_tpl_vars['header']; ?><?php echo '</b></div></td>'; ?><?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?><?php echo '<td id="statutdem" class="detailedViewHeader" align="right" style="display:none" ><select name="statutdemande" id="statutdemande"  tabindex="'; ?><?php echo $this->_tpl_vars['vt_tab']; ?><?php echo '" class="small" onchange="showformtraintement1();"><option value="1">Livr&eacute;</option><option selected value="0">Non Livr&eacute;</option></select></td>'; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_INFORMATION'] && $this->_tpl_vars['DISPLAY_LIVRAISON1']['statut'] == '1' && $this->_tpl_vars['MODULE'] == 'Demandes' && $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == 20): ?><?php echo '<td align="right" ><img src="'; ?><?php echo vtiger_imageurl('delivered.png', $this->_tpl_vars['THEME']); ?><?php echo '"></td>'; ?><?php endif; ?><?php echo ''; ?>

					             </tr>
						<?php endif; ?>
					</table>
						<?php if ($this->_tpl_vars['header'] != 'Comments'): ?>
							<?php if ($this->_tpl_vars['BLOCKINITIALSTATUS'][$this->_tpl_vars['header']] == 1): ?>
								<div style="width:auto;display:block;" id="tbl<?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?>
" >
							<?php else: ?>
								<div style="width:auto;display:none;" id="tbl<?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?>
" >
							<?php endif; ?>
							<table border=0 cellspacing=0 cellpadding=0 width="100%" class="small">
							    <?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['detail']):
?>
								<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES2'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="banqueAgent2fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_COORDBANK2']; ?>
 height:25px">	
										
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES3'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="banqueAgent3fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_COORDBANK3']; ?>
 height:25px">	
										
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES4'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="banqueAgent4fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_COORDBANK4']; ?>
 height:25px">	
										
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES5'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="banqueAgent5fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_COORDBANK5']; ?>
 height:25px">	
										
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_CONJOINT'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="conjointAgentfields_<?php echo $this->_tpl_vars['label']; ?>
" style=" <?php echo $this->_tpl_vars['DISPLAY_CONJOINT']; ?>
 height:25px">	
										
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT1'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="enfantAgent1fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT1']; ?>
 height:25px">	
										
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT2'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="enfantAgent2fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT2']; ?>
 height:25px">	
										
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT3'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="enfantAgent3fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT3']; ?>
 height:25px">	
										
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT4'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="enfantAgent4fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT4']; ?>
 height:25px">	
										
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT5'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="enfantAgent5fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT5']; ?>
 height:25px">	
										
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT6'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="enfantAgent6fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT6']; ?>
 height:25px">	
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_CHOIX_ETABLISSEMENT_2'] && $this->_tpl_vars['MODULE'] == 'Candidats'): ?>
									<tr id="enfantAgent6fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_ETABLISSEMENT2']; ?>
 height:25px">	
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_CHOIX_ETABLISSEMENT_3'] && $this->_tpl_vars['MODULE'] == 'Candidats'): ?>
									<tr id="enfantAgent6fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_ETABLISSEMENT3']; ?>
 height:25px">	
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_2'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="demande2fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_DEMANDE2']; ?>
 height:25px">
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_3'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="demande3fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_DEMANDE3']; ?>
 height:25px">
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_4'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="demande4fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_DEMANDE4']; ?>
 height:25px">
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_5'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="demande5fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_DEMANDE5']; ?>
 height:25px">		

																<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_LIGNE_BUDGETAIRE_2'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="lignebudget2fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_LIGNEBUDGET2']; ?>
 height:25px">		
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_LIGNE_BUDGETAIRE_3'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="lignebudget3fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_LIGNEBUDGET3']; ?>
 height:25px">
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_LIGNE_BUDGETAIRE_4'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="lignebudget4fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_LIGNEBUDGET4']; ?>
 height:25px">
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_LIGNE_BUDGETAIRE_5'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="lignebudget5fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_LIGNEBUDGET5']; ?>
 height:25px">
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_FILE_JUSTIFICATIF_2'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="justif2fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_JUSTIFS2']; ?>
 height:25px">	

								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET2_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet2fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET2']; ?>
 height:25px">
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET3_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet3fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET3']; ?>
 height:25px">
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET4_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet4fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET4']; ?>
 height:25px">
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET5_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet5fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET5']; ?>
 height:25px">
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET6_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet6fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET6']; ?>
 height:25px">
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET7_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet7fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET7']; ?>
 height:25px">
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET8_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet8fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET8']; ?>
 height:25px">									
									
								<?php else: ?>
									<tr style="height:25px">
								<?php endif; ?>	
									<?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['label'] => $this->_tpl_vars['data']):
?>
									   <?php $this->assign('keyid', $this->_tpl_vars['data']['ui']); ?>
									   <?php $this->assign('keyval', $this->_tpl_vars['data']['value']); ?>
									   <?php $this->assign('keytblname', $this->_tpl_vars['data']['tablename']); ?>
									   <?php $this->assign('keyfldname', $this->_tpl_vars['data']['fldname']); ?>
									   <?php $this->assign('keyfldid', $this->_tpl_vars['data']['fldid']); ?>
									   <?php $this->assign('keyoptions', $this->_tpl_vars['data']['options']); ?>
									   <?php $this->assign('keysecid', $this->_tpl_vars['data']['secid']); ?>
									   <?php $this->assign('keyseclink', $this->_tpl_vars['data']['link']); ?>
									   <?php $this->assign('keycursymb', $this->_tpl_vars['data']['cursymb']); ?>
									   <?php $this->assign('keysalut', $this->_tpl_vars['data']['salut']); ?>
									   <?php $this->assign('keyaccess', $this->_tpl_vars['data']['notaccess']); ?>
									   <?php $this->assign('keycntimage', $this->_tpl_vars['data']['cntimage']); ?>
									   <?php $this->assign('keyadmin', $this->_tpl_vars['data']['isadmin']); ?>
									   
									   
									   
										<?php if ($this->_tpl_vars['label'] != ''): ?>
										<?php if ($this->_tpl_vars['keycntimage'] != ''): ?>
											<td class="dvtCellLabel" align=right width=25%><input type="hidden" id="hdtxt_IsAdmin" value=<?php echo $this->_tpl_vars['keyadmin']; ?>
></input><?php echo $this->_tpl_vars['keycntimage']; ?>
</td>
										<?php elseif ($this->_tpl_vars['keyid'] == '71' || $this->_tpl_vars['keyid'] == '72'): ?><!-- Currency symbol -->
											<td class="dvtCellLabel" align=right width=25%><?php echo $this->_tpl_vars['label']; ?>
<input type="hidden" id="hdtxt_IsAdmin" value=<?php echo $this->_tpl_vars['keyadmin']; ?>
></input> (<?php echo $this->_tpl_vars['keycursymb']; ?>
)</td>
					
										<?php elseif ($this->_tpl_vars['keyid'] != '53'): ?> <!-- Hodar crm && $keyid neq '27' pour ne pas afficher filelocationtype -->
											<?php if (( $this->_tpl_vars['MODULE'] == 'Demandes' || $this->_tpl_vars['MODULE'] == 'Incidents' ) && $this->_tpl_vars['keyfldname'] == 'description'): ?>
												<input type="hidden" id="hdtxt_IsAdmin" value=<?php echo $this->_tpl_vars['keyadmin']; ?>
>
											<?php else: ?>
												<td class="dvtCellLabel" align=right width=25%><input type="hidden" id="hdtxt_IsAdmin" value=<?php echo $this->_tpl_vars['keyadmin']; ?>
></input><?php echo $this->_tpl_vars['label']; ?>
</td>
										<?php endif; ?>
											<!--<td class="dvtCellLabel" align=right width=25%><input type="hidden" id="hdtxt_IsAdmin" value=<?php echo $this->_tpl_vars['keyadmin']; ?>
></input><?php echo $this->_tpl_vars['label']; ?>
</td> -->
										<?php endif; ?>
										<?php if (( $this->_tpl_vars['MODULE'] == 'Documents' || $this->_tpl_vars['MODULE'] == 'HReports' ) && $this->_tpl_vars['EDIT_PERMISSION'] == 'yes' && $this->_tpl_vars['header'] == 'File Information'): ?>
											<?php if ($this->_tpl_vars['keyfldname'] == 'filestatus' && $this->_tpl_vars['ADMIN'] == 'yes'): ?>
												<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DetailViewUI.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
											<?php else: ?>
												<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DetailViewFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
										<?php endif; ?>
										<?php else: ?>
										<?php if ($this->_tpl_vars['EDIT_PERMISSION'] == 'yes'): ?>
											<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DetailViewUI.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
										<?php else: ?>
											<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DetailViewFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
										<?php endif; ?>
										<?php endif; ?>
										<?php endif; ?>
										
									<?php endforeach; endif; unset($_from); ?>
								</tr>
														
							    <?php endforeach; endif; unset($_from); ?>	
								

								<?php if (( $this->_tpl_vars['CURRENT_USER_IS_ADMIN'] == 'on' || $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == 20 )): ?>
								<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="headtraitement1" style="display:none">		
										<td colspan=4 class="detailedViewHeader2">
													<b>D&eacute;tail de la livraison</b>
												</td>
									</tr>
									<tr height="25" id="info1traitement1" style="display:none">
									<td class="dvtCellLabel" align=right width=25%>Description Article</td>
									<td width=25% class="dvtCellInfo" align="left">	
										<input type="text" name="descarticle1" id="descarticle1" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
"  class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
									</td>
									<td class="dvtCellLabel" align=right width=25%>N° de s&eacute;rie </td>
									<td width=25% class="dvtCellInfo" align="left">
										<input type="text" name="numserie1" id="numserie1" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
"  class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
									</td>
									</tr>
									<tr height="25" id="info2traitement1" style="display:none">
									<td class="dvtCellLabel" align=right width=25%>Commentaire</td>
									<td width=25% class="dvtCellInfo" align="left" colspan=3>
										<textarea class="detailedViewTextBox" name="comment1" id="comment1" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" onFocus="this.className='detailedViewTextBoxOn'"   onBlur="this.className='detailedViewTextBox'" cols="110" rows="12"></textarea>
									</td>
									
									</tr>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_INFORMATION'] && $this->_tpl_vars['DISPLAY_LIVRAISON1']['statut'] == '1' && $this->_tpl_vars['MODULE'] == 'Demandes' && $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == 20): ?>
									<tr>		
										<td colspan=4 class="detailedViewHeader2">
													<b>D&eacute;tail de la livraison</b>
												</td>
									</tr>
									<tr height="25">
									<td class="dvtCellLabel" align=right width=25%>Description Article</td>
									<td width=25% class="dvtCellInfo" align="left">	
										<span class=detailedViewTextBox><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON1']['descarticle']; ?>
</span>
									</td>
									<td class="dvtCellLabel" align=right width=25%>N° de s&eacute;rie </td>
									<td width=25% class="dvtCellInfo" align="left">
										<span class=detailedViewTextBox><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON1']['numseriearticle']; ?>
</span>									
									</td>
									</tr>
									<tr height="25">
									<td class="dvtCellLabel" align=right width=25%>Date Livraison</td>
									<td width=25% class="dvtCellInfo" align="left">
										<span class=detailedViewTextBox><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON1']['datelivraison']; ?>
</span>									
									</td>
									<td class="dvtCellLabel" align=right width=25%>Commentaire</td>
									<td width=25% class="dvtCellInfo" align="left" colspan=3>
										<textarea class="detailedViewTextBox"cols="110" rows="12"><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON1']['commentaire']; ?>
</textarea>
									</td>
									</tr>
							<?php endif; ?>
								<?php if ($this->_tpl_vars['DISPLAY_DEMANDE2'] == 'display:;' && $this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_2'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr  id="headtraitement2" style="display:none">		
										<td colspan=4 class="detailedViewHeader2">
													<b>D&eacute;tail de la livraison</b>
												</td>
									</tr>									
									<tr height="25" id="info1traitement2" style="display:none">
									<td class="dvtCellLabel" align=right width=25%>Description Article</td>
									<td width=25% class="dvtCellInfo" align="left">	
										<input type="text" name="descarticle2" id="descarticle2" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
"  class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
									</td>
									<td class="dvtCellLabel" align=right width=25%>N° de s&eacute;rie </td>
									<td width=25% class="dvtCellInfo" align="left">
										<input type="text" name="numserie2" id="numserie2" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
"  class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
									</td>
									</tr>
									<tr height="25" id="info2traitement2" style="display:none">
									<td class="dvtCellLabel" align=right width=25%>Commentaire</td>
									<td width=25% class="dvtCellInfo" align="left" colspan=3>
										<textarea class="detailedViewTextBox" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" onFocus="this.className='detailedViewTextBoxOn'" name="comment2" id="comment2"  onBlur="this.className='detailedViewTextBox'" cols="110" rows="12"></textarea>
									</td>
									
									</tr>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_2'] && $this->_tpl_vars['DISPLAY_LIVRAISON2']['statut'] == '1' && $this->_tpl_vars['MODULE'] == 'Demandes' && $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == 20): ?>
									<tr>		
										<td colspan=4 class="detailedViewHeader2">
													<b>D&eacute;tail de la livraison</b>
												</td>
									</tr>
									<tr height="25">
									<td class="dvtCellLabel" align=right width=25%>Description Article</td>
									<td width=25% class="dvtCellInfo" align="left">	
										<span class=detailedViewTextBox><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON2']['descarticle']; ?>
</span>
									</td>
									<td class="dvtCellLabel" align=right width=25%>N° de s&eacute;rie </td>
									<td width=25% class="dvtCellInfo" align="left">
										<span class=detailedViewTextBox><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON2']['numseriearticle']; ?>
</span>									
									</td>
									</tr>
									<tr height="25">
									<td class="dvtCellLabel" align=right width=25%>Date Livraison</td>
									<td width=25% class="dvtCellInfo" align="left">
										<span class=detailedViewTextBox><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON2']['datelivraison']; ?>
</span>									
									</td>
									<td class="dvtCellLabel" align=right width=25%>Commentaire</td>
									<td width=25% class="dvtCellInfo" align="left" colspan=3>
										<textarea class="detailedViewTextBox"cols="110" rows="12"><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON2']['commentaire']; ?>
</textarea>
									</td>
									</tr>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['DISPLAY_DEMANDE3'] == 'display:;' && $this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_3'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="headtraitement3" style="display:none">		
										<td colspan=4 class="detailedViewHeader2" >
													<b>D&eacute;tail de la livraison</b>
												</td>
									</tr>
									<tr height="25" id="info1traitement3" style="display:none">
									<td class="dvtCellLabel" align=right width=25%>Description Article</td>
									<td width=25% class="dvtCellInfo" align="left">	
										<input type="text" name="descarticle3" id="descarticle3" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
"  class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
									</td>
									<td class="dvtCellLabel" align=right width=25%>N° de s&eacute;rie </td>
									<td width=25% class="dvtCellInfo" align="left">
										<input type="text" name="numserie3" id="numserie3" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
"  class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
									</td>
									</tr>
									<tr height="25" id="info2traitement3" style="display:none">
									<td class="dvtCellLabel" align=right width=25%>Commentaire</td>
									<td width=25% class="dvtCellInfo" align="left" colspan=3>
										<textarea class="detailedViewTextBox" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" onFocus="this.className='detailedViewTextBoxOn'" name="comment3" id="comment3"  onBlur="this.className='detailedViewTextBox'" cols="110" rows="12"></textarea>
									</td>
									
									</tr>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_3'] && $this->_tpl_vars['DISPLAY_LIVRAISON3']['statut'] == '1' && $this->_tpl_vars['MODULE'] == 'Demandes' && $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == 20): ?>
									<tr>		
										<td colspan=4 class="detailedViewHeader2">
													<b>D&eacute;tail de la livraison</b>
												</td>
									</tr>
									<tr height="25">
									<td class="dvtCellLabel" align=right width=25%>Description Article</td>
									<td width=25% class="dvtCellInfo" align="left">	
										<span class=detailedViewTextBox><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON3']['descarticle']; ?>
</span>
									</td>
									<td class="dvtCellLabel" align=right width=25%>N° de s&eacute;rie </td>
									<td width=25% class="dvtCellInfo" align="left">
										<span class=detailedViewTextBox><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON3']['numseriearticle']; ?>
</span>									
									</td>
									</tr>
									<tr height="25">
									<td class="dvtCellLabel" align=right width=25%>Date Livraison</td>
									<td width=25% class="dvtCellInfo" align="left">
										<span class=detailedViewTextBox><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON3']['datelivraison']; ?>
</span>									
									</td>
									<td class="dvtCellLabel" align=right width=25%>Commentaire</td>
									<td width=25% class="dvtCellInfo" align="left" colspan=3>
										<textarea class="detailedViewTextBox"cols="110" rows="12"><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON3']['commentaire']; ?>
</textarea>
									</td>
									</tr>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['DISPLAY_DEMANDE4'] == 'display:;' && $this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_4'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="headtraitement4" style="display:none">		
										<td colspan=4 class="detailedViewHeader2" >
													<b>D&eacute;tail de la livraison</b>
												</td>
									</tr>
									<tr height="25" id="info1traitement4" style="display:none">
									<td class="dvtCellLabel" align=right width=25%>Description Article</td>
									<td width=25% class="dvtCellInfo" align="left">	
										<input type="text" name="descarticle4" id="descarticle4" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
"  class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
									</td>
									<td class="dvtCellLabel" align=right width=25%>N° de s&eacute;rie </td>
									<td width=25% class="dvtCellInfo" align="left">
										<input type="text" name="numserie4" id="numserie4" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
"  class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
									</td>
									</tr>
									<tr height="25" id="info2traitement4" style="display:none">
									<td class="dvtCellLabel" align=right width=25%>Commentaire</td>
									<td width=25% class="dvtCellInfo" align="left" colspan=3>
										<textarea class="detailedViewTextBox" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" onFocus="this.className='detailedViewTextBoxOn'" name="comment4" id="comment4"  onBlur="this.className='detailedViewTextBox'" cols="110" rows="12"></textarea>
									</td>
									
									</tr>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_4'] && $this->_tpl_vars['DISPLAY_LIVRAISON4']['statut'] == '1' && $this->_tpl_vars['MODULE'] == 'Demandes' && $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == 20): ?>
									<tr>		
										<td colspan=4 class="detailedViewHeader2">
													<b>D&eacute;tail de la livraison</b>
												</td>
									</tr>
									<tr height="25">
									<td class="dvtCellLabel" align=right width=25%>Description Article</td>
									<td width=25% class="dvtCellInfo" align="left">	
										<span class=detailedViewTextBox><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON4']['descarticle']; ?>
</span>
									</td>
									<td class="dvtCellLabel" align=right width=25%>N° de s&eacute;rie </td>
									<td width=25% class="dvtCellInfo" align="left">
										<span class=detailedViewTextBox><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON4']['numseriearticle']; ?>
</span>									
									</td>
									</tr>
									<tr height="25">
									<td class="dvtCellLabel" align=right width=25%>Date Livraison</td>
									<td width=25% class="dvtCellInfo" align="left">
										<span class=detailedViewTextBox><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON4']['datelivraison']; ?>
</span>									
									</td>
									<td class="dvtCellLabel" align=right width=25%>Commentaire</td>
									<td width=25% class="dvtCellInfo" align="left" colspan=3>
										<textarea class="detailedViewTextBox"cols="110" rows="12"><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON4']['commentaire']; ?>
</textarea>
									</td>
									</tr>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['DISPLAY_DEMANDE5'] == 'display:;' && $this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_5'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
									<tr id="headtraitement5" style="display:none">		
										<td colspan=4 class="detailedViewHeader2" >
													<b>D&eacute;tail de la livraison</b>
												</td>
									</tr>
									<tr height="25" id="info1traitement5" style="display:none">
									<td class="dvtCellLabel" align=right width=25%>Description Article</td>
									<td width=25% class="dvtCellInfo" align="left">	
										<input type="text" name="descarticle5" id="descarticle5" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
"  class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
									</td>
									<td class="dvtCellLabel" align=right width=25%>N° de s&eacute;rie </td>
									<td width=25% class="dvtCellInfo" align="left">
										<input type="text" name="numserie5" id="numserie5" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
"  class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
									</td>
									</tr>
									<tr height="25" id="info2traitement5" style="display:none">
									<td class="dvtCellLabel" align=right width=25%>Commentaire</td>
									<td width=25% class="dvtCellInfo" align="left" colspan=3>
										<textarea class="detailedViewTextBox" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" onFocus="this.className='detailedViewTextBoxOn'" name="comment5" id="comment5"  onBlur="this.className='detailedViewTextBox'" cols="110" rows="12"></textarea>
									</td>
									
									</tr>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_5'] && $this->_tpl_vars['DISPLAY_LIVRAISON5']['statut'] == '1' && $this->_tpl_vars['MODULE'] == 'Demandes' && $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == 20): ?>
									<tr>		
										<td colspan=4 class="detailedViewHeader2">
													<b>D&eacute;tail de la livraison</b>
												</td>
									</tr>
									<tr height="25">
									<td class="dvtCellLabel" align=right width=25%>Description Article</td>
									<td width=25% class="dvtCellInfo" align="left">	
										<span class=detailedViewTextBox><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON5']['descarticle']; ?>
</span>
									</td>
									<td class="dvtCellLabel" align=right width=25%>N° de s&eacute;rie </td>
									<td width=25% class="dvtCellInfo" align="left">
										<span class=detailedViewTextBox><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON5']['numseriearticle']; ?>
</span>									
									</td>
									</tr>
									<tr height="25">
									<td class="dvtCellLabel" align=right width=25%>Date Livraison</td>
									<td width=25% class="dvtCellInfo" align="left">
										<span class=detailedViewTextBox><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON5']['datelivraison']; ?>
</span>									
									</td>
									<td class="dvtCellLabel" align=right width=25%>Commentaire</td>
									<td width=25% class="dvtCellInfo" align="left" colspan=3>
										<textarea class="detailedViewTextBox"cols="110" rows="12"><?php echo $this->_tpl_vars['DISPLAY_LIVRAISON5']['commentaire']; ?>
</textarea>
									</td>
									</tr>
							<?php endif; ?>
					<?php endif; ?>	
							</table>
						</div>
						<?php endif; ?>
                     	                      </td>
					   </tr>
			                                                                                                    
		<td style="padding:10px">
			<?php endforeach; endif; unset($_from); ?>
                     
			</td>
                </tr>
				<?php if ($this->_tpl_vars['MODULE'] == 'Demandes' || $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
					<tr><td class="small"><b><u>Initiateur demande</u> : <?php echo $this->_tpl_vars['POSTEURDEMANDE']; ?>
<b></td></tr>	
				<?php endif; ?>	
				<?php if ($this->_tpl_vars['MODULE'] == 'OrdresMission' || $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
					
				<tr><td>
			<div id='divdecompteview'>
				<table width="90%" align=center border=1 cellspacing=1 cellpadding=3 width=100% class="lvt small" valign=top>
				<caption class="big2" align=center> INFORMATION DISPONIBITE DES CREDITS</caption>
					
				<?php if ($this->_tpl_vars['BUDGETDISP']['msgErreurSap'] == ''): ?>	
					<tr align=center>		
							<td class="detailedViewHeader2"><b>Code Budgétaire</b></td>
							<td class="detailedViewHeader2"><b>Source de Financement</b></td>
							<td class="detailedViewHeader2"><b>Compte Nature</b></td>
							<td class="detailedViewHeader2"><b>Autorisation d'engagement</b></td>
							<td class="detailedViewHeader2"><b>Montant Engagé</b></td>
							<td class="detailedViewHeader2"><b>Montant Disponible</b></td>
					</tr>
					<?php $_from = $this->_tpl_vars['BUDGETDISP']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['codebudget'] => $this->_tpl_vars['budget']):
?>
						<?php if ($this->_tpl_vars['codebudget'] != 'msgErreurSap'): ?>
							<?php $_from = $this->_tpl_vars['budget']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cmptnat'] => $this->_tpl_vars['line']):
?>
								<tr align=center>
									<td class="detailedViewHeader2"><?php echo $this->_tpl_vars['line']['codebudget']; ?>
</td>
									<td class="detailedViewHeader2"><?php echo $this->_tpl_vars['line']['sourcefin']; ?>
</td>
									<td class="detailedViewHeader2"><?php echo $this->_tpl_vars['line']['comptenat']; ?>
</td>
									<td class="detailedViewHeader2"><?php echo ((is_array($_tmp=$this->_tpl_vars['line']['fonddisp'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</td>
									<td class="detailedViewHeader2"><?php echo ((is_array($_tmp=$this->_tpl_vars['line']['fondengage'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</td>
									<td class="detailedViewHeader2"><?php echo ((is_array($_tmp=$this->_tpl_vars['line']['mntdispo'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</td>
								</tr>	
							<?php endforeach; endif; unset($_from); ?>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				<?php else: ?>
					<tr>
						<td colspan=6 class="detailedViewHeader2" align=center>
							<font color='red'><b><?php echo $this->_tpl_vars['BUDGETDISP']['msgErreurSap']; ?>
</b></font>
						</td>
						
					</tr>
				<?php endif; ?>
				</table>
		</div>
			
			</td></tr>	
		<?php endif; ?>		
											
		<tr>           
								
					
		<!-- Inventory - Product Details informations -->
		   <tr>
			<?php echo $this->_tpl_vars['ASSOCIATED_PRODUCTS']; ?>

		   </tr>			
			<!--
			<?php if ($this->_tpl_vars['SinglePane_View'] == 'true' && $this->_tpl_vars['IS_REL_LIST'] == 'true'): ?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'RelatedListNew.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endif; ?>
			-->
			<?php if ($this->_tpl_vars['MODULE'] == 'Demandes' && $this->_tpl_vars['NBTRAITEMENT'] >= 0): ?>
 				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'ListViewTraitementDemande.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 			<?php elseif ($this->_tpl_vars['MODULE'] == 'Incidents' && $this->_tpl_vars['NBTRAITEMENT'] >= 0): ?>
 				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'ListViewTraitementIncident.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php elseif ($this->_tpl_vars['MODULE'] == 'Conventions' && $this->_tpl_vars['NBTRAITEMENT'] >= 0): ?>
 				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'ListViewTraitementConvention.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
 			<?php endif; ?>
		</table>
		
		<?php if ($this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
		<div id='divdecompteview'>
				<table width="90%" align=center border=1 cellspacing=1 cellpadding=3 width=100% class="lvt small" valign=top>
				<caption class="big2" align=center> RECAPITULATIF DE LA DECOMPTE</caption>
					<?php if ($this->_tpl_vars['CURRENT_USER_PROFIL'] == '27' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '26' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '20'): ?>
					<tr><td colspan=9 align=right>
							<input title="<?php echo $this->_tpl_vars['MOD']['LBL_MODIFDECOMPTE_BUTTON_LABEL']; ?>
" class="crmbutton small edit" 
												onclick="return modifierDecompte(<?php echo $this->_tpl_vars['ID']; ?>
);"   
												type="button"  
												name="Edit" 
												value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_MODIFDECOMPTE_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
												
					</td></tr>
				<?php endif; ?>
				<tr align=center>		
						<td class="detailedViewHeader2" rowspan=2><b>Lieu</b></td>
						<td class="detailedViewHeader2" colspan=2><b>Indemnit&eacute;</b></td>
						<td class="detailedViewHeader2" colspan=2><b>Hébergement</b></td>
						<td class="detailedViewHeader2" colspan=2><b>Transport</b></td>

						<td class="detailedViewHeader2" rowspan=2><b>Total</b></td>
					</tr>
					<tr align=center>
						<td class="detailedViewHeader2">Nbjours</td>
						<td class="detailedViewHeader2">Taux</td>
						<td class="detailedViewHeader2">Nbjours</td>
						<td class="detailedViewHeader2">Taux</td>
						<td class="detailedViewHeader2">Nbjours</td>
						<td class="detailedViewHeader2">Taux</td>
						<?php $this->assign('totaldecomte', 0); ?>
						<?php $_from = $this->_tpl_vars['DECOMPTES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['decompte']):
?>

							<tr align=center>		
								<td class="dvtCellInfo"><b><?php echo $this->_tpl_vars['decompte']['zone']; ?>
</b></td>
								<td class="dvtCellInfo"><?php echo $this->_tpl_vars['decompte']['nbjindemn']; ?>
</td>
								<td class="dvtCellInfo"><?php echo ((is_array($_tmp=$this->_tpl_vars['decompte']['indemnite'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</td>
								<td class="dvtCellInfo"><?php echo $this->_tpl_vars['decompte']['nbjheberg']; ?>
</td>
								<td class="dvtCellInfo"><?php echo ((is_array($_tmp=$this->_tpl_vars['decompte']['herbergement'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</td>
								<td class="dvtCellInfo"><?php echo $this->_tpl_vars['decompte']['nbjtransp']; ?>
</td>
								<td class="dvtCellInfo"><?php echo ((is_array($_tmp=$this->_tpl_vars['decompte']['transport'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</td>
								<td class="dvtCellInfo"><b><?php echo ((is_array($_tmp=$this->_tpl_vars['decompte']['mnttotal'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</b></td>
							</tr>	
							 <?php $this->assign('totaldecomte', $this->_tpl_vars['totaldecomte']+$this->_tpl_vars['decompte']['mnttotal']); ?>
						<?php endforeach; endif; unset($_from); ?>	
					<tr align=center>		
								<td class="dvtCellInfo" colspan=7 align=right><b>TOTAL DECOMPTE</b></td>
								<td class="dvtCellInfo" ><b><?php echo ((is_array($_tmp=$this->_tpl_vars['totaldecomte'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</b></td>
							</tr>	
				</table>
		</div>	
		<br>
		<div id='divdecompteedit' style="display:none" >
				<table width="90%" align=center border=1 cellspacing=1 cellpadding=3 width=100% class="lvt small" valign=top>
					<?php if ($this->_tpl_vars['CURRENT_USER_PROFIL'] == '27' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '26' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '20'): ?>
				<tr><td colspan=9 align=right>
						<input title="<?php echo $this->_tpl_vars['MOD']['LBL_SAVEMODIFDECOMPTE_BUTTON_LABEL']; ?>
" class="crmbutton small edit" 
											onclick="this.form.return_module.value='OrdresMission'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='OrdresMission';
											this.form.action.value='SaveDecompte';
											this.form.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
											return saveModifDecompte('OrdresMission');"   
									type="submit"  
									name="Edit" 
											value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_SAVEMODIFDECOMPTE_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
				<input title="<?php echo $this->_tpl_vars['MOD']['LBL_CANCELMODIFDECOMPTE_BUTTON_LABEL']; ?>
" class="crmbutton small edit" 
											onclick="return AnnulermodifierDecompte(<?php echo $this->_tpl_vars['ID']; ?>
);"   
											type="button"  
											name="Edit" 
											value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_CANCELMODIFDECOMPTE_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;							
				</td></tr>
				<?php endif; ?>
				<tr align=center>		
						<td class="detailedViewHeader2" rowspan=2><b>Lieu</b></td>
						<td class="detailedViewHeader2" colspan=2><b>Indemnit&eacute;</b></td>
						<td class="detailedViewHeader2" colspan=2><b>Hébergement</b></td>
						<td class="detailedViewHeader2" colspan=2><b>Transport</b></td>

					</tr>
					<tr align=center>
						<td class="detailedViewHeader2">Nbjours</td>
						<td class="detailedViewHeader2">Taux</td>
						<td class="detailedViewHeader2">Nbjours</td>
						<td class="detailedViewHeader2">Taux</td>
						<td class="detailedViewHeader2">Nbjours</td>
						<td class="detailedViewHeader2">Taux</td>
						<?php $this->assign('totaldecomte', 0); ?>
						<?php $_from = $this->_tpl_vars['DECOMPTES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['decompte']):
?>

							<tr align=center>		
								<td class="dvtCellInfo" nowrap><b><?php echo $this->_tpl_vars['decompte']['zone']; ?>
</b></td>
								<td class="dvtCellInfo"><input type="text" name="nbjindemn_<?php echo $this->_tpl_vars['k']; ?>
" id="nbjindemn_<?php echo $this->_tpl_vars['k']; ?>
" value="<?php echo $this->_tpl_vars['decompte']['nbjindemn']; ?>
" class=detailedViewTextBox size=10/></td>
								<td class="dvtCellInfo"><input type="text" name="indemnite_<?php echo $this->_tpl_vars['k']; ?>
" id="indemnite_<?php echo $this->_tpl_vars['k']; ?>
" value="<?php echo $this->_tpl_vars['decompte']['indemnite']; ?>
" class=detailedViewTextBox size=30/></td>
								<td class="dvtCellInfo"><input type="text" name="nbjheberg_<?php echo $this->_tpl_vars['k']; ?>
" id="nbjheberg_<?php echo $this->_tpl_vars['k']; ?>
" value="<?php echo $this->_tpl_vars['decompte']['nbjheberg']; ?>
" class=detailedViewTextBox size=10/></td>
								<td class="dvtCellInfo"><input type="text" name="herbergement_<?php echo $this->_tpl_vars['k']; ?>
" id="herbergement_<?php echo $this->_tpl_vars['k']; ?>
" value="<?php echo $this->_tpl_vars['decompte']['herbergement']; ?>
" class=detailedViewTextBox size=30/></td>
								<td class="dvtCellInfo"><input type="text" name="nbjtransp_<?php echo $this->_tpl_vars['k']; ?>
" id="nbjtransp_<?php echo $this->_tpl_vars['k']; ?>
" value="<?php echo $this->_tpl_vars['decompte']['nbjtransp']; ?>
" class=detailedViewTextBox size=10/></td>
								<td class="dvtCellInfo"><input type="text" name="transport_<?php echo $this->_tpl_vars['k']; ?>
" id="transport_<?php echo $this->_tpl_vars['k']; ?>
" value="<?php echo $this->_tpl_vars['decompte']['transport']; ?>
" class=detailedViewTextBox size=30/></td>
					 
								<input type="hidden" id="zonetrajet_<?php echo $this->_tpl_vars['k']; ?>
" name="zonetrajet_<?php echo $this->_tpl_vars['k']; ?>
" value="<?php echo $this->_tpl_vars['decompte']['zone']; ?>
"></input>
							
							</tr>	
						<?php endforeach; endif; unset($_from); ?>	
					
				</table>
		</div>
		
				 <input type="hidden" id="nbzonetrajet" name="nbzonetrajet" value=<?php echo count($this->_tpl_vars['DECOMPTES']); ?>
></input>

		<?php endif; ?>
		
		 <input type="hidden" id="demandeid" name="demandeid" value=<?php echo $this->_tpl_vars['ID']; ?>
></input>
		<input type="hidden" id="demandeticket" name="demandeticket" value=<?php echo $this->_tpl_vars['TICKET']; ?>
></input>
			<div id="savetraitbut" style="display:none" align=center >
						<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="traitementbut" onclick="if(!verifSaveTraitement()) return false; this.form.action.value='SaveTraitement'" type="submit" name="button" value="Enregistrer Livraison" >
            </div>
		</td>
		<!--
		<td width=22% valign=top style="border-left:1px dashed #cccccc;padding:13px">
				  
			
			<?php if ($this->_tpl_vars['MODULE'] == 'Potentials' || $this->_tpl_vars['MODULE'] == 'HelpDesk' || $this->_tpl_vars['MODULE'] == 'Contacts' || $this->_tpl_vars['MODULE'] == 'Accounts' || $this->_tpl_vars['MODULE'] == 'Leads' || ( ( $this->_tpl_vars['MODULE'] == 'Documents' || $this->_tpl_vars['MODULE'] == 'HReports' ) && ( $this->_tpl_vars['ADMIN'] == 'yes' || $this->_tpl_vars['FILE_STATUS'] == '1' ) )): ?>
  			<table width="100%" border="0" cellpadding="5" cellspacing="0">
				<tr><td>&nbsp;</td></tr>				
								
				<?php if ($this->_tpl_vars['MODULE'] == 'HelpDesk'): ?>
					<?php if ($this->_tpl_vars['CONVERTASFAQ'] == 'permitted'): ?>
				<tr><td align="left" class="genHeaderSmall"><?php echo $this->_tpl_vars['APP']['LBL_ACTIONS']; ?>
</td></tr>				
				<tr>
					<td align="left" style="padding-left:10px;"> 
						<a class="webMnu" href="index.php?return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&record=<?php echo $this->_tpl_vars['ID']; ?>
&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=ConvertAsFAQ"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
						<a class="webMnu" href="index.php?return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&record=<?php echo $this->_tpl_vars['ID']; ?>
&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=ConvertAsFAQ"><?php echo $this->_tpl_vars['MOD']['LBL_CONVERT_AS_FAQ_BUTTON_LABEL']; ?>
</a>
					</td>
				</tr>
					<?php endif; ?>		
				<?php elseif ($this->_tpl_vars['MODULE'] == 'Potentials'): ?>
						<?php if ($this->_tpl_vars['CONVERTINVOICE'] == 'permitted'): ?>
				<tr><td align="left" class="genHeaderSmall"><?php echo $this->_tpl_vars['APP']['LBL_ACTIONS']; ?>
</td></tr>				
				<tr>
					<td align="left" style="padding-left:10px;"> 
						<a class="webMnu" href="index.php?return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&convertmode=<?php echo $this->_tpl_vars['CONVERTMODE']; ?>
&module=Invoice&action=EditView&account_id=<?php echo $this->_tpl_vars['ACCOUNTID']; ?>
"><img src="<?php echo vtiger_imageurl('actionGenerateInvoice.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
						<a class="webMnu" href="index.php?return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&convertmode=<?php echo $this->_tpl_vars['CONVERTMODE']; ?>
&module=Invoice&action=EditView&account_id=<?php echo $this->_tpl_vars['ACCOUNTID']; ?>
"><?php echo $this->_tpl_vars['APP']['LBL_CREATE']; ?>
 <?php echo $this->_tpl_vars['APP']['Invoice']; ?>
</a>
					</td>
				</tr>
						<?php endif; ?>
				<?php elseif ($this->_tpl_vars['TODO_PERMISSION'] == 'true' || $this->_tpl_vars['EVENT_PERMISSION'] == 'true' || $this->_tpl_vars['CONTACT_PERMISSION'] == 'true' || $this->_tpl_vars['MODULE'] == 'Contacts' || ( $this->_tpl_vars['MODULE'] == 'Documents' )): ?>                              
				<tr><td align="left" class="genHeaderSmall"><?php echo $this->_tpl_vars['APP']['LBL_ACTIONS']; ?>
</td></tr>
						
					<?php if ($this->_tpl_vars['MODULE'] == 'Contacts'): ?>
						<?php $this->assign('subst', 'contact_id'); ?>
						<?php $this->assign('acc', "&account_id=".($this->_tpl_vars['accountid'])); ?>
					<?php else: ?>
						<?php $this->assign('subst', 'parent_id'); ?>
						<?php $this->assign('acc', ""); ?>
					<?php endif; ?>			
				
					<?php if ($this->_tpl_vars['MODULE'] == 'Leads' || $this->_tpl_vars['MODULE'] == 'Contacts' || $this->_tpl_vars['MODULE'] == 'Accounts'): ?>
						<?php if ($this->_tpl_vars['SENDMAILBUTTON'] == 'permitted'): ?>						
					<tr>
						<td align="left" style="padding-left:10px;"> 
							<input type="hidden" name="pri_email" value="<?php echo $this->_tpl_vars['EMAIL1']; ?>
"/>
							<input type="hidden" name="sec_email" value="<?php echo $this->_tpl_vars['EMAIL2']; ?>
"/>
							<a href="javascript:void(0);" class="webMnu" onclick="if(LTrim('<?php echo $this->_tpl_vars['EMAIL1']; ?>
') !='' || LTrim('<?php echo $this->_tpl_vars['EMAIL2']; ?>
') !=''){fnvshobj(this,'sendmail_cont');sendmail('<?php echo $this->_tpl_vars['MODULE']; ?>
',<?php echo $this->_tpl_vars['ID']; ?>
)}else{OpenCompose('','create')}"><img src="<?php echo vtiger_imageurl('sendmail.png', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>&nbsp;
							<a href="javascript:void(0);" class="webMnu" onclick="if(LTrim('<?php echo $this->_tpl_vars['EMAIL1']; ?>
') !='' || LTrim('<?php echo $this->_tpl_vars['EMAIL2']; ?>
') !=''){fnvshobj(this,'sendmail_cont');sendmail('<?php echo $this->_tpl_vars['MODULE']; ?>
',<?php echo $this->_tpl_vars['ID']; ?>
)}else{OpenCompose('','create')}"><?php echo $this->_tpl_vars['APP']['LBL_SENDMAIL_BUTTON_LABEL']; ?>
</a>
						</td>
					</tr>
						<?php endif; ?>
					<?php endif; ?>
					
					<?php if ($this->_tpl_vars['MODULE'] == 'Contacts' || $this->_tpl_vars['EVENT_PERMISSION'] == 'true'): ?>	
					<tr>
						<td align="left" style="padding-left:10px;"> 
				        	<a href="index.php?module=Calendar&action=EditView&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&activity_mode=Events&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&<?php echo $this->_tpl_vars['subst']; ?>
=<?php echo $this->_tpl_vars['ID']; ?>
<?php echo $this->_tpl_vars['acc']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
" class="webMnu"><img src="<?php echo vtiger_imageurl('AddEvent.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
							<a href="index.php?module=Calendar&action=EditView&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&activity_mode=Events&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&<?php echo $this->_tpl_vars['subst']; ?>
=<?php echo $this->_tpl_vars['ID']; ?>
<?php echo $this->_tpl_vars['acc']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
" class="webMnu"><?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Event']; ?>
</a>
						</td>
					</tr>
					<?php endif; ?>
		
					<?php if ($this->_tpl_vars['TODO_PERMISSION'] == 'true' && ( $this->_tpl_vars['MODULE'] == 'Accounts' || $this->_tpl_vars['MODULE'] == 'Leads' )): ?>
					<tr>
						<td align="left" style="padding-left:10px;">
					        <a href="index.php?module=Calendar&action=EditView&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&activity_mode=Task&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&<?php echo $this->_tpl_vars['subst']; ?>
=<?php echo $this->_tpl_vars['ID']; ?>
<?php echo $this->_tpl_vars['acc']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
" class="webMnu"><img src="<?php echo vtiger_imageurl('AddToDo.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle" border="0"/></a>
							<a href="index.php?module=Calendar&action=EditView&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&activity_mode=Task&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&<?php echo $this->_tpl_vars['subst']; ?>
=<?php echo $this->_tpl_vars['ID']; ?>
<?php echo $this->_tpl_vars['acc']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
" class="webMnu"><?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Todo']; ?>
</a>
						</td>
					</tr>
					<?php endif; ?>
		
					<?php if ($this->_tpl_vars['MODULE'] == 'Contacts' && $this->_tpl_vars['CONTACT_PERMISSION'] == 'true'): ?>
					<tr>
						<td align="left" style="padding-left:10px;">
					        <a href="index.php?module=Calendar&action=EditView&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&activity_mode=Task&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&<?php echo $this->_tpl_vars['subst']; ?>
=<?php echo $this->_tpl_vars['ID']; ?>
<?php echo $this->_tpl_vars['acc']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
" class="webMnu"><img src="<?php echo vtiger_imageurl('AddToDo.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle" border="0"/></a>
							<a href="index.php?module=Calendar&action=EditView&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&activity_mode=Task&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&<?php echo $this->_tpl_vars['subst']; ?>
=<?php echo $this->_tpl_vars['ID']; ?>
<?php echo $this->_tpl_vars['acc']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
" class="webMnu"><?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Todo']; ?>
</a>
						</td>
					</tr>
					<?php endif; ?>							
					
					<?php if ($this->_tpl_vars['MODULE'] == 'Leads'): ?>
						<?php if ($this->_tpl_vars['CONVERTLEAD'] == 'permitted'): ?>
					<tr>
						<td align="left" style="padding-left:10px;">
							<a href="javascript:void(0);" class="webMnu" onclick="callConvertLeadDiv('<?php echo $this->_tpl_vars['ID']; ?>
');"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
							<a href="javascript:void(0);" class="webMnu" onclick="callConvertLeadDiv('<?php echo $this->_tpl_vars['ID']; ?>
');"><?php echo $this->_tpl_vars['APP']['LBL_CONVERT_BUTTON_LABEL']; ?>
</a>
						</td>
					</tr>
						<?php endif; ?>
					<?php endif; ?>
					
				
					<?php if ($this->_tpl_vars['MODULE'] == 'Documents' || $this->_tpl_vars['MODULE'] == 'HReports'): ?>
		                                <tr><td align="left" style="padding-left:10px;">			        
						<?php if ($this->_tpl_vars['FILE_STATUS'] == '1'): ?>	
							<br><a href="index.php?module=uploads&action=downloadfile&fileid=<?php echo $this->_tpl_vars['FILEID']; ?>
&entityid=<?php echo $this->_tpl_vars['NOTESID']; ?>
"  onclick="javascript:dldCntIncrease(<?php echo $this->_tpl_vars['NOTESID']; ?>
);" class="webMnu"><img src="<?php echo vtiger_imageurl('fbDownload.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_DOWNLOAD']; ?>
" border="0"/></a>
		                    <a href="index.php?module=uploads&action=downloadfile&fileid=<?php echo $this->_tpl_vars['FILEID']; ?>
&entityid=<?php echo $this->_tpl_vars['NOTESID']; ?>
" onclick="javascript:dldCntIncrease(<?php echo $this->_tpl_vars['NOTESID']; ?>
);"><?php echo $this->_tpl_vars['MOD']['LBL_DOWNLOAD_FILE']; ?>
</a>
						<?php elseif ($this->_tpl_vars['DLD_TYPE'] == 'E' && $this->_tpl_vars['FILE_STATUS'] == '1'): ?>
							<br><a target="_blank" href="<?php echo $this->_tpl_vars['DLD_PATH']; ?>
" onclick="javascript:dldCntIncrease(<?php echo $this->_tpl_vars['NOTESID']; ?>
);"><img src="<?php echo vtiger_imageurl('fbDownload.gif', $this->_tpl_vars['THEME']); ?>
"" align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_DOWNLOAD']; ?>
" border="0"></a>
							<a target="_blank" href="<?php echo $this->_tpl_vars['DLD_PATH']; ?>
" onclick="javascript:dldCntIncrease(<?php echo $this->_tpl_vars['NOTESID']; ?>
);"><?php echo $this->_tpl_vars['MOD']['LBL_DOWNLOAD_FILE']; ?>
</a>
						
						<?php endif; ?>
						</td></tr>
						<?php if ($this->_tpl_vars['CHECK_INTEGRITY_PERMISSION'] == 'yes'): ?>
							<tr><td align="left" style="padding-left:10px;">	
							<br><a href="javascript:;" onClick="checkFileIntegrityDetailView(<?php echo $this->_tpl_vars['NOTESID']; ?>
);"><img id="CheckIntegrity_img_id" src="<?php echo vtiger_imageurl('yes.gif', $this->_tpl_vars['THEME']); ?>
" alt="Check integrity of this file" title="Check integrity of this file" hspace="5" align="absmiddle" border="0"/></a>
		                    <a href="javascript:;" onClick="checkFileIntegrityDetailView(<?php echo $this->_tpl_vars['NOTESID']; ?>
);"><?php echo $this->_tpl_vars['MOD']['LBL_CHECK_INTEGRITY']; ?>
</a>&nbsp;
		                    <input type="hidden" id="dldfilename" name="dldfilename" value="<?php echo $this->_tpl_vars['FILENAME']; ?>
">
		                    <span id="vtbusy_integrity_info" style="display:none;">
								<img src="<?php echo vtiger_imageurl('vtbusy.gif', $this->_tpl_vars['THEME']); ?>
" border="0"></span>
							<span id="integrity_result" style="display:none"></span>						
							</td></tr>
						<?php endif; ?>
						<tr><td align="left" style="padding-left:10px;">			        
						<?php if ($this->_tpl_vars['DLD_TYPE'] == 'I'): ?>	
							<input type="hidden" id="dldfilename" name="dldfilename" value="<?php echo $this->_tpl_vars['FILENAME']; ?>
">
							<br><a href="javascript: document.DetailView.return_module.value='Documents'; document.DetailView.return_action.value='DetailView'; document.DetailView.module.value='Documents'; document.DetailView.action.value='EmailFile'; document.DetailView.record.value=<?php echo $this->_tpl_vars['NOTESID']; ?>
; document.DetailView.return_id.value=<?php echo $this->_tpl_vars['NOTESID']; ?>
; sendfile_email();" class="webMnu"><img src="<?php echo vtiger_imageurl('attachment.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle" border="0"/></a>
		                    <a href="javascript: document.DetailView.return_module.value='Documents'; document.DetailView.return_action.value='DetailView'; document.DetailView.module.value='Documents'; document.DetailView.action.value='EmailFile'; document.DetailView.record.value=<?php echo $this->_tpl_vars['NOTESID']; ?>
; document.DetailView.return_id.value=<?php echo $this->_tpl_vars['NOTESID']; ?>
; sendfile_email();"><?php echo $this->_tpl_vars['MOD']['LBL_EMAIL_FILE']; ?>
</a>                                      
						<?php endif; ?>
						</td></tr>
						<tr><td>&nbsp;</td></tr>
					
						<?php endif; ?>
					<?php endif; ?>
					
			
                  </table>
                <br>
			<?php endif; ?>
		
						<?php if ($this->_tpl_vars['CUSTOM_LINKS']): ?>
			<table width="100%" border="0" cellpadding="5" cellspacing="0">
				<tr><td align="left" class="dvtUnSelectedCell dvtCellLabel">
					<a href="javascript:;" onmouseover="fnvshobj(this,'vtlib_customLinksLay');" onclick="fnvshobj(this,'vtlib_customLinksLay');"><b><?php echo $this->_tpl_vars['APP']['LBL_MORE']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_ACTIONS']; ?>
 &#187;</b></a>
				</td></tr>
			</table>
			<br>
			<div style="display: none; left: 193px; top: 106px;width:155px; position:absolute;" id="vtlib_customLinksLay" 
				onmouseout="fninvsh('vtlib_customLinksLay')" onmouseover="fnvshNrm('vtlib_customLinksLay')">
				<table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr><td style="border-bottom: 1px solid rgb(204, 204, 204); padding: 5px;"><b><?php echo $this->_tpl_vars['APP']['LBL_MORE']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_ACTIONS']; ?>
 &#187;</b></td></tr>
				<tr>
					<td>
						<?php $_from = $this->_tpl_vars['CUSTOM_LINKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['CUSTOMLINK']):
?>
							<?php $this->assign('customlink_href', $this->_tpl_vars['CUSTOMLINK']->linkurl); ?>
							<?php $this->assign('customlink_label', $this->_tpl_vars['CUSTOMLINK']->linklabel); ?>
							<?php if ($this->_tpl_vars['customlink_label'] == ''): ?>
								<?php $this->assign('customlink_label', $this->_tpl_vars['customlink_href']); ?>
							<?php else: ?>
																<?php $this->assign('customlink_label', getTranslatedString($this->_tpl_vars['customlink_label'], $this->_tpl_vars['customlink_module'])); ?>
							<?php endif; ?>
							<a href="<?php echo $this->_tpl_vars['customlink_href']; ?>
" class="drop_down"><?php echo $this->_tpl_vars['customlink_label']; ?>
</a>
						<?php endforeach; endif; unset($_from); ?>
					</td>
				</tr>
				</table>
			</div>
			<?php endif; ?>
		         			</form>
       

		<?php if ($this->_tpl_vars['TAG_CLOUD_DISPLAY'] == 'true'): ?>
		
		<table border=0 cellspacing=0 cellpadding=0 width=100% class="tagCloud">
		<tr>
			<td class="tagCloudTopBg"><img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
tagCloudName.gif" border=0></td>
		</tr>
		<tr>
              		<td><div id="tagdiv" style="display:visible;"><form method="POST" action="javascript:void(0);" onsubmit="return tagvalidate();"><input class="textbox"  type="text" id="txtbox_tagfields" name="textbox_First Name" value="" style="width:100px;margin-left:5px;"></input>&nbsp;&nbsp;<input name="button_tagfileds" type="submit"  class="crmbutton small save" value="<?php echo $this->_tpl_vars['APP']['LBL_TAG_IT']; ?>
" /></form></div></td>
                </tr>
		<tr>
			<td class="tagCloudDisplay" valign=top> <span id="tagfields"><?php echo $this->_tpl_vars['ALL_TAG']; ?>
</span></td>
		</tr>
		</table>
		
		<?php endif; ?>
				<br>
				<?php if ($this->_tpl_vars['MERGEBUTTON'] == 'permitted'): ?>
				<form action="index.php" method="post" name="TemplateMerge" id="form">
				<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
				<input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
">
				<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
				<input type="hidden" name="action">
  				<table border=0 cellspacing=0 cellpadding=0 width=100% class="rightMailMerge">
      				<tr>
      					   <td class="rightMailMergeHeader"><b><?php echo $this->_tpl_vars['WORDTEMPLATEOPTIONS']; ?>
</b></td>
      				</tr>
      				<tr style="height:25px">
					<td class="rightMailMergeContent">
						<?php if ($this->_tpl_vars['TEMPLATECOUNT'] != 0): ?>
						<select name="mergefile"><?php $_from = $this->_tpl_vars['TOPTIONS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['templid'] => $this->_tpl_vars['tempflname']):
?><option value="<?php echo $this->_tpl_vars['templid']; ?>
"><?php echo $this->_tpl_vars['tempflname']; ?>
</option><?php endforeach; endif; unset($_from); ?></select>
                                                   <input class="crmbutton small create" value="<?php echo $this->_tpl_vars['APP']['LBL_MERGE_BUTTON_LABEL']; ?>
" onclick="this.form.action.value='Merge';" type="submit" ></input> 
						<?php else: ?>
						<a href=index.php?module=Settings&action=upload&tempModule=<?php echo $this->_tpl_vars['MODULE']; ?>
&parenttab=Settings><?php echo $this->_tpl_vars['APP']['LBL_CREATE_MERGE_TEMPLATE']; ?>
</a>
						<?php endif; ?>
					</td>
      				</tr>
  				</table>
				</form>
				<?php endif; ?>
			</td>
		</tr>
		</table>
		
			
			
		
		</div>
		
	</td>
	-->
</tr>
<?php if ($this->_tpl_vars['MODULE'] == 'OrdresMission' && ( $this->_tpl_vars['CURRENT_USER_PROFIL'] == '27' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '26' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '20' )): ?>
	
													<?php if ($this->_tpl_vars['IS_MISSIONENGAGE'] == '1'): ?>
							<tr><td align=right><input 
											title="<?php echo $this->_tpl_vars['MOD']['LBL_EST_ENGAGE_OM_BUTTON_LABEL']; ?>
" 
											class="crmbutton small edit" 
											disabled="disabled"
											onclick=""
											type="button" 
											name="Edit" 
											value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_EST_ENGAGE_OM_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
						</td></tr>
						<?php else: ?>
							<tr><td align=right><input 
												title="<?php echo $this->_tpl_vars['MOD']['LBL_CREER_ENGAGEMENT_OM_BUTTON_LABEL']; ?>
" 
												class="crmbutton small edit" 
												onclick="return goengagement('<?php echo $this->_tpl_vars['ID']; ?>
');"
												type="button" 
												name="Edit" 
												value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_CREER_ENGAGEMENT_OM_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
							</td></tr>
						<?php endif; ?>
					<?php endif; ?>
	<tr>
		<td>			
			<form action="index.php" method="post" name="DetailView2" id="form2">
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'DetailViewHidden.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
				<tr>
					<td class="dvtTabCacheBottom" style="width:10px" nowrap>&nbsp;</td>
					
					<td class="dvtSelectedCellBottom" align=center nowrap><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['SINGLE_MOD']]; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</td>	
					<td class="dvtTabCacheBottom" style="width:10px">&nbsp;</td>
					<!--
					<?php if ($this->_tpl_vars['SinglePane_View'] == 'false'): ?>
					<td class="dvtUnSelectedCell" align=center nowrap><a href="index.php?action=CallRelatedList&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&record=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['APP']['LBL_MORE']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</a></td>
					<?php endif; ?>
					-->
					<td class="dvtTabCacheBottom" align="right" style="width:100%">
						&nbsp;
						<?php if ($this->_tpl_vars['CURRENT_USER_DO_ACTION'] == 'YES'): ?>
														<?php if (( $this->_tpl_vars['CURRENT_USER_IS_POSTEUR_DEMANDE'] != '0' || $this->_tpl_vars['CURRENT_USER_IS_POSTEUR_INCIDENT'] != '0' || $this->_tpl_vars['CURRENT_USER_IS_ADMIN'] == 'on' || $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == 20 ) && ( $this->_tpl_vars['STATUT'] == 'open' )): ?>
								<input title="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_KEY']; ?>
" class="crmbutton small edit" onclick="this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.return_action.value='DetailView'; this.form.return_id.value='<?php echo $this->_tpl_vars['ID']; ?>
';this.form.module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
';this.form.action.value='EditView'" type="submit"  name="Edit" value="&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
							<?php endif; ?>
																					<?php if (( $this->_tpl_vars['CURRENT_USER_IS_POSTEUR_DEMANDE'] != '0' || $this->_tpl_vars['CURRENT_USER_IS_POSTEUR_INCIDENT'] != '0' || $this->_tpl_vars['CURRENT_USER_IS_ADMIN'] == 'on' || $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == 20 ) && $this->_tpl_vars['STATUT'] == 'open'): ?>
									<input title="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_KEY']; ?>
" class="crmbutton small delete" onclick="this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.return_action.value='index'; this.form.action.value='Delete'; <?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?> return confirm('<?php echo $this->_tpl_vars['APP']['NTC_ACCOUNT_DELETE_CONFIRMATION']; ?>
') <?php else: ?> return confirm('<?php echo $this->_tpl_vars['APP']['NTC_DELETE_CONFIRMATION']; ?>
') <?php endif; ?>" type="submit"  name="Delete" value="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_LABEL']; ?>
">&nbsp;
							<?php endif; ?>
						<?php endif; ?>
						<?php if ($this->_tpl_vars['privrecord'] != ''): ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" onclick="location.href='index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&viewtype=<?php echo $this->_tpl_vars['VIEWTYPE']; ?>
&action=DetailView&record=<?php echo $this->_tpl_vars['privrecord']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
'" name="privrecord" value="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" src="<?php echo vtiger_imageurl('rec_prev.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
						<?php else: ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" src="<?php echo vtiger_imageurl('rec_prev_disabled.gif', $this->_tpl_vars['THEME']); ?>
">
						<?php endif; ?>							
						<?php if ($this->_tpl_vars['privrecord'] != '' || $this->_tpl_vars['nextrecord'] != ''): ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LBL_JUMP_BTN']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_JUMP_BTN']; ?>
" onclick="var obj = this;var lhref = getListOfRecords(obj, '<?php echo $this->_tpl_vars['MODULE']; ?>
',<?php echo $this->_tpl_vars['ID']; ?>
,'<?php echo $this->_tpl_vars['CATEGORY']; ?>
');" name="jumpBtnIdBottom" id="jumpBtnIdBottom" src="<?php echo vtiger_imageurl('rec_jump.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
						<?php endif; ?>
						<?php if ($this->_tpl_vars['nextrecord'] != ''): ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" onclick="location.href='index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&viewtype=<?php echo $this->_tpl_vars['VIEWTYPE']; ?>
&action=DetailView&record=<?php echo $this->_tpl_vars['nextrecord']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
'" name="nextrecord" src="<?php echo vtiger_imageurl('rec_next.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
						<?php else: ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" src="<?php echo vtiger_imageurl('rec_next_disabled.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
						<?php endif; ?>
					</td>
				</tr>
				
			</table>
			</form>
		</td>
	</tr>
	
</table>

<?php if ($this->_tpl_vars['MODULE'] == 'Products'): ?>
<script language="JavaScript" type="text/javascript" src="modules/Products/Productsslide.js"></script>
<script language="JavaScript" type="text/javascript">Carousel();</script>
<?php endif; ?>

<script>

function getTagCloud()
{
new Ajax.Request(
        'index.php',
        {queue: {position: 'end', scope: 'command'},
        method: 'post',
        postBody: 'module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['MODULE']; ?>
Ajax&file=TagCloud&ajxaction=GETTAGCLOUD&recordid=<?php echo $this->_tpl_vars['ID']; ?>
',
        onComplete: function(response) {
                                $("tagfields").innerHTML=response.responseText;
                                $("txtbox_tagfields").value ='';
                        }
        }
);
}
getTagCloud();
</script>
<!-- added for validation -->
<script language="javascript">
  var fieldname = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDNAME']; ?>
);
  var fieldlabel = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDLABEL']; ?>
);
  var fielddatatype = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDDATATYPE']; ?>
);
</script>
</td>

	<td align=right valign=top><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
</tr></table>

<?php if ($this->_tpl_vars['MODULE'] == 'Leads' || $this->_tpl_vars['MODULE'] == 'Contacts' || $this->_tpl_vars['MODULE'] == 'Accounts' || $this->_tpl_vars['MODULE'] == 'Campaigns' || $this->_tpl_vars['MODULE'] == 'Vendors'): ?>
	<form name="SendMail"><div id="sendmail_cont" style="z-index:100001;position:absolute;"></div></form>
<?php endif; ?>

<!-- Add new Folder UI for Documents module starts -->
<script language="JavaScript" type="text/javascript" src="modules/Documents/Documents.js"></script>
<div id="orgLay" style="display:none;width:350px;" class="layerPopup" >
        <table border=0 cellspacing=0 cellpadding=5 width=100% class=layerHeadingULine>
	        <tr>
				<td class="genHeaderSmall" nowrap align="left" width="30%" id="editfolder_info"><?php echo $this->_tpl_vars['MOD']['LBL_ADD_NEW_FOLDER']; ?>

				</td>
				<td align="right"><a href="javascript:;" onClick="closeFolderCreate();"><img src="<?php echo vtiger_imageurl('close.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" border="0"></a>
				</td>
	        </tr>
        </table>
        <table border=0 cellspacing=0 cellpadding=5 width=95% align=center>
        <tr>
			<td class="small">
				<table border=0 celspacing=0 cellpadding=5 width=100% align=center bgcolor=white>
				<tr>
					<td align="right" nowrap class="cellLabel small"><font color='red'>*</font>&nbsp;<b><?php echo $this->_tpl_vars['MOD']['LBL_FOLDER_NAME']; ?>

</b></td>
					<td align="left" class="cellText small">
					<input id="folder_id" name="folderId" type="hidden" value=''>
					<input id="fldrsave_mode" name="folderId" type="hidden" value='save'>
					<input id="folder_name" name="folderName" class="txtBox" type="text"> &nbsp;&nbsp;Maximum 20
					</td>
				</tr>
				<tr>
					<td class="cellLabel small" align="right" nowrap><b><?php echo $this->_tpl_vars['MOD']['LBL_FOLDER_DESC']; ?>
</b>
					</td>
 					<td class="cellText small" align="left"><input id="folder_desc" name="folderDesc" class="txtBox" type="text"> &nbsp;&nbsp;Maximum 50
					</td>
				 </tr>
				 <tr>
					<td class="cellLabel small" align="right" nowrap><b><?php echo $this->_tpl_vars['MOD']['LBL_FOLDER_FATHER']; ?>
</b>
					</td>
 					<td class="cellText small" align="left">
					<select name="folderFather" tabindex="folder_father" class="small">
						<!--<?php $_from = $this->_tpl_vars['fldvalue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>-->	 
						<option value="1">default</option> 
						<!--<?php endforeach; endif; unset($_from); ?>-->
					</select>
					</td>
				 </tr>
				</table>
			</td>
        </tr>
 	</table>
 	
	<table border=0 cellspacing=0 cellpadding=5 width=100% class="layerPopupTransport">
        <tr>
			<td class="small" align="center">
                <input name="save" value=" &nbsp;<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
&nbsp; " class="crmbutton small save" onClick="AddFolder();" type="button">&nbsp;&nbsp;
                <input name="cancel" value=" <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
 " class="crmbutton small cancel" onclick="closeFolderCreate();" type="button">
			</td>
        </tr>
	</table>
</div>

<!-- Add new folder UI for Documents module ends -->







