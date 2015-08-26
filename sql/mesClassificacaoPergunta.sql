-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 22, 2010 at 07:46 AM
-- Server version: 5.0.91
-- PHP Version: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `graebinn_regisls`
--

-- --------------------------------------------------------

--
-- Table structure for table `mesClassificacaoPergunta`
--

CREATE TABLE IF NOT EXISTS `mesClassificacaoPergunta` (
  `Codigo` int(10) unsigned NOT NULL auto_increment COMMENT 'Código da classificação',
  `Descricao` varchar(200) NOT NULL COMMENT 'Descrição concisa',
  `TextoDescritivo` varchar(500) default NULL COMMENT 'Descrição mais detalhada',
  PRIMARY KEY  (`Codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabela com a classificação das questões' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mesClassificacaoPergunta`
--

INSERT INTO `mesClassificacaoPergunta` (`Codigo`, `Descricao`, `TextoDescritivo`) VALUES
(1, 'TextoEsquisito', 'Texto explicativo do que é o nome esquesito'),
(2, 'SaoQuatro', 'Esta é a segunda'),
(3, 'SaoQuatro', 'Esta é a segunda'),
(4, 'MaisUma', 'Quarto texto explicativo da categoria de exercícios');
