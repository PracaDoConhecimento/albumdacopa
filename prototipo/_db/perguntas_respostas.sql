-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Tempo de geração: 23/05/2014 às 19:05
-- Versão do servidor: 5.6.17
-- Versão do PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `albumdacopa`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `perguntas_respostas`
--

CREATE TABLE IF NOT EXISTS `perguntas_respostas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pergunta` varchar(300) NOT NULL,
  `respostas` varchar(400) NOT NULL,
  `resposta_certa` int(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Fazendo dump de dados para tabela `perguntas_respostas`
--

INSERT INTO `perguntas_respostas` (`id`, `pergunta`, `respostas`, `resposta_certa`) VALUES
(3, 'QUe Ã© o prim,', 'a:4:{i:0;s:6:"123sad";i:1;s:9:"sdfdsfsdg";i:2;s:9:"dsfdgdrfh";i:3;s:7:"sfsdggh";}', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
