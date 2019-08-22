-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 22-Ago-2019 às 23:33
-- Versão do servidor: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `realtec`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `insumo`
--

CREATE TABLE `insumo` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `unidade_medida` varchar(5) NOT NULL,
  `valor_minimo` decimal(10,2) DEFAULT NULL,
  `estoque` decimal(10,2) DEFAULT NULL,
  `valor_medio` decimal(10,2) DEFAULT NULL,
  `observacao` text,
  `ativo` char(1) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `data_atualizacao` datetime DEFAULT NULL,
  `data_remocao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `insumo`
--

INSERT INTO `insumo` (`id`, `nome`, `codigo`, `unidade_medida`, `valor_minimo`, `estoque`, `valor_medio`, `observacao`, `ativo`, `data_cadastro`, `data_atualizacao`, `data_remocao`) VALUES
(1, 'CLORO', '0001', 'L', '20.00', NULL, NULL, NULL, '0', '2019-08-22 15:52:08', NULL, '2019-08-22 23:25:26'),
(2, 'Whey\'s', '0002', 'KG', '200.00', NULL, NULL, 'Teste', '1', '2019-08-22 22:59:38', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `insumo`
--
ALTER TABLE `insumo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `insumo`
--
ALTER TABLE `insumo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
