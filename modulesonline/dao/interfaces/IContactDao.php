<?php
/*
 * Created on 6 mai 08
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 interface IContactDao 
{  
   // public function addContact($contact);
   // public function updateContact($id);
    public function updateChampContact($id,$champ,$valeur);
    public function deleteContact($ids);
   // public function moveContact($ids);
    public function selectContactByAbonne($idabonne); 
    public function selectContactByCategorie($idabonne,$catid); 
    public function selectCategorieByAbonne($idabonne); 
    public function findContactById($id);
    public function findContact($criteria);
    public function addCategorie($categorie,$numeroclient);
    //public function deleteCategorie($categorie,$numeroclient);

}  
?>
