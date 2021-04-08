<?php /* Smarty version 2.6.18, created on 2016-01-25 17:00:13
         compiled from ListViewReportingConventions.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'ListViewReportingConventions.tpl', 410, false),array('modifier', 'date_format', 'ListViewReportingConventions.tpl', 548, false),array('function', 'html_options', 'ListViewReportingConventions.tpl', 446, false),)), $this); ?>

<script language="JavaScript" type="text/javascript" src="include/js/ListView.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/search.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/Merge.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/dtlviewajax.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script language="JavaScript" type="text/javascript" src="jscalendar/calendar.js"></script>
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
	/*if(document.basicFilter.entity_module_field != undefined) 
	{
		var filter_entity_module_field_val = $('filter_entity_module_field').options[$('filter_entity_module_field').selectedIndex].value;
		urlstring += 'entity_module_field='+filter_entity_module_field_val+'&';
	}*/
	
	if(document.basicFilter.filter_agence_field != undefined) 
	{
		var filter_agence_field_val = $('filter_agence_field').options[$('filter_agence_field').selectedIndex].value;
		urlstring += 'filter_agence_field='+filter_agence_field_val+'&';
	}
	
	if(document.basicFilter.filter_domaine_field != undefined) 
	{
		var filter_domaine_field_val = $('filter_domaine_field').options[$('filter_domaine_field').selectedIndex].value;
		urlstring += 'filter_domaine_field='+filter_domaine_field_val+'&';
	}

	
	if(document.basicFilter.filter_organe_field != undefined) 
	{
		var filter_organe_field_val = $('filter_organe_field').options[$('filter_organe_field').selectedIndex].value;
		urlstring += 'filter_organe_field='+filter_organe_field_val+'&';
	}

	if(document.basicFilter.filter_localite_field != undefined) 
	{
		var filter_localite_field_val = $('filter_localite_field').options[$('filter_localite_field').selectedIndex].value;
		urlstring += 'filter_localite_field='+filter_localite_field_val+'&';
	}
	
	if(document.basicFilter.filter_programme_field != undefined) 
	{
		var filter_programme_field_val = $('filter_programme_field').options[$('filter_programme_field').selectedIndex].value;
		urlstring += 'filter_programme_field='+filter_programme_field_val+'&';
	}
	
	if(document.basicFilter.filter_politique_field != undefined) 
	{
		var filter_politique_field_val = $('filter_politique_field').options[$('filter_politique_field').selectedIndex].value;
		urlstring += 'filter_politique_field='+filter_politique_field_val+'&';
	}
	
	var date_start_val = encodeURIComponent(document.basicFilter.jscal_field_date_start.value);
	var date_end_val = encodeURIComponent(document.basicFilter.jscal_field_date_end.value);
	

	urlstring += 'date_start='+date_start_val+'&';
	urlstring += 'date_end='+date_end_val+'&';



	$("status").style.display="inline";
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody:urlstring +'filter=true&file=index&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['MODULE']; ?>
Ajax&ajax=true&search=true&login=<?php echo $this->_tpl_vars['LOGIN']; ?>
',
			onComplete: function(response) {
								$("status").style.display="none";
                                result = response.responseText.split('&#&#&#');
								//alert(response.responseText);
                                $("ListViewContents").innerHTML= result[2];
                                if(result[1] != '')
									alert(result[1]);
			}
	       }
        );
		
	return false
}

/*	
function ExportExcell()
{
	document.location.href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=CreateXL&parenttab=JokCallStats";
}
*/

function ExportExcell()
{
//	document.location.href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=CreateXL&parenttab=JokCallStats";

	var urlstring = '';
	if ("<?php echo $this->_tpl_vars['CATEGORY']; ?>
" == 'Reporting')
	{
		if(document.basicFilter.tranche_field != undefined) 
		{
			var i=0;
			var taille = document.basicFilter.tranche_field.length;
			
			while (i<taille && document.basicFilter.tranche_field[i].checked != true) 
			{
				i++;
			}
			
			if (i<taille) 
			{
				filter_tranche_field_val = document.basicFilter.tranche_field[i].value
			    urlstring += '&tranche_field='+filter_tranche_field_val;
			}
		}

		if(document.basicFilter.position_field != undefined) 
		{
			var i2=0;
			var taille2 = document.basicFilter.position_field.length;
			
			while (i2<taille2 && document.basicFilter.position_field[i2].checked != true) 
			{
				i2++;
			}
			
			if (i2<taille2) 
			{
				filter_position_field_val = document.basicFilter.position_field[i2].value
			    urlstring += '&position_field='+filter_position_field_val;
			}
		}


	}
	
	document.location.href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=CreateXL&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"+urlstring;
}

function ModifierSeuil()
{
	document.getElementById('buttonSeuil').style.display='none';
	document.getElementById('formSeuil').style.display='block';
}

function cancelModifierSeuil()
{
	document.getElementById('buttonSeuil').style.display='block';
	document.getElementById('formSeuil').style.display='none';
}

function SaveModifierSeuil()
{
	var seuiltalkval = document.getElementById('seuiltalk').value;
	var seuilacwval = document.getElementById('seuilacw').value
	
	
	   if (confirm("Confirmer les nouvelles valeurs des seuils : Seuil Talk = "+seuiltalkval+"% - Seuil ACW ="+seuilacwval+"% ?")) 
	   { 
  
			new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
					method: 'post',
					postBody: 'module=Talk&action=TalkAjax&mode=ajax&file=SaveSeuilProductivite&seuiltalk='+seuiltalkval+'&seuilacw='+seuilacwval,
					onComplete: function(response) 
					{
						if(response.responseText == '')
							{
								//successfully called
							}
						else
							{
								alert(response.responseText);
							}
					}
			}
	);
          return false;
       }
	
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
<table width="80%" cellpadding="5" cellspacing="0"  class="searchUIBasic " align="center" border=0>
	<tr>
		<td class="searchUIName " nowrap align="left">
		<!-- <span class="moduleName"><?php echo $this->_tpl_vars['APP']['LBL_SEARCH']; ?>
</span><br><span ><a href="#" onClick="fnhide('searchAcc');show('advSearch');updatefOptions(document.getElementById('Fields0'), 'Condition0');document.basicSearch.searchtype.value='advance';"><?php echo $this->_tpl_vars['APP']['LBL_GO_TO']; ?>
 <?php echo $this->_tpl_vars['APP']['LNK_ADVANCED_SEARCH']; ?>
</a></span> -->
		<span class="moduleName"><?php echo $this->_tpl_vars['APP']['LBL_SEARCH']; ?>
</span><br>
		<!-- <img src="themes/images/basicSearchLens.gif" align="absmiddle" alt="<?php echo $this->_tpl_vars['APP']['LNK_BASIC_SEARCH']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LNK_BASIC_SEARCH']; ?>
" border=0>&nbsp;&nbsp;-->
		</td>
		<td  nowrap align=right><!--<b><?php echo $this->_tpl_vars['APP']['LBL_SEARCH_FOR']; ?>
</b>--></td>
		<td ><input type="text"  class="txtBox" style="width:120px" name="search_text"></td>
		<td  nowrap><b><?php echo $this->_tpl_vars['APP']['LBL_IN']; ?>
</b>&nbsp;</td>
		<td  nowrap>
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
		<td  nowrap width=40% >
			  <input name="submit" type="button" class="crmbutton  create" onClick="callSearch('Basic');" value=" <?php echo $this->_tpl_vars['APP']['LBL_SEARCH_NOW_BUTTON']; ?>
 ">&nbsp;
			  
		</td>
		<td  valign="top" onMouseOver="this.style.cursor='pointer';" onclick="moveMe('searchAcc');searchshowhide('searchAcc','advSearch')">[x]</td>
	</tr>
	<tr>
		<td colspan="7" align="center" >
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

<div id="filterAcc" style="z-index:1;display:block;position:relative;">
	<form name="basicFilter" method="post" action="index.php" onSubmit="return callFilter();">
		<table width="95%" cellpadding="5" cellspacing="0"  class="searchUIBasic " align="center" border=0>
			<tr>
				<td class="searchUIName" nowrap align="left" rowspan="6">
				<span class="moduleName2"><?php echo $this->_tpl_vars['APP']['LBL_FILTER']; ?>
</span>
				</td>
				<td class="searchUIName" nowrap align="left" rowspan="6">
				<span class="moduleName2">&nbsp;</span>
				</td>
			
		</tr>
		<?php if ($this->_tpl_vars['MODULE'] == 'ReportingConventions' || $this->_tpl_vars['MODULE'] == 'SBConventions'): ?> 
			<tr>
			
				<td  nowrap align="right"><b><?php echo $this->_tpl_vars['APP']['LBL_AGENCE_EXECUTION']; ?>
</b>&nbsp;&nbsp;&nbsp;
				<td>	<select name="agence_field" id="filter_agence_field" class="txtBox" style="width:200px;">
					 <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['AGENCESEXECUTION']), $this);?>

					</select>
				</td>	
				
				<td  nowrap align="right"><b><?php echo $this->_tpl_vars['APP']['LBL_DOMAINE']; ?>
</b>&nbsp;&nbsp;&nbsp;
				<td>	<select name="domaine_field" id="filter_domaine_field" class="txtBox" style="width:200px;">
					 <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['DOMAINES']), $this);?>

					</select>
				</td>
				
				<td  nowrap align="right"><b><?php echo $this->_tpl_vars['APP']['LBL_LOCALITE']; ?>
</b>&nbsp;&nbsp;&nbsp;
				<td>	<select name="localite_field" id="filter_localite_field" class="txtBox" style="width:200px;">
					 <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['LOCALITESPAYS']), $this);?>

					</select>
				</td>	
		</tr>	
	
		<tr>	
				
				
		
				<td  nowrap align="right"><b><?php echo $this->_tpl_vars['APP']['LBL_ORGANE']; ?>
</b>&nbsp;&nbsp;&nbsp;
				<td><select name="organe_field" id="filter_organe_field" class="txtBox" style="width:200px;">
					 <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['ORGANES']), $this);?>

					</select>
				</td>	
		
				<td  nowrap align="right"><b><?php echo $this->_tpl_vars['APP']['LBL_POLITIQUE']; ?>
</b>&nbsp;&nbsp;&nbsp;
				<td>	<select name="politique_field" id="filter_politique_field" class="txtBox" style="width:200px;">
					 <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['POLITIQUES']), $this);?>

					</select>
				</td>	
		
				<td  nowrap align="right"><b><?php echo $this->_tpl_vars['APP']['LBL_PROGRAMME']; ?>
</b>&nbsp;&nbsp;&nbsp;
				<td>	<select name="programme_field" id="filter_programme_field" class="txtBox" style="width:200px;">
					 <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['PROGRAMMES']), $this);?>

					</select>
				</td>	
		</tr>	
		
		<?php else: ?>
			</tr>
		<?php endif; ?>
		
			<tr>
				<td  nowrap valign="bottom"><b><?php echo $this->_tpl_vars['APP']['LBL_PERIODE']; ?>
</b>&nbsp;</td>
			
				<?php if ($this->_tpl_vars['CURRENT_USER_PROFIL_ID'] != 23): ?> 
					<td  align=left colspan = 3>
				<?php else: ?>
					<td  align=left>
				<?php endif; ?>
				<b> <?php echo $this->_tpl_vars['APP']['LNK_LIST_START']; ?>
 </b>&nbsp;
					<input name="date_start" id="jscal_field_date_start" type="text" style="border:1px solid #bababa;" size="11" maxlength="10" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['DATEDEBUT'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
">&nbsp;
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
					
					<!--select name="heure_debut_field" id="filter_heure_debut_field" class="txtBox">
						 <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['FILTERHEURES']), $this);?>

					</select-->
					
					<?php echo $this->_tpl_vars['APP']['LBL_JOKCALL_H']; ?>
 &nbsp;
					
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $this->_tpl_vars['APP']['LNK_LIST_END']; ?>
</b>&nbsp;&nbsp;&nbsp;
					<input name="date_end" id="jscal_field_date_end" type="text" style="border:1px solid #bababa;" size="11" maxlength="10" value="<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
">&nbsp;
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
						
					<!--select name="heure_fin_field" id="filter_heure_fin_field" class="txtBox">
						 <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['FILTERHEURES'],'selected' => 24), $this);?>

					</select-->
					
					<?php echo $this->_tpl_vars['APP']['LBL_JOKCALL_H']; ?>
 &nbsp;
					
				</td>
				
		
	            <input type="hidden" name="searchtype" value="BasicSearch">
	            <input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
	            <input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
">
				<input type="hidden" name="action" value="index">
	            <input type="hidden" name="query" value="false">
	            <input type="hidden" name="filter" value="true">
	            <input type="hidden" name="login" value="<?php echo $this->_tpl_vars['LOGIN']; ?>
">
	            
			
					<td  nowrap  align = center>
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
</span><br><span ><a href="#" onClick="show('searchAcc');fnhide('advSearch')"><?php echo $this->_tpl_vars['APP']['LBL_GO_TO']; ?>
 <?php echo $this->_tpl_vars['APP']['LNK_BASIC_SEARCH']; ?>
</a></span></td>
					<td nowrap ><b><input name="matchtype" type="radio" value="all">&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_ADV_SEARCH_MSG_ALL']; ?>
</b></td>
					<td nowrap width=60%  ><b><input name="matchtype" type="radio" value="any" checked>&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_ADV_SEARCH_MSG_ANY']; ?>
</b></td>
					<td  valign="top" onMouseOver="this.style.cursor='pointer';" onclick="moveMe('searchAcc');searchshowhide('searchAcc','advSearch')">[x]</td>
			</tr>
		</table>
		<table cellpadding="2" cellspacing="0" width="80%" align="center" class="searchUIAdv2 small" border=0>
			<tr>
				<td align="center"  width=90%>
				<div id="fixed" style="position:relative;width:95%;height:80px;padding:0px; overflow:auto;border:1px solid #CCCCCC;background-color:#ffffff" >
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
			<td align=left ><input type="button" class="crmbutton small create" value=" <?php echo $this->_tpl_vars['APP']['LBL_SEARCH_NOW_BUTTON']; ?>
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
<br>
	   <!-- PUBLIC CONTENTS STARTS-->
	   		<div id="ListViewContents"  style="float:left; width: 1250px; overflow-x:auto;overflow-y:auto; height: 500px; ">
	
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "ListViewEntriesReportingConventions.tpl", 'smarty_include_vars' => array()));
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

