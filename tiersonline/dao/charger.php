<?php
/*
 * Created on 6 mai 08
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 // the following code will make it so that the class directory is in your include_path // this allows the __autoload function to work.
$cur = ini_get("include_path");
$cur .= PATH_SEPARATOR.dirname(__FILE__).'\\include\\class\\';;
ini_set("include_path", $cur);

// this will load any classes that are not found and are located in the // /include/class/ folder.

function __autoload($class) {
include($class . '.php');

/* Check to see it the include defined the class */  if ( !class_exists($class, false) ) {
  trigger_error("Unable to load class $class", E_USER_ERROR);  } } 
 
?>
