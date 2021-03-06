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
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
	<title>BDSM - BASE DE DONNEES DE LA SURVEILLANCE MULTILATERALE</title>
	<!--link REL="SHORTCUT ICON" HREF="themes/images/favicon.ico"-->	
	<style type="text/css">@import url("themes/{$THEME}/style.css");</style>
	<!-- ActivityReminder customization for callback -->
	{literal}
	<style type="text/css">div.fixedLay1 { position:fixed; }</style>
	<!--[if lte IE 6]>
	<style type="text/css">div.fixedLay { position:absolute; }</style>
	<![endif]-->
	{/literal}
	<!-- End -->
</head>
	<body leftmargin=0 topmargin=0 marginheight=0 marginwidth=0 class=small>
	<a name="top"></a>
	<!-- header -->
	<!-- header-vtiger crm name & RSS -->
        <link href="themes/css/nav.css" rel="stylesheet" type="text/css" />
        <link href="themes/css/header.css" rel="stylesheet" type="text/css" />
        <link href="themes/css/footer.css" rel="stylesheet" type="text/css" />
   

	<script language="JavaScript" type="text/javascript" src="include/js/general.js"></script>
	<!-- vtlib customization: Javascript hook -->	
	<script language="JavaScript" type="text/javascript" src="include/js/vtlib.js"></script>
	<!-- END -->
	<script language="JavaScript" type="text/javascript" src="include/js/fr_fr.lang.js"></script>
	<script language="JavaScript" type="text/javascript" src="include/js/QuickCreate.js"></script>
	<script language="javascript" type="text/javascript" src="include/scriptaculous/prototype.js"></script>
	<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>
	<script language="JavaScript" type="text/javascript" src="include/calculator/calc.js"></script>
	<script language="JavaScript" type="text/javascript" src="modules/Calendar/script.js"></script>
	<script language="javascript" type="text/javascript" src="include/scriptaculous/dom-drag.js"></script>
	<script language="JavaScript" type="text/javascript" src="include/js/notificationPopup.js"></script>
	<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
        <script type="text/javascript" src="jscalendar/calendar.js"></script>
        <script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
        <script type="text/javascript" src="jscalendar/lang/calendar-{$APP.LBL_JSCALENDAR_LANG}.js"></script>
        
    <!-- asterisk Integration -->
    {if $USE_ASTERISK eq 'true'}
    	<script type="text/javascript" src="include/js/asterisk.js"></script>
    {/if}
    <!-- END -->

	{* vtlib customization: Inclusion of custom javascript and css as registered *}
	{if $HEADERSCRIPTS}
		<!-- Custom Header Script -->
		{foreach item=HEADERSCRIPT from=$HEADERSCRIPTS}
			<script type="text/javascript" src="{$HEADERSCRIPT->linkurl}"></script>
		{/foreach}
		<!-- END -->
	{/if}
	{if $HEADERCSS}
		<!-- Custom Header CSS -->
		{foreach item=HDRCSS from=$HEADERCSS}
			<link rel="stylesheet" type="text/css" href="{$HDRCSS->linkurl}"></script>
		{/foreach}
		<!-- END -->
	{/if}
	{* END *}

	<TABLE border=0 cellspacing=0 cellpadding=0 width=100% class="hdrNameBg">
	<tr>
		<td >
					<span style="font-size: 22px;text-decoration:none;color:white;vertical-align:middle;padding-left:10px;">Union Economique et Mon&eacute;taire Ouest Africaine</span><br>
					<span style="font-size: 25px;text-decoration:none;color:#1B019B;vertical-align:middle;padding-left:10px;">Base de Donn&eacute;es de la Surveillance Multimat??rale </span><br>
					<!--span style="font-size: 9px;text-decoration:none;color:#154360;vertical-align:middle;">SECTEUR REEL - INDICES DE PRIX - FINANCES PUBLIQUES - DETTES PUBLIQUES - ECHANGES EXTERIEURES - SITUATION MONETAIRE</span-->		
		<td valign=top><img src="{$IMAGEPATH}/logo_uemoa.png" width=60 height=56  alt="PORTAIL BASE DE DONNEES DE LA SURVEILLANCE MULTILATERALE UEMOA" title="PORTAIL PORTAIL BASE DE DONNEES DE LA SURVEILLANCE MULTILATERALE UEMOA" border=0></td>
		<td class=small nowrap align=right>
			<table border=0 cellspacing=0 cellpadding=0>
			
			 <tr>
			
			{* vtlib customization: Header links on the top panel *}
			{if $HEADERLINKS}
			<td style="padding-left:10px;padding-right:5px" class=small nowrap>
				<a href="javascript:;" onmouseover="fnvshobj(this,'vtlib_headerLinksLay');" onclick="fnvshobj(this,'vtlib_headerLinksLay');">{$APP.LBL_MORE}</a> <img src="{'arrow_down.gif'|@vtiger_imageurl:$THEME}" border=0>
				<div style="display: none; left: 193px; top: 106px;width:155px; position:absolute;" id="vtlib_headerLinksLay" 
					onmouseout="fninvsh('vtlib_headerLinksLay')" onmouseover="fnvshNrm('vtlib_headerLinksLay')">
					<table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr><td style="border-bottom: 1px solid rgb(204, 204, 204); padding: 5px;"><b>{$APP.LBL_MORE}</b></td></tr>
					<tr>
						<td>
							{foreach item=HEADERLINK from=$HEADERLINKS}
								{assign var="headerlink_href" value=$HEADERLINK->linkurl}
								{assign var="headerlink_label" value=$HEADERLINK->linklabel}
								{if $headerlink_label eq ''}
									{assign var="headerlink_label" value=$headerlink_href}
								{else}
									{* Pickup the translated label provided by the module *}
									{assign var="headerlink_label" value=$headerlink_label|@getTranslatedString:$HEADERLINK->module()}
								{/if}
								<a href="{$headerlink_href}" class="drop_down">{$headerlink_label}</a>
							{/foreach}
						</td>
					</tr>
					</table>
				</div>
			</td>
			{/if}
			{* END *}
			
			<!-- gmailbookmarklet customization -->
			 <td style="padding-left:10px;padding-right:10px" class=small nowrap>
				{$GMAIL_BOOKMARKLET}
			 </td>
			 <!-- END -->
			 {if $ADMIN_LINK neq ''} {* Show links only for admin *}
			<!-- <td style="padding-left:10px;padding-right:10px" class=small nowrap> <a href="javascript:void(0);" onclick="vtiger_news(this)">{$APP.LBL_VTIGER_NEWS}</a></td>
			 <td style="padding-left:10px;padding-right:10px" class=small nowrap> <a href="javascript:void(0);" onclick="vtiger_feedback();">{$APP.LBL_FEEDBACK}</a></td> -->
			 {/if}
			<!-- 
			 <td style="padding-left:10px;padding-right:10px" class=small nowrap> <a href="index.php?module=Users&action=DetailView&record={$CURRENT_USER_ID}&modechk=prefview">{$APP.LBL_MY_PREFERENCES}</a></td>
			<td style="padding-left:10px;padding-right:10px" class=small nowrap><a href="http://wiki.vtiger.com/index.php/Main_Page" target="_blank">{$APP.LNK_HELP}</a></td>
			 <td style="padding-left:10px;padding-right:10px" class=small nowrap><a href="javascript:;" onClick="openwin();">{$APP.LNK_WEARE}</a></td>
			 -->
			 <!--td style="padding-left:10px;padding-right:10px" class=small nowrap> <a href="index.php?module=Users&action=Logout">{$APP.LBL_LOGOUT}</a> ({$CURRENT_USER})</td-->
			 </tr>
			
			
			</tr>
			</table>
		</td>
	</tr>
	
	</TABLE>

<div id='miniCal' style='width:300px; position:absolute; display:none; left:100px; top:100px; z-index:100000'>
</div>

<!-- header - master tabs -->
<!--TABLE border=0 cellspacing=0 cellpadding=0 width=100% class="hdrTabBg">
<tr>
	<td style="width:50px" class=small>&nbsp;</td>
	<td class=small nowrap> 
		<table border=0 cellspacing=0 cellpadding=0>
		
		<tr>
			<td class=tabSeperator><img src="{'spacer.gif'|@vtiger_imageurl:$THEME}" width=2px height=28px></td>		
			{foreach key=maintabs item=detail from=$HEADERS}
				{if $maintabs ne $CATEGORY}
				  <td class="tabUnSelected"  onmouseover="fnDropDown(this,'{$maintabs}_sub');" onmouseout="fnHideDrop('{$maintabs}_sub');" align="center" nowrap><a href="index.php?module={$detail[0]}&action=index">{$APP[$maintabs]}</a><img src="{'menuDnArrow.gif'|@vtiger_imageurl:$THEME}" border=0 style="padding-left:5px"></td>
				  <td class="tabSeperator"><img src="{'spacer.gif'|@vtiger_imageurl:$THEME}"></td>
				{else}
				  <td class="tabSelected"  onmouseover="fnDropDown(this,'{$maintabs}_sub');" onmouseout="fnHideDrop('{$maintabs}_sub');" align="center" nowrap><a href="index.php?module={$detail[0]}&action=index">{$APP[$maintabs]}</a><img src="{'menuDnArrow.gif'|@vtiger_imageurl:$THEME}" border=0 style="padding-left:5px"></td>
				  <td class="tabSeperator"><img src="{'spacer.gif'|@vtiger_imageurl:$THEME}"></td>
				{/if}
			{/foreach}
		
			<td style="padding-left:10px" nowrap>
				{if $CNT ge 1}
					<select class=small id="qccombo" style="width:155px"  onclick="QCreate2(this);">
						<option value="none">{$APP.LBL_QUICK_CREATE}...</option>
                        {foreach  item=detail from=$QCMODULE}
                        <option value="{$detail.1}">{$APP.POST}&nbsp;{$detail.0}</option>
                        {/foreach}
					</select>
				
				{/if}	
			</td>
			
		</tr>

		</table>
	</td>
	
	<td align=right style="padding-right:10px" >
		<table border=0 cellspacing=0 cellpadding=0 id="search" style="border:1px solid #999999;background-color:white">
		   <tr>
			<form name="UnifiedSearch" method="post" action="index.php" style="margin:0px">
			<td style="height:19px;background-color:#ffffef" >
				<input type="hidden" name="action" value="UnifiedSearch" style="margin:0px">
				<input type="hidden" name="module" value="Home" style="margin:0px">
				<input type="hidden" name="parenttab" value="{$CATEGORY}" style="margin:0px">
				<input type="text" name="query_string" value="{$QUERY_STRING}" class="searchBox" onFocus="this.value=''" >
			</td>
			<td style="background-color:#cccccc">
				<input type="submit" class="searchBtn" value="{$APP.LBL_FIND_BUTTON}" alt="{$APP.LBL_FIND}" title="{$APP.LBL_FIND}">
			</td>
			</form>
		   </tr>
		</table>
	</td>
	
</td>
</tr>
</TABLE-->

<!-- - level 2 tabs starts-->
<TABLE border=0 cellspacing=0 cellpadding=2 width=100% class="level2Bg" >
<tr>
	<td >
		<table border=0 cellspacing=0 cellpadding=0 width=98%>
		<tr >
			<!-- ASHA: Avoid using this as it gives module name instead of module label. 
			Now Using the same array QUICKACCESS that is used to show drop down menu
			(which gives both module name and module label)-->
			{*foreach  key=maintabs item=detail from=$HEADERS}
				{if $maintabs eq $CATEGORY}
					{foreach  key=number item=module from=$detail}
						{assign var="modulelabel" value=$module}
      					{if $APP.$module} 
      						{assign var="modulelabel" value=$APP.$module} 
      					{/if}
						{if $module eq $MODULE_NAME}
							<td class="level2SelTab" nowrap><a href="index.php?module={$module}&action=index">{$modulelabel}</a></td>
						{else}
							<td class="level2UnSelTab" nowrap> <a href="index.php?module={$module}&action=index">{$modulelabel}</a> </td>
						{/if}	
					{/foreach}
				{/if}
			{/foreach*}
			
			
			<td class="level2SelTab" nowrap align="right">
				<a href="index.php?module=StatisticsSM&action=Accueil">ACCUEIL</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="index.php?module=StatisticsSM&action=APROPOS">A PROPOS</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="index.php?module=StatisticsSM&action=ListView&sfiche=SFPR23-01">STATISTIQUES</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="#">GUIDE UTILISATEUR</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="#">GUIDE M&Eacute;THODOLOGIQUE BDSM</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="index.php?module=StatisticsSM&action=Lexique">LEXIQUE</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="#">CONTACT</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="index.php?module=StatisticsSM&action=Faq">FAQ</a>&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
		</tr>
		
		</table>
	</td>
</tr>
</TABLE>		
<!-- Level 2 tabs ends -->
<div id="calculator_cont" style="position:absolute; z-index:10000" ></div>
	{include file="Clock.tpl"}

<div id="qcform" style="position:absolute;width:700px;top:80px;left:450px;z-index:100000;"></div>

<script>
var gVTModule = '{$smarty.request.module}';
function fetch_clock()
{ldelim}
	new Ajax.Request(
		'index.php',
		{ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
			method: 'post',
			postBody: 'module=Utilities&action=UtilitiesAjax&file=Clock',
			onComplete: function(response)
				    {ldelim}
					$("clock_cont").innerHTML=response.responseText;
					execJS($('clock_cont'));
				    {rdelim}
		{rdelim}
	);

{rdelim}

function fetch_calc()
{ldelim}
	new Ajax.Request(
		'index.php',
		{ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
			method: 'post',
			postBody: 'module=Utilities&action=UtilitiesAjax&file=Calculator',
			onComplete: function(response)
					{ldelim}
						$("calculator_cont").innerHTML=response.responseText;
						execJS($('calculator_cont'));
					{rdelim}
		{rdelim}
	);
{rdelim}

function QCreate2(qcoptions) 
{ldelim}
	var module = qcoptions.options[qcoptions.options.selectedIndex].value;
  	if(module != 'none')
  	{ldelim}
		location.href = 'index.php?module='+module+'&action=EditView&return_action=DetailView&parenttab='+module;
  	{rdelim}
{rdelim}	
</script>

<script>
{literal}
function QCreate(qcoptions){
	var module = qcoptions.options[qcoptions.options.selectedIndex].value;
	/*if(module != 'none'){
		$("status").style.display="inline";
		if(module == 'Events'){
			module = 'Calendar';
			var urlstr = '&activity_mode=Events';
		}else if(module == 'Calendar'){
			module = 'Calendar';
			var urlstr = '&activity_mode=Task';
		}else{
			var urlstr = '';
		}
		new Ajax.Request(
			'index.php',
				{queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module='+module+'&action='+module+'Ajax&file=QuickCreate'+urlstr,
				onComplete: function(response){
					$("status").style.display="none";
					$("qcform").style.display="inline";
					$("qcform").innerHTML = response.responseText;
					// Evaluate all the script tags in the response text.
					var scriptTags = $("qcform").getElementsByTagName("script");
					for(var i = 0; i< scriptTags.length; i++){
						var scriptTag = scriptTags[i];
						eval(scriptTag.innerHTML);
					}
                    eval($("qcform"));
                    posLay(qcoptions, "qcform");
				}
			}
		);
	}else{
		hide('qcform');
	}
}

function getFormValidate(divValidate)
{
  var st = document.getElementById('qcvalidate');
  eval(st.innerHTML);
  for (var i=0; i<qcfieldname.length; i++) {
		var curr_fieldname = qcfieldname[i];	
		if(window.document.QcEditView[curr_fieldname] != null)
		{
			var type=qcfielddatatype[i].split("~")
			var input_type = window.document.QcEditView[curr_fieldname].type;	
			if (type[1]=="M") {
					if (!qcemptyCheck(curr_fieldname,qcfieldlabel[i],input_type))
						return false
				}
			switch (type[0]) {
				case "O"  : break;
				case "V"  : break;
				case "C"  : break;
				case "DT" :
					if (window.document.QcEditView[curr_fieldname] != null && window.document.QcEditView[curr_fieldname].value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{	 
						if (type[1]=="M")
							if (!qcemptyCheck(type[2],qcfieldlabel[i],getObj(type[2]).type))
								return false
						if(typeof(type[3])=="undefined") var currdatechk="OTH"
						else var currdatechk=type[3]

						if (!qcdateTimeValidate(curr_fieldname,type[2],qcfieldlabel[i],currdatechk))
							return false
						if (type[4]) {
							if (!dateTimeComparison(curr_fieldname,type[2],qcfieldlabel[i],type[5],type[6],type[4]))
								return false

						}
					}		
				break;
				case "D"  :
					if (window.document.QcEditView[curr_fieldname] != null && window.document.QcEditView[curr_fieldname].value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{	
						if(typeof(type[2])=="undefined") var currdatechk="OTH"
						else var currdatechk=type[2]

							if (!qcdateValidate(curr_fieldname,qcfieldlabel[i],currdatechk))
								return false
									if (type[3]) {
										if (!qcdateComparison(curr_fieldname,qcfieldlabel[i],type[4],type[5],type[3]))
											return false
									}
					}	
				break;
				case "T"  :
					if (window.document.QcEditView[curr_fieldname] != null && window.document.QcEditView[curr_fieldname].value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{	 
						if(typeof(type[2])=="undefined") var currtimechk="OTH"
						else var currtimechk=type[2]

							if (!timeValidate(curr_fieldname,qcfieldlabel[i],currtimechk))
								return false
									if (type[3]) {
										if (!timeComparison(curr_fieldname,qcfieldlabel[i],type[4],type[5],type[3]))
											return false
									}
					}
				break;
				case "I"  :
					if (window.document.QcEditView[curr_fieldname] != null && window.document.QcEditView[curr_fieldname].value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{	
						if (window.document.QcEditView[curr_fieldname].value.length!=0)
						{
							if (!qcintValidate(curr_fieldname,qcfieldlabel[i]))
								return false
							if (type[2]) {
								if (!qcnumConstComp(curr_fieldname,qcfieldlabel[i],type[2],type[3]))
									return false
							}
						}
					}
				break;
				case "N"  :
					case "NN" :
					if (window.document.QcEditView[curr_fieldname] != null && window.document.QcEditView[curr_fieldname].value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{
						if (window.document.QcEditView[curr_fieldname].value.length!=0)
						{
							if (typeof(type[2])=="undefined") var numformat="any"
							else var numformat=type[2]

								if (type[0]=="NN") {

									if (!numValidate(curr_fieldname,qcfieldlabel[i],numformat,true))
										return false
								} else {
									if (!numValidate(curr_fieldname,qcfieldlabel[i],numformat))
										return false
								}
							if (type[3]) {
								if (!numConstComp(curr_fieldname,qcfieldlabel[i],type[3],type[4]))
									return false
							}
						}
					}
				break;
				case "E"  :
					if (window.document.QcEditView[curr_fieldname] != null && window.document.QcEditView[curr_fieldname].value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{
						if (window.document.QcEditView[curr_fieldname].value.length!=0)
						{
							var etype = "EMAIL"
								if (!qcpatternValidate(curr_fieldname,qcfieldlabel[i],etype))
									return false
						}
					}
				break;
			}
		}
	}
       //added to check Start Date & Time,if Activity Status is Planned.//start
        for (var j=0; j<qcfieldname.length; j++)
		{
			curr_fieldname = qcfieldname[j];
			if(window.document.QcEditView[curr_fieldname] != null)
			{
				if(qcfieldname[j] == "date_start")
				{
					var datelabel = qcfieldlabel[j]
						var datefield = qcfieldname[j]
						var startdatevalue = window.document.QcEditView[datefield].value.replace(/^\s+/g, '').replace(/\s+$/g, '')
				}
				if(qcfieldname[j] == "time_start")
				{
					var timelabel = qcfieldlabel[j]
						var timefield = qcfieldname[j]
						var timeval=window.document.QcEditView[timefield].value.replace(/^\s+/g, '').replace(/\s+$/g, '')
				}
				if(qcfieldname[j] == "eventstatus" || qcfieldname[j] == "taskstatus")
				{
					var statusvalue = window.document.QcEditView[curr_fieldname].options[window.document.QcEditView[curr_fieldname].selectedIndex].value.replace(/^\s+/g, '').replace(/\s+$/g, '')
					var statuslabel = qcfieldlabel[j++]
				}
			}
		}
	if(statusvalue == "Planned")
        {
               var dateelements=splitDateVal(startdatevalue)
	       var hourval=parseInt(timeval.substring(0,timeval.indexOf(":")))
               var minval=parseInt(timeval.substring(timeval.indexOf(":")+1,timeval.length))
               var dd=dateelements[0]
               var mm=dateelements[1]
               var yyyy=dateelements[2]

               var chkdate=new Date()
               chkdate.setYear(yyyy)
               chkdate.setMonth(mm-1)
               chkdate.setDate(dd)
	       chkdate.setMinutes(minval)
               chkdate.setHours(hourval)
		if(!comparestartdate(chkdate)) return false;
		

	 }//end
	return true;
}
</SCRIPT>
{/literal}

{* Quick Access Functionality *}
<div id="allMenu" onmouseout="fninvsh('allMenu');" onMouseOver="fnvshNrm('allMenu');" style="width:550px;z-index: 10000001;display:none;">
	<table border=0 cellpadding="5" cellspacing="0" class="allMnuTable" >
	<tr>
		<td valign="top">
		{assign var="parentno" value=0}
		{foreach name=parenttablist key=parenttab item=details from=$QUICKACCESS}
			<span class="allMnuHdr">{$APP[$parenttab]}</span>
			{foreach name=modulelist item=modules from=$details}
       		{math assign="num" equation="x + y" x=$parentno y=1}
			{math assign="loopvalue" equation="x % y" x=$num y=15}
			{assign var="parentno" value=$num}
			{if $loopvalue eq '0'}
				</td><td valign="top">
			{/if}
			{assign var="modulelabel" value=$modules[1]}
   			{if $APP[$modules.1]}
   				{assign var="modulelabel" value=$APP[$modules.1]}
   			{/if}
			<a href="index.php?module={$modules.0}&action=index&parenttab={$parenttab}" class="allMnu">{$modulelabel}</a> 
			{/foreach}
		{/foreach}
		</td>
	</tr>
</table>
</div>

<!-- Drop Down Menu in the Main Tab -->
{*foreach name=parenttablist key=parenttab item=details from=$QUICKACCESS}
<div class="drop_mnu" id="{$parenttab}_sub" onmouseout="fnHideDrop('{$parenttab}_sub')" onmouseover="fnShowDrop('{$parenttab}_sub')">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		{foreach name=modulelist item=modules from=$details}
		{assign var="modulelabel" value=$modules[1]}
		{if $APP[$modules.1]}
			{assign var="modulelabel" value=$APP[$modules.1]}
		{/if}
		
		<tr><td>
		
		<!--<a href="index.php?module={$modules.0}&action=index&parenttab={$parenttab}" class="drop_down">{$modulelabel}</a>-->

			{if ($CURRENT_USER_IS_ADMIN eq 'on' || $CURRENT_USER_PROFIL_ID eq 20) && $modules.0 neq 'Reports'}
				<a href="index.php?module={$modules.0}&action=index&parenttab={$parenttab}" class="drop_down">{$modulelabel}</a>
			{else}
		 		{if $modules.0 neq 'TraitementDemandes' && $modules.0 neq 'TraitementIncidents' && $modules.0 neq 'SuiviDemandes' && $modules.0 neq 'SuiviIncidents' && $modules.0 neq 'Reports'}
					<a href="index.php?module={$modules.0}&action=index&parenttab={$parenttab}" class="drop_down">{$modulelabel}</a>
		 		{elseif $modules.0 eq 'TraitementDemandes' && $CURRENT_USER_IS_TRAITEUR_DEMANDE neq 0}
					<a href="index.php?module={$modules.0}&action=index&parenttab={$parenttab}" class="drop_down">{$modulelabel}</a>
		  		{elseif $modules.0 eq 'TraitementIncidents' && $CURRENT_USER_IS_TRAITEUR_INCIDENT neq 0}
					<a href="index.php?module={$modules.0}&action=index&parenttab={$parenttab}" class="drop_down">{$modulelabel}</a>
		  		{elseif $modules.0 eq 'SuiviDemandes' && $CURRENT_USER_IS_POSTEUR_DEMANDE neq 0}
					<a href="index.php?module={$modules.0}&action=index&parenttab={$parenttab}" class="drop_down">{$modulelabel}</a>
		  		{elseif $modules.0 eq 'SuiviIncidents' && $CURRENT_USER_IS_POSTEUR_INCIDENT neq 0}
					<a href="index.php?module={$modules.0}&action=index&parenttab={$parenttab}" class="drop_down">{$modulelabel}</a>
		 		{/if}
			{/if}
		
		</td></tr>
		{/foreach}
	</table>
</div>
{/foreach*}


<div id="status" style="position:absolute;display:none;left:930px;top:95px;height:27px;white-space:nowrap;"><img src="{$IMAGEPATH}status.gif"></div>
<script>
function openwin()
{ldelim}
            window.open("index.php?module=Users&action=about_us","aboutwin","height=520,width=515,top=200,left=300")
{rdelim}

</script>


<div id="tracker" style="display:none;position:absolute;z-index:100000001;" class="layerPopup">

	<table border="0" cellpadding="5" cellspacing="0" width="200">
	<tr style="cursor:move;">
		<td colspan="2" class="mailClientBg small" id="Track_Handle"><strong>{$APP.LBL_LAST_VIEWED}</strong></td>
		<td align="right" style="padding:5px;" class="mailClientBg small">
		<a href="javascript:;"><img src="{'close.gif'|@vtiger_imageurl:$THEME}" border="0"  onClick="fninvsh('tracker')" hspace="5" align="absmiddle"></a>
		</td></tr>
	</table>
	<table border="0" cellpadding="5" cellspacing="0" width="200" class="hdrNameBg">
	{foreach name=trackinfo item=trackelements from=$TRACINFO}
	<tr>
		<td class="trackerListBullet small" align="center" width="12">{$smarty.foreach.trackinfo.iteration}</td>
		<td class="trackerList small"> <a href="index.php?module={$trackelements.module_name}&action=DetailView&record={$trackelements.crmid}&parenttab={$CATEGORY}">{$trackelements.item_summary}</a> </td><td class="trackerList small">&nbsp;</td></tr>
	{/foreach}
	</table>
</div>
	
<script>
	var THandle = document.getElementById("Track_Handle");
	var TRoot   = document.getElementById("tracker");
	Drag.init(THandle, TRoot);
</script>		

<!-- vtiger Feedback -->
<script type="text/javascript">
{literal}
function vtiger_feedback() {
	window.open("http://www.vtiger.com/products/crm/feedback.php?uid={/literal}{php}global $application_unique_key; echo $application_unique_key;{/php}{literal}","feedbackwin","height=300,width=515,top=200,left=300")
}
{/literal}
</script>
<!-- vtiger news -->
<script type="text/javascript">
{literal}
function vtiger_news(obj) {
	$('status').style.display = 'inline';
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Home&action=HomeAjax&file=HomeNews',
			onComplete: function(response) {
				$("vtigerNewsPopupLay").innerHTML=response.responseText;
				fnvshobj(obj, 'vtigerNewsPopupLay');
				$('status').style.display = 'none';
			}
		}
	);
		
}
{/literal}
</script>
<div class="lvtCol fixedLay1" id="vtigerNewsPopupLay" style="display: none; height: 250px; bottom: 2px; padding: 2px; z-index: 12; font-weight: normal;" align="left">
</div>
<!-- END -->

<!-- ActivityReminder Customization for callback -->
<div class="lvtCol fixedLay1" id="ActivityRemindercallback" style="right: 0px; bottom: 2px; display:none; padding: 2px; z-index: 10; font-weight: normal;" align="left">
</div>
<!-- End -->

<!-- divs for asterisk integration -->
<div class="lvtCol fixedLay1" id="notificationDiv" style="float: right;  padding-right: 5px; overflow: hidden; border-style: solid; right: 0px; border-color: rgb(141, 141, 141); bottom: 0px; display: none; padding: 2px; z-index: 10; font-weight: normal;" align="left">
</div>

<div id="OutgoingCall" style="display: none;position: absolute;z-index:200;" class="layerPopup">
	<table  border='0' cellpadding='5' cellspacing='0' width='100%'>
		<tr style='cursor:move;' >
			<td class='mailClientBg small' id='outgoing_handle'>
				<b>{$APP.LBL_OUTGOING_CALL}</b>
			</td>
		</tr>
	</table>
	<table  border='0' cellpadding='0' cellspacing='0' width='100%' class='hdrNameBg'>
		</tr>
		<tr><td style='padding:10px;' colspan='2'>
			{$APP.LBL_OUTGOING_CALL_MESSAGE}
		</td></tr>
	</table>
</div>
<!-- divs for asterisk integration :: end-->
