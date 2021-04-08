<table border=0 cellspacing=1 cellpadding=3  class="lvt small" align=center width=100%>
										<tr><td class="lvtCol" align=center >INDICES HARMONISES DES PRIX A LA CONSOMMATION (IHPC)</td>
											<td class="lvtCol" width=10	valign=middle nowrap><img src="{'actionGeneratePDF.gif'|@vtiger_imageurl:$THEME}" width=30 height=30> &nbsp;&nbsp;
											<td class="lvtCol" width=10 valign=middle nowrap><img src="{'exportxsl.jpg'|@vtiger_imageurl:$THEME}" width=30 height=30>&nbsp;
											</td>
										</tr>
								</table>	
								<div id="conteneur">								
										<div id="table_gauche">
										    <table border=0 cellspacing=1 cellpadding=3  class="lvt small">
												<tr>
													<td class="lvtCol">CODE</td><td class="lvtCol">INTITULE</td>
												</tr>
												<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
													<td>&nbsp;</td><td>&nbsp;</td>
												</tr>
												
												{foreach item=data key=k1 from=$INDICATEURSDATAS.datas}
													{if $data.niveau eq 0}
														<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
															<td><b>{$k1}</b></td><td><b>{$data.intitule}</b></td>
														</tr>
													{else}
														<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
															<td>{$k1}</td><td>&nbsp;&nbsp;{$data.intitule}</td>
														</tr>
													{/if}
													<tr>
												{/foreach}
											</table>
										  </div>    
										  <div id="table_droite">
										     <table border=0 cellspacing=1 cellpadding=3   class="lvt small" align=left>
												<tr>
														{foreach item=data key=annee from=$INDICATEURSDATAS.trimestre}
															<td align=center class="lvtCol" width=50 colspan={$data|@count}><b>{$annee}</b></td>
														{/foreach}
												</tr>
												<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
													{foreach item=data key=annee from=$INDICATEURSDATAS.trimestre}
														{foreach item=data key=trimestre from=$data}
															{if $trimestre neq '0'}
																<td align=center width=50><b>{$TRIMESTRESTATS.$trimestre}</b></td>
															{/if}
														{/foreach}
													{/foreach}
												</tr>
												<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
													{foreach item=data key=annee from=$INDICATEURSDATAS.trimestre}
														{foreach item=data key=trimestre from=$data}
															{if $trimestre neq '0'}
																<td align=center width=50>&nbsp;</td>
															{/if}
														{/foreach}
													{/foreach}
												</tr>
												
												{foreach item=dataflux from=$INDICATEURSDATAS.datas}
														<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
															{foreach item=dataan key=an from=$dataflux.data}
																{foreach item=datamois key=trimestre from=$dataan}
																	{foreach item=dataf from=$datamois}
																		<td align=center>{$dataf}</td>
																	{/foreach}
																	{foreachelse}
																<td align=center>&nbsp;</td>
																{/foreach}
															
															{/foreach}
															
														</tr>
													
												{/foreach}
												
											</table>
										  </div>
										</div>
									
						</div>
				   </td>
                </tr>
                
         
            
        </table>