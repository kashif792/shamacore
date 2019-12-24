<?php

use Phinx\Migration\AbstractMigration;

class DetailDatesheetMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->execute("CREATE TABLE IF NOT EXISTS `datesheet_details` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `datesheet_id` int(11) DEFAULT NULL,
          `subject_id` int(11) DEFAULT NULL,
          `exam_date` date DEFAULT NULL,
          `start_time` time DEFAULT NULL,
          `end_time` time DEFAULT NULL,
          `created_at` datetime DEFAULT NULL,
          `updated_at` datetime DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `datesheet_id` (`datesheet_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    }
    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS `datesheet_details`");
    }
}
