 <?
 // Cette fonction peut �tre d�clar�e dans un 
 // fichier include commun. 
 function __autoload($class_name) {
   require_once 'modules/Timesheets/'.$class_name.'.php';
 }
 ?>