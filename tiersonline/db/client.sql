-- phpMyAdmin SQL Dump
-- version 2.9.1.1-Debian-3
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Jeudi 30 Août 2007 à 17:52
-- Version du serveur: 5.0.32
-- Version de PHP: 4.4.4-8+etch4
-- 
-- Base de données: `achatenligne`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `client`
-- 

CREATE TABLE `client` (
  `idclient` int(10) unsigned NOT NULL auto_increment,
  `Questions_idquestions` int(10) unsigned NOT NULL default '0',
  `Adresse_idFacturation` int(10) unsigned NOT NULL default '0',
  `reponseQuestion` varchar(255) default NULL,
  `nomClient` varchar(20) NOT NULL default '',
  `prenomClient` varchar(20) default NULL,
  `civiliteClient` enum('M','Mme','Mlle') default NULL,
  `sujetClient` varchar(255) NOT NULL default '',
  `datenaiss` date default NULL,
  `departNaiss` char(3) NOT NULL default '',
  `societe` varchar(25) default NULL,
  `EMAIL` varchar(25) default NULL,
  `IdSoucripteur` int(10) NOT NULL default '0',
  `TELEPHONE` varchar(20) default NULL,
  `TELEPHONE_PORTABLE_1` varchar(20) default NULL,
  `TELEPHONE_PORTABLE_2` varchar(20) default NULL,
  `TELEPHONE_PROFESSIONNEL` varchar(20) default NULL,
  `tmk` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`idclient`),
  KEY `client_FKIndex2` (`Adresse_idFacturation`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Contenu de la table `client`
-- 

INSERT INTO `client` (`idclient`, `Questions_idquestions`, `Adresse_idFacturation`, `reponseQuestion`, `nomClient`, `prenomClient`, `civiliteClient`, `sujetClient`, `datenaiss`, `departNaiss`, `societe`, `EMAIL`, `IdSoucripteur`, `TELEPHONE`, `TELEPHONE_PORTABLE_1`, `TELEPHONE_PORTABLE_2`, `TELEPHONE_PROFESSIONNEL`, `tmk`) VALUES 
(1, 1, 142, 'dsfdf', 'KOLO', 'LOM', 'Mme', '', '1923-04-03', '03', NULL, 'emaillo@test.de', 1, '0999999999', '', '', '', 0);
