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
	{assign var="action" value="ListView"}
	{assign var="MODULELABEL" value=$MODULE}
	{if $APP[$MODULE]}
		{assign var="MODULELABEL" value=$APP[$MODULE]}
	{/if}	
	{if $CURRENT_USER_PROFIL_ID eq '50'}
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap>{$APP.$CATEGORY} >{$MODULELABEL}</td>
	{else}
			<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap>{$APP.$CATEGORY} > <a class="hdrLink" href="index.php?action={$action}&module={$MODULE}&parenttab={$CATEGORY}">{$MODULELABEL}</a></td>

	{/if}	
	<td width=100% nowrap>
	
		<table border="0" cellspacing="0" cellpadding="0" >
		<tr>
		<td class="sep1" style="width:1px;"></td>
		<td class=small >
			<!-- Add and Search -->
			{if $CURRENT_USER_PROFIL_ID neq '50'}
			<table border=0 cellspacing=0 cellpadding=0>
			<tr>
			<td>
				<table border=0 cellspacing=0 cellpadding=5>
				<tr>
					{if $CHECK.EditView eq 'yes'}
			        	
						<td style="padding-right:0px;padding-left:10px;"><img src="{'btnL3Add-Faded.gif'|@vtiger_imageurl:$THEME}" border=0></td>	
					{/if}

							 <td style="padding-right:10px"><a href="javascript:;" onClick="moveMe('searchAcc');searchshowhide('searchAcc','advSearch');mergehide('mergeDup')" ><img src="{$IMAGE_PATH}btnL3Search.gif" alt="{$APP.LBL_SEARCH_ALT}{$APP.$MODULE}..." title="{$APP.LBL_SEARCH_TITLE}{$APP.$MODULE}..." border=0></a></a></td>
								<td style="padding-right:10px"><a href="javascript:;" onClick="moveMe('filterAcc');searchshowhide('filterAcc','advSearch');mergehide('mergeDup')" ><img src="{$IMAGE_PATH}btnFilter.jpg" alt="{$APP.LBL_FILTER_ALT}{$APP.$MODULE}..." title="{$APP.LBL_FILTER_TITLE}{$APP.$MODULE}..." border=0></a></a></td>
								
						
					
				</tr>
				</table>
			</td>
			</tr>
			</table>
			{/if}
		</td>
			
		
		<td style="width:20px;">&nbsp;</td>
		
		</tr>
		</table>
	</td>
</tr>
<tr><td style="height:2px"></td></tr>
</TABLE>
