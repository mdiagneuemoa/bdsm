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
<script language="JavaScript" type="text/javascript" src="modules/PriceBooks/PriceBooks.js"></script>
{literal}
<script>
function editProductListPrice(id,pbid,price)
{
        $("status").style.display="inline";
        new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: 'action=ProductsAjax&file=EditListPrice&return_action=DetailView&return_module=PriceBooks&module=Products&parenttab=Settings&record='+id+'&pricebook_id='+pbid+'&listprice='+price,
                        onComplete: function(response) {
                                        $("status").style.display="none";
                                        $("editlistprice").innerHTML= response.responseText;
                        }
                }
        );
}

function gotoUpdateListPrice(id,pbid,proid)
{
        $("status").style.display="inline";
        $("roleLay").style.display = "none";
        var listprice=$("list_price").value;
                new Ajax.Request(
                        'index.php',
                        {queue: {position: 'end', scope: 'command'},
                                method: 'post',
                                postBody: 'module=Products&action=ProductsAjax&file=UpdateListPrice&ajax=true&return_action=CallRelatedList&return_module=PriceBooks&record='+id+'&pricebook_id='+pbid+'&product_id='+proid+'&list_price='+listprice,
                                onComplete: function(response) {
                                        $("status").style.display="none";
                                        $("RLContents").innerHTML= response.responseText;
                                }
                        }
                );
}
{/literal}

function loadCvList(type,id)
{ldelim}
	if($("lead_cv_list").value != 'None' || $("cont_cv_list").value != 'None')
	{ldelim}
        	$("status").style.display="inline";

		if(type === 'Leads')
		{ldelim}
			new Ajax.Request(
                        'index.php',
                        {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
                                method: 'post',
                                postBody: 'module=Campaigns&action=CampaignsAjax&file=LoadList&ajax=true&return_action=DetailView&return_id='+id+'&list_type='+type+'&cvid='+$("lead_cv_list").value,
                                onComplete: function(response) {ldelim}
                                        $("status").style.display="none";
                                        $("RLContents").innerHTML= response.responseText;
                                {rdelim}
                        {rdelim}
                	);
		{rdelim}

		if(type === 'Contacts')
		{ldelim}
			new Ajax.Request(
                        'index.php',
                        {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
                                method: 'post',
                                postBody: 'module=Campaigns&action=CampaignsAjax&file=LoadList&ajax=true&return_action=DetailView&return_id='+id+'&list_type='+type+'&cvid='+$("cont_cv_list").value,
                                onComplete: function(response) {ldelim}
                                        $("status").style.display="none";
                                        $("RLContents").innerHTML= response.responseText;
                                {rdelim}
                        {rdelim}
                	);
		{rdelim}
	{rdelim}
{rdelim}
</script>

<!-- Contents -->
<div id="editlistprice" style="position:absolute;width:300px;"></div>
		<!-- PUBLIC CONTENTS STARTS-->
		
			<!-- Account details tabs -->
			<tr>
				<td valign=top align=left >
					<div class="small" style="padding:5px">
		                	<table border=0 cellspacing=0 cellpadding=3 width=100% >
						<tr>
							<td valign=top align=left>
							<!-- content cache -->
								<table border=0 cellspacing=0 cellpadding=0 width=100%>
									<tr>
										<td >
										   <!-- General details -->
												{include file='RelatedListsHidden.tpl'}
												<div id="RLContents">
					                                                        {include file='RelatedListContents.tpl'}
                                        						        </div>
												</form>
										  {*-- End of Blocks--*} 
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					</div>
				</td>
			</tr>
	<!-- PUBLIC CONTENTS STOPS-->

<script>
function OpenWindow(url)
{ldelim}
	openPopUp('xAttachFile',this,url,'attachfileWin',380,375,'menubar=no,toolbar=no,location=no,status=no,resizable=no');	
{rdelim}
</script>

