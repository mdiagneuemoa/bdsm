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

REM ******Debut  Remplissage donnees rapports ******

set MYSQL_EXE="C:\wamp\mysql\bin\mysql"
set IP_SERVEUR="10.11.2.198"

%MYSQL_EXE% -h %IP_SERVEUR% -u gidpcci  -pgidpcci gidpcci -e"CALL rapport_quotidien_campagne ()"
%MYSQL_EXE% -h %IP_SERVEUR% -u gidpcci  -pgidpcci gidpcci -e"CALL rapport_quotidien_type ()"
%MYSQL_EXE% -h %IP_SERVEUR% -u gidpcci  -pgidpcci gidpcci -e"CALL rapport_quotidien_groupe ()"

REM ******Fin  Remplissage donnees rapports ******


