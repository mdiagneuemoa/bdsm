<table border=0 cellspacing=1 cellpadding=3  class="lvt small" align=center width=100%>
										<tr><td class="lvtCol" align=center >{$DESCSFICHE}</td>
											<td class="lvtCol" width=10	valign=middle nowrap><img src="{'actionGeneratePDF.gif'|@vtiger_imageurl:$THEME}" width=30 height=30> &nbsp;&nbsp;
											<td class="lvtCol" width=10 valign=middle nowrap><img src="{'exportxsl.jpg'|@vtiger_imageurl:$THEME}" width=30 height=30>&nbsp;
											</td>
										</tr>
								</table>	
								<div id="conteneur">								
										<div id="table_gauche">
										    <table border=0 cellspacing=1 cellpadding=3  class="lvt small">
											{if count($INDICATEURSDATAS.datas) neq 0}
												<tr>
													<td class="lvtCol">CODE</td><td class="lvtCol">INTITULE</td>
												</tr>
												<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
													<td>&nbsp;</td><td>&nbsp;</td>
												</tr>
												<!--tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
													<td>&nbsp;</td><td><b>INDICES PAR FONCTION</b></td>
												</tr-->
											{/if}
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
														{foreach item=data key=annee from=$INDICATEURSDATAS.mois}
															<td align=center class="lvtCol" width=50 colspan={$data|@count}><b>{$annee}</b></td>
														{/foreach}
												</tr>
												<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
													{foreach item=data key=annee from=$INDICATEURSDATAS.mois}
														{foreach item=data key=mois from=$data}
															{if $mois neq '0'}
																<td align=center width=50><b>{$MOISSTATS.$mois}</b></td>
															{/if}
														{/foreach}
													{/foreach}
												</tr>
												<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
													{foreach item=data key=annee from=$INDICATEURSDATAS.mois}
														{foreach item=data key=mois from=$data}
															{if $mois neq '0'}
																<td align=center width=50>&nbsp;</td>
															{/if}
														{/foreach}
													{/foreach}
												</tr>
												
												{foreach item=dataflux from=$INDICATEURSDATAS.datas}
														<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
															{foreach item=dataan key=an from=$dataflux.data}
																{foreach item=datamois key=mois from=$dataan}
																	{foreach item=dataf from=$datamois}
																		<td align=center>{$dataf}</td>
																	{/foreach}
																{/foreach}
															{/foreach}
														</tr>
													
													<tr>
												{/foreach}
											</table>
										  </div>
										</div>
									
						</div>
				   </td>
                </tr>
                
         
            
        </table>