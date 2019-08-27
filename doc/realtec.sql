-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 27-Ago-2019 às 19:37
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
-- Estrutura da tabela `fabricacao`
--

CREATE TABLE `fabricacao` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` decimal(10,2) NOT NULL,
  `codigo` varchar(100) NOT NULL,
  `observacao` text,
  `ativo` char(1) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `data_remocao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fabricacao_formula`
--

CREATE TABLE `fabricacao_formula` (
  `id` int(11) NOT NULL,
  `quantidade` decimal(10,2) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `insumo_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `fabricacao_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `insumo_entrada`
--

CREATE TABLE `insumo_entrada` (
  `id` int(11) NOT NULL,
  `data_entrada` datetime NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `quantidade` decimal(10,2) NOT NULL,
  `ativo` char(1) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `data_atualizacao` datetime DEFAULT NULL,
  `data_remocao` datetime DEFAULT NULL,
  `insumo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `descricao` text NOT NULL,
  `ativo` char(1) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `data_atualizacao` datetime DEFAULT NULL,
  `data_remocao` datetime DEFAULT NULL,
  `unidade_medida` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_formula`
--

CREATE TABLE `produto_formula` (
  `id` int(11) NOT NULL,
  `quantidade` decimal(10,2) NOT NULL,
  `insumo_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fabricacao`
--
ALTER TABLE `fabricacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fabricacao_produto_fk` (`produto_id`);

--
-- Indexes for table `fabricacao_formula`
--
ALTER TABLE `fabricacao_formula`
  ADD PRIMARY KEY (`id`),
  ADD KEY `insumo_fabricacao_formula` (`insumo_id`),
  ADD KEY `produto_fabricacao_formula` (`produto_id`),
  ADD KEY `fabricacao_formula_fk` (`fabricacao_id`);

--
-- Indexes for table `insumo`
--
ALTER TABLE `insumo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `insumo_entrada`
--
ALTER TABLE `insumo_entrada`
  ADD PRIMARY KEY (`id`),
  ADD KEY `insumo_id_fk` (`insumo_id`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produto_formula`
--
ALTER TABLE `produto_formula`
  ADD PRIMARY KEY (`id`),
  ADD KEY `insumo_id_fk_formula` (`insumo_id`),
  ADD KEY `produto_id_fk_formula` (`produto_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fabricacao`
--
ALTER TABLE `fabricacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fabricacao_formula`
--
ALTER TABLE `fabricacao_formula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insumo`
--
ALTER TABLE `insumo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insumo_entrada`
--
ALTER TABLE `insumo_entrada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produto_formula`
--
ALTER TABLE `produto_formula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `fabricacao`
--
ALTER TABLE `fabricacao`
  ADD CONSTRAINT `fabricacao_produto_fk` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`);

--
-- Limitadores para a tabela `fabricacao_formula`
--
ALTER TABLE `fabricacao_formula`
  ADD CONSTRAINT `fabricacao_formula_fk` FOREIGN KEY (`fabricacao_id`) REFERENCES `fabricacao` (`id`),
  ADD CONSTRAINT `insumo_fabricacao_formula` FOREIGN KEY (`insumo_id`) REFERENCES `insumo` (`id`),
  ADD CONSTRAINT `produto_fabricacao_formula` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`);

--
-- Limitadores para a tabela `insumo_entrada`
--
ALTER TABLE `insumo_entrada`
  ADD CONSTRAINT `insumo_id_fk` FOREIGN KEY (`insumo_id`) REFERENCES `insumo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `produto_formula`
--
ALTER TABLE `produto_formula`
  ADD CONSTRAINT `insumo_id_fk_formula` FOREIGN KEY (`insumo_id`) REFERENCES `insumo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `produto_id_fk_formula` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
