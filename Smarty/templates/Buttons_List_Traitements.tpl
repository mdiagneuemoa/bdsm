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
<script type="text/javascript" src="modules/{$MODULE}/{$MODULE}.js"></script>

<TABLE border=0 cellspacing=0 cellpadding=0 width=100% class=small>
<tr><td style="height:2px"></td></tr>
<tr>
	{assign var="MODULELABEL" value=$MODULE}
	{if $APP[$MODULE]}
		{assign var="MODULELABEL" value=$APP[$MODULE]}
	{/if}
	{if $CATEGORY eq 'Settings'}
	<!-- No List View in Settings - Action is index -->
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap><a class="hdrLink" href="index.php?action=index&module={$MODULE}&parenttab={$CATEGORY}">{$MODULELABEL}</a></td>
	{else}
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap>{$APP.$CATEGORY} > <a class="hdrLink" href="index.php?action=index&module={$MODULE}&parenttab={$CATEGORY}">{$MODULELABEL}</a></td>
	{/if}
	<td width=100% nowrap>
	
		<table border="0" cellspacing="0" cellpadding="0" >
		<tr>
		<td class="sep1" style="width:1px;"></td>
		<td class=small >
			<!-- Add and Search -->
			<table border=0 cellspacing=0 cellpadding=0>
			<tr>
			<td>
				<table border=0 cellspacing=0 cellpadding=5>
				<tr>
						<td style="padding-right:0px;padding-left:10px;"><img src="{'btnL3Add-Faded.gif'|@vtiger_imageurl:$THEME}" border=0></td>	
									
						<td style="padding-right:10px"><img src="{'btnL3Search-Faded.gif'|@vtiger_imageurl:$THEME}" border=0></td>
					
				</tr>
				</table>
			</td>
			</tr>
			</table>
		</td>
		
		<td style="width:20px;">&nbsp;</td>
		<td class="small">
				<!-- All Menu -->
				<table border=0 cellspacing=0 cellpadding=5>
				<tr>
					<td style="padding-left:10px;"><a href="javascript:;" onmouseout="fninvsh('allMenu');" onClick="fnvshobj(this,'allMenu')"><img src="{$IMAGE_PATH}btnL3AllMenu.gif" alt="{$APP.LBL_ALL_MENU_ALT}" title="{$APP.LBL_ALL_MENU_TITLE}" border="0"></a></td>
				</tr>
				</table>
		</td>			
		</tr>
		</table>
	</td>
</tr>
</TABLE>
