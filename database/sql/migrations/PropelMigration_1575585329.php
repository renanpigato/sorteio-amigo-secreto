<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1575585329.
 * Generated on 2019-12-05 22:35:29 by root
 */
class PropelMigration_1575585329
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE `actions`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `needed_class` VARCHAR(50),
    `archive` VARCHAR(50),
    `need_ssl` TINYINT(1) DEFAULT 1 NOT NULL,
    `need_login` TINYINT(1) DEFAULT 1 NOT NULL,
    `is_ajax` TINYINT(1) DEFAULT 0 NOT NULL,
    `menu` VARCHAR(50),
    `base_template` VARCHAR(50),
    `include_page` VARCHAR(50) NOT NULL,
    `error_template` VARCHAR(50),
    `error` VARCHAR(50),
    `success_redirect` VARCHAR(50),
    `permission` VARCHAR(50) DEFAULT \'ALL\' NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `actions_name_un_in` (`name`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `actions`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}