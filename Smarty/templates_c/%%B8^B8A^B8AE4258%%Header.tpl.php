<?php /* Smarty version 2.6.18, created on 2021-04-07 17:09:21
         compiled from Header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'Header.tpl', 92, false),array('modifier', 'getTranslatedString', 'Header.tpl', 106, false),array('function', 'math', 'Header.tpl', 511, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
	<title>BDSM - BASE DE DONNEES DE LA SURVEILLANCE MULTILATERALE</title>
	<!--link REL="SHORTCUT ICON" HREF="themes/images/favicon.ico"-->	
	<style type="text/css">@import url("themes/<?php echo $this->_tpl_vars['THEME']; ?>
/style.css");</style>
	<!-- ActivityReminder customization for callback -->
	<?php echo '
	<style type="text/css">div.fixedLay1 { position:fixed; }</style>
	<!--[if lte IE 6]>
	<style type="text/css">div.fixedLay { position:absolute; }</style>
	<![endif]-->
	'; ?>

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
        <script type="text/javascript" src="jscalendar/lang/calendar-<?php echo $this->_tpl_vars['APP']['LBL_JSCALENDAR_LANG']; ?>
.js"></script>
        
    <!-- asterisk Integration -->
    <?php if ($this->_tpl_vars['USE_ASTERISK'] == 'true'): ?>
    	<script type="text/javascript" src="include/js/asterisk.js"></script>
    <?php endif; ?>
    <!-- END -->

		<?php if ($this->_tpl_vars['HEADERSCRIPTS']): ?>
		<!-- Custom Header Script -->
		<?php $_from = $this->_tpl_vars['HEADERSCRIPTS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['HEADERSCRIPT']):
?>
			<script type="text/javascript" src="<?php echo $this->_tpl_vars['HEADERSCRIPT']->linkurl; ?>
"></script>
		<?php endforeach; endif; unset($_from); ?>
		<!-- END -->
	<?php endif; ?>
	<?php if ($this->_tpl_vars['HEADERCSS']): ?>
		<!-- Custom Header CSS -->
		<?php $_from = $this->_tpl_vars['HEADERCSS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['HDRCSS']):
?>
			<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['HDRCSS']->linkurl; ?>
"></script>
		<?php endforeach; endif; unset($_from); ?>
		<!-- END -->
	<?php endif; ?>
	
	<TABLE border=0 cellspacing=0 cellpadding=0 width=100% class="hdrNameBg">
	<tr>
		<td >
					<span style="font-size: 22px;text-decoration:none;color:white;vertical-align:middle;padding-left:10px;">Union Economique et Mon&eacute;taire Ouest Africaine</span><br>
					<span style="font-size: 25px;text-decoration:none;color:#1B019B;vertical-align:middle;padding-left:10px;">Base de Donn&eacute;es de la Surveillance Multimatérale </span><br>
					<!--span style="font-size: 9px;text-decoration:none;color:#154360;vertical-align:middle;">SECTEUR REEL - INDICES DE PRIX - FINANCES PUBLIQUES - DETTES PUBLIQUES - ECHANGES EXTERIEURES - SITUATION MONETAIRE</span-->		
		<td valign=top><img src="<?php echo $this->_tpl_vars['IMAGEPATH']; ?>
/logo_uemoa.png" width=60 height=56  alt="PORTAIL BASE DE DONNEES DE LA SURVEILLANCE MULTILATERALE UEMOA" title="PORTAIL PORTAIL BASE DE DONNEES DE LA SURVEILLANCE MULTILATERALE UEMOA" border=0></td>
		<td class=small nowrap align=right>
			<table border=0 cellspacing=0 cellpadding=0>
			
			 <tr>
			
						<?php if ($this->_tpl_vars['HEADERLINKS']): ?>
			<td style="padding-left:10px;padding-right:5px" class=small nowrap>
				<a href="javascript:;" onmouseover="fnvshobj(this,'vtlib_headerLinksLay');" onclick="fnvshobj(this,'vtlib_headerLinksLay');"><?php echo $this->_tpl_vars['APP']['LBL_MORE']; ?>
</a> <img src="<?php echo vtiger_imageurl('arrow_down.gif', $this->_tpl_vars['THEME']); ?>
" border=0>
				<div style="display: none; left: 193px; top: 106px;width:155px; position:absolute;" id="vtlib_headerLinksLay" 
					onmouseout="fninvsh('vtlib_headerLinksLay')" onmouseover="fnvshNrm('vtlib_headerLinksLay')">
					<table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr><td style="border-bottom: 1px solid rgb(204, 204, 204); padding: 5px;"><b><?php echo $this->_tpl_vars['APP']['LBL_MORE']; ?>
</b></td></tr>
					<tr>
						<td>
							<?php $_from = $this->_tpl_vars['HEADERLINKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['HEADERLINK']):
?>
								<?php $this->assign('headerlink_href', $this->_tpl_vars['HEADERLINK']->linkurl); ?>
								<?php $this->assign('headerlink_label', $this->_tpl_vars['HEADERLINK']->linklabel); ?>
								<?php if ($this->_tpl_vars['headerlink_label'] == ''): ?>
									<?php $this->assign('headerlink_label', $this->_tpl_vars['headerlink_href']); ?>
								<?php else: ?>
																		<?php $this->assign('headerlink_label', getTranslatedString($this->_tpl_vars['headerlink_label'], $this->_tpl_vars['HEADERLINK']->module())); ?>
								<?php endif; ?>
								<a href="<?php echo $this->_tpl_vars['headerlink_href']; ?>
" class="drop_down"><?php echo $this->_tpl_vars['headerlink_label']; ?>
</a>
							<?php endforeach; endif; unset($_from); ?>
						</td>
					</tr>
					</table>
				</div>
			</td>
			<?php endif; ?>
						
			<!-- gmailbookmarklet customization -->
			 <td style="padding-left:10px;padding-right:10px" class=small nowrap>
				<?php echo $this->_tpl_vars['GMAIL_BOOKMARKLET']; ?>

			 </td>
			 <!-- END -->
			 <?php if ($this->_tpl_vars['ADMIN_LINK'] != ''): ?> 			<!-- <td style="padding-left:10px;padding-right:10px" class=small nowrap> <a href="javascript:void(0);" onclick="vtiger_news(this)"><?php echo $this->_tpl_vars['APP']['LBL_VTIGER_NEWS']; ?>
</a></td>
			 <td style="padding-left:10px;padding-right:10px" class=small nowrap> <a href="javascript:void(0);" onclick="vtiger_feedback();"><?php echo $this->_tpl_vars['APP']['LBL_FEEDBACK']; ?>
</a></td> -->
			 <?php endif; ?>
			<!-- 
			 <td style="padding-left:10px;padding-right:10px" class=small nowrap> <a href="index.php?module=Users&action=DetailView&record=<?php echo $this->_tpl_vars['CURRENT_USER_ID']; ?>
&modechk=prefview"><?php echo $this->_tpl_vars['APP']['LBL_MY_PREFERENCES']; ?>
</a></td>
			<td style="padding-left:10px;padding-right:10px" class=small nowrap><a href="http://wiki.vtiger.com/index.php/Main_Page" target="_blank"><?php echo $this->_tpl_vars['APP']['LNK_HELP']; ?>
</a></td>
			 <td style="padding-left:10px;padding-right:10px" class=small nowrap><a href="javascript:;" onClick="openwin();"><?php echo $this->_tpl_vars['APP']['LNK_WEARE']; ?>
</a></td>
			 -->
			 <!--td style="padding-left:10px;padding-right:10px" class=small nowrap> <a href="index.php?module=Users&action=Logout"><?php echo $this->_tpl_vars['APP']['LBL_LOGOUT']; ?>
</a> (<?php echo $this->_tpl_vars['CURRENT_USER']; ?>
)</td-->
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
			<td class=tabSeperator><img src="<?php echo vtiger_imageurl('spacer.gif', $this->_tpl_vars['THEME']); ?>
" width=2px height=28px></td>		
			<?php $_from = $this->_tpl_vars['HEADERS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['maintabs'] => $this->_tpl_vars['detail']):
?>
				<?php if ($this->_tpl_vars['maintabs'] != $this->_tpl_vars['CATEGORY']): ?>
				  <td class="tabUnSelected"  onmouseover="fnDropDown(this,'<?php echo $this->_tpl_vars['maintabs']; ?>
_sub');" onmouseout="fnHideDrop('<?php echo $this->_tpl_vars['maintabs']; ?>
_sub');" align="center" nowrap><a href="index.php?module=<?php echo $this->_tpl_vars['detail'][0]; ?>
&action=index"><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['maintabs']]; ?>
</a><img src="<?php echo vtiger_imageurl('menuDnArrow.gif', $this->_tpl_vars['THEME']); ?>
" border=0 style="padding-left:5px"></td>
				  <td class="tabSeperator"><img src="<?php echo vtiger_imageurl('spacer.gif', $this->_tpl_vars['THEME']); ?>
"></td>
				<?php else: ?>
				  <td class="tabSelected"  onmouseover="fnDropDown(this,'<?php echo $this->_tpl_vars['maintabs']; ?>
_sub');" onmouseout="fnHideDrop('<?php echo $this->_tpl_vars['maintabs']; ?>
_sub');" align="center" nowrap><a href="index.php?module=<?php echo $this->_tpl_vars['detail'][0]; ?>
&action=index"><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['maintabs']]; ?>
</a><img src="<?php echo vtiger_imageurl('menuDnArrow.gif', $this->_tpl_vars['THEME']); ?>
" border=0 style="padding-left:5px"></td>
				  <td class="tabSeperator"><img src="<?php echo vtiger_imageurl('spacer.gif', $this->_tpl_vars['THEME']); ?>
"></td>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
		
			<td style="padding-left:10px" nowrap>
				<?php if ($this->_tpl_vars['CNT'] >= 1): ?>
					<select class=small id="qccombo" style="width:155px"  onclick="QCreate2(this);">
						<option value="none"><?php echo $this->_tpl_vars['APP']['LBL_QUICK_CREATE']; ?>
...</option>
                        <?php $_from = $this->_tpl_vars['QCMODULE']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['detail']):
?>
                        <option value="<?php echo $this->_tpl_vars['detail']['1']; ?>
"><?php echo $this->_tpl_vars['APP']['POST']; ?>
&nbsp;<?php echo $this->_tpl_vars['detail']['0']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
					</select>
				
				<?php endif; ?>	
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
				<input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
" style="margin:0px">
				<input type="text" name="query_string" value="<?php echo $this->_tpl_vars['QUERY_STRING']; ?>
" class="searchBox" onFocus="this.value=''" >
			</td>
			<td style="background-color:#cccccc">
				<input type="submit" class="searchBtn" value="<?php echo $this->_tpl_vars['APP']['LBL_FIND_BUTTON']; ?>
" alt="<?php echo $this->_tpl_vars['APP']['LBL_FIND']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_FIND']; ?>
">
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
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "Clock.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="qcform" style="position:absolute;width:700px;top:80px;left:450px;z-index:100000;"></div>

<script>
var gVTModule = '<?php echo $_REQUEST['module']; ?>
';
function fetch_clock()
{
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Utilities&action=UtilitiesAjax&file=Clock',
			onComplete: function(response)
				    {
					$("clock_cont").innerHTML=response.responseText;
					execJS($('clock_cont'));
				    }
		}
	);

}

function fetch_calc()
{
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Utilities&action=UtilitiesAjax&file=Calculator',
			onComplete: function(response)
					{
						$("calculator_cont").innerHTML=response.responseText;
						execJS($('calculator_cont'));
					}
		}
	);
}

function QCreate2(qcoptions) 
{
	var module = qcoptions.options[qcoptions.options.selectedIndex].value;
  	if(module != 'none')
  	{
		location.href = 'index.php?module='+module+'&action=EditView&return_action=DetailView&parenttab='+module;
  	}
}	
</script>

<script>
<?php echo '
function QCreate(qcoptions){
	var module = qcoptions.options[qcoptions.options.selectedIndex].value;
	/*if(module != \'none\'){
		$("status").style.display="inline";
		if(module == \'Events\'){
			module = \'Calendar\';
			var urlstr = \'&activity_mode=Events\';
		}else if(module == \'Calendar\'){
			module = \'Calendar\';
			var urlstr = \'&activity_mode=Task\';
		}else{
			var urlstr = \'\';
		}
		new Ajax.Request(
			\'index.php\',
				{queue: {position: \'end\', scope: \'command\'},
				method: \'post\',
				postBody: \'module=\'+module+\'&action=\'+module+\'Ajax&file=QuickCreate\'+urlstr,
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
		hide(\'qcform\');
	}
}

function getFormValidate(divValidate)
{
  var st = document.getElementById(\'qcvalidate\');
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
					if (window.document.QcEditView[curr_fieldname] != null && window.document.QcEditView[curr_fieldname].value.replace(/^\\s+/g, \'\').replace(/\\s+$/g, \'\').length!=0)
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
					if (window.document.QcEditView[curr_fieldname] != null && window.document.QcEditView[curr_fieldname].value.replace(/^\\s+/g, \'\').replace(/\\s+$/g, \'\').length!=0)
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
					if (window.document.QcEditView[curr_fieldname] != null && window.document.QcEditView[curr_fieldname].value.replace(/^\\s+/g, \'\').replace(/\\s+$/g, \'\').length!=0)
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
					if (window.document.QcEditView[curr_fieldname] != null && window.document.QcEditView[curr_fieldname].value.replace(/^\\s+/g, \'\').replace(/\\s+$/g, \'\').length!=0)
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
					if (window.document.QcEditView[curr_fieldname] != null && window.document.QcEditView[curr_fieldname].value.replace(/^\\s+/g, \'\').replace(/\\s+$/g, \'\').length!=0)
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
					if (window.document.QcEditView[curr_fieldname] != null && window.document.QcEditView[curr_fieldname].value.replace(/^\\s+/g, \'\').replace(/\\s+$/g, \'\').length!=0)
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
						var startdatevalue = window.document.QcEditView[datefield].value.replace(/^\\s+/g, \'\').replace(/\\s+$/g, \'\')
				}
				if(qcfieldname[j] == "time_start")
				{
					var timelabel = qcfieldlabel[j]
						var timefield = qcfieldname[j]
						var timeval=window.document.QcEditView[timefield].value.replace(/^\\s+/g, \'\').replace(/\\s+$/g, \'\')
				}
				if(qcfieldname[j] == "eventstatus" || qcfieldname[j] == "taskstatus")
				{
					var statusvalue = window.document.QcEditView[curr_fieldname].options[window.document.QcEditView[curr_fieldname].selectedIndex].value.replace(/^\\s+/g, \'\').replace(/\\s+$/g, \'\')
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
'; ?>


<div id="allMenu" onmouseout="fninvsh('allMenu');" onMouseOver="fnvshNrm('allMenu');" style="width:550px;z-index: 10000001;display:none;">
	<table border=0 cellpadding="5" cellspacing="0" class="allMnuTable" >
	<tr>
		<td valign="top">
		<?php $this->assign('parentno', 0); ?>
		<?php $_from = $this->_tpl_vars['QUICKACCESS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['parenttablist'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['parenttablist']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['parenttab'] => $this->_tpl_vars['details']):
        $this->_foreach['parenttablist']['iteration']++;
?>
			<span class="allMnuHdr"><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['parenttab']]; ?>
</span>
			<?php $_from = $this->_tpl_vars['details']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['modulelist'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['modulelist']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['modules']):
        $this->_foreach['modulelist']['iteration']++;
?>
       		<?php echo smarty_function_math(array('assign' => 'num','equation' => "x + y",'x' => $this->_tpl_vars['parentno'],'y' => 1), $this);?>

			<?php echo smarty_function_math(array('assign' => 'loopvalue','equation' => "x % y",'x' => $this->_tpl_vars['num'],'y' => 15), $this);?>

			<?php $this->assign('parentno', $this->_tpl_vars['num']); ?>
			<?php if ($this->_tpl_vars['loopvalue'] == '0'): ?>
				</td><td valign="top">
			<?php endif; ?>
			<?php $this->assign('modulelabel', $this->_tpl_vars['modules'][1]); ?>
   			<?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['modules']['1']]): ?>
   				<?php $this->assign('modulelabel', $this->_tpl_vars['APP'][$this->_tpl_vars['modules']['1']]); ?>
   			<?php endif; ?>
			<a href="index.php?module=<?php echo $this->_tpl_vars['modules']['0']; ?>
&action=index&parenttab=<?php echo $this->_tpl_vars['parenttab']; ?>
" class="allMnu"><?php echo $this->_tpl_vars['modulelabel']; ?>
</a> 
			<?php endforeach; endif; unset($_from); ?>
		<?php endforeach; endif; unset($_from); ?>
		</td>
	</tr>
</table>
</div>

<!-- Drop Down Menu in the Main Tab -->


<div id="status" style="position:absolute;display:none;left:930px;top:95px;height:27px;white-space:nowrap;"><img src="<?php echo $this->_tpl_vars['IMAGEPATH']; ?>
status.gif"></div>
<script>
function openwin()
{
            window.open("index.php?module=Users&action=about_us","aboutwin","height=520,width=515,top=200,left=300")
}

</script>


<div id="tracker" style="display:none;position:absolute;z-index:100000001;" class="layerPopup">

	<table border="0" cellpadding="5" cellspacing="0" width="200">
	<tr style="cursor:move;">
		<td colspan="2" class="mailClientBg small" id="Track_Handle"><strong><?php echo $this->_tpl_vars['APP']['LBL_LAST_VIEWED']; ?>
</strong></td>
		<td align="right" style="padding:5px;" class="mailClientBg small">
		<a href="javascript:;"><img src="<?php echo vtiger_imageurl('close.gif', $this->_tpl_vars['THEME']); ?>
" border="0"  onClick="fninvsh('tracker')" hspace="5" align="absmiddle"></a>
		</td></tr>
	</table>
	<table border="0" cellpadding="5" cellspacing="0" width="200" class="hdrNameBg">
	<?php $_from = $this->_tpl_vars['TRACINFO']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['trackinfo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['trackinfo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['trackelements']):
        $this->_foreach['trackinfo']['iteration']++;
?>
	<tr>
		<td class="trackerListBullet small" align="center" width="12"><?php echo $this->_foreach['trackinfo']['iteration']; ?>
</td>
		<td class="trackerList small"> <a href="index.php?module=<?php echo $this->_tpl_vars['trackelements']['module_name']; ?>
&action=DetailView&record=<?php echo $this->_tpl_vars['trackelements']['crmid']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['trackelements']['item_summary']; ?>
</a> </td><td class="trackerList small">&nbsp;</td></tr>
	<?php endforeach; endif; unset($_from); ?>
	</table>
</div>
	
<script>
	var THandle = document.getElementById("Track_Handle");
	var TRoot   = document.getElementById("tracker");
	Drag.init(THandle, TRoot);
</script>		

<!-- vtiger Feedback -->
<script type="text/javascript">
<?php echo '
function vtiger_feedback() {
	window.open("http://www.vtiger.com/products/crm/feedback.php?uid='; ?>
<?php global $application_unique_key; echo $application_unique_key; ?><?php echo '","feedbackwin","height=300,width=515,top=200,left=300")
}
'; ?>

</script>
<!-- vtiger news -->
<script type="text/javascript">
<?php echo '
function vtiger_news(obj) {
	$(\'status\').style.display = \'inline\';
	new Ajax.Request(
		\'index.php\',
		{queue: {position: \'end\', scope: \'command\'},
			method: \'post\',
			postBody: \'module=Home&action=HomeAjax&file=HomeNews\',
			onComplete: function(response) {
				$("vtigerNewsPopupLay").innerHTML=response.responseText;
				fnvshobj(obj, \'vtigerNewsPopupLay\');
				$(\'status\').style.display = \'none\';
			}
		}
	);
		
}
'; ?>

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
				<b><?php echo $this->_tpl_vars['APP']['LBL_OUTGOING_CALL']; ?>
</b>
			</td>
		</tr>
	</table>
	<table  border='0' cellpadding='0' cellspacing='0' width='100%' class='hdrNameBg'>
		</tr>
		<tr><td style='padding:10px;' colspan='2'>
			<?php echo $this->_tpl_vars['APP']['LBL_OUTGOING_CALL_MESSAGE']; ?>

		</td></tr>
	</table>
</div>
<!-- divs for asterisk integration :: end-->