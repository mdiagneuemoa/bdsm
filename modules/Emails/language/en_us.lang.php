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
/*********************************************************************************
 * $Header: /cvs/repository/siprodPCCI/modules/Emails/language/en_us.lang.php,v 1.1 2010/01/15 18:45:01 isene Exp $
 * Description:  Defines the English language pack for the Account module.
 ********************************************************************************/
 
$mod_strings = Array(
// Mike Crowe Mod --------------------------------------------------------added for general search
'LBL_GENERAL_INFORMATION'=>'General Information',

'LBL_MODULE_NAME'=>'Email',
'LBL_MODULE_TITLE'=>'Email: Home',
'LBL_SEARCH_FORM_TITLE'=>'Email Search',
'LBL_LIST_FORM_TITLE'=>'Email List',
'LBL_NEW_FORM_TITLE'=>'Track Email',

'LBL_LIST_SUBJECT'=>'Subject',
'LBL_LIST_CONTACT'=>'Contact',
'LBL_LIST_RELATED_TO'=>'Related to',
'LBL_LIST_DATE'=>'Date Sent',
'LBL_LIST_TIME'=>'Time Sent',

'ERR_DELETE_RECORD'=>"A record number must be specified to delete the vtiger_account.",
'LBL_DATE_SENT'=>'Date Sent:',
'LBL_DATE_AND_TIME'=>'Date & Time Sent:',
'LBL_DATE'=>'Date Sent:',
'LBL_TIME'=>'Time Sent:',
'LBL_SUBJECT'=>'Subject:',
'LBL_BODY'=>'Body:',
'LBL_CONTACT_NAME'=>' Contact Name: ',
'LBL_EMAIL'=>'Email:', 
'LBL_DETAILVIEW_EMAIL'=>'E-Mail', 
'LBL_COLON'=>':',
'LBL_CHK_MAIL'=>'Check Mail',
'LBL_COMPOSE'=>'Compose',
//Single change for 5.0.3
'LBL_SETTINGS'=>'Incoming Mail Server Settings',
'LBL_EMAIL_FOLDERS'=>'Email Folders',
'LBL_INBOX'=>'Inbox',
'LBL_SENT_MAILS'=>'Sent Mails',
'LBL_TRASH'=>'Trash',
'LBL_JUNK_MAILS'=>'Junk Mails',
'LBL_TO_LEADS'=>'To Leads',
'LBL_TO_CONTACTS'=>'To Contacts',
'LBL_TO_ACCOUNTS'=>'To Accounts',
'LBL_MY_MAILS'=>'My Mails',
'LBL_QUAL_CONTACT'=>'Qualified Mails (As Contacts)',
'LBL_MAILS'=>'Mails',
'LBL_QUALIFY_BUTTON'=>'Qualify',
'LBL_REPLY_BUTTON'=>'Reply',
'LBL_FORWARD_BUTTON'=>'Forward',
'LBL_DOWNLOAD_ATTCH_BUTTON'=>'Download Attachments',
'LBL_FROM'=>'From :',
'LBL_CC'=>'Cc :',
'LBL_BCC'=>'Bcc :',

'NTC_REMOVE_INVITEE'=>'Are you sure you want to remove this recipient from the email?',
'LBL_INVITEE'=>'Recipients',

// Added Fields
// Contacts-SubPanelViewContactsAndUsers.php
'LBL_BULK_MAILS'=>'Bulk Mails',
'LBL_ATTACHMENT'=>'Attachment',
'LBL_UPLOAD'=>'Upload',
'LBL_FILE_NAME'=>'File Name',
'LBL_SEND'=>'Send',

'LBL_EMAIL_TEMPLATES'=>'Email Templates',
'LBL_TEMPLATE_NAME'=>'Template Name',
'LBL_DESCRIPTION'=>'Description',
'LBL_EMAIL_TEMPLATES_LIST'=>'Email Templates  List',
'LBL_EMAIL_INFORMATION'=>'Email Information',




//for v4 release added
'LBL_NEW_LEAD'=>'New Lead',
'LBL_LEAD_TITLE'=>'Leads',

'LBL_NEW_PRODUCT'=>'New Product',
'LBL_PRODUCT_TITLE'=>'Products',
'LBL_NEW_CONTACT'=>'New Contact',
'LBL_CONTACT_TITLE'=>'Contacts',
'LBL_NEW_ACCOUNT'=>'New Account',
'LBL_ACCOUNT_TITLE'=>'Accounts',

// Added vtiger_fields after vtiger4 - Beta
'LBL_USER_TITLE'=>'Users',
'LBL_NEW_USER'=>'New User',

// Added for 4 GA
'LBL_TOOL_FORM_TITLE'=>'Email Tools',
//Added for 4GA
'Date & Time Sent'=>'Date & Time Sent',
'Sales Enity Module'=>'Sales Enity Module',
'Related To'=>'Related To',
'Assigned To'=>'Assigned To',
'Subject'=>'Subject',
'Attachment'=>'Attachment',
'Description'=>'Description',
'Time Start'=>'Time Start',
'Created Time'=>'Created Time',
'Modified Time'=>'Modified Time',

'MESSAGE_CHECK_MAIL_SERVER_NAME'=>'Please Check the Mail Server Name...',
'MESSAGE_CHECK_MAIL_ID'=>'Please Check the Email Id of "Assigned To" User...',
'MESSAGE_MAIL_HAS_SENT_TO_USERS'=>'Mail has been sent to the following User(s) :',
'MESSAGE_MAIL_HAS_SENT_TO_CONTACTS'=>'Mail has been sent to the following Contact(s) :',
'MESSAGE_MAIL_ID_IS_INCORRECT'=>'Mail Id is incorrect. Please Check this Mail Id...',
'MESSAGE_ADD_USER_OR_CONTACT'=>'Please Add any User(s) or Contact(s)...',
'MESSAGE_MAIL_SENT_SUCCESSFULLY'=>' Mail(s) sent successfully!',

// Added for web mail post 4.0.1 release
'LBL_FETCH_WEBMAIL'=>'Fetch Web Mail',
//Added for 4.2 Release -- CustomView
'LBL_ALL'=>'All',
'MESSAGE_CONTACT_NOT_WANT_MAIL'=>'This Contact does not want to receive mails.',
'LBL_WEBMAILS_TITLE'=>'WebMails',
'LBL_EMAILS_TITLE'=>'Email',
'LBL_MAIL_CONNECT_ERROR_INFO'=>'Error connecting mail server!<br> Check in My Accounts->List Mail Server -> List Mail Account',
'LBL_ALLMAILS'=>'All Mails',
'LBL_TO_USERS'=>'To Users',
'LBL_TO'=>'To:',
'LBL_IN_SUBJECT'=>'in Subject',
'LBL_IN_SENDER'=>'in Sender',
'LBL_IN_SUBJECT_OR_SENDER'=>'in Subject or Sender',
'SELECT_EMAIL'=>'Select Email IDs',
'Sender'=>'Sender',
'LBL_CONFIGURE_MAIL_SETTINGS'=>'Your Incoming Mail Server is not configured',
'LBL_MAILSELECT_INFO1'=>'The following Email ID types are associated to the selected',
'LBL_MAILSELECT_INFO2'=>'Select the Email ID types to which,the email should be sent',
'LBL_MULTIPLE'=>'Multiple',
'LBL_COMPOSE_EMAIL'=>'Compose E-Mail',
'LBL_VTIGER_EMAIL_CLIENT'=>'vtiger Webmail Client',

//Added for 5.0.3
'TITLE_VTIGERCRM_MAIL'=>'vtigerCRM Mail',
'TITLE_COMPOSE_MAIL'=>'Compose Mail',

'MESSAGE_MAIL_COULD_NOT_BE_SEND'=>'Mail could not be sent to the assigned to user.',
'MESSAGE_PLEASE_CHECK_ASSIGNED_USER_EMAILID'=>'Please check the assigned to user email id...',
'MESSAGE_PLEASE_CHECK_THE_FROM_MAILID'=>'Please check the from email id',
'MESSAGE_MAIL_COULD_NOT_BE_SEND_TO_THIS_EMAILID'=>'Mail could not be sent to this email id',
'PLEASE_CHECK_THIS_EMAILID'=>'Please check this mail id...',
'LBL_CC_EMAIL_ERROR'=>'Your cc mailid is not proper',
'LBL_BCC_EMAIL_ERROR'=>'Your bcc mailid is not proper',
'LBL_NO_RCPTS_EMAIL_ERROR'=>'No recepients specified',
'LBL_CONF_MAILSERVER_ERROR'=>'Please configure your outgoing mailserver under Settings ---> Outgoing Server link',
'LBL_VTIGER_EMAIL_CLIENT'=>'vtiger Webmail Client',
'LBL_MAILSELECT_INFO3'=>'You don\'t have permission to view email id(s) of the selected Record(s).',
//Added  for script alerts
'FEATURE_AVAILABLE_INFO' => 'This feature is currently only available for Microsoft Internet Explorer 5.5+ users\n\nWait f
or an update!',
'DOWNLOAD_CONFIRAMATION' => 'Do you want to download the file ?',
'LBL_PLEASE_ATTACH' => 'Please give a valid file to attach and try again!',
'LBL_KINDLY_UPLOAD' => 'Please configure <font color="red">upload_tmp_dir</font> variable in php.ini file.',
'LBL_EXCEED_MAX' => 'Sorry, the uploaded file exceeds the maximum filesize limit. Please try a file smaller than ',
'LBL_BYTES' => ' bytes',
'LBL_CHECK_USER_MAILID' => 'Please check the current user mailid.It should be a valid mailid to send Emails',

// Added/Updated for vtiger CRM 5.0.4
'Activity Type'=>'Activity Type',
'LBL_MAILSELECT_INFO'=>'has the following Email IDs associated.Please Select the Email IDs to which,the mail should be sent',
'LBL_NO_RECORDS' => 'No Records Found',
'LBL_PRINT_EMAIL'=> 'Print',

);

?>
