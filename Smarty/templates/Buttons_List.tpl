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
	{if $RIGHT_LABEL eq 'TraitementConventions'}
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap>{$APP.$CATEGORY} > <a class="hdrLink" href="index.php?action=index&module=TraitementConventions&parenttab={$CATEGORY}">{$APP.TraitementConventions}</a></td>
	{elseif $RIGHT_LABEL eq 'SuiviConventions'}
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap>{$APP.$CATEGORY} > <a class="hdrLink" href="index.php?action=index&module=SuiviConventions&parenttab={$CATEGORY}">{$APP.SuiviConventions}</a></td>
	{elseif $RIGHT_LABEL eq 'ExecutionConventions'}
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap>{$APP.$CATEGORY} > <a class="hdrLink" href="index.php?action=index&module=ExecutionConventions&parenttab={$CATEGORY}">{$APP.ExecutionConventions}</a></td>
	{elseif  $CURRENT_USER_PROFIL_ID eq 24 || $CURRENT_USER_PROFIL_ID eq 23}
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap>{$MODULELABEL}</td>
	{else}
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap>{$APP.$CATEGORY} > <a class="hdrLink" href="index.php?action={$action}&module={$MODULE}&parenttab={$CATEGORY}">{$MODULELABEL}</a></td>
	{/if}
	<td width=100% nowrap>
	
		<table border="0" cellspacing="3" cellpadding="3" width=90%>
			<tr>
				<td  align="left"><a href="index.php?module={$MODULE}&action=EditView&return_action=DetailView&parenttab={$CATEGORY}"><input type="button" value="Saisie de donn&eacute;es"></a> &nbsp; <a href="index.php?module={$MODULE}&action=ListView&return_action=DetailView&parenttab={$CATEGORY}"><input type="button" value="Consultation de donn&eacute;es"></a></td>				
				<td  align="right" ><a href="http://localhost/bdsm/index.php" target="_blank"><input type="button" value="Consulter les donn&eacute;es publi&eacute;es"></a></td>				
			</tr>
		</table>
	</td>
</tr>
<tr><td style="height:2px"></td></tr>
</TABLE>
