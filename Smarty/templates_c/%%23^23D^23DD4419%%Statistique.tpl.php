<?php /* Smarty version 2.6.18, created on 2011-02-23 19:18:15
         compiled from Statistique.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'Statistique.tpl', 317, false),)), $this); ?>
<script language="JavaScript" type="text/javascript" src="include/js/ListView.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/search.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/Merge.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/dtlviewajax.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script language="JavaScript" type="text/javascript" src="jscalendar/calendar.js"></script>
<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
<script language="JavaScript" type="text/javascript" src="jscalendar/calendar-setup.js"></script>

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

<script language="javascript">
function callFilter()
{
			
	var urlstring = '';
	
	var cc_field_val = $('filter_cc_field').options[$('filter_cc_field').selectedIndex].value;
	var bareme_field_val = $('filter_bareme_field').options[$('filter_bareme_field_val').selectedIndex].value;
	var campagne_val = $('filter_campagne_field').options[$('filter_campagne_field').selectedIndex].value;
	var date_start_val = encodeURIComponent(document.basicFilter.jscal_field_date_start.value);
	var date_end_val = encodeURIComponent(document.basicFilter.jscal_field_date_end.value);

	urlstring += 'bareme_field='+bareme_field_val+'&';
	urlstring += 'cc_field='+cc_field_val+'&';
	urlstring += 'campagne_field='+campagne_val+'&';
	urlstring += 'date_start='+date_start_val+'&';
	urlstring += 'date_end='+date_end_val+'&';
	

	$("status").style.display="inline";
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody:urlstring +'filter=true&file=index&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['MODULE']; ?>
Ajax&ajax=true&search=true',
	//		postBody:urlstring +'filter=true&file=DetailView&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['MODULE']; ?>
Ajax&ajax=true&search=true',
			onComplete: function(response) {
								$("status").style.display="none";
                                result = response.responseText.split('&#&#&#');
                                $("ListViewContents").innerHTML= result[2];
                                if(result[1] != '')
									alert(result[1]);
			}
	       }
        );
		
	return false

}

</script>


<div id="lstRecordLayout" class="layerPopup" style="display:none;width:325px;height:300px;"></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Buttons_List1.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>



<!-- FILTRE -->

<div id="filterAcc" style="z-index:1;display:<?php echo $this->_tpl_vars['FILTER']; ?>
;position:relative;">
	<form name="basicFilter" method="post" action="index.php" onSubmit="return callFilter();">
	
		<table width="80%" cellpadding="2" cellspacing="2"  class="searchUIBasic small" align="center" border=0>
			<tr>
				<td class="dvtCellLabel small" colspan="2" nowrap align="center">
				<?php echo $this->_tpl_vars['APP']['LBL_FILTER']; ?>

				</td>
				
				<td class="small" valign="top" colspan="1" align="right" onMouseOver="this.style.cursor='pointer';" onclick="moveMe('filterAcc');searchshowhide('filterAcc','advSearch')">[x]</td>
			</tr>
			<tr>
				
				<td class=small cellpadding="2" colspan="2" cellspacing="4" width="100%" align=center>
					
					<b> <?php echo $this->_tpl_vars['APP']['LNK_LIST_START']; ?>
 </b>&nbsp;
					<input readonly name="date_start" value="<?php echo $this->_tpl_vars['MYSELECTED_DS']; ?>
" id="jscal_field_date_start" type="text" style="border:1px solid #bababa;" size="11" maxlength="10">&nbsp;
					<img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
btnL3Calendar.gif" id="jscal_trigger_date_start" height=20 width=20>
					
					<script type="text/javascript" id='massedit_calendar_date_start'>
						Calendar.setup ({
						inputField : "jscal_field_date_start", ifFormat : "<?php echo $this->_tpl_vars['JS_DATEFORMAT']; ?>
", showsTime : false, button : "jscal_trigger_date_start", singleClick : true, step : 1
						});
					</script>
			   	
					&nbsp;&nbsp;&nbsp;<b><?php echo $this->_tpl_vars['APP']['LNK_LIST_END']; ?>
</b>&nbsp;
					<input readonly name="date_end" value="<?php echo $this->_tpl_vars['MYSELECTED_DE']; ?>
" id="jscal_field_date_end" type="text" style="border:1px solid #bababa;" size="11" maxlength="10">&nbsp;
					<img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
btnL3Calendar.gif" id="jscal_trigger_date_end" height=20 width=20>
					
					<script type="text/javascript" id='massedit_calendar_date_end'>
						Calendar.setup ({
						inputField : "jscal_field_date_end", ifFormat : "<?php echo $this->_tpl_vars['JS_DATEFORMAT']; ?>
", showsTime : false, button : "jscal_trigger_date_end", singleClick : true, step : 1
						});
					</script>
			 	</td>

		  
				
	            <input type="hidden" name="searchtype" value="BasicSearch">
	            <input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
	            <input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
">
				<input type="hidden" name="action" value="index">
	            <input type="hidden" name="query" value="false">
	            <input type="hidden" name="filter" value="block">
	            
				
					<td class="small" nowrap  colspan = 1 align = center>
						  <input name="submit" type="submit" class="crmbutton small create" onClick="callFilter();" value=" <?php echo $this->_tpl_vars['APP']['LBL_FILTER']; ?>
 ">&nbsp;
					</td>
				</tr>

			</table>
	</form>

</div>

<!-- END FILTRE -->






 <table align="center" border=0 cellspacing=0 cellpadding=0 width=98%>

	<tr>
		<td width="100%" valign="top" style="padding: 10px;" class="showPanelBg">

	 		<table align="center" border="0" cellpadding="5" cellspacing="1" width="100%" valign="top">
			
				<tr>
						  <?php if ($this->_tpl_vars['SHOW_CAMPAGNE_T'] != 'ko'): ?>
							   <td align="center">
									<img src='/gidPCCI/Graphics/Diagramme_C_1.php' width="800" height="400"/>
						       </td>
					       <?php else: ?>
						       <td align="center" valign="middle" height="100px" >
							       <img src="<?php echo vtiger_imageurl('empty.jpg', $this->_tpl_vars['THEME']); ?>
" height="60" width="61">
							       <?php echo $this->_tpl_vars['MOD']['GRAPH_INDISPONIBLE']; ?>

						       </td>
					       <?php endif; ?>
			   </tr>
			   <tr>
					      <?php if ($this->_tpl_vars['SHOW_CAMPAGNE_S'] != 'ko'): ?>
							   <td align="center">
									<img src='/gidPCCI/Graphics/Diagramme_C_2.php' width="800" height="400"/>
						       </td>
					       <?php else: ?>
						       <td align="center" valign="middle" height="100px" >
							       <img src="<?php echo vtiger_imageurl('empty.jpg', $this->_tpl_vars['THEME']); ?>
" height="60" width="61">
							       <?php echo $this->_tpl_vars['MOD']['GRAPH_INDISPONIBLE']; ?>

						       </td>
					       <?php endif; ?>
				</tr>
				<tr>
						  <?php if ($this->_tpl_vars['SHOW_TYPE_T'] != 'ko'): ?>
							   <td align="center">
									<img src='/gidPCCI/Graphics/Diagramme_T_1.php' width="800" height="400"/>
						       </td>
					       <?php else: ?>
						       <td align="center" valign="middle" height="100px" >
							       <img src="<?php echo vtiger_imageurl('empty.jpg', $this->_tpl_vars['THEME']); ?>
" height="60" width="61">
							       <?php echo $this->_tpl_vars['MOD']['GRAPH_INDISPONIBLE']; ?>

						       </td>
					       <?php endif; ?>
			   </tr>
			   <tr>
					      
					       <?php if ($this->_tpl_vars['SHOW_TYPE_S'] != 'ko'): ?>
							   <td align="center">
									<img src='/gidPCCI/Graphics/Diagramme_T_2.php' width="800" height="400"/>
						       </td>
					       <?php else: ?>
						       <td align="center" valign="middle" height="100px" >
							       <img src="<?php echo vtiger_imageurl('empty.jpg', $this->_tpl_vars['THEME']); ?>
" height="60" width="61">
							       <?php echo $this->_tpl_vars['MOD']['GRAPH_INDISPONIBLE']; ?>

						       </td>
					       <?php endif; ?>
				</tr>
				
			</table>
		
		</td>	
		
	</tr>
</table>
</div>









