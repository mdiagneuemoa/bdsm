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
</script>


<br/><br/>

{*<!-- Contents -->*}
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
   <tr>
	<td valign=top>
		<img src="{'showPanelTopLeft.gif'|@vtiger_imageurl:$THEME}">
	</td>

	<td class="showPanelBg" valign=top width=100%>
	     {*<!-- PUBLIC CONTENTS STARTS-->*}
	     <div class="small" style="padding:20px">
		
		{* vtlib customization: use translation only if present *}
		{assign var="SINGLE_MOD_LABEL" value=$SINGLE_MOD}
		{if $APP.$SINGLE_MOD} {assign var="SINGLE_MOD_LABEL" value=$APP.SINGLE_MOD} {/if}
				
		 {if $MODE eq 'edit'}   
			 <span class="lvtHeaderText">{$MOD.LBL_MODIFICATION_PROFIL}</span> <br>
			{$UPDATEINFO}	 
		{else}
			 <span class="lvtHeaderText">{$MOD.LBL_DESACTIVATION_USER}</span> <br>
		 {/if}

		 {if $OP_MODE eq 'create_view'}
			{if $DUPLICATE neq 'true'}
			{assign var=create_new value="LBL_CREATING_NEW_"|cat:$SINGLE_MOD}
				{* vtlib customization: use translation only if present *}
				{assign var="create_newlabel" value=$APP.$create_new}
				{if $create_newlabel neq ''}
					<span class="lvtHeaderText">{$create_newlabel}</span> <br>
				{else}
					<!--<span class="lvtHeaderText">{$APP.LBL_CREATING} {$APP.LBL_NEW} {$SINGLE_MOD}</span> <br>-->
					<span class="lvtHeaderText">{$APP.LBL_NEW} {$SINGLE_MOD}</span> <br>
				{/if}
		        
			{else}
			<span class="lvtHeaderText">{$APP.LBL_DUPLICATING} "{$NAME}" </span> <br>
			{/if}
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

					{if $ADVBLOCKS neq ''}	
						<td width=75 style="width:15%" align="center" nowrap class="dvtSelectedCell" id="bi" onclick="fnLoadValues('bi','mi','basicTab','moreTab','normal','{$MODULE}')"><b>{$APP.LBL_BASIC} {$APP.LBL_INFORMATION}</b></td>
                    	<td class="dvtUnSelectedCell" style="width: 100px;" align="center" nowrap id="mi" onclick="fnLoadValues('mi','bi','moreTab','basicTab','normal','{$MODULE}')"><b>{$APP.LBL_MORE} {$APP.LBL_INFORMATION} </b></td>
                   		<td class="dvtTabCache" style="width:65%" nowrap>&nbsp;</td>
					{else}
						<td class="dvtSelectedCell" align=center nowrap>{$APP.LBL_BASIC} {$APP.LBL_INFORMATION}</td>
	                    <td class="dvtTabCache" style="width:65%">&nbsp;</td>
					{/if}
				   <tr>
				</table>
			</td>
		   </tr>
		   <tr>
			<td valign=top align=left >

			    <!-- Basic Information Tab Opened -->
			    <div id="basicTab">

				<table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace">
				   <tr>
					<td align=left>
					<!-- content cache -->
					
						<table border=0 cellspacing=0 cellpadding=0 width=100%>
						   <tr>
							<td id ="autocom"></td>
						   </tr>
						   <tr>
							<td style="padding:10px">
							<!-- General details -->
								<table border=0 cellspacing=0 cellpadding=5 width="100%" class="small">

									<input type="hidden" name="record" value="{$ID}">
									<input type="hidden" id="mode" name="mode" value="{$MODE}">
									<input type="hidden" id="profilId" name="profilId" value="{$IDPROFILE}">
									
									<tr class="small">
									    <td width="15%" class="small cellLabel"><strong>{$MOD.Matricule}</strong></td>
									    <td width="85%" class="cellText" >{$MATRICULE}</td>
									</tr>
									<tr class="small">
									    <td width="15%" class="small cellLabel" ><strong>{$MOD.Lastname}</strong></td>
									    <td width="85%" class="cellText" >{$NOM}</td>
									</tr>
									<tr class="small">
									    <td class="small cellLabel"><strong>{$MOD.Firstname}</strong></td>
									    <td class="cellText">{$PRENOM} </td>
									</tr>
						
									{if $MODE == 'edit'}			
									<tr class="small">
									    <td class="small cellLabel"><strong>{$MOD.Profil}</strong></td>
									    <td class="cellText">
									    {$PROFILESLIST}
									    </td>
									</tr>
									{else}
									    <td class="small cellLabel"><strong>{$MOD.Profil}</strong></td>
									    <td class="cellText"> {$PROFILENAME}</td>
									{/if}
									
									{if $MODE == 'delete' || $MODE == 'enable'}
									<tr class="small">
										<td class="small cellLabel"><strong>{$MOD.Raison}</strong></td>
										<td class="cellText"><textarea name="raison" class="detailedViewTextBox" rows=2 cols=30> </textarea></td>
									</tr>
									{/if}
	
									<tr><td><div><font color="red">(f) : champs facultatifs</font></div></td></tr>
								   <tr>
									<td  colspan=4 style="padding:5px">
									   <div align="center">
 										{if $MODE == 'edit'}			
                                            <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" class="crmbutton small save" onclick="getProfileSelected({$ID}); this.form.action.value='Save';  return formValidate()" type="submit" name="button" value="{$APP.LBL_MODIFIER_BUTTON_LABEL}" style="width:70px">
                                        {elseif $MODE == 'enable'}
                                        	<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" class="crmbutton small save" onclick="getProfileSelected({$ID}); this.form.action.value='Save';  return formValidate()" type="submit" name="button" value="{$APP.LBL_ACTIVER_BUTTON_LABEL}" style="width:70px">
                                         {else}
                                        	<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" class="crmbutton small save" onclick="getProfileSelected({$ID}); this.form.action.value='Save';  return formValidate()" type="submit" name="button" value="{$APP.LBL_DESACTIVER_BUTTON_LABEL}" style="width:70px">
                                        {/if}
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
						
			    </div>
			    <!-- Basic Information Tab Closed -->

			</td>
		   </tr>
		</table>
	     </div>
	</td>
	<td align=right valign=top><img src="{'showPanelTopRight.gif'|@vtiger_imageurl:$THEME}"></td>
   </tr>
</table>
</form>

{if ($MODULE eq 'Emails' || 'Documents' || 'HReports') and ($FCKEDITOR_DISPLAY eq 'true')}
       <script type="text/javascript" src="include/fckeditor/fckeditor.js"></script>
       <script type="text/javascript" defer="1">

       var oFCKeditor = null;

       {if $MODULE eq 'Documents'}
               oFCKeditor = new FCKeditor( "notecontent" ) ;
       {/if}
	   {if $MODULE eq 'HReports'}
               oFCKeditor = new FCKeditor( "hreportcontent" ) ;
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

<script type='text/javascript'>
function getProfileSelected(userId) 
{ldelim}
	var element = document.getElementById('profil'+userId);
	if(element != null) 
	{ldelim}
		var profil = element.value;
		var mode = document.getElementById('mode').value;
		if(mode == 'edit') 
		{ldelim}
			document.getElementById('profilId').value = profil;
		{rdelim}
	{rdelim}
{rdelim}
</script>
