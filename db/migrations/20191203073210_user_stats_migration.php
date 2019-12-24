<?php

use Phinx\Migration\AbstractMigration;

class UserStatsMigration extends AbstractMigration
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
        $this->execute("CREATE TABLE IF NOT EXISTS `user_stats` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) DEFAULT '0',
          `check_in` datetime NOT NULL,
          `check_out` datetime NOT NULL,
          `last_opened` datetime NOT NULL,
          `last_updated` datetime NOT NULL,
          PRIMARY KEY (`id`),
          KEY `user_stats_ibfk_1` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    }
    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS `user_stats`");
    }
}
