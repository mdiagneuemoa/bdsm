
 <tr>
	<td colspan=4 class="dvInnerHeader">
    	<b>{$APP.LBL_DETAIL_DEMANDE_TRAITEMENT}</b>
	</td>
 </tr>
 <tr><td>&nbsp;</td></tr>	
 
 <tr>
 <td>		
		<table border=0   align=center valign=bottom align=center>
		   <tr>
		   {foreach key=i item=traitement from=$LISTTRAITEMENT}
			 {assign var="k" value=$i+1}
			 		{if $i%4 eq 0}
						</tr> <tr>
					{/if}
			 		{foreach key=libelle item=value from=$traitement}
					
					   {if $libelle eq 'statut' }
								
						    {if $value eq $APP.pending}
								<td  class="reservation" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq $APP.traited}
								<td  class="traitement" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq $APP.transfered}
								<td  class="transfert" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq $APP.reopen}
								<td  class="retraitement" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq $APP.closed}
								<td  class="cloture" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{/if}
							
						{/if}
						
					{/foreach}
					
					{foreach key=libelle item=value from=$traitement}
						{if $libelle eq 'groupe' && $value neq '' }
								<br><b>Destination : </b> {$value} <br>
					    {/if}
				     {/foreach}
				     
				     {foreach key=libelle item=value from=$traitement}
						{if $libelle eq 'datemodification' && $value neq '' }
								<b>Date : </b> {$value}
					    {/if}
				     {/foreach}
				     </td>
				     
			 	 {if $i neq $NBTRAITEMENT }
				 	 	 <td><img src="{'fleche-droite.jpg'|@vtiger_imageurl:$THEME}" hspace="5" align="absmiddle" border="0"/></td>
				 {/if}
			 {/foreach}
			 </tr>
		</table>
	</td>
</tr>			 
 <tr>
	<td  height='50'>		
		<table border=0 cellspacing=4 cellpadding=4 width=100% align=center valign=bottom>
			
			<tr><td>
			{foreach key=i item=traitement from=$LISTTRAITEMENT}
								
				{assign var="k" value=$i+1}
				{assign var="j" value=$k%2}
				{if $j eq 1 }
					</tr><tr><td>
				{/if}
				
				 	<table class=small cellspacing="0" cellpadding="0" border="0" id=tab_{$i} style="display: none;" width=400 height=200 align=center valign=bottom bordercolor="eee">
						 	
					 	
						{foreach key=libelle item=value from=$traitement}
						
							{if $libelle eq 'statut'}
							
							 	 {if $value eq $APP.pending  && $value neq ''}
							 		<tr>
								 		<td colspan='2' align="center" class=dvInnerHeader><b>Statut:</b> En cours de traitement</td>
								 	</tr>
								 {elseif $value eq $APP.closed  && $value neq ''}
									<tr>
								 		<td colspan='2' align="center" class=dvInnerHeader><b>Statut:</b> Clotur&eacute;</td>
								 	</tr>
								 {elseif $value eq $APP.traited  && $value neq ''}
									<tr>
								 		<td colspan='2' align="center" class=dvInnerHeader><b>Statut:</b> Trait&eacute;(e)</td>
								 	</tr>
								 {elseif $value eq $APP.transfered  && $value neq ''}
									<tr>
								 		<td colspan='2' align="center" class=dvInnerHeader><b>Statut:</b> Transf&eacute;r&eacute;(e)</td>
								 	</tr>
								 {elseif $value eq $APP.traited  && $value neq ''}
									<tr>
								 		<td colspan='2' align="center" class=dvInnerHeader><b>Statut:</b> A Traiter</td>
								 	</tr>
								 {elseif $value eq $APP.reopen  && $value neq ''}
									<tr>
								 		<td colspan='2' align="center" class=dvInnerHeader><b>Statut:</b> A Retraiter</td>
								 	</tr>
								 {/if}
						        
							{elseif $libelle eq 'description'  && $value neq ''}
								<tr>
									<td class=dvtCellInfo colspan='2'>Description : <br>{$value}</td>
								</tr>
							{elseif $libelle eq 'datemodification'  && $value neq ''}
								<tr>
									<td width=100 class=dvtCellLabel>Date :</td>
									<td width=300 class=dvtCellInfo>{$value}</td>
								</tr>
							{elseif $libelle eq 'nom'  && $value neq ''}
								<tr>
									<td width=100 class=dvtCellLabel>Nom :</td>
									<td width=300 class=dvtCellInfo>{$value} {$APP.$value}</td>
								</tr>
							{elseif $libelle eq 'groupname'  && $value neq ''}
								<tr>
									<td width=100 class=dvtCellLabel>Groupe :</td>
									<td width=300 class=dvtCellInfo>{$value}</td>
								</tr>
							{elseif $libelle eq 'groupe'  && $value neq ''}
								<tr>
									<td width=100 class=dvtCellLabel>{$APP.transfered} au :</td>
									<td width=300 class=dvtCellInfo>{$value}</td>
								</tr>
							{/if}
							{*elseif $libelle neq 'nom'  && $value neq ''}
								<tr>
									<td width=100 class=dvtCellLabel>{$libelle} :</td>
									<td width=300 class=dvtCellInfo>{$value} {$APP.$value}</td>
								</tr>
							{/if*}
						{/foreach}
							
				 	</table>
					
			 {/foreach}
			  </td>
		     </tr>
		     
		</table>
	</td>
 </tr>



