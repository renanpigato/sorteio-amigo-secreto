<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1575589293.
 * Generated on 2019-12-05 23:41:33 by root
 */
class PropelMigration_1575589293
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
                INSERT INTO amigo (nome, telefone) VALUES 
                     ('Renan'   , '51992351365')
                    ,('Catiuci' , '51985651542')
                    ,('Pedro'   , '51997726171')
                    ,('Renata'  , '51997726172')
                    ,('Jana'    , '51981225571')
                    ,('Tiao'    , '51998512151')
                    ,('Felipe'  , '51999764356')
                    ,('Diane'   , '51989282777')
                ;

                UPDATE amigo SET senha = '52c3efac08fc2ba1b436c3bfccd23a03' WHERE id = 1;
                UPDATE amigo SET senha = 'd971185137d693f7277adf25cab6b317' WHERE id = 2;
                UPDATE amigo SET senha = '44320635db4c7327076cd45181e9c545' WHERE id = 3;
                UPDATE amigo SET senha = '5f5b12fbf17b19eeee785251ee4837ec' WHERE id = 4;
                UPDATE amigo SET senha = '4c88f5bb790562ef9dac875cf42f7653' WHERE id = 5;
                UPDATE amigo SET senha = 'dbb4a93969a213c98e9b22de24f5ff99' WHERE id = 6;
                UPDATE amigo SET senha = '564c6621540a870359542edf38ddda5a' WHERE id = 7;
                UPDATE amigo SET senha = 'a086ab04392f0a36afca6cdd1316b2d1' WHERE id = 8;
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
            'default' => 'DELETE FROM amigo',
        );
    }

}