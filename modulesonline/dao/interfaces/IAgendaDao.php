<?php
/*
 * Created on 6 mai 08
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 interface IAgendaDao 
{  
    public function addEvent($event);
    public function updateEvent($id);
    public function deleteEvent($ids)
    public function selectEventByAbonne($idabonne); 
    public function findEventById($id);
    public function findEvent($criteria);
    
}  
?>
