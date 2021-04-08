<?php
include_once("interventionUtils.php");
session_start();

if ( !isset($_SESSION['interventions'] ) ) {
    $_SESSION['interventions'] = array();
    $_SESSION['nextID'] = 1;
}

if ( !isset($_SESSION['toDelete'] ) ) {
    $_SESSION['toDelete'] = array();
    $_SESSION['nextIDDel'] = 1;
}

$request = null;

if ( isset( $_POST['addInterv'] ) ) 
{
	$request = new AddItemRequest();
	$_SESSION['dureeTotIntervs']=$_POST['dureeTot'];
}

if ( isset( $_POST['dellInterv'] ) ) 
{
    //$request = new DelItemRequest();
	$idDel = $_SESSION['nextIDDel'];
	$_SESSION['toDelete'][$idDel]=$_POST['ID'];
	$_SESSION['nextIDDel']++;
	$_SESSION['dureeTotIntervs']=$_POST['dureeTot'];
} 

/*else if ( isset( $_POST['setiteminfo'] ) ) {
    $request = new SetItemInfoRequest();
} else if ( isset( $_POST['getitems'] ) ) {
    $request = new GetItemsRequest();
}
*/

if ($request)
 {
     $request->serve();
    exit(0);
}
?>