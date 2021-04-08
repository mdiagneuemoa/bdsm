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

<!-- This file is used to display the fields based on the ui type in detailview -->
		{if $keyid eq '1' || $keyid eq 2 || $keyid eq '11' || $keyid eq '7' || $keyid eq '9' || $keyid eq '55' || $keyid eq '71' || $keyid eq '72' || $keyid eq '255'} <!--TextBox-->
			<td width=25% class="dvtCellInfo" align="left">&nbsp;
				{if $keyid eq '55' || $keyid eq '255'}<!--SalutationSymbol-->
					{if $keyaccess eq $APP.LBL_NOT_ACCESSIBLE}
						<font color='red'>{$APP.LBL_NOT_ACCESSIBLE}</font>
					{else}
						{$keysalut}
					{/if}
				{/if}
				
				{if $keyfldname eq 'nom' && ($MODULE eq 'Demandes') }
					<span id="dtlview_{$label}">{$AGENTNOM}</span>
				{elseif $keyfldname eq 'prenom' && ($MODULE eq 'Demandes')}
					<span id="dtlview_{$label}">{$AGENTPRENOM}</span>
				{elseif $keyfldname eq 'service' && ($MODULE eq 'Demandes')}
					<span id="dtlview_{$label}">{$AGENTSERVICE}</span>
				{elseif $keyfldname eq 'matricule' && ($MODULE eq 'Demandes')}
					<span id="dtlview_{$label}">{$AGENTMATRICULE}</span>
				{elseif $keyfldname eq 'datedernmission' && ($MODULE eq 'Demandes')}
					<span id="dtlview_{$label}">{$DATEDERNMISSION}</span>	
				{elseif $keyfldname eq 'intervalmission' && $MODULE eq 'Demandes'}
					<span id="dtlview_{$label}">{$INTERVALMISSION}</span>	
				{elseif $keyfldname eq 'nbjourannee' && $MODULE eq 'Demandes'}
					<span id="dtlview_{$label}">{$NBJOURCONSOMME}</span>
				{elseif $keyfldname eq 'nom' && ($MODULE eq 'OrdresMission') }
					<span id="dtlview_{$label}">{$AGENTNOM}</span>
				{elseif $keyfldname eq 'prenom' && ($MODULE eq 'OrdresMission')}
					<span id="dtlview_{$label}">{$AGENTPRENOM}</span>
				{elseif $keyfldname eq 'service' && ($MODULE eq 'OrdresMission')}
					<span id="dtlview_{$label}">{$AGENTSERVICE}</span>
				{elseif $keyfldname eq 'matricule' && ($MODULE eq 'OrdresMission')}
					<span id="dtlview_{$label}">{$AGENTMATRICULE}</span>
				{elseif $keyfldname eq 'datedernmission' && ($MODULE eq 'OrdresMission')}
					<span id="dtlview_{$label}">{$DATEDERNMISSION}</span>						
				{elseif $keyfldname eq 'lieu' && $MODULE eq 'OrdresMission'}
					<span id="dtlview_{$label}">{$DEMANDELIEU}</span>	
				{elseif $keyfldname eq 'objet' && $MODULE eq 'OrdresMission'}
					<span id="dtlview_{$label}">{$DEMANDEOBJET}</span>	
				{elseif $keyfldname eq 'fonction' && $MODULE eq 'OrdresMission'}
					<span id="dtlview_{$label}">{$AGENTFONCTION}</span>	
				{elseif $keyfldname eq 'datedebut' && $MODULE eq 'OrdresMission'}
					<span id="dtlview_{$label}">{$DEMANDEDATEDEB}</span>	
				{elseif $keyfldname eq 'datefin' && $MODULE eq 'OrdresMission'}
					<span id="dtlview_{$label}">{$DEMANDEDATEFIN}</span>	
				{elseif $keyfldname eq 'commentbillet' && $MODULE eq 'OrdresMission'}
					<span id="dtlview_{$label}">{$DEMANDECOMMENTBILLET}</span>	
					{elseif $keyfldname eq 'nomcomplet' && $MODULE eq 'OrdresMission'}
					<span id="dtlview_{$label}">{$AGENTNOM}</span>	
					{else}
						&nbsp;&nbsp;<span id="dtlview_{$label}">{$keyval}</span>
				
				{/if}
				
			
				
                {if $keyid eq '71' && $keyfldname eq 'unit_price'}	
                	{if $PRICE_DETAILS|@count > 0}				
						<span id="multiple_currencies" width="38%" style="align:right;">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="toggleShowHide('currency_class','multiple_currencies');">{$APP.LBL_MORE_CURRENCIES} &raquo;</a>
						</span>
						
						<div id="currency_class" class="multiCurrencyDetailUI">					
							<table width="100%" height="100%" class="small" cellpadding="5">
							<tr class="detailedViewHeader">							
								<th colspan="2">
									<b>{$MOD.LBL_PRODUCT_PRICES}</b>
								</th>
								<th align="right">
									<img border="0" style="cursor: pointer;" onclick="toggleShowHide('multiple_currencies','currency_class');" src="{'close.gif'|@vtiger_imageurl:$THEME}"/>
								</th>
							</tr>							
							<tr class="detailedViewHeader">
								<th>{$APP.LBL_CURRENCY}</th>
								<th colspan="2">{$APP.LBL_PRICE}</th>
							</tr>
							{foreach item=price key=count from=$PRICE_DETAILS}
								<tr>
									{*if $price.check_value eq 1*}
									<td class="dvtCellLabel" width="40%">
										{$price.currencylabel} ({$price.currencysymbol})
									</td>
									<td class="dvtCellInfo" width="60%" colspan="2">
										{$price.curvalue}
									</td>
								</tr>
							{/foreach}
							</table>
						</div>
					{/if}
                {/if}
			</td>
		{elseif $keyid eq '13'} <!--Email-->
			<td width=25% class="dvtCellInfo" align="left">
				{if $smarty.session.internal_mailer eq 1}
					<a href="javascript:InternalMailer({$ID},{$keyfldid},'{$keyfldname}','{$MODULE}','record_id');">{$keyval}</a>
				{else}
					<a href="mailto:{$keyval}" target="_blank" >{$keyval}</a>
				{/if}
				</span>
			</td>
		{elseif $keyid eq '15' || $keyid eq '16'} <!--ComboBox-->
			<td width=25% class="dvtCellInfo" align="left">&nbsp;
				{foreach item=arr from=$keyoptions}
					{if $arr[0] eq $APP.LBL_NOT_ACCESSIBLE}
						{assign var=keyval value=$APP.LBL_NOT_ACCESSIBLE}
						{assign var=fontval value='red'}
					{else}
						{assign var=fontval value=''}
					{/if}
				{/foreach}
				<font color="{$fontval}">{$keyval}</font>
			</td>
		{elseif $keyid eq '33'}
			<td width=25% class="dvtCellInfo" align="left">&nbsp;
				{foreach item=sel_val from=$keyoptions }
					{if $sel_val[2] eq 'selected'}
						{if $selected_val neq ''}
							{assign var=selected_val value=$selected_val|cat:', '}
					 	{/if}
						{assign var=selected_val value=$selected_val|cat:$sel_val[0]}
					{/if}
				{/foreach}
				{$selected_val|replace:"\n":"<br>&nbsp;&nbsp;"}
			</td>
		{elseif $keyid eq '17'} <!--WebSite-->
			<td width=25% class="dvtCellInfo" align="left">&nbsp;<a href="http://{$keyval}" target="_blank">{$keyval}</a>
			</td>
		{elseif $keyid eq '85'}<!--Skype-->
			<td width=25% class="dvtCellInfo" align="left" id="mouseArea_{$label}">
				&nbsp;<img src="{'skype.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_SKYPE}" title="{$APP.LBL_SKYPE}" LANGUAGE=javascript align="absmiddle"></img>
				<span id="dtlview_{$label}"><a href="skype:{$keyval}?call">{$keyval}</a></span>
			</td>	
		{elseif $keyid eq '19' || $keyid eq '20'} <!--TextArea/Description-->
			{if $label eq $MOD.LBL_ADD_COMMENT}
				{assign var=keyval value=''}
			{/if}
			<td width=100% class="dvtCellInfo" align="left">&nbsp;
				<!--To give hyperlink to URL-->
				{$keyval|regex_replace:"/(^|[\n ])([\w]+?:\/\/.*?[^ \"\n\r\t<]*)/":"\\1<a href=\"\\2\" target=\"_blank\">\\2</a>"|regex_replace:"/(^|[\n ])((www|ftp)\.[\w\-]+\.[\w\-.\~]+(?:\/[^ \"\t\n\r<]*)?)/":"\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>"|regex_replace:"/(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)/i":"\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>"|regex_replace:"/,\"|\.\"|\)\"|\)\.\"|\.\)\"/":"\""|replace:"\n":"<br>&nbsp;"}                   
			</td>
		{elseif $keyid eq '21' || $keyid eq '24' || $keyid eq '22'} <!--TextArea/Street-->
			<td width=25% class="dvtCellInfo" align="left">&nbsp;<span id ="dtlview_{$label}">{$keyval}</span>
			</td>
		{elseif $keyid eq '50' || $keyid eq '73' || $keyid eq '51' || $keyid eq '57' || $keyid eq '59' || $keyid eq '75' || $keyid eq '81' || $keyid eq '76' || $keyid eq '78' || $keyid eq '80'} <!--AccountPopup-->
			<td width=25% class="dvtCellInfo" align="left">&nbsp;<a href="{$keyseclink}">{$keyval}</a>
			</td>
		{elseif $keyid eq 82} <!--Email Body-->
			<td colspan="3" width=100% class="dvtCellInfo" align="left">&nbsp;{$keyval}
			</td>
		{elseif $keyid eq '53'} <!--Assigned To-->
		
            <td width=25% class="dvtCellInfo" align="left">&nbsp;
	            {if $keyseclink eq ''}
	                {$keyval}
	            {else}
	               	<a href="{$keyseclink}">{$keyval}</a>         
	            {/if}
				&nbsp;            
            </td>
		{*	
		 {elseif $keyid eq '61'} <!--File -->
			  <td width=25% class="dvtCellInfo" align="left">
					<table><tr>
								<td>{$keyval}</td>
								<td><a href="javascript:;" onClick="deletefile()"><img src="{'remove.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_DELETE_FILE_IMG}" >supprimer</a></td>
							</tr>
					</table>
			</td>	
		*}
		{elseif $keyid eq '56'} <!--CheckBox--> 
			<td width=25% class="dvtCellInfo" align="left">{$keyval}&nbsp;
			</td>     
		{elseif $keyid eq 83}<!-- Handle the Tax in Inventory -->
				<td align="right" class="dvtCellLabel">
					{$APP.LBL_VAT} {$APP.COVERED_PERCENTAGE}							
				</td>
				<td class="dvtCellInfo" align="left">&nbsp;
					{$VAT_TAX}
				</td>
				<td colspan="2" class="dvtCellInfo">&nbsp;</td>
			</tr>
			<tr>
				<td align="right" class="dvtCellLabel">
					{$APP.LBL_SALES} {$APP.LBL_TAX} {$APP.COVERED_PERCENTAGE}
				</td> 
				<td class="dvtCellInfo" align="left">&nbsp;
					{$SALES_TAX}
				</td>	
				<td colspan="2" class="dvtCellInfo">&nbsp;</td>
			</tr>
			<tr>
				<td align="right" class="dvtCellLabel">
					{$APP.LBL_SERVICE} {$APP.LBL_TAX} {$APP.COVERED_PERCENTAGE}
				</td>
				<td class="dvtCellInfo" align="left" >&nbsp;
					{$SERVICE_TAX}
				</td>	

		{elseif $keyid eq 69}<!-- for Image Reflection -->
			<td align="left" width=25%">&nbsp;{$keyval}</td>
		{else}									
			<td class="dvtCellInfo" align="left" width=25%">&nbsp;{$keyval}</td>
		{/if}
