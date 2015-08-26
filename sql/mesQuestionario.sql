-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 22, 2010 at 07:48 AM
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
-- Table structure for table `mesQuestionario`
--

CREATE TABLE IF NOT EXISTS `mesQuestionario` (
  `Codigo` int(10) unsigned NOT NULL COMMENT 'Código do questionario',
  `Descricao` varchar(500) NOT NULL COMMENT 'Descrição do questionario',
  `DtCadastro` date NOT NULL COMMENT 'Data de cadastro',
  PRIMARY KEY  (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Questionarios';

--
-- Dumping data for table `mesQuestionario`
--

