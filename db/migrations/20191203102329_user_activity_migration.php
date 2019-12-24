<?php

use Phinx\Migration\AbstractMigration;

class UserActivityMigration extends AbstractMigration
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
        $this->execute("CREATE TABLE IF NOT EXISTS `user_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `started` datetime NOT NULL,
  `finished` datetime NOT NULL,
  `duration` int(11) NOT NULL DEFAULT '0',
  `man` varchar(32) DEFAULT '',
  `model` varchar(32) DEFAULT '',
  `platform` varchar(16) DEFAULT '' COMMENT 'chrome, android, ios, windows, etc',
  `app_type` enum('web','mobile','desktop') NOT NULL DEFAULT 'web',
  `version` varchar(16) DEFAULT '',
  `unique_code` varchar(16) NOT NULL,
  `last_updated` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    }
}
