<?php
/*
 * Created on 6 mai 08
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 interface ICollaborateurDao 
{  
    public function ajouter($collab);  
    public function update($id);
    public function updateChamp($id,$champ,$valeur);
    public function delete($id);
    public function selectAll(); 
    public function findCollabById($id);
    public function findCollab($criteria);
    
}  
?>
