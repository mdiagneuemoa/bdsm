
 <?php
 
require_once ("C:/wamp/www/mon-assistant-en-ligne1/config/config_inc.php");
require_once (PATH_BEANS."/Contact.php");
require_once (PATH_DAO_IMPL."/contactDaoImpl.php");
$numeroclient = $_SESSION['numeroclient'];
$numeroclient = '20120702033';
$contactdao = new ContactDao();

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

if ($_REQUEST["action"]==getAllContacts)
{
    $contacts = $contactdao->selectContactByAbonne($numeroclient);
	$listconts ="<table class='tabstyle'><tbody>";
	foreach ($contacts as $contact) 
	{
		$listconts.= "<tr><td><input type='checkbox' name='contacts[]'  value='".$contact['contactid']."'></td>";
		$listconts.= "<td>".$contact['nom']."</td><td>".$contact['email']."</td><td>".$contact['numerotel']."</td><td>".$contact['adresse']."</td><td class='catlib'>".$contact['catlib']."</td></tr>";
	}
	if(count($contacts)==0)
	{
		$listconts.= "<tr><td coslpan=5 align=center height=300>Il n'existe aucun contact dans le groupe</td>";

	}
	$listconts .="<tbody></table>";
	echo $listconts;
}

if ($_REQUEST["action"]==getContactsByCat)
{
	 $idcat = $_REQUEST['idcategorie'];
    $contacts = $contactdao->selectContactByCategorie($numeroclient,$idcat);
	$listconts ="<table class='tabstyle'><tbody>";
	foreach ($contacts as $contact) 
	{
		$listconts.= "<tr><td><input type='checkbox' name='contacts[]'  value='".$contact['contactid']."'></td>";
		$listconts.= "<td>".$contact['nom']."</td><td>".$contact['email']."</td><td>".$contact['numerotel']."</td><td>".$contact['adresse']."</td><td class='catlib'>".$contact['catlib']."</td></tr>";
	}
	if(count($contacts)==0)
	{
		$listconts.= "<tr><td coslpan=5 align=center height=300>Il n'existe aucun contact dans le groupe</td>";

	}
	$listconts .="<tbody></table>";
	echo $listconts;
}

//print_r($messages);
?> 		
