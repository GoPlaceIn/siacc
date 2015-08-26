-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 22, 2010 at 07:42 AM
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
-- Table structure for table `mesPergunta`
--

CREATE TABLE IF NOT EXISTS `mesPergunta` (
  `Codigo` int(10) unsigned NOT NULL auto_increment COMMENT 'Código da pergunta',
  `Descricao` varchar(2000) NOT NULL COMMENT 'Descrição da pergunta',
  PRIMARY KEY  (`Codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabela que guardará as perguntas dos questionários' AUTO_INCREMENT=30 ;

--
-- Dumping data for table `mesPergunta`
--

INSERT INTO `mesPergunta` (`Codigo`, `Descricao`) VALUES
(1, 'Descrição da primeira pergunta'),
(2, 'Segunda pergunta cadastrada'),
(3, 'Mais uma'),
(4, 'Já tem 4 perguntas'),
(5, 'Testando os ácêntos e o Cçdilha'),
(6, 'Falta pouco'),
(7, 'Sétima pergunta'),
(8, '8ª pergunta cadastrada no sistema'),
(9, 'Agora uma pergunta com uma descrição bem longa'),
(10, 'Pergunta número 10'),
(11, 'Agora tem que quebrar'),
(20, 'Mais uma pergunta'),
(21, 'O paginador funciona também'),
(22, 'Vou cadastrar mais uma'),
(23, 'E outra'),
(24, 'Com essa são 16'),
(25, 'A 17 agora'),
(26, 'Falta pouquinho agora'),
(27, 'Só mais duas'),
(28, 'A vigesima pergunta agora'),
(29, 'Agora vem a pergunta número 21');
