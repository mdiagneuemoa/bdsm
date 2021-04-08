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

			<div align=center>
			<table border=0 cellspacing=1 cellpadding=3 width=99% class="lvt small">
			<th colspan=6><h2> Liste du personnel en mission au {$DATEJOUR}</h2></th>
			<!-- Table Headers -->
			<tr>
           				
 					<td class="lvtCol" align=center nowrap>{$MOD.Numeroom}</td>
 					<td class="lvtCol" align=center nowrap>{$MOD.Nomcomplet}</td>
 					<td class="lvtCol" align=center nowrap>{$MOD.Objet}</td>
 					<td class="lvtCol" align=center nowrap>{$MOD.Lieu}</td>
 					<td class="lvtCol" align=center nowrap>{$MOD.Datedepart}</td>
 					<td class="lvtCol" align=center nowrap>{$MOD.Datearrivee}</td>
 		
			</tr>
			<!-- Table Contents -->
			{foreach item=missiondeparts key=depart from=$LISTENTITY}
				<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'">
					<td colspan=6 class="lvtCol">
						{$missiondeparts.libdepart}
					</td>
				</tr>
				{foreach item=entity key=entity_id from=$missiondeparts.missions}
					<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
						
						{foreach item=data name=cols from=$entity}
							{if $smarty.foreach.cols.index == 2}
								<td width=40%>
									{$data}
								</td>
							{else}
								<td nowrap>
									{$data}
								</td>
							{/if}
						{/foreach}
					</tr>
				{/foreach}
			{foreachelse}
			<tr><td style="background-color:#efefef;height:340px" align="center" colspan="{$smarty.foreach.listviewforeach.iteration+1}">
			<div style="border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 45%; position: relative; z-index: 10000000;">
											
				<table border="0" cellpadding="5" cellspacing="0" width="98%">
				<tr>
					<td rowspan="2" width="25%"><img src="{'empty.jpg'|@vtiger_imageurl:$THEME}" height="60" width="61"></td>
					<td style="border-bottom: 1px solid rgb(204, 204, 204);" nowrap="nowrap" width="75%">
					<span class="genHeaderSmall">Aucune Mission en cours !!!</span></td>
				</tr>
				
				</table> 
			
		       </td>
		   </tr>
	    </table>
 {/foreach}
{$SELECT_SCRIPT}
<div id="basicsearchcolumns" style="display:none;"><select name="search_field" id="bas_searchfield" class="txtBox" style="width:150px">{html_options  options=$SEARCHLISTHEADER}</select></div>
