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
{if $smarty.request.ajax neq ''}
&#&#&#{$ERROR}&#&#&# 
{/if}
{*$LIST_QUERY*}

<form name="massdelete" method="POST" id="massdelete">
     <input name='search_url' id="search_url" type='hidden' value='{$SEARCH_URL}'>
     <input name="idlist" id="idlist" type="hidden">
     <input name="change_owner" type="hidden">
     <input name="change_status" type="hidden">
     <input name="action" type="hidden">
     <input name="where_export" type="hidden" value="{php} echo to_html($_SESSION['export_where']);{/php}">
     <input name="step" type="hidden">
     <input name="allids" type="hidden" id="allids" value="{$ALLIDS}">
     <input name="selectedboxes" id="selectedboxes" type="hidden" value="{$SELECTEDIDS}">
     <input name="allselectedboxes" id="allselectedboxes" type="hidden" value="{$ALLSELECTEDIDS}">
     <input name="current_page_boxes" id="current_page_boxes" type="hidden" value="{$CURRENT_PAGE_BOXES}">
				<!-- List View Master Holder starts -->
				<table border=0 cellspacing=1 cellpadding=0 width=100% class="lvtBg">
				<tr>
				<td>
				<!-- List View's Buttons and Filters starts -->
		        <table border=0 cellspacing=0 cellpadding=2 width=100% >
			    <tr>
				<!-- Buttons -->
				<!--
				<td style="padding-right:20px" nowrap>

                 {foreach key=button_check item=button_label from=$BUTTONS}
                    {if $button_check eq 'del'}
                         <input class="crmbutton small delete" type="button" value="{$button_label}" onclick="return massDelete('{$MODULE}')"/>
                    {elseif $button_check eq 'mass_edit'}
                         <input class="crmbutton small edit" type="button" value="{$button_label}" onclick="return mass_edit(this, 'massedit', '{$MODULE}')"/>
                    {elseif $button_check eq 's_mail'}
                         <input class="crmbutton small edit" type="button" value="{$button_label}" onclick="return eMail('{$MODULE}',this);"/>
					{elseif $button_check eq 's_cmail'}
                         <input class="crmbutton small edit" type="submit" value="{$button_label}" onclick="return massMail('{$MODULE}')"/>
                    {elseif $button_check eq 'mailer_exp'}
                         <input class="crmbutton small edit" type="submit" value="{$button_label}" onclick="return mailer_export()"/>
					{/if}
                {/foreach}
                </td>
				-->
				<!-- Record Counts -->
			{if $MODULE neq 'Satellite' }
				<td style="padding-right:20px"  nowrap>{$RECORD_COUNTS}</td>
			{/if}	
				<!-- Page Navigation -->
			 {if $MODULE neq 'Satellite' }
		        	<td nowrap align="center" width=50%>
					<table border=0 cellspacing=0 cellpadding=0 >
					     <tr>{$NAVIGATION}</tr>
					</table>
                		</td>
                	{/if}
                {if $MODULE eq 'Satellite' }
	                <td nowrap>
	                	<input type="hidden" name="recordmp3" id="recordmp3">
                		<div id="player">
							
						</div> 
	                </td>
	             {/if}
				 
				   <!-- Filters -->
				   
				   {if $HIDE_CUSTOM_LINKS neq '1'}
					
						{if $CATEGORY eq 'Analytics' && $NB_RECORDS neq 0}
						<td width=100% align="right">
							<table border=0 cellspacing=0 cellpadding=0 >
								<tr>						
									<td align=left>
										<input name="submit" type="button" class="crmbutton small create" onClick="ExportExcell();" value="Export XSL">&nbsp;
									</td>
								</tr>
							</table> 
						</td>	
						{elseif $CATEGORY eq 'Reporting' && $NB_RECORDS neq 0}
						<td width=100% align="right">
							<table border=0 cellspacing=0 cellpadding=0 >
								<tr>						
									<td align=left>
										<input name="submit" type="button" class="crmbutton small create" onClick="ExportExcell();" value="Export XSL">&nbsp;
									</td>
								</tr>
							</table> 
						</td>	
						{/if}
					{/if}
       		    </tr>
			<tr>

					{if $MODULE eq 'Satellite' }
						<td nowrap>
							<p> <b>{$RECORDS_PERIODE} </b> </p>
						</td>
						<td style="padding-right:20px"  nowrap><p> &nbsp;&nbsp;&nbsp;&nbsp; {$RECORD_COUNTS} </p></td>
					{/if}	
			</tr>	
					
			</table>
			<!-- List View's Buttons and Filters ends -->
			
			<!-- Table Headers -->
			<!--<div style="width:100%;overflow:auto;">
			<table border="1" style="width:100%;overflow:hidden;">-->
		
			
			<div class="wrap">
				<div class="inner">
			<table border=0 cellspacing=1 cellpadding=3 width=100% class="lvt small">
			
			<tr>
	          
				{foreach name="listviewforeach" item=header from=$LISTHEADER}
				{if $header eq "Action" && ($MODULE eq "ReportingConventions" || $MODULE eq "SBConventions")}
				{else}
 					<td class="lvtCol" align=center>{$header}</td>
 				{/if}
				{/foreach}
			</tr>
			
			
			{foreach item=entityg key=cle from=$LISTENTITYGLOBAL}
			{if $cle neq 'SEUIL'}
				<tr>
					{if $cle eq 'CUMUL' && $MODULE neq 'Agent'}
						<td  align="left" colspan="4"><b>SEUIL <span style="color:green;">OK</span> : {$LISTENTITYGLOBAL.SEUIL.seuilOK} / {$LISTENTITYGLOBAL.SEUIL.nbccx} <span style="color:green;">({$LISTENTITYGLOBAL.SEUIL.pseuilOK}%)</span>
						- SEUIL <span style="color:red;">K0</span> : {$LISTENTITYGLOBAL.SEUIL.seuilKO} / {$LISTENTITYGLOBAL.SEUIL.nbccx} <span style="color:red;">({$LISTENTITYGLOBAL.SEUIL.pseuilKO}%)</span></b></td>
						<td align="right" colspan="1"><b>{$cle}</b></td>
					{elseif $cle eq 'MOYENNE' || $MODULE eq 'Agent'}	
						<td align="right" colspan="5"><b>{$cle}</b></td>
					{/if}
					
			
					{foreach item=data from=$entityg name=cols}			
						<td>{$data}</td>

					{/foreach}
				</tr>
			{/if}
			{/foreach}
			<!--</table>-->
			<!-- Table Contents -->
			
		
			
			 {if ($MODULE eq 'RoutingPoint' || $MODULE eq 'Campagne') && $NB_RECORDS neq 0}
				{assign var=totalCallsEntered value=0}
				{assign var=totalCallsDistributed value=0}
				{assign var=totalCallsAnswered value=0}
				{assign var=totalCallsAbandoned value=0}
				{assign var=totalCallsShotAnswered value=0}
				{assign var=totalCallsShotAbandoned value=0}
			{/if}
			
			 {if $MODULE eq 'ReportingConventions' && $NB_RECORDS neq 0}
				{assign var=totalMontant value=0}
		{/if}	
			
			{foreach item=entity key=entity_id from=$LISTENTITY}
			<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
			
			{foreach item=data from=$entity name=cols}	
			
			{if ($MODULE eq 'RoutingPoint' || $MODULE eq 'Campagne') && $smarty.foreach.cols.index == 2}
				{assign var=totalCallsEntered value=$totalCallsEntered+$data}		
			{/if}
			{if ($MODULE eq 'RoutingPoint' || $MODULE eq 'Campagne') && $smarty.foreach.cols.index == 3}
				{assign var=totalCallsDistributed value=$totalCallsDistributed+$data}			
			{/if}
			{if ($MODULE eq 'RoutingPoint' || $MODULE eq 'Campagne') && $smarty.foreach.cols.index == 4}
				{assign var=totalCallsAnswered value=$totalCallsAnswered+$data}			
			{/if}
			{if ($MODULE eq 'RoutingPoint' || $MODULE eq 'Campagne') && $smarty.foreach.cols.index == 5}
				{assign var=totalCallsAbandoned value=$totalCallsAbandoned+$data}		
			{/if}
			{if ($MODULE eq 'RoutingPoint' || $MODULE eq 'Campagne') && $smarty.foreach.cols.index == 6}
				{assign var=totalCallsShotAnswered value=$totalCallsShotAnswered+$data}		
			{/if}
			{if ($MODULE eq 'RoutingPoint' || $MODULE eq 'Campagne') && $smarty.foreach.cols.index == 7}
				{assign var=totalCallsShotAbandoned value=$totalCallsShotAbandoned+$data}			
			{/if}
			{if $MODULE eq 'ReportingConventions' && $smarty.foreach.cols.index == 2}
				{assign var=totalMontant value=$totalMontant+$data}			
			{/if}
			

			{if $MODULE eq 'ReportingConventions' && $smarty.foreach.cols.index == 2}
				<td nowrap align="right">
				{php} 
					$mnt = $this->get_template_vars('data'); 
					$mnt2 = number_format($mnt, 0, ',', ' ');
					echo $mnt2;
				{/php}
			{elseif $MODULE eq 'SBConventions' && ($smarty.foreach.cols.index == 3 || $smarty.foreach.cols.index == 4 || $smarty.foreach.cols.index == 5
						|| $smarty.foreach.cols.index == 6 || $smarty.foreach.cols.index == 7 || $smarty.foreach.cols.index == 8 || $smarty.foreach.cols.index == 9
						|| $smarty.foreach.cols.index == 10)}
				<td nowrap align="right">
					{php} 
					$mnt = $this->get_template_vars('data'); 
					$mnt2 = number_format($mnt, 0, ',', ' ');
					echo $mnt2;
				{/php}			
			{else}
			<td nowrap>
				{$data}
			{/if}
			</td>
	        {/foreach}
			</tr>
			{foreachelse}
			<tr><td style="background-color:#efefef;height:340px" align="center" colspan="{$smarty.foreach.listviewforeach.iteration+1}">
			<div style="border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 50%; position: relative; z-index: 10000000;">
				{assign var=vowel_conf value='LBL_A'}
				{if $MODULE eq 'Accounts' || $MODULE eq 'Invoice'}
				{assign var=vowel_conf value='LBL_AN'}
				{/if}
				{assign var=MODULE_CREATE value=$SINGLE_MOD}
				{if $MODULE eq 'HelpDesk'}
				{assign var=MODULE_CREATE value='Ticket'}
				{/if}
				
				{if $CHECK.EditView eq 'yes' && $MODULE neq 'Emails' && $MODULE neq 'Webmails'}
							
				<table border="0" cellpadding="5" cellspacing="0" width="98%">
				<tr>
					<td rowspan="2" width="25%"><img src="{'empty.jpg'|@vtiger_imageurl:$THEME}" height="60" width="60"></td>
					<td style="border-bottom: 1px solid rgb(204, 204, 204);" nowrap="nowrap" width="75%"><span class="genHeaderSmall">
					{if $MODULE_CREATE eq 'SalesOrder' || $MODULE_CREATE eq 'PurchaseOrder' || $MODULE_CREATE eq 'Invoice' || $MODULE_CREATE eq 'Quotes'}
						{$APP.LBL_NO} {$APP.$MODULE_CREATE} {$APP.LBL_FOUND} !
					{elseif $MODULE eq 'Calendar'}
						{$APP.LBL_NO} {$APP.ACTIVITIES} {$APP.LBL_FOUND} !
					{else}
						{* vtlib customization: Use translation string only if available *}
						{*
						{$APP.LBL_NO} {if $APP.$MODULE_CREATE}{$APP.$MODULE_CREATE}s{else}{$MODULE_CREATE}{/if} {$APP.LBL_FOUND} !
						*}
						
						{$APP.NO_DATA_AVAILABLE_WITH_SPECIFIED_PERIOD} !

					{/if}
					</span></td>
				</tr>
				
				</table> 
			{else}
				<table border="0" cellpadding="5" cellspacing="0" width="98%">
				<tr>
				<td rowspan="2" width="25%"><img src="{'denied.gif'|@vtiger_imageurl:$THEME}"></td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204);" nowrap="nowrap" width="75%"><span class="genHeaderSmall">
				{if $MODULE_CREATE eq 'SalesOrder' || $MODULE_CREATE eq 'PurchaseOrder' || $MODULE_CREATE eq 'Invoice' || $MODULE_CREATE eq 'Quotes'}
					{$APP.LBL_NO} {$APP.$MODULE_CREATE} {$APP.LBL_FOUND} !</span></td>
				{else}
					{* vtlib customization: Use translation string only if available *}
					{$APP.LBL_NO} {if $APP.$MODULE_CREATE}{$APP.$MODULE_CREATE}s{else}{$MODULE_CREATE}{/if} {$APP.LBL_FOUND} !</span></td>
				{/if}
				</tr>
				<tr>
				<td  align="left" nowrap="nowrap">{$APP.LBL_YOU_ARE_NOT_ALLOWED_TO_CREATE} {$APP.$vowel_conf}
				{if $MODULE_CREATE eq 'SalesOrder' || $MODULE_CREATE eq 'PurchaseOrder' || $MODULE_CREATE eq 'Invoice' || $MODULE_CREATE eq 'Quotes'}
					 {$MOD.$MODULE_CREATE}
				{else}
					 {* vtlib customization: Use translation string only if available *}
					 {if $APP.$MODULE_CREATE}{$APP.$MODULE_CREATE}{else}{$MODULE_CREATE}{/if}
				{/if}
				<br>
				</td>
				</tr>
				</table>
				{/if}
				</div>					
				</td></tr>	
			     {/foreach}

				 {if ($MODULE eq 'RoutingPoint' || $MODULE eq 'Campagne') && $NB_RECORDS neq 0}
					<tr bgcolor=white class=lvtColDataHover  id="row_{$entity_id}">
						<td colspan="2" align="right"><b>Total</b></td>
						<td><b>{$totalCallsEntered}</td>
						<td><b>{$totalCallsDistributed}</td>
						<td><b>{$totalCallsAnswered}</td>
						<td><b>{$totalCallsAbandoned}</td>
						<td><b>{$totalCallsShotAnswered}</td>
						<td><b>{$totalCallsShotAbandoned}</td>
						<td colspan=20><b>&nbsp;</td>
						
					</tr>
				{/if}	
				
				{if ($MODULE eq 'ReportingConventions') && $NB_RECORDS neq 0}
					<tr bgcolor=white class=lvtColDataHover  id="row_{$entity_id}">
						<td colspan="2" align="right"><b>Total</b></td>
						<td nowrap><b>{php} 
									$mnt = $this->get_template_vars('totalMontant'); 
									$mnt2 = number_format($mnt, 0, ',', ' ');
									echo $mnt2;
								{/php}</td>
						<td colspan=20><b>&nbsp;</td>
						
					</tr>
				{/if}
			  </tbody>
		 </table>
		 <!--/div-->
			 
			 <table border=0 cellspacing=0 cellpadding=2 width=100%>
			      <tr>
				  <!--
				 <td style="padding-right:20px" nowrap>
                                 {foreach key=button_check item=button_label from=$BUTTONS}
                                        {if $button_check eq 'del'}
                                            <input class="crmbutton small delete" type="button" value="{$button_label}" onclick="return massDelete('{$MODULE}')"/>
					                    {elseif $button_check eq 'mass_edit'}
					                         <input class="crmbutton small edit" type="button" value="{$button_label}" onclick="return mass_edit(this, 'massedit', '{$MODULE}')"/>
                                        {elseif $button_check eq 's_mail'}
                                             <input class="crmbutton small edit" type="button" value="{$button_label}" onclick="return eMail('{$MODULE}',this)"/>
                                        {elseif $button_check eq 's_cmail'}
                                             <input class="crmbutton small edit" type="submit" value="{$button_label}" onclick="return massMail('{$MODULE}')"/>
                                        {elseif $button_check eq 'mailer_exp'}
                                             <input class="crmbutton small edit" type="submit" value="{$button_label}" onclick="return mailer_export()"/>
										{/if}

                                 {/foreach}
                    </td>
					-->
				 <td style="padding-right:20px"  nowrap width=40%>{$RECORD_COUNTS}</td>
				 <td nowrap align="left" width=60%>
				    <table border=0 cellspacing=0 cellpadding=0 >
				         <tr>{$NAVIGATION}</tr>
				     </table>
				 </td>
				 <!--
				 <td align="right" width=100%>
				   <table border=0 cellspacing=0 cellpadding=0 >
					<tr>
                                           {$WORDTEMPLATEOPTIONS}{$MERGEBUTTON}
					</tr>
				   </table>
				 </td>
				 -->
			      </tr>
       		    </table>
		       </td>
		   </tr>
	    </table>

   </form>	
{$SELECT_SCRIPT}
<div id="basicsearchcolumns" style="display:none;"><select name="search_field" id="bas_searchfield" class="txtBox" style="width:150px">{html_options  options=$SEARCHLISTHEADER}</select></div>
