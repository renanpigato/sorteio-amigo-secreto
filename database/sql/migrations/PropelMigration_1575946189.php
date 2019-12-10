<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1575946189.
 * Generated on 2019-12-10 02:49:49 by root
 */
class PropelMigration_1575946189
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
        return array ('default' => "
            INSERT INTO actions (name, needed_class, is_ajax, base_template, include_page) values
                ('visualizar',            'Visualizar',  false,       null,     'visualizar.php'   )
        ");
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array ('default' => '
            DELETE FROM actions WHERE name ILIKE \'visualizar\'
        ');
    }

}