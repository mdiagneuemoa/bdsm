@echo off
REM  **************************************************************************************
REM  * The contents of this file are subject to the vtiger CRM Public License Version 1.0 *
REM  * ("License"); You may not use this file except in compliance with the License       *
REM  * The Original Code is:  vtiger CRM Open Source                                      *
REM  * The Initial Developer of the Original Code is vtiger.                              *
REM  * Portions created by vtiger are Copyright (C) vtiger.                               *
REM  * All Rights Reserved.                                                               *
REM  *                                                                                    *
REM  **************************************************************************************  


REM ****** Debut Envoi du rapport hebdomadaire ******

set VTIGERCRM_ROOTDIR="C:\wamp\www\gidPCCI"
set PHP_EXE="C:\wamp\php\php.exe"

cd $VTIGERCRM_ROOTDIR

%PHP_EXE% %VTIGERCRM_ROOTDIR%\WeeklyNotification.php

REM ****** Fin Envoi du rapport hebdomadaire ******
