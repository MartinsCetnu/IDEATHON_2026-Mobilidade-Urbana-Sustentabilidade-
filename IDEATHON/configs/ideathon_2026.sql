-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05/11/2026 às 13:50
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ideathon_2026`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `passeios`
--

CREATE TABLE `passeios` (
  `passeio_id` int(11) NOT NULL,
  `passeio_titulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `passeio_descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `passeio_imagem` varchar(255) DEFAULT NULL,
  `passeio_locini` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `passeio_locfim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `passeio_data` date NOT NULL,
  `passeio_hora` time NOT NULL,
  `passeio_distancia` decimal(10,0) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `passeios`
--

INSERT INTO `passeios` (`passeio_id`, `passeio_titulo`, `passeio_descricao`, `passeio_imagem`, `passeio_locini`, `passeio_locfim`, `passeio_data`, `passeio_hora`, `passeio_distancia`) VALUES
(1, 'Pedalada Noturna da Cidade', 'Percurso leve passando pelos principais pontos urbanos, ideal para iniciantes.', 'https://thumbs.dreamstime.com/b/um-menino-novo-em-uma-cena-de-um-inc%C3%AAndio-10027468.jpg', 'Praça 500 anos', 'Praça 500 anos', '2026-11-10', '19:30:00', 16);

-- --------------------------------------------------------

--
-- Estrutura para tabela `passeio_interesses`
--

CREATE TABLE `passeio_interesses` (
  `pasint_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `passeio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `passeio_interesses`
--

INSERT INTO `passeio_interesses` (`pasint_id`, `usuario_id`, `passeio_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL,
  `usuario_nome` varchar(50) NOT NULL,
  `usuario_senha` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `usuario_nome`, `usuario_senha`) VALUES
(1, 'Roberto', '123');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `passeios`
--
ALTER TABLE `passeios`
  ADD PRIMARY KEY (`passeio_id`);

--
-- Índices de tabela `passeio_interesses`
--
ALTER TABLE `passeio_interesses`
  ADD PRIMARY KEY (`pasint_id`),
  ADD UNIQUE KEY `participacao_unica` (`usuario_id`,`passeio_id`),
  ADD KEY `fk_passeio` (`passeio_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `passeios`
--
ALTER TABLE `passeios`
  MODIFY `passeio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `passeio_interesses`
--
ALTER TABLE `passeio_interesses`
  MODIFY `pasint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `passeio_interesses`
--
ALTER TABLE `passeio_interesses`
  ADD CONSTRAINT `fk_passeio` FOREIGN KEY (`passeio_id`) REFERENCES `passeios` (`passeio_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
