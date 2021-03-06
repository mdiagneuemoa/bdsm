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
		{assign var="uitype" value="$maindata[0][0]"}
		{assign var="fldlabel" value="$maindata[1][0]"}
		{assign var="fldlabel_sel" value="$maindata[1][1]"}
		{assign var="fldlabel_combo" value="$maindata[1][2]"}
		{assign var="fldlabel_other" value="$maindata[1][3]"}
		{assign var="fldname" value="$maindata[2][0]"}
		{assign var="fldvalue" value="$maindata[3][0]"}
		{assign var="secondvalue" value="$maindata[3][1]"}
		{assign var="thirdvalue" value="$maindata[3][2]"}
		{assign var="typeofdata" value="$maindata[4]"} 
	 	{assign var="vt_tab" value="$maindata[5][0]"}
{*$fldname}={$fldvalue*}
		{if $typeofdata eq 'M'}
			{assign var="mandatory_field" value="*"}
		{else}
			{assign var="mandatory_field" value=""}
		{/if}

		{* vtlib customization: Help information for the fields *}
		{assign var="usefldlabel" value=$fldlabel}
		{assign var="fldhelplink" value=""}
		{if $FIELDHELPINFO && $FIELDHELPINFO.$fldname}
			{assign var="fldhelplinkimg" value='help_icon.gif'|@vtiger_imageurl:$THEME}
			{assign var="fldhelplink" value="<img style='cursor:pointer' onclick='vtlib_field_help_show(this, \"$fldname\");' border=0 src='$fldhelplinkimg'>"}
			{if $uitype neq '10'}
				{assign var="usefldlabel" value="$fldlabel $fldhelplink"}
			{/if}
		{/if}
		{* END *}

		{* vtlib customization *}
		{if $uitype eq '10'}
			<td width=20% class="dvtCellLabel" align=right>
			{$fldlabel.displaylabel} 

			{if count($fldlabel.options) eq 1}
				{assign var="use_parentmodule" value=$fldlabel.options.0}
				<input type='hidden' class='small' name="{$fldname}_type" value="{$use_parentmodule}">{$APP.$use_parentmodule}
			{else}
			<br>
			{if $fromlink eq 'qcreate'}
			<select id="{$fldname}_type" class="small" name="{$fldname}_type" onChange='document.QcEditView.{$fldname}_display.value=""; document.QcEditView.{$fldname}.value="";'>
			{else}
			<select id="{$fldname}_type" class="small" name="{$fldname}_type" onChange='document.EditView.{$fldname}_display.value=""; document.EditView.{$fldname}.value="";$("qcform").innerHTML=""'>
			{/if}
			{foreach item=option from=$fldlabel.options}
				<option value="{$option}" 
				{if $fldlabel.selected == $option}selected{/if}>
				{if $APP.$option neq ''}{$APP.$option}{else}{$option}{/if}
				</option> 
			{/foreach}
			</select>
			{/if}
			{if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			{$fldhelplink}

			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input id="{$fldname}" name="{$fldname}" type="hidden" value="{$fldvalue.entityid}" id="{$fldname}">
				<input id="{$fldname}_display" name="{$fldname}_display" id="edit_{$fldname}_display" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue.displayvalue}">&nbsp;
				{if $fromlink eq 'qcreate'}
				<img src="{'select.gif'|@vtiger_imageurl:$THEME}" tabindex="{$vt_tab}" 
alt="Select" title="Select" LANGUAGE=javascript  onclick='return window.open("index.php?module="+ document.QcEditView.{$fldname}_type.value +"&action=Popup&html=Popup_picker&form=vtlibPopupView&forfield={$fldname}&srcmodule={$MODULE}&forrecord={$ID}","test","width=640,height=602,resizable=0,scrollbars=0,top=150,left=200");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;
				{else}
				<img src="{'select.gif'|@vtiger_imageurl:$THEME}" tabindex="{$vt_tab}" 
alt="Select" title="Select" LANGUAGE=javascript  onclick='return window.open("index.php?module="+ document.EditView.{$fldname}_type.value +"&action=Popup&html=Popup_picker&form=vtlibPopupView&forfield={$fldname}&srcmodule={$MODULE}&forrecord={$ID}","test","width=640,height=602,resizable=0,scrollbars=0,top=150,left=200");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;
				{/if}
				<input type="image" src="{'clear_field.gif'|@vtiger_imageurl:$THEME}" 
alt="Clear" title="Clear" LANGUAGE=javascript	onClick="this.form.{$fldname}.value=''; this.form.{$fldname}_display.value=''; return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;
			</td>
		{* END *}
		{elseif $uitype eq 2 && $fldname neq 'postenum' }
			<td width=20% class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small">{/if}
			</td>
			
			{* Siprod change *}
		
			{if $fldname eq 'ticket' && ($MODULE eq 'Demandes' || $MODULE eq 'DemandesFournituresService') && $OP_MODE eq 'create_view' }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$NEXTTICKET}" tabindex="{$vt_tab}" class='inputReadonly' ">
				</td> 
			{elseif $fldname eq 'ticket' && ($MODULE eq 'Incidents' || $MODULE eq 'Conventions') && $OP_MODE eq 'create_view' }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$NEXTTICKETINCIDENT}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td> 
				
			{elseif $fldname eq 'numom' && $MODULE eq 'OrdresMission' && $OP_MODE eq 'create_view'}
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$NEXTTICKET}"  class='inputReadonly'">
				</td>
			{elseif $fldname eq 'ticket' && ($MODULE eq 'Reunion') && $OP_MODE eq 'create_view' }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$NEXTTICKETREUNION}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td>	
				
			{elseif $fldname eq 'ticket' && ($MODULE eq 'Transfert') && $OP_MODE eq 'create_view' }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$NEXTTICKETTRANSFERT}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td>		
			{elseif $fldname eq 'ticket' && $MODULE eq 'Reunion' && $OP_MODE eq 'openbc' }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$NEXTREUNIONBC}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td>
			{elseif $fldname eq 'ticketparent' && $MODULE eq 'Reunion' && $OP_MODE eq 'openbc' }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$TICKET}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td>
				
			{elseif $fldname eq 'identifiant' && ($MODULE eq 'Tiers') && $OP_MODE eq 'create_view' }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$NEXTIDENTIFIANTTIERS}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td> 
			{elseif $fldname eq 'ticket' && ($MODULE eq 'ExecutionConventions' || $MODULE eq 'TraitementConventions') && $OP_MODE eq 'create_view' }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$TICKET}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td> 	
			{elseif $fldname eq 'maitriseouvrage' && $MODULE eq 'Conventions' && $OP_MODE eq 'create_view' }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}"  value="{$MAITREOUVRAGE}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td> 	
			{elseif $fldname eq 'identifiant'  && ($MODULE eq 'Candidats') }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td> 
			{elseif ($fldname eq 'matricule'  || $fldname eq 'badge' || $fldname eq 'nom' || $fldname eq 'nomjeunefille' || $fldname eq 'prenoms' || $fldname eq 'nomutilisateursap' || $fldname eq 'emailprofessionnel') && ($MODULE eq 'Agentuemoa') }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$fldvalue}" tabindex="{$vt_tab}" class=small2 >
				</td> 
			{elseif ($fldname eq 'affectposte' || $fldname eq 'affectfonction' || $fldname eq 'diplome') && ($MODULE eq 'Agentuemoa') }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$fldvalue}" tabindex="{$vt_tab}" size="60" class=small3 >
				</td> 	
			{elseif $fldname eq 'popimpactee' && $MODULE eq 'Incidents'}
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
			    	<input type="checkbox" id="tous" name="tous" {$ALL_POPULATION_CHECKED}>Tous</input>
				</td> 
			{elseif $fldname eq 'agenceexecution' && $MODULE eq 'Conventions'}
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" id="{$fldname}"  tabindex="{$vt_tab}" tabindex="{$vt_tab}" value="{$fldvalue}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
					<br><b>Ou selectionner dans la liste...</b> <br>
					<select name="modlist" id="modlist"  tabindex="{$vt_tab}" class="small" onchange="getMOD()" style="width:230px;">
					 {html_options  options=$AGENCESEXECUTION selected=$fldvalue}
					</select>	
				</td>	
				
			{*elseif $fldname eq 'trajet1depart' && $MODULE eq 'OrdresMission'}
				<td width=30% align=left class="dvtCellInfo">
					<b>De :</b> <input type="text" name="trajet1depart" id="trajet1depart"  tabindex="{$vt_tab}" value="{$fldvalue}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
					<b>&Agrave;&nbsp;&nbsp; :</b> <input type="text" name="trajet1arrivee" id="trajet1arrivee"  tabindex="{$vt_tab}" value="{$fldvalue}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td>	*}
			{*elseif ($fldname eq 'bailleurs') && $MODULE eq 'Conventions'}
			{if $OP_MODE eq 'edit_view' }
				{assign var=rate1 value=$BAILLEUR1_RATE}
				{assign var=rate2 value=$BAILLEUR2_RATE}
				{assign var=bailleur2_val value=$BAILLEUR2_VAL}
				{assign var=bailleur1_val value=$BAILLEUR1_VAL}

				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" id="{$fldname}" tabindex="{$vt_tab}" value="{$bailleur1_val}" tabindex="{$vt_tab}" class=detailedViewTextBox2   size="25">&nbsp;&nbsp;
			    	<input type="text" name="{$fldname}rate" id="{$fldname}rate" tabindex="{$vt_tab}" class=detailedViewTextBox2 value="{$rate1}" tabindex="{$vt_tab}"  size="3" maxlength="3" onblur="calculDeltaFin()">&nbsp;(% Financement)
					<input type="text" name="{$fldname}2" id="{$fldname}2" tabindex="{$vt_tab}"  value="{$bailleur2_val}" tabindex="{$vt_tab}" class=detailedViewTextBox2  size="25" >&nbsp;&nbsp;
					<input type="text" name="{$fldname}2rate" id="{$fldname}2rate" tabindex="{$vt_tab}" value="{$rate2}" class=detailedViewTextBox2 tabindex="{$vt_tab}" readonly size="3" maxlength="3">&nbsp;(% Financement)
				</td> 
			{else}	
					<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" id="{$fldname}" tabindex="{$vt_tab}"  tabindex="{$vt_tab}" class=detailedViewTextBox2   size="25">&nbsp;&nbsp;
			    	<input type="text" name="{$fldname}rate" id="{$fldname}rate" tabindex="{$vt_tab}" class=detailedViewTextBox2  tabindex="{$vt_tab}"  size="3" maxlength="3" onblur="calculDeltaFin()">&nbsp;(% Financement)
					<input type="text" name="{$fldname}2" id="{$fldname}2" tabindex="{$vt_tab}"   tabindex="{$vt_tab}" class=detailedViewTextBox2  size="25" >&nbsp;&nbsp;
					<input type="text" name="{$fldname}2rate" id="{$fldname}2rate" tabindex="{$vt_tab}"  class=detailedViewTextBox2 tabindex="{$vt_tab}" readonly size="3" maxlength="3">&nbsp;(% Financement)
				</td> 
			{/if*}
			{elseif ($fldname eq 'bailleurs') && $MODULE eq 'Conventions'}
			{if $OP_MODE eq 'edit_view' }
				{assign var=bailleur2_val value=$BAILLEUR2_VAL}
				{assign var=bailleur1_val value=$BAILLEUR1_VAL}

				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" id="{$fldname}" tabindex="{$vt_tab}" value="{$bailleur1_val}" tabindex="{$vt_tab}" class=detailedViewTextBox2   size="25">&nbsp;&nbsp;
					<input type="text" name="{$fldname}2" id="{$fldname}2" tabindex="{$vt_tab}"  value="{$bailleur2_val}" tabindex="{$vt_tab}" class=detailedViewTextBox2  size="25" >&nbsp;&nbsp;
				</td> 
									
			{else}	
					<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" id="{$fldname}" tabindex="{$vt_tab}"  tabindex="{$vt_tab}" class=detailedViewTextBox2   size="25">&nbsp;&nbsp;
					<input type="text" name="{$fldname}2" id="{$fldname}2" tabindex="{$vt_tab}"   tabindex="{$vt_tab}" class=detailedViewTextBox2  size="25" >&nbsp;&nbsp;
				</td> 
			{/if}
			{elseif ($fldname eq 'bailleursrate') && $MODULE eq 'Conventions'}
			{if $OP_MODE eq 'edit_view' }
				{assign var=rate1 value=$BAILLEUR1_RATE}
				{assign var=rate2 value=$BAILLEUR2_RATE}
				{assign var=bailleur2_val value=$BAILLEUR2_VAL}
				{assign var=bailleur1_val value=$BAILLEUR1_VAL}

				<td width=30% align=left class="dvtCellInfo">
			    	<input type="text" name="{$fldname}" id="{$fldname}" tabindex="{$vt_tab}" class=detailedViewTextBox2 value="{$rate1}" tabindex="{$vt_tab}"  size="3" maxlength="3" onblur="calculDeltaFin()">&nbsp;%<br>
					<input type="text" name="{$fldname}2" id="{$fldname}2" tabindex="{$vt_tab}" value="{$rate2}" class=detailedViewTextBox2 tabindex="{$vt_tab}" readonly size="3" maxlength="3">&nbsp;%
				</td> 
			{else}	
					<td width=30% align=left class="dvtCellInfo">
			    	<input type="text" name="{$fldname}" id="{$fldname}" tabindex="{$vt_tab}" class=detailedViewTextBox2  tabindex="{$vt_tab}"  size="3" maxlength="3" onblur="calculDeltaFin()">&nbsp;%<br>
					<input type="text" name="{$fldname}2" id="{$fldname}2" tabindex="{$vt_tab}"  class=detailedViewTextBox2 tabindex="{$vt_tab}" readonly size="3" maxlength="3">&nbsp;(% Financement)
				</td> 
			{/if}
			{elseif $fldname eq 'beneficiaire' && $MODULE eq 'Conventions'}
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" id="{$fldname}" tabindex="{$vt_tab}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">&nbsp;&nbsp;
			    	<input type="checkbox" name="{$fldname}_ismod" id="{$fldname}_ismod" onchange="isbeneficiaireMOD()">(M.O.D)</input>
				</td>
			{elseif $fldname eq 'pays' && $MODULE eq 'PHVInfos'}
				<td width=30% align=left class="dvtCellInfo">
					{if $OP_MODE eq 'edit_view' }
						<input type="text" name="{$fldname}" id="{$fldname}" tabindex="{$vt_tab}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">&nbsp;&nbsp;
					{else}	
						<input type="text" name="{$fldname}" id="{$fldname}" tabindex="{$vt_tab}" value="{$CURRENT_PAYS}" readonly tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">&nbsp;&nbsp;
					
					{/if}
				</td>
			{elseif $fldname eq 'numom' && $MODULE eq 'OrdresMission' && $OP_MODE eq 'edit_view' }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td>		
			{elseif $fldname eq 'ticket' && ( $MODULE eq 'Demandes' || $MODULE eq 'DemandesFournituresService' || $MODULE eq 'Incidents' || $MODULE eq 'Conventions' ) && $OP_MODE eq 'edit_view' }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td>
					{*elseif $fldname eq 'ticket' && $MODULE eq 'Incidents' && $OP_MODE eq 'edit_view' }
						<td width=30% align=left class="dvtCellInfo">
							<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
						</td>
					*}	
			{elseif $fldname eq 'user' && ( $MODULE eq 'TraitementDemandes' || $MODULE eq 'TraitementIncidents'|| $MODULE eq 'TraitementIncidents' || $MODULE eq 'TraitementConventions') && ($OP_MODE eq 'create_view' || $OP_MODE eq 'create_view') }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="vue" tabindex="{$vt_tab}" readonly="true" value="{$USER}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
					<input type="hidden" name="{$fldname}" tabindex="{$vt_tab}" value="{$USER_ID}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td>
				
					{*elseif $fldname eq 'user' && ( $MODULE eq 'TraitementDemandes' || $MODULE eq 'TraitementIncidents' || $MODULE eq 'TraitementConventions') && $OP_MODE eq 'edit_view' }
						<td width=30% align=left class="dvtCellInfo">
							<input type="text" name="vue" tabindex="{$vt_tab}" readonly="true" value="{$USER}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
							<input type="hidden" name="{$fldname}" tabindex="{$vt_tab}" value="{$USER_ID}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
						</td>
					*}	
			{elseif $fldname eq 'ticket' && $MODULE eq 'TraitementDemandes' && $OP_MODE eq 'create_view' }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$TICKET}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td> 
			{elseif $fldname eq 'ticket' && $MODULE eq 'TraitementDemandes' && $OP_MODE eq 'edit_view' }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td>
				
			{elseif $fldname eq 'datemodification' && ( $MODULE eq 'TraitementDemandes' || $MODULE eq 'TraitementIncidents' || $MODULE eq 'TraitementConventions') }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$DATEMODIF}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td>
			
			
			{elseif ($fldname eq 'nom'  || $fldname eq 'nomcomplet') && ($MODULE eq 'Demandes' || $MODULE eq 'OrdresMission' || $MODULE eq 'DemandesFournituresService') }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$AGENTNOM}" tabindex="{$vt_tab}" class='inputReadonly'">
				</td> 		
			{elseif $fldname eq 'prenom' && ($MODULE eq 'Demandes' || $MODULE eq 'DemandesFournituresService')}
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$AGENTPRENOM}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td> 
			{elseif $fldname eq 'matricule' && ($MODULE eq 'OrdresMission' || $MODULE eq 'DemandesFournituresService')}
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$AGENTMATRICULE}" tabindex="{$vt_tab}" class='inputReadonly'">
				</td> 
			{elseif $fldname eq 'service' && ($MODULE eq 'Demandes' || $MODULE eq 'OrdresMission' || $MODULE eq 'DemandesFournituresService')}
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$AGENTSERVICE}" tabindex="{$vt_tab}" class='inputReadonly'">
				</td> 
				
				
			{elseif $fldname eq 'lieu' && ($MODULE == 'OrdresMission')}
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$DEMANDELIEU}" tabindex="{$vt_tab}" class='inputReadonly'">
				</td> 
			{elseif $fldname eq 'objet' && ($MODULE eq 'OrdresMission')}
				<td width=30% align=left class="dvtCellInfo">
					<textarea class='inputReadonly' tabindex="{$vt_tab}"  name="{$fldname}" readonly="true"  cols="90" rows="8">{$DEMANDEOBJET}</textarea>
				</td>
			{elseif $fldname eq 'commentbillet' && ($MODULE eq 'OrdresMission')}
				<td width=30% align=left class="dvtCellInfo">
					<textarea class='inputReadonly' tabindex="{$vt_tab}"  name="{$fldname}" readonly="true" cols="90" rows="8">{$DEMANDECOMMENTBILLET}</textarea>
				</td>
			{elseif $fldname eq 'fonction' && ($MODULE eq 'OrdresMission' )}
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$AGENTFONCTION}" tabindex="{$vt_tab}" class='inputReadonly'">
				</td> 
				{elseif $fldname eq 'datedebut'  && ($MODULE eq 'OrdresMission')}
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$DEMANDEDATEDEB}" tabindex="{$vt_tab}" class='inputReadonly'">
				</td> 
				{elseif $fldname eq 'datefin'  && ($MODULE eq 'OrdresMission')}
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$DEMANDEDATEFIN}" tabindex="{$vt_tab}" class='inputReadonly'">
				</td> 	
								
				
			{else}
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" id="{$fldname}" tabindex="{$vt_tab}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'" style="width:250px">
				</td>
			{/if}
			
			{* Siprod change end *}
	
		{elseif $uitype eq 3 || $uitype eq 4}<!-- Non Editable field, only configured value will be loaded -->
				<td width=20% class="dvtCellLabel" align=right>{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small">{/if}</td>
                                <td width=30% align=left class="dvtCellInfo"><input readonly type="text" tabindex="{$vt_tab}" name="{$fldname}" id ="{$fldname}" {if $MODE eq 'edit'} value="{$fldvalue}" {else} value="{$MOD_SEQ_ID}" {/if} class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'"></td>
		{elseif $uitype eq 11 || $uitype eq 1 || $uitype eq 13 || $uitype eq 7 || $uitype eq 9}
			<td width=20% class="dvtCellLabel" align=right>{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}</td>
			
			{if $fldname eq 'email'  && ($MODULE eq 'Candidats') }
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" readonly="true" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td> 
				
			{elseif $fldname eq 'tickersymbol' && $MODULE eq 'Accounts'}
				<td width=30% align=left class="dvtCellInfo">
					<input type="text" name="{$fldname}" tabindex="{$vt_tab}" id ="{$fldname}" value="{$fldvalue}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn';" onBlur="this.className='detailedViewTextBox';{if $fldname eq 'tickersymbol' && $MODULE eq 'Accounts'}sensex_info(){/if}">
					<span id="vtbusy_info" style="display:none;">
						<img src="{'vtbusy.gif'|@vtiger_imageurl:$THEME}" border="0"></span>
				</td>
			{elseif  $fldname eq 'folderid'}
				<td width=30% align=left class="dvtCellInfo">
					<input type="hidden" name="{$fldname}" tabindex="{$vt_tab}" id ="{$fldname}" value="{$FOLDERID}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn';" onBlur="this.className='detailedViewTextBox'">
					<img src="{'dossier-ferme.gif'|@vtiger_imageurl:$THEME}">&nbsp;{$FOLDERNAME}
					
				</td>
			{else}
				<td width=30% align=left class="dvtCellInfo"><input type="text" tabindex="{$vt_tab}" name="{$fldname}" id ="{$fldname}" value="{$fldvalue}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'"></td>
			{/if}
		{elseif $uitype eq 19 || $uitype eq 20}
			<!-- In Add Comment are we should not display anything -->
			{if $fldlabel eq $MOD.LBL_ADD_COMMENT}
				{assign var=fldvalue value=""}
			{/if}
			{if $fldname eq 'libelle' && $MODULE eq 'TraitementConventions'}
				{assign var=fldvalue value="$LIBELLECONV"}
			{/if}
			{if $fldname eq 'description'}
				<td colspan=4 class="dvtCellLabel">
					<textarea class="detailedViewTextBox" tabindex="{$vt_tab}" onFocus="this.className='detailedViewTextBoxOn'" name="{$fldname}"  onBlur="this.className='detailedViewTextBox'" cols="110" rows="12">{$fldvalue}</textarea>
					{if $fldlabel eq $MOD.Solution}
					<input type = "hidden" name="helpdesk_solution" value = '{$fldvalue}'>
					{/if}
				</td>
			{else}		
				<td width=20% class="dvtCellLabel" align=right>
						 
					{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
				</td>
				<td colspan=3>
					<textarea class="detailedViewTextBox" tabindex="{$vt_tab}" onFocus="this.className='detailedViewTextBoxOn'" name="{$fldname}"  onBlur="this.className='detailedViewTextBox'" cols="90" rows="8">{$fldvalue}</textarea>
					{if $fldlabel eq $MOD.Solution}
					<input type = "hidden" name="helpdesk_solution" value = '{$fldvalue}'>
					{/if}
				</td>
			{/if}
		{elseif $uitype eq 21 || $uitype eq 24}
			<td width=20% class="dvtCellLabel" align=right>
					
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width=30% align=left class="dvtCellInfo">
				<textarea value="{$fldvalue}" name="{$fldname}" id="{$fldname}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'" rows=2>{$fldvalue}</textarea>
			</td>
		{elseif $uitype eq 15 || $uitype eq 16 } <!-- uitype 111 added for noneditable existing picklist values - ahmed -->
		
			<td width="20%" class="dvtCellLabel" align=right>
				
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
			{if $fldname eq 'localite'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:160px;">
					 {html_options  options=$LOCALITES selected=$fldvalue}
					</select>
					
			{************************************ NOMADE **********************************************************}
			
				{elseif $fldname eq 'matricule' && $MODULE eq 'Demandes'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;" onchange="getfoncagent()">
					{html_options  options=$LISTAGENTS selected=$fldvalue}

					</select>
			{elseif $fldname eq 'natmission' && $MODULE eq 'Demandes'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					 {html_options  options=$NATUREMISSION selected=$fldvalue}

					</select>

			{elseif $fldname eq 'modetransport' && $MODULE eq 'Demandes'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					 {html_options  options=$MOYENTRANSPORT selected=$fldvalue}

					</select>
			{elseif $fldname eq 'lieu' && $MODULE eq 'Demandes'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					 {html_options  options=$LOCALITES selected=$fldvalue}

					</select>
			
			{elseif ( $fldname eq 'budget' || $fldname eq 'budget2' || $fldname eq 'budget3' || $fldname eq 'budget4' || $fldname eq 'budget5' ) && ($MODULE eq 'Demandes' || $MODULE eq 'Reunion')}			
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					 {html_options  options=$TYPESBUDGET selected=$fldvalue}

					</select>

			{elseif ( $fldname eq 'sourcefin' || $fldname eq 'sourcefin2' || $fldname eq 'sourcefin3' || $fldname eq 'sourcefin4' || $fldname eq 'sourcefin5' ) && ($MODULE eq 'Demandes' || $MODULE eq 'Reunion')}			
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					 {html_options  options=$SOURCESFINACEMENT selected=$fldvalue}

					</select>

			{elseif ( $fldname eq 'codebudget' || $fldname eq 'codebudget2' || $fldname eq 'codebudget3' || $fldname eq 'codebudget4' || $fldname eq 'codebudget5' ) && $MODULE eq 'Demandes'}			
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					 {html_options  options=$CODESBUDGETAIRES selected=$fldvalue}

					</select>
					
			{elseif ( $fldname eq 'comptenat' || $fldname eq 'comptenat2' || $fldname eq 'comptenat3' || $fldname eq 'comptenat4' || $fldname eq 'comptenat5' ) && $MODULE eq 'Demandes'}			
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					 {html_options  options=$COMPTESNATURE selected=$fldvalue}

					</select>
			
			{elseif $fldname eq 'motif' && $MODULE eq 'TraitementDemandes'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					{html_options  options=$MOTIFSREJET selected=$fldvalue}

					</select>
					
			{elseif ($fldname eq 'zonemission' || $fldname eq 'trajet1zone' || $fldname eq 'trajet2zone' || $fldname eq 'trajet3zone' ||
						$fldname eq 'trajet4zone' || $fldname eq 'trajet5zone' || $fldname eq 'trajet6zone' || $fldname eq 'trajet7zone' || $fldname eq 'trajet8zone')
						&& $MODULE eq 'OrdresMission'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					 {html_options  options=$ZONEMISSION selected=$fldvalue}

					</select>	
			
			{elseif $fldname eq 'timbre' && $MODULE eq 'OrdresMission'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					{html_options  options=$TIMBRES selected=$fldvalue}

					</select>	
			{elseif $fldname eq 'signataire' && $MODULE eq 'OrdresMission'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					 {html_options  options=$SIGNATAIRES selected=$fldvalue}

					</select>
			
			{elseif $fldname eq 'matinterimaire' && $MODULE eq 'Interim'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					 {html_options  options=$LISTINTERIMAIRES selected=$fldvalue}

					</select>
			{elseif $fldname eq 'matdirecteur' && $MODULE eq 'Interim'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					 {html_options  options=$LISTDIRECTEURS selected=$MATDIRECTEUR}

					</select>
			{elseif $fldname eq 'user_sexe' && $MODULE eq 'UsersNomade'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					 {html_options  options=$CIVILITES selected=$fldvalue}

					</select>
			{elseif $fldname eq 'user_direction' && $MODULE eq 'UsersNomade'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					 {html_options  options=$DIRECTIONS selected=$fldvalue}

					</select>
			{elseif $fldname eq 'user_profil' && $MODULE eq 'UsersNomade'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					 {html_options  options=$PROFILS selected=$fldvalue}

					</select>
			{elseif $fldname eq 'user_categmis' && $MODULE eq 'UsersNomade'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					 {html_options  options=$CATEGORIES selected=$fldvalue}

					</select>
			
			{elseif $fldname eq 'responssuivi' && ($MODULE eq 'Reunion')}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					{html_options  options=$LISTAGENTS selected=$fldvalue}
					</select>
			{elseif $fldname eq 'departement' && ($MODULE eq 'Reunion' || $MODULE eq 'Transfert')}
					<select name="{$fldname}" disabled="true" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:300px;">
					{html_options  options=$DEPARTEMENTS selected=$DEPARTSELECTED}
					</select>
					<input type="hidden" name="{$fldname}" id="{$fldname}" value="{$DEPARTSELECTED}">
			
			{elseif $fldname eq 'direction' && ($MODULE eq 'Reunion' || $MODULE eq 'Transfert')}
					<select name="{$fldname}" disabled="true" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:300px;">
					{html_options  options=$DIRECTIONS selected=$DIRECTIONSELECTED}
					</select>
					<input type="hidden" name="{$fldname}" id="{$fldname}" value="{$DIRECTIONSELECTED}">
					
			{elseif $fldname eq 'lieu' && ($MODULE eq 'Reunion')}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;">
					{html_options  options=$VILLESUEMOA selected=$fldvalue}
					</select>
			{elseif ( $fldname eq 'codebudget') && ($MODULE eq 'Reunion')}			
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;" onchange="getCompteNatByBudget()">
					 {html_options  options=$CODESBUDGETAIRES selected=$fldvalue}

					</select>
					
			{elseif $fldname eq 'typereamenagement' && ($MODULE eq 'Transfert')}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:150px;">
					{html_options  options=$TYPEREAMENAGEMENT selected=$fldvalue}
					</select>
			{*************************************** NOMADE FIN ***************************************************}
					
					
					
					
					
			{elseif $fldname eq 'projetid' && $MODULE eq 'Conventions'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" id="{$fldname}" style="width:230px;" onchange="getinfosprojet()">
					 {html_options  options=$PROJECTS selected=$fldvalue }
					</select>
			{elseif $fldname eq 'domaine' && $MODULE eq 'Conventions'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:230px;">
					 {html_options  options=$DOMAINES selected=$fldvalue}
					</select>				
			{elseif $fldname eq 'typeactivite' && $MODULE eq 'Conventions'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:230px;">
					 {html_options  options=$TYPESACTIVITE selected=$fldvalue}
					</select>	
			
			{elseif ( $fldname eq 'devisecompte1' || $fldname eq 'devisecompte2' || $fldname eq 'devisecompte3' ) && $MODULE eq 'Tiers'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:230px;">
					 {html_options  options=$DEVISES selected=$fldvalue}
					</select>
			{elseif ( $fldname eq 'devise' || $fldname eq 'devise1' || $fldname eq 'devise2' || $fldname eq 'devise3' || $fldname eq 'devise4') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:230px;">
					 {html_options  options=$DEVISES selected=$fldvalue}
					</select>					
			{elseif ( $fldname eq 'formejuridique') && $MODULE eq 'Tiers'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:230px;">
					 {html_options  options=$FORMESJURIDIQUES selected=$fldvalue}
					</select>	
			{elseif ( $fldname eq 'personnalitejuridique') && $MODULE eq 'Tiers'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:230px;">
					 {html_options  options=$PERSONNALITEJURIDIQUES selected=$fldvalue}
					</select>		
			{elseif ( $fldname eq 'pays') && ($MODULE eq 'Tiers' || $MODULE eq 'Candidats') }
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:230px;">
					 {html_options  options=$PAYS selected=$fldvalue}
					</select>	
			
			{elseif ( $fldname eq 'nombreenfants') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" id="{$fldname}" onchange="changenbenfants();" disabled="true" tabindex="{$vt_tab}" class="small" style="width:100px">
					 {html_options  options=$NBENFANTS selected=$fldvalue}
					</select>
			{elseif ( $fldname eq 'natureactenaissance') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:230px">
					 {html_options  options=$NATUREACTENAIS selected=$fldvalue}
					</select>
			{elseif ( $fldname eq 'nature') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}"  class="small" style="width:230px">
					 {html_options  options=$NATUREPIECEIDENT selected=$fldvalue}
					</select>
			{elseif ( $fldname eq 'conttypecontrat') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}" disabled="true" class="small" style="width:230px">
					 {html_options  options=$TYPECONTRAT selected=$fldvalue}
					</select>
			{elseif ( $fldname eq 'contcategorie') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}" disabled="true" class="small" style="width:230px">
					 {html_options  options=$CATEGORIESALARIE selected=$fldvalue}
					</select>
			
			{elseif ( $fldname eq 'contstatut') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}" disabled="true" class="small" style="width:230px">
					 {html_options  options=$STATUTSALARIE selected=$fldvalue}
					</select>
			{elseif ( $fldname eq 'langue') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:230px;">
					 {html_options  options=$LANGUEFORMATION selected=$fldvalue}
					</select>
			{elseif ( $fldname eq 'contperiodeessai') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:100px">
					 {html_options  options=$PERIODEESSAI selected=$fldvalue}
					</select>	
			{elseif ( $fldname eq 'diplome') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:100px;">
					 {html_options  options=$DIPLOME selected=$fldvalue}
					</select>	
			{elseif ( $fldname eq 'permis') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:100px;">
					 {html_options  options=$PERMISCONDUIRE selected=$fldvalue}
					</select>		
			{elseif ( $fldname eq 'modedepaiement' || $fldname eq 'modedepaiement2' || $fldname eq 'modedepaiement3' || 
					$fldname eq 'modedepaiement4' || $fldname eq 'modedepaiement5' ) && $MODULE eq 'Agentuemoa'}
					{if $fldname eq 'modedepaiement'}
						<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:230px">
					{else}
						<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:230px;">
					{/if}
					 {html_options  options=$MODEDEPAIEMENT selected=$fldvalue}
					</select>		
			{elseif ( $fldname eq 'niveauxscolaires') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:230px;">
					 {html_options  options=$NIVEAUSCOLAIRE selected=$fldvalue}
					</select>
			{elseif ( $fldname eq 'contmotifdepart') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:230px">
					 {html_options  options=$MOTIFSDEPART selected=$fldvalue}
					</select>		
			{elseif ( $fldname eq 'nationalite' || $fldname eq 'perenationalite' || $fldname eq 'merenationalite' || 
					$fldname eq 'enfant1nationalite' || $fldname eq 'enfant2nationalite' || $fldname eq 'enfant3nationalite' || 
					$fldname eq 'enfant4nationalite' || $fldname eq 'enfant5nationalite' || $fldname eq 'enfant6nationalite' || $fldname eq 'conjointnationalite') && $MODULE eq 'Agentuemoa'}
					{if $fldname eq 'nationalite'}
						<select name="{$fldname}" tabindex="{$vt_tab}" disabled="true" class="small" style="width:230px">
					{else}
						<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:230px;">
					{/if}
					 {html_options  options=$NATIONNALITE selected=$fldvalue}
					</select>				
			{elseif ( $fldname eq 'sexe' || $fldname eq 'enfant1sexe' || $fldname eq 'enfant2sexe' || 
					$fldname eq 'enfant3sexe' || $fldname eq 'enfant4sexe' || $fldname eq 'enfant5sexe' || $fldname eq 'enfant6sexe' || $fldname eq 'conjointsexe' ) && $MODULE eq 'Agentuemoa'}
					{if $fldname eq 'sexe'}
						<select name="{$fldname}" tabindex="{$vt_tab}" disabled="true" class="small" style="width:100px">
					{else}
						<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:100px;">
					{/if}
					 {html_options  options=$SEXE selected=$fldvalue}
					</select>
			{elseif ( $fldname eq 'peresexe') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}"   class="small" style="width:100px;">
					 {html_options  options=$SEXE selected="M"}
					</select>
			{elseif ($fldname eq 'meresexe') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}"  class="small" style="width:100px;">
					 {html_options  options=$SEXE selected="F"}
					</select>
			{elseif ( $fldname eq 'sexe') && $MODULE eq 'Candidats'}
					<select name="{$fldname}" tabindex="{$vt_tab}"   class="small" style="width:100px;">
					 {html_options  options=$SEXE selected=$fldvalue}
					</select>					
			{elseif ( $fldname eq 'dipniveau') && $MODULE eq 'Candidats'}
					<select name="{$fldname}" tabindex="{$vt_tab}"   class="small" style="width:100px;">
					 {html_options  options=$NIVEAUDIPLOME selected=$fldvalue}
					</select>
			{elseif ( $fldname eq 'nationalite') && $MODULE eq 'Candidats'}
					<select name="{$fldname}" tabindex="{$vt_tab}"   class="small" style="width:100px;">
					 {html_options  options=$NATIONALITE selected=$fldvalue}
					</select>		
			{elseif ( $fldname eq 'etab1formenligne' || $fldname eq 'etab1formpreinscription' || $fldname eq 'etab2formenligne' || $fldname eq 'etab2formpreinscription' || $fldname eq 'etab3formenligne' || $fldname eq 'etab3formpreinscription') && $MODULE eq 'Candidats'}
					<select name="{$fldname}" tabindex="{$vt_tab}"   class="small" style="width:100px;">
					 {html_options  options=$BOOL selected=$fldvalue}
					</select>
			{elseif ( $fldname eq 'etab1ville' || $fldname eq 'etab2ville' || $fldname eq 'etab3ville') && $MODULE eq 'Candidats'}
					<select name="{$fldname}" tabindex="{$vt_tab}"   class="small" style="width:100px;">
					 {html_options  options=$LOCALITES selected=$fldvalue}
					</select>
			{elseif ( $fldname eq 'etab1pays' || $fldname eq 'etab2pays' || $fldname eq 'etab3pays') && $MODULE eq 'Candidats'}
					<select name="{$fldname}" tabindex="{$vt_tab}"   class="small" style="width:150px;">
					 {html_options  options=$PAYS selected=$fldvalue}
					</select>
			{elseif ( $fldname eq 'civilite' ||  $fldname eq 'enfant1civilite' || $fldname eq 'enfant2civilite' || 
					$fldname eq 'enfant3civilite' || $fldname eq 'enfant4civilite' || $fldname eq 'enfant5civilite' || $fldname eq 'enfant6civilite' || $fldname eq 'conjointcivilite' ) && $MODULE eq 'Agentuemoa'}
					{if $fldname eq 'civilite'}
						<select name="{$fldname}" tabindex="{$vt_tab}" disabled="true" class="small" style="width:100px">
					{else}
						<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:100px;">
					{/if}
					 {html_options  options=$CIVILITE selected=$fldvalue}
					</select>
			{elseif ($fldname eq 'perecivilite') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:100px;">
					 {html_options  options=$CIVILITE selected="M"}
					</select>
			{elseif ($fldname eq 'peresexe') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:100px;">
					 {html_options  options=$SEXE selected="HOMME"}
					</select>
			{elseif ($fldname eq 'merecivilite') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:100px;">
					 {html_options  options=$CIVILITE selected="MME"}
					</select>		
			{elseif ($fldname eq 'meresexe') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:100px;">
					 {html_options  options=$SEXE selected="F"}
					</select>		
			{elseif ( $fldname eq 'situationfamiliale' ) && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" id="{$fldname}" onchange="changesituationfamiliale();" disabled="true" tabindex="{$vt_tab}" class="small" style="width:100px">
					 {html_options  options=$SITUATIONFAMILIALE selected=$fldvalue}
					</select>
			{elseif ( $fldname eq 'perescolouapprent' || $fldname eq 'merescolouapprent' || $fldname eq 'enfant1scolouapprent' || $fldname eq 'enfant2scolouapprent' || 
					$fldname eq 'enfant3scolouapprent' || $fldname eq 'enfant4scolouapprent' || $fldname eq 'enfant5scolouapprent' || 
					$fldname eq 'enfant6scolouapprent' || $fldname eq 'conjointscolouapprent') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:100px;">
					 {html_options  options=$SCOLOUAPPRENT selected=$fldvalue}
					</select>	
			{elseif ( $fldname eq 'peresaloucom' || $fldname eq 'meresaloucom' || $fldname eq 'enfant1saloucom' || $fldname eq 'enfant2saloucom' || 
					$fldname eq 'enfant3saloucom' || $fldname eq 'enfant4saloucom' || $fldname eq 'enfant5saloucom' || 
					$fldname eq 'enfant6saloucom' || $fldname eq 'conjointsaloucom') && $MODULE eq 'Agentuemoa'}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:100px;">
					 {html_options  options=$SALOUCOM selected=$fldvalue}
					</select>

			{elseif ( $fldname eq 'typedemande' || $fldname eq 'typedemande2' || $fldname eq 'typedemande3' || $fldname eq 'typedemande4' || $fldname eq 'typedemande5') && ($MODULE eq 'Demandes')}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:200px;">
					 {html_options  options=$TYPEMATERIELS selected=$fldvalue}
					</select>			
			
			{elseif ( $fldname eq 'typedemande' || $fldname eq 'typedemande2' || $fldname eq 'typedemande3' || $fldname eq 'typedemande4' || $fldname eq 'typedemande5') && ($MODULE eq 'DemandesFournituresService')}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:200px;">
					 {html_options  options=$TYPECONSOMMABLES selected=$fldvalue}
					</select>	
					
			{elseif ( $fldname eq 'quantite' || $fldname eq 'quantite2' || $fldname eq 'quantite3' || $fldname eq 'quantite4' || $fldname eq 'quantite5') && ($MODULE eq 'Demandes' || $MODULE eq 'DemandesFournituresService')}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:100px;">
					 {html_options  options=$QUANTITE selected=$fldvalue}
					</select>
			
			{elseif ( $fldname eq 'priorite') && ($MODULE eq 'Demandes' || $MODULE eq 'DemandesFournituresService')}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:100px;">
					 {html_options  options=$PRIORITE selected=$fldvalue}
					</select>
					
			{elseif ( $fldname eq 'anneebudgetaire' || $fldname eq 'anneebudgetaire2' || $fldname eq 'anneebudgetaire3' || $fldname eq 'anneebudgetaire4' || $fldname eq 'anneebudgetaire5') && ($MODULE eq 'Demandes' || $MODULE eq 'DemandesFournituresService')}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:100px;">
					 {html_options  options=$ANNEEBUDGETAIRE selected=$fldvalue}
					</select>
			
			{elseif ($fldname eq 'naturedemande') && $MODULE eq 'DemandesFournituresService'}
			<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:200px;">
					 {html_options  options=$NATUREDEMANDE selected=$fldvalue}
			</select>
		
			{else}
				{if $MODULE eq 'Calendar'}
			   		<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:160px;">
				{elseif $fldname eq 'date_format'}
			   		<select name="{$fldname}" disabled class="small" >	
				{elseif $fldname eq 'affectorgane' && $MODULE eq 'Agentuemoa'}
			   		<select name="{$fldname}" id="{$fldname}"  onchange="getdepartement();" disabled="true" class="small" style="width:250px;">	
				{elseif $fldname eq 'affectdepartement' && $MODULE eq 'Agentuemoa'}
			   		<select name="{$fldname}" id="{$fldname}"  onchange="getdirection();" disabled="true" class="small" style="width:250px;">	
				{elseif $fldname eq 'affectdirection' && $MODULE eq 'Agentuemoa'}
			   		<select name="{$fldname}" id="{$fldname}"  onchange="getdirection();" disabled="true" class="small" style="width:250px;">	
				{elseif $fldname eq 'affectdivision' && $MODULE eq 'Agentuemoa'}
			   		<select name="{$fldname}" id="{$fldname}"  onchange="getdirection();" class="small" style="width:250px;">		
									
				{elseif ($fldname eq 'paysnaissance')  && $MODULE eq 'Agentuemoa'}					
					<select name="{$fldname}" tabindex="{$vt_tab}" disabled="true" class="small2" style="width:100px">
				
				{elseif ($fldname eq 'paysemission')  && $MODULE eq 'Agentuemoa'}					
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small" style="width:100px">
				{else}
			   		<select name="{$fldname}" tabindex="{$vt_tab}" class="small">
			   	{/if}
				{foreach item=arr from=$fldvalue}
					{if $arr[0] eq $APP.LBL_NOT_ACCESSIBLE}
					<option value="{$arr[0]}" {$arr[2]}>
						{$arr[0]}
					</option>
					{else}
					<option value="{$arr[1]}" {$arr[2]}>
                                                {$arr[0]}
                                        </option>
					{/if}
				{/foreach}
			   </select>
			{/if}	   
			</td>

		{elseif $uitype eq 33}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			{if $fldname eq 'typeactivite1'}
			<td width="30%" align=left class="dvtCellInfo">
			   <select MULTIPLE name="{$fldname}[]" size="4" style="width:260px;" tabindex="{$vt_tab}" class="small">
					 {html_options  options=$TYPESACTIVITE }
				</select>
			</td>
			{else}	
			<td width="30%" align=left class="dvtCellInfo">
			   <select MULTIPLE name="{$fldname}[]" size="4" style="width:160px;" tabindex="{$vt_tab}" class="small">
				{foreach item=arr from=$fldvalue}
					<option value="{$arr[1]}" {$arr[2]}>
                                                {$arr[0]}
                                        </option>
				{/foreach}
			   </select>
			</td>
		{/if}
		{elseif $uitype eq 53}
		{if ($fldname eq 'naturedemande') && $MODULE eq 'DemandesFournituresService'}
		<td width=20% class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small">{/if}
			</td>
		<td width="30%" class="dvtCellLabel" align=center >
			{html_radios name='$fldname' id='$fldname' options=$NATUREDEMANDE   selected=$customer_id separator=' '}
		</td>
		{/if}
		<!--
			<td width="20%" class="dvtCellLabel" align=right >
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				{assign var=check value=1}
				{foreach key=key_one item=arr from=$fldvalue}
					{foreach key=sel_value item=value from=$arr}
						{if $value ne ''}
							{assign var=check value=$check*0}
						{else}
							{assign var=check value=$check*1}
						{/if}
					{/foreach}
				{/foreach}

				{if $check eq 0}
					{assign var=select_user value='checked'}
					{assign var=style_user value='display:block'}
					{assign var=style_group value='display:none'}
				{else}
					{assign var=select_group value='checked'}
					{assign var=style_user value='display:none'}
					{assign var=style_group value='display:block'}
				{/if}

				<input type="radio" tabindex="{$vt_tab}" name="assigntype" {$select_user} value="U" onclick="toggleAssignType(this.value)" >&nbsp;{$APP.LBL_USER}

				{if $secondvalue neq ''}
					<input type="radio" name="assigntype" {$select_group} value="T" onclick="toggleAssignType(this.value)">&nbsp;{$APP.LBL_GROUP}
				{/if}
				
				<span id="assign_user" style="{$style_user}">
					<select name="assigned_user_id" class="small">
						{foreach key=key_one item=arr from=$fldvalue}
							{foreach key=sel_value item=value from=$arr}
								<option value="{$key_one}" {$value}>{$sel_value}</option>
							{/foreach}
						{/foreach}
					</select>
				</span>

				{if $secondvalue neq ''}
					<span id="assign_team" style="{$style_group}">
						<select name="assigned_group_id" class="small">';
							{foreach key=key_one item=arr from=$secondvalue}
								{foreach key=sel_value item=value from=$arr}
									<option value="{$key_one}" {$value}>{$sel_value}</option>
								{/foreach}
							{/foreach}
						</select>
					</span>
					
				{/if}
			</td>
		-->	
		
		
		
		
		{elseif $uitype eq 52 || $uitype eq 77}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				{if $uitype eq 52}
					<select name="assigned_user_id" class="small">
				{elseif $uitype eq 77}
					<select name="assigned_user_id1" tabindex="{$vt_tab}" class="small">
				{else}
					<select name="{$fldname}" tabindex="{$vt_tab}" class="small">
				{/if}

				{foreach key=key_one item=arr from=$fldvalue}
					{foreach key=sel_value item=value from=$arr}
						<option value="{$key_one}" {$value}>{$sel_value}</option>
					{/foreach}
				{/foreach}
				</select>
			</td>
		{elseif $uitype eq 51}
			{if $MODULE eq 'Accounts'}
				{assign var='popuptype' value = 'specific_account_address'}
			{elseif $MODULE eq 'Products'}
				{assign var='popuptype' value = 'inventory_mo'}
			{else}
				{assign var='popuptype' value = 'specific_contact_account_address'}
			{/if}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			{if $MODULE neq 'Products'}
			<td width="30%" align=left class="dvtCellInfo">
				<input readonly name="account_name" style="border:1px solid #bababa;" type="text" value="{$fldvalue}"><input name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img tabindex="{$vt_tab}" src="{'select.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Accounts&action=Popup&popuptype={$popuptype}&form=TasksEditView&form_submit=false&fromlink={$fromlink}","test","width=640,height=602,resizable=0,scrollbars=0");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" src="{'clear_field.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.account_id.value=''; this.form.account_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>
			{else}
				{if $RETURN_MODULE eq 'Products' && ($RETURN_ID neq '' && $RETURN_ID neq $ID)}
				<td width="30%" align=left class="dvtCellInfo">
					<input readonly name="product_name" style="border:1px solid #bababa;" type="text" value="{$RETURN_NAME}"><input name="{$fldname}" type="hidden" value="{$RETURN_ID}">&nbsp;<img tabindex="{$vt_tab}" src="{'select.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Products&return_module=Products&record_id={$ID}&action=Popup&popuptype={$popuptype}&form=TasksEditView&form_submit=false&fromlink={$fromlink}","test","width=640,height=602,resizable=0,scrollbars=0");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" src="{'clear_field.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.product_id.value=''; this.form.product_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
				</td>
				{else}
				<td width="30%" align=left class="dvtCellInfo">
					<input readonly name="product_name" style="border:1px solid #bababa;" type="text" value="{$fldvalue}"><input name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img tabindex="{$vt_tab}" src="{'select.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='if({$IS_PARENT}==0)return window.open("index.php?module=Products&return_module=Products&record_id={$ID}&action=Popup&popuptype={$popuptype}&form=TasksEditView&form_submit=false&fromlink={$fromlink}","test","width=640,height=602,resizable=0,scrollbars=0"); else alert(alert_arr.IS_PARENT);' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" src="{'clear_field.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.product_id.value=''; this.form.product_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
				</td>
				{/if}
			{/if}
		{elseif $uitype eq 50}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input readonly name="account_name" type="text" value="{$fldvalue}"><input name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{'select.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Accounts&action=Popup&popuptype=specific&form=TasksEditView&form_submit=false&fromlink={$fromlink}","test","width=640,height=602,resizable=0,scrollbars=0");' align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>
		{elseif $uitype eq 73}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input readonly name="account_name" id = "single_accountid" type="text" value="{$fldvalue}"><input name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{'select.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Accounts&action=Popup&popuptype=specific_account_address&form=TasksEditView&form_submit=false&fromlink={$fromlink}","test","width=640,height=602,resizable=0,scrollbars=0");' align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		{elseif $uitype eq 75 || $uitype eq 81}
			<td width="20%" class="dvtCellLabel" align=right>
				{if $uitype eq 81}
					{assign var="pop_type" value="specific_vendor_address"}
					{else}{assign var="pop_type" value="specific"}
				{/if}
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input name="vendor_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{'select.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Vendors&action=Popup&html=Popup_picker&popuptype={$pop_type}&form=EditView&fromlink={$fromlink}","test","width=640,height=602,resizable=0,scrollbars=0");' align="absmiddle" style='cursor:hand;cursor:pointer'>
				{if $uitype eq 75}
					&nbsp;<input type="image" tabindex="{$vt_tab}" src="{'clear_field.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.vendor_id.value='';this.form.vendor_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
				{/if}
			</td>
		{elseif $uitype eq 57}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				{if $fromlink eq 'qcreate'}
					<input name="contact_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{'select.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='selectContact("false","general",document.QcEditView)' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" tabindex="{$vt_tab}" src="{'clear_field.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.contact_id.value=''; this.form.contact_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
				{else}
					<input name="contact_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{'select.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='selectContact("false","general",document.EditView)' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" tabindex="{$vt_tab}" src="{'clear_field.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.contact_id.value=''; this.form.contact_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
				{/if}
			</td>
		
		{elseif $uitype eq 58}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
			<input name="campaignname" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{'select.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Campaigns&action=Popup&html=Popup_picker&popuptype=specific_campaign&form=EditView&fromlink={$fromlink}","test","width=640,height=602,resizable=0,scrollbars=0");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" tabindex="{$vt_tab}" src="{'clear_field.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.campaignid.value=''; this.form.campaignname.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
		
			</td>

		{elseif $uitype eq 80}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input name="salesorder_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{'select.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='selectSalesOrder();' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" tabindex="{$vt_tab}" src="{'clear_field.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.salesorder_id.value=''; this.form.salesorder_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		{elseif $uitype eq 78}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small">{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input name="quote_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input name="{$fldname}" type="hidden" value="{$secondvalue}" >&nbsp;<img src="{'select.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='selectQuote()' align="absmiddle" style='cursor:hand;cursor:pointer' >&nbsp;<input type="image" tabindex="{$vt_tab}" src="{'clear_field.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.quote_id.value=''; this.form.quote_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		{elseif $uitype eq 76}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input name="potential_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img tabindex="{$vt_tab}" src="{'select.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='selectPotential()' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" src="{'clear_field.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.potential_id.value=''; this.form.potential_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		{elseif $uitype eq 17}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				&nbsp;&nbsp;http://
			<input style="width:74%;" class = 'detailedViewTextBoxOn' type="text" tabindex="{$vt_tab}" name="{$fldname}" style="border:1px solid #bababa;" size="27" onFocus="this.className='detailedViewTextBoxOn'"onBlur="this.className='detailedViewTextBox'" onkeyup="validateUrl('{$fldname}');" value="{$fldvalue}">
			</td>

		{elseif $uitype eq 85}
            <td width="20%" class="dvtCellLabel" align=right>
                <font color="red">{$mandatory_field}</font>
                {$usefldlabel}
                {if $MASS_EDIT eq '1'}
                	<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >
                {/if}
            </td>
            <td width="30%" align=left class="dvtCellInfo">
				<img src="{'skype.gif'|@vtiger_imageurl:$THEME}" alt="Skype" title="Skype" LANGUAGE=javascript align="absmiddle"></img>
				<input class='detailedViewTextBox' type="text" tabindex="{$vt_tab}" name="{$fldname}" style="border:1px solid #bababa;" size="27" onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'" value="{$fldvalue}">
            </td>

		{elseif $uitype eq 71 || $uitype eq 72}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">				
				{if $fldname eq "unit_price" && $fromlink neq 'qcreate'}
					<span id="multiple_currencies">
						<input name="{$fldname}" id="{$fldname}" tabindex="{$vt_tab}" type="text" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'; updateUnitPrice('unit_price', '{$BASE_CURRENCY}');"  value="{$fldvalue}" style="width:60%;">
					{if $MASS_EDIT neq 1}
						&nbsp;<a href="javascript:void(0);" onclick="updateUnitPrice('unit_price', '{$BASE_CURRENCY}'); toggleShowHide('currency_class','multiple_currencies');">{$APP.LBL_MORE_CURRENCIES} &raquo;</a>
					{/if}
					</span>
					{if $MASS_EDIT neq 1}
					<div id="currency_class" class="multiCurrencyEditUI" width="350">
						<input type="hidden" name="base_currency" id="base_currency" value="{$BASE_CURRENCY}" />
						<input type="hidden" name="base_conversion_rate" id="base_currency" value="{$BASE_CURRENCY}" />
						<table width="100%" height="100%" class="small" cellpadding="5">
						<tr class="detailedViewHeader">
							<th colspan="4">
								<b>{$MOD.LBL_PRODUCT_PRICES}</b>
							</th>
							<th align="right">
								<img border="0" style="cursor: pointer;" onclick="toggleShowHide('multiple_currencies','currency_class');" src="{'close.gif'|@vtiger_imageurl:$THEME}"/>
							</th>
						</tr>
						<tr class="detailedViewHeader">
							<th>{$APP.LBL_CURRENCY}</th>
							<th>{$APP.LBL_PRICE}</th>
							<th>{$APP.LBL_CONVERSION_RATE}</th>
							<th>{$APP.LBL_RESET_PRICE}</th>							
							<th>{$APP.LBL_BASE_CURRENCY}</th>
						</tr>
						{foreach item=price key=count from=$PRICE_DETAILS}
							<tr>
								{if $price.check_value eq 1 || $price.is_basecurrency eq 1}
									{assign var=check_value value="checked"}
									{assign var=disable_value value=""}
								{else}
									{assign var=check_value value=""}
									{assign var=disable_value value="disabled=true"}
								{/if}
								
								{if $price.is_basecurrency eq 1}
									{assign var=base_cur_check value="checked"}
								{else}
									{assign var=base_cur_check value=""}
								{/if}
								
								{if $price.curname eq $BASE_CURRENCY}
									{assign var=call_js_update_func value="updateUnitPrice('$BASE_CURRENCY', 'unit_price');"}
								{else}
									{assign var=call_js_update_func value=""}
								{/if}
								
								<td align="right" class="dvtCellLabel">
									{$price.currencylabel} ({$price.currencysymbol})
									<input type="checkbox" name="cur_{$price.curid}_check" id="cur_{$price.curid}_check" class="small" onclick="fnenableDisable(this,'{$price.curid}'); updateCurrencyValue(this,'{$price.curname}','{$BASE_CURRENCY}','{$price.conversionrate}');" {$check_value}>
								</td>
								<td class="dvtCellInfo" align="left">
									<input {$disable_value} type="text" size="10" class="small" name="{$price.curname}" id="{$price.curname}" value="{$price.curvalue}" onBlur="{$call_js_update_func} fnpriceValidation('{$price.curname}');">
								</td>
								<td class="dvtCellInfo" align="left">
									<input disabled=true type="text" size="10" class="small" name="cur_conv_rate{$price.curid}" value="{$price.conversionrate}">
								</td>
								<td class="dvtCellInfo" align="center">
									<input {$disable_value} type="button" class="crmbutton small edit" id="cur_reset{$price.curid}"  onclick="updateCurrencyValue(this,'{$price.curname}','{$BASE_CURRENCY}','{$price.conversionrate}');" value="{$APP.LBL_RESET}"/>
								</td>
								<td class="dvtCellInfo">
									<input {$disable_value} type="radio" class="detailedViewTextBox" id="base_currency{$price.curid}" name="base_currency_input" value="{$price.curname}" {$base_cur_check} onchange="updateBaseCurrencyValue()" />
								</td>
							</tr>
						{/foreach}
						</table>
					</div>
					{/if}
				{else}
					<input name="{$fldname}" tabindex="{$vt_tab}" type="text" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'"  value="{$fldvalue}">
				{/if}
			</td>

		{elseif $uitype eq 56}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			
			{if $fldname eq 'formejuridique' && $MODULE eq 'Tiers'}
					<td width="30%" align=left class="dvtCellInfo">
				{html_checkboxes name='id' options=$FORMESJURIDIQUES
					selected=$customer_id separator='<br />'}
					</td>
					
			{elseif $fldname eq 'notime' && $ACTIVITY_MODE eq 'Events'}
				{if $fldvalue eq 1}
					<td width="30%" align=left class="dvtCellInfo">
						<input name="{$fldname}" type="checkbox" tabindex="{$vt_tab}" onclick="toggleTime()" checked>
					</td>
				{else}
					<td width="30%" align=left class="dvtCellInfo">
						<input name="{$fldname}" tabindex="{$vt_tab}" type="checkbox" onclick="toggleTime()" >
					</td>
				{/if}
			<!-- For Portal Information we need a hidden field existing_portal with the current portal value -->
			{elseif $fldname eq 'portal'}
				<td width="30%" align=left class="dvtCellInfo">
					<input type="hidden" name="existing_portal" value="{$fldvalue}">
					<input name="{$fldname}" type="checkbox" tabindex="{$vt_tab}" {if $fldvalue eq 1}checked{/if}>
				</td>
			{else}
				{if $fldvalue eq 1}
					<td width="30%" align=left class="dvtCellInfo">
						<input name="{$fldname}" type="checkbox" tabindex="{$vt_tab}" checked>
					</td>
				{elseif $fldname eq 'filestatus'&& $MODE eq 'create'}
					<td width="30%" align=left class="dvtCellInfo">
						<input name="{$fldname}" type="checkbox" tabindex="{$vt_tab}" checked>
					</td>
				{else}
					<td width="30%" align=left class="dvtCellInfo">
						<input name="{$fldname}" tabindex="{$vt_tab}" type="checkbox" {if ( $PROD_MODE eq 'create' &&  $fldname|substr:0:3 neq 'cf_') ||( $fldname|substr:0:3 neq 'cf_' && $PRICE_BOOK_MODE eq 'create' ) || $USER_MODE eq 'create'}checked{/if}>
					</td>
				{/if}
			{/if}
		{elseif $uitype eq 23 || $uitype eq 5 || $uitype eq 6}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				{foreach key=date_value item=time_value from=$fldvalue}
					{assign var=date_val value="$date_value"}
					{assign var=time_val value="$time_value"}
				{/foreach}
				
				{if ($fldname eq 'datenaissance'  || $fldname eq 'enfant1datenaissance'  || $fldname eq 'enfant2datenaissance'  || $fldname eq 'enfant3datenaissance'  || $fldname eq 'enfant4datenaissance'  || $fldname eq 'enfant5datenaissance'  || $fldname eq 'enfant6datenaissance'  ||
					$fldname eq 'contdatedebut' ||  $fldname eq 'contdatefin' ||  $fldname eq 'contdateembauche' ||  $fldname eq 'contdateanciennete' ||  $fldname eq 'contdatedepart') && $MODULE eq 'Agentuemoa'}
				<input name="{$fldname}" tabindex="{$vt_tab}" id="jscal_field_{$fldname}" type="text" readonly="true" style="border:1px solid #bababa; background-color : #cccccc;" size="11" maxlength="10" value="{$date_val}">

				{else}
				<input name="{$fldname}" tabindex="{$vt_tab}" id="jscal_field_{$fldname}" type="text" style="border:1px solid #bababa;" size="11" maxlength="10" value="{$date_val}">
				<img src="{'btnL3Calendar.gif'|@vtiger_imageurl:$THEME}" id="jscal_trigger_{$fldname}">
				{/if}
				
				{if $uitype eq 6}
					<input name="time_start" id="time_start" tabindex="{$vt_tab}" style="border:1px solid #bababa;" size="5" maxlength="5" type="text" value="{$time_val}">
				{/if}

				{foreach key=date_format item=date_str from=$secondvalue}
					{assign var=dateFormat value="$date_format"}
					{assign var=dateStr value="$date_str"}
				{/foreach}
				
				{if ($uitype eq 5 || $uitype eq 23)}
					{assign var=dateFormat value="%d-%m-%Y"}
					{assign var=dateStr value="jj-mm-aaaa"}
				{/if}
				{if $uitype eq 23  && $CATEGORY eq 'Conventions'}
					{assign var=dateFormat value="%d-%m-%Y"}
					{assign var=dateStr value="jj-mm-aaaa"}
				{/if}
				{if $uitype eq 23  && $CATEGORY eq 'ExecutionConventions'}
					{assign var=dateFormat value="%d-%m-%Y"}
					{assign var=dateStr value="jj-mm-aaaa"}
				{/if}
					{if $uitype eq 23  && $CATEGORY eq 'TraitementConventions'}
					{assign var=dateFormat value="%d-%m-%Y"}
					{assign var=dateStr value="jj-mm-aaaa"}
				{/if}
					{if $uitype eq 23  && ( $CATEGORY eq 'PHVInfos' || $MODULE eq 'PHVInfos')}
					{assign var=dateFormat value="%d-%m-%Y"}
					{assign var=dateStr value="jj-mm-aaaa"}
				{/if}
					{if $uitype eq 23  && ($MODULE eq 'Agentuemoa')}
					{assign var=dateFormat value="%d-%m-%Y"}
					{assign var=dateStr value="jj-mm-aaaa"}
				{/if}
				{if $uitype eq 23  && ($MODULE eq 'Candidats')}
					{assign var=dateFormat value="%d-%m-%Y"}
					{assign var=dateStr value="jj-mm-aaaa"}
				{/if}
					{if $uitype eq 23  && ($MODULE eq 'OrdresMission' || $MODULE eq 'Demandes')}
					{assign var=dateFormat value="%d-%m-%Y"}
					{assign var=dateStr value="jj-mm-aaaa"}
				{/if}
				{if $uitype eq 6  && ( $CATEGORY eq 'Incidents' || $CATEGORY eq 'Conventions' )}
					{assign var=dateFormat value="%d-%m-%Y"}
					{*assign var=dateStr value="jj-mm-aaaa"*}
				{/if}
				
				{if $uitype eq 5 || $uitype eq 23}
					{if $CATEGORY neq 'Demandes'}
						<br><font size=1><em old="(yyyy-mm-dd)">({$dateStr})</em></font>
					{/if}
				{else}
					<br><font size=1><em old="(yyyy-mm-dd)">({$dateStr})</em></font>
				{/if}

				<script type="text/javascript" id='massedit_calendar_{$fldname}'>
					Calendar.setup ({ldelim}
						inputField : "jscal_field_{$fldname}", ifFormat : "{$dateFormat}", showsTime : false, button : "jscal_trigger_{$fldname}", singleClick : true, step : 1
					{rdelim})
				</script>


			</td>

		{elseif $uitype eq 63}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input name="{$fldname}" type="text" size="2" value="{$fldvalue}" tabindex="{$vt_tab}" >&nbsp;
				<select name="duration_minutes" tabindex="{$vt_tab}" class="small">
					{foreach key=labelval item=selectval from=$secondvalue}
						<option value="{$labelval}" {$selectval}>{$labelval}</option>
					{/foreach}
				</select>

		{elseif $uitype eq 68 || $uitype eq 66 || $uitype eq 62}
			<td width="20%" class="dvtCellLabel" align=right>
				{if $fromlink eq 'qcreate'}
					<select class="small" name="parent_type" onChange='document.QcEditView.parent_name.value=""; document.QcEditView.parent_id.value=""'>
				{else}
					<select class="small" name="parent_type" onChange='document.EditView.parent_name.value=""; document.EditView.parent_id.value=""'>
				{/if}
					{section name=combo loop=$fldlabel}
						<option value="{$fldlabel_combo[combo]}" {$fldlabel_sel[combo]}>{$fldlabel[combo]} </option>
					{/section}
				</select>
				{if $MASS_EDIT eq '1'}<input type="checkbox" name="parent_id_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}			
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input name="{$fldname}" type="hidden" value="{$secondvalue}">
				<input name="parent_name" readonly id = "parentid" type="text" style="border:1px solid #bababa;" value="{$fldvalue}">
				&nbsp;
				{if $fromlink eq 'qcreate'}
					<img src="{'select.gif'|@vtiger_imageurl:$THEME}" tabindex="{$vt_tab}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module="+ document.QcEditView.parent_type.value +"&action=Popup&html=Popup_picker&form=HelpDeskEditView&fromlink={$fromlink}","test","width=640,height=602,resizable=0,scrollbars=0,top=150,left=200");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" src="{'clear_field.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.parent_id.value=''; this.form.parent_name.value=''; return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
				{else}
					<img src="{'select.gif'|@vtiger_imageurl:$THEME}" tabindex="{$vt_tab}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module="+ document.EditView.parent_type.value +"&action=Popup&html=Popup_picker&form=HelpDeskEditView&fromlink={$fromlink}","test","width=640,height=602,resizable=0,scrollbars=0,top=150,left=200");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" src="{'clear_field.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.parent_id.value=''; this.form.parent_name.value=''; return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
					{/if}
			</td>

		{elseif $uitype eq 357}
			<td width="20%" class="dvtCellLabel" align=right>To:&nbsp;</td>
			<td width="90%" colspan="3">
				<input name="{$fldname}" type="hidden" value="{$secondvalue}">
				<textarea readonly name="parent_name" cols="70" rows="2">{$fldvalue}</textarea>&nbsp;
				<select name="parent_type" class="small">
					{foreach key=labelval item=selectval from=$fldlabel}
						<option value="{$labelval}" {$selectval}>{$labelval}</option>
					{/foreach}
				</select>
				&nbsp;
				{if $fromlink eq 'qcreate'}
					<img tabindex="{$vt_tab}" src="{'select.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module="+ document.QcEditView.parent_type.value +"&action=Popup&html=Popup_picker&form=HelpDeskEditView&fromlink={$fromlink}","test","width=640,height=602,resizable=0,scrollbars=0,top=150,left=200");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" src="{'clear_field.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.parent_id.value=''; this.form.parent_name.value=''; return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
				{else}
					<img tabindex="{$vt_tab}" src="{'select.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module="+ document.EditView.parent_type.value +"&action=Popup&html=Popup_picker&form=HelpDeskEditView&fromlink={$fromlink}","test","width=640,height=602,resizable=0,scrollbars=0,top=150,left=200");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" src="{'clear_field.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.parent_id.value=''; this.form.parent_name.value=''; return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
				{/if}
			</td>
		   <tr style="height:25px">
			<td width="20%" class="dvtCellLabel" align=right>CC:&nbsp;</td>	
			<td width="30%" align=left class="dvtCellInfo">
				<input name="ccmail" type="text" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'"  value="">
			</td>
			<td width="20%" class="dvtCellLabel" align=right>BCC:&nbsp;</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input name="bccmail" type="text" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'"  value="">
			</td>
		   </tr>

		{elseif $uitype eq 59}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input name="{$fldname}" type="hidden" value="{$secondvalue}">
				<input name="product_name" readonly type="text" value="{$fldvalue}">&nbsp;<img tabindex="{$vt_tab}" src="{'select.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Products&action=Popup&html=Popup_picker&form=HelpDeskEditView&popuptype=specific&fromlink={$fromlink}","test","width=640,height=602,resizable=0,scrollbars=0,top=150,left=200");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" src="{'clear_field.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.product_id.value=''; this.form.product_name.value=''; return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		{elseif $uitype eq 55 || $uitype eq 255} 
			{if $uitype eq 55}
				<td width="20%" class="dvtCellLabel" align=right>{$usefldlabel} {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}</td>
			{elseif $uitype eq 255}	
				<td width="20%" class="dvtCellLabel" align=right>{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}</td>
			{/if}
			<td width="30%" align=left class="dvtCellInfo">
			{if $fldvalue neq ''}
			<select name="salutationtype" class="small">
				{foreach item=arr from=$fldvalue}
						<option value="{$arr[1]}" {$arr[2]}>
                                                	{$arr[0]}
                                                </option>
				{/foreach}
			</select>
			{/if}
			<input type="text" name="{$fldname}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'" style="width:58%;" value= "{$secondvalue}" >
			</td>

		{elseif $uitype eq 22}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<textarea name="{$fldname}" cols="30" tabindex="{$vt_tab}" rows="2">{$fldvalue}</textarea>
			</td>

		{elseif $uitype eq 69}
		
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font>
				{if $MASS_EDIT eq '1'}
					<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small"  >
				{/if}
			</td>
			<td colspan="3" width="30%" align=left class="dvtCellInfo">
				{if $MODULE eq 'Products' || $MODULE eq 'Demandes'}
					<input name="del_file_list" type="hidden" value="">
					<div id="files_list" style="border: 1px solid grey; width: 500px; padding: 5px; background: rgb(255, 255, 255) none repeat scroll 0%; -moz-background-clip: initial; -moz-background-origin: initial; -moz-background-inline-policy: initial; font-size: x-small">{$APP.Files_Maximum_6}
						<input id="my_file_element" type="file" name="file_1" tabindex="{$vt_tab}"  onchange="validateFilename(this)"/>
						{assign var=image_count value=0}
						{if $maindata[3].0.name neq '' && $DUPLICATE neq 'true'}
						   {foreach name=image_loop key=num item=image_details from=$maindata[3]}
							<div align="center">
								<img src="{$image_details.path}{$image_details.name}" height="50">&nbsp;&nbsp;[{$image_details.orgname}]<input id="file_{$num}" value="Delete" type="button" class="crmbutton small delete" onclick='this.parentNode.parentNode.removeChild(this.parentNode);delRowEmt("{$image_details.orgname}")'>
							</div>
					   	   {assign var=image_count value=$smarty.foreach.image_loop.iteration}
					   	   {/foreach}
						{/if}
					</div>

					<script>
						{*<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->*}
						var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 6 );
						multi_selector.count = {$image_count}
						{*<!-- Pass in the file element -->*}
						multi_selector.addElement( document.getElementById( 'my_file_element' ) );
					</script>
				{else}
					<input name="{$fldname}"  type="file" value="{$maindata[3].0.name}" tabindex="{$vt_tab}" onchange="validateFilename(this);" />
					<input name="{$fldname}_hidden"  type="hidden" value="{$maindata[3].0.name}" />
					<input type="hidden" name="id" value=""/>
					{if $maindata[3].0.name != "" && $DUPLICATE neq 'true'}
						<div id="replaceimage">[{$maindata[3].0.orgname}] <a href="javascript:;" onClick="delimage({$ID})">Del</a></div>
					{/if}
				{/if}
			</td>
          
		{elseif $uitype eq 61}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font>
				{if $MASS_EDIT eq '1'}
					<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small"  disabled >
				{/if}
			</td>

			<td colspan="1" width="30%" align=left class="dvtCellInfo">
				{*<input name="{$fldname}"  class="detailedViewTextBox"  type="file" value="{$secondvalue}" tabindex="{$vt_tab}" onchange="validateFilename(this)"/><br>*}
				<input name="{$fldname}[]"  class="detailedViewTextBox" multiple="multiple" type="file" value="{$secondvalue}" tabindex="{$vt_tab}" onchange="validateFilename(this)"/><br>
				<input type="hidden" name="{$fldname}_hidden" value="{$secondvalue}"/>
				<input type="hidden" name="id" value=""/>{$fldvalue}
				<ul id="fileList"></ul>
			</td>
		{elseif $uitype eq 156}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
				{if $fldvalue eq 'on'}
					<td width="30%" align=left class="dvtCellInfo">
						{if ($secondvalue eq 1 && $CURRENT_USERID != $smarty.request.record) || ($MODE == 'create')}
							<input name="{$fldname}" tabindex="{$vt_tab}" type="checkbox" checked>
						{else}
							<input name="{$fldname}" type="hidden" value="on">
							<input name="{$fldname}" disabled tabindex="{$vt_tab}" type="checkbox" checked>
						{/if}	
					</td>
				{else}
					<td width="30%" align=left class="dvtCellInfo">
						{if ($secondvalue eq 1 && $CURRENT_USERID != $smarty.request.record) || ($MODE == 'create')}
							<input name="{$fldname}" tabindex="{$vt_tab}" type="checkbox">
						{else}
							<input name="{$fldname}" disabled tabindex="{$vt_tab}" type="checkbox">
						{/if}	
					</td>
				{/if}
		{elseif $uitype eq 98}<!-- Role Selection Popup -->		
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
			{if $thirdvalue eq 1}
				<input name="role_name" id="role_name" readonly class="txtBox" tabindex="{$vt_tab}" value="{$secondvalue}" type="text">&nbsp;
				<a href="javascript:openPopup();"><img src="{'select.gif'|@vtiger_imageurl:$THEME}" align="absmiddle" border="0"></a>
			{else}	
				<input name="role_name" id="role_name" tabindex="{$vt_tab}" class="txtBox" readonly value="{$secondvalue}" type="text">&nbsp;
			{/if}	
			<input name="user_role" id="user_role" value="{$fldvalue}" type="hidden">
			</td>
		{elseif $uitype eq 104}<!-- Mandatory Email Fields -->			
			 <td width=20% class="dvtCellLabel" align=right>
			{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			 </td>
    	     <td width=30% align=left class="dvtCellInfo"><input type="text" name="{$fldname}" id ="{$fldname}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'"></td>
			{elseif $uitype eq 115}<!-- for Status field Disabled for nonadmin -->
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
			   <!--
			   {if $secondvalue eq 1 && $CURRENT_USERID != $smarty.request.record}
			   	<select id="user_status" name="{$fldname}" tabindex="{$vt_tab}" class="small">
			   {else}
			   	<select id="user_status" disabled name="{$fldname}" class="small">
			   {/if}
				-->
				<select id="user_status" disabled name="{$fldname}" class="small">
				{foreach item=arr from=$fldvalue}
                                        <option value="{$arr[1]}" {$arr[2]} >
                                                {$arr[0]}
                                        </option>
				{/foreach}
			   </select>
			</td>
			{elseif $uitype eq 105}
			
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				{if $MODE eq 'edit' && $IMAGENAME neq ''}
					<input name="{$fldname}"  type="file" value="{$maindata[3].0.name}" tabindex="{$vt_tab}" onchange="validateFilename(this);" />[{$IMAGENAME}]<br>{$APP.LBL_IMG_FORMATS}
					<input name="{$fldname}_hidden"  type="hidden" value="{$maindata[3].0.name}" />
				{else}
					<input name="{$fldname}"  type="file" value="{$maindata[3].0.name}" tabindex="{$vt_tab}" onchange="validateFilename(this);" /><br>{$APP.LBL_IMG_FORMATS}
					<input name="{$fldname}_hidden"  type="hidden" value="{$maindata[3].0.name}" />
				{/if}
					<input type="hidden" name="id" value=""/>
					{$maindata[3].0.name}
			</td>
			{elseif $uitype eq 103}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" colspan="3" align=left class="dvtCellInfo">
				<input type="text" name="{$fldname}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
			</td>	
			{elseif $uitype eq 101}<!-- for reportsto field USERS POPUP -->
				<td width="20%" class="dvtCellLabel" align=right>
			      {$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
	            </td>
				<td width="30%" align=left class="dvtCellInfo">
					<input readonly name='reports_to_name' class="small" type="text" value='{$fldvalue}' tabindex="{$vt_tab}" >
					<input name='reports_to_id' type="hidden" value='{$secondvalue}'>
					&nbsp;<input  type="button" class="small" value='{$APP.LBL_CHANGE}' name=btn1 LANGUAGE=javascript onclick='return window.open("index.php?module=Users&action=Popup&form=UsersEditView&form_submit=false&fromlink={$fromlink}","test","width=640,height=603,resizable=0,scrollbars=0");'>
				</td>
			
			{elseif $uitype eq 300}<!-- for reportsto field USERS POPUP -->
				<td width="20%" class="dvtCellLabel" align=right>
			      {$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
	            </td>
				<td width="30%" align=left class="dvtCellInfo">
					<input readonly name="{$fldname}" id="{$fldname}" class="small" type="text" value='{$fldvalue}' tabindex="{$vt_tab}" >
					&nbsp;<input  type="button" class="small" value='{$APP.LBL_CHANGE}' name=btn1 LANGUAGE=javascript onclick='return window.open("index.php?module=Users&action=Popup&form=UsersEditView&form_submit=false&fromlink={$fromlink}&fldname={$fldname}","test","width=640,height=603,resizable=0,scrollbars=0");'>
					<input type="image" src="{'clear_field.gif'|@vtiger_imageurl:$THEME}" alt="Effacer" title="Effacer" LANGUAGE=javascript	onClick="this.form.{$fldname}.value=''; this.form.onsubmit='false'; return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;
					<input name='{$fldname}_id' type="hidden">
		        </td>
			
			{elseif $uitype eq 116 || $uitype eq 117}<!-- for currency in users details-->	
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
			   {if $secondvalue eq 1 || $uitype eq 117}
			   	<select name="{$fldname}" tabindex="{$vt_tab}" class="small">
			   {else}
			   	<select disabled name="{$fldname}" tabindex="{$vt_tab}" class="small">
			   {/if} 

				{foreach item=arr key=uivalueid from=$fldvalue}
					{foreach key=sel_value item=value from=$arr}
						<option value="{$uivalueid}" {$value}>{$sel_value}</option>
						<!-- code added to pass Currency field value, if Disabled for nonadmin -->
						{if $value eq 'selected' && $secondvalue neq 1}
							{assign var="curr_stat" value="$uivalueid"}
						{/if}
						<!--code ends -->
					{/foreach}
				{/foreach}
			   </select>
			<!-- code added to pass Currency field value, if Disabled for nonadmin -->
			{if $curr_stat neq '' && $uitype neq 117}
				<input name="{$fldname}" type="hidden" value="{$curr_stat}">
			{/if}
			<!--code ends -->
			</td>
			{elseif $uitype eq 106}
			<td width=20% class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width=30% align=left class="dvtCellInfo">
				{if $MODE eq 'edit'}
				<input type="text" readonly name="{$fldname}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				{else}
				<input type="text" name="{$fldname}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				{/if}
			</td>
			{elseif $uitype eq 99}
				{if $MODE eq 'create'}
				<td width=20% class="dvtCellLabel" align=right>
					{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
				</td>
				<td width=30% align=left class="dvtCellInfo">
					<input type="password" name="{$fldname}" tabindex="{$vt_tab}" value="{$fldvalue}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td>
				{/if}
		{elseif $uitype eq 30}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td colspan="3" width="30%" align=left class="dvtCellInfo">
				{assign var=check value=$secondvalue[0]}
				{assign var=yes_val value=$secondvalue[1]}
				{assign var=no_val value=$secondvalue[2]}

				<input type="radio" name="set_reminder" tabindex="{$vt_tab}" value="Yes" {$check}>&nbsp;{$yes_val}&nbsp;
				<input type="radio" name="set_reminder" value="No">&nbsp;{$no_val}&nbsp;

				{foreach item=val_arr from=$fldvalue}
					{assign var=start value="$val_arr[0]"}
					{assign var=end value="$val_arr[1]"}
					{assign var=sendname value="$val_arr[2]"}
					{assign var=disp_text value="$val_arr[3]"}
					{assign var=sel_val value="$val_arr[4]"}
					<select name="{$sendname}" class="small">
						{section name=reminder start=$start max=$end loop=$end step=1 }
							{if $smarty.section.reminder.index eq $sel_val}
								{assign var=sel_value value="SELECTED"}
							{else}
								{assign var=sel_value value=""}
							{/if}
							<OPTION VALUE="{$smarty.section.reminder.index}" "{$sel_value}">{$smarty.section.reminder.index}</OPTION>
						{/section}
					</select>
					&nbsp;{$disp_text}
				{/foreach}
			</td>
		{elseif $uitype eq 31}
			<td width="20%" class="dvtCellLabel" align=right>
				{$usefldlabel}<font color="red">{$mandatory_field}</font> {if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				

				<input type="radio" name="typeconvention" tabindex="{$vt_tab}" value="Convention" checked>&nbsp;Convention&nbsp;
				<input type="radio" name="typeconvention" value="Bonification">&nbsp;Bonification&nbsp;
			</td>	
		{elseif $uitype eq 26}
		<td width="20%" class="dvtCellLabel" align=right>
		<font color="red">{$mandatory_field}</font>{$fldlabel}
		{if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}_mass_edit_check" id="{$fldname}_mass_edit_check" class="small" >{/if}
		</td>
		<td width="30%" align=left class="dvtCellInfo">
			<select name="{$fldname}" tabindex="{$vt_tab}" class="small">
				{foreach item=v key=k from=$fldvalue}	 
				<option value="{$k}">{$v}</option> 
				{/foreach}
			</select>
		</td>
		{elseif $uitype eq 27}
			<td width=20% class="dvtCellLabel" align=right >
				{$fldlabel_other}&nbsp;
				<!--
				<select class="small" name="{$fldname}_locationtype" onchange='changeDldType(this);'>
					{section name=combo loop=$fldlabel}
						<option value="{$fldlabel_combo[combo]}" {$fldlabel_sel[combo]} >{$fldlabel[combo]} </option>
					{/section}
				</select>
				-->
				{if $MASS_EDIT eq '1'}<input type="checkbox" name="{$fldname}" id="{$fldname}_mass_edit_check" class="small" >{/if}			
			</td>
		
		  {assign var=check value=1}
				{foreach key=key_one item=arr from=$fldvalue}
					{foreach key=sel_value item=value from=$arr}
						{if $value eq 'I'}
							{assign var=check value=$check*0}
						{else}
							{assign var=check value=$check*1}
						{/if}
					{/foreach}
				{/foreach}
				
				{if $check eq 1}
					{assign var=internalfilename value='display:none'}
					{assign var=externalfilename value='display:block'}
				{else}
					{assign var=internalfilename value='display:block'}
					{assign var=externalfilename value='display:none'}
				{/if}
		  <td width="30%" align=left class="dvtCellInfo">
		 <!-- <div id="internal"  style="{$internalfilename}" >
		   <input type="file" name="{$fldname}" class="detailedViewTextBox" onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'" value="{$secondvalue}">{if $secondvalue neq '' && $value neq 'E'}[{$secondvalue}]{/if}<br>
		  </div>
		  
		  <div id="external" class"dvtCellLabel"  style="{$externalfilename}" >
		  <input type="text" name="{$fldname}" class="detailedViewTextBox" onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'" value="{if $value eq 'E'}{$secondvalue}{/if}"><br>
		  </div>
		  -->
		  </td>
		{elseif $uitype eq 83} <!-- Handle the Tax in Inventory -->
			{foreach item=tax key=count from=$TAX_DETAILS}
				{if $tax.check_value eq 1}
					{assign var=check_value value="checked"}
					{assign var=show_value value="visible"}
				{else}
					{assign var=check_value value=""}
					{assign var=show_value value="hidden"}
				{/if}
				<td align="right" class="dvtCellLabel" style="border:0px solid red;">
					{$tax.taxlabel} {$APP.COVERED_PERCENTAGE}
					<input type="checkbox" name="{$tax.check_name}" id="{$tax.check_name}" class="small" onclick="fnshowHide(this,'{$tax.taxname}')" {$check_value}>
				</td>
				<td class="dvtCellInfo" align="left" style="border:0px solid red;">
					<input type="text" class="detailedViewTextBox" name="{$tax.taxname}" id="{$tax.taxname}" value="{$tax.percentage}" style="visibility:{$show_value};" onBlur="fntaxValidation('{$tax.taxname}')">
				</td>
			   </tr>
			{/foreach}

			<td colspan="2" class="dvtCellInfo">&nbsp;</font></td>
		{/if}
		