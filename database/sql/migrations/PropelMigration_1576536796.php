<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1576536796.
 * Generated on 2019-12-16 22:53:16 by root
 */
class PropelMigration_1576536796
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
            'default' => "
                INSERT INTO amigo (nome, telefone, senha) VALUES 
                     ('Fernando'   , '51985651543', '697d038327ec59656a66c219608e5815')  -- d76dc0e0c
                    ,('Davi'       , '51985651544', 'e2b37d05f072fd1991a591befbb2c96f')  -- 4934de51f
                    ,('Julia'      , '51997726173', '5561507a9c18f7252da7a50d00476cbd')  -- 6356876d4
                    ,('Miguel'     , '51981225572', 'e928ddcb0f90a98935986cff9959c2ab')  -- 31535e3ac
                    ,('Caetano'    , '51981225573', '001bddb234365a05e5ae804bd13eb9e5')  -- 0940e5128
                    ,('Felipinho'  , '51989282778', '2115181c743dc83e3798099c46897caa')  -- c07c54c96
                    ,('Luisa'      , '51989282779', 'b126627b7de4d95071c64ca2e24a9616')  -- 82b87c8bf
                    ,('Lucas'      , '51989282780', 'ddb2d746a8ca84f875ab85d2fa7eadcb')  -- b67bb6bf9
                ;
            ",
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
            'default' => "
                DELETE FROM amigo WHERE nome ilike 'Fernando';
                DELETE FROM amigo WHERE nome ilike 'Davi';
                DELETE FROM amigo WHERE nome ilike 'Julia';
                DELETE FROM amigo WHERE nome ilike 'Miguel';
                DELETE FROM amigo WHERE nome ilike 'Caetano';
                DELETE FROM amigo WHERE nome ilike 'Felipinho';
                DELETE FROM amigo WHERE nome ilike 'Luisa' ;
                DELETE FROM amigo WHERE nome ilike 'Lucas';
                );
        ");
    }

}