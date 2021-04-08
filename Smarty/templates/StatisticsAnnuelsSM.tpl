<table border=0 cellspacing=1 cellpadding=3  class="lvt small" align=center width=100%>
										
										
										<!--tr><td class="lvtCol" align=center >{$DESCSFICHE}</td>
											<td  width=50 class="lvtCol"  height=10	valign=middle nowrap>
											<input 
												class="crmbutton small edit" 
												type="button" 
												name="Edit" 
												value="&nbsp;{$MOD.LBL_SAISIE_BUTTON_LABEL}&nbsp;">&nbsp;
											<td  width=50 class="lvtCol"	valign=middle nowrap>
											<input 
												class="crmbutton small edit" 
												type="button" 
												name="Edit" 
												value="&nbsp;{$MOD.LBL_VALIDATION_BUTTON_LABEL}&nbsp;">&nbsp;
											<td class="lvtCol" width=10	valign=middle nowrap><img src="{'exportpdf.jpg'|@vtiger_imageurl:$THEME}" width=30> &nbsp;&nbsp;
											<td class="lvtCol" width=10 valign=middle nowrap><img src="{'exportxsl.jpg'|@vtiger_imageurl:$THEME}" width=30>&nbsp;
											</td-->
										</tr-->
								</table>	
								<div id="conteneur">								
										<!--div id="table_gauche" >
										    <table border=0 cellspacing=1 cellpadding=3  class="lvt small">
												<tr>
													<td class="lvtCol">CODE <br>&nbsp;</td>
													<td class="lvtCol">INTITULE<br>&nbsp;</td>
												</tr>
											
												{assign var=decal value=''}
												{foreach item=data key=k1 from=$INDICATEURSDATAS.datas}
												{if $data.intitule|truncate:4:"" == 'Dont' }
													{assign var=decal value='&nbsp;&nbsp;&nbsp;&nbsp;'}
													{assign var=niveaustyle value='fichedont'}
												{/if}
												{if $data.niveau eq 0 && $data.intitule|truncate:4:"" != 'Dont' }
													{assign var=decal value=''}
													{assign var=niveaustyle value='fichen1'}
												{elseif $data.niveau eq 1 && $data.intitule|truncate:4:"" != 'Dont'}
													{assign var=decal value='&nbsp;&nbsp;&nbsp;&nbsp;'}
													{assign var=niveaustyle value='fichen2'}
												{elseif $data.niveau eq 2 && $data.intitule|truncate:4:"" != 'Dont'}
													{assign var=decal value='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'}
													{assign var=niveaustyle value='fichen3'}
												{elseif $data.niveau eq 3 && $data.intitule|truncate:4:"" != 'Dont'}
													{assign var=decal value='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'}
													{assign var=niveaustyle value=''}
												{elseif $data.niveau eq 4 && $data.intitule|truncate:4:"" != 'Dont'}
													{assign var=decal value='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'}	
													{assign var=niveaustyle value=''}
												{elseif $data.niveau eq 5 && $data.intitule|truncate:4:"" != 'Dont'}
													{assign var=decal value='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'}	
												{/if}				
												
														<tr bgcolor=white class="{$niveaustyle}" >
															<td>{$k1}</td><td>{$decal}{$data.intitule}</td>
														</tr>
													<tr>
												{/foreach}
											</table>
										  </div>    
										  <div id="table_droite">
										     <table border=0 cellspacing=1 cellpadding=3   class="lvt small" align=left>
												
												<tr>
														{foreach item=data key=an from=$INDICATEURSDATAS.annee}
															<td align=center class="lvtCol" width=50><b>{$data.annee}</b> <br>{$data.etat}</td>
														{/foreach}
												</tr>
												
												<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
														{foreach item=data key=an from=$INDICATEURSDATAS.annee}
															<td align=center  width=50>&nbsp;</td>
														{/foreach}
												</tr>
																								
												{foreach item=dataflux from=$INDICATEURSDATAS.datas}
														<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
															{foreach item=dataan key=an from=$dataflux.data}
																	{foreach item=dataf from=$dataan}
																		<td align=center>{$dataf}</td>
																	{/foreach}
															{/foreach}
														</tr>
													
													<tr>
													
												{/foreach}
												
											</table>
										  </div>
										</div-->
									
						</div>
				   </td>
                </tr>
                
         
            
        </table>