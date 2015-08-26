-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 22, 2010 at 07:47 AM
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
-- Table structure for table `mesAlternativa`
--

CREATE TABLE IF NOT EXISTS `mesAlternativa` (
  `Codigo` int(10) unsigned NOT NULL auto_increment COMMENT 'Código da alternativa',
  `Grupo` varchar(200) NOT NULL COMMENT 'Grupo das alternativas',
  `Alternativa` varchar(500) NOT NULL COMMENT 'Alternativa propriamente dita',
  PRIMARY KEY  (`Codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Alternativas de resposta' AUTO_INCREMENT=10 ;

--
-- Dumping data for table `mesAlternativa`
--

INSERT INTO `mesAlternativa` (`Codigo`, `Grupo`, `Alternativa`) VALUES
(1, 'simnao', 'Sim'),
(2, 'simnao', 'Não'),
(3, 'bma', 'Baixa'),
(4, 'bma', 'Média'),
(5, 'bma', 'Alta'),
(6, 'relevancia', 'Irrelevante'),
(7, 'relevancia', 'Pouco relevante'),
(8, 'relevancia', 'Relevante'),
(9, 'relevancia', 'Muito relevante');
