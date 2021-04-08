
 <tr>
	<td colspan=4 class="dvInnerHeader">
    	<b>{$APP.LBL_DETAIL_DEMANDE_TRAITEMENT}</b>
	</td>
 </tr>
 <tr><td>&nbsp;</td></tr>	
 
 <tr>
 <td>		
		<table border=0   align=center valign=bottom align=center>
		   <tr align=center>
		   {foreach key=i item=traitement from=$LISTTRAITEMENT}
			 		{assign var="k" value=$i+1}
			 		{if $i%4 eq 0}
						</tr> <tr>
					{/if}
			 		{foreach key=libelle item=value from=$traitement}
					
					   {if $libelle eq 'statut' }
							
						    {if $value eq 'open'}
								<td  class="submitted" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq 'submitted' || $value eq 'submitted_grcj' || $value eq 'sup_submitted'}
								<td  class="submitted" width=180 height=30 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq 'dir_accepted' || $value eq 'dc_submitted' || $value eq 'dcpc_submitted' }
								<td  class="accepted" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq 'reopen'}
								<td  class="reopen" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq 'dc_accepted' || $value eq 'grcj_accepted' || $value eq 'dc_authorized' || $value eq 'signed'}
								<td  class="accepted" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq 'com_accepted' || $value eq 'prcj_accepted'}
								<td  class="accepted" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq 'umv_accepted' || $value eq 'rumv_accepted'}
								<td  class="accepted" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq 'authorized' || $value eq 'pr_authorized'}
								<td  class="authorized" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq 'ch_cancelled' || $value eq 'grcj_cancelled' || $value eq 'prcj_cancelled'  }
								<td  class="cancelled" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq 'dir_cancelled'}
								<td  class="cancelled" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq 'dc_cancelled' }
								<td  class="cancelled" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq 'dcpc_omcancelled' }
								<td  class="cancelled" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq 'om_cancelled' }
								<td  class="cancelled" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq 'com_cancelled'}
								<td  class="cancelled" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">
							{elseif $value eq 'ag_cancelled'}
								<td  class="cancelled" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">	
							{elseif $value eq 'dir_denied'}
								<td  class="denied" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">	
							{elseif $value eq 'dc_denied' || $value eq 'grcj_denied' || $value eq 'prcj_denied'}
								<td  class="denied" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">	
							{elseif $value eq 'dcpc_denied'}
								<td  class="denied" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">	
							{elseif $value eq 'com_denied'}
								<td  class="denied" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">	
							{elseif $value eq 'umv_denied'}
								<td  class="denied" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">	
							{elseif $value eq 'umv_tobecorrected'}
								<td  class="tobecorrected" width=180 height=80 onClick="javascript:displayTraitementById('tab_{$i}' , {$NBTRAITEMENT });">	
							{/if}
					{/if}	
					{/foreach}
					
					
				     {foreach key=libelle item=value from=$traitement}
					 {if $libelle eq 'statut' && $value neq '' }
								<b>{$APP.$value}</b> 
					    {/if}<br>
						{if $libelle eq 'datemodification' && $value neq '' }
								 {$value}
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
	<td>		
		<table class=tabs border=0 cellspacing=4 cellpadding=4 width=100% align=center valign=bottom>
			
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
							
							 	    <tr>
								 		<td colspan='2' align="center" class=dvInnerHeader><b>Statut:</b> {$APP.$value} </td>
								 	</tr>
							{elseif $libelle eq 'description' && $value neq ''}
								<tr>
									<td class=dvtCellInfo colspan='2'>Description : <br>{$value}</td>
								</tr>
							{elseif $libelle eq 'datemodification' && $value neq ''}
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
							{elseif $libelle eq 'groupe' && $value neq '' }
								<tr>
									<td width=100 class=dvtCellLabel>{$APP.transfered} au :</td>
									<td width=300 class=dvtCellInfo> {$value} </td>
								</tr>
							
							{elseif $libelle eq 'motif' && $value neq ''}
								<tr>
									<td width=100 class=dvtCellLabel>{$libelle} :</td>
									<td width=300 class=dvtCellInfo>{$value} {$APP.$value}</td>
								</tr>
							{elseif $libelle eq 'autremotif' && $value neq ''}
								<tr>
									<td width=100 class=dvtCellLabel>{$libelle} :</td>
									<td width=300 class=dvtCellInfo>{$value}</td>
								</tr>
							{/if}
						{/foreach}
							
				 	</table>
				
			 {/foreach}
			 </td>
		     </tr>
		     
		</table>
	</td>
 </tr>



