<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the 
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
********************************************************************************/

include('vtigerversion.php');

// more than 8MB memory needed for graphics
// memory limit default value = 64M
ini_set('memory_limit','64M');

// show or hide calendar, world clock, calculator, chat and FCKEditor 
// Do NOT remove the quotes if you set these to false! 
/*
$CALENDAR_DISPLAY = 'true';
$WORLD_CLOCK_DISPLAY = 'true';
$CALCULATOR_DISPLAY = 'true';
$CHAT_DISPLAY = 'true'; 
$FCKEDITOR_DISPLAY = 'true';
*/
$CALENDAR_DISPLAY = 'true';
$WORLD_CLOCK_DISPLAY = 'false';
$CALCULATOR_DISPLAY = 'false';
$CHAT_DISPLAY = 'false'; 
$FCKEDITOR_DISPLAY = 'false';


// url for customer portal (Example: http://vtiger.com/portal)
//$PORTAL_URL = 'http://10.11.2.198/sigcuemoa/';

// helpdesk support email id and support name (Example: 'support@vtiger.com' and 'vtiger support')
$HELPDESK_SUPPORT_EMAIL_ID = 'diagne_meiz@yahoo.fr';
$HELPDESK_SUPPORT_NAME = 'your-support name';

//$default_module = 'UsersGID';

$default_admin_module = 'Demandes';
$default_tiers_module = 'Tiers';
$default_agent_module = 'Demandes';
$default_candidat_module = 'Candidats';

//$default_module = 'Tiers';
//$default_module = 'Conventions
//$default_module = 'Tiers';
$default_module = 'StatisticsSM';




$dbconfig['db_server']   = 'localhost';
$dbconfig['db_port'] 	 = ':3306';
$dbconfig['db_username'] = 'root';
$dbconfig['db_password'] = '';
$dbconfig['db_name']     = 'dsmuemoa';
$dbconfig['db_type']     = 'mysql';
$dbconfig['db_status']   = 'true';

$dbconfig['db_hostname'] = $dbconfig['db_server'].$dbconfig['db_port'];


$dbconfig['db_server_hist']   = 'localhost';
$dbconfig['db_name_hist']     = 'gidpcci_historisee';
$dbconfig['db_hostname_hist'] = $dbconfig['db_server_hist'].$dbconfig['db_port'];

$dbconfig['db_serversql']   = 'ouapapp03';
$dbconfig['db_usersql'] = 'sa';
$dbconfig['db_pwdsql'] = 'sa';
$dbconfig['db_sqlname']     = 'UEMOA_SOCIETE_03';

$dbconfig['DOMAIN_FQDN'] = 'uemoa.int';
$dbconfig['LDAP_SERVER'] = '172.16.1.52';

//************************ NOMADE *********************************************

//$WSSAP['URL_ENGAGEMENTMISSION_QUAL'] = 'http://OuavQE01.uemoa.int:8000/sap/bc/srt/wsdl/flv_10000A101AD1/bndg_url/sap/bc/srt/rfc/sap/yz_load_commitmebnt/220/yz_load_commitment_srv/yz_load_commitment?sap-client=220';

/**** LIEN QUAL ***********/
//$WSSAP['URL_ENGAGEMENTMISSION'] = 'http://OuavQE01.uemoa.int:8000/sap/bc/srt/wsdl/flv_10000A101AD1/bndg_url/sap/bc/srt/rfc/sap/yz_load_commitmebnt/225/yz_load_commitmebnt_srv/yz_load_commitmebnt_lnk?sap-client=225';
//$WSSAP['URL_CONTRDISPOFOND'] = 'http://OuavQE01.uemoa.int:8000/sap/bc/srt/wsdl/flv_10000A101AD1/bndg_url/sap/bc/srt/rfc/sap/zget_avaibility/225/zget_avaibility_srv/zget_avaibility_lnk?sap-client=225';

/**** LIEN PROD ***********/
$WSSAP['URL_ENGAGEMENTMISSION'] = 'http://OuavPE01.uemoa.int:8000/sap/bc/srt/wsdl/flv_10000A101AD1/bndg_url/sap/bc/srt/rfc/sap/yz_load_commitmebnt/400/yz_load_commitmebnt_srv/yz_load_commitmebnt_lnk?sap-client=400';
$WSSAP['URL_CONTRDISPOFOND'] = 'http://OuavPE01.uemoa.int:8000/sap/bc/srt/wsdl/flv_10000A101AD1/bndg_url/sap/bc/srt/rfc/sap/zget_avaibility/400/zget_avaibility_service/zget_avaibility_lnk?sap-client=400';

$WSSAP['URL_ENGAGEMENTREUNION'] = 'http://OuavQE01.uemoa.int:8000/sap/bc/srt/wsdl/flv_10000A101AD1/bndg_url/sap/bc/srt/rfc/sap/yz_load_budgetreunion/225/yz_load_budgetreunion_srv/yz_load_budgetreunion_lnk?sap-client=225';

//$WSSAP['URL_ANNULERENGAGEMENT'] = 'http://ouavqe01.uemoa.int:8000/sap/bc/srt/wsdl/flv_10000A101AD1/bndg_url/sap/bc/srt/rfc/sap/yzwsfi07_canceldocment/225/yzwsfio7_canceldocument/yzwsfio7_cancel_lnk?sap-client=225';
$WSSAP['URL_ANNULERENGAGEMENT'] = 'http://OuavPE01.uemoa.int:8000/sap/bc/srt/wsdl/flv_10000A101AD1/bndg_url/sap/bc/srt/rfc/sap/yzwsfi07_canceldocment/400/yswsfi07_canceldocument_srv/yswsfi07_canceldocument_lnk?sap-client=400';

$WSSAP['SOAP_AUTH'] = array( 'user'=> 'WBS_USER','password'=>'P@ssw0rdSAP20');
//$WSSAP['CODEFOURNISSEUR'] = '420433';
$WSSAP['CODEFOURNISSEUR'] = 'C0001-2018';
$WSSAP['PERIMETREFIN']['01'] = 'PF00';
$WSSAP['PERIMETREFIN']['02'] = 'PF00';
$WSSAP['PERIMETREFIN']['03'] = 'PF30';
$WSSAP['PERIMETREFIN']['04'] = 'PF00';
$WSSAP['PERIMETREFIN']['05'] = 'PF00';

$WSSAP['AFISCAL'] = '2018';

$DBPHEB['MSSQL_AUTH'] = array('user'=>'sa','pwd'=>'sa','db'=>'UEMOA_SOCIETE_09','servername'=>'OUAVPHEBBD01'); 

$ANNEESTAT =array(00=>'Choisir...',1980=>'1980',1981=>'1981',1982=>'1982',1983=>'1983',1984=>'1984',1985=>'1985',1986=>'1986',1987=>'1987',1988=>'1988',1989=>'1989',
				  1990=>'1990',1991=>'1991',1992=>'1992',1993=>'1993',1994=>'1994',1995=>'1995',1996=>'1996',1997=>'1997',1998=>'1998',1999=>'1999',
				  2000=>'2000',2001=>'2001',2002=>'2002',2003=>'2003',2004=>'2004',2005=>'2005',2006=>'2006',2007=>'2007',2008=>'2008',2009=>'2009',
				  2010=>'2010',2011=>'2011',2012=>'2012',2013=>'2013',2014=>'2014',2015=>'2015',2016=>'2016',2017=>'2017',2018=>'2018',2019=>'2019',
				  2020=>'2020',2021=>'2021',2022=>'2022',2023=>'2023',2024=>'2024',2025=>'2025');
$MOISSTAT =array(0=>'Choisir...',1=>'Janvier',2=>'F&eacute;vrier',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'D&eacute;cembre');
$MOISSTATS =array(1=>'M1',2=>'M2',3=>'M3',4=>'M4',5=>'M5',6=>'M6',7=>'M7',8=>'M8',9=>'M9',10=>'M10',11=>'M11',12=>'M12');
$TRIMESTRESTATS =array(1=>'T1',2=>'T2',3=>'T3',4=>'T4');

$NATUREMISSION = array(""=>"Choisissez la nature de la mission...", "01"=>"Atelier","02"=>"Atelier de formation",
					   "03"=>"Atelier de validation","04"=>"Conf&eacute;rence des chefs d\'&eacute;tats","05"=>"Conseil des ministres sectoriel",
					   "06"=>"Conseil des ministres statutaires","07"=>"Formation","08"=>"Invitation",
						"09"=>"Mission","10"=>"Mission circulaire","11"=>"Ordinaire","12"=>"R&eacute;union des Experts Sectoriels",
						"13"=>"R&eacute;union des Experts Statutaires","14"=>"R&eacute;union","15"=>"Secr&eacute;tariat Conjoint",
						"16"=>"S&eacute;minaire","17"=>"S&eacute;minaire de formation","18"=>"Stage de formation");

$MOYENTRANSPORT = array("01"=>"Avion","02"=>"Avion et Train","03"=>"Avion et Voiture",
						"04"=>"Avion Train Voiture","05"=>"Train","06"=>"Voiture");

$TYPEREAMENAGEMENT = array(""=>"Choisir...","Transfert"=>"Transfert","Virement"=>"Virement");


$TYPEBUDGET = array(""=>"Choisirle type de budget...","FAI"=>"Budget Sp&eacute;cial du FAIR",
"FRD"=>"Budget Sp&eacute;cial du FRDA",
"ORG"=>"Budget des Organes",
"EXT"=>"Prise en charge ext&eacute;rieure",
"CCR"=>"Budget Sp&eacute;cial CCR");

$ZONEMISSION = array(""=>"Choisir la zone de la mission...","1"=>"UEMOA",
"2"=>"AFRIQUE HORS UEMOA",
"3"=>"HORS AFRIQUE");
$DEMSTATUTS =array("open"=>"En pr&eacute;paration","submitted"=>"Soumise","signed"=>"Sign&eacute;e","authorized"=>"Autoris&eacute;e",
					"umv_accepted"=>"Vis&eacute;e par UMV","denied"=>"Rejet&eacute;e","cancelled"=>"Annul&eacute;e");
						
//************************ FIN NOMADE *********************************************



$DELAICANDIDATURE = "le 30 Mai 2017 &agrave; 16h00";
$BOURSEEDITION = "2017 - 2018";
$PAYS = array(""=>"Choisissez un Pays...","PAYS DE L'UEMOA"=> array("BENIN"=>"BENIN","BURKINA FASO"=>"BURKINA FASO","COTE DIVOIRE"=>"COTE D'IVOIRE","GUINEE-BISSAU"=>"GUINEE-BISSAU","MALI"=>"MALI","NIGER"=>"NIGER","SENEGAL"=>"SENEGAL","TOGO"=>"TOGO"),"AUTRES PAYS" => array("AFRIQUE DU SUD"=>"AFRIQUE DU SUD","AUTRICHE"=>"AUTRICHE","BELGIQUE"=>"BELGIQUE","CANADA"=>"CANADA","CUBA"=>"CUBA","USA"=>"ÉTATS UNIS D'AMÉRIQUE","GHANA"=>"GHANA","GUINEE CONAKRY"=>"GUINEE CONAKRY","FRANCE"=>"FRANCE","LUXEMBOURG"=>"LUXEMBOURG","NIGERIA"=>"NIGERIA","SUISSE"=>"SUISSE","TUNISIE"=>"TUNISIE","USA"=>"USA"));
$PAYSUEMOA = array(""=>"Choisissez un Pays...","BENIN"=>"BENIN","BURKINA FASO"=>"BURKINA FASO","COTE DIVOIRE"=>"COTE D'IVOIRE","GUINEE-BISSAU"=>"GUINEE-BISSAU","MALI"=>"MALI","NIGER"=>"NIGER","SENEGAL"=>"SENEGAL","TOGO"=>"TOGO");
$CODEPAYSUEMOA = array("BN"=>"BENIN","BF"=>"BURKINA FASO","CI"=>"COTE D'IVOIRE","GB"=>"GUINEE-BISSAU","ML"=>"MALI","NG"=>"NIGER","SN"=>"SENEGAL","TG"=>"TOGO");
$NATIONNALITE = array(""=>"Choisissez...","BENINOISE"=>"BENINOISE","BURKINABE"=>"BURKINABE","IVOIRIENNE"=>"IVOIRIENNE","BISSAU GUINEENNE"=>"BISSAU GUINEENNE","MALIENNE"=>"MALIENNE","NIGERIENNE"=>"NIGERIENNE","SENEGALAISE"=>"SENEGALAISE","TOGOLAISE"=>"TOGOLAISE");
$DEVISES = array(""=>"Choisissez une devise...","XOF"=>"Franc CFA (BCEAO)","EUR"=>"Euro","USD"=>"Dollar US");
$NIVEAUDIPLOME =array(""=>"Choisir...","BAC + 4"=>"BAC + 4","BAC + 5"=>"BAC + 5","Master 1"=>"Master 1",
			"Master 2"=>"Master 2",">BAC + 5"=>">BAC + 5");

$BOOL =array(""=>"Choisir...","OUI"=>"OUI","NON"=>"NON");
$FORMESJURIDIQUES = array(""=>"Choisissez une Forme Juridique...","SURL"=>"Soci&eacute;t&eacute; Unipersonnelle &agrave; responsabilit&eacute; limit&eacute;e (SURL)","SARL"=>"Soci&eacute;t&eacute; &agrave; Responsabilit&eacute; Limit&eacute;e (SARL)","ENTIND"=>"Entreprise individuelle","SA"=>"Soci&eacute;t&eacute; anonyme (SA)","SNC"=>"Soci&eacute;t&eacute; en Nom Collectif (SNC)","SCS"=>"Soci&eacute;t&eacute; en Commandite Simple (SCS)","GIE"=>"Groupement d Int&eacute;r&ecirc;t Economique (GIE)");
$PERSONNALITEJURIDIQUES = array(""=>"Choisissez une Personnalite Juridique...","PERSONNE PHYSIQUE"=>"Personne Physique","PERSONNE MORALE"=>"Personne Morale");
$STATUTS =array(""=>"Choisissez un statut...","1"=>"Actif","0"=>"Inactif");
$NBENFANTS =array(""=>"Choisir...","0"=>"0","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6");
$SEXE =array(""=>"Choisir...","F"=>"F&eacute;minin","M"=>"Masculin");
$CIVILITE=array(""=>"Choisir...","MME"=>"Madame","MLLE"=>"MAdemoiselle","M"=>"Monsieur");
$SITUATIONFAMILIALE=array(""=>"Choisir...","C"=>"C&eacute;libataire","M"=>"Mari&eacute;(e)","D"=>"Divorc&eacute;(e)","V"=>"Veuf(ve)","S"=>"S&eacute;par&eacute;(e)");
$SCOLOUAPPRENT =array(""=>"Choisir...","scolarise"=>"Scolaris&eacute;(e)","apprentissage"=>"En Apprentissage");
$SALOUCOM =array(""=>"Choisir...","commercant"=>"Commer&ccedil;ant(e)","salarie"=>"Salari&eacute;(e)");
$NATUREACTENAIS =array(""=>"Choisir...","extrait"=>"Extrait","bulletin"=>"Bulletin","jugement"=>"Jugement");
$NATUREPIECEIDENT =array(""=>"Choisir...","passeport"=>"Passeport","CNI"=>"Carte d'Identit&eacute;(CNI)");
$TYPECONTRAT =array(""=>"Choisir...","MO"=>"Membre d'Organes(MO)","CDI"=>"Contrat &agrave; Dur&eacute;e Ind&eacute;termin&eacute;e(CDI)","CDD"=>"Contrat &agrave; Dur&eacute;e D&eacute;termin&eacute;e(CDD)");
$CATEGORIESALARIE =array(""=>"Choisir...","MO"=>"MO : Membres d'organes","M"=>"M : Agent de Service Auxiliaire","G"=>"G : Agent de Service G&eacute;n&eacute;raux","P"=>"P : Professionnels");
//$STATUTSALARIE =array(""=>"Choisir...","11"=>"Membre d'Organes(MO)","12"=>"Pr&eacute;sident","21"=>"Professionnels(P)","22"=>"Agents Services G&eacute;n&eacute;raux(G)","23"=>"Agents Services Auxiliaires(M)");
$STATUTSALARIE =array(""=>"Choisir...","11"=>"Membre d'organe local","12"=>"Membre d'organe expatri&eacute;","13"=>"Local Fonctionnaire","14"=>"Local Contractuel","15"=>"Local Contractuel Forfaitaires","16"=>"Local Contractuel Devis Programmes Forfaitaires Contractuels","17"=>"Expatri&eacute; Fonctionnaire","18"=>"Expatri&eacute; Contractuel","19"=>"Expatri&eacute; Contractuel Forfaitaires","20"=>"Expatri&eacute; Contractuel Devis Programmes Forfaitaires Contractuels");
$LANGUEFORMATION =array(""=>"Choisir...","FR"=>"Fran&ccedil;ais","EN"=>"Anglais","PO"=>"Portugais");
$MODEDEPAIEMENT =array(""=>"Choisir...","virement"=>"Virement","espece"=>"Esp&egrave;ces","cheque"=>"Ch&eacute;que");
$PERIODEESSAI =array(""=>"Choisir...","non"=>"Non","oui"=>"Oui");
$DIPLOME =array(""=>"Choisir...","deug"=>"D.E.U.G","licence"=>"Licence","licencepro"=>"Licence Pro","maitrise"=>"Maitrise","master"=>"Master","DESS"=>"D.E.S.S","phd"=>"Ph D","doctorat"=>"Doctorat");
$NIVEAUSCOLAIRE =array(""=>"Choisir...","2"=>"FORMATION BAC + 3 ..(LICENCE, ECOLES SUPERIEURES, INGENIEUR)","3"=>"FORMATION BAC + 2 (BTS, DUT, 1ER CYCLE SUPERIEUR)","4"=>"FORMATION EQUIVALENTE AU BAC, BAC TECHNIQUE, BREVET TECHNIQUE",
			"5"=>"NIVEAU DE FORMATION EQUIVALENT AU BEP, CAP","6"=>"FORMATION COURTE, MAXI 1 AN, CONDUISANT AU CEP OU EQUIVALENT","7"=>"PAS DE FORMATION ALLANT AU-DELA DE LA FIN DE SCOLARITE OBLIGATOIRE");
$PERMISCONDUIRE =array("categorieB"=>"Cat&eacute;gorie B","categorieA"=>"Cat&eacute;gorie A","categorieC"=>"Cat&eacute;gorie C","categorieD"=>"Cat&eacute;gorie D","aucun"=>"Aucun");

$MOTIFSDEPART =array(""=>"Choisir...","4"=>"DISPONIBILITE","AG"=>"65 &eacute;me anniversaire","AUT"=>"Autres","CA"=>"Cessation d'activit&eacute; entreprise","CP"=>"Non r&eacute;int&eacute;gration apr&egrave;s cong&eacute; parental",
		    "DC"=>"D&eacute;c&egrave;s","DEC"=>"Suite &agrave; d&eacute;centralisation","DM"=>"D&eacute;mission","DPE"=>"D&eacute;part en pr&eacute;-retraite pour motif &eacute;conomique",
		    "DPV"=>"D&eacute;part en pr&eacute;-retraite volontaire","DRE"=>"D&eacute;part en retraite pour motif &eacute;conomique",
		    "DRV"=>"D&eacute;part en retraite volontaire","FC"=>"Fin de contrat entreprise","FCD"=>"Fin de CDD",
		    "FCE"=>"Fin de p&eacute;riode d'essai entreprise","FCS"=>"Fin de p&eacute;riode d'essai salari&eacute;","FM"=>"Force majeure",
		    "FMI"=>"Fin de mission d'int&eacute;rim","LI"=>"Licenciements","LI1"=>"Licenciement disciplinaire","LI2"=>"Licenciement &eacute;conomique",
		    "MCT"=>"Modification du contrat de travail","PFC"=>"Fin de chantier","RAE"=>"Rupture anticip&eacute;e CDD sur initiative employeur",
		    "RAS"=>"Rupture anticip&eacute;e CDD sur initiative salari&eacute;","RCC"=>"Rupture suite &agrave; une convention de conversion","RIE"=>"Retraite",
		    "RIS"=>"Retraite &agrave; l'initiative du salari&eacute;","RLJ"=>"Suite &agrave; redressement ou liquidation judiciaire",
		    "RME"=>"Rupture pour motif &eacute;co. (Art. L321-1 du CT)","SN"=>"Service national");

			
$TYPEMATERIELS =array(""=>"Choisir...",'ORDINATEUR PORTABLE'=>array('MacBook'=>'MacBook','PC Portable'=>'PC Portable','Accessoires PC Portable'=>'Accessoires PC Portable'),
'ORDINATEUR DE BUREAU'=>array('iMac, Mac mini, Mac pro'=>'iMac, Mac mini, Mac pro','PC de bureau'=>'PC de bureau','Unite centrale'=>'Unit&eacute; centrale'),
'TABLETTE, IPAD'=>array('Tablette Tactile'=>'Tablette Tactile','Samsung Galaxy tab'=>'Samsung Galaxy tab','Accessoires Tablette, iPad'=>'Accessoires Tablette, iPad'),
'COMPOSANTS'=>array('Processeur'=>'Processeur','Memoire PC'=>'M&eacute;moire PC','Carte Graphique'=>'Carte Graphique','Carte mere'=>'Carte m&egrave;re','Alimentation PC'=>'Alimentation PC','Boitier PC'=>'Boitier PC','Graveur'=>'Graveur'),
'STOCKAGE'=>array('Disque dur interne'=>'Disque dur interne','Disque dur externe'=>'Disque dur externe'),
'PERIPHERIQUES'=>array('Ecran PC'=>'Ecran PC','Imprimante'=>'Imprimante','Scanner'=>'Scanner','Clavier'=>'Clavier','Souris'=>'Souris','Webcam'=>'Webcam','Micro-casque'=>'Micro-casque'),
'RESEAU'=>array('Onduleur'=>'Onduleur','Multiprise'=>'Multiprise','Modem Routeur , Points dacces'=>'Modem Routeur , Points d acc&egrave;s','Switch'=>'Switch','Repeteur WiFi'=>'R&eacute;p&eacute;teur WiFi'),
'ACCESSOIRES'=>array('Accessoires ordinateur portable'=>'Accessoires ordinateur portable','Sacoche ordinateur portable'=>'Sacoche ordinateur portable'));


$QUANTITE =array(1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12',13=>'13',14=>'14',15=>'15',16=>'16',17=>'17',18=>'18',19=>'19',20=>'20',21=>'21',22=>'22',23=>'23',24=>'24',25=>'25',26=>'26',27=>'27',28=>'28',29=>'29',30=>'30',31=>'31',32=>'32',33=>'33',34=>'34',35=>'35',36=>'36',37=>'37',38=>'38',39=>'39',40=>'40',41=>'41',42=>'42',43=>'43',44=>'44',45=>'45',46=>'46',47=>'47',48=>'48',49=>'49',50=>'50');
$ANNEEBUDGETAIRE =array(2016=>'2016',2017=>'2017',2018=>'2018',2019=>'2019',2020=>'2020',2021=>'2021',2022=>'2022',2023=>'2023',2024=>'2024',2025=>'2025');
$PRIORITE =array('normal'=>'Normal','haute'=>'Haute','urgente'=>'Urgence signal&eacute;e');
$NATUREDEMANDE =array(""=>"Choisir...",
'CONSOMMABLES'=>array('Consommables : Fournitures de Bureau'=>'Fournitures de Bureau','Consommables : Cartouche d\'encre'=>'Cartouche d\'encre','Consommables : Informatique'=>'Informatique','Consommables : Telephonie'=>'T&eacute;l&eacute;phonie'),
'TRAVAUX'=>array('Travaux : Climatisation'=>'Climatisation','Travaux : Informatique'=>'Informatique','Travaux : Plomberie'=>'Plomberie','Travaux : Menuiserie'=>'Menuiserie','Travaux : Serrurerie'=>'Serrurerie','Travaux : Second oeuvre'=>'Second oeuvre','Travaux : Telephonie'=>'T&eacute;l&eacute;phonie'),
);
$TYPETRAVAUX =array(""=>"Choisir...",'ELECTRICITE'=>array('probleme electrique'=>'Probl&egrave;me electrique','Absence de lumiere'=>'Absence de lumi&egrave;re','probleme prise courant'=>'Probl&egrave;me prise courant','changement ampoule'=>'Changement Ampoule','autres'=>'Autres'),
'PLOMBERIE'=>array('robinet HS'=>'Robinet HS','fuite d eau'=>'Fuite d\'eau','coupure d eau'=>'Coupure d\'eau','WC HS'=>'WC HS','siphon bouche'=>'Siphon bouch&eacute;','autres'=>'Autres'),
'CLIMATISATION'=>array('climatisation HS'=>'Climatisation HS','maintenance climatisation'=>'Maintenance climatisation','autres'=>'Autres'),
'SERRURERIE'=>array('serrure HS'=>'Serrure HS','duplication cle'=>'Duplication cl&eacute;'),
'MENUISERIE'=>array('porte cassee'=>'Porte cass&eacute;e','table bureau deterioree'=>'Table bureau d&eacute;terior&eacute;e','caisson deterioree'=>'Caisson d&eacute;terior&eacute;e','autres'=>'Autres'),
'INFORMATIQUE'=>array('Reseau HS'=>'R&eacute;seau HS','Internet HS'=>'Internet HS','imprimante HS'=>'Imprimante HS','Clavier HS'=>'Clavier HS','Souris HS'=>'Souris HS','autres'=>'Autres'),
'TELEPHONIE'=>array('telephone HS'=>'t&eacute;l&eacute;phone HS','autres'=>'Autres'),
'SECOND OEUVRE'=>array('probleme carrelage'=>'Probl&egrave;me carrelage','probleme planchet'=>'Probl&egrave;me planchet','reprise peinture'=>'Reprise peinture','autres'=>'Autres')
);

$TYPECONSOMMABLES =array(""=>"Choisir...",'FOURNITURES DE BUREAU'=>array('papeterie'=>'Papeterie','fauteil'=>'Fauteil','chaises visiteur'=>'Chaises Visiteur','autres'=>'Autres'),
'CARTOUCHE D\'ENCRE'=>array('cartouche IR 1600'=>'cartouche IR 1600','autres'=>'Autres')
);			
			/*************************	Debut Archivage	****************************/

$dbconfig['all_incident'] = " (SELECT * FROM gidpcci.siprod_incident UNION SELECT * FROM gidpcci_historisee.siprod_incident) ";
//$dbconfig['all_incient_crmentity'] = " (SELECT * FROM gidpcci.vtiger_crmentity WHERE setype = 'Incidents' UNION SELECT * FROM gidpcci_historisee.vtiger_crmentity WHERE setype = 'Incidents') ";
$dbconfig['all_incient_crmentity'] = " (SELECT * FROM gidpcci.vtiger_crmentity UNION SELECT * FROM gidpcci_historisee.vtiger_crmentity) ";
$dbconfig['all_traitement_incident'] = " (SELECT * FROM gidpcci.siprod_traitement_incidents UNION SELECT * FROM gidpcci_historisee.siprod_traitement_incidents) ";
//$dbconfig['all_tr_incient_crmentity'] = " (SELECT * FROM gidpcci.vtiger_crmentity WHERE setype = 'TraitementIncidents' UNION SELECT * FROM gidpcci_historisee.vtiger_crmentity WHERE setype = 'TraitementIncidents') ";
$dbconfig['all_tr_incient_crmentity'] = " (SELECT * FROM gidpcci.vtiger_crmentity UNION SELECT * FROM gidpcci_historisee.vtiger_crmentity) ";
$dbconfig['all_suivi_incident_technique'] = " (SELECT * FROM gidpcci.siprod_suivi_incidents_tech UNION SELECT * FROM gidpcci_historisee.siprod_suivi_incidents_tech) ";


$dbconfig['sigc_convention'] = '';
//$dbconfig['gid_incient_crmentity'] = " (SELECT * FROM gidpcci.vtiger_crmentity WHERE setype = 'Incidents') ";
$dbconfig['sigc_convention_crmentity'] = " sigc_cuemoa.vtiger_crmentity ";
$dbconfig['sigc_traitement_convention'] = '';
//$dbconfig['gid_tr_incient_crmentity'] = " (SELECT * FROM gidpcci.vtiger_crmentity WHERE setype = 'TraitementIncidents') ";
$dbconfig['gid_tr_incient_crmentity'] = " sigc_cuemoa.vtiger_crmentity ";
$dbconfig['gid_suivi_incident_technique'] = '';

/*
$dbconfig['gid_hist_incident'] = " gidpcci_historisee.siprod_incident ";
//$dbconfig['gid_hist_incient_crmentity'] = " (SELECT * FROM gidpcci_historisee.vtiger_crmentity WHERE setype = 'Incidents') ";
$dbconfig['gid_hist_incient_crmentity'] = " gidpcci_historisee.vtiger_crmentity ";
$dbconfig['gid_hist_traitement_incident'] = " gidpcci_historisee.siprod_traitement_incidents ";
//$dbconfig['gid_hist_tr_incient_crmentity'] = " (SELECT * FROM gidpcci_historisee.vtiger_crmentity WHERE setype = 'TraitementIncidents') ";
$dbconfig['gid_hist_tr_incient_crmentity'] = " gidpcci_historisee.vtiger_crmentity ";
$dbconfig['gid_hist_suivi_incident_technique'] = " gidpcci_historisee.siprod_suivi_incidents_tech ";
*/
/*************************	Fin Archivage	****************************/


/*
$dbconfig['db_server'] = 'SSIIDEV01';
$dbconfig['db_port'] = '';
$dbconfig['db_username'] = 'gidpcci';
$dbconfig['db_password'] = 'gidpcci';
$dbconfig['db_name'] = 'gidpcci';
$dbconfig['db_type'] = 'mssql';
$dbconfig['db_status'] = 'true';

$dbconfig['db_hostname'] = $dbconfig['db_server'];
*/
// TODO: test if port is empty
// TODO: set db_hostname dependending on db_type

// log_sql default value = false
$dbconfig['log_sql'] = false;

// persistent default value = true
$dbconfigoption['persistent'] = true;

// autofree default value = false
$dbconfigoption['autofree'] = false;

// debug default value = 0
$dbconfigoption['debug'] = 0;

// seqname_format default value = '%s_seq'
$dbconfigoption['seqname_format'] = '%s_seq';

// portability default value = 0
$dbconfigoption['portability'] = 0;

// ssl default value = false
$dbconfigoption['ssl'] = false;

$host_name = $dbconfig['db_hostname'];

//$site_URL = 'http://localhost:80';

// root directory path
$root_directory = 'C:/wamp/www/bdsm/';
//$root_directory = 'C:/xampp/htdocs/portailadmin/';
//$root_directory = '/var/www/sigcuemoa/';
//$root_directory = '/var/www/hodarcrm/';
//$root_directory ='/var/www/vhosts/hodarconseil.com/httpdocs/hodarcrm/';
// cache direcory path
$cache_dir = 'cache/';

// tmp_dir default value prepended by cache_dir = images/
$tmp_dir = 'cache/images/';

// import_dir default value prepended by cache_dir = import/
$import_dir = 'cache/import/';

// upload_dir default value prepended by cache_dir = upload/
$upload_dir = 'cache/upload/';

// maximum file size for uploaded files in bytes also used when uploading import files
// upload_maxsize default value = 3000000
$upload_maxsize = 3000000;

// flag to allow export functionality
// 'all' to allow anyone to use exports 
// 'admin' to only allow admins to export 
// 'none' to block exports completely 
// allow_exports default value = all
$allow_exports = 'all';

// files with one of these extensions will have '.txt' appended to their filename on upload
// upload_badext default value = php, php3, php4, php5, pl, cgi, py, asp, cfm, js, vbs, html, htm
$upload_badext = array('php', 'php3', 'php4', 'php5', 'pl', 'cgi', 'py', 'asp', 'cfm', 'js', 'vbs', 'html', 'htm', 'exe', 'bin', 'bat', 'sh', 'dll', 'phps');

// full path to include directory including the trailing slash
// includeDirectory default value = $root_directory..'include/
$includeDirectory = $root_directory.'include/';

// list_max_entries_per_page default value = 20
$list_max_entries_per_page = '100';

// limitpage_navigation default value = 5
$limitpage_navigation = '20';

// history_max_viewed default value = 5
$history_max_viewed = '5';

// define list of menu tabs
//$moduleList = Array('Home', 'Dashboard', 'Contacts', 'Accounts', 'Opportunities', 'Cases', 'Notes', 'Calls', 'Emails', 'Meetings', 'Tasks','MessageBoard');

// map sugar language codes to jscalendar language codes
// unimplemented until jscalendar language files are fixed
// $cal_codes = array('en_us'=>'en', 'ja'=>'jp', 'sp_ve'=>'sp', 'it_it'=>'it', 'tw_zh'=>'zh', 'pt_br'=>'pt', 'se'=>'sv', 'cn_zh'=>'zh', 'ge_ge'=>'de', 'ge_ch'=>'de', 'fr'=>'fr');

// default_module default value = Home
//$default_module = 'Conventions';
//$default_module = 'Calendar';

// default_action default value = index
$default_action = 'index';

// set default theme
// default_theme default value = blue
//$default_theme = 'softed';
$default_theme = 'woodspice';

// show or hide time to compose each page
// calculate_response_time default value = true
$calculate_response_time = true;

// default text that is placed initially in the login form for user name
// no default_user_name default value
$default_user_name = '';

// default text that is placed initially in the login form for password
// no default_password default value
$default_password = '';

// create user with default username and password
// create_default_user default value = false
$create_default_user = false;
// default_user_is_admin default value = false
$default_user_is_admin = false;

// if your MySQL/PHP configuration does not support persistent connections set this to true to avoid a large performance slowdown
// disable_persistent_connections default value = false
$disable_persistent_connections = false;

// defined languages available. the key must be the language file prefix. (Example 'en_us' is the prefix for every 'en_us.lang.php' file)
// languages default value = en_us=>US English
//$languages = Array('en_us'=>'US English',);
$languages = array('fr_fr'=>'Fran&ccedil;ais',);
//$languages = Array('en_us'=>'US English','fr_fr'=>'Français',);

//Master currency name
$currency_name = 'USA, Dollars';

// default charset
// default charset default value = 'UTF-8' or 'ISO-8859-1'
$default_charset = 'UTF-8';
//$default_charset = 'ISO-8859-1';
// default language
// default_language default value = en_us
//$default_language = 'en_us';
$default_language = 'fr_fr';
// add the language pack name to every translation string in the display.
// translation_string_prefix default value = false
$translation_string_prefix = false;

//Option to cache tabs permissions for speed.
$cache_tab_perms = true;

//Option to hide empty home blocks if no entries.
$display_empty_home_blocks = false;

// Generating Unique Application Key
$application_unique_key = '01afb95680b627052bfb7aa9e11601dc12xxzz';

// trim descriptions, titles in listviews to this value
$listview_max_textlength = 30;

// Maximum time limit for PHP script execution (in seconds)
$php_max_execution_time = 0;

// Set the default timezone as per your preference
//$default_timezone = '';
//$default_timezone = 'Europe/Paris';
?>
