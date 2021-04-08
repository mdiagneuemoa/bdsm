
{*<!-- this file displays a widget div - the contents of the div are loaded later usnig javascript -->*}

<div id="stuff_{$tablestuff.Stuffid}" class="MatrixLayer twoColumnWidget" style="float:left;overflow-x:hidden;overflow-y:auto;" >
	<table width="100%" cellpadding="0"  cellspacing="0" class="small" style="padding-right:0px;padding-left:0px;padding-top:0px;" >
		<tr id="headerrow_{$tablestuff.Stuffid}" class="headerrow">
		
		{if $MOD[$tablestuff.Stufftitle] neq ""}
					
			{*if (($CURRENT_USER_IS_ADMIN eq 'on' || $CURRENT_USER_PROFIL_ID eq 20 || $CURRENT_USER_IS_TRAITEUR_DEMANDE neq 0) && $tablestuff.Stufftitle eq 'Demandes_a_traiter')}
				{assign var="stitle" value=$MOD.Demandes_a_traiter}
				{assign var="nbElement" value=$RECORD_COUNT_DEMANDE}
				{assign var="totalElement" value=$TOTAL_RECORD_COUNT_DEMANDE}
				{assign var="checkVal" value=$DEMANDES_VIEW_ALL_CHECKED}
				
			{elseif (($CURRENT_USER_IS_ADMIN eq 'on' || $CURRENT_USER_PROFIL_ID eq 20 || $CURRENT_USER_IS_TRAITEUR_INCIDENT neq 0) && $tablestuff.Stufftitle eq 'Incidents_a_traiter')}
				{assign var="stitle" value=$MOD.Incidents_a_traiter}
				{assign var="nbElement" value=$RECORD_COUNT_INCIDENT}
				{assign var="totalElement" value=$TOTAL_RECORD_COUNT_INCIDENT}
				{assign var="checkVal" value=$INCIDENTS_VIEW_ALL_CHECKED}
				
			{elseif (($CURRENT_USER_IS_ADMIN eq 'on' || $CURRENT_USER_PROFIL_ID eq 20 || $CURRENT_USER_IS_POSTEUR_DEMANDE neq 0) && $tablestuff.Stufftitle eq 'Demandes_a_traiter')}
				{assign var="stitle" value=$MOD.Demandes_a_suivre}
				{assign var="nbElement" value=$RECORD_COUNT_DEMANDE}
				{assign var="totalElement" value=$TOTAL_RECORD_COUNT_DEMANDE}
				{assign var="checkVal" value=$DEMANDES_VIEW_ALL_CHECKED}
				
			{elseif (($CURRENT_USER_IS_ADMIN eq 'on' || $CURRENT_USER_PROFIL_ID eq 20 || $CURRENT_USER_IS_POSTEUR_INCIDENT neq 0) && $tablestuff.Stufftitle eq 'Incidents_a_traiter')}
				{assign var="stitle" value=$MOD.Incidents_a_suivre}
				{assign var="nbElement" value=$RECORD_COUNT_INCIDENT}
				{assign var="totalElement" value=$TOTAL_RECORD_COUNT_INCIDENT}
				{assign var="checkVal" value=$INCIDENTS_VIEW_ALL_CHECKED}
			{/if*}
			
			{ assign var="stitle" value=$MOD[$tablestuff.Stufftitle] }
			
		{else}
			{assign var="stitle" value=$tablestuff.Stufftitle}
		{/if}

			<td align="left" class="homePageMatrixHdr" style="height:30px;" nowrap width=50%><b>&nbsp;{$stitle}&nbsp;&nbsp; </b></td>
			<td align="right" class="homePageMatrixHdr" style="height:30px;" width=25%>
				<span id="refresh_{$tablestuff.Stuffid}" style="position:relative;">&nbsp;&nbsp; </span>

			</td>
			<td align="right" class="homePageMatrixHdr" style="height:30px;" width=25% nowrap>

{*<!-- code for edit button ends here -->*}

{*<!-- code for refresh button -->*}
{if $tablestuff.Stufftitle eq "Home Page Dashboard"}
				<a style='cursor:pointer;' onclick="fetch_homeDB({$tablestuff.Stuffid});">
					<img src="{'windowRefresh.gif'|@vtiger_imageurl:$THEME}" border="0" alt="Refresh" title="Refresh" hspace="2" align="absmiddle"/>
				</a>
{else}
				<a style='cursor:pointer;' onclick="loadStuff({$tablestuff.Stuffid},'{$tablestuff.Stufftype}');">
					<img src="{'windowRefresh.gif'|@vtiger_imageurl:$THEME}" border="0" alt="Refresh" title="Refresh" hspace="2" align="absmiddle"/>
				</a>
{/if}

{*<!-- code for delete button ends here -->*}
			</td>
		</tr>
	</table>
	
	<table width="100%" cellpadding="0" cellspacing="0" class="small" style="padding-right:0px;padding-left:0px;padding-top:0px;">
{if $tablestuff.Stufftype eq "Module"}
		<tr id="maincont_row_{$tablestuff.Stuffid}" class="show_tab winmarkModulesusr">
{elseif $tablestuff.Stufftype eq "Default" && $tablestuff.Stufftitle neq "Home Page Dashboard"}
		<tr id="maincont_row_{$tablestuff.Stuffid}" class="show_tab winmarkModulesdefBis">
{elseif $tablestuff.Stufftype eq "RSS"}
		<tr id="maincont_row_{$tablestuff.Stuffid}" class="show_tab winmarkRSS">
{elseif $tablestuff.Stufftype eq "DashBoard"}
		<tr id="maincont_row_{$tablestuff.Stuffid}" class="show_tab winmarkDashboardusr">
{elseif $tablestuff.Stufftype eq "Default" && $tablestuff.Stufftitle eq "Home Page Dashboard"}
		<tr id="maincont_row_{$tablestuff.Stuffid}" class="show_tab winmarkDashboarddef">
{elseif $tablestuff.Stufftype eq "Notebook" || $tablestuff.Stufftype eq "Tag Cloud"}
		<tr id="maincont_row_{$tablestuff.Stuffid}">
{else}
		<tr id="maincont_row_{$tablestuff.Stuffid}" class="show_tab">
{/if}
			<td colspan="2">
				<div id="stuffcont_{$tablestuff.Stuffid}" style="height:260px; overflow-y: auto; overflow-x:hidden;width:100%;height:100%;"> 
				</div>
			</td>
		</tr>
	</table>
	
	<table width="100%" cellpadding="0" cellspacing="0" class="small scrollLink">
	<tr>
		<td align="left">
			<a href="javascript:;" onclick="addScrollBar({$tablestuff.Stuffid});">
				{$MOD.LBL_SCROLL}
			</a>
		</td>
{if $tablestuff.Stufftype eq "Module" || ($tablestuff.Stufftype eq "Default" &&  $tablestuff.Stufftitle neq "Key Metrics" && $tablestuff.Stufftitle neq "Home Page Dashboard" && $tablestuff.Stufftitle neq "My Group Allocation" ) || $tablestuff.Stufftype eq "RSS" || $tablestuff.Stufftype eq "DashBoard"}
		<td align="right">
			<a href="#" id="a_{$tablestuff.Stuffid}">
				{$MOD.LBL_MORE}
			</a>
		</td>
{/if}
	</tr>	
	</table>
</div>

<script language="javascript">
	{*<!-- position the div in the page -->*}
	window.onresize = function(){ldelim}positionDivInAccord('stuff_{$tablestuff.Stuffid}','{$tablestuff.Stufftitle}','{$tablestuff.Stufftype}');{rdelim};
	positionDivInAccord('stuff_{$tablestuff.Stuffid}','{$tablestuff.Stufftitle}','{$tablestuff.Stufftype}');
</script>	

<script language="javascript">
	function afficherTout(idElement) 
	{ldelim}
		var element = document.getElementById(idElement);
		var val = '';
		
		if(element != null) 
		{ldelim}
			if(element.checked == true) 
			{ldelim}
				val = idElement;
			{rdelim}
		{rdelim}
		document.getElementById(idElement).value = val;
		
	{rdelim}

</script>	
