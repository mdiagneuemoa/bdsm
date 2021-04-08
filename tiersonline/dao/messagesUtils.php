
 <?php
 
require_once ("C:/wamp/www/mon-assistant-en-ligne1/config/config_inc.php");
require_once (PATH_BEANS."/Message.php");
require_once (PATH_DAO_IMPL."/messageDaoImpl.php");
$numeroclient = $_SESSION['numeroclient'];
$numeroclient = '20120702033';
$messagedao = new MessageDao();

if ($_REQUEST["action"]==getCategories)
{
	$categories = $contactdao->selectCategorieByAbonne($numeroclient);
	$listcats ="<ul>";
	foreach ($categories as $cat) 
	{
		$listcats .= "<li><a href='#' onclick='showContacts(\'".$cat['categorie']."\')'>".$cat['libelle']."(".$cat['nb'].")</a></li>";
	}
	$listcats .="</ul>";

	echo $listcats;
}

if ($_REQUEST["action"]==saveCategorie)
{
	$newcategorie = $_REQUEST["newcategorie"];
	if( $contactdao->addCategorie($newcategorie,$numeroclient))
	{
		$categories = $contactdao->selectCategorieByAbonne($numeroclient);
		$listcats ="<ul>";
		foreach ($categories as $cat) 
		{
			$listcats .= "<li><a href='#' name='listcats[]'>".$cat['libelle']."(".$cat['nb'].")</a></li>";
		}
		$listcats .="</ul>";

		echo $listcats;
	}	
}

if ($_REQUEST["action"]==getAllMessages)
{
    $messages = $messagedao->selectMessageByAbonne($numeroclient);
	$listmsgs ="<table class='tabstyle'><tbody>";
	
	foreach ($messages as $message) 
	{
		if ($message['nomcontact']!='') $contact = $message['nomcontact']; else $contact = $message['numeroappelant']; 
		if ($message['urgent']==1) $urgent = "<img src='images/urgent.jpg' title='urgent'>&nbsp;&nbsp;"; else $urgent="&nbsp;"; 

		$messagetext = '<a href="#" onclick="viewMessages(\''.$message['messageid'].'\');">'.changeAccented($message['message']).'</a>';
		$listmsgs.= "<tr><td><input type='checkbox' name='messages[]' value='".$message['messageid']."'></td>";
		$listmsgs.= "<td nowrap>".$contact."</td><td width=18 align=right>".$urgent."</td><td><img src='images/".$message['icone']."'>&nbsp;&nbsp;".$messagetext."</td><td nowrap>".$message['dateappel']."</td></tr>";
	}
	if(count($messages)==0)
	{
		$listmsgs.= "<tr><td coslpan=4 align=center height=300>Il n'existe aucun message dans ce dossier</td>";

	}
	$listmsgs .="<tbody></table>";

	echo $listmsgs;

}

if ($_REQUEST["action"]==getMessagesByCat)
{
	 $idcat = $_REQUEST['idcategorie'];
       $messages = $messagedao->selectMessageByForder($numeroclient,$idcat);
	$listmsgs ="<table class='tabstyle'><tbody>";
	
	foreach ($messages as $message) 
	{
		if ($message['nomcontact']!='') $contact = $message['nomcontact']; else $contact = $message['numeroappelant']; 
		if ($message['urgent']==1) $urgent = "<img src='images/urgent.jpg' title='urgent'>&nbsp;&nbsp;"; else $urgent="&nbsp;"; 

		$messagetext = '<a href="#" onclick="viewMessages(\''.$message['messageid'].'\')">'.changeAccented($message['message']).'</a>';
		$listmsgs.= "<tr><td><input type='checkbox' name='messages[]' value='".$message['messageid']."'></td>";
		$listmsgs.= "<td nowrap><td width=18 align=right>".$urgent."</td></td><td><img src='images/".$message['icone']."'>&nbsp;&nbsp;".$messagetext."</td><td nowrap>".$message['dateappel']."</td></tr>";
	}
	if(count($messages)==0)
	{
		$listmsgs.= "<tr><td coslpan=5 align=center height=300>Il n'existe aucun message dans ce dossier</td>";

	}
	$listmsgs .="<tbody></table>";

	echo $listmsgs;
}


if ($_REQUEST["action"]==getMessageById)
{
	 $idmessage = $_REQUEST['idmessage'];
       $listmessage = $messagedao->findMessageById($idmessage);
	   $message = $listmessage[0];
	$detailmsg ="";
	
	if ($message['nomcontact']!='') $contact = $message['nomcontact']; else $contact = $message['numeroappelant']; 
	if ($message['urgent']==1) $urgent = "<img src='images/urgent.jpg'>&nbsp;&nbsp;"; else $urgent=""; 

	$messagetext = changeAccented($message['message']);
	/*$detailmsg.= "<tr><td nowrap>".$contact."</td><td>".$message['dateappel']."</td></tr>";
	$detailmsg.= "<tr><td colpan=2>".$messagetext."</td></tr>";
	$detailmsg .="<tbody></table>";*/

	
	$detailmsg.= "<a href='#' id='boiterecept'  title='Retour a la Boite de Reception'><img border='0'  src='images/retour2.jpg'/></a>
				  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <a href='#' id='delmessage' alt='Supprimer le message' title='Supprimer le message'><img border='0'  src='images/del.jpg'/></a>
				 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <a href='#' id='add2contact' title='Ajouter au contact'><img border='0'  src='images/contacts.jpg'/></a>
				<div>&nbsp;&nbsp; ".$urgent."  <img src='images/".$message['icone']."'><b>&nbsp;&nbsp; MESSAGE DE MON ASSISTANT</b></div><hr><br>
						<table border=0 cellspacing=1 cellpadding=1  class='tabdetstyle' >
						<tr>
			   					<td rowspan=4 valign=top width=50><img src='images/profile_icone.png'></td>
								<td valign=middle><b>De :&nbsp;&nbsp;</b>".$contact."</td>
								<td  align=right >".$message['dateappel']."</td>
							</tr>
            				<tr>
								<td scolspan=2>&nbsp;</td>
							</tr>
						
							<tr>
								<td  width='50px' colspan=2><span>".$messagetext."</td>
							</tr>
						</table>";
	
	echo $detailmsg;
}

//print_r($messages);
?> 		
