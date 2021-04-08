<?php /* Smarty version 2.6.18, created on 2021-04-07 17:07:08
         compiled from FAQ.tpl */ ?>
	<script type="text/javascript" src="modules/StatisticsSM/StatisticsSM.js"></script>

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
	<center><table width=80% align="center" class="styled-table">
<thead>
        <tr>
            <th colspan=2><h1> FOIRE AUX QUESTIONS (FAQ) </h1></th>
        </tr>
    </thead>
    <?php $_from = $this->_tpl_vars['INFOSFAQ']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['code'] => $this->_tpl_vars['faq']):
?>
			<tr><td class="lexiqueData"><b><?php echo $this->_tpl_vars['faq']['question']; ?>
</b></td>
				<td align=right><a href="javascript:;" onclick="showfaq('<?php echo $this->_tpl_vars['faq']['idfaq']; ?>
');" ><img src="themes/images/activate.gif"></a></td>
			</tr>
			<tr><td class="lexiqueData" style="display:none;"  colspan="2" id="REP<?php echo $this->_tpl_vars['faq']['idfaq']; ?>
"><?php echo $this->_tpl_vars['faq']['reponse']; ?>
</td></tr>

<?php endforeach; endif; unset($_from); ?>
</table></center>
