<?php /* Smarty version 2.6.18, created on 2010-04-19 14:05:11
         compiled from Statistics.tpl */ ?>
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Buttons_List1.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 <table align="center" border=0 cellspacing=0 cellpadding=0 width=90%>
 <tr>
 <td height=25> </td>
 </tr>
 <tr>
  <td width="100%" valign="top" style="padding: 10px;" class="showPanelBg">
  
	
<!-- Generate Report UI Filter -->

<table class="small" align="center" cellpadding="5" cellspacing="0" width="80%" border=0>
<tr>
	<td align=center class=lvtCol width="50%">
	
		<table border=0 cellspacing=0 cellpadding=0 width=100% align=center>
			
			<tr>
				<td align="left" width="50%" class=small><b>Groupe de Traitement</b> </td>
				<td align="left" width="50%" class=small>
				<select name="stdDateFilterField" class="small" style="width:50%" onchange="standardFilterDisplay();"> 
				<!--<?php echo $this->_tpl_vars['BLOCK1']; ?>
-->
				</select>
				</td>
			</tr>
			<tr>		
				<td align=left width="50%" class=small><b>Typologie </b></td>
				<td align="left" width="50%" class=small>
				<select name="stdDateFilter" class="small" onchange='showDateRange( this.options[ this.selectedIndex ].value )' style="width:50%">
				
				
				<!--<?php echo $this->_tpl_vars['BLOCKCRITERIA']; ?>
-->
				</select>
				</td>
			</tr>
		</table>
	
	</td>
	<td align=center class=lvtCol width="50%">
	
						<table border=0 cellspacing=2 cellpadding=2>
							<tr>	
								<td align=left class=small><b> Periode </b></td>
							<tr>
								<td align=left class=small><b>Debut </b></td>
								<td align=left><input name="startdate" id="jscal_field_date_start" type="text" size="10" class="importBox" style="width:70px;" value="<?php echo $this->_tpl_vars['STARTDATE']; ?>
"></td>
								<td valign=absmiddle align=left><img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
btnL3Calendar.gif" id="jscal_trigger_date_start">

							
								<!--<font size="1"><em old="(yyyy-mm-dd)">(<?php echo $this->_tpl_vars['DATEFORMAT']; ?>
)</em></font>-->
									<script type="text/javascript">
										Calendar.setup ({
										inputField : "jscal_field_date_start", ifFormat : "<?php echo $this->_tpl_vars['JS_DATEFORMAT']; ?>
", showsTime : false, button : "jscal_trigger_date_start", singleClick : true, step : 1
										});
									</script>
			
								</td>
								<td>&nbsp;</td>
								<td align=left class=small><b>Fin </b></td>
								<td align=left><input name="enddate" id="jscal_field_date_end" type="text" size="10" class="importBox" style="width:70px;" value="<?php echo $this->_tpl_vars['ENDDATE']; ?>
"></td>
								<td valign=absmiddle align=left><img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
btnL3Calendar.gif" id="jscal_trigger_date_end">
								
								<!--<font size="1"><em old="(yyyy-mm-dd)">(<?php echo $this->_tpl_vars['DATEFORMAT']; ?>
)</em></font>-->
									<script type="text/javascript">
										Calendar.setup ({
										inputField : "jscal_field_date_end", ifFormat : "<?php echo $this->_tpl_vars['JS_DATEFORMAT']; ?>
", showsTime : false, button : "jscal_trigger_date_end", singleClick : true, step : 1
										});
									</script>
								</td>
							</tr>
						</table>
									
	</td>
</tr>
<tr>
	<td align="center" colspan="8" style="padding:5px"><input name="generatenw" value="Filtrer" class="crmbutton small create" type="button" onClick="generateReport(<?php echo $this->_tpl_vars['REPORTID']; ?>
);"></td>
</tr>

<tr>
 <td colspan=2>	
 <table align="center" border="0" cellpadding="5" cellspacing="1" width="90%">

			<tr>
				<td colspan=2>
					<table align="center" class="lvt small" border="0" cellpadding="5" cellspacing="1" width="100%">
				
							<tr class="lvtColData" onmouseover="this.className='lvtColDataHover'" onmouseout="this.className='lvtColData'" bgcolor="white">
								<td width="35%"><b><?php echo $this->_tpl_vars['MOD']['LBL_NB_INCIDENTS_DEMANDES_DECLARES']; ?>
</b></td>
								<td width="50%"><b><?php echo $this->_tpl_vars['NB_INCIDENTS_DEMANDES_DECLARES']; ?>
<b></td>
							</tr>
							
					</table>
				</td>
			</tr>
			
			<tr>
				<td>
					<table align="center" class="lvt small" border="0" cellpadding="5" cellspacing="1" width="100%">
						<tr>
						  <td height=25 colspan=2><b> <?php echo $this->_tpl_vars['MOD']['LBL_INCIDENTS']; ?>
 </b></td>
						</tr>
						<tr>
							<td class="lvtCol" width="35%"> <?php echo $this->_tpl_vars['MOD']['LBL_INCIDENTS_DESIGNATION']; ?>
 </td>
							<td class="lvtCol" width="50%"> <?php echo $this->_tpl_vars['MOD']['LBL_INCIDENTS_QUANTITE']; ?>
 </td>
						</tr>
						<tr class="lvtColData" onmouseover="this.className='lvtColDataHover'" onmouseout="this.className='lvtColData'" bgcolor="white">
							<td> <?php echo $this->_tpl_vars['MOD']['LBL_INCIDENTS_NB_DECLARES']; ?>
 </td>
							<td><b> <?php echo $this->_tpl_vars['INCIDENTS_NB_DECLARES']; ?>
 <b></td>
						</tr>
						<tr class="lvtColData" onmouseover="this.className='lvtColDataHover'" onmouseout="this.className='lvtColData'" bgcolor="white">
							<td> <?php echo $this->_tpl_vars['MOD']['LBL_INCIDENTS_NB_TRAITES_DANS_DELAIS']; ?>
 </td>
							<td><b> <?php echo $this->_tpl_vars['INCIDENTS_NB_TRAITES_DANS_DELAIS']; ?>
 <b></td>
						</tr>
						<tr class="lvtColData" onmouseover="this.className='lvtColDataHover'" onmouseout="this.className='lvtColData'" bgcolor="white">
							<td> <?php echo $this->_tpl_vars['MOD']['LBL_INCIDENTS_NB_TRAITES_AU_DELA_DELAIS']; ?>
 </td>
							<td><b> <?php echo $this->_tpl_vars['INCIDENTS_NB_TRAITES_AU_DELA_DELAIS']; ?>
 <b></td>
						</tr>
						<tr class="lvtColData" onmouseover="this.className='lvtColDataHover'" onmouseout="this.className='lvtColData'" bgcolor="white">
							<td> <?php echo $this->_tpl_vars['MOD']['LBL_INCIDENTS_NB_EN_SOUFFRANCE']; ?>
 </td>
							<td><b> <?php echo $this->_tpl_vars['INCIDENTS_NB_EN_SOUFFRANCE']; ?>
 <b></td>
						</tr>
						<tr class="lvtColData" onmouseover="this.className='lvtColDataHover'" onmouseout="this.className='lvtColData'" bgcolor="white">
					        <td> <?php echo $this->_tpl_vars['MOD']['LBL_INCIDENTS_TAUX_TRAITEMENT']; ?>
 </td>
					        <td><b> <?php echo $this->_tpl_vars['INCIDENTS_TAUX_TRAITEMENT']; ?>
 <b></td>
						</tr>
						<tr class="lvtColData" onmouseover="this.className='lvtColDataHover'" onmouseout="this.className='lvtColData'" bgcolor="white">
					        <td> <?php echo $this->_tpl_vars['MOD']['LBL_INCIDENTS_DUREE_MOYENNE_TRAITEMENT']; ?>
 </td>
					        <td><b> <?php echo $this->_tpl_vars['INCIDENTS_DUREE_MOYENNE_TRAITEMENT']; ?>
<b></td>
						</tr>
						<tr class="lvtColData" onmouseover="this.className='lvtColDataHover'" onmouseout="this.className='lvtColData'" bgcolor="white">
					        <td> <?php echo $this->_tpl_vars['MOD']['LBL_INCIDENTS_NB_ORIGINE_INTERNE']; ?>
 </td>
					        <td><b> <?php echo $this->_tpl_vars['INCIDENTS_NB_ORIGINE_INTERNE']; ?>
 <b></td>
						</tr>
						<tr class="lvtColData" onmouseover="this.className='lvtColDataHover'" onmouseout="this.className='lvtColData'" bgcolor="white">
					        <td> <?php echo $this->_tpl_vars['MOD']['LBL_INCIDENTS_NB_ORIGINE_EXTERNE']; ?>
 </td>
					        <td><b> <?php echo $this->_tpl_vars['INCIDENTS_NB_ORIGINE_EXTERNE']; ?>
 <b></td>
						</tr>
						
					 </table>
				 </td>
				 <td>	
					<table align="center" class="lvt small" border="0" cellpadding="5" cellspacing="1" width="100%">
						<tr>
						  <td height=25 colspan=2><b> <?php echo $this->_tpl_vars['MOD']['LBL_DEMANDES']; ?>
 </b></td>
						</tr>
						<tr>
							<td class="lvtCol" width="35%"> <?php echo $this->_tpl_vars['MOD']['LBL_DEMANDES_DESIGNATION']; ?>
 </td>
							<td class="lvtCol" width="50%"> <?php echo $this->_tpl_vars['MOD']['LBL_DEMANDES_QUANTITE']; ?>
 </td>
						</tr>
						<tr class="lvtColData" onmouseover="this.className='lvtColDataHover'" onmouseout="this.className='lvtColData'" bgcolor="white">
							<td> <?php echo $this->_tpl_vars['MOD']['LBL_DEMANDES_NB_DECLARES']; ?>
 </td>
							<td><b> <?php echo $this->_tpl_vars['DEMANDES_NB_DECLARES']; ?>
 <b></td>
						</tr>
						<tr class="lvtColData" onmouseover="this.className='lvtColDataHover'" onmouseout="this.className='lvtColData'" bgcolor="white">
							<td> <?php echo $this->_tpl_vars['MOD']['LBL_DEMANDES_NB_TRAITES_DANS_DELAIS']; ?>
 </td>
							<td><b> <?php echo $this->_tpl_vars['DEMANDES_NB_TRAITES_DANS_DELAIS']; ?>
 <b></td>
						</tr>
						<tr class="lvtColData" onmouseover="this.className='lvtColDataHover'" onmouseout="this.className='lvtColData'" bgcolor="white">
							<td> <?php echo $this->_tpl_vars['MOD']['LBL_DEMANDES_NB_TRAITES_AU_DELA_DELAIS']; ?>
 </td>
							<td><b> <?php echo $this->_tpl_vars['DEMANDES_NB_TRAITES_AU_DELA_DELAIS']; ?>
 <b></td>
						</tr>
						<tr class="lvtColData" onmouseover="this.className='lvtColDataHover'" onmouseout="this.className='lvtColData'" bgcolor="white">
							<td> <?php echo $this->_tpl_vars['MOD']['LBL_DEMANDES_NB_EN_SOUFFRANCE']; ?>
 </td>
							<td><b> <?php echo $this->_tpl_vars['DEMANDES_NB_EN_SOUFFRANCE']; ?>
 <b></td>
						</tr>
						<tr class="lvtColData" onmouseover="this.className='lvtColDataHover'" onmouseout="this.className='lvtColData'" bgcolor="white">
					        <td> <?php echo $this->_tpl_vars['MOD']['LBL_DEMANDES_TAUX_TRAITEMENT']; ?>
 </td>
					        <td><b> <?php echo $this->_tpl_vars['DEMANDES_TAUX_TRAITEMENT']; ?>
 <b></td>
						</tr>
						<tr class="lvtColData" onmouseover="this.className='lvtColDataHover'" onmouseout="this.className='lvtColData'" bgcolor="white">
					        <td> <?php echo $this->_tpl_vars['MOD']['LBL_DEMANDES_DUREE_MOYENNE_TRAITEMENT']; ?>
 </td>
					        <td><b> <?php echo $this->_tpl_vars['DEMANDES_DUREE_MOYENNE_TRAITEMENT']; ?>
 <b></td>
						</tr>
						<tr class="lvtColData" onmouseover="this.className='lvtColDataHover'" onmouseout="this.className='lvtColData'" bgcolor="white">
					        <td> <?php echo $this->_tpl_vars['MOD']['LBL_DEMANDES_NB_ORIGINE_INTERNE']; ?>
 </td>
					        <td><b> <?php echo $this->_tpl_vars['DEMANDES_NB_ORIGINE_INTERNE']; ?>
 <b></td>
						</tr>
						<tr class="lvtColData" onmouseover="this.className='lvtColDataHover'" onmouseout="this.className='lvtColData'" bgcolor="white">
					        <td> <?php echo $this->_tpl_vars['MOD']['LBL_DEMANDES_NB_ORIGINE_EXTERNE']; ?>
 </td>
					        <td><b> <?php echo $this->_tpl_vars['DEMANDES_NB_ORIGINE_EXTERNE']; ?>
 <b></td>
						</tr>
					
					</table>
				</td>
			</tr>
		</table>
 	</td>
 </tr>

</table>



</div>









