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

{*<!-- module header -->*}

<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<script type="text/javascript" src="jscalendar/lang/calendar-{$CALENDAR_LANG}.js"></script>
<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
<script type="text/javascript" src="include/js/timesheets.js"></script>
<script type="text/javascript">
var gVTModule = '{$smarty.request.module}';
function sensex_info()
{ldelim}
        var Ticker = $('tickersymbol').value;
        if(Ticker!='')
        {ldelim}
                $("vtbusy_info").style.display="inline";
                new Ajax.Request(
                      'index.php',
                      {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
                                method: 'post',
                                postBody: 'module={$MODULE}&action=Tickerdetail&tickersymbol='+Ticker,
                                onComplete: function(response) {ldelim}
                                        $('autocom').innerHTML = response.responseText;
                                        $('autocom').style.display="block";
                                        $("vtbusy_info").style.display="none";
                                {rdelim}
                        {rdelim}
                );
        {rdelim}
{rdelim}
function AddressSync(Addform,id)
{ldelim}
        if(formValidate() == true)
        {ldelim}  
	      checkAddress(Addform,id);
        {rdelim}
{rdelim}

</script>

		{include file='Buttons_List1.tpl'}	

{*<!-- Contents -->*}
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
   <tr>
	<td valign=top><img src="{'showPanelTopLeft.gif'|@vtiger_imageurl:$THEME}"></td>

	<td class="showPanelBg" valign=top width=100%>
		{*<!-- PUBLIC CONTENTS STARTS-->*}
		<div class="small" style="padding:20px">
			{* vtlib customization: use translated label if available *}
			{assign var="SINGLE_MOD_LABEL" value=$SINGLE_MOD}
			{if $APP.$SINGLE_MOD} {assign var="SINGLE_MOD_LABEL" value=$APP.SINGLE_MOD} {/if}
				
			{if $OP_MODE eq 'edit_view'}  				
				<span class="lvtHeaderText"><font color="purple">[ {$ID} ] </font>{$NAME} - {$APP.LBL_EDITING} {$SINGLE_MOD_LABEL} {$APP.LBL_INFORMATION}</span> <br>
				{$UPDATEINFO}	 
			{/if}
			{if $OP_MODE eq 'create_view'}
				<span class="lvtHeaderText">{$APP.LBL_CREATING} {$SINGLE_MOD_LABEL}</span> <br>
			{/if}

			<hr noshade size=1>
			<br> 
		
			{include file='EditViewHidden.tpl'}

			{*<!-- Account details tabs -->*}
			<table border=0 cellspacing=0 cellpadding=0 width=95% align=center>
			   <tr>
				<td>
					<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
					   <tr>
						<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
						<td class="dvtSelectedCell" align=center nowrap>{$APP[$SINGLE_MOD]} {$APP.LBL_INFORMATION}</td>
						<td class="dvtTabCache" style="width:10px">&nbsp;</td>
						<td class="dvtTabCache" style="width:100%">&nbsp;</td>
					   </tr>
					</table>
				</td>
			   </tr>
			   <tr>
				<td valign=top align=left >
					<table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace">
					   <tr>

						<td align=left>
							{*<!-- content cache -->*}
					
							<table border=0 cellspacing=0 cellpadding=0 width=100%>
							   <tr>
								<td id ="autocom"></td>
							   </tr>
							   <tr>
								<td style="padding:10px">
									<!-- General details -->
									<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
									   <tr>
										<td  colspan=4 style="padding:5px">
											<div align="center">
												<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save" onclick="this.form.action.value='Save'; return formValidateTimesheet(); " type="submit" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
												<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmbutton small cancel" onclick="window.history.back()" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
											</div>
										</td>
									   </tr>

									   <!-- included to handle the edit fields based on ui types -->
									   {foreach key=header item=data from=$BLOCKS}
											{if $header== $MOD.LBL_INTERVENTION_INFORMATION}
												   <tr>
												   <td  colspan=4>
												   
												   <table id='interv' class='closeinterv' cellspacing=0 cellpadding=0 width="100%">
												    <tr>
														<td colspan=4 class="detailedViewHeader">
				                                            <b>{$header}</b>
											 		</td>
						                            </tr>

												   <!-- Here we should include the uitype handlings-->
												  
												   {include file="DisplayFields.tpl"}	
												   
												   <tr>
													<td  colspan=4 style="padding:5px">
													   <div align="center">
														<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}"  onclick="if(formValidateIntervention()) addToListIntervs(this.form);" type="button" name="button" value="  {$MOD.LBL_SAVE_INTERVENTION}  " style="width:200px" >
														<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}"  onclick="document.getElementById('interv').style.display='none';" type="button" name="button" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
													   </div>
													</td>
												   </tr>
												   </table>
												   </td>
												   </tr>
											{else}
												<tr>
													<td colspan=4 class="detailedViewHeader">
														<b>{$header}</b>
													</td>
												</tr>

												<!-- Here we should include the uitype handlings-->
												{include file="DisplayFields.tpl"}	
								   		   {/if}
								   
									   {/foreach}

									   <tr>
									   <td colspan=4>
											<table border=0 cellspacing=0 cellpadding=0 width="100%" class="small">
												<tr>
													<td class="detailedViewHeader">
														<b>{$MOD.LBL_INTERVENTIONS}</b>
													</td>
													<td class="detailedViewHeader" align=right>	
														
														<input title="{$MOD.LBL_ADD_INTERVENTION}" onclick="addIntervForm(this.form);" type="button" name="button" value="  {$MOD.LBL_ADD_INTERVENTION}  " style="width:200px" >
													</td>
												</tr>
												<tr>
													<td colspan=2>
													
														<table id='tabIntervs' border=1 align=center cellspacing=1 cellpadding=1 width=100%>
															<tr  class="lvt small">
																<td width='10'><img src="{'select.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ADD_INTERVENTION}" LANGUAGE=javascript onclick="document.getElementById('interv').style.display='block';" align="absmiddle" style='cursor:hand;cursor:pointer'>
				</td>

																<td align='center'><b>{$MOD.LBL_INTERVENTION_DATE}</b></td>
																<td align='center'><b>{$MOD.LBL_INTERVENTION_ACCOUNT}</b></td>
																<td align='center'><b>{$MOD.LBL_INTERVENTION_POTENTIAL}</b></td>
																<td align='center'><b>{$MOD.LBL_INTERVENTION_TASK}</b></td>
																<td align='center' width="100"><b>{$MOD.LBL_INTERVENTION_DURATION}</b></td>
															</tr>
														
															 {foreach item=interv from=$LISTINTERVENTIONS}
																<tbody class="lvt small" id="tr_{$interv.tshtintervid}">
																	<tr class="lvt small">
																	<td width='10' align="center">
																	<img src="{'remove.gif'|@vtiger_imageurl:$THEME}" alt="{$MOD.LBL_ADD_INTERVENTION}" LANGUAGE=javascript onclick="delToListIntervs('{$interv.tshtintervid}','{$interv.duration_interv}','edit');" align="absmiddle" style='cursor:hand;cursor:pointer'>
																	<td align='center'>{$interv.date_interv}</td>
																	<td align='center'>{$interv.accountname}</td>
																	<td align='center'>{$interv.potentialname}</td>
																	<td align='center'>{$interv.intervtask}</td>
																	<td align='center' width="100" id="duration_{$interv.tshtintervid}">{$interv.duration_interv}</td>
																	</tr>
																</tbody>																
															{/foreach}	
															</table>
															<table border=1 align=center cellspacing=1 cellpadding=1 width=100%>
															<input type=hidden name=dureeTotale value={$DURATIONHOURS}>
															<tr class="lvt small">
																<td colspan='5' align=right><b>{$MOD.LBL_TIMESHEET_TOTAL_DURATION}</b></td>
																<td align='center' width="100" id='dureeT'><b>{$DURATIONHOURS}</b></td>
															</tr>
														</table>
													</td>
												</tr>
										</table>
										</td>
                                    </tr>

									   <tr>
										<td  colspan=4 style="padding:5px">
											<div align="center">
										           	<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save" onclick="this.form.action.value='Save'; return formValidateTimesheet(); " type="submit" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
                                        			<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmbutton small cancel" onclick="window.history.back()" type="button" name="button" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
											</div>
										</td>
									   </tr>
									</table>
								</td>
							   </tr>
							</table>
						</td>
					   </tr>
					</table>
				</td>
			   </tr>
			</table>
		<div>
	</td>
	<td align=right valign=top><img src="{'showPanelTopRight.gif'|@vtiger_imageurl:$THEME}"></td>
   </tr>
</table>
<!--added to fix 4600-->
<input name='search_url' id="search_url" type='hidden' value='{$SEARCH}'>
</form>


{if ($MODULE eq 'Emails' || 'Documents') and ($FCKEDITOR_DISPLAY eq 'true')}
	<script type="text/javascript" src="include/fckeditor/fckeditor.js"></script>
	<script type="text/javascript" defer="1">
		var oFCKeditor = null;
		{if $MODULE eq 'Documents'}
			oFCKeditor = new FCKeditor( "notecontent" ) ;
		{/if}
		oFCKeditor.BasePath   = "include/fckeditor/" ;
		oFCKeditor.ReplaceTextarea() ;
	</script>
{/if}

{if $MODULE eq 'Accounts'}
<script>
	ScrollEffect.limit = 201;
	ScrollEffect.closelimit= 200;
</script>
{/if}
<script>	

        var fieldname = new Array({$VALIDATION_DATA_FIELDNAME})

        var fieldlabel = new Array({$VALIDATION_DATA_FIELDLABEL})

        var fielddatatype = new Array({$VALIDATION_DATA_FIELDDATATYPE})

	var ProductImages=new Array();
	var count=0;

	function delRowEmt(imagename)
	{ldelim}
		ProductImages[count++]=imagename;
	{rdelim}

	function displaydeleted()
	{ldelim}
		var imagelists='';
		for(var x = 0; x < ProductImages.length; x++)
		{ldelim}
			imagelists+=ProductImages[x]+'###';
		{rdelim}

		if(imagelists != '')
			document.EditView.imagelist.value=imagelists
	{rdelim}

</script>

<!-- vtlib customization: Help information assocaited with the fields -->
{if $FIELDHELPINFO}
<script type='text/javascript'>
{literal}var fieldhelpinfo = {}; {/literal}
{foreach item=FIELDHELPVAL key=FIELDHELPKEY from=$FIELDHELPINFO}
	fieldhelpinfo["{$FIELDHELPKEY}"] = "{$FIELDHELPVAL}";
{/foreach}
</script>
{/if}
<!-- END -->
