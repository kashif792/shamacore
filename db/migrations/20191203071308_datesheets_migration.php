<?php

use Phinx\Migration\AbstractMigration;

class DatesheetsMigration extends AbstractMigration
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
        $this->execute("CREATE TABLE IF NOT EXISTS `datesheets` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `school_id` int(11) DEFAULT NULL,
          `session_id` int(11) NOT NULL,
          `semester_id` int(11) DEFAULT NULL,
          `class_id` int(11) DEFAULT NULL,
          `exam_type` enum('Mid','Final') NOT NULL,
          `start_date` date DEFAULT NULL,
          `end_date` date DEFAULT NULL,
          `notes` text,
          `start_time` time DEFAULT NULL,
          `end_time` time DEFAULT NULL,
          `created_at` datetime DEFAULT NULL,
          `updated_at` datetime DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `school_id` (`school_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    }
    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS `datesheets`");
    }
}
