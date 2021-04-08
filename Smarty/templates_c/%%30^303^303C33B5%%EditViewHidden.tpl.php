<?php /* Smarty version 2.6.18, created on 2018-04-03 10:46:05
         compiled from EditViewHidden.tpl */ ?>

<?php if ($this->_tpl_vars['MODULE'] == 'Emails'): ?>	
	<form name="EditView" method="POST" ENCTYPE="multipart/form-data" action="index.php">
        <input type="hidden" name="form">
        <input type="hidden" name="send_mail">
        <input type="hidden" name="contact_id" value="<?php echo $this->_tpl_vars['CONTACT_ID']; ?>
">
        <input type="hidden" name="user_id" value="<?php echo $this->_tpl_vars['USER_ID']; ?>
">
        <input type="hidden" name="filename" value="<?php echo $this->_tpl_vars['FILENAME']; ?>
">
        <input type="hidden" name="old_id" value="<?php echo $this->_tpl_vars['OLD_ID']; ?>
">

<?php elseif ($this->_tpl_vars['MODULE'] == 'Contacts'): ?>
	<?php echo $this->_tpl_vars['ERROR_MESSAGE']; ?>

    <form name="EditView" method="POST" ENCTYPE="multipart/form-data" action="index.php">
		<input type="hidden" name="activity_mode" value="<?php echo $this->_tpl_vars['ACTIVITY_MODE']; ?>
">
		<input type="hidden" name="opportunity_id" value="<?php echo $this->_tpl_vars['OPPORTUNITY_ID']; ?>
">
		<input type="hidden" name="contact_role">
		<input type="hidden" name="case_id" value="<?php echo $this->_tpl_vars['CASE_ID']; ?>
">
		<INPUT TYPE="HIDDEN" NAME="MAX_FILE_SIZE" VALUE="800000">
		<input type="hidden" name="campaignid" value="<?php echo $this->_tpl_vars['campaignid']; ?>
">

<?php elseif ($this->_tpl_vars['MODULE'] == 'Potentials'): ?>
	<form name="EditView" method="POST" action="index.php">
		<input type="hidden" name="contact_id" value="<?php echo $this->_tpl_vars['CONTACT_ID']; ?>
">

<?php elseif ($this->_tpl_vars['MODULE'] == 'Campaigns'): ?>
        <form name="EditView" method="POST" action="index.php">

<?php elseif ($this->_tpl_vars['MODULE'] == 'Timesheets'): ?>
        <form name="EditView" method="POST" id="formTmsht" action="index.php">
		
<?php elseif ($this->_tpl_vars['MODULE'] == 'Calendar'): ?>
	<input type="hidden" name="activity_mode" value="<?php echo $this->_tpl_vars['ACTIVITY_MODE']; ?>
">
	<input type="hidden" name="product_id" value="<?php echo $this->_tpl_vars['PRODUCTID']; ?>
">

<?php elseif ($this->_tpl_vars['MODULE'] == 'PurchaseOrder' || $this->_tpl_vars['MODULE'] == 'SalesOrder' || $this->_tpl_vars['MODULE'] == 'Invoice' || $this->_tpl_vars['MODULE'] == 'Quotes'): ?>
	<!-- (id="frmEditView") content added to form tag and new hidden field added,  -->
	<form id="frmEditView" name="EditView" method="POST" action="index.php" onSubmit="settotalnoofrows();calcTotal();">
	<input type="hidden" name="hidImagePath" id="hidImagePath" value="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
"/>
	<!-- End of code added -->

	<?php if ($this->_tpl_vars['MODULE'] == 'Invoice' || $this->_tpl_vars['MODULE'] == 'PurchaseOrder' || $this->_tpl_vars['MODULE'] == 'SalesOrder'): ?>
       		 <input type="hidden" name="convertmode">
	<?php endif; ?>

<?php elseif ($this->_tpl_vars['MODULE'] == 'HelpDesk'): ?>
	<form name="EditView" method="POST" action="index.php" ENCTYPE="multipart/form-data">
	<input type="hidden" name="old_smownerid" value="<?php echo $this->_tpl_vars['OLDSMOWNERID']; ?>
">
	<input type="hidden" name="old_id" value="<?php echo $this->_tpl_vars['OLD_ID']; ?>
">

<?php elseif ($this->_tpl_vars['MODULE'] == 'Leads'): ?>
        <form name="EditView" method="POST" action="index.php">
        <input type="hidden" name="campaignid" value="<?php echo $this->_tpl_vars['campaignid']; ?>
">

<?php elseif ($this->_tpl_vars['MODULE'] == 'Accounts' || $this->_tpl_vars['MODULE'] == 'Faq' || $this->_tpl_vars['MODULE'] == 'PriceBooks' || $this->_tpl_vars['MODULE'] == 'Vendors'): ?>
	<form name="EditView" method="POST" action="index.php">

<?php elseif ($this->_tpl_vars['MODULE'] == 'Documents' || $this->_tpl_vars['MODULE'] == 'HReports'): ?>
	<form name="EditView" method="POST" ENCTYPE="multipart/form-data" action="index.php">
	<input type="hidden" name="max_file_size" value="<?php echo $this->_tpl_vars['MAX_FILE_SIZE']; ?>
">
	<input type="hidden" name="form">
	<input type="hidden" name="email_id" value="<?php echo $this->_tpl_vars['EMAILID']; ?>
">
	<input type="hidden" name="ticket_id" value="<?php echo $this->_tpl_vars['TICKETID']; ?>
">
	<input type="hidden" name="fileid" value="<?php echo $this->_tpl_vars['FILEID']; ?>
">
	<input type="hidden" name="old_id" value="<?php echo $this->_tpl_vars['OLD_ID']; ?>
">
	<input type="hidden" name="parentid" value="<?php echo $this->_tpl_vars['PARENTID']; ?>
">

<?php elseif ($this->_tpl_vars['MODULE'] == 'Demandes' || $this->_tpl_vars['MODULE'] == 'Incidents' || $this->_tpl_vars['MODULE'] == 'Reunion'): ?>
	<form name="EditView" method="POST" ENCTYPE="multipart/form-data" action="index.php">
	<input type="hidden" name="statut" value="open">

<?php elseif ($this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
	<form name="EditView" method="POST" ENCTYPE="multipart/form-data" action="index.php">
	<input type="hidden" name="demandeid" value="<?php echo $this->_tpl_vars['ID']; ?>
">
	<input type="hidden" name="matricule" value="<?php echo $this->_tpl_vars['AGENTMATRICULE']; ?>
">	
	<input type="hidden" name="datecreation" value="<?php echo $this->_tpl_vars['DATEJOUR']; ?>
">	


	
<?php elseif ($this->_tpl_vars['MODULE'] == 'TraitementDemandes' || $this->_tpl_vars['MODULE'] == 'TraitementIncidents' || $this->_tpl_vars['MODULE'] == 'TraitementReunions'): ?>
	<form name="EditView" method="POST" ENCTYPE="multipart/form-data" action="index.php">
	<input type="hidden" name="statut" value="<?php echo $this->_tpl_vars['STATUT']; ?>
">
	<input type="hidden" name="demandeid" value="<?php echo $this->_tpl_vars['ID']; ?>
">
	<input type="hidden" name="ticket" value="<?php echo $this->_tpl_vars['TICKET']; ?>
">

<?php elseif ($this->_tpl_vars['MODULE'] == 'Conventions' || $this->_tpl_vars['MODULE'] == 'Tiers' || $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
	<form name="EditView" method="POST" ENCTYPE="multipart/form-data" action="index.php">
	<input type="hidden" name="organeid" id="organeid">
	<input type="hidden" name="programmeid" id="programmeid">
	<input type="hidden" name="politiqueid" id="politiqueid">
	
<?php elseif ($this->_tpl_vars['MODULE'] == 'Products'): ?>
	<?php echo $this->_tpl_vars['ERROR_MESSAGE']; ?>

	<form name="EditView" method="POST" ENCTYPE="multipart/form-data" action="index.php">
	<input type="hidden" name="activity_mode" value="<?php echo $this->_tpl_vars['ACTIVITY_MODE']; ?>
">
	<INPUT TYPE="HIDDEN" NAME="MAX_FILE_SIZE" VALUE="800000">
	

<?php else: ?>
	<?php echo $this->_tpl_vars['ERROR_MESSAGE']; ?>

	<form name="EditView" method="POST" action="index.php">
<?php endif; ?>

<input type="hidden" name="pagenumber" value="<?php echo $_REQUEST['start']; ?>
">
<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
<input type="hidden" name="mode" value="<?php echo $this->_tpl_vars['MODE']; ?>
">
<input type="hidden" name="action">
<input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
">
<input type="hidden" name="return_module" value="<?php echo $this->_tpl_vars['RETURN_MODULE']; ?>
">
<input type="hidden" name="return_id" value="<?php echo $this->_tpl_vars['RETURN_ID']; ?>
">
<input type="hidden" name="return_action" value="<?php echo $this->_tpl_vars['RETURN_ACTION']; ?>
">
<input type="hidden" name="return_viewname" value="<?php echo $this->_tpl_vars['RETURN_VIEWNAME']; ?>
">
<input type="hidden" name="reserver" value="<?php echo $this->_tpl_vars['RESERVER']; ?>
">

	<input type="hidden" name="civilite2" value="<?php echo $this->_tpl_vars['SELECTNONMODIF']['civilite']; ?>
">	
	<input type="hidden" name="sexe2" value="<?php echo $this->_tpl_vars['SELECTNONMODIF']['sexe']; ?>
">
	<input type="hidden" name="paysnaissance2" value="<?php echo $this->_tpl_vars['SELECTNONMODIF']['paysnaissance']; ?>
">
	<input type="hidden" name="nationalite2" value="<?php echo $this->_tpl_vars['SELECTNONMODIF']['nationalite']; ?>
">
	<input type="hidden" name="situationfamiliale2" value="<?php echo $this->_tpl_vars['SELECTNONMODIF']['situationfamiliale']; ?>
">
	<input type="hidden" name="nombreenfants2" value="<?php echo $this->_tpl_vars['SELECTNONMODIF']['nombreenfants']; ?>
">
	<input type="hidden" name="affectorgane2" value="<?php echo $this->_tpl_vars['SELECTNONMODIF']['affectorgane']; ?>
">
	<input type="hidden" name="affectdepartement2" value="<?php echo $this->_tpl_vars['SELECTNONMODIF']['affectdepartement']; ?>
">
	<input type="hidden" name="affectdirection2" value="<?php echo $this->_tpl_vars['SELECTNONMODIF']['affectdirection']; ?>
">
	<input type="hidden" name="affectfonction2" value="<?php echo $this->_tpl_vars['SELECTNONMODIF']['affectfonction']; ?>
">
	<input type="hidden" name="conttypecontrat2" value="<?php echo $this->_tpl_vars['SELECTNONMODIF']['conttypecontrat']; ?>
">
	<input type="hidden" name="contcategorie2" value="<?php echo $this->_tpl_vars['SELECTNONMODIF']['contcategorie']; ?>
">
	<input type="hidden" name="contstatut2" value="<?php echo $this->_tpl_vars['SELECTNONMODIF']['contstatut']; ?>
">