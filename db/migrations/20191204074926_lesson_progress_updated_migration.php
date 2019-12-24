<?php

use Phinx\Migration\AbstractMigration;

class LessonProgressUpdatedMigration extends AbstractMigration
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
        $this->execute("ALTER TABLE `lesson_progress` ADD `open_count` INT NOT NULL AFTER `count`, ADD `finish_count` INT NOT NULL AFTER `open_count`, ADD `started` DATETIME Not NULL DEFAULT '1970-12-12 10:10:10' AFTER `finish_count`, ADD `finished` DATETIME Default '1970-12-12 10:10:10' AFTER `started`, ADD `duration` INT NOT NULL AFTER `finished`, ADD `total_score` INT NOT NULL AFTER `duration`, ADD `score` INT NOT NULL AFTER `total_score`");
    }
}
