<?php /* Smarty version 2.6.18, created on 2015-11-29 20:14:03
         compiled from Home/MainHomeBlock.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'Home/MainHomeBlock.tpl', 53, false),)), $this); ?>


<div id="stuff_<?php echo $this->_tpl_vars['tablestuff']['Stuffid']; ?>
" class="MatrixLayer twoColumnWidget" style="float:left;overflow-x:hidden;overflow-y:auto;" >
	<table width="100%" cellpadding="0"  cellspacing="0" class="small" style="padding-right:0px;padding-left:0px;padding-top:0px;" >
		<tr id="headerrow_<?php echo $this->_tpl_vars['tablestuff']['Stuffid']; ?>
" class="headerrow">
		
		<?php if ($this->_tpl_vars['MOD'][$this->_tpl_vars['tablestuff']['Stufftitle']] != ""): ?>
					
						
			<?php $this->assign('stitle', $this->_tpl_vars['MOD'][$this->_tpl_vars['tablestuff']['Stufftitle']]); ?>
			
		<?php else: ?>
			<?php $this->assign('stitle', $this->_tpl_vars['tablestuff']['Stufftitle']); ?>
		<?php endif; ?>

			<td align="left" class="homePageMatrixHdr" style="height:30px;" nowrap width=50%><b>&nbsp;<?php echo $this->_tpl_vars['stitle']; ?>
&nbsp;&nbsp; </b></td>
			<td align="right" class="homePageMatrixHdr" style="height:30px;" width=25%>
				<span id="refresh_<?php echo $this->_tpl_vars['tablestuff']['Stuffid']; ?>
" style="position:relative;">&nbsp;&nbsp; </span>

			</td>
			<td align="right" class="homePageMatrixHdr" style="height:30px;" width=25% nowrap>


<?php if ($this->_tpl_vars['tablestuff']['Stufftitle'] == 'Home Page Dashboard'): ?>
				<a style='cursor:pointer;' onclick="fetch_homeDB(<?php echo $this->_tpl_vars['tablestuff']['Stuffid']; ?>
);">
					<img src="<?php echo vtiger_imageurl('windowRefresh.gif', $this->_tpl_vars['THEME']); ?>
" border="0" alt="Refresh" title="Refresh" hspace="2" align="absmiddle"/>
				</a>
<?php else: ?>
				<a style='cursor:pointer;' onclick="loadStuff(<?php echo $this->_tpl_vars['tablestuff']['Stuffid']; ?>
,'<?php echo $this->_tpl_vars['tablestuff']['Stufftype']; ?>
');">
					<img src="<?php echo vtiger_imageurl('windowRefresh.gif', $this->_tpl_vars['THEME']); ?>
" border="0" alt="Refresh" title="Refresh" hspace="2" align="absmiddle"/>
				</a>
<?php endif; ?>

			</td>
		</tr>
	</table>
	
	<table width="100%" cellpadding="0" cellspacing="0" class="small" style="padding-right:0px;padding-left:0px;padding-top:0px;">
<?php if ($this->_tpl_vars['tablestuff']['Stufftype'] == 'Module'): ?>
		<tr id="maincont_row_<?php echo $this->_tpl_vars['tablestuff']['Stuffid']; ?>
" class="show_tab winmarkModulesusr">
<?php elseif ($this->_tpl_vars['tablestuff']['Stufftype'] == 'Default' && $this->_tpl_vars['tablestuff']['Stufftitle'] != 'Home Page Dashboard'): ?>
		<tr id="maincont_row_<?php echo $this->_tpl_vars['tablestuff']['Stuffid']; ?>
" class="show_tab winmarkModulesdefBis">
<?php elseif ($this->_tpl_vars['tablestuff']['Stufftype'] == 'RSS'): ?>
		<tr id="maincont_row_<?php echo $this->_tpl_vars['tablestuff']['Stuffid']; ?>
" class="show_tab winmarkRSS">
<?php elseif ($this->_tpl_vars['tablestuff']['Stufftype'] == 'DashBoard'): ?>
		<tr id="maincont_row_<?php echo $this->_tpl_vars['tablestuff']['Stuffid']; ?>
" class="show_tab winmarkDashboardusr">
<?php elseif ($this->_tpl_vars['tablestuff']['Stufftype'] == 'Default' && $this->_tpl_vars['tablestuff']['Stufftitle'] == 'Home Page Dashboard'): ?>
		<tr id="maincont_row_<?php echo $this->_tpl_vars['tablestuff']['Stuffid']; ?>
" class="show_tab winmarkDashboarddef">
<?php elseif ($this->_tpl_vars['tablestuff']['Stufftype'] == 'Notebook' || $this->_tpl_vars['tablestuff']['Stufftype'] == 'Tag Cloud'): ?>
		<tr id="maincont_row_<?php echo $this->_tpl_vars['tablestuff']['Stuffid']; ?>
">
<?php else: ?>
		<tr id="maincont_row_<?php echo $this->_tpl_vars['tablestuff']['Stuffid']; ?>
" class="show_tab">
<?php endif; ?>
			<td colspan="2">
				<div id="stuffcont_<?php echo $this->_tpl_vars['tablestuff']['Stuffid']; ?>
" style="height:260px; overflow-y: auto; overflow-x:hidden;width:100%;height:100%;"> 
				</div>
			</td>
		</tr>
	</table>
	
	<table width="100%" cellpadding="0" cellspacing="0" class="small scrollLink">
	<tr>
		<td align="left">
			<a href="javascript:;" onclick="addScrollBar(<?php echo $this->_tpl_vars['tablestuff']['Stuffid']; ?>
);">
				<?php echo $this->_tpl_vars['MOD']['LBL_SCROLL']; ?>

			</a>
		</td>
<?php if ($this->_tpl_vars['tablestuff']['Stufftype'] == 'Module' || ( $this->_tpl_vars['tablestuff']['Stufftype'] == 'Default' && $this->_tpl_vars['tablestuff']['Stufftitle'] != 'Key Metrics' && $this->_tpl_vars['tablestuff']['Stufftitle'] != 'Home Page Dashboard' && $this->_tpl_vars['tablestuff']['Stufftitle'] != 'My Group Allocation' ) || $this->_tpl_vars['tablestuff']['Stufftype'] == 'RSS' || $this->_tpl_vars['tablestuff']['Stufftype'] == 'DashBoard'): ?>
		<td align="right">
			<a href="#" id="a_<?php echo $this->_tpl_vars['tablestuff']['Stuffid']; ?>
">
				<?php echo $this->_tpl_vars['MOD']['LBL_MORE']; ?>

			</a>
		</td>
<?php endif; ?>
	</tr>	
	</table>
</div>

<script language="javascript">
		window.onresize = function(){positionDivInAccord('stuff_<?php echo $this->_tpl_vars['tablestuff']['Stuffid']; ?>
','<?php echo $this->_tpl_vars['tablestuff']['Stufftitle']; ?>
','<?php echo $this->_tpl_vars['tablestuff']['Stufftype']; ?>
');};
	positionDivInAccord('stuff_<?php echo $this->_tpl_vars['tablestuff']['Stuffid']; ?>
','<?php echo $this->_tpl_vars['tablestuff']['Stufftitle']; ?>
','<?php echo $this->_tpl_vars['tablestuff']['Stufftype']; ?>
');
</script>	

<script language="javascript">
	function afficherTout(idElement) 
	{
		var element = document.getElementById(idElement);
		var val = '';
		
		if(element != null) 
		{
			if(element.checked == true) 
			{
				val = idElement;
			}
		}
		document.getElementById(idElement).value = val;
		
	}

</script>	