-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19-Maio-2023 às 01:36
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `pastelaria`
--
CREATE DATABASE IF NOT EXISTS `pastelaria` DEFAULT CHARACTER SET utf8 COLLATE utf8_swedish_ci;
USE `pastelaria`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tab_comanda`
--

CREATE TABLE `tab_comanda` (
  `id` int(10) NOT NULL,
  `nome` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data` datetime NOT NULL,
  `status` int(1) NOT NULL,
  `pronta` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Extraindo dados da tabela `tab_comanda`
--

INSERT INTO `tab_comanda` (`id`, `nome`, `valor`, `data`, `status`, `pronta`) VALUES
(47, 'Comanda#1', '27.00', '2023-05-19 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tab_itens`
--

CREATE TABLE `tab_itens` (
  `id` int(10) NOT NULL,
  `id_comanda` int(10) NOT NULL,
  `id_produto` int(10) NOT NULL,
  `qtde` int(10) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Extraindo dados da tabela `tab_itens`
--

INSERT INTO `tab_itens` (`id`, `id_comanda`, `id_produto`, `qtde`, `subtotal`) VALUES
(172, 47, 15, 1, '9.00'),
(173, 47, 16, 1, '9.00'),
(174, 47, 17, 1, '9.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tab_produtos`
--

CREATE TABLE `tab_produtos` (
  `id` int(11) NOT NULL,
  `produto` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `quant` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `tipo` int(1) NOT NULL,
  `disponivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Extraindo dados da tabela `tab_produtos`
--

INSERT INTO `tab_produtos` (`id`, `produto`, `quant`, `valor`, `tipo`, `disponivel`) VALUES
(15, 'Pastel de carne', 99, '9.00', 0, 1),
(16, 'Pastel de queijo', 99, '9.00', 0, 1),
(17, 'Pastel de carne com queijo', 99, '9.00', 0, 1),
(18, 'Pastel de carne com ovo', 100, '9.00', 0, 1),
(19, 'Pastel misto', 100, '9.00', 0, 1),
(20, 'Pastel bauru', 100, '9.00', 0, 0),
(21, 'Pastel de pizza', 100, '9.00', 0, 1),
(22, 'Pastel de frango com catupiry', 100, '9.00', 0, 1),
(23, 'Pastel de frango com cheddar', 100, '9.00', 0, 1),
(24, 'Pastel de palmito com queijo', 100, '9.00', 0, 1),
(25, 'Pastel de calabresa com queijo', 100, '9.00', 0, 1),
(26, 'Pastel de carne seca com queijo', 100, '9.00', 0, 1),
(27, 'Pastel de carne com cheddar', 100, '9.00', 0, 1),
(28, 'Pastel de carne com bacon', 100, '9.00', 0, 1),
(29, 'Pastel de camarao com catupiry', 100, '9.00', 0, 1),
(30, 'Pastel de escarola com queijo', 100, '9.00', 0, 1),
(31, 'Pastel 4 queijos', 100, '9.00', 0, 1),
(32, 'Pastel portuguesa', 100, '9.00', 0, 1),
(33, 'Pastel de atum com queijo', 100, '9.00', 0, 1),
(34, 'Pastel de salame com queijo', 100, '9.00', 0, 1),
(35, 'Pastel de nutella', 100, '9.00', 0, 1),
(36, 'Especial de carne', 100, '20.00', 1, 1),
(37, 'Especial de frango', 100, '20.00', 1, 1),
(38, 'Especial de calabresa', 100, '20.00', 1, 1),
(39, 'Especial misto', 100, '20.00', 1, 1),
(50, 'Coca-cola 600ml', 999, '6.00', 2, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tab_comanda`
--
ALTER TABLE `tab_comanda`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tab_itens`
--
ALTER TABLE `tab_itens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_comanda` (`id_comanda`) USING BTREE,
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices para tabela `tab_produtos`
--
ALTER TABLE `tab_produtos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tab_comanda`
--
ALTER TABLE `tab_comanda`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de tabela `tab_itens`
--
ALTER TABLE `tab_itens`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT de tabela `tab_produtos`
--
ALTER TABLE `tab_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
