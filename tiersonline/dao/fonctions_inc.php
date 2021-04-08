<?php


function debug_tableau($tab) {
	echo "<pre>";
	print_r($tab);
	echo "</pre>";	
}

///////////////////////////////////////////////////////////////
// dernier id de l'utilisateur correspondant à l'identifiant //
// ou au nom null sinon                                      //
///////////////////////////////////////////////////////////////
function getUtilisateurId($identifiant)
{
	// connexions à la base
	$db = new DB_Sql();
	$db->Host = DB_HOST;
	$db->User = DB_USER;
	$db->Password = DB_PASSWORD;
	$db->Database = DB_DATABASE;

	$sql  = "SELECT ";
	$sql .= "utilisateur_id ";
	$sql .= "FROM utilisateur ";
	$sql .= "WHERE identifiant='".strtoupper($identifiant)."' and date_fin IS NULL";

	if (TRACE) $trace->Trace_Info("requete = [$sql]");
	if (!$db->query($sql)) return "null";

	if ($db->nf()<=0)
	{
		// Rechercher dans le nom
		$sql  = "SELECT ";
		$sql .= "utilisateur_id ";
		$sql .= "FROM utilisateur ";
		$sql .= "WHERE nom='".strtoupper($identifiant)." ";
		$sql .= "ORDER BY utilisateur_id DESC";

		if (!$db->query($sql)) return "null";

		if ($db->nf()>=1)
		{
			$db->next_record();
			return $db->f("utilisateur_id");
		}
		else
		{
			return "null";
		}
	}
	else
	{
		$db->next_record();
		return $db->f("utilisateur_id");
	}
}

function initBase() {
	$db = new DB_Sql();
	$db->Host = DB_HOST;
	$db->User = DB_USER;
	$db->Password = DB_PASSWORD;
	$db->Database = DB_DATABASE;
	return $db;
}

///////////////////////////////////////////////////////////////
// AAAA-MM-JJ HH:MM:SS -> JJ/MM/AAAA HH:MM:SS                //
// opt=1 : AAAA-MM-JJ HH:MM:SS -> JJ/MM/AAAA                 //
///////////////////////////////////////////////////////////////
function convertDate($date,$opt="0")
{
	if (strlen($date)>=8)
	{
		$aaaa=substr($date,0,4);
		$mm=substr($date,5,2);
		$jj=substr($date,8,2);
		$reste=substr($date,10);
		if ($opt==0) return $jj."/".$mm."/".$aaaa.$reste;
		if ($opt==1) return $jj."/".$mm."/".$aaaa;
	}
	else
	{
		return "";
	}
}
///////////////////////////////////////////////////////////////
// AAAA-MM-JJ HH:MM:SS -> MM/JJ/AAAA PM                      //
// opt=1 : AAAA-MM-JJ HH:MM:SS -> MM/JJ/AAAA                 //
///////////////////////////////////////////////////////////////
function convertDateMJA($date,$opt="0")
{
	if (strlen($date)>=8)
	{
		$aaaa=substr($date,0,4);
		$mm=substr($date,5,2);
		$jj=substr($date,8,2);
		$reste=substr($date,10);
		if ($opt==0) return $mm."/".$jj."/".$aaaa.$reste;
		if ($opt==1) return $mm."/".$jj."/".$aaaa;
	}
	else
	{
		return "";
	}
}
///////////////////////////////////////////////////////////////
// MM/JJ/AAAA -> AAAA-MM-JJ                                  //
///////////////////////////////////////////////////////////////
function convertDate2($date)
{
	if (strlen($date)==10)
	{
		$mm=substr($date,0,2);
		$jj=substr($date,3,2);
		$aaaa=substr($date,6,4);
		return $aaaa."-".$mm."-".$jj;
	}
	else
	{
		return "";
	}
}
///////////////////////////////////////////////////////////////
// JJ/MM/AAAA -> AAAA-MM-JJ                                  //
///////////////////////////////////////////////////////////////
function convertDate2old($date)
{
	if (strlen($date)==10)
	{
		$jj=substr($date,0,2);
		$mm=substr($date,3,2);
		$aaaa=substr($date,6,4);
		return $aaaa."-".$mm."-".$jj;
	}
	else
	{
		return "";
	}
}
///////////////////////////////////////////////////////////////
// AAAA-MM-JJ - JJ/MM/AAAA                                   //
///////////////////////////////////////////////////////////////
function convertDate3($date)
{
	if (strlen($date)==10)
	{
		$aaaa=substr($date,0,4);
		$mm=substr($date,5,2);
		$jj=substr($date,8,2);
		return $jj."-".$mm."-".$aaaa;
	}
	else
	{
		return "";
	}
}

///////////////////////////////////////////////////////////////
// Split de AAAA-MM-JJ HH:MM:SS                              //
///////////////////////////////////////////////////////////////
function convertDate4($date)
{
	$tmp=array();
	
	if (strlen($date)==19)
	{
		$a = split(" ",$date);
		$b = split("-", $a[0]);
		$c = split(":", $a[1]);
		$tmp["date"]=$b;
		$tmp["heure"]=$c;
	}
	
	return $tmp;
	
}



///////////////////////////////////////////////////////////////
// Table -> Tableau                                          //
///////////////////////////////////////////////////////////////
function getArrayFromTable($table_name,$key_name,$val_name)
{
	// connexions à la base
	$db = new DB_Sql();
	$db->Host = DB_HOST;
	$db->User = DB_USER;
	$db->Password = DB_PASSWORD;
	$db->Database = DB_DATABASE;

	$tab = array();
	$sql="SELECT ".$key_name." as code,".$val_name." as libelle FROM ".$table_name;
	if (TRACE) $trace->Trace_Info("requete = [$sql]");
	$db->query($sql,__LINE__,__FILE__);
	while ($db->next_record())
	{
		$tab[$db->f('code')]=$db->f('libelle');
	}
	return $tab;
}
/**
 * fonction pour changer les caractères spéciaux
 */
function changeAccented($text) {
	$replace = array (

		"À" => "&#192;",
		"Â" => "&#194;",
		"Ä" => "&#196;",

		"Ç" => "&#199;",

		"È" => "&#200;",
		"É" => "&#201;",
		"Ê" => "&#202;",
		"Ë" => "&#203;",

		"Î" => "&#206;",
		"Ï" => "&#207;",

		"Ù" => "&#217;",
		"Ú" => "&#218;",
		"Û" => "&#219;",
		"Ü" => "&#220;",

		"à" => "&#224;",
		"â" => "&#226;",
		"ä" => "&#228;",

		"ç" => "&#231;",
		"è" => "&#232;",
		"é" => "&#233;",
		"ê" => "&#234;",
		"ë" => "&#235;",

		"î" => "&#238;",
		"ï" => "&#239;",

		"ô" => "&#244;",
		"ö" => "&#245;",

		"ù" => "&#249;",
		"û" => "&#251;",
		"ü" => "&#252;"

		
	);
	
	$text = str_replace("’","'",  $text);
	$text = str_replace("–","-",  $text);
	
	$text = str_replace ( "\'",  '&#39;', $text );
	$text =	$ville = str_replace ( "'",  '&#39;', $text );
	
	for ($i = 0; $i < strlen($text); $i++) {
		if (array_key_exists($text[$i],$replace )) {
			
			$key = $text[$i];
			$val = $replace[$key];
			
			$text = str_replace($key,$val,  $text);
			
		}
	}
	
	return $text;
}


function indent($hrarray,$folderout,$folder_det,$numeroclient)
{
	global $theme,$mod_strings,$app_strings;
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
	foreach($hrarray as $folderid => $value)
	{
	
		//retreiving the vtiger_folder details
		$folder_det_arr=$folder_det[$folderid];
		$folderid_arr=$folder_det_arr[2];
		
		$foldername = $folder_det_arr[0];
		$folderdepth = $folder_det_arr[1]; 
		$foldernbmsg = $folder_det_arr[3]; 
		
		
		$folderout .= '<ul id="'.$folderid.'" style="display:block;list-style-type:none;">';
		$folderout .=  '<li ><table border="0" cellpadding="0" cellspacing="0" onMouseOver="fnVisible(\'layer_'.$folderid.'\')" onMouseOut="fnInVisible(\'layer_'.$folderid.'\')">';
		$folderout.= '<tr class="small"><td nowrap>';
		if(sizeof($value) >0 && $folderdepth != 0)
		{	
			//$folderout.='<b style="font-weight:bold;margin:0;padding:0;cursor:pointer;">';
			$folderout .= '<img src="' . vtiger_imageurl('minus.gif', $theme) . '" id="img_'.$folderid.'" border="0"  alt="'.$app_strings['LBL_EXPAND_COLLAPSE'].'" title="'.$app_strings['LBL_EXPAND_COLLAPSE'].'" align="absmiddle" onClick="showhide2(\''.$folderid_arr.'\',\'img_'.$folderid.'\',\'dossier_'.$folderid.'\')" style="cursor:pointer;">';
							
		}
		
		if($folderdepth == 0){
			$folderout .= '<img src="' . vtiger_imageurl('menu_root.gif', $theme) . '" id="img_'.$folderid.'" border="0"  alt="'.$app_strings['LBL_ROOT'].'" title="'.$app_strings['LBL_ROOT'].'" >';
			$folderout .= '&nbsp;<b class="smallf"><a class="smallf" href="index.php?action=ListView&module=Messages&parenttab=Satellite&folderid='.$folderid.'">'.$foldername.'('.$foldernbmsg.')</a></b></td>';
			//$folderout .= '<td nowrap><div id="layer_'.$folderid.'" class="drag_Element"><a onClick="createFolderss(this,\'orgLay\',\''.$folderid.'\',\''.$foldername.'\',\'0\',\'Document\');" href="#"><img src="' . vtiger_imageurl('Rolesadd.gif', $theme) . '" align="absmiddle" border="0" alt="Ajouter un sous-dossier" title="Ajouter un sous-dossier"></a></div></td>';
			$folderout .= '<td nowrap><div id="layer_'.$folderid.'" class="drag_Element"><a onClick="return ajoutDossier(\''.$numeroclient.'\');" href="#"><img src="' . vtiger_imageurl('Rolesadd.gif', $theme) . '" align="absmiddle" border="0" alt="Ajouter un sous-dossier" title="Ajouter un sous-dossier"></a></div></td>';
			$folderout .= '</tr></table>';
		}
		else{
			
			$folderout .= '&nbsp;<a class="smallf" href="index.php?action=ListView&module=Messages&parenttab=Espace Rapportage&folderid='.$folderid.'">';
			$folderout .= '<img src="' . vtiger_imageurl('dossier.jpg', $theme) . '" id="dossier_'.$folderid.'" border="0"  align="absmiddle" style="cursor:pointer;">&nbsp;'.$foldername.'('.$foldernbmsg.')</a></td>';
			$folderout .='</div></td>';
			$folderout.='<td nowrap><div id="layer_'.$folderid.'" class="drag_Element">';

			if($folderid == 1 )
			{
					//$folderout.='<a href="#" onClick="createFolderss(this,\'orgLay\',\''.$folderid.'\',\''.$foldername.'\',\''.$potentialid.'\',\'Document\');"><img src="' . vtiger_imageurl('Rolesadd.gif', $theme) .'" align="absmiddle" border="0" alt="Ajouter un sous-dossier" title="Ajouter un sous-dossier"></a>';
					$folderout .= '<td nowrap><div id="layer_'.$folderid.'" class="drag_Element"><a onClick="return ajoutDossier(\''.$numeroclient.'\');" href="#"><img src="' . vtiger_imageurl('Rolesadd.gif', $theme) . '" align="absmiddle" border="0" alt="Ajouter un sous-dossier" title="Ajouter un sous-dossier"></a></div></td>';

			}
			if($folderid != 1 && $folderid != 2 && $folderid != 3 && $folderid != 4)
			{
							
				$folderout .=	'<a href="#" onClick="DeleteFolderCheck(\''.$folderid.'\',\''.$foldername.'\',\'Document\');"><img src="' . vtiger_imageurl('RolesDelete.gif', $theme) . '" align="absmiddle" border="0" alt="Supprimer le dossier" title="Supprimer le dossier"></a>';
			}		
			
			$folderout .=	'</tr></table>';

		}
 		$folderout .=  '</li>';
		if(sizeof($value) > 0 )
		{
			$folderout = indent($value,$folderout,$folder_det);
		}

		$folderout .=  '</ul>';

	}

	return $folderout;
}	


?>
