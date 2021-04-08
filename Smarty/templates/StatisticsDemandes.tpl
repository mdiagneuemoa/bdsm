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
   <a class="link"  align="right" href="javascript:;">{$APP.LBL_EDIT_BUTTON}</a>
</span>
-->
<div id="convertleaddiv" style="display:block;position:absolute;left:225px;top:150px;"></div>
<script>
{literal}
var gVTModule = '{$smarty.request.module}';
function callConvertLeadDiv(id)
{
        new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: 'module=Leads&action=LeadsAjax&file=ConvertLead&record='+id,
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
	if(oObj.style.display == 'block')
	{
		oObj.style.display = 'none';
		eval(document.getElementById(anchorImgId)).src =  'themes/images/inactivate.gif';
		eval(document.getElementById(anchorImgId)).alt = 'Display';
		eval(document.getElementById(anchorImgId)).title = 'Display';
	}
	else
	{
		oObj.style.display = 'block';
		eval(document.getElementById(anchorImgId)).src = 'themes/images/activate.gif';
		eval(document.getElementById(anchorImgId)).alt = 'Hide';
		eval(document.getElementById(anchorImgId)).title = 'Hide';
	}
}
<!-- End Of Code modified by SAKTI on 10th Apr, 2008 -->

<!-- Start of code added by SAKTI on 16th Jun, 2008 -->
function setCoOrdinate(elemId){
	oBtnObj = document.getElementById(elemId);
	var tagName = document.getElementById('lstRecordLayout');
	leftpos  = 0;
	toppos = 0;
	aTag = oBtnObj;
	do{					  
	  leftpos  += aTag.offsetLeft;
	  toppos += aTag.offsetTop;
	} while(aTag = aTag.offsetParent);
	
	tagName.style.top= toppos + 20 + 'px';
	tagName.style.left= leftpos - 276 + 'px';
}

function getListOfRecords(obj, sModule, iId,sParentTab)
{
		new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Users&action=getListOfRecords&ajax=true&CurModule='+sModule+'&CurRecordId='+iId+'&CurParentTab='+sParentTab,
			onComplete: function(response) {
				sResponse = response.responseText;
				$("lstRecordLayout").innerHTML = sResponse;
				Lay = 'lstRecordLayout';	
				var tagName = document.getElementById(Lay);
				var leftSide = findPosX(obj);
				var topSide = findPosY(obj);
				var maxW = tagName.style.width;
				var widthM = maxW.substring(0,maxW.length-2);
				var getVal = parseInt(leftSide) + parseInt(widthM);
				if(getVal  > document.body.clientWidth ){
					leftSide = parseInt(leftSide) - parseInt(widthM);
					tagName.style.left = leftSide + 230 + 'px';
					tagName.style.top = topSide + 20 + 'px';
				}else{
					tagName.style.left = leftSide + 230 + 'px';
				}
				setCoOrdinate(obj.id);
				
				tagName.style.display = 'block';
				tagName.style.visibility = "visible";
			}
		}
	);
}
<!-- End of code added by SAKTI on 16th Jun, 2008 -->
{/literal}
function BackupDocument(form,id,folderid)
{ldelim}
	if(confirm("{$MOD.LBL_MSG_BACKUP}"))
	{ldelim}
		
		form.return_module.value='Documents'; 
		form.return_action.value='DetailView';
		form.module.value='Documents';
		form.action.value='ListView';
		form.idToBackup.value=id;
		form.folderid.value=folderid;
		form.submit();
		
	{rdelim}
{rdelim}

function BackupRapport(form,id,folderid)
{ldelim}
	if(confirm("Attention!! vous etes sur le point d'archiver ce rapport.\n Une fois fait, il ne sera disponible qu'en consultation."))
	{ldelim}
	
		form.return_module.value='HReports'; 
		form.return_action.value='DetailView';
		form.module.value='HReports';
		form.action.value='ListView';
		form.folderid.value=folderid;
		form.idToBackup.value=id;
		form.submit();
		
	{rdelim}
{rdelim}


function tagvalidate()
{ldelim}
	if(trim(document.getElementById('txtbox_tagfields').value) != '')
		SaveTag('txtbox_tagfields','{$ID}','{$MODULE}');	
	else
	{ldelim}
		alert("{$APP.PLEASE_ENTER_TAG}");
		return false;
	{rdelim}
{rdelim}
function DeleteTag(id,recordid)
{ldelim}
	$("vtbusy_info").style.display="inline";
	Effect.Fade('tag_'+id);
	new Ajax.Request(
		'index.php',
                {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
                        method: 'post',
                        postBody: "file=TagCloud&module={$MODULE}&action={$MODULE}Ajax&ajxaction=DELETETAG&recordid="+recordid+"&tagid=" +id,
                        onComplete: function(response) {ldelim}
						getTagCloud();
						$("vtbusy_info").style.display="none";
                        {rdelim}
                {rdelim}
        );
{rdelim}




//Added to send a file, in Documents module, as an attachment in an email
function sendfile_email()
{ldelim}
	filename = $('dldfilename').value;
	document.DetailView.submit();
	OpenCompose(filename,'Documents');
{rdelim}

</script>

<script language="javascript">
function callFilter()
{ldelim}
			
	var urlstring = '';
	
	var groupname_val = $('filter_groupname_field').options[$('filter_groupname_field').selectedIndex].value;
	var typologie_val = $('filter_typologie_field').options[$('filter_typologie_field').selectedIndex].value;
	var statut_val = $('filter_statut_field').options[$('filter_statut_field').selectedIndex].value;
	var campagne_val = $('filter_campagne_field').options[$('filter_campagne_field').selectedIndex].value;
	
	var date_start_val = encodeURIComponent(document.basicFilter.jscal_field_date_start.value);
	var date_end_val = encodeURIComponent(document.basicFilter.jscal_field_date_end.value);

	
	urlstring += 'groupname_field='+groupname_val+'&';
	urlstring += 'typologie_field='+typologie_val+'&';
	//urlstring += 'statut_field='+statut_val+'&';
	urlstring += 'campagne_field='+campagne_val+'&';
	urlstring += 'date_start='+date_start_val+'&';
	urlstring += 'date_end='+date_end_val+'&';
	
/*	
	$("status").style.display="inline";
	new Ajax.Request(
		'index.php',
		{ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
			method: 'post',
			postBody:urlstring +'filter=true&file=index&module={$MODULE}&action={$MODULE}Ajax&ajax=true&search=true',
	//		postBody:urlstring +'filter=true&file=DetailView&module={$MODULE}&action={$MODULE}Ajax&ajax=true&search=true',
			onComplete: function(response) {ldelim}
								$("status").style.display="none";
                                result = response.responseText.split('&#&#&#');
                                $("ListViewContents").innerHTML= result[2];
                                if(result[1] != '')
									alert(result[1]);
			{rdelim}
	       {rdelim}
        );
		
	return false
*/
{rdelim}

</script>


<div id="lstRecordLayout" class="layerPopup" style="display:none;width:325px;height:300px;"></div>
{include file='Buttons_List1.tpl'}



<!-- FILTRE -->

<div id="filterAcc" style="z-index:1;display:{$FILTER};position:relative;">
<!--	<form name="basicFilter" method="post" action="index.php" onSubmit="return callFilter();">-->
	<form name="basicFilter" method="post" action="index.php" >
		<table width="90%" cellpadding="2" cellspacing="2"  class="searchUIBasic small" align="center" border=0>
			<tr>
				<td class="searchUIName small" nowrap align="left">
				<span class="moduleName">{$APP.LBL_FILTER}</span><br>
				</td>
				<td class="small" valign="top" colspan="3" align="right" onMouseOver="this.style.cursor='pointer';" onclick="moveMe('filterAcc');searchshowhide('filterAcc','advSearch')">[x]</td>
			</tr>
			<tr>
				<td class="small" nowrap><b>{$APP.LBL_GROUP_NAME}</b>&nbsp;</td>
				<td class="small" nowrap>
					<div id="filter_groupname">
						<select name="groupname_field" id="filter_groupname_field" class="txtBox" style="width:150px">
						 {html_options  options=$FILTERGROUPNAME selected=$MYSELECTED_GT}
						</select>
					</div>
				</td>	
				
				<td class="small" nowrap><b>{$APP.LBL_CAMPAIGN_NAME}</b>&nbsp;</td>
				<td class="small" nowrap>
					<div id="filter_campagne">
						<select name="campagne_field" id="filter_campagne_field" class="txtBox">
						 {html_options  options=$FILTERCAMPAGNE   selected=$MYSELECTED_CAMP}
						</select>
					</div>
				</td>
			</tr>
		
			<tr>
				
				<td class="small" nowrap><b>{$APP.LBL_TYPOLOGIE}</b>&nbsp;</td>
				<td class="small" nowrap>
					<div id="filter_typologie">
						<select name="typologie_field" id="filter_typologie_field" class="txtBox">
						 {html_options  options=$FILTERTYPOLOGIE selected=$MYSELECTED_TYPE}
						</select>
					</div>
				</td>	

				<td class="small" nowrap><b>{$APP.LBL_PERIODE}</b>&nbsp;</td>
			
				<td align=left class=small><b> {$APP.LNK_LIST_START} </b>&nbsp;
					<input name="date_start" value="{$MYSELECTED_DS}" id="jscal_field_date_start" type="text" style="border:1px solid #bababa;" size="11" maxlength="10">&nbsp;
					<img src="{$IMAGE_PATH}btnL3Calendar.gif" id="jscal_trigger_date_start" height=20 width=20>
					
						<script type="text/javascript" id='massedit_calendar_date_start'>
							Calendar.setup ({ldelim}
							inputField : "jscal_field_date_start", ifFormat : "{$JS_DATEFORMAT}", showsTime : false, button : "jscal_trigger_date_start", singleClick : true, step : 1
							{rdelim});
						</script>
					
					&nbsp;&nbsp;&nbsp;<b>{$APP.LNK_LIST_END}</b>&nbsp;
					<input name="date_end" value="{$MYSELECTED_DE}" id="jscal_field_date_end" type="text" style="border:1px solid #bababa;" size="11" maxlength="10">&nbsp;
					<img src="{$IMAGE_PATH}btnL3Calendar.gif" id="jscal_trigger_date_end" height=20 width=20>
					
						<script type="text/javascript" id='massedit_calendar_date_end'>
							Calendar.setup ({ldelim}
							inputField : "jscal_field_date_end", ifFormat : "{$JS_DATEFORMAT}", showsTime : false, button : "jscal_trigger_date_end", singleClick : true, step : 1
							{rdelim});
						</script>
					</td>
				</tr>

	            <input type="hidden" name="searchtype" value="BasicSearch">
	            <input type="hidden" name="module" value="{$MODULE}">
	            <input type="hidden" name="parenttab" value="{$CATEGORY}">
				<input type="hidden" name="action" value="index">
	            <input type="hidden" name="query" value="false">
	            <input type="hidden" name="filter" value="block">
	            
				<tr>
					<td class="small" nowrap width=40% colspan = 4 align = center>
						  <!--<input name="submit" type="button" class="crmbutton small create" onClick="callFilter();" value=" {$APP.LBL_FILTER} ">&nbsp;-->
						  <input name="submit" type="submit" class="crmbutton small create" onClick="callFilter();" value=" {$APP.LBL_FILTER} ">&nbsp;
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
			<td>
			{if $DEMANDES_NB_DECLARES neq 0 }
					<table align="center" class="lvt small" border="0" cellpadding="5" cellspacing="1" width="100%">
						
						<tr>
							<td class=lvtCol colspan=6>
								<table width="100%">
									<tr>
										<td align=left>
										 {$MOD.LBL_STAT_DEMANDES} 
										</td>
								 		<td align=right>
								           {$MOD.LBL_TOTAL_DEMANDES} : {$DEMANDES_NB_DECLARES}
							            </td>
							         </tr>
							       </table>
							 </td>
						</tr>
						<tr class=lvtColData>
							<td colspan=2 align="center"><b> {$MOD.LBL_ATRAITER_DEMANDES} </b></td>
							<td colspan=4 align="center">
								<table width="100%">
									<tr>
										<td align=left>
										 <b> {$MOD.LBL_TRAITE_DEMANDES} </b>
										</td>
										{if $TYPOLOGY neq '' }
								 		<td align=right>
								          <b> {$MOD.LBL_DUREE_MOYENNE_DEMANDES} : {$DEMANDES_DUREE_MOYENNE_TRAITEMENT}</b>
							            </td>
							            {/if}
							         </tr>
							       </table>
							</td>
						</tr>
						<tr class=lvtColData>
							<td> {$MOD.LBL_NON_SOUFFRANT_DEMANDES} </td>
							<td> {$MOD.LBL_DEMANDES_NB_EN_SOUFFRANCE} </td>
							<td> {$MOD.LBL_DEMANDES_NB_TRAITES_DANS_DELAIS} </td>
							<td> {$MOD.LBL_DEMANDES_NB_TRAITES_AU_DELA_DELAIS} </td>
							<td> {$MOD.LBL_DEMANDES_NB_ORIGINE_INTERNE} </td>
					        <td> {$MOD.LBL_DEMANDES_NB_ORIGINE_EXTERNE} </td>
						</tr>
						<tr class="lvtColData">
							<td align="center"> {$DEMANDES_NON_TRAITE} </td>
							<td align="center"> {$DEMANDES_NB_EN_SOUFFRANCE} </td>
							<td align="center"> {$DEMANDES_NB_TRAITES_DANS_DELAIS} </td>
							<td align="center"> {$DEMANDES_NB_TRAITES_AU_DELA_DELAIS} </td>
							<td align="center"> {$DEMANDES_NB_ORIGINE_INTERNE} </td>
					        <td align="center"> {$DEMANDES_NB_ORIGINE_EXTERNE} </td>
						</tr>
					
					</table>
		
	    		</td>
	
				<td>
					<table align="center" class="lvt small" border="0" cellpadding="5" cellspacing="1" width="100%">
						<tr>
							<td class=lvtCol colspan=4>
								<table width="100%">
									<tr>
										<td align=left>
										 {$MOD.LBL_DEMANDES_TABLEAU} 
										</td>
								 		<td align=right>
								           {$MOD.LBL_TOTAL_DEMANDES} : {$DEMANDES_NB_DECLARES}
							            </td>
							         </tr>
							       </table>
							 </td>
						</tr>
						<tr class=lvtColData>
							<td colspan=2 align="center"><b> {$MOD.LBL_DEMANDES_NON_TRAITES} </b></td>
							<td colspan=2 align="center">
								<table width="100%">
									<tr>
										<td align=left>
										 <b> {$MOD.LBL_TRAITE_DEMANDES} </b>
										</td>
								 		<td align=right>
								          <b> {$MOD.LBL_TAUX_DEMANDES} : {$DEMANDES_TAUX_TRAITEMENT}</b>
							            </td>
							         </tr>
							      </table>
							</td>
						</tr>
						<tr class="lvtColData">
							<td> {$APP.open} </td>
							<td> {$APP.pending} </td>
					        <td> {$APP.tobeclosed} </td>
					        <td> {$APP.closed} </td>
						</tr>
						<tr class="lvtColData">
							
							{foreach item=data from=$VALUES_STATUS}	
							<td align="center">
									{$data}
								
							</td>
					        {/foreach}
							
						</tr>
					
					</table>
		
	    		</td>
				
			</tr>
			<tr>
					   <td align="center">
							<img src='/gidpcci/modules/StatisticsDemandes/Diagramme.php' width="400" height="215"/>
				       </td>
				       <td align="center">
							<img src='/gidpcci/modules/StatisticsDemandes/Diagramme2.php' width="400" height="215"/>
				      </td>
			</tr>
		</table>
		
		{else}
		<br><br><br><br><br><br>
		<div style="margin: auto; border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 50%; position: relative; z-index: 10000000;">

		<table border="0" cellpadding="5" cellspacing="0" width="98%" align="center">
				<tr>
						<td rowspan="2" width="25%">
							<img src="{'empty.jpg'|@vtiger_imageurl:$THEME}" height="60" width="61">
						</td>
						<td style="border-bottom: 1px solid rgb(204, 204, 204);" nowrap="nowrap" width="45%">
							<span class="genHeaderSmall">
								{$APP.NO_STATS} !
							</span>
						</td>
				</tr>
		  </table>
		  </div>
 		  <br><br><br><br><br><br>

		{/if}		
		
		
	</tr>
</table>
</div>










