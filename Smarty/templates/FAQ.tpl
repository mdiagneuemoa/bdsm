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
    {foreach item=faq key=code from=$INFOSFAQ}
			<tr><td class="lexiqueData"><b>{$faq.question}</b></td>
				<td align=right><a href="javascript:;" onclick="showfaq('{$faq.idfaq}');" ><img src="themes/images/activate.gif"></a></td>
			</tr>
			<tr><td class="lexiqueData" style="display:none;"  colspan="2" id="REP{$faq.idfaq}">{$faq.reponse}</td></tr>

{/foreach}
</table></center>

