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
	<title>{$CURRENT_USER} - {$APP.$CATEGORY} - {$APP.$MODULE_NAME} - {$APP.LBL_BROWSER_TITLE}</title>
	<!--link REL="SHORTCUT ICON" HREF="themes/images/favicon.ico"-->	
	<style type="text/css">@import url("themes/{$THEME}/style.css");</style>
	<!-- ActivityReminder customization for callback -->
	{*literal}
	<style type="text/css">div.fixedLay1 { position:fixed; }</style>
	<!--[if lte IE 6]>
	<style type="text/css">div.fixedLay { position:absolute; }</style>
	<![endif]-->
	{/literal*}
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
 
<nav id="menu-side">
	<p class="titre">A PROPOS</p>
	<ul>
		<li><a href="index.php?module=StatisticsSM&action=Presentation">Pr&eacute;sentation de la BDSM</a></li>
		<li><a href="index.php?module=StatisticsSM&action=Lexique">Lexique de la BDSM</a></li>
		<li><a href="index.php?module=StatisticsSM&action=Faq">Foire Aux Questions</a></li>
		<li><a href="#nogo">Guide Utilisateur</a></li>
		<li><a href="#nogo">Guide M&eacute;thodologique</a></li>
		<li><a href="index.php?module=StatisticsSM&action=Contact">Contact</a></li>
	</ul>
	<p class="titre">STATISTIQUES</p>
	<ul>
		<li><a href="index.php?module=StatisticsSM&action=ListView&sfiche=SFCN11-01">Secteur Reel</a></li>
		<li><a href="index.php?module=StatisticsSM&action=ListView&sfiche=SFPR23-01">Indices de Prix</a></li>
		<li><a href="index.php?module=StatisticsSM&action=ListView&sfiche=SFTO31-01">Finances Publiques</a></li>
		<li><a href="index.php?module=StatisticsSM&action=ListView&sfiche=SFTO41-01">Dette Publique</a></li>
		<li><a href="index.php?module=StatisticsSM&action=ListView&sfiche=SFEC41-01">Echanges Exterieures</a></li>
		<li><a href="index.php?module=StatisticsSM&action=ListView&sfiche=SFSM52-01">Situation Mon&eacute;taire</a></li>
		<li><a href="index.php?module=StatisticsSM&action=ListView&sfiche=SFCC61-01">Critères de Convergence</a></li>
	</ul>
	</nav>
	<center>
<table width=80% align="center" class="lexique-table">
<thead>
        <tr>
            <th colspan=2><h1> LEXIQUE DE LA BDSM </h1></th>
        </tr>
    </thead>
    {foreach item=lexiques key=secteur from=$INFOSLEXIQUES}
	    <tr><td class="lexiqueSecteur">{$secteur}</td></tr>
		{foreach item=lexique key=code from=$lexiques}
    			<tr><td class="lexiqueData"><b>{$code}: </b>{$lexique}</td></tr>
		{/foreach}
    {/foreach}

	
	
	
	
	
	
	
	
	
	
	