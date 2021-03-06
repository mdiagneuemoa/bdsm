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
<script language="javascript" type="text/javascript" src="modules/Home/homeajax.js"></script>
<script language="javascript" type="text/javascript" src="modules/Home/Homestuff.js"></script>
<script language="javascript" type="text/javascript" src="include/scriptaculous/prototype.js"></script>
<script language="javascript" type="text/javascript" src="include/scriptaculous/scriptaculous.js"></script>
<script language="javascript" type="text/javascript" src="include/scriptaculous/unittest.js"></script>
<script language="javascript" type="text/javascript" src="include/js/notebook.js"></script>

<input id="homeLayout" type="hidden" value="{$LAYOUT}">
{*<!--Home Page Entries  -->*}

{include file="Home/HomeButtons.tpl"}
<div id="vtbusy_homeinfo" style="display:none;">
	<img src="{'vtbusy.gif'|@vtiger_imageurl:$THEME}" border="0">
</div>

{*<!-- Main Contents Start Here -->*}
<table width="97%" class="small showPanelBg" cellpadding="0" cellspacing="0" border="0" align="center" valign="top">
<tr>
	<td width="100%" align="center" valign="top" height="300" >
		<div id="MainMatrix" class="show_tab topMarginHomepage" style="padding:0px;width:100%">
			
			<form name="EditView" method="POST" action="index.php">
				
				<input type="hidden" name="module" value="{$MODULE}">
				<input type="hidden" name="action" value="index">
				<input type="hidden" name="parenttab" value="{$CATEGORY}">

				{foreach item=tablestuff from=$HOMEFRAME name="homeframe"}
					{*<!-- create divs for each widget - the contents will be loaded dynamically from javascript -->*}
					{include file="Home/MainHomeBlock.tpl"}
					
					<script>
						{*<!-- load contents for the widget-->*}
						{if $tablestuff.Stufftype eq 'Default' && $tablestuff.Stufftitle eq 'Home Page Dashboard'}
							fetch_homeDB({$tablestuff.Stuffid});
						{else}
							loadStuff({$tablestuff.Stuffid},'{$tablestuff.Stufftype}');
						{/if}
					</script>
				{/foreach}
			
			</form>
			
		</div>
	</td>
</tr>
	
</table>
	
{*<!-- Main Contents Ends Here -->*}
<script>
{literal}
initHomePage();

/**
 * this function is used to display the add window for different dashboard widgets
 */
function fnAddWindow(obj,CurrObj){
	var tagName = document.getElementById(CurrObj);
	var left_Side = findPosX(obj);
	var top_Side = findPosY(obj);
	tagName.style.left= left_Side + 2 + 'px';
	tagName.style.top= top_Side + 22 + 'px';
	tagName.style.display = 'block';
	document.getElementById("addmodule").href="javascript:chooseType('Module');fnRemoveWindow();setFilter($('selmodule_id'))";
	document.getElementById("addNotebook").href="javascript:chooseType('Notebook');fnRemoveWindow();show('addWidgetsDiv');placeAtCenter($('addWidgetsDiv'));";
	//document.getElementById("addURL").href="javascript:chooseType('URL');fnRemoveWindow();show('addWidgetsDiv');placeAtCenter($('addWidgetsDiv'));";
{/literal}
{if $ALLOW_RSS eq "yes"}
	document.getElementById("addrss").href="javascript:chooseType('RSS');fnRemoveWindow();show('addWidgetsDiv');placeAtCenter($('addWidgetsDiv'));";
{/if}
{if $ALLOW_DASH eq "yes"}
	document.getElementById("adddash").href="javascript:chooseType('DashBoard');fnRemoveWindow()";
{/if}
{literal}	
}
{/literal}	
</script>


