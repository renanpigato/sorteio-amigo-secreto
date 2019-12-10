
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- amigo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `amigo`;

CREATE TABLE `amigo`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(100) NOT NULL,
    `telefone` VARCHAR(11) NOT NULL,
    UNIQUE INDEX `id` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- sorteio
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sorteio`;

CREATE TABLE `sorteio`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE INDEX `id` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- sorteio_amigo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sorteio_amigo`;

CREATE TABLE `sorteio_amigo`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `amigo` BIGINT NOT NULL,
    `sorteio` BIGINT NOT NULL,
    UNIQUE INDEX `id` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
