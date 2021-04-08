<?php
// charge la librairie Smarty

require_once(SMARTY_DIR . 'Smarty.class.php');
// le fichier setup.php est un bon
// endroit pour charger les fichiers
// de librairies de l'application et vous pouvez
// faire celà juste ici. Par exemple :


class Smarty_postePCCI extends Smarty {
function Smarty_postePCCI() {
// Constructeur de la classe.
// Appelé automatiquement à l'instanciation de la classe.
$this->Smarty();
$smarty->template_dir = PATH_PROJET.'/templates/';
$smarty->compile_dir = PATH_PROJET.'/templates_c/';
$smarty->config_dir = PATH_PROJET.'/configs/';
$smarty->cache_dir = PATH_PROJET.'/cache/';
$this->caching = true;
$this->assign('app_name', 'Poste PCCI');
}
}
?>