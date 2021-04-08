
{if $smarty.request.ajax neq ''}
&#&#&#{$ERROR}&#&#&#
{/if}

<form name="massdelete" method="POST" id="massdelete">
     <input name='search_url' id="search_url" type='hidden' value='{$SEARCH_URL}'>
     <input name="idlist" id="idlist" type="hidden">
     <input name="change_owner" type="hidden">
     <input name="change_status" type="hidden">
     <input name="action" type="hidden">
     
    <input type="hidden" name="module" value="{$MODULE}">
	<input type="hidden" name="mode" value="add">
     
     <input name="where_export" type="hidden" value="{php} echo to_html($_SESSION['export_where']);{/php}">
     <input name="step" type="hidden">
     <input name="allids" type="hidden" id="allids" value="{$ALLIDS}">
     <input name="selectedboxes" id="selectedboxes" type="hidden" value="{$SELECTEDIDS}">
     <input name="allselectedboxes" id="allselectedboxes" type="hidden" value="{$ALLSELECTEDIDS}">
     <input name="allProfileSelectedBoxes" id="allProfileSelectedBoxes" type="hidden" value="{$ALLPROFILESELECTEDIDS}">
     <input name="current_page_boxes" id="current_page_boxes" type="hidden" value="{$CURRENT_PAGE_BOXES}">

				<table border=0 cellspacing=1 cellpadding=0 width=100% class="lvtBg">
				<tr>
				<td>

		        <table border=0 cellspacing=0 cellpadding=2 width=100% class="small">
			    <tr>

				<td style="padding-right:20px" class="small" nowrap><span class="lvtHeaderText">{$MOD.LBL_CREATION_USERS}</span></td>
				<td style="padding-right:20px" class="small" nowrap>{$RECORD_COUNTS}</td>

		        <td nowrap >
					<table border=0 cellspacing=0 cellpadding=0 class="small">
					     <tr>{$NAVIGATION}</tr>
					</table>
                </td>
				<td width=100% align="right">

				   
				   {if $HIDE_CUSTOM_LINKS neq '1'}
					<table border=0 cellspacing=0 cellpadding=0 class="small">
					<tr>
						<td>{$APP.LBL_VIEW}</td>
						<td style="padding-left:5px;padding-right:5px">
                            <SELECT NAME="viewname" disabled id="viewname" class="small" onchange="showDefaultCustomView(this,'{$MODULE}','{$CATEGORY}')">{$CUSTOMVIEW_OPTION}</SELECT></td>

					</tr>
					</table> 

				   {/if}

				</td>	
       		    </tr>
			</table>
			<div>
			<table border=0 cellspacing=1 cellpadding=3 width=100% class="lvt small">

			<tr>
           
		   <td class="lvtCol"><input type="checkbox"  name="selectall" onClick=toggleSelect_ListView(this.checked,"selected_id")></td>
			
			{foreach name="listviewforeach" item=header from=$LISTHEADER}
 			<td class="lvtCol">{$header}</td>
				{/foreach}
			</tr>

			{foreach item=entity key=entity_id from=$LISTENTITY}
			<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
			
			<td width="2%"><input type="checkbox" NAME="selected_id" id="{$entity_id}" value= '{$entity_id}' onClick="check_object(this)"></td>
		
			{foreach item=data from=$entity}	
			<td>{$data}</td>
	        {/foreach}
			</tr>
			
			
			
			     {/foreach}
			     
			     
			     
			     
			 </table>
			 
			 
			 </div>
			 
			 <table border=0 cellspacing=0 cellpadding=2 width=100%>

				 <td style="padding-right:20px" class="small" nowrap>{$RECORD_COUNTS}</td>
				 <td nowrap >
				    <table border=0 cellspacing=0 cellpadding=0 class="small">
				         <tr>{$NAVIGATION}</tr>
				     </table>
				 </td>

			      </tr>
       		    </table>
		       </td>
		   </tr>
	    </table>

			 <table border=0 cellspacing=0 cellpadding=2 width=100%>
			      <tr>
					 <td style="padding-right:20px" nowrap align=center>
				      	<input class="crmbutton small save" type="submit" value="{$MOD.LBL_AJOUTER_UTILISATEURS}"  onclick="this.form.action.value='Save';return getUserChecked();"/>
				     </td>
				  </tr>
			</table>

			<br/>
		
   </form>	
{$SELECT_SCRIPT}
<div id="basicsearchcolumns" style="display:none;"><select name="search_field" id="bas_searchfield" class="txtBox" style="width:150px">{html_options  options=$SEARCHLISTHEADER}</select></div>
