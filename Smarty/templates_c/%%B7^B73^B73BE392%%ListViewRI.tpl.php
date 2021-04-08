<?php /* Smarty version 2.6.18, created on 2011-02-23 11:48:03
         compiled from ListViewRI.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'ListViewRI.tpl', 282, false),array('function', 'html_options', 'ListViewRI.tpl', 317, false),)), $this); ?>

<script language="JavaScript" type="text/javascript" src="include/js/ListView.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/search.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/Merge.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/dtlviewajax.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
<script language="JavaScript" type="text/javascript" src="jscalendar/calendar-setup.js"></script>

<script language="javascript" type="text/javascript">
var typeofdata = new Array();
typeofdata['E'] = ['is','isn','bwt','ewt','cts','dcts'];
typeofdata['V'] = ['is','isn','bwt','ewt','cts','dcts'];
typeofdata['N'] = ['is','isn','lst','grt','lsteq','grteq'];
typeofdata['NN'] = ['is','isn','lst','grt','lsteq','grteq'];
typeofdata['T'] = ['is','isn','lst','grt','lsteq','grteq'];
typeofdata['I'] = ['is','isn','lst','grt','lsteq','grteq'];
typeofdata['C'] = ['is','isn'];
typeofdata['DT'] = ['is','isn','lst','grt','lsteq','grteq'];
typeofdata['D'] = ['is','isn','lst','grt','lsteq','grteq'];
var fLabels = new Array();
fLabels['is'] = "<?php echo $this->_tpl_vars['APP']['is']; ?>
";
fLabels['isn'] = "<?php echo $this->_tpl_vars['APP']['is_not']; ?>
";
fLabels['bwt'] = "<?php echo $this->_tpl_vars['APP']['begins_with']; ?>
";
fLabels['ewt'] = "<?php echo $this->_tpl_vars['APP']['ends_with']; ?>
";
fLabels['cts'] = "<?php echo $this->_tpl_vars['APP']['contains']; ?>
";
fLabels['dcts'] = "<?php echo $this->_tpl_vars['APP']['does_not_contains']; ?>
";
fLabels['lst'] = "<?php echo $this->_tpl_vars['APP']['less_than']; ?>
";
fLabels['grt'] = "<?php echo $this->_tpl_vars['APP']['greater_than']; ?>
";
fLabels['lsteq'] = "<?php echo $this->_tpl_vars['APP']['less_or_equal']; ?>
";
fLabels['grteq'] = "<?php echo $this->_tpl_vars['APP']['greater_or_equal']; ?>
";
var noneLabel;
<?php echo '
function trimfValues(value)
{
    var string_array;
    string_array = value.split(":");
    return string_array[4];
}

function updatefOptions(sel, opSelName) {
    var selObj = document.getElementById(opSelName);
    var fieldtype = null ;

    var currOption = selObj.options[selObj.selectedIndex];
    var currField = sel.options[sel.selectedIndex];
    
    var fld = currField.value.split(":");
    var tod = fld[4];
  /*  if(fld[4] == \'D\' || (fld[4] == \'T\' && fld[1] != \'time_start\' && fld[1] != \'time_end\') || fld[4] == \'DT\')
    {
	$("and"+sel.id).innerHTML =  "";
	if(sel.id != "fcol5")
		$("and"+sel.id).innerHTML =  "<em old=\'(yyyy-mm-dd)\'>("+$("user_dateformat").value+")</em>&nbsp;"+alert_arr.LBL_AND;
	else
		$("and"+sel.id).innerHTML =  "<em old=\'(yyyy-mm-dd)\'>("+$("user_dateformat").value+")</em>&nbsp;";
    }
    else {
	$("and"+sel.id).innerHTML =  "";
	if(sel.id != "fcol5")
		$("and"+sel.id).innerHTML =  "&nbsp;"+alert_arr.LBL_AND;
	else
		$("and"+sel.id).innerHTML =  "&nbsp;";
    } 	
*/
    if(currField.value != null && currField.value.length != 0)
    {
	fieldtype = trimfValues(currField.value);
	fieldtype = fieldtype.replace(/\\\\\'/g,\'\');
	ops = typeofdata[fieldtype];
	var off = 0;
	if(ops != null)
	{

		var nMaxVal = selObj.length;
		for(nLoop = 0; nLoop < nMaxVal; nLoop++)
		{
			selObj.remove(0);
		}
	/*	selObj.options[0] = new Option (\'None\', \'\');
		if (currField.value == \'\') {
			selObj.options[0].selected = true;
		}*/
		for (var i = 0; i < ops.length; i++)
		{
			var label = fLabels[ops[i]];
			if (label == null) continue;
			var option = new Option (fLabels[ops[i]], ops[i]);
			selObj.options[i] = option;
			if (currOption != null && currOption.value == option.value)
			{
				option.selected = true;
			}
		}
	}
    }else
    {
	var nMaxVal = selObj.length;
	for(nLoop = 0; nLoop < nMaxVal; nLoop++)
	{
		selObj.remove(0);
	}
	selObj.options[0] = new Option (\'None\', \'\');
	if (currField.value == \'\') {
		selObj.options[0].selected = true;
	}
    }

}
'; ?>

</script>
<script language="JavaScript" type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['MODULE']; ?>
.js"></script>
<script language="javascript">
function checkgroup()
{
  if($("group_checkbox").checked)
  {
  document.change_ownerform_name.lead_group_owner.style.display = "block";
  document.change_ownerform_name.lead_owner.style.display = "none";
  }
  else
  {
  document.change_ownerform_name.lead_owner.style.display = "block";
  document.change_ownerform_name.lead_group_owner.style.display = "none";
  }    
  
}
function callSearch(searchtype)
{
/*
	for(i=1;i<=26;i++)
    	{
        	var data_td_id = 'alpha_'+ eval(i);
        	getObj(data_td_id).className = 'searchAlph';
    	}
    	gPopupAlphaSearchUrl = '';
*/
	search_fld_val= $('bas_searchfield').options[$('bas_searchfield').selectedIndex].value;
	search_txt_val= encodeURIComponent(document.basicSearch.search_text.value);
        var urlstring = '';
        if(searchtype == 'Basic')
        {
        		var p_tab = document.getElementsByName("parenttab");
                urlstring = 'search_field='+search_fld_val+'&searchtype=BasicSearch&search_text='+search_txt_val+'&';
                urlstring = urlstring + 'parenttab='+p_tab[0].value+ '&';
        }
        else if(searchtype == 'Advanced')
        {
                var no_rows = document.basicSearch.search_cnt.value;
                for(jj = 0 ; jj < no_rows; jj++)
                {
                        var sfld_name = getObj("Fields"+jj);
                        var scndn_name= getObj("Condition"+jj);
                        var srchvalue_name = getObj("Srch_value"+jj);
                        var p_tab = document.getElementsByName("parenttab");
                        urlstring = urlstring+'Fields'+jj+'='+sfld_name[sfld_name.selectedIndex].value+'&';
                        urlstring = urlstring+'Condition'+jj+'='+scndn_name[scndn_name.selectedIndex].value+'&';
						urlstring = urlstring+'Srch_value'+jj+'='+encodeURIComponent(srchvalue_name.value)+'&';
                        urlstring = urlstring + 'parenttab='+p_tab[0].value+ '&';
                }
                for (i=0;i<getObj("matchtype").length;i++){
                        if (getObj("matchtype")[i].checked==true)
                                urlstring += 'matchtype='+getObj("matchtype")[i].value+'&';
                }
                urlstring += 'search_cnt='+no_rows+'&';
                urlstring += 'searchtype=advance&'
        }
	$("status").style.display="inline";
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody:urlstring +'query=true&file=index&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['MODULE']; ?>
Ajax&ajax=true&search=true',
			onComplete: function(response) {
								$("status").style.display="none";
                                result = response.responseText.split('&#&#&#');
                                $("ListViewContents").innerHTML= result[2];
                                if(result[1] != '')
									alert(result[1]);
								$('basicsearchcolumns').innerHTML = '';
			}
	       }
        );
	return false
}
function alphabetic(module,url,dataid)
{
        for(i=1;i<=26;i++)
        {
                var data_td_id = 'alpha_'+ eval(i);
                getObj(data_td_id).className = 'searchAlph';

        }
        getObj(dataid).className = 'searchAlphselected';
	$("status").style.display="inline";
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module='+module+'&action='+module+'Ajax&file=index&ajax=true&search=true&'+url,
			onComplete: function(response) {
				$("status").style.display="none";
				result = response.responseText.split('&#&#&#');
				$("ListViewContents").innerHTML= result[2];
				if(result[1] != '')
			                alert(result[1]);
				$('basicsearchcolumns').innerHTML = '';
			}
		}
	);
}


function callFilter()
{
			
	var urlstring = '';
/*	
	var groupname_val = $('filter_groupname_field').options[$('filter_groupname_field').selectedIndex].value;
	var typologie_val = $('filter_typologie_field').options[$('filter_typologie_field').selectedIndex].value;
	var statut_val = $('filter_statut_field').options[$('filter_statut_field').selectedIndex].value;
	var campagne_val = $('filter_campagne_field').options[$('filter_campagne_field').selectedIndex].value;
*/	
	var date_start_val = encodeURIComponent(document.basicFilter.jscal_field_date_start.value);
	var date_end_val = encodeURIComponent(document.basicFilter.jscal_field_date_end.value);

/*	
	urlstring += 'groupname_field='+groupname_val+'&';
	urlstring += 'typologie_field='+typologie_val+'&';
	urlstring += 'statut_field='+statut_val+'&';
	urlstring += 'campagne_field='+campagne_val+'&';
*/
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
	
function ExportExcell()
{
	document.location.href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=CreateXL&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
";
}

</script>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Buttons_List1.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                <div id="searchingUI" style="display:none;">
                                        <table border=0 cellspacing=0 cellpadding=0 width=100%>
                                        <tr>
                                                <td align=center>
                                                <img src="<?php echo vtiger_imageurl('searching.gif', $this->_tpl_vars['THEME']); ?>
" alt="<?php echo $this->_tpl_vars['APP']['LBL_SEARCHING']; ?>
"  title="<?php echo $this->_tpl_vars['APP']['LBL_SEARCHING']; ?>
">
                                                </td>
                                        </tr>
                                        </table>

                                </div>
                        </td>
                </tr>
                </table>
        </td>
</tr>
</table>

<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
     <tr>
        <td valign=top><img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
"></td>

	<td class="showPanelBg" valign="top" width=100% style="padding:10px;">
	 <!-- SIMPLE SEARCH -->
<div id="searchAcc" style="z-index:1;display:none;position:relative;">
<form name="basicSearch" method="post" action="index.php" onSubmit="return callSearch('Basic');">
<table width="80%" cellpadding="5" cellspacing="0"  class="searchUIBasic small" align="center" border=0>
	<tr>
		<td class="searchUIName small" nowrap align="left">
		<!-- <span class="moduleName"><?php echo $this->_tpl_vars['APP']['LBL_SEARCH']; ?>
</span><br><span class="small"><a href="#" onClick="fnhide('searchAcc');show('advSearch');updatefOptions(document.getElementById('Fields0'), 'Condition0');document.basicSearch.searchtype.value='advance';"><?php echo $this->_tpl_vars['APP']['LBL_GO_TO']; ?>
 <?php echo $this->_tpl_vars['APP']['LNK_ADVANCED_SEARCH']; ?>
</a></span> -->
		<span class="moduleName"><?php echo $this->_tpl_vars['APP']['LBL_SEARCH']; ?>
</span><br>
		<!-- <img src="themes/images/basicSearchLens.gif" align="absmiddle" alt="<?php echo $this->_tpl_vars['APP']['LNK_BASIC_SEARCH']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LNK_BASIC_SEARCH']; ?>
" border=0>&nbsp;&nbsp;-->
		</td>
		<td class="small" nowrap align=right><!--<b><?php echo $this->_tpl_vars['APP']['LBL_SEARCH_FOR']; ?>
</b>--></td>
		<td class="small"><input type="text"  class="txtBox" style="width:120px" name="search_text"></td>
		<td class="small" nowrap><b><?php echo $this->_tpl_vars['APP']['LBL_IN']; ?>
</b>&nbsp;</td>
		<td class="small" nowrap>
			<div id="basicsearchcolumns_real">
			<select name="search_field" id="bas_searchfield" class="txtBox" style="width:150px">
			 <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['SEARCHLISTHEADER']), $this);?>

			</select>
			</div>
                <input type="hidden" name="searchtype" value="BasicSearch">
                <input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
                <input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
">
				<input type="hidden" name="action" value="index">
                <input type="hidden" name="query" value="true">
				<input type="hidden" name="search_cnt">
		</td>
		<td class="small" nowrap width=40% >
			  <input name="submit" type="button" class="crmbutton small create" onClick="callSearch('Basic');" value=" <?php echo $this->_tpl_vars['APP']['LBL_SEARCH_NOW_BUTTON']; ?>
 ">&nbsp;
			  
		</td>
		<td class="small" valign="top" onMouseOver="this.style.cursor='pointer';" onclick="moveMe('searchAcc');searchshowhide('searchAcc','advSearch')">[x]</td>
	</tr>
	<tr>
		<td colspan="7" align="center" class="small">
			<table border=0 cellspacing=0 cellpadding=0 width=100%>
				<tr>
                                                <!--   <?php echo $this->_tpl_vars['ALPHABETICAL']; ?>
 -->
                                </tr>
                        </table>
		</td>
	</tr>
</table>
</form>
</div>

<!-- FILTRE -->

<div id="filterAcc" style="z-index:1;display:none;position:relative;">
	<form name="basicFilter" method="post" action="index.php" onSubmit="return callFilter();">
		<table width="80%" cellpadding="5" cellspacing="0"  class="searchUIBasic small" align="center" border=0>
						
			<tr>
				<td colspan = 4  class="small" nowrap><b><?php echo $this->_tpl_vars['MOD']['LBL_PERIODE']; ?>
</b>&nbsp;</td>
			</tr>
			<tr>
				<td width=80% align=center class=small colspan = 3><b> <?php echo $this->_tpl_vars['MOD']['LNK_LIST_START']; ?>
 </b>&nbsp;
					<input name="date_start" id="jscal_field_date_start" type="text" style="border:1px solid #bababa;" size="11" maxlength="10">&nbsp;
					<img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
btnL3Calendar.gif" id="jscal_trigger_date_start">
					<font size="1"><em old="(yyyy-mm-dd)">(<?php echo $this->_tpl_vars['DATEFORMAT']; ?>
)</em></font>
						<script type="text/javascript" id='massedit_calendar_date_start'>
							Calendar.setup ({
							inputField : "jscal_field_date_start", ifFormat : "<?php echo $this->_tpl_vars['JS_DATEFORMAT']; ?>
", showsTime : false, button : "jscal_trigger_date_start", singleClick : true, step : 1
							});
						</script>
					
					&nbsp;&nbsp;&nbsp;<b><?php echo $this->_tpl_vars['MOD']['LNK_LIST_END']; ?>
</b>&nbsp;
					<input name="date_end" id="jscal_field_date_end" type="text" style="border:1px solid #bababa;" size="11" maxlength="10">&nbsp;
					<img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
btnL3Calendar.gif" id="jscal_trigger_date_end">
					<font size="1"><em old="(yyyy-mm-dd)">(<?php echo $this->_tpl_vars['DATEFORMAT']; ?>
)</em></font>
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
	            <input type="hidden" name="filter" value="true">
	            
				
					<td class="small" nowrap width=10% colspan = 1 align = center>
						  <input name="submit" type="button" class="crmbutton small create" onClick="callFilter();" value=" <?php echo $this->_tpl_vars['APP']['LBL_FILTER']; ?>
 ">&nbsp;
					</td>
				</tr>

			</table>
	</form>

</div>


<!-- END FILTRE -->
<!-- ADVANCED SEARCH -->
<div id="advSearch" style="display:none;">
<form name="advSearch" method="post" action="index.php" onSubmit="totalnoofrows();return callSearch('Advanced');">
		<table  cellspacing=0 cellpadding=5 width=80% class="searchUIAdv1 small" align="center" border=0>
			<tr>
					<td class="searchUIName small" nowrap align="left"><span class="moduleName"><?php echo $this->_tpl_vars['APP']['LBL_SEARCH']; ?>
</span><br><span class="small"><a href="#" onClick="show('searchAcc');fnhide('advSearch')"><?php echo $this->_tpl_vars['APP']['LBL_GO_TO']; ?>
 <?php echo $this->_tpl_vars['APP']['LNK_BASIC_SEARCH']; ?>
</a></span></td>
					<td nowrap class="small"><b><input name="matchtype" type="radio" value="all">&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_ADV_SEARCH_MSG_ALL']; ?>
</b></td>
					<td nowrap width=60% class="small" ><b><input name="matchtype" type="radio" value="any" checked>&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_ADV_SEARCH_MSG_ANY']; ?>
</b></td>
					<td class="small" valign="top" onMouseOver="this.style.cursor='pointer';" onclick="moveMe('searchAcc');searchshowhide('searchAcc','advSearch')">[x]</td>
			</tr>
		</table>
		<table cellpadding="2" cellspacing="0" width="80%" align="center" class="searchUIAdv2 small" border=0>
			<tr>
				<td align="center" class="small" width=90%>
				<div id="fixed" style="position:relative;width:95%;height:80px;padding:0px; overflow:auto;border:1px solid #CCCCCC;background-color:#ffffff" class="small">
					<table border=0 width=95%>
					<tr>
					<td align=left>
						<table width="100%"  border="0" cellpadding="2" cellspacing="0" id="adSrc" align="left">
						<tr  >
							<td width="31%"><select name="Fields0" id="Fields0" class="detailedViewTextBox" onchange="updatefOptions(this, 'Condition0')"><?php echo $this->_tpl_vars['FIELDNAMES']; ?>
</select>
							</td>
							<td width="32%"><select name="Condition0" id="Condition0" class="detailedViewTextBox"><?php echo $this->_tpl_vars['CRITERIA']; ?>
</select>
							</td>
							<td width="32%"><input type="text" name="Srch_value0" class="detailedViewTextBox"></td>
						</tr>
						</table>
					</td>
					</tr>
				</table>
				</div>	
				</td>
			</tr>
		</table>
			
		<table border=0 cellspacing=0 cellpadding=5 width=80% class="searchUIAdv3 small" align="center">
		<tr>
		    <td align=left width=40%>
						<input type="button" name="more" value=" <?php echo $this->_tpl_vars['APP']['LBL_MORE']; ?>
 " onClick="fnAddSrch('<?php echo $this->_tpl_vars['FIELDNAMES']; ?>
','<?php echo $this->_tpl_vars['CRITERIA']; ?>
')" class="crmbuttom small edit" >
						<input name="button" type="button" value=" <?php echo $this->_tpl_vars['APP']['LBL_FEWER_BUTTON']; ?>
 " onclick="delRow()" class="crmbuttom small edit" >
			</td>			
			<td align=left class="small"><input type="button" class="crmbutton small create" value=" <?php echo $this->_tpl_vars['APP']['LBL_SEARCH_NOW_BUTTON']; ?>
 " onClick="totalnoofrows();callSearch('Advanced');">
			</td>
		</tr>
	</table>
</form>
</div>		

<div id="mergeDup" style="z-index:1;display:none;position:relative;">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "MergeColumns.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>	 
	   <!-- PUBLIC CONTENTS STARTS-->
	  <div id="ListViewContents" class="small" style="width:100%;">

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "ListViewEntries.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	</div>

     </td>
        <td valign=top><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
   </tr>
</table>

<!-- MassEdit Feature -->
<div id="massedit" class="layerPopup" style="display:none;width:80%;">
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="layerHeadingULine">
<tr>
	<td class="layerPopupHeading" align="left" width="60%"><?php echo $this->_tpl_vars['APP']['LBL_MASSEDIT_FORM_HEADER']; ?>
</td>
	<td>&nbsp;</td>
	<td align="right" width="40%"><img onClick="fninvsh('massedit');" title="<?php echo $this->_tpl_vars['APP']['LBL_CLOSE']; ?>
" alt="<?php echo $this->_tpl_vars['APP']['LBL_CLOSE']; ?>
" style="cursor:pointer;" src="<?php echo vtiger_imageurl('close.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" border="0"></td>
</tr>
</table>
<div id="massedit_form_div"></div>

</div>
<!-- END -->
<?php if ($this->_tpl_vars['MODULE'] == 'Leads' || $this->_tpl_vars['MODULE'] == 'Contacts' || $this->_tpl_vars['MODULE'] == 'Accounts' || $this->_tpl_vars['MODULE'] == 'Vendors'): ?>
<form name="SendMail"><div id="sendmail_cont" style="z-index:100001;position:absolute;"></div></form>
<?php endif; ?>

<!-- Add new Folder UI for Documents module starts -->
<script language="JavaScript" type="text/javascript" src="modules/Documents/Documents.js"></script>
<div id="orgLay" style="display:none;width:350px;" class="layerPopup">
        <table border=0 cellspacing=0 cellpadding=5 width=100% class=layerHeadingULine>
        <tr>
                <td class="genHeaderSmall" nowrap align="left" width="30%" id="editfolder_info"><?php echo $this->_tpl_vars['MOD']['LBL_ADD_NEW_FOLDER']; ?>
</td>
                <td align="right"><a href="javascript:;" onClick="closeFolderCreate();"><img src="<?php echo vtiger_imageurl('close
.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" border="0"></a></td>
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

</b></td>
                                <td class="cellText small" align="left"><input id="folder_desc" name="folderDes
c" class="txtBox" type="text"> &nbsp;&nbsp;Maximum 50</td>
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
<?php if ($this->_tpl_vars['MODULE'] == 'Documents'): ?>
<!-- Add new folder UI for Documents module ends -->
<!-- Move documents UI for Documents module starts -->
<div style="display: none;left:193px;top:106px;width:155px;" id="folderLay" onmouseout="fninvsh('folderLay')" onmouseover="fnvshNrm('folderLay')">
<table bgcolor="#ffffff" border="1" cellpadding="0" cellspacing="0" width="100%">
	<tr><td align="left"><b><?php echo $this->_tpl_vars['MOD']['LBL_MOVE_TO']; ?>
 :</b></td></tr>
	<tr>
	<td align="left">
	<?php $_from = $this->_tpl_vars['ALL_FOLDERS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['folder']):
?>
		<a href="javascript:;" onClick="MoveFile('<?php echo $this->_tpl_vars['folder']['folderid']; ?>
','<?php echo $this->_tpl_vars['folder']['foldername']; ?>
');" class="drop_down">- <?php echo $this->_tpl_vars['folder']['foldername']; ?>
</a>
	<?php endforeach; endif; unset($_from); ?>
	</td>
	</tr>
</table>
</div>
<!-- Move documents UI for Documents module ends -->
<?php endif; ?>
<script>
<?php echo '

function ajaxChangeStatus(statusname)
{
	$("status").style.display="inline";
	var viewid = document.getElementById(\'viewname\').options[document.getElementById(\'viewname\').options.selectedIndex].value;
	var idstring = document.getElementById(\'idlist\').value;
	var searchurl= document.getElementById(\'search_url\').value;
	var tplstart=\'&\';
	if(gstart!=\'\')
	{
		tplstart=tplstart+gstart;
	}
	if(statusname == \'status\')
	{
		fninvsh(\'changestatus\');
		var url=\'&leadval=\'+document.getElementById(\'lead_status\').options[document.getElementById(\'lead_status\').options.selectedIndex].value;
		var urlstring ="module=Users&action=updateLeadDBStatus&return_module=Leads"+tplstart+url+"&viewname="+viewid+"&idlist="+idstring+searchurl;
	}
	else if(statusname == \'owner\')
	{
		if($("user_checkbox").checked)
		{
		    fninvsh(\'changeowner\');
		    var url=\'&owner_id=\'+document.getElementById(\'lead_owner\').options[document.getElementById(\'lead_owner\').options.selectedIndex].value;
		    '; ?>

		        var urlstring ="module=Users&action=updateLeadDBStatus&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
"+tplstart+url+"&viewname="+viewid+"&idlist="+idstring+searchurl;
		    <?php echo '
		} else {
			fninvsh(\'changeowner\');
			var url=\'&owner_id=\'+document.getElementById(\'lead_group_owner\').options[document.getElementById(\'lead_group_owner\').options.selectedIndex].value;
	      	'; ?>

		        var urlstring ="module=Users&action=updateLeadDBStatus&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
"+tplstart+url+"&viewname="+viewid+"&idlist="+idstring+searchurl;
        	<?php echo '
    	}
	}
	new Ajax.Request(
                \'index.php\',
                {queue: {position: \'end\', scope: \'command\'},
                        method: \'post\',
                        postBody: urlstring,
                        onComplete: function(response) {
                                $("status").style.display="none";
                                result = response.responseText.split(\'&#&#&#\');
                                $("ListViewContents").innerHTML= result[2];
                                if(result[1] != \'\')
                                        alert(result[1]);
				$(\'basicsearchcolumns\').innerHTML = \'\';
                        }
                }
        );
	
}
</script>
'; ?>


<?php if ($this->_tpl_vars['MODULE'] == 'Contacts'): ?>
<?php echo '
<script>
function modifyimage(imagename)
{
	imgArea = getObj(\'dynloadarea\');
        if(!imgArea)
        {
                imgArea = document.createElement("div");
                imgArea.id = \'dynloadarea\';
                imgArea.setAttribute("style","z-index:100000001;");
                imgArea.style.position = \'absolute\';
                imgArea.innerHTML = \'<img width="260" height="200" src="\'+imagename+\'" class="thumbnail">\';
		document.body.appendChild(imgArea);
        }
	PositionDialogToCenter(imgArea.id);
}

function PositionDialogToCenter(ID)
{
       var vpx,vpy;
       if (self.innerHeight) // Mozilla, FF, Safari and Opera
       {
               vpx = self.innerWidth;
               vpy = self.innerHeight;
       }
       else if (document.documentElement && document.documentElement.clientHeight) //IE

       {
               vpx = document.documentElement.clientWidth;
               vpy = document.documentElement.clientHeight;
       }
       else if (document.body) // IE
       {
               vpx = document.body.clientWidth;
               vpy = document.body.clientHeight;
       }

       //Calculate the length from top, left
       dialogTop = (vpy/2 - 280/2) + document.documentElement.scrollTop;
       dialogLeft = (vpx/2 - 280/2);

       //Position the Dialog to center
       $(ID).style.top = dialogTop+"px";
       $(ID).style.left = dialogLeft+"px";
       $(ID).style.display="block";
}

function removeDiv(ID){
        var node2Rmv = getObj(ID);
        if(node2Rmv){node2Rmv.parentNode.removeChild(node2Rmv);}
}

</script>
'; ?>

<?php endif; ?>

