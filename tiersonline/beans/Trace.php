<?php


class Trace extends Exception 
{
  var $fpTrace;
  var $txtNomTrace;
  var $txtNomModule;

  // constructeur
  function __construct($filename)
  {
    $this->txtNomTrace = $filename;
    $this->fpTrace = NULL;
    $this->txtNomModule = $GLOBALS["PHP_SELF"];
  }

  public function __construct($Msg) 
  {
 	parent :: __construct($Msg);
  }

   public function RetourneErreur()
   {
	 $msg = '<div><strong>' . $this->getMessage() . '</strong>';
	 $msg .= ' Ligne : ' . $this->getLine() . '</div>';
	 return $msg;
   } 

  // creation du fichier trace
  // ecriture de l'heure d'ouverture
  // retourne 1 si OK, 0 si KO
  function ouvrir()
  {
    
    $this->fpTrace = fopen($this->txtNomTrace,"a");

    if (!$this->fpTrace)
      return 0;
    else
     return ($this->Enregistre("CTR DEBUT, ".date("d/m/Y").", ".date("H:i:s")."\n"));
  }

  // ecriture de texte dans le fichier trace
  // retourne 1 si OK, 0 si KO
  function enregistre($txtAEcrire)
  {
    if(!$this->fpTrace)
    	return 0;
    	
    if (!fwrite($this->fpTrace,$txtAEcrire))
      return 0;
    else
      return 1;
  }

  // Ecriture d'une ligne d'erreur dans le fichier trace
  //
  // ex : ERR, 27/11/2000, 15:10:50, /paysips/pop3/info.php : mon texte d'erreur
  // Remarque : un CR est ajoute a la fin de chaque ligne.
  //

  function trace_Err($txtAEcrire)
  {
   if(!$this->fpTrace)
    	return 0;
    	
   $strErreur = "ERR, ".date("d/m/Y").", ".date("H:i:s").", ".$this->txtNomModule." : ".$txtAEcrire."\n";
    if (!fwrite($this->fpTrace,$strErreur))
      return 0;
    else
      return 1;
  }

  // Ecriture d'une ligne d'information dans le fichier trace
  //
  // ex : TRA, 27/11/2000, 15:10:50, /paysips/pop3/info.php : mon texte d'info
  // Remarque : un CR est ajoute a la fin de chaque ligne.
  //
  function trace_Info($txtAEcrire)
  {
   if(!$this->fpTrace)
    	return 0;

   $strTrace = "TRA, ".date("d/m/Y").", ".date("H:i:s").", ".$this->txtNomModule." : ".$txtAEcrire."\n";
    if (!fwrite($this->fpTrace,$strTrace))
      return 0;
    else
      return 1;
  }

  // ecriture de l'heure de fermeture puis
  // fermeture du fichier de trace
  // retourne 1 si OK, 0 si KO
  function fermer()
  {
    if ($this->fpTrace)
    {
      if (!$this->Enregistre("CTR FIN, ".date("d/m/Y").", ".date("H:i:s")."\n"))
      	return 0;
      	
      if (fclose($this->fpTrace))
      {
        $this->fpTrace = NULL;
        return 1;
      }
      else
        return 0;
    }
    else
      return 0;
  }
};


 ?>
