<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
require_once('data/CRMEntity.php');
require_once('data/Tracker.php');

class Agentuemoa extends CRMEntity {
	var $db, $log; // Used in class functions of CRMEntity
	
	var $table_name = 'tiers_agentsuemoa';
	var $table_index= 'agentid';
	var $column_fields = Array();
	
	/** Indicator if this is a custom module or standard module */
	var $IsCustomModule = true;

	var $tab_name = Array('vtiger_crmentity', 'tiers_agentsuemoa', 'tiers_agentsuemoacf');
	
	/**
	 * Mandatory for Saving, Include tablename and tablekey columnname here.
	 */
	var $tab_name_index = Array(
		'vtiger_crmentity' => 'crmid',
		'tiers_agentsuemoa'   => 'agentid',
		'tiers_agentsuemoacf' => 'agentid');
	
	/**
	 * Mandatory for Listing (Related listview)
	 */
	var $list_fields = Array (
		/* Format: Field Label => Array(tablename, columnname) */
		'matricule'=> Array('tiers_agentsuemoa','matricule'),
		'badge'=> Array('tiers_agentsuemoa','badge'),
		'photo'=> Array('tiers_agentsuemoa','photo'),
		'civilite'=> Array('tiers_agentsuemoa','civilite'),
		'nom'=> Array('tiers_agentsuemoa','nom'),
		'nomjeunefille'=> Array('tiers_agentsuemoa','nomjeunefille'),
		'prenoms'=> Array('tiers_agentsuemoa','prenoms'),
		'sexe'=> Array('tiers_agentsuemoa','sexe'),
		'datenaissance'=> Array('tiers_agentsuemoa','datenaissance'),
		'lieunaissance'=> Array('tiers_agentsuemoa','lieunaissance'),
		'paysnaissance'=> Array('tiers_agentsuemoa','paysnaissance'),
		'nationalite'=> Array('tiers_agentsuemoa','nationalite'),
		'situationfamiliale'=> Array('tiers_agentsuemoa','situationfamiliale'),
		'nombreenfants'=> Array('tiers_agentsuemoa','nombreenfants'),
		'referenceactenaissance'=> Array('tiers_agentsuemoa','referenceactenaissance'),
		'natureactenaissance'=> Array('tiers_agentsuemoa','natureactenaissance'),
		'dateetablissementactenaissance'=> Array('tiers_agentsuemoa','dateetablissementactenaissance'),
		'lieuetablissement'=> Array('tiers_agentsuemoa','lieuetablissement'),
		'numcrrae'=> Array('tiers_agentsuemoa','numcrrae'),
		'numcaisse'=> Array('tiers_agentsuemoa','numcaisse'),
		'numassurance'=> Array('tiers_agentsuemoa','numassurance'),
		'numcigna'=> Array('tiers_agentsuemoa','numcigna'),
		'numassuranceretraite'=> Array('tiers_agentsuemoa','numassuranceretraite'),
		'numaccident'=> Array('tiers_agentsuemoa','numaccident'),
		'nature'=> Array('tiers_agentsuemoa','nature'),
		'numero'=> Array('tiers_agentsuemoa','numero'),
		'dateetablissement'=> Array('tiers_agentsuemoa','dateetablissement'),
		'autorite'=> Array('tiers_agentsuemoa','autorite'),
		'finvalidit'=> Array('tiers_agentsuemoa','finvalidit'),
		'lieuemission'=> Array('tiers_agentsuemoa','lieuemission'),
		'paysemission'=> Array('tiers_agentsuemoa','paysemission'),
		'adresspays'=> Array('tiers_agentsuemoa','adresspays'),
		'adressdepart'=> Array('tiers_agentsuemoa','adressdepart'),
		'adressprovince'=> Array('tiers_agentsuemoa','adressprovince'),
		'adresssecteur'=> Array('tiers_agentsuemoa','adresssecteur'),
		'adressville'=> Array('tiers_agentsuemoa','adressville'),
		'adresscommune'=> Array('tiers_agentsuemoa','adresscommune'),
		'adressnumerolot'=> Array('tiers_agentsuemoa','adressnumerolot'),
		'adressnumerorue'=> Array('tiers_agentsuemoa','adressnumerorue'),
		'adressnumeroporte'=> Array('tiers_agentsuemoa','adressnumeroporte'),
		'adressnumeroetage'=> Array('tiers_agentsuemoa','adressnumeroetage'),
		'adressnomimmeuble'=> Array('tiers_agentsuemoa','adressnomimmeuble'),
		'adressboitepostale'=> Array('tiers_agentsuemoa','adressboitepostale'),
		'nomutilisateursap'=> Array('tiers_agentsuemoa','nomutilisateursap'),
		'emailprofessionnel'=> Array('tiers_agentsuemoa','emailprofessionnel'),
		'numposte'=> Array('tiers_agentsuemoa','numposte'),
		'telephonebureau'=> Array('tiers_agentsuemoa','telephonebureau'),
		'emailprive'=> Array('tiers_agentsuemoa','emailprive'),
		'cellulaire'=> Array('tiers_agentsuemoa','cellulaire'),
		'affectpays'=> Array('tiers_agentsuemoa','affectpays'),
		'affectdepart'=> Array('tiers_agentsuemoa','affectdepart'),
		'affectprovince'=> Array('tiers_agentsuemoa','affectprovince'),
		'affectsecteur'=> Array('tiers_agentsuemoa','affectsecteur'),
		'affectville'=> Array('tiers_agentsuemoa','affectville'),
		'affectnumerolot'=> Array('tiers_agentsuemoa','affectnumerolot'),
		'affectnumerorue'=> Array('tiers_agentsuemoa','affectnumerorue'),
		'affectnumeroporte'=> Array('tiers_agentsuemoa','affectnumeroporte'),
		'affectnumeroetage'=> Array('tiers_agentsuemoa','affectnumeroetage'),
		'affectnomimmeuble'=> Array('tiers_agentsuemoa','affectnomimmeuble'),
		'affectboitepostale'=> Array('tiers_agentsuemoa','affectboitepostale'),
		'affectorgane'=> Array('tiers_agentsuemoa','affectorgane'),
		'affectdepartement'=> Array('tiers_agentsuemoa','affectdepartement'),
		'affectdirection'=> Array('tiers_agentsuemoa','affectdirection'),
		'affectdivision'=> Array('tiers_agentsuemoa','affectdivision'),
		'affectposte'=> Array('tiers_agentsuemoa','affectposte'),
		'affectfonction'=> Array('tiers_agentsuemoa','affectfonction'),
		'conttypecontrat'=> Array('tiers_agentsuemoa','conttypecontrat'),
		'contref'=> Array('tiers_agentsuemoa','contref'),
		'contdatedebut'=> Array('tiers_agentsuemoa','contdatedebut'),
		'contdatefin'=> Array('tiers_agentsuemoa','contdatefin'),
		'contperiodeessai'=> Array('tiers_agentsuemoa','contperiodeessai'),
		'contdateembauche'=> Array('tiers_agentsuemoa','contdateembauche'),
		'contdateanciennete'=> Array('tiers_agentsuemoa','contdateanciennete'),
		'contdatedepart'=> Array('tiers_agentsuemoa','contdatedepart'),
		'contmotifdepart'=> Array('tiers_agentsuemoa','contmotifdepart'),
		'contcategorie'=> Array('tiers_agentsuemoa','contcategorie'),
		'contstatut'=> Array('tiers_agentsuemoa','contstatut'),
		'categoriecoordonneesbancaire'=> Array('tiers_agentsuemoa','categoriecoordonneesbancaire'),
		'destinataire'=> Array('tiers_agentsuemoa','destinataire'),
		'codebanque'=> Array('tiers_agentsuemoa','codebanque'),
		'codeagence'=> Array('tiers_agentsuemoa','codeagence'),
		'numcompte'=> Array('tiers_agentsuemoa','numcompte'),
		'clerib'=> Array('tiers_agentsuemoa','clerib'),
		'codeswift'=> Array('tiers_agentsuemoa','codeswift'),
		'iban'=> Array('tiers_agentsuemoa','iban'),
		'modedepaiement'=> Array('tiers_agentsuemoa','modedepaiement'),
		'devise'=> Array('tiers_agentsuemoa','devise'),
		'repartition'=> Array('tiers_agentsuemoa','repartition'),
		'perecivilite'=> Array('tiers_agentsuemoa','perecivilite'),
		'perenom'=> Array('tiers_agentsuemoa','perenom'),
		'perenomjeunefille'=> Array('tiers_agentsuemoa','perenomjeunefille'),
		'pereprenoms'=> Array('tiers_agentsuemoa','pereprenoms'),
		'peresexe'=> Array('tiers_agentsuemoa','peresexe'),
		'peredatenaissance'=> Array('tiers_agentsuemoa','peredatenaissance'),
		'perelieunaissance'=> Array('tiers_agentsuemoa','perelieunaissance'),
		'perepaysnaissance'=> Array('tiers_agentsuemoa','perepaysnaissance'),
		'pereetat'=> Array('tiers_agentsuemoa','pereetat'),
		'perenationalite'=> Array('tiers_agentsuemoa','perenationalite'),
		'perescolouapprent'=> Array('tiers_agentsuemoa','perescolouapprent'),
		'perecapitaldeces'=> Array('tiers_agentsuemoa','perecapitaldeces'),
		'peredatedeces'=> Array('tiers_agentsuemoa','peredatedeces'),
		'pereacharge'=> Array('tiers_agentsuemoa','pereacharge'),
		'perenumcigna'=> Array('tiers_agentsuemoa','perenumcigna'),
		'peresaloucom'=> Array('tiers_agentsuemoa','peresaloucom'),
		'langue'=> Array('tiers_agentsuemoa','langue'),
		'diplome'=> Array('tiers_agentsuemoa','diplome'),
		'ecole'=> Array('tiers_agentsuemoa','ecole'),
		'permis'=> Array('tiers_agentsuemoa','permis'),
		'niveauxscolaires'=> Array('tiers_agentsuemoa','niveauxscolaires'),
		'specialites'=> Array('tiers_agentsuemoa','specialites'),
		'filiere'=> Array('tiers_agentsuemoa','filiere'),
		'merecivilite'=> Array('tiers_agentsuemoa','merecivilite'),
		'merenom'=> Array('tiers_agentsuemoa','merenom'),
		'merenomjeunefille'=> Array('tiers_agentsuemoa','merenomjeunefille'),
		'mereprenoms'=> Array('tiers_agentsuemoa','mereprenoms'),
		'meresexe'=> Array('tiers_agentsuemoa','meresexe'),
		'meredatenaissance'=> Array('tiers_agentsuemoa','meredatenaissance'),
		'merelieunaissance'=> Array('tiers_agentsuemoa','merelieunaissance'),
		'merepaysnaissance'=> Array('tiers_agentsuemoa','merepaysnaissance'),
		'mereetat'=> Array('tiers_agentsuemoa','mereetat'),
		'merenationalite'=> Array('tiers_agentsuemoa','merenationalite'),
		'merescolouapprent'=> Array('tiers_agentsuemoa','merescolouapprent'),
		'merecapitaldeces'=> Array('tiers_agentsuemoa','merecapitaldeces'),
		'meredatedeces'=> Array('tiers_agentsuemoa','meredatedeces'),
		'mereacharge'=> Array('tiers_agentsuemoa','mereacharge'),
		'merenumcigna'=> Array('tiers_agentsuemoa','merenumcigna'),
		'meresaloucom'=> Array('tiers_agentsuemoa','meresaloucom'),
		'enfant1civilite'=> Array('tiers_agentsuemoa','enfant1civilite'),
		'enfant1nom'=> Array('tiers_agentsuemoa','enfant1nom'),
		'enfant1nomjeunefille'=> Array('tiers_agentsuemoa','enfant1nomjeunefille'),
		'enfant1prenoms'=> Array('tiers_agentsuemoa','enfant1prenoms'),
		'enfant1sexe'=> Array('tiers_agentsuemoa','enfant1sexe'),
		'enfant1datenaissance'=> Array('tiers_agentsuemoa','enfant1datenaissance'),
		'enfant1lieunaissance'=> Array('tiers_agentsuemoa','enfant1lieunaissance'),
		'enfant1paysnaissance'=> Array('tiers_agentsuemoa','enfant1paysnaissance'),
		'enfant1etat'=> Array('tiers_agentsuemoa','enfant1etat'),
		'enfant1nationalite'=> Array('tiers_agentsuemoa','enfant1nationalite'),
		'enfant1scolouapprent'=> Array('tiers_agentsuemoa','enfant1scolouapprent'),
		'enfant1capitaldeces'=> Array('tiers_agentsuemoa','enfant1capitaldeces'),
		'enfant1datedeces'=> Array('tiers_agentsuemoa','enfant1datedeces'),
		'enfant1nometprenomsmereenfant'=> Array('tiers_agentsuemoa','enfant1nometprenomsmereenfant'),
		'enfant1acharge'=> Array('tiers_agentsuemoa','enfant1acharge'),
		'enfant1numcigna'=> Array('tiers_agentsuemoa','enfant1numcigna'),
		'enfant1saloucom'=> Array('tiers_agentsuemoa','enfant1saloucom'),
		'enfant2civilite'=> Array('tiers_agentsuemoa','enfant2civilite'),
		'enfant2nom'=> Array('tiers_agentsuemoa','enfant2nom'),
		'enfant2nomjeunefille'=> Array('tiers_agentsuemoa','enfant2nomjeunefille'),
		'enfant2prenoms'=> Array('tiers_agentsuemoa','enfant2prenoms'),
		'enfant2sexe'=> Array('tiers_agentsuemoa','enfant2sexe'),
		'enfant2datenaissance'=> Array('tiers_agentsuemoa','enfant2datenaissance'),
		'enfant2lieunaissance'=> Array('tiers_agentsuemoa','enfant2lieunaissance'),
		'enfant2paysnaissance'=> Array('tiers_agentsuemoa','enfant2paysnaissance'),
		'enfant2etat'=> Array('tiers_agentsuemoa','enfant2etat'),
		'enfant2nationalite'=> Array('tiers_agentsuemoa','enfant2nationalite'),
		'enfant2scolouapprent'=> Array('tiers_agentsuemoa','enfant2scolouapprent'),
		'enfant2capitaldeces'=> Array('tiers_agentsuemoa','enfant2capitaldeces'),
		'enfant2datedeces'=> Array('tiers_agentsuemoa','enfant2datedeces'),
		'enfant2nometprenomsmereenfant'=> Array('tiers_agentsuemoa','enfant2nometprenomsmereenfant'),
		'enfant2acharge'=> Array('tiers_agentsuemoa','enfant2acharge'),
		'enfant2numcigna'=> Array('tiers_agentsuemoa','enfant2numcigna'),
		'enfant2saloucom'=> Array('tiers_agentsuemoa','enfant2saloucom'),
		'enfant3civilite'=> Array('tiers_agentsuemoa','enfant3civilite'),
		'enfant3nom'=> Array('tiers_agentsuemoa','enfant3nom'),
		'enfant3nomjeunefille'=> Array('tiers_agentsuemoa','enfant3nomjeunefille'),
		'enfant3prenoms'=> Array('tiers_agentsuemoa','enfant3prenoms'),
		'enfant3sexe'=> Array('tiers_agentsuemoa','enfant3sexe'),
		'enfant3datenaissance'=> Array('tiers_agentsuemoa','enfant3datenaissance'),
		'enfant3lieunaissance'=> Array('tiers_agentsuemoa','enfant3lieunaissance'),
		'enfant3paysnaissance'=> Array('tiers_agentsuemoa','enfant3paysnaissance'),
		'enfant3etat'=> Array('tiers_agentsuemoa','enfant3etat'),
		'enfant3nationalite'=> Array('tiers_agentsuemoa','enfant3nationalite'),
		'enfant3scolouapprent'=> Array('tiers_agentsuemoa','enfant3scolouapprent'),
		'enfant3capitaldeces'=> Array('tiers_agentsuemoa','enfant3capitaldeces'),
		'enfant3datedeces'=> Array('tiers_agentsuemoa','enfant3datedeces'),
		'enfant3nometprenomsmereenfant'=> Array('tiers_agentsuemoa','enfant3nometprenomsmereenfant'),
		'enfant3acharge'=> Array('tiers_agentsuemoa','enfant3acharge'),
		'enfant3numcigna'=> Array('tiers_agentsuemoa','enfant3numcigna'),
		'enfant3saloucom'=> Array('tiers_agentsuemoa','enfant3saloucom'),
		'enfant4civilite'=> Array('tiers_agentsuemoa','enfant4civilite'),
		'enfant4nom'=> Array('tiers_agentsuemoa','enfant4nom'),
		'enfant4nomjeunefille'=> Array('tiers_agentsuemoa','enfant4nomjeunefille'),
		'enfant4prenoms'=> Array('tiers_agentsuemoa','enfant4prenoms'),
		'enfant4sexe'=> Array('tiers_agentsuemoa','enfant4sexe'),
		'enfant4datenaissance'=> Array('tiers_agentsuemoa','enfant4datenaissance'),
		'enfant4lieunaissance'=> Array('tiers_agentsuemoa','enfant4lieunaissance'),
		'enfant4paysnaissance'=> Array('tiers_agentsuemoa','enfant4paysnaissance'),
		'enfant4etat'=> Array('tiers_agentsuemoa','enfant4etat'),
		'enfant4nationalite'=> Array('tiers_agentsuemoa','enfant4nationalite'),
		'enfant4scolouapprent'=> Array('tiers_agentsuemoa','enfant4scolouapprent'),
		'enfant4capitaldeces'=> Array('tiers_agentsuemoa','enfant4capitaldeces'),
		'enfant4datedeces'=> Array('tiers_agentsuemoa','enfant4datedeces'),
		'enfant4nometprenomsmereenfant'=> Array('tiers_agentsuemoa','enfant4nometprenomsmereenfant'),
		'enfant4acharge'=> Array('tiers_agentsuemoa','enfant4acharge'),
		'enfant4numcigna'=> Array('tiers_agentsuemoa','enfant4numcigna'),
		'enfant4saloucom'=> Array('tiers_agentsuemoa','enfant4saloucom'),
		'enfant5civilite'=> Array('tiers_agentsuemoa','enfant5civilite'),
		'enfant5nom'=> Array('tiers_agentsuemoa','enfant5nom'),
		'enfant5nomjeunefille'=> Array('tiers_agentsuemoa','enfant5nomjeunefille'),
		'enfant5prenoms'=> Array('tiers_agentsuemoa','enfant5prenoms'),
		'enfant5sexe'=> Array('tiers_agentsuemoa','enfant5sexe'),
		'enfant5datenaissance'=> Array('tiers_agentsuemoa','enfant5datenaissance'),
		'enfant5lieunaissance'=> Array('tiers_agentsuemoa','enfant5lieunaissance'),
		'enfant5paysnaissance'=> Array('tiers_agentsuemoa','enfant5paysnaissance'),
		'enfant5etat'=> Array('tiers_agentsuemoa','enfant5etat'),
		'enfant5nationalite'=> Array('tiers_agentsuemoa','enfant5nationalite'),
		'enfant5scolouapprent'=> Array('tiers_agentsuemoa','enfant5scolouapprent'),
		'enfant5capitaldeces'=> Array('tiers_agentsuemoa','enfant5capitaldeces'),
		'enfant5datedeces'=> Array('tiers_agentsuemoa','enfant5datedeces'),
		'enfant5nometprenomsmereenfant'=> Array('tiers_agentsuemoa','enfant5nometprenomsmereenfant'),
		'enfant5acharge'=> Array('tiers_agentsuemoa','enfant5acharge'),
		'enfant5numcigna'=> Array('tiers_agentsuemoa','enfant5numcigna'),
		'enfant5saloucom'=> Array('tiers_agentsuemoa','enfant5saloucom'),
		'enfant6civilite'=> Array('tiers_agentsuemoa','enfant6civilite'),
		'enfant6nom'=> Array('tiers_agentsuemoa','enfant6nom'),
		'enfant6nomjeunefille'=> Array('tiers_agentsuemoa','enfant6nomjeunefille'),
		'enfant6prenoms'=> Array('tiers_agentsuemoa','enfant6prenoms'),
		'enfant6sexe'=> Array('tiers_agentsuemoa','enfant6sexe'),
		'enfant6datenaissance'=> Array('tiers_agentsuemoa','enfant6datenaissance'),
		'enfant6lieunaissance'=> Array('tiers_agentsuemoa','enfant6lieunaissance'),
		'enfant6paysnaissance'=> Array('tiers_agentsuemoa','enfant6paysnaissance'),
		'enfant6etat'=> Array('tiers_agentsuemoa','enfant6etat'),
		'enfant6nationalite'=> Array('tiers_agentsuemoa','enfant6nationalite'),
		'enfant6scolouapprent'=> Array('tiers_agentsuemoa','enfant6scolouapprent'),
		'enfant6capitaldeces'=> Array('tiers_agentsuemoa','enfant6capitaldeces'),
		'enfant6datedeces'=> Array('tiers_agentsuemoa','enfant6datedeces'),
		'enfant6nometprenomsmereenfant'=> Array('tiers_agentsuemoa','enfant6nometprenomsmereenfant'),
		'enfant6acharge'=> Array('tiers_agentsuemoa','enfant6acharge'),
		'enfant6numcigna'=> Array('tiers_agentsuemoa','enfant6numcigna'),
		'enfant6saloucom'=> Array('tiers_agentsuemoa','enfant6saloucom'),
		'assuranefile'=> Array('tiers_agentsuemoa','assuranefile'),
		'pieceidentfile'=> Array('tiers_agentsuemoa','pieceidentfile'),
		'ribfile'=> Array('tiers_agentsuemoa','ribfile'),
		'extraitfile'=> Array('tiers_agentsuemoa','extraitfile'),
		'certifmariagefile'=> Array('tiers_agentsuemoa','certifmariagefile'),
		'livrefile'=> Array('tiers_agentsuemoa','livrefile'),
		'conjointcivilite'=> Array('tiers_agentsuemoa','conjointcivilite'),
		'conjointnom'=> Array('tiers_agentsuemoa','conjointnom'),
		'conjointnomjeunefille'=> Array('tiers_agentsuemoa','conjointnomjeunefille'),
		'conjointprenoms'=> Array('tiers_agentsuemoa','conjointprenoms'),
		'conjointsexe'=> Array('tiers_agentsuemoa','conjointsexe'),
		'conjointdatenaissance'=> Array('tiers_agentsuemoa','conjointdatenaissance'),
		'conjointlieunaissance'=> Array('tiers_agentsuemoa','conjointlieunaissance'),
		'conjointpaysnaissance'=> Array('tiers_agentsuemoa','conjointpaysnaissance'),
		'conjointetat'=> Array('tiers_agentsuemoa','conjointetat'),
		'conjointnationalite'=> Array('tiers_agentsuemoa','conjointnationalite'),
		'conjointscolouapprent'=> Array('tiers_agentsuemoa','conjointscolouapprent'),
		'conjointcapitaldeces'=> Array('tiers_agentsuemoa','conjointcapitaldeces'),
		'conjointdatedeces'=> Array('tiers_agentsuemoa','conjointdatedeces'),
		'conjointacharge'=> Array('tiers_agentsuemoa','conjointacharge'),
		'conjointnumcigna'=> Array('tiers_agentsuemoa','conjointnumcigna'),
		'conjointsaloucom'=> Array('tiers_agentsuemoa','conjointsaloucom'),
		'categoriecoordonneesbancaire2'=> Array('tiers_agentsuemoa','categoriecoordonneesbancaire2'),
		'destinataire2'=> Array('tiers_agentsuemoa','destinataire2'),
		'codebanque2'=> Array('tiers_agentsuemoa','codebanque2'),
		'codeagence2'=> Array('tiers_agentsuemoa','codeagence2'),
		'numcompte2'=> Array('tiers_agentsuemoa','numcompte2'),
		'clerib2'=> Array('tiers_agentsuemoa','clerib2'),
		'codeswift2'=> Array('tiers_agentsuemoa','codeswift2'),
		'iban2'=> Array('tiers_agentsuemoa','iban2'),
		'modedepaiement2'=> Array('tiers_agentsuemoa','modedepaiement2'),
		'devise2'=> Array('tiers_agentsuemoa','devise2'),
		'repartition2'=> Array('tiers_agentsuemoa','repartition2'),
		'categoriecoordonneesbancaire3'=> Array('tiers_agentsuemoa','categoriecoordonneesbancaire3'),
		'destinataire3'=> Array('tiers_agentsuemoa','destinataire3'),
		'codebanque3'=> Array('tiers_agentsuemoa','codebanque3'),
		'codeagence3'=> Array('tiers_agentsuemoa','codeagence3'),
		'numcompte3'=> Array('tiers_agentsuemoa','numcompte3'),
		'clerib3'=> Array('tiers_agentsuemoa','clerib3'),
		'codeswift3'=> Array('tiers_agentsuemoa','codeswift3'),
		'iban3'=> Array('tiers_agentsuemoa','iban3'),
		'modedepaiement3'=> Array('tiers_agentsuemoa','modedepaiement3'),
		'devise3'=> Array('tiers_agentsuemoa','devise3'),
		'repartition3'=> Array('tiers_agentsuemoa','repartition3'),
		'categoriecoordonneesbancaire4'=> Array('tiers_agentsuemoa','categoriecoordonneesbancaire4'),
		'destinataire4'=> Array('tiers_agentsuemoa','destinataire4'),
		'codebanque4'=> Array('tiers_agentsuemoa','codebanque4'),
		'codeagence4'=> Array('tiers_agentsuemoa','codeagence4'),
		'numcompte4'=> Array('tiers_agentsuemoa','numcompte4'),
		'clerib4'=> Array('tiers_agentsuemoa','clerib4'),
		'codeswift4'=> Array('tiers_agentsuemoa','codeswift4'),
		'iban4'=> Array('tiers_agentsuemoa','iban4'),
		'modedepaiement4'=> Array('tiers_agentsuemoa','modedepaiement4'),
		'devise4'=> Array('tiers_agentsuemoa','devise4'),
		'repartition4'=> Array('tiers_agentsuemoa','repartition4'),
		'categoriecoordonneesbancaire5'=> Array('tiers_agentsuemoa','categoriecoordonneesbancaire5'),
		'destinataire5'=> Array('tiers_agentsuemoa','destinataire5'),
		'codebanque5'=> Array('tiers_agentsuemoa','codebanque5'),
		'codeagence5'=> Array('tiers_agentsuemoa','codeagence5'),
		'numcompte5'=> Array('tiers_agentsuemoa','numcompte5'),
		'clerib5'=> Array('tiers_agentsuemoa','clerib5'),
		'codeswift5'=> Array('tiers_agentsuemoa','codeswift5'),
		'iban5'=> Array('tiers_agentsuemoa','iban5'),
		'modedepaiement5'=> Array('tiers_agentsuemoa','modedepaiement5'),
		'devise5'=> Array('tiers_agentsuemoa','devise5'),
		'repartition5'=> Array('tiers_agentsuemoa','repartition5'),
		'ribfile2'=> Array('tiers_agentsuemoa','ribfile2'),
		'ribfile3'=> Array('tiers_agentsuemoa','ribfile3'),
		'ribfile4'=> Array('tiers_agentsuemoa','ribfile4'),
		'ribfile5'=> Array('tiers_agentsuemoa','ribfile5'),





	);
	var $list_fields_name = Array(
	
		'Matricule'=>'matricule',
		'Badge'=>'badge',
		'Photo'=>'photo',
		'Civilite'=>'civilite',
		'Nom'=>'nom',
		'Nomjeunefille'=>'nomjeunefille',
		'Prenoms'=>'prenoms',
		'Sexe'=>'sexe',
		'Datenaissance'=>'datenaissance',
		'Lieunaissance'=>'lieunaissance',
		'Paysnaissance'=>'paysnaissance',
		'Nationalite'=>'nationalite',
		'Situationfamiliale'=>'situationfamiliale',
		'Nombreenfants'=>'nombreenfants',
		'Referenceactenaissance'=>'referenceactenaissance',
		'Natureactenaissance'=>'natureactenaissance',
		'Dateetablissementactenaissance'=>'dateetablissementactenaissance',
		'Lieuetablissement'=>'lieuetablissement',
		'Numcrrae'=>'numcrrae',
		'Numcaisse'=>'numcaisse',
		'Numassurance'=>'numassurance',
		'Numcigna'=>'numcigna',
		'Numassuranceretraite'=>'numassuranceretraite',
		'Numaccident'=>'numaccident',
		'Nature'=>'nature',
		'Numero'=>'numero',
		'Dateetablissement'=>'dateetablissement',
		'Autorite'=>'autorite',
		'Finvalidit'=>'finvalidit',
		'Lieuemission'=>'lieuemission',
		'Paysemission'=>'paysemission',
		'Adresspays'=>'adresspays',
		'Adressdepart'=>'adressdepart',
		'Adressprovince'=>'adressprovince',
		'Adresssecteur'=>'adresssecteur',
		'Adressville'=>'adressville',
		'Adresscommune'=>'adresscommune',
		'Adressnumerolot'=>'adressnumerolot',
		'Adressnumerorue'=>'adressnumerorue',
		'Adressnumeroporte'=>'adressnumeroporte',
		'Adressnumeroetage'=>'adressnumeroetage',
		'Adressnomimmeuble'=>'adressnomimmeuble',
		'Adressboitepostale'=>'adressboitepostale',
		'Nomutilisateursap'=>'nomutilisateursap',
		'Emailprofessionnel'=>'emailprofessionnel',
		'Numposte'=>'numposte',
		'Telephonebureau'=>'telephonebureau',
		'Emailprive'=>'emailprive',
		'Cellulaire'=>'cellulaire',
		'Affectpays'=>'affectpays',
		'Affectdepart'=>'affectdepart',
		'Affectprovince'=>'affectprovince',
		'Affectsecteur'=>'affectsecteur',
		'Affectville'=>'affectville',
		'Affectnumerolot'=>'affectnumerolot',
		'Affectnumerorue'=>'affectnumerorue',
		'Affectnumeroporte'=>'affectnumeroporte',
		'Affectnumeroetage'=>'affectnumeroetage',
		'Affectnomimmeuble'=>'affectnomimmeuble',
		'Affectboitepostale'=>'affectboitepostale',
		'Affectorgane'=>'affectorgane',
		'Affectdepartement'=>'affectdepartement',
		'Affectdirection'=>'affectdirection',
		'Affectdivision'=>'affectdivision',
		'Affectposte'=>'affectposte',
		'Affectfonction'=>'affectfonction',
		'Conttypecontrat'=>'conttypecontrat',
		'contref'=>'contref',
		'Contdatedebut'=>'contdatedebut',
		'Contdatefin'=>'contdatefin',
		'Contperiodeessai'=>'contperiodeessai',
		'Contdateembauche'=>'contdateembauche',
		'Contdateanciennete'=>'contdateanciennete',
		'Contdatedepart'=>'contdatedepart',
		'Contmotifdepart'=>'contmotifdepart',
		'Contcategorie'=>'contcategorie',
		'Contstatut'=>'contstatut',
		'Categoriecoordonneesbancaire'=>'categoriecoordonneesbancaire',
		'Destinataire'=>'destinataire',
		'Codebanque'=>'codebanque',
		'Codeagence'=>'codeagence',
		'Numcompte'=>'numcompte',
		'Clerib'=>'clerib',
		'Codeswift'=>'codeswift',
		'Iban'=>'iban',
		'Modedepaiement'=>'modedepaiement',
		'Devise'=>'devise',
		'Repartition'=>'repartition',
		'Perecivilite'=>'perecivilite',
		'Perenom'=>'perenom',
		'Perenomjeunefille'=>'perenomjeunefille',
		'Pereprenoms'=>'pereprenoms',
		'Peresexe'=>'peresexe',
		'Peredatenaissance'=>'peredatenaissance',
		'Perelieunaissance'=>'perelieunaissance',
		'Perepaysnaissance'=>'perepaysnaissance',
		'Pereetat'=>'pereetat',
		'Perenationalite'=>'perenationalite',
		'Perescolouapprent'=>'perescolouapprent',
		'Perecapitaldeces'=>'perecapitaldeces',
		'Peredatedeces'=>'peredatedeces',
		'Pereacharge'=>'pereacharge',
		'Perenumcigna'=>'perenumcigna',
		'Peresaloucom'=>'peresaloucom',
		'Langue'=>'langue',
		'Diplome'=>'diplome',
		'Ecole'=>'ecole',
		'Permis'=>'permis',
		'Niveauxscolaires'=>'niveauxscolaires',
		'Specialites'=>'specialites',
		'Filiere'=>'filiere',
		'Merecivilite'=>'merecivilite',
		'Merenom'=>'merenom',
		'Merenomjeunefille'=>'merenomjeunefille',
		'Mereprenoms'=>'mereprenoms',
		'Meresexe'=>'meresexe',
		'Meredatenaissance'=>'meredatenaissance',
		'Merelieunaissance'=>'merelieunaissance',
		'Merepaysnaissance'=>'merepaysnaissance',
		'Mereetat'=>'mereetat',
		'Merenationalite'=>'merenationalite',
		'Merescolouapprent'=>'merescolouapprent',
		'Merecapitaldeces'=>'merecapitaldeces',
		'Meredatedeces'=>'meredatedeces',
		'Mereacharge'=>'mereacharge',
		'Merenumcigna'=>'merenumcigna',
		'Meresaloucom'=>'meresaloucom',
		'Enfant1Civilite'=>'enfant1civilite',
		'Enfant1Nom'=>'enfant1nom',
		'Enfant1Nomjeunefille'=>'enfant1nomjeunefille',
		'Enfant1Prenoms'=>'enfant1prenoms',
		'Enfant1Sexe'=>'enfant1sexe',
		'Enfant1Datenaissance'=>'enfant1datenaissance',
		'Enfant1Lieunaissance'=>'enfant1lieunaissance',
		'Enfant1Paysnaissance'=>'enfant1paysnaissance',
		'Enfant1Etat'=>'enfant1etat',
		'Enfant1Nationalite'=>'enfant1nationalite',
		'Enfant1Scolouapprent'=>'enfant1scolouapprent',
		'Enfant1Capitaldeces'=>'enfant1capitaldeces',
		'Enfant1Datedeces'=>'enfant1datedeces',
		'Enfant1Nometprenomsmereenfant'=>'enfant1nometprenomsmereenfant',
		'Enfant1Acharge'=>'enfant1acharge',
		'Enfant1Numcigna'=>'enfant1numcigna',
		'Enfant1Saloucom'=>'enfant1saloucom',
		'Enfant2Civilite'=>'enfant2civilite',
		'Enfant2Nom'=>'enfant2nom',
		'Enfant2Nomjeunefille'=>'enfant2nomjeunefille',
		'Enfant2Prenoms'=>'enfant2prenoms',
		'Enfant2Sexe'=>'enfant2sexe',
		'Enfant2Datenaissance'=>'enfant2datenaissance',
		'Enfant2Lieunaissance'=>'enfant2lieunaissance',
		'Enfant2Paysnaissance'=>'enfant2paysnaissance',
		'Enfant2Etat'=>'enfant2etat',
		'Enfant2Nationalite'=>'enfant2nationalite',
		'Enfant2Scolouapprent'=>'enfant2scolouapprent',
		'Enfant2Capitaldeces'=>'enfant2capitaldeces',
		'Enfant2Datedeces'=>'enfant2datedeces',
		'Enfant2Nometprenomsmereenfant'=>'enfant2nometprenomsmereenfant',
		'Enfant2Acharge'=>'enfant2acharge',
		'Enfant2Numcigna'=>'enfant2numcigna',
		'Enfant2Saloucom'=>'enfant2saloucom',
		'Enfant3Civilite'=>'enfant3civilite',
		'Enfant3Nom'=>'enfant3nom',
		'Enfant3Nomjeunefille'=>'enfant3nomjeunefille',
		'Enfant3Prenoms'=>'enfant3prenoms',
		'Enfant3Sexe'=>'enfant3sexe',
		'Enfant3Datenaissance'=>'enfant3datenaissance',
		'Enfant3Lieunaissance'=>'enfant3lieunaissance',
		'Enfant3Paysnaissance'=>'enfant3paysnaissance',
		'Enfant3Etat'=>'enfant3etat',
		'Enfant3Nationalite'=>'enfant3nationalite',
		'Enfant3Scolouapprent'=>'enfant3scolouapprent',
		'Enfant3Capitaldeces'=>'enfant3capitaldeces',
		'Enfant3Datedeces'=>'enfant3datedeces',
		'Enfant3Nometprenomsmereenfant'=>'enfant3nometprenomsmereenfant',
		'Enfant3Acharge'=>'enfant3acharge',
		'Enfant3Numcigna'=>'enfant3numcigna',
		'Enfant3Saloucom'=>'enfant3saloucom',
		'Enfant4Civilite'=>'enfant4civilite',
		'Enfant4Nom'=>'enfant4nom',
		'Enfant4Nomjeunefille'=>'enfant4nomjeunefille',
		'Enfant4Prenoms'=>'enfant4prenoms',
		'Enfant4Sexe'=>'enfant4sexe',
		'Enfant4Datenaissance'=>'enfant4datenaissance',
		'Enfant4Lieunaissance'=>'enfant4lieunaissance',
		'Enfant4Paysnaissance'=>'enfant4paysnaissance',
		'Enfant4Etat'=>'enfant4etat',
		'Enfant4Nationalite'=>'enfant4nationalite',
		'Enfant4Scolouapprent'=>'enfant4scolouapprent',
		'Enfant4Capitaldeces'=>'enfant4capitaldeces',
		'Enfant4Datedeces'=>'enfant4datedeces',
		'Enfant4Nometprenomsmereenfant'=>'enfant4nometprenomsmereenfant',
		'Enfant4Acharge'=>'enfant4acharge',
		'Enfant4Numcigna'=>'enfant4numcigna',
		'Enfant4Saloucom'=>'enfant4saloucom',
		'Enfant5Civilite'=>'enfant5civilite',
		'Enfant5Nom'=>'enfant5nom',
		'Enfant5Nomjeunefille'=>'enfant5nomjeunefille',
		'Enfant5Prenoms'=>'enfant5prenoms',
		'Enfant5Sexe'=>'enfant5sexe',
		'Enfant5Datenaissance'=>'enfant5datenaissance',
		'Enfant5Lieunaissance'=>'enfant5lieunaissance',
		'Enfant5Paysnaissance'=>'enfant5paysnaissance',
		'Enfant5Etat'=>'enfant5etat',
		'Enfant5Nationalite'=>'enfant5nationalite',
		'Enfant5Scolouapprent'=>'enfant5scolouapprent',
		'Enfant5Capitaldeces'=>'enfant5capitaldeces',
		'Enfant5Datedeces'=>'enfant5datedeces',
		'Enfant5Nometprenomsmereenfant'=>'enfant5nometprenomsmereenfant',
		'Enfant5Acharge'=>'enfant5acharge',
		'Enfant5Numcigna'=>'enfant5numcigna',
		'Enfant5Saloucom'=>'enfant5saloucom',
		'Enfant6Civilite'=>'enfant6civilite',
		'Enfant6Nom'=>'enfant6nom',
		'Enfant6Nomjeunefille'=>'enfant6nomjeunefille',
		'Enfant6Prenoms'=>'enfant6prenoms',
		'Enfant6Sexe'=>'enfant6sexe',
		'Enfant6Datenaissance'=>'enfant6datenaissance',
		'Enfant6Lieunaissance'=>'enfant6lieunaissance',
		'Enfant6Paysnaissance'=>'enfant6paysnaissance',
		'Enfant6Etat'=>'enfant6etat',
		'Enfant6Nationalite'=>'enfant6nationalite',
		'Enfant6Scolouapprent'=>'enfant6scolouapprent',
		'Enfant6Capitaldeces'=>'enfant6capitaldeces',
		'Enfant6Datedeces'=>'enfant6datedeces',
		'Enfant6Nometprenomsmereenfant'=>'enfant6nometprenomsmereenfant',
		'Enfant6Acharge'=>'enfant6acharge',
		'Enfant6Numcigna'=>'enfant6numcigna',
		'Enfant6Saloucom'=>'enfant6saloucom',
		'Assuranefile'=>'assuranefile',
		'Pieceidentfile'=>'pieceidentfile',
		'Ribfile'=>'ribfile',
		'Extraitfile'=>'extraitfile',
		'Certifmariagefile'=>'certifmariagefile',
		'Livrefile'=>'livrefile',
		'Conjointcivilite'=>'conjointcivilite',
		'Conjointnom'=>'conjointnom',
		'Conjointnomjeunefille'=>'conjointnomjeunefille',
		'Conjointprenoms'=>'conjointprenoms',
		'Conjointsexe'=>'conjointsexe',
		'Conjointdatenaissance'=>'conjointdatenaissance',
		'Conjointlieunaissance'=>'conjointlieunaissance',
		'Conjointpaysnaissance'=>'conjointpaysnaissance',
		'Conjointetat'=>'conjointetat',
		'Conjointnationalite'=>'conjointnationalite',
		'Conjointscolouapprent'=>'conjointscolouapprent',
		'Conjointcapitaldeces'=>'conjointcapitaldeces',
		'Conjointdatedeces'=>'conjointdatedeces',
		'Conjointacharge'=>'conjointacharge',
		'Conjointnumcigna'=>'conjointnumcigna',
		'Conjointsaloucom'=>'conjointsaloucom',
		'Categoriecoordonneesbancaire2'=>'categoriecoordonneesbancaire2',
		'Destinataire2'=>'destinataire2',
		'Codebanque2'=>'codebanque2',
		'Codeagence2'=>'codeagence2',
		'Numcompte2'=>'numcompte2',
		'Clerib2'=>'clerib2',
		'Codeswift2'=> 'codeswift2',
		'Iban2'=>'iban2',
		'Modedepaiement2'=>'modedepaiement2',
		'Devise2'=>'devise2',
		'Repartition2'=>'repartition2',
		'Categoriecoordonneesbancaire3'=>'categoriecoordonneesbancaire3',
		'Destinataire3'=>'destinataire3',
		'Codebanque3'=>'codebanque3',
		'Codeagence3'=>'codeagence3',
		'Numcompte3'=>'numcompte3',
		'Clerib3'=>'clerib3',
		'Codeswift3'=>'codeswift3',
		'Iban3'=>'iban3',
		'Modedepaiement3'=>'modedepaiement3',
		'Devise3'=>'devise3',
		'Repartition3'=>'repartition3',
		'Categoriecoordonneesbancaire4'=>'categoriecoordonneesbancaire4',
		'Destinataire4'=>'destinataire4',
		'Codebanque4'=>'codebanque4',
		'Codeagence4'=>'codeagence4',
		'Numcompte4'=>'numcompte4',
		'Clerib4'=>'clerib4',
		'Codeswift4'=>'codeswift4',
		'Iban4'=>'iban4',
		'Modedepaiement4'=>'modedepaiement4',
		'Devise4'=>'devise4',
		'Repartition4'=>'repartition4',
		'Categoriecoordonneesbancaire5'=>'categoriecoordonneesbancaire5',
		'Destinataire5'=>'destinataire5',
		'Codebanque5'=>'codebanque5',
		'Codeagence5'=>'codeagence5',
		'Numcompte5'=>'numcompte5',
		'Clerib5'=>'clerib5',
		'Codeswift5'=>'codeswift5',
		'Iban5'=>'iban5',
		'Modedepaiement5'=>'modedepaiement5',
		'Devise5'=>'devise5',
		'Repartition5'=>'repartition5',
		'Ribfile2'=>'ribfile2',
		'Ribfile3'=>'ribfile3',
		'Ribfile4'=>'ribfile4',
		'Ribfile5'=>'ribfile5',


	);
	
	// Make the field link to detail view from list view (Fieldname)
	var $list_link_field = 'matricule';
	
	// For Popup listview and UI type support
	var $search_fields = Array(
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'
		
		'Matricule'=> Array('tiers_agentsuemoa', 'matricule'),
		'Nom'=> Array('tiers_agentsuemoa', 'nom'),
		'Prenoms'=> Array('tiers_agentsuemoa', 'prenoms')

	);
	var $search_fields_name = Array(
		/* Format: Field Label => fieldname */
		'Matricule'=> 'matricule',
		'Nom'=> 'nom',
		'Prenoms'=> 'prenoms'

	);
	
	// For Popup window record selection
	var $popup_fields = Array('matricule');
	
	// Placeholder for sort fields - All the fields will be initialized for Sorting through initSortFields
	var $sortby_fields = Array();
	
	// For Alphabetical search
	var $def_basicsearch_col = 'matricule';
	
	// Column value to use on detail view record text display
	var $def_detailview_recname = 'matricule';
	
	// Required Information for enabling Import feature
	var $required_fields = Array('matricule'=>1);
	
	// Callback function list during Importing
	var $special_functions = Array('set_import_assigned_user');
	
	var $default_order_by = 'matricule';
	var $default_sort_order='ASC';
	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	var $mandatory_fields = Array('createdtime', 'modifiedtime', 'matricule');
	function __construct() {
		global $log, $currentModule;
		$this->column_fields = getColumnFields($currentModule);
		$this->db = new PearDatabase();
		$this->log = $log;
	}
	
	function getSortOrder() {
		global $currentModule;
		
		$sortorder = $this->default_sort_order;
		if($_REQUEST['sorder']) $sortorder = $_REQUEST['sorder'];
		else if($_SESSION[$currentModule.'_Sort_Order']) 
			$sortorder = $_SESSION[$currentModule.'_Sort_Order'];
		
		return $sortorder;
	}
	
	function getOrderBy() {
		$orderby = $this->default_order_by;
		if($_REQUEST['order_by']) $orderby = $_REQUEST['order_by'];
		else if($_SESSION[$currentModule.'_Order_By'])
			$orderby = $_SESSION[$currentModule.'_Order_By'];
		return $orderby;
	}
	
	function save_module($module)
	{
		global $log,$adb;
		$insertion_mode = $this->mode;
		if(isset($this->parentid) && $this->parentid != '')
			$relid =  $this->parentid;		
		//inserting into vtiger_sehreportsrel
		//echo "relid =$relid" ;break;
		if(isset($relid) && $relid != '')
		{
			$this->sigc_seconventionfilerel($relid,$this->id);
		}
		
		$this->insertIntoConventionFiles($this->id,'Agentuemoa');
		
		/*		
		$fieldname = $this->getFileTypeFieldName();
		//echo $_FILES[$fieldname]['name'],' - ',$_FILES[$fieldname]['error'];break;
		if($_FILES[$fieldname]['name'] != '')
		{
			$errCode=$_FILES[$fieldname]['error'];
				if($errCode == 0){
					foreach($_FILES as $fileindex => $files)
					{
						if($files['name'] != '' && $files['size'] > 0){
							$filename = $_FILES[$fieldname]['name'];
							$filename = from_html(preg_replace('/\s+/', '_', $filename));
							$filetype = $_FILES[$fieldname]['type'];
							$filesize = $_FILES[$fieldname]['size'];
							$filelocationtype = 'I';
						}
					}
			
				}
			$this->insertIntoConventionFiles($this->id,'Tiers');
				$filestatus=1;
				//$query = "Update vtiger_hreports set filename = ? ,filesize = ?, filetype = ? , filelocationtype = ? , filestatus = ?, filedownloadcount = ? where hreportsid = ?";
				//$re=$adb->pquery($query,array($filename,$filesize,$filetype,$filelocationtype,$filestatus,$filedownloadcount,$this->id));
		}
		*/
		
	}
	
	function insertintofileconvrel($relid,$id)
	{
		global $adb;
		$dbQuery = "insert into sigc_seconventionfilerel values ( ?, ? )";
		$dbresult = $adb->pquery($dbQuery,array($relid,$id));
	}
	
	function insertIntoConventionFiles($id,$module)
	{
		global $log, $adb;
		$log->debug("Entering into insertIntoConventionFiles($id,$module) method.");
		
		$file_saved = false;
		//print_r($_FILES);break;
		foreach($_FILES as $fileindex => $files)
		{
			if($files['name'] != '' && $files['size'] > 0)
			{
				$files['original_name'] = $_REQUEST[$fileindex.'_hidden'];
				$file_saved = $this->uploadAndSaveFile($id,$module,$files);
			}
		}

		$log->debug("Exiting from insertIntorapport($id,$module) method.");
	}
	
	function getFileTypeFieldName(){
		global $adb,$log;
		$query = 'SELECT fieldname from vtiger_field where tabid = ? and uitype = ?';
		$tabid = getTabid('Tiers');
		//$res = $adb->pquery($query,array($tabid,27));
		$res = $adb->pquery($query,array($tabid,61));
		$fieldname = $adb->query_result($res,0,'fieldname');
		return $fieldname;
		
	} 
	
	/**
	 * Return query to use based on given modulename, fieldname
	 * Useful to handle specific case handling for Popup
	 */
	function getQueryByModuleField($module, $fieldname, $srcrecord) {
		// $srcrecord could be empty
	}
	
	/**
	 * Get list view query (send more WHERE clause condition if required)
	 */
	 
	function getListQuery($module, $where='') {
		global $current_user;
		
		$query="SELECT tiers_agentsuemoa.matricule,tiers_agentsuemoa.nom,tiers_agentsuemoa.prenoms,tiers_agentsuemoa.emailprofessionnel,
			tiers_agentsuemoa.numposte,tiers_agentsuemoa.cellulaire,tiers_agentsuemoa.affectdepartement,tiers_agentsuemoa.affectdirection,
			tiers_agentsuemoa.affectposte,tiers_agentsuemoa.affectfonction ,vtiger_crmentity.crmid 
			FROM tiers_agentsuemoa 
			INNER JOIN vtiger_crmentity ON crmid = tiers_agentsuemoa.agentid AND vtiger_crmentity.deleted=0 
				";
			
		return $query;
	}
	
	/**
	 * Apply security restriction (sharing privilege) query part for List view.
	 */
	function getListViewSecurityParameter($module) {
		global $current_user;
		require('user_privileges/user_privileges_'.$current_user->id.'.php');
		////require('user_privileges/sharing_privileges_'.$current_user->id.'.php');
		
		$sec_query = '';
		$tabid = getTabid($module);
		
		if($is_admin==false && $profileGlobalPermission[1] == 1 && $profileGlobalPermission[2] == 1 
			&& $defaultOrgSharingPermission[$tabid] == 3) {
			
			$sec_query .= " AND (vtiger_crmentity.smownerid in($current_user->id) OR vtiger_crmentity.smownerid IN 
				(
				SELECT vtiger_user2role.userid FROM vtiger_user2role 
				INNER JOIN vtiger_users ON vtiger_users.id=vtiger_user2role.userid 
				INNER JOIN vtiger_role ON vtiger_role.roleid=vtiger_user2role.roleid 
				WHERE vtiger_role.parentrole LIKE '".$current_user_parent_role_seq."::%'
				) 
				OR vtiger_crmentity.smownerid IN 
				(
				SELECT shareduserid FROM vtiger_tmp_read_user_sharing_per 
				WHERE userid=".$current_user->id." AND tabid=".$tabid."
				) 
				OR 
				(";
			
			// Build the query based on the group association of current user.
			if(sizeof($current_user_groups) > 0) {
				$sec_query .= " vtiger_groups.groupid IN (". implode(",", $current_user_groups) .") OR ";
			}
			$sec_query .= " vtiger_groups.groupid IN 
				(
				SELECT vtiger_tmp_read_group_sharing_per.sharedgroupid 
				FROM vtiger_tmp_read_group_sharing_per
				WHERE userid=".$current_user->id." and tabid=".$tabid."
				)";
			$sec_query .= ")
				)";
		}
		return $sec_query;
	}
	
	/**
	 * Create query to export the records.
	 */
	function create_export_query($where)
		{
		global $current_user;
		$thismodule = $_REQUEST['module'];
		
		include("include/utils/ExportUtils.php");
		
		//To get the Permitted fields query and the permitted fields list
		$sql = getPermittedFieldsQuery($thismodule, "detail_view");
		
		$fields_list = getFieldsListFromQuery($sql);
		
		$query = "SELECT $fields_list, vtiger_groups.groupname as 'Assigned To Group', vtiger_users.user_name AS user_name 
			FROM vtiger_crmentity INNER JOIN $this->table_name ON vtiger_crmentity.crmid=$this->table_name.$this->table_index";
		
		if(!empty($this->customFieldTable)) {
			$query .= " INNER JOIN ".$this->customFieldTable[0]." ON ".$this->customFieldTable[0].'.'.$this->customFieldTable[1] .
				" = $this->table_name.$this->table_index"; 
		}
		
		$query .= " LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid";
		$query .= " LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id and vtiger_users.status='Active'";
		
		$where_auto = " vtiger_crmentity.deleted=0";
		
		if($where != '') $query .= " WHERE ($where) AND $where_auto";
		else $query .= " WHERE $where_auto";
		
		require('user_privileges/user_privileges_'.$current_user->id.'.php');
		////require('user_privileges/sharing_privileges_'.$current_user->id.'.php');
		
		// Security Check for Field Access
		if($is_admin==false && $profileGlobalPermission[1] == 1 && $profileGlobalPermission[2] == 1 && $defaultOrgSharingPermission[7] == 3)
		{
			//Added security check to get the permitted records only
			$query = $query." ".getListViewSecurityParameter($thismodule);
		}
		return $query;
		}
	
	/**
	 * Initialize this instance for importing.
	 */
	function initImport($module) {
		$this->db = new PearDatabase();
		$this->initImportableFields($module);
	}
	
	/**
	 * Create list query to be shown at the last step of the import.
	 * Called From: modules/Import/UserLastImport.php
	 */
	function create_import_query($module) {
		global $current_user;
		$query = "SELECT vtiger_crmentity.crmid, vtiger_users.user_name, $this->table_name.* FROM $this->table_name
			INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = $this->table_name.$this->table_index
			LEFT JOIN vtiger_users_last_import ON vtiger_users_last_import.bean_id=vtiger_crmentity.crmid
			LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid
			WHERE vtiger_users_last_import.assigned_user_id='$current_user->id'
			AND vtiger_users_last_import.bean_type='$module'
			AND vtiger_users_last_import.deleted=0
			AND vtiger_users.status = 'Active'";
		return $query;
	}
	
	/**
	 * Delete the last imported records.
	 */
	function undo_import($module, $user_id) {
		global $adb;
		$count = 0;
		$query1 = "select bean_id from vtiger_users_last_import where assigned_user_id=? AND bean_type='$module' AND deleted=0";
		$result1 = $adb->pquery($query1, array($user_id)) or die("Error getting last import for undo: ".mysql_error()); 
		while ( $row1 = $adb->fetchByAssoc($result1))
		{
			$query2 = "update vtiger_crmentity set deleted=1 where crmid=?";
			$result2 = $adb->pquery($query2, array($row1['bean_id'])) or die("Error undoing last import: ".mysql_error()); 
			$count++;			
		}
		return $count;
	}
	
	/**
	 * Function which will set the assigned user id for import record.
	 */
	function set_import_assigned_user()
		{
		global $current_user, $adb;
		$record_user = $this->column_fields["assigned_user_id"];
		
		if($record_user != $current_user->id){
			$sqlresult = $adb->pquery("select id from vtiger_users where id = ?", array($record_user));
			if($this->db->num_rows($sqlresult)!= 1) {
				$this->column_fields["assigned_user_id"] = $current_user->id;
			} else {			
				$row = $adb->fetchByAssoc($sqlresult, -1, false);
				if (isset($row['id']) && $row['id'] != -1) {
					$this->column_fields["assigned_user_id"] = $row['id'];
				} else {
					$this->column_fields["assigned_user_id"] = $current_user->id;
				}
			}
		}
		}
	
	/** 
	 * Function which will give the basic query to find duplicates
	 */
	function getDuplicatesQuery($module,$table_cols,$field_values,$ui_type_arr,$select_cols='') {
		$select_clause = "SELECT ". $this->table_name .".".$this->table_index ." AS recordid, vtiger_users_last_import.deleted,".$table_cols;
		
		// Select Custom Field Table Columns if present
		if(isset($this->customFieldTable)) $query .= ", " . $this->customFieldTable[0] . ".* ";
		
		$from_clause = " FROM $this->table_name";
		
		$from_clause .= "	INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = $this->table_name.$this->table_index";
		
		// Consider custom table join as well.
		if(isset($this->customFieldTable)) {
			$from_clause .= " INNER JOIN ".$this->customFieldTable[0]." ON ".$this->customFieldTable[0].'.'.$this->customFieldTable[1] .
				" = $this->table_name.$this->table_index"; 
		}
		$from_clause .= " LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid";
		
		$where_clause = "	WHERE vtiger_crmentity.deleted = 0";
		$where_clause .= $this->getListViewSecurityParameter($module);
		
		if (isset($select_cols) && trim($select_cols) != '') {
			$sub_query = "SELECT $select_cols FROM  $this->table_name AS t " .
				" INNER JOIN vtiger_crmentity AS crm ON crm.crmid = t.".$this->table_index.
				" GROUP BY $select_cols HAVING COUNT(*)>1";	
		} else {
			$sub_query = "SELECT $table_cols $from_clause $where_clause GROUP BY $table_cols HAVING COUNT(*)>1";
		}	
		
		
		$query = $select_clause . $from_clause .
			" LEFT JOIN vtiger_users_last_import ON vtiger_users_last_import.bean_id=" . $this->table_name .".".$this->table_index .
			" INNER JOIN (" . $sub_query . ") AS temp ON ".get_on_clause($field_values,$ui_type_arr,$module) .
			$where_clause .
			" ORDER BY $table_cols,". $this->table_name .".".$this->table_index ." ASC";
		
		return $query;		
	}
	
	function getAgentid($matricule)
	{
		global $log;
		$log->debug("Entering getAgentid(".$matricule.") method ...");
		global $adb;
		$query = "SELECT agentid FROM tiers_agentsuemoa WHERE matricule=?";
		$result = $adb->pquery($query, array($matricule));
		$agentid = $adb->query_result($result,0,"agentid");
		$log->debug("Inside getAgentid. The agentid is ".$agentid);
		$log->debug("Exiting getAgentid method ...");
		return $agentid;

	}

	function existinfosconjoint($agentid)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existinfoconjoint(".$agentid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select situationfamiliale,conjointnom from tiers_agentsuemoa where agentid = ?" ;
		$result = $adb->pquery($query, array($agentid));
		$row1 = $adb->fetchByAssoc($result);
		if((trim($row1['conjointnom'])!='') || ($row1['situationfamiliale']=='M'))
			return 1;
		else
			return 0;

	}
	
	function selectnonmodifval($agentid)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering selectnonmodifval(".$agentid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select civilite,sexe,paysnaissance,nationalite,situationfamiliale,nombreenfants,affectpays,affectorgane,affectdepartement,affectdirection,affectfonction,
					conttypecontrat,contcategorie,contstatut,diplome,niveauxscolaires from tiers_agentsuemoa where agentid = ?" ;
		$result = $adb->pquery($query, array($agentid));
		$row1 = $adb->fetchByAssoc($result);
		
			return $row1;

	}
	
	function existinfosenfant1($agentid)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existinfosenfant1(".$agentid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select enfant1nom,enfant1prenoms,nombreenfants from tiers_agentsuemoa where agentid = ? " ;
		$result = $adb->pquery($query, array($agentid));
		$row1 = $adb->fetchByAssoc($result);
		if((trim($row1['enfant1nom'])!='' && trim($row1['enfant1prenoms'])!='') || intval($row1['nombreenfants'])>=1)
			return 1;
		else
			return 0;
	}
	
	function existinfosenfant2($agentid)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existinfosenfant2(".$agentid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select enfant2nom,enfant2prenoms,nombreenfants from tiers_agentsuemoa where agentid = ? " ;
		$result = $adb->pquery($query, array($agentid));
		$row1 = $adb->fetchByAssoc($result);

		if((trim($row1['enfant2nom'])!='' &&  trim($row1['enfant2prenoms'])!='') || intval($row1['nombreenfants'])>=2)
			return 1;
		else
			return 0;
	}
	
	function existinfosenfant3($agentid)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existinfosenfant3(".$agentid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select enfant3nom,enfant3prenoms,nombreenfants from tiers_agentsuemoa where agentid = ? " ;
		$result = $adb->pquery($query, array($agentid));
		$row1 = $adb->fetchByAssoc($result);

		if((trim($row1['enfant3nom'])!=''&&  trim($row1['enfant3prenoms'])!='') || intval($row1['nombreenfants'])>=3)
			return 1;
		else
			return 0;
	}
	
	function existinfosenfant4($agentid)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existinfosenfant4(".$agentid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select enfant4nom,enfant4prenoms,nombreenfants from tiers_agentsuemoa where agentid = ? " ;
		$result = $adb->pquery($query, array($agentid));
		$row1 = $adb->fetchByAssoc($result);

		if((trim($row1['enfant4nom'])!='' &&  trim($row1['enfant4prenoms'])!='') || intval($row1['nombreenfants'])>=4)
			return 1;
		else
			return 0;
	}
	
	function existinfosenfant5($agentid)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existinfosenfant5(".$agentid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select enfant5nom,enfant5prenoms,nombreenfants from tiers_agentsuemoa where agentid = ? " ;
		$result = $adb->pquery($query, array($agentid));
		$row1 = $adb->fetchByAssoc($result);

		if((trim($row1['enfant5nom'])!=''&&  trim($row1['enfant5prenoms'])!='') || intval($row1['nombreenfants'])>=5)
			return 1;
		else
			return 0;
	}
	
	function existinfosenfant6($agentid)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existinfosenfant6(".$agentid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select enfant6nom,enfant6prenoms,nombreenfants from tiers_agentsuemoa where agentid = ? " ;
		$result = $adb->pquery($query, array($agentid));
		$row1 = $adb->fetchByAssoc($result);

		if((trim($row1['enfant6nom'])!=''&&  trim($row1['enfant6prenoms'])!='') || intval($row1['nombreenfants'])>=6)
			return 1;
		else
			return 0;
	}
	
	
	
	function existcoordbanque2($agentid)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existcoordbanque2(".$agentid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select iban2 from tiers_agentsuemoa where agentid = ?" ;
		$result = $adb->pquery($query, array($agentid));
		$row1 = $adb->fetchByAssoc($result);

		if(trim($row1['iban2'])!='')
			return 1;
		else
			return 0;

	}
	function existcoordbanque3($agentid)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existcoordbanque3(".$agentid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select iban3 from tiers_agentsuemoa where agentid = ?" ;
		$result = $adb->pquery($query, array($agentid));
		$row1 = $adb->fetchByAssoc($result);

		if(trim($row1['iban3'])!='')
			return 1;
		else
			return 0;

	}
	function existcoordbanque4($agentid)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existcoordbanque4(".$agentid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select iban4 from tiers_agentsuemoa where agentid = ?" ;
		$result = $adb->pquery($query, array($agentid));
		$row1 = $adb->fetchByAssoc($result);

		if(trim($row1['iban4'])!='')
			return 1;
		else
			return 0;

	}
	function existcoordbanque5($agentid)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existcoordbanque5(".$agentid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select iban5 from tiers_agentsuemoa where agentid = ?" ;
		$result = $adb->pquery($query, array($agentid));
		$row1 = $adb->fetchByAssoc($result);

		if(trim($row1['iban5'])!='')
			return 1;
		else
			return 0;

	}
	
	/** Returns a list of the associated traitement
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	 */
	
	function get_traitements($ticket)
	{	
		// TO DO
		global $log, $singlepane_view,$adb;
		$log->debug("Entering get_traitements(".$ticket.") method ...");
		global $app_strings, $mod_strings;
		
		$button = '';
		
		
		$query ="select TRAIT.crmid,TRAIT.statut,TRAIT.datemodification,TRAIT.nom,TRAIT.organelib,TRAIT.organesigle,TRAIT.organecode,TRAIT.description
				FROM   
				(SELECT vtiger_crmentity.crmid, sigc_convention.statut, vtiger_crmentity.createdtime AS datemodification, 
				CONCAT( users.user_firstname, ' ', users.user_name ) AS nom,sigc_organes.organelibelle AS organelib,sigc_organes.organesigle AS organesigle,sigc_organes.organecode AS organecode, '' AS description
				FROM sigc_convention
				INNER JOIN vtiger_crmentity ON sigc_convention.conventionid = vtiger_crmentity.crmid
				INNER JOIN users ON users.user_id = vtiger_crmentity.smcreatorid
				INNER JOIN sigc_organes ON users.User_Direction = sigc_organes.organecode
				WHERE sigc_convention.ticket =?  AND vtiger_crmentity.deleted = 0 
				UNION  
				SELECT vtiger_crmentity.crmid, sigc_traitement_conventions.statut, vtiger_crmentity.createdtime AS datemodification, 
				concat( users.user_firstname, ' ', users.user_name ) AS nom,sigc_organes.organelibelle AS organelib,sigc_organes.organesigle AS organesigle,sigc_organes.organecode AS organecode, sigc_traitement_conventions.description
				FROM sigc_traitement_conventions
				INNER JOIN vtiger_crmentity ON sigc_traitement_conventions.traitementconventionid = vtiger_crmentity.crmid
				INNER JOIN users ON users.user_id = vtiger_crmentity.smcreatorid
				INNER JOIN sigc_organes ON users.User_Direction = sigc_organes.organecode
				WHERE sigc_traitement_conventions.ticket =?  AND vtiger_crmentity.deleted = 0
				)TRAIT
				ORDER BY TRAIT.datemodification asc" ;
		

		$log->debug("Exiting get_traitements method ...");
		$category = getParentTab($currentModule);
		$result = $adb->pquery($query, array($ticket,$ticket));
		while ( $row1 = $adb->fetchByAssoc($result) )
		{
			$row1["traitementid"] = $row1["crmid"];
			$row1["statut"] = $app_strings[$row1["statut"]];
			$row1["datemodification"] = getDisplayDate($row1["datemodification"]);
			$row1["nom"] = decode_html($row1["nom"]);
			$row1["organe"] = $row1["organelib"].'('.$this->getOrganeHier($row1["organecode"],$row1["organesigle"]).')';
			$row1["description"] = decode_html($row1["description"]);
			$traitement[]=$row1;			
		}
		return $traitement;
	}
	function getOrganeHier($organe)
	{
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getOrganesLibelle(".$organe.") method ...");
		global $app_strings, $mod_strings;
		
		$query ="SELECT CONCAT(o2.organesigle,'/',o3.organesigle) AS organehier,o3.depth,o3.organesigle sigle
				FROM sigc_organes o2,sigc_organes o3 
				WHERE o3.organeparent LIKE CONCAT('%',':',o2.organecode,':',o3.organecode) 
				AND o3.organecode=?" ;
		

		$log->debug("Exiting getOrganesLibelle method ...");
		$result = $adb->pquery($query, array($organe));
		$row1 = $adb->fetchByAssoc($result);
			if ($row1["depth"]>0)
				$organehier = $row1["organehier"];
			else
				$organehier = $row1["organesigle"];
		
		return $organehier;
	}
	
	
	
	function get_decaissements($ticket)
	{	
		// TO DO
		global $log, $singlepane_view,$adb;
		$log->debug("Entering get_decaissements(".$ticket.") method ...");
		global $app_strings, $mod_strings;
		
		$button = '';
		
		
		$query =" SELECT numengagement,dateengagement,montantengage,montantliquide,montantordonnance,
					dateordonnancement,montantpaye,datepaiement
				FROM sigc_decaissements
				WHERE numconvention=? " ;
		
		$log->debug("Exiting get_executions method ...");
		$category = getParentTab($currentModule);
		$result = $adb->pquery($query, array($ticket));
		while ( $row1 = $adb->fetchByAssoc($result) )
		{
			$row1["numengagement"] = $row1["numengagement"];
			$row1["dateengagement"] = getDisplayDate($row1["dateengagement"]);
			$row1["montantengage"] = number_format($row1["montantengage"], 0, ',', ' ');
			$row1["montantliquide"] = number_format($row1["montantliquide"], 0, ',', ' ');
			$row1["montantordonnance"] = number_format($row1["montantordonnance"], 0, ',', ' ');
			$row1["dateordonnancement"] = getDisplayDate($row1["dateordonnancement"]);
			$row1["montantpaye"] = number_format($row1["montantpaye"], 0, ',', ' ');
			$row1["datepaiement"] = decode_html($row1["datepaiement"]);
			$decaissement[]=$row1;			
		}
		return $decaissement;
	}
	function get_crexecutions($ticket)
	{	
		// TO DO
		global $log, $singlepane_view,$adb;
		$log->debug("Entering get_executions(".$ticket.") method ...");
		global $app_strings, $mod_strings;
		
		$button = '';
		
		
		$query =" SELECT vtiger_crmentity.smcreatorid,sigc_execution_conventions.idexecution,sigc_execution_conventions.reffournisseur,sigc_execution_conventions.refpaiement,
					sigc_modepaiement.modepaiementlib modepaiement,sigc_execution_conventions.montant,sigc_execution_conventions.datepaiement,
					sigc_execution_conventions.description,vtiger_crmentity.modifiedtime datesaisie
					FROM sigc_execution_conventions
					INNER JOIN vtiger_crmentity ON sigc_execution_conventions.idexecution = vtiger_crmentity.crmid
					INNER JOIN sigc_modepaiement ON sigc_execution_conventions.modepaiement = sigc_modepaiement.modepaiementcode
					WHERE sigc_execution_conventions.ticket =?  
					AND vtiger_crmentity.deleted = 0
					ORDER BY vtiger_crmentity.modifiedtime desc" ;
		

		$log->debug("Exiting get_executions method ...");
		$category = getParentTab($currentModule);
		$result = $adb->pquery($query, array($ticket));
		while ( $row1 = $adb->fetchByAssoc($result) )
		{
			$row1["idexecution"] = $row1["idexecution"];
			$row1["reffournisseur"] = $row1["reffournisseur"];
			$row1["refpaiement"] = $row1["refpaiement"];
			$row1["modepaiement"] = decode_html($row1["modepaiement"]);
			$row1["montant"] = number_format($row1["montant"], 0, ',', ' ');
			$row1["datepaiement"] = getDisplayDate($row1["datepaiement"]);
			$row1["localitenom"] = decode_html($row1["localitenom"]);
			$row1["datesaisie"] = getDisplayDate($row1["datesaisie"]);
			$row1["description"] = decode_html($row1["description"]);
			
			$pjustifs = $this->get_crexecutions_pjustif($row1["idexecution"]);

			$row1["pjustifid"] = $pjustifs["pjustifid"];
			$row1["filename"] = $pjustifs["filename"];
			
			$crexecution[]=$row1;			
		}
		return $crexecution;
	}
	
	function get_crexecutions_pjustif($idconventionfile)
	{	
		// TO DO
		global $log, $singlepane_view,$adb;
		$log->debug("Entering get_crexecutions_pjustif(".$idconventionfile.") method ...");
		global $app_strings, $mod_strings;
		
		$button = '';
		
		
		$query =" SELECT secv.conventionfileid pjustifid,cf.name filename FROM sigc_seconventionfilerel secv,sigc_conventionfiles cf 
					WHERE secv.crmid = cf.conventionfileid AND cf.conventionfileid AND cf.conventionfileid=?" ;
		
		$log->debug("Exiting get_crexecutions_pjustif method ...");
		$result = $adb->pquery($query, array($idconventionfile));
		$pjustifs = $adb->fetchByAssoc($result); 
			
		return $pjustifs;
	}
	
	function get_produitsfinanciers($ticket)
	{	
		// TO DO
		global $log, $singlepane_view,$adb;
		$log->debug("Entering get_produitsfinanciers(".$ticket.") method ...");
		global $app_strings, $mod_strings;
		
		$button = '';
		
		
		$query =" SELECT sigc_produitfinancier.idprodfin,sigc_produitfinancier.libelle,sigc_produitfinancier.montant,sigc_produitfinancier.dateprodfin datesaisie,sigc_produitfinancier.dateeffetprodfin dateeffet
					FROM sigc_produitfinancier
					WHERE sigc_produitfinancier.ticket =?  
					ORDER BY datesaisie DESC" ;
		

		$log->debug("Exiting get_produitsfinanciers method ...");
		$category = getParentTab($currentModule);
		$result = $adb->pquery($query, array($ticket));
		while ( $row1 = $adb->fetchByAssoc($result) )
		{
			$row1["idprodfin"] = $row1["idprodfin"];
			$row1["libelle"] = $row1["libelle"];
			$row1["montant"] = number_format($row1["montant"], 0, ',', ' ');
			$row1["dateeffet"] = getDisplayDate($row1["dateeffet"]);
			$row1["datesaisie"] = getDisplayDate($row1["datesaisie"]);
			
			
			$produitsfinanciers[]=$row1;			
		}
		return $produitsfinanciers;
	}
	
	/**
	 * Verifie l'existence du ticket pour gerer son unicité
	 */
	function existTicket($ticket)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existTicket(".$ticket.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select count(*) NBR from sigc_convention where ticket = ? " ;
		$result = $adb->pquery($query, array($ticket));
		$nbrows = $adb->query_result($result, 0 , "NBR");
		
		if($nbrows < 1)
			return 1;
		else
			return 0;
	}
	function getBailleursRates($conventionid)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getBailleursRates(".$conventionid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select bailleurs,bailleursrate from sigc_convention where conventionid = ? " ;
		$result = $adb->pquery($query, array($conventionid));
		$row1 = $adb->fetchByAssoc($result);
		$bailleurs = explode('|',$row1["bailleurs"]);
		$bailleursrate = explode('|',$row1["bailleursrate"]);

		return array('bailleurs1'=>$bailleurs[0],'bailleurs1rate'=>$bailleursrate[0],'bailleurs2'=>$bailleurs[1],'bailleurs2rate'=>$bailleursrate[1]);
	}
	
	
	
	/** 
	 * Handle saving related module information.
	 * NOTE: This function has been added to CRMEntity (base class).
	 * You can override the behavior by re-defining it here.
	 */
	// function save_related_module($module, $crmid, $with_module, $with_crmid) { }
	
	/**
	 * Handle deleting related module information.
	 * NOTE: This function has been added to CRMEntity (base class).
	 * You can override the behavior by re-defining it here.
	 */
	//function delete_related_module($module, $crmid, $with_module, $with_crmid) { }
	
	/**
	 * Handle getting related list information.
	 * NOTE: This function has been added to CRMEntity (base class).
	 * You can override the behavior by re-defining it here.
	 */
	//function get_related_list($id, $cur_tab_id, $rel_tab_id, $actions=false) { }
}
?>