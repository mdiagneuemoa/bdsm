<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *
 ********************************************************************************/


include('include/InventoryPDF.php');
$pdf=get_quote_pdf();

$pdf->Output('storage/Quote.pdf','F'); //added file name to make it work in IE, also forces the download giving the user the option to save

// Added to fix annoying bug that includes HTML in your PDF
//echo "<script>openPopUp('xComposeEmail',this,iurl,'createemailWin',830,662,opts);</script>";
echo "<script>window.history.back();</script>";
exit();
?>
