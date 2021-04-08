<?php
/*
 * Created on 6 mai 08
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 interface IMessageDao 
{  
    //public function updateMessage($id);
    public function updateChampMessage($id,$champ,$valeur);
    public function deleteMessage($ids);
    //public function moveMessage($ids,$folderid);
    public function selectMessageByAbonne($idabonne);
    public function selectMessageDAyByAbonne($idabonne); 
    public function selectMessageByForder($idabonne,$folderid); 
    public function selectFolderByAbonne($numeroclient,$messages); 
    public function findMessageById($idmessage);
    public function findMessage($criteria);
    
}  
?>
