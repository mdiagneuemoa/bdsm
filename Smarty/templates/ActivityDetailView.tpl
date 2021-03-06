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
<script type="text/javascript" src="modules/{$MODULE}/Calendar.js"></script>
<script type="text/javascript" src="include/js/reflection.js"></script>
<script src="include/scriptaculous/scriptaculous.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="include/js/dtlviewajax.js"></script>
<span id="crmspanid" style="display:none;position:absolute;"  onmouseover="show('crmspanid');">
   <a class="link"  align="right" href="javascript:;">{$APP.LBL_EDIT_BUTTON}</a>
</span>

<script>
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

{literal}
function setCoOrdinate(elemId)
{
	oBtnObj = document.getElementById(elemId);
	var tagName = document.getElementById('lstRecordLayout');
	leftpos  = 0;
	toppos = 0;
	aTag = oBtnObj;
	do 
	{					  
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
				var getVal = eval(leftSide) + eval(widthM);
				if(getVal  > document.body.clientWidth ){
					leftSide = eval(leftSide) - eval(widthM);
					tagName.style.left = leftSide + 230 + 'px';
				}
				else
					tagName.style.left= leftSide + 388 + 'px';
				
				setCoOrdinate(obj.id);
				
				tagName.style.display = 'block';
				tagName.style.visibility = "visible";
			}
		}
	);
}
{/literal}
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

</script>

<div id="lstRecordLayout" class="layerPopup" style="display:none;width:325px;height:300px;"></div> <!-- Code added by SAKTI on 17th Jun, 2008 -->

<table width="100%" cellpadding="2" cellspacing="0" border="0">
<form action="index.php" method="post" name="DetailView" id="form">
<tr><td>&nbsp;</td>
	<td>
                <table cellpadding="0" cellspacing="5" border="0">
			{include file='DetailViewHidden.tpl'}
		</table>	

<!-- Contents -->
<table  border="0" cellpadding="5" cellspacing="0" width="100%" >
<tr>
	<td style="border-bottom:1px dotted #cccccc">
	
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align="left">		
					<span class="lvtHeaderText"><font color="purple">[ {$ID} ] </font>{$NAME} -  {$SINGLE_MOD} {$APP.LBL_INFORMATION}</span>&nbsp;&nbsp;<span class="small">{$UPDATEINFO}</span>&nbsp;<span id="vtbusy_info" style="display:none;" valign="bottom"><img src="{'vtbusy.gif'|@vtiger_imageurl:$THEME}" border="0"></span><span id="vtbusy_info" style="visibility:hidden;" valign="bottom"><img src="{'vtbusy.gif'|@vtiger_imageurl:$THEME}" border="0"></span>
				</td>
				<td align="right">		
					{if $EDIT_DUPLICATE eq 'permitted'}
					<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="crmbutton small edit" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.return_id.value='{$ID}';this.form.module.value='{$MODULE}';this.form.action.value='EditView'" type="submit" name="Edit" value="&nbsp;{$APP.LBL_EDIT_BUTTON_LABEL}&nbsp;">&nbsp;
					{/if}
					
					{if $EDIT_DUPLICATE eq 'permitted'}
					<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="crmbutton small create" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.isDuplicate.value='true';this.form.module.value='{$MODULE}'; this.form.action.value='EditView'" type="submit" name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}">&nbsp;
                    {/if}
                    
                    {if $DELETE eq 'permitted'}
					<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="crmbutton small delete" onclick="this.form.return_module.value='{$MODULE}'; {if $VIEWTYPE eq 'calendar'} this.form.return_action.value='index'; {else} this.form.return_action.value='ListView'; {/if}  this.form.action.value='Delete'; return confirm('{$APP.NTC_DELETE_CONFIRMATION}')" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}">&nbsp;
					{/if}
					
					{if $privrecord neq ''}
					<img align="absmiddle" title="{$APP.LNK_LIST_PREVIOUS}" accessKey="{$APP.LNK_LIST_PREVIOUS}" onclick="location.href='index.php?module={$MODULE}&viewtype={$VIEWTYPE}&action=DetailView&record={$privrecord}&parenttab={$CATEGORY}'" name="privrecord" value="{$APP.LNK_LIST_PREVIOUS}" src="{'rec_prev.gif'|@vtiger_imageurl:$THEME}">&nbsp;
					{else}
					<img align="absmiddle" title="{$APP.LNK_LIST_PREVIOUS}" src="{'rec_prev_disabled.gif'|@vtiger_imageurl:$THEME}">
					{/if}
					
					{if $privrecord neq '' || $nextrecord neq ''}
					<img align="absmiddle" title="{$APP.LBL_JUMP_BTN}" accessKey="{$APP.LBL_JUMP_BTN}" onclick="var obj = this;var lhref = getListOfRecords(obj, '{$MODULE}',{$ID},'{$CATEGORY}');" name="jumpBtnIdTop" id="jumpBtnIdTop" src="{'rec_jump.gif'|@vtiger_imageurl:$THEME}">
					{/if}
					&nbsp;
					{if $nextrecord neq ''}
					<img align="absmiddle" title="{$APP.LNK_LIST_NEXT}" accessKey="{$APP.LNK_LIST_NEXT}" onclick="location.href='index.php?module={$MODULE}&viewtype={$VIEWTYPE}&action=DetailView&record={$nextrecord}&parenttab={$CATEGORY}'" name="nextrecord" src="{'rec_next.gif'|@vtiger_imageurl:$THEME}">&nbsp;
					{else}
					<img align="absmiddle" title="{$APP.LNK_LIST_NEXT}" src="{'rec_next_disabled.gif'|@vtiger_imageurl:$THEME}">&nbsp;
					{/if}
				</td>
			</tr>
		 </table>
	</td>
</tr>
<tr><td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td valign=top align=left >
                           <table border=0 cellspacing=0 cellpadding=3 width=100%>
				<tr>
					<td align=left>
					<!-- content cache -->
					
					<table border=0 cellspacing=0 cellpadding=0 width=100%>
			                  <tr>
					     <td style="padding:3px">
						     <!-- General details -->
						     {foreach key=header item=detail from=$BLOCKS}
							     {if $header neq $APP.LBL_CUSTOM_INFORMATION}
						     <table border=0 cellspacing=0 cellpadding=5 width=100% class="small">
						     	<tr>{strip}
						     		<td colspan=4 class="tableHeading">
									<b>{$header}</b>
								</td>{/strip}
					             	</tr>
						     </table>
							     {/if}
						     {/foreach}
						     {if $ACTIVITYDATA.activitytype neq 'Task'}	
							 <!-- display of fields starts -->
						     <table border=0 cellspacing=0 cellpadding=5 width=100% >
               					<!--	 <tr>
											{if $LABEL.activitytype neq ''}
											{assign var=type value=$ACTIVITYDATA.activitytype}
											<td class="cellLabel" width="20%" align="right"><b>{$MOD.LBL_EVENTTYPE}</b></td>
											<td class="cellInfo" width="30%"align="left">{$type}</td>
											{/if}
											{if $LABEL.visibility neq ''}
											{assign var=vblty value=$ACTIVITYDATA.visibility}
											<td class="cellLabel" width="20%" align="right"><b>{$LABEL.visibility}</b></td>
			                                                                <td class="cellInfo" width="30%" align="left" >{$MOD.$vblty}</td>
											{/if}
							 </tr> -->
							 <tr>
                        					<td class="cellLabel" align="right"><b>{$MOD.LBL_EVENTNAME}</b></td>
					                        <td class="cellInfo" colspan=3 align="left" >{$ACTIVITYDATA.subject}</td>
             						 </tr>
							 {if $LABEL.description neq ''}
							 <tr>
								<td class="cellLabel" align="right" nowrap valign="top"><b>{$LABEL.description}</b></td>
								<td class="cellInfo" valign="top" align="left" colspan="3" height="60px">{$ACTIVITYDATA.description}&nbsp;</td>
							 </tr>
							{/if}
							<tr>
							{if $LABEL.location neq ''}
								<td class="cellLabel" align="right" valign="top"><b>{$LABEL.location}</b></td>
								<td class="cellInfo" align="left" >{$ACTIVITYDATA.location}&nbsp;</td>
							{/if}	
							
								{if $LABEL.eventstatus neq ''}
								<td class="cellLabel" align="right" nowrap valign="top"><b>{$LABEL.eventstatus}</b></td>
								<td class="cellInfo" align="left" nowrap valign="top">
									{if $ACTIVITYDATA.eventstatus eq $APP.LBL_NOT_ACCESSIBLE}
										<font color="red">{$ACTIVITYDATA.eventstatus}</font>
										{else}
											{$ACTIVITYDATA.eventstatus}
									{/if}
								</td>
								{/if}
							</tr>
							<tr>							
								{if $LABEL.assigned_user_id neq ''}
									<td class="cellLabel" align="right" nowrap valign="top"><b>{$LABEL.assigned_user_id}</b></td>
									<td class="cellInfo" align="left" nowrap valign="top">{$ACTIVITYDATA.assigned_user_id}</td>
								{/if}
								{if $LABEL.assigned_group_id neq ''}
									<td class="cellLabel" align="right" nowrap valign="top"><b>{$LABEL.assigned_group_id}</b></td>
									<td class="cellInfo" align="left" nowrap valign="top">{$ACTIVITYDATA.assigned_group_id}</td>
								{/if}
								
								{if $LABEL.taskpriority neq ''}
									<td class="cellLabel" align="right" nowrap valign="top"><b>{$LABEL.taskpriority}</b></td>
                                    <td class="cellInfo" align="left" nowrap valign="top">
										{if $ACTIVITYDATA.taskpriority eq $APP.LBL_NOT_ACCESSIBLE}
											<font color="red" >{$ACTIVITYDATA.taskpriority}</font>
										{else}
											{$ACTIVITYDATA.taskpriority}
										{/if}
									</td>
								{/if}
							</tr>	
							{if $LABEL.createdtime neq '' || $LABEL.modifiedtime neq ''}
								 <tr>
										<td class="cellLabel" align="right" nowrap valign="top"align="right">{if $LABEL.createdtime neq ''}<b>{$LABEL.createdtime}</b>{/if}</td>
										<td class="cellInfo" align="left" nowrap valign="top">{if $LABEL.createdtime neq ''}{$ACTIVITYDATA.createdtime}{/if}</td>
										<td class="cellLabel" align="right" nowrap valign="top"align="right">{if $LABEL.modifiedtime neq ''}<b>{$LABEL.modifiedtime}</b>{/if}</td>
										<td class="cellInfo" align="left" nowrap valign="top">{if $LABEL.modifiedtime neq ''}{$ACTIVITYDATA.modifiedtime}{/if}</td>
								 </tr>
							{/if}
						    <tr>
								<td class="cellLabel" align="right"><b>{$MOD.LBL_EVENTSTAT}</b></td>
								<td class="cellInfo" align="left">{$ACTIVITYDATA.date_start}&nbsp;{$ACTIVITYDATA.starthr}:{$ACTIVITYDATA.startmin}</td>
								<td  class="cellLabel" align="right"><b>{$MOD.LBL_EVENTEDAT}</b></td>
								<td class="cellInfo" align="left">{$ACTIVITYDATA.due_date}&nbsp;{$ACTIVITYDATA.endhr}:{$ACTIVITYDATA.endmin}{$ACTIVITYDATA.endfmt}</td>
                            </tr>
                        </table>
                    </td></tr>
                </table>
							{if $CUSTOM_FIELDS_DATA|@count > 0}
	                             <table border=0 cellspacing=0 cellpadding=5 width=100% >
	                             	<tr>{strip}
							     		<td colspan=4 class="tableHeading">
										<b>{$APP.LBL_CUSTOM_INFORMATION}</b>
										</td>{/strip}
						          	</tr>
						          	<tr>
						          		{foreach key=index item=custom_field from=$CUSTOM_FIELDS_DATA}
						          		{assign var=keyid value=$custom_field.2}
						          		{assign var=keyval value=$custom_field.1}
						          		{assign var=keyfldname value=$custom_field.0}
						          		{assign var=keyoptions value=$custom_field.options}
						          		<td class="cellLabel" align="right" width="20%"><b>{$keyfldname}</b></td>
						          		{include file="DetailViewFields.tpl"}
						          		{if ($index+1)% 2 == 0}
						          			</tr><tr>
						          		{/if}
							            {/foreach}
							        {if ($index+1)% 2 != 0}
							        	<td width="20%"></td><td width="30%"></td>
							        {/if}
						            </tr>
	                             </table>   
                             {/if}    
						     <br>
					             <table border=0 cellspacing=0 cellpadding=0 width=100% align=center>
                					 <tr>
                        				<td>
											<table border=0 cellspacing=0 cellpadding=3 width=100%>
												<tr>
													<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
													<td id="cellTabInvite" class="dvtSelectedCell" align=center nowrap><a href="javascript:doNothing()" onClick="switchClass('cellTabInvite','on');switchClass('cellTabAlarm','off');switchClass('cellTabRepeat','off');switchClass('cellTabRelatedto','off');ghide('addEventAlarmUI');dispLayer('addEventInviteUI');ghide('addEventRepeatUI');ghide('addEventRelatedtoUI');">{$MOD.LBL_INVITE}</a></td>
										<!--<td class="dvtTabCache" style="width:10px">&nbsp;</td>
										{if $LABEL.reminder_time neq ''}
										<td id="cellTabAlarm" class="dvtUnSelectedCell" align=center nowrap><a href="javascript:doNothing()" onClick="switchClass('cellTabInvite','off');switchClass('cellTabAlarm','on');switchClass('cellTabRepeat','off');switchClass('cellTabRelatedto','off');dispLayer('addEventAlarmUI');ghide('addEventInviteUI');ghide('addEventRepeatUI');ghide('addEventRelatedtoUI');">{$MOD.LBL_REMINDER}</a></td>
										{/if}
										<td class="dvtTabCache" style="width:10px">&nbsp;</td>
										{if $LABEL.recurringtype neq ''}
										<td id="cellTabRepeat" class="dvtUnSelectedCell" align=center nowrap><a href="javascript:doNothing()" onClick="switchClass('cellTabInvite','off');switchClass('cellTabAlarm','off');switchClass('cellTabRepeat','on');switchClass('cellTabRelatedto','off');ghide('addEventAlarmUI');ghide('addEventInviteUI');dispLayer('addEventRepeatUI');ghide('addEventRelatedtoUI');">{$MOD.LBL_REPEAT}</a></td>
										{/if}
										<td class="dvtTabCache" style="width:10px">&nbsp;</td>
										<td id="cellTabRelatedto" class="dvtUnSelectedCell" align=center nowrap><a href="javascript:doNothing()" onClick="switchClass('cellTabInvite','off');switchClass('cellTabAlarm','off');switchClass('cellTabRepeat','off');switchClass('cellTabRelatedto','on');ghide('addEventAlarmUI');ghide('addEventInviteUI');dispLayer('addEventRelatedtoUI');ghide('addEventRepeatUI');">{$MOD.LBL_LIST_RELATED_TO}</a></td>
										<td class="dvtTabCache" style="width:100%">&nbsp;</td>
										-->
										<td class="dvtTabCache" style="width:100%">&nbsp;</td>
									</tr>
									</table>
								</td>
							 </tr>
							
							 <tr>
								<td width=100% valign=top align=left class="dvtContentSpace" style="padding:10px;height:120px">
									<!-- Invite UI -->
									<DIV id="addEventInviteUI" style="display:block;width:100%">
									<table width="100%" cellpadding="5" cellspacing="0" border="0">
										<tr>
                                                                                        <td width="30%" valign="top" align=right><b>{$MOD.LBL_USERS}</b></td>
                                                                                        <td width="70%" align=left valign="top" >
												{foreach item=username key=userid from=$INVITEDUSERS}
                                                                                        	        {$username}<br>
                                                                                                {/foreach}
											</td>
                                                                                </tr>
									</table>
									</DIV>
									<!-- Reminder UI -->
									<!--		
									  <DIV id="addEventAlarmUI" style="display:none;width:100%">
									{if $LABEL.reminder_time != ''}
									<table width="100%" cellpadding="5" cellspacing="0" border="0">
									<tr>
											<td width="30%" align=right><b>{$MOD.LBL_SENDREMINDER}</b></td>
											<td width="70%" align=left>{$ACTIVITYDATA.set_reminder}</td>
									</tr>
										{if $ACTIVITYDATA.set_reminder != 'No'}
										<tr>
                                                                                        <td width="30%" align=right><b>{$MOD.LBL_RMD_ON}</b></td>
											<td width="70%" align=left>{$ACTIVITYDATA.reminder_str}</td>
										</tr>
										{/if}
                                                                        </table>
									{/if}
									</DIV>
									-->
									<!-- Repeat UI -->
									<!--
									<div id="addEventRepeatUI" style="display:none;width:100%">
									{if $LABEL.recurringtype neq ''}
									<table width="100%" cellpadding="5" cellspacing="0" border="0">
										<tr>
											<td width="30%" align=right><b>{$MOD.LBL_ENABLE_REPEAT}</b></td>
											<td width="70%" align=left>{$ACTIVITYDATA.recurringcheck}</td>
										</tr>
										{if $ACTIVITYDATA.recurringcheck != 'No'}
										<tr>
											<td width="30%" align=right>&nbsp;</td>
											<td>{$MOD.LBL_REPEATEVENT}&nbsp;{$ACTIVITYDATA.repeat_frequency}&nbsp;{$MOD[$ACTIVITYDATA.recurringtype]}</td>
										</tr>
										<tr>
                                                                                        <td width="30%" align=right>&nbsp;</td>
                                                                                        <td>{$ACTIVITYDATA.repeat_str}</td>
                                                                                </tr>
										{/if}
									</table>
									{/if}
									</div>
									-->
									<!-- Relatedto UI -->
									<!--
									<div id="addEventRelatedtoUI" style="display:none;width:100%">
									<table width="100%" cellpadding="5" cellspacing="0" border="0">
										{if $LABEL.parent_id neq ''}
										<tr>
											<td width="30%" align=right valign="top"><b>{$LABEL.parent_id}</b></td>
											<td width="70%" align=left valign="top">{$ACTIVITYDATA.parent_name}</td>
										</tr>
										{/if}
										<tr>
											<td width="30%" valign="top" align=right><b>{$MOD.LBL_CONTACT_NAME}</b></td>	
											<td width="70%" valign="top" align=left>
											{foreach item=contactname key=cntid from=$CONTACTS}
	                                        	{$contactname.0}
	                                            {if $IS_PERMITTED_CNT_FNAME == '0'}
	                                            	&nbsp;{$contactname.1}
	                                            {/if}
	                                            <br>
                                            {/foreach}
										</tr>
									</table>
									</div>
									-->
								</td>
                					 </tr>
						     </table>
						    {else}
							<!-- detailed view of a ToDo -->
					 	     <table border="0" cellpadding="5" cellspacing="0" width="100%">
							<tr>
								<td class="cellLabel"  align="right"><b>{$MOD.LBL_TODO}</b></td>
								<td class="cellInfo" colspan="3" align="left">{$ACTIVITYDATA.subject}</td>
							</tr>
							{if $LABEL.description neq ''}
								<tr>
									<td class="cellLabel" align="right" valign="top"><b>{$LABEL.description}</b></td>
	                                <td class="cellInfo" colspan="3" align="left" colspan="3" valign="top" height="40px">{$ACTIVITYDATA.description}&nbsp;</td>
	                			</tr>
							{/if}
							 <tr>
								{if $LABEL.taskpriority neq ''}
									<td class="cellLabel"  align="right"><b>{$LABEL.taskpriority}</b></td>
									<td class="cellInfo" align="left" valign="top">
										{if $ACTIVITYDATA.taskpriority eq $APP.LBL_NOT_ACCESSIBLE}
											<font color="red">{$ACTIVITYDATA.taskpriority}</font>
										{else}{$ACTIVITYDATA.taskpriority}{/if}
									</td>
								{/if}
								{if $LABEL.taskstatus neq ''}
                                	<td class="cellLabel"  align="right"><b>{$LABEL.taskstatus}</b></td>
									<td class="cellInfo" align="left" valign="top">
										{if $ACTIVITYDATA.taskstatus eq $APP.LBL_NOT_ACCESSIBLE}
                                           	<font color="red">{$ACTIVITYDATA.taskstatus}</font>
										{else} 
											{$ACTIVITYDATA.taskstatus}{/if}
                                    </td>
								{/if}
								</tr>
							<tr>
								<td class="cellLabel"  align="right"><b>{$MOD.LBL_TIMEDATE}</b></td>
								<td class="cellInfo">{$ACTIVITYDATA.date_start}
									&nbsp;{$ACTIVITYDATA.starthr}:{$ACTIVITYDATA.startmin}{$ACTIVITYDATA.startfmt}
								</td>
								<td class="cellLabel"  align="right"><b>{$LABEL.due_date}</b></td>
								<td class="cellInfo">{$ACTIVITYDATA.due_date}</td>
							</tr>	
							<tr>
								{if $LABEL.createdtime neq ''}
									<td class="cellLabel" align=right nowrap><b>{$LABEL.createdtime}</b></td>
									<td class="cellInfo" align=left nowrap>{$ACTIVITYDATA.createdtime}</td>
								{/if}	
								{if $LABEL.modifiedtime neq ''}
									<td class="cellLabel" align=right nowrap ><b>{$LABEL.modifiedtime}</b></td>
									<td class="cellInfo" align=left  nowrap>{$ACTIVITYDATA.modifiedtime}</td>
								{/if}
                            </tr>    		

							<tr>
								<td class="cellLabel"  align="right"><b>{$LABEL.assigned_user_id}</b></td>
								<td class="cellInfo" align="left">{$ACTIVITYDATA.assigned_user_id}</td>
								<td class="cellLabel" align="right"><b>Equipe</b></td>
								<td class="cellInfo" align="left">
									<table cellpadding="2" cellspacing="5">
										<tr>
											{if $ACTIVITYDATA.chefequipe neq ''}
												<td align="right"><b>Chef Equipe :</b></td> 
												<td align="left">{$ACTIVITYDATA.chefequipe}</td>
											{/if}	
											{if $ACTIVITYDATA.coordonnateur neq ''}	
												<td><b>Coordonnateur :</b></td> 
												<td align="left">{$ACTIVITYDATA.coordonnateur}</td>
											{/if}
										</tr>
										<tr>	
											{if $ACTIVITYDATA.consultant1 neq ''}
												<td align="right"><b>Consultant 1 :</b></td> 
												<td align="left">{$ACTIVITYDATA.consultant1}</td>
											{/if}
											{if $ACTIVITYDATA.consultant2 neq ''}
												<td><b>Consultant 2 :</b></td> 
												<td align="left">{$ACTIVITYDATA.consultant2}</td>
											{/if}
										</tr>
										<tr>								
											{if $ACTIVITYDATA.assistant1 neq ''}
												<td align="right"><b>Assistant 1 :</b></td> 
												<td align="left">{$ACTIVITYDATA.assistant1}</td>
											{/if}
											{if $ACTIVITYDATA.assistant2 neq ''}
												<td align="right"><b>Assistant 2 :</b></td> 
												<td align="left">{$ACTIVITYDATA.assistant2}</td>
											{/if}
										</tr>	
									</table>	
								</td>	
							</tr>
						</table>
						
						 <!--  
						     <table border=0 cellspacing=0 cellpadding=5 width=100% >
							<tr>
								                        </tr>
                            </table>
							
							{if $CUSTOM_FIELDS_DATA|@count > 0}
	                             <table border=0 cellspacing=0 cellpadding=5 width=100% >
	                             	<tr>{strip}
							     		<td colspan=4 class="tableHeading">
										<b>{$APP.LBL_CUSTOM_INFORMATION}</b>
										</td>{/strip}
						          	</tr>
						          	<tr>
						          		{foreach key=index item=custom_field from=$CUSTOM_FIELDS_DATA}
						          		{assign var=keyid value=$custom_field.2}
						          		{assign var=keyval value=$custom_field.1}
						          		{assign var=keyfldname value=$custom_field.0}
						          		{assign var=keyoptions value=$custom_field.options}
						          		<td class="cellLabel" align="right" width="20%"><b>{$keyfldname}</b></td>
						          		{include file="DetailViewFields.tpl"}
											{if ($index+1)% 2 == 0}
												</tr><tr>
											{/if}
							            {/foreach}
							        {if ($index+1)% 2 != 0}
							        	<td width="20%"></td><td width="30%"></td>
							        {/if}
						            </tr>
	                             </table>   
                             {/if}  
						     <br>

						     {if $LABEL.sendnotification neq '' || ($LABEL.parent_id neq '') || ($LABEL.contact_id neq '') } 
						     <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td>
									<table border="0" cellpadding="3" cellspacing="0" width="100%">
									<tr>
										<td class="dvtTabCache" style="width: 10px;" nowrap="nowrap">&nbsp;</td>
										{if $LABEL.sendnotification neq ''}
                                                                                        {assign var='class_val' value='dvtUnSelectedCell'}
	                                                                                <td id="cellTabInvite" class="dvtSelectedCell" align="center" nowrap="nowrap"><a href="javascript:doNothing()" onClick="switchClass('cellTabInvite','on');switchClass('cellTabRelatedto','off');dispLayer('addTaskAlarmUI');ghide('addTaskRelatedtoUI');">{$MOD.LBL_NOTIFICATION}</td></a></td>
										{else}
                                                                                        {assign var='class_val' value='dvtSelectedCell'}
                                                                                {/if}
										<td class="dvtTabCache" style="width: 10px;" nowrap="nowrap">&nbsp;</td>
										{if ($LABEL.parent_id neq '') || ($LABEL.contact_id neq '') }
                                                                                <td id="cellTabRelatedto" class={$class_val} align=center nowrap><a href="javascript:doNothing()" onClick="switchClass('cellTabInvite','off');switchClass('cellTabRelatedto','on');dispLayer('addTaskRelatedtoUI');ghide('addTaskAlarmUI');">{$MOD.LBL_RELATEDTO}</a></td>
										{/if}

                                                                                <td class="dvtTabCache" style="width: 100%;">&nbsp;</td>
									</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width=100% valign=top align=left class="dvtContentSpace" style="padding:10px;height:120px">
                                                               
                                                                        <DIV id="addTaskAlarmUI" style="display:block;width:100%">
									{if $LABEL.sendnotification neq ''}
									{assign var='vision' value='none'}
                                                                        <table width="100%" cellpadding="5" cellspacing="0" border="0">
                                                                                <tr>
                                                                                        <td width="30%" align=right><b>{$MOD.LBL_SENDNOTIFICATION}</b></td>
                                                                                        <td width="70%" align=left>{$ACTIVITYDATA.sendnotification}</td>
                                                                                </tr>
                                                                        </table>
									{else}
                                                                        {assign var='vision' value='block'}
                                                                        {/if}
                                                                        </DIV>
									<div id="addTaskRelatedtoUI" style="display:{$vision};width:100%">
									<table width="100%" cellpadding="5" cellspacing="0" border="0">
                                                                                <tr>
										{if $LABEL.parent_id neq ''}
                                                                                        <td width="30%" align=right><b>{$LABEL.parent_id}</b></td>
                                                                                        <td width="70%" align=left>{$ACTIVITYDATA.parent_name}</td>
										{/if}
                                                                                </tr>
                                                                                <tr>
										{if $LABEL.contact_id neq ''}
                                                                                        <td width="30%" align=right><b>{$MOD.LBL_CONTACT_NAME}</b></td>
											<td width="70%" align=left><a href="{$ACTIVITYDATA.contact_idlink}">{$ACTIVITYDATA.contact_id}</a></td>
										{/if}
                                                                                </tr>
                                                                        </table>
                                                                        </div>
								</td>
							</tr>
						     </table>
						     {/if}

                     	                      </td>
					   </tr>
                </table>-->
		{/if}
		</form>
	</table>
	</td>
		<!-- right side relevant info -->
	<!--
	<td width=22% valign=top style="border-left:2px dashed #cccccc;padding:13px">
					
		{* vtlib customization: Custom links on the Detail view *}
		{if $CUSTOM_LINKS}
			<table width="100%" border="0" cellpadding="5" cellspacing="0">
				<tr><td align="left" class="dvtUnSelectedCell dvtCellLabel">
					<a href="javascript:;" onmouseover="fnvshobj(this,'vtlib_customLinksLay');" onclick="fnvshobj(this,'vtlib_customLinksLay');"><b>{$APP.LBL_MORE} {$APP.LBL_ACTIONS} &#187;</b></a>
				</td></tr>
			</table>
			<br>
			<div style="display: none; left: 193px; top: 106px;width:155px; position:absolute;" id="vtlib_customLinksLay" 
				onmouseout="fninvsh('vtlib_customLinksLay')" onmouseover="fnvshNrm('vtlib_customLinksLay')">
				<table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr><td style="border-bottom: 1px solid rgb(204, 204, 204); padding: 5px;"><b>{$APP.LBL_MORE} {$APP.LBL_ACTIONS} &#187;</b></td></tr>
				<tr>
					<td>
						{foreach item=CUSTOMLINK from=$CUSTOM_LINKS}
							{assign var="customlink_href" value=$CUSTOMLINK->linkurl}
							{assign var="customlink_label" value=$CUSTOMLINK->linklabel}
							{assign var="customlink_module" value=$CUSTOMLINK->module()}
							{if $customlink_label eq ''}
								{assign var="customlink_label" value=$customlink_href}
							{else}
								{* Pickup the translated label provided by the module *}
								{assign var="customlink_label" value=$customlink_label|@getTranslatedString:$customlink_module}
							{/if}
							<a href="{$customlink_href}" class="drop_down">{$customlink_label}</a>
						{/foreach}
					</td>
				</tr>
			</table>
			</div>
		{/if}
		{* END *}

		{if $TAG_CLOUD_DISPLAY eq 'true'}
		
		<table border=0 cellspacing=0 cellpadding=0 width=100% class="tagCloud">
		<tr>
			<td class="tagCloudTopBg"><img src="{$IMAGE_PATH}tagCloudName.gif" border=0></td>
		</tr>
		<tr>
                      	<td><div id="tagdiv" style="display:visible;"><form method="POST" action="javascript:void(0);" onsubmit="return tagvalidate();"><input class="textbox"  type="text" id="txtbox_tagfields" name="textbox_First Name" value="" style="width:100px;margin-left:5px;"></input>&nbsp;&nbsp;<input name="button_tagfileds" type="submit" class="crmbutton small save" value="{$APP.LBL_TAG_IT}" /></form></div></td>
                </tr>
		<tr>
			<td class="tagCloudDisplay" valign=top> <span id="tagfields">{$ALL_TAG}</span></td>
		</tr>
		</table>
		
		{/if}
				<br>
			</td>
		</tr>
		</table>
		
			
			
		
		</div>
		
	</td>
-->	
</tr>
<tr>
	<form action="index.php" method="post" name="DetailView" id="form2">
	{include file='DetailViewHidden.tpl'}
	<td align="right" style="border-top:1px dotted #cccccc">		
		{if $EDIT_DUPLICATE eq 'permitted'}
		<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="crmbutton small edit" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.return_id.value='{$ID}';this.form.module.value='{$MODULE}';this.form.action.value='EditView'" type="submit" name="Edit" value="&nbsp;{$APP.LBL_EDIT_BUTTON_LABEL}&nbsp;">&nbsp;
		{/if}
		
		{if $EDIT_DUPLICATE eq 'permitted'}
		<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="crmbutton small create" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.isDuplicate.value='true';this.form.module.value='{$MODULE}'; this.form.action.value='EditView'" type="submit" name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}">&nbsp;
        {/if}
        
        {if $DELETE eq 'permitted'}
		<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="crmbutton small delete" onclick="this.form.return_module.value='{$MODULE}'; {if $VIEWTYPE eq 'calendar'} this.form.return_action.value='index'; {else} this.form.return_action.value='ListView'; {/if}  this.form.action.value='Delete'; return confirm('{$APP.NTC_DELETE_CONFIRMATION}')" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}">&nbsp;
		{/if}
		
		{if $privrecord neq ''}
		<img align="absmiddle" title="{$APP.LNK_LIST_PREVIOUS}" accessKey="{$APP.LNK_LIST_PREVIOUS}" onclick="location.href='index.php?module={$MODULE}&viewtype={$VIEWTYPE}&action=DetailView&record={$privrecord}&parenttab={$CATEGORY}'" name="privrecord" value="{$APP.LNK_LIST_PREVIOUS}" src="{'rec_prev.gif'|@vtiger_imageurl:$THEME}">&nbsp;
		{else}
		<img align="absmiddle" title="{$APP.LNK_LIST_PREVIOUS}" src="{'rec_prev_disabled.gif'|@vtiger_imageurl:$THEME}">
		{/if}
		
		{if $privrecord neq '' || $nextrecord neq ''}
		<img align="absmiddle" title="{$APP.LBL_JUMP_BTN}" accessKey="{$APP.LBL_JUMP_BTN}" onclick="var obj = this;var lhref = getListOfRecords(obj, '{$MODULE}',{$ID},'{$CATEGORY}');" name="jumpBtnIdBottom" id="jumpBtnIdBottom" src="{'rec_jump.gif'|@vtiger_imageurl:$THEME}">
		{/if}
		&nbsp;
		{if $nextrecord neq ''}
		<img align="absmiddle" title="{$APP.LNK_LIST_NEXT}" accessKey="{$APP.LNK_LIST_NEXT}" onclick="location.href='index.php?module={$MODULE}&viewtype={$VIEWTYPE}&action=DetailView&record={$nextrecord}&parenttab={$CATEGORY}'" name="nextrecord" src="{'rec_next.gif'|@vtiger_imageurl:$THEME}">&nbsp;
		{else}
		<img align="absmiddle" title="{$APP.LNK_LIST_NEXT}" src="{'rec_next_disabled.gif'|@vtiger_imageurl:$THEME}">&nbsp;
		{/if}
	</td>
	</form>
</tr>
</table>

{if $MODULE eq 'Products'}
<script language="JavaScript" type="text/javascript" src="modules/Products/Productsslide.js"></script>
<script language="JavaScript" type="text/javascript">Carousel();</script>
{/if}

<script>
function getTagCloud()
{ldelim}
new Ajax.Request(
        'index.php',
        {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
        method: 'post',
        postBody: 'module={$MODULE}&action={$MODULE}Ajax&file=TagCloud&ajxaction=GETTAGCLOUD&recordid={$ID}',
        onComplete: function(response) {ldelim}
                                $("tagfields").innerHTML=response.responseText;
                                $("txtbox_tagfields").value ='';
                        {rdelim}
        {rdelim}
);
{rdelim}
getTagCloud();
</script>
<!-- added for validation -->
<script language="javascript">
  var fieldname = new Array({$VALIDATION_DATA_FIELDNAME});
  var fieldlabel = new Array({$VALIDATION_DATA_FIELDLABEL});
  var fielddatatype = new Array({$VALIDATION_DATA_FIELDDATATYPE});
</script>
</td>

</tr></table>
</td></tr></table>
</td></tr></table>
</td></tr></table>
        </td></tr></table>
        </td></tr></table>
        </div>
        </td>
        <td valign=top><img src="{'showPanelTopRight.gif'|@vtiger_imageurl:$THEME}"></td>
        </tr>
        </table>


