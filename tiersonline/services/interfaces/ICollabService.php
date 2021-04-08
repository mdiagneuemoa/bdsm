<?php
/*
 * Created on 6 mai 08
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 interface ICollaborateurService 
{  
    public function ajout($collab);  
    public function update($id);
    public function delete($id);
    public function selectAll(); 
    public function findCollabById($id);
    
}  
?>
