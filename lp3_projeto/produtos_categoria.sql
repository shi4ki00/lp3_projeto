-- Adiciona o relacionamento entre produtos e categorias.
-- Execute depois de criar as tabelas produtos e categorias.
ALTER TABLE `produtos`
ADD COLUMN `categoria_id` int(11) DEFAULT NULL AFTER `valor`,
ADD KEY `idx_produtos_categoria_id` (`categoria_id`),
ADD CONSTRAINT `fk_produtos_categoria`
  FOREIGN KEY (`categoria_id`)
  REFERENCES `categorias` (`id`)
  ON DELETE SET NULL
  ON UPDATE CASCADE;
