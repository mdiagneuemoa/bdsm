<?php
/*
 * Created on 6 mai 08
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 interface IParametrageDao 
{  
    public function selectInfosAbonne($idabonne,$infos);
    public function updateAgenda($idabonne,$infos);
    public function updateConsignes($idabonne,$infos);
    
}  
?>
