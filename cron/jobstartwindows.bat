REM  **************************************************************************************
REM  * The contents of this file are subject to the vtiger CRM Public License Version 1.0 *
REM  * ("License"); You may not use this file except in compliance with the License       *
REM  * The Original Code is:  vtiger CRM Open Source                                      *
REM  * The Initial Developer of the Original Code is vtiger.                              *
REM  * Portions created by vtiger are Copyright (C) vtiger.                               *
REM  * All Rights Reserved.                                                               *
REM  *                                                                                    *
REM  **************************************************************************************  
@echo off
set SCH_INSTALL=%1
FOR %%X in (%SCH_INSTALL%) DO SET SCH_INSTALL=%%~sX
REM  * schtasks /create /tn "vtigerCRM Notification Scheduler" /tr %SCH_INSTALL%\apache\htdocs\vtigerCRM\cron\intimateTaskStatus.bat /sc daily /st 11:00:00 /RU SYSTEM  *
REM  * schtasks /create /tn "vtigerCRM Email Reminder" /tr %SCH_INSTALL%\apache\htdocs\vtigerCRM\modules\Calendar\SendReminder.bat /sc minute /mo 1 /RU SYSTEM			*


cd $VTIGERCRM_ROOTDIR
schtasks /create /tn "Daily Notification Scheduler" /tr C:\wamp\www\gidPCCI\DailyNotificationCron.bat /sc daily /st 20:00:00 /RU SYSTEM