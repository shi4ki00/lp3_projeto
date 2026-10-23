DROP TABLE IF EXISTS `filmes`;
CREATE TABLE `filmes` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `filme` varchar(200) NOT NULL,
  `diretor` varchar(200) NOT NULL,
  `duracao` int(11) DEFAULT NULL,
  `imagem` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
