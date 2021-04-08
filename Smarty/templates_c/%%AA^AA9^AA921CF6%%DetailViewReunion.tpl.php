<?php /* Smarty version 2.6.18, created on 2019-01-29 14:49:08
         compiled from DetailViewReunion.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'DetailViewReunion.tpl', 204, false),array('modifier', 'number_format', 'DetailViewReunion.tpl', 557, false),array('modifier', 'replace', 'DetailViewReunion.tpl', 604, false),array('function', 'html_options', 'DetailViewReunion.tpl', 719, false),)), $this); ?>
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
					<?php if ($this->_tpl_vars['IS_AGENTDB'] == '1' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '20'): ?>
					<td class="dvtUnSelectedCell" align=center nowrap><a href="index.php?action=Engagement&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&record=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['MOD']['LBL_ENGAGEMENT_BUTTON_LABEL']; ?>
</a></td>
					<?php endif; ?>
				
					<td class="dvtTabCache" align="right" style="width:100%">
                    				

					
					<?php if (( $this->_tpl_vars['IS_POSTEURDEMANDE'] == '1' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '20' ) && ( $this->_tpl_vars['STATUT'] != 'mt_cancelled' || $this->_tpl_vars['STATUT'] != 'cancelled' )): ?>
						
						
						<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_CANCELREUNION_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Reunion'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementReunions';
												this.form.action.value='EditView';
												this.form.statut.value='mt_cancelled';
												return AnnulerReunion('Reunion');"
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_CANCELREUNION_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
							
							
						<input title="<?php echo $this->_tpl_vars['MOD']['LBL_DOCREUNION_BUTTON_LABEL']; ?>
" class="crmbutton small edit" 
										onclick="window.open('http://ouavlibre01/portailnomade/reunions/reunion.php?reunionid=<?php echo $this->_tpl_vars['ID']; ?>
','','');return false;"   
										type="submit"  
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_DOCREUNION_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
						<?php if ($this->_tpl_vars['STATUT'] != 'db_accepted'): ?>				
							<input title="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_KEY']; ?>
" class="crmbutton small edit" onclick="this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.return_action.value='DetailView'; this.form.return_id.value='<?php echo $this->_tpl_vars['ID']; ?>
';this.form.module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
';this.form.action.value='EditView'" type="submit" name="Edit" value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
						<?php endif; ?>
						<input 
							title="<?php echo $this->_tpl_vars['MOD']['LBL_ADD_BUDGETCOMPLEMENTAIRE_BUTTON_LABEL']; ?>
" 
							class="crmbutton small edit" 
							
							onclick="this.form.return_module.value='Reunion'; 
								this.form.return_action.value='DetailView'; 
								this.form.module.value='Reunion';
								this.form.action.value='EditViewBC';
								this.form.statut.value='openbc';
								return AjoutBudgetCompl('Reunion');"   
						type="submit"  
						name="Edit"
							value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_ADD_BUDGETCOMPLEMENTAIRE_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
						<?php if ($this->_tpl_vars['IS_DEMANDEVALIDE'] == '1'): ?>
						
							<?php if ($this->_tpl_vars['STATUT'] == 'open'): ?>
								<input 
									title="<?php echo $this->_tpl_vars['MOD']['LBL_SOUMETTRE_BUTTON_LABEL']; ?>
" 
									class="crmbutton small edit" 
									onclick="this.form.return_module.value='Reunion'; 
										this.form.return_action.value='DetailView'; 
										this.form.module.value='TraitementReunions';
										this.form.action.value='Save';
										this.form.statut.value='dc_submitted';
										return soumettreReunion('Reunion');"   
								type="submit"  
								name="Edit" 
									value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_SOUMETTRE_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
												
							
							<?php elseif ($this->_tpl_vars['STATUT'] == 'db_accepted'): ?>
								<input title="<?php echo $this->_tpl_vars['MOD']['LBL_ADD_SIGNATAIRE_BUTTON_LABEL']; ?>
" class="crmbutton small edit" 
								onclick="AddSignataire();"   
								type="button"  
								name="Edit" 
								value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_ADD_SIGNATAIRE_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;	
						
													
							<?php else: ?>
								<input 
									title="<?php echo $this->_tpl_vars['MOD']['LBL_REMETTREENPREPA_BUTTON_LABEL']; ?>
" 
									class="crmbutton small edit" 
									
									onclick="this.form.return_module.value='Reunion'; 
										this.form.return_action.value='DetailView'; 
										this.form.module.value='TraitementReunions';
										this.form.action.value='Save';
										this.form.statut.value='open';
										return remettreReunionEnPrepa('Reunion');"   
								type="submit"  
								name="Edit"
									value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_REMETTREENPREPA_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
						<?php endif; ?>	
						
					<?php endif; ?>	
					<?php endif; ?>			

					<?php if (( $this->_tpl_vars['CURRENT_USER_PROFIL'] == '22' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '20' || $this->_tpl_vars['IS_INTERIMDIRCAB'] == '1' ) && $this->_tpl_vars['STATUT'] == 'dc_submitted'): ?> 							<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_REJET_DC_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Reunion'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementReunions';
												this.form.action.value='EditView';
												this.form.statut.value='dc_denied';
												return RejeterReunion('Reunion');"
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_REJET_DC_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
																		
						<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_VISER_DC_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Reunion'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='TraitementReunions';
											this.form.action.value='Save';
											this.form.statut.value='dc_authorized';
											return ViserReunion('Reunion');"   
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_VISER_DC_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;

					<?php endif; ?>
						
					<?php if (( $this->_tpl_vars['IS_AGENTDB'] == '1' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '20' )): ?> 							
								<?php if ($this->_tpl_vars['STATUT'] == 'dc_authorized' || $this->_tpl_vars['STATUT'] == 'db_accepted'): ?>
									<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_CREATEDECISION_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="return SaisirDecision(<?php echo $this->_tpl_vars['ID']; ?>
);"   
										type="button"  
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_CREATEDECISION_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
								<?php endif; ?>	
								
								<?php if ($this->_tpl_vars['STATUT'] == 'dc_authorized'): ?>						
										<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_REJET_DB_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Reunion'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementReunions';
												this.form.action.value='EditView';
												this.form.statut.value='db_denied';
												return RejeterReunion('Reunion');"
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_REJET_DB_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
							
										
									<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_VISER_DB_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Reunion'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='TraitementReunions';
											this.form.action.value='Save';
											this.form.statut.value='db_accepted';
											return ViserReunion('Reunion');"   
										type="submit" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_VISER_DB_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
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
				
			</form>
			<form action="index.php" method="post" name="DetailView" id="form3">
			
		<?php if ($this->_tpl_vars['MODULE'] == 'Reunion'): ?>
			<?php if ($this->_tpl_vars['STATUT'] == 'open'): ?>
				<tr><td align="left" ><img src="<?php echo vtiger_imageurl('open_reunion.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			<?php endif; ?>
				
			<?php if ($this->_tpl_vars['STATUT'] == 'submitted'): ?>
				<tr><td align="left" ><img src="<?php echo vtiger_imageurl('submitted_reunion.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>				
			<?php endif; ?>	
			<?php if ($this->_tpl_vars['STATUT'] == 'dc_accepted'): ?>
				<tr><td align="left" ><img src="<?php echo vtiger_imageurl('dc_accepted_reunion.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['STATUT'] == 'dc_cancelled' || $this->_tpl_vars['STATUT'] == 'dc_denied'): ?>
				<tr><td align="left" ><img src="<?php echo vtiger_imageurl('dc_denied_reunion.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['STATUT'] == 'db_accepted'): ?>
				<tr><td align="left" ><img src="<?php echo vtiger_imageurl('db_accepted_reunion.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			<?php endif; ?>
			
			<?php if ($this->_tpl_vars['STATUT'] == 'db_denied'): ?>
				<tr><td align="left" ><img src="<?php echo vtiger_imageurl('db_denied_reunion.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			<?php endif; ?>
			
			<?php if ($this->_tpl_vars['STATUT'] == 'dcf_accepted'): ?>
				<tr><td align="left" ><img src="<?php echo vtiger_imageurl('dcf_accepted_reunion.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['STATUT'] == 'dcf_denied'): ?>
				<tr><td align="left" ><img src="<?php echo vtiger_imageurl('dcf_denied_reunion.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			<?php endif; ?>
			
			<?php if ($this->_tpl_vars['STATUT'] == 'com_cancelled' || $this->_tpl_vars['STATUT'] == 'com_denied'): ?>
				<tr><td align="left" ><img src="<?php echo vtiger_imageurl('com_denied_reunion.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			<?php endif; ?>
			
			<?php if ($this->_tpl_vars['STATUT'] == 'mtgenered'): ?>
				<tr><td align="left" ><img src="<?php echo vtiger_imageurl('prgenered.png', $this->_tpl_vars['THEME']); ?>
"></td></tr>
			<?php endif; ?>

			
		<?php endif; ?>
		
		<?php if ($this->_tpl_vars['IS_DEMANDEVALIDE'] == '0'): ?>
			<!-- Demande de transfert nécessaire sur certains comptes natures -->
			<tr><td align=center><font color='red'><b>Vous devez effectuer des Virements / Transferts sur les lignes en rouge avant de pouvoir soumettre cette demande de r&eacute;union!!!</b></font></td></tr>
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
					
							<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_REUNION_DEPENSES'] && $this->_tpl_vars['MODULE'] == 'Reunion'): ?>
									<tr>
										<td colspan=5 class="detailedViewHeader" align=center>
											<font color='red'><b><?php echo $this->_tpl_vars['BUDGETDISP']['msgErreurSap']; ?>
</b></font>
										</td>
										
									</tr>
									<tr>
											<td colspan=5 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
										
									</tr>
									<tr><td colspan=5 >
									<table width=99% border=1>
									<tr>
										<td class="detailedViewHeader" ><b>LIBELLE</b></td>
										<td class="detailedViewHeader" align="center"><b>QUANTITE</b></td>
										<td class="detailedViewHeader" align="center"><b>NOMBRE</b></td>
										<td class="detailedViewHeader" align="center"><b>PRIX UNITAIRE</b></td>
										<td class="detailedViewHeader" align="center"><b>TOTAL (FCFA)</b></td>
										
									</tr>
									<?php $this->assign('totaldepreunion', 0); ?>
									<?php $_from = $this->_tpl_vars['NATDEPENSES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['comptenat'] => $this->_tpl_vars['natdepense']):
?>
										<tr>
											<td colspan=5 class="detailedViewHeader">
												<table width=99% border=0>
													<tr>
														<td colspan=4>
															<b><?php echo $this->_tpl_vars['natdepense']['libnatdepense']; ?>
 (<?php echo $this->_tpl_vars['comptenat']; ?>
)</b>
														</td>
														<td align=right>
															<?php if ($this->_tpl_vars['BUDGETDISP'][$this->_tpl_vars['CODEBUDGET']][$this->_tpl_vars['comptenat']]['mntdispo'] != '' && $this->_tpl_vars['BUDGETDISP'][$this->_tpl_vars['CODEBUDGET']][$this->_tpl_vars['comptenat']]['mntdispo'] != '0'): ?>
																<b>Montant disponible : <font color='green'><?php echo ((is_array($_tmp=$this->_tpl_vars['BUDGETDISP'][$this->_tpl_vars['CODEBUDGET']][$this->_tpl_vars['comptenat']]['mntdispo'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
 FCFA </font></b>
															<?php else: ?>
																<b>Montant disponible : 0 FCFA</b>
															<?php endif; ?>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<?php $_from = $this->_tpl_vars['natdepense']['depenses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['lignedepense']):
?>
											<tr>
												<td ><?php echo $this->_tpl_vars['lignedepense']['libdepense']; ?>
</td>
												<td align="center"><?php echo $this->_tpl_vars['lignedepense']['qtedepense']; ?>
</td>
												<td align="center"><?php echo $this->_tpl_vars['lignedepense']['nbredepense']; ?>
</td>
												<td align=right><?php echo ((is_array($_tmp=$this->_tpl_vars['lignedepense']['pudepense'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</td>
												<td align=right><?php echo ((is_array($_tmp=$this->_tpl_vars['lignedepense']['totaldepense'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</td>
												</tr>
										<?php endforeach; endif; unset($_from); ?>
											<tr>
												<td colspan=4 align="right">
													<b>TOTAL&nbsp;</b>
												</td>
												<td align=right>
												<?php if ($this->_tpl_vars['natdepense']['totaldepense'] > $this->_tpl_vars['BUDGETDISP'][$this->_tpl_vars['CODEBUDGET']][$this->_tpl_vars['comptenat']]['mntdispo']): ?>
													<font color='red'><b><?php echo ((is_array($_tmp=$this->_tpl_vars['natdepense']['totaldepense'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</b></font>
												<?php else: ?>
													<b><?php echo ((is_array($_tmp=$this->_tpl_vars['natdepense']['totaldepense'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</b>
												<?php endif; ?>
												</td>
												
											</tr>
											<?php $this->assign('totaldepreunion', $this->_tpl_vars['totaldepreunion']+$this->_tpl_vars['natdepense']['totaldepense']); ?>
									<?php endforeach; endif; unset($_from); ?>
									<tr><td colspan=4 align=right><b><font color='blue'>BUDGET TOTAL DE L'ACTIVITE</font></b></td>
									<td align=right><b><font color='blue'><?php echo ((is_array($_tmp=$this->_tpl_vars['totaldepreunion'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
 FCFA</font></b></td></tr>
									</table>
										</td>
										
									</tr>
							<?php elseif ($this->_tpl_vars['header'] != 'Comments'): ?>
 
							<tr>
							<?php echo '<td colspan=2 class="dvInnerHeader"><div style="float:left;font-weight:bold;"><div style="float:left;"><a href="javascript:showHideStatus(\'tbl'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?><?php echo '\',\'aid'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?><?php echo '\',\''; ?><?php echo $this->_tpl_vars['IMAGE_PATH']; ?><?php echo '\');">'; ?><?php if ($this->_tpl_vars['BLOCKINITIALSTATUS'][$this->_tpl_vars['header']] == 1): ?><?php echo '<img id="aid'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?><?php echo '" src="'; ?><?php echo vtiger_imageurl('activate.gif', $this->_tpl_vars['THEME']); ?><?php echo '" style="border: 0px solid #000000;" alt="Hide" title="Hide"/>'; ?><?php else: ?><?php echo '<img id="aid'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?><?php echo '" src="'; ?><?php echo vtiger_imageurl('inactivate.gif', $this->_tpl_vars['THEME']); ?><?php echo '" style="border: 0px solid #000000;" alt="Display" title="Display"/>'; ?><?php endif; ?><?php echo '</a></div><b>&nbsp;'; ?><?php echo $this->_tpl_vars['header']; ?><?php echo '</b></div></td>'; ?>

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
										
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_REUNION_DEPENSES'] && $this->_tpl_vars['MODULE'] == 'Reunion'): ?>
									<tr  style="display:none; height:25px">	
											
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
								

								
							</table>
						</div>
						<?php endif; ?>
                     	                      </td>
					   </tr>
			                                                                                                    
		<td style="padding:10px">
			<?php endforeach; endif; unset($_from); ?>
                     
			</td>
                </tr>
		<tr><td>
		<div id='divsignataire'  style='display:none;'>
				<table width="90%" align=center border=1 cellspacing=1 cellpadding=3 width=100% class="lvt small" valign=top>
					
						<tr><th colspan=3 align=center>MODIFICATION TIMBRES ET SIGNATAIRES</th><tr>
						
					
				<tr align=center>
						<td class="detailedViewHeader2" ><b>&nbsp;</b></td>
						<td class="detailedViewHeader2" ><b>Timbre</b></td>
						<td class="detailedViewHeader2" ><b>Signataire</b></td>

					</tr>
					<tr align=center>
						<td class="detailedViewHeader2" ><b>Directeur de Cabinet</b></td>
						<td class="dvtCellInfo">
							<select name="timbredc"  class="small" id="timbredc" style="width:230px;">
								<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['TIMBRESDC'],'selected' => $this->_tpl_vars['TIMBRESDCSELECT']), $this);?>

							</select>
						</td>
						<td class="dvtCellInfo">
							<select name="signatairedc"  class="small" id="signatairedc" style="width:230px;">
								<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['SIGNATAIRES'],'selected' => $this->_tpl_vars['SIGNATAIREDCSELECT']), $this);?>

							</select>
						</td>
								
					</tr>	
					<tr align=center>
						<td class="detailedViewHeader2" ><b>Commissaire</b></td>
						<td class="dvtCellInfo">
							<select name="timbrecom"  class="small" id="timbrecom" style="width:230px;">
								<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['TIMBRESCOM'],'selected' => $this->_tpl_vars['TIMBRESCOMSELECT']), $this);?>

							</select>
						</td>
						<td class="dvtCellInfo">
							<select name="signatairecom"  class="small" id="signatairecom" style="width:230px;">
								<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['SIGNATAIRES'],'selected' => $this->_tpl_vars['SIGNATAIRECOMSELECT']), $this);?>

							</select>
						</td>
								
					</tr>	
					<tr><td colspan=3 align=right>
							<input title="<?php echo $this->_tpl_vars['MOD']['LBL_SAVE_BUTTON_LABEL']; ?>
" class="crmbutton small edit" 
								onclick="saveSignataire('<?php echo $this->_tpl_vars['ID']; ?>
');"   
								type="button"  
								name="Edit" 
								value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_SAVE_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
							<input title="<?php echo $this->_tpl_vars['MOD']['LBL_BACK_BUTTON_LABEL']; ?>
" class="crmbutton small edit" 
								onclick="AnnulerSignataire();"   
								type="button"  
								name="Edit" 
								value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_BACK_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;							
						</td></tr>
				</table>
		</div>
		</td>
                </tr>
		<tr><td>
		<div id='divdecision'  style='display:none;'>
				<table width="90%" align=center border=1 cellspacing=1 cellpadding=3 width=100% class="lvt small" valign=top>
					
						<tr><th colspan=3 align=center>CAISSE AVANCE (AU BESOIN) ET R&Eacute;GISSEUR</th><tr>
						
					
				<tr align=center>		
						<td class="detailedViewHeader2" ><b>R&eacute;gisseur</b></td>

					</tr>
					<tr align=center>
						<td class="dvtCellInfo" colspan=2>
							<select name="regisseur"  class="small" id="regisseur" style="width:230px;">
								<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['LISTREGISSEURS'],'selected' => $this->_tpl_vars['REGISSEURSELECT']), $this);?>

							</select>
						</td>
								
					</tr>	
					<tr><td  align=right>
							<input title="<?php echo $this->_tpl_vars['MOD']['LBL_SAVEMODIFDECISION_BUTTON_LABEL']; ?>
" class="crmbutton small edit" 
								onclick="saveDecision('<?php echo $this->_tpl_vars['ID']; ?>
');"   
								type="button"  
								name="Edit" 
								value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_SAVEMODIFDECISION_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
							<input title="<?php echo $this->_tpl_vars['MOD']['LBL_CANCELMODIFDECISION_BUTTON_LABEL']; ?>
" class="crmbutton small edit" 
								onclick="AnnulerDecision();"   
								type="button"  
								name="Edit" 
								value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_CANCELMODIFDECISION_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;							
						</td></tr>
				</table>
		</div>
		</td>
                </tr>
		
				<?php if ($this->_tpl_vars['MODULE'] == 'Demandes' || $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
					<tr><td class="small"><b><u>Initiateur demande</u> : <?php echo $this->_tpl_vars['POSTEURDEMANDE']; ?>
<b></td></tr>	
				<?php endif; ?>	
				
				<!--tr><td>
				<div id='divdecompteview'>
				<table width="90%" align=center border=1 cellspacing=1 cellpadding=3 width=100% class="lvt small" valign=top>
				<caption class="big2" align=center> INFORMATION DISPONIBITE DES CREDITS</caption>
					
				<tr align=center>		
						<td class="detailedViewHeader2"><b>Code Budgétaire</b></td>
						<td class="detailedViewHeader2"><b>Nature Dépense</b></td>
						<td class="detailedViewHeader2"><b>Autorisation d'engagement</b></td>
						<td class="detailedViewHeader2"><b>Montant Engagé</b></td>
						<td class="detailedViewHeader2"><b>Montant Disponible</b></td>
				</tr>
				<?php $this->assign('totalbudget', 0); ?>
				<?php $_from = $this->_tpl_vars['BUDGETDISP']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['codebudg'] => $this->_tpl_vars['budget']):
?>
					<tr align=center>
						<td class="detailedViewHeader2" rowspan=20><b><?php echo $this->_tpl_vars['codebudg']; ?>
</b></td>
					<?php $_from = $this->_tpl_vars['budget']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ligne']):
?>
						<tr>					
						<td class="detailedViewHeader2"><?php echo $this->_tpl_vars['ligne']['comptenatlib']; ?>
 (<?php echo $this->_tpl_vars['ligne']['comptenat']; ?>
)</td>
						<td class="detailedViewHeader2"  align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['ligne']['fonddisp'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</td>
						<td class="detailedViewHeader2"  align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['ligne']['fondengage'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</td>
						<td class="detailedViewHeader2"  align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['ligne']['mntdispo'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</td>
						</tr>
						<?php $this->assign('totalbudget', $this->_tpl_vars['totalbudget']+$this->_tpl_vars['ligne']['mntdispo']); ?>

					<?php endforeach; endif; unset($_from); ?>
					</tr>	
				<?php endforeach; endif; unset($_from); ?>
				<tr align=center>
						<td class="detailedViewHeader2" colspan=3 align=right><b>TOTAL BUDGET DISPONIBLE</b></td>
						<td class="detailedViewHeader2"  align="right"><b><?php echo ((is_array($_tmp=$this->_tpl_vars['totalbudget'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</b></td>
				</table>
			</div>
			
			</td></tr-->	
			<?php if ($this->_tpl_vars['MODULE'] == 'Reunion'): ?>
					<tr><td>&nbsp;</td></tr>
					<tr><td class="small"><b><u>Inititeur R&eacute;union</u> : <?php echo $this->_tpl_vars['POSTEURDEMANDE']; ?>
<b></td></tr>	
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
			
 				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'ListViewTraitementReunions.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 			
		</table>
		
		
			
		
		 <input type="hidden" id="demandeid" name="demandeid" value=<?php echo $this->_tpl_vars['ID']; ?>
></input>
		<input type="hidden" id="demandeticket" name="demandeticket" value=<?php echo $this->_tpl_vars['TICKET']; ?>
></input>
			
		</td>
		
</tr>
</form>
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







