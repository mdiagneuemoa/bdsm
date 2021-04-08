<?php
/*
 * Created on 6 mai 08
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 interface ITiersDao 
{  
   // public function addTiers($Tiers);
   // public function updateTiers($id);
    public function updateChampTiers($id,$champ,$valeur);
    public function deleteTiers($ids);
   // public function moveTiers($ids);
   /* public function selectTiersByAbonne($idabonne); 
    public function selectTiersByCategorie($idabonne,$catid); 
    public function selectCategorieByAbonne($idabonne); 
    public function findTiersById($id);
    public function findTiers($criteria);
    public function addCategorie($categorie,$numeroclient);*/
    public function selectTiersByEmail($email);
    public function selectTiersByMatricule($matricule);
    public function verifExistMatricule($matricule);
    public function verifExistIdentFiscale($matricule);
    public function selectTiersByIdentFiscale($identfiscale);
    public function verifExistRaisonSociale($raisonsociale);
    public function selectTiersByRaisonSociale($raisonsociale);
    public function selectAllSecteursActivite();
    public function saveTiers($tiers);
    public function updateTiers($tiers);
    public function saveFournisseurs($tiers);
    public function updateFournisseurs($tiers);
    public function uploadFile($index,$destination,$maxsize=FALSE,$extensions=FALSE,$tiersid,$isupdate);
    public function getNextIdentifiant();
    public function getNextTiersId();


}  
?>
