<?php

use Phinx\Migration\AbstractMigration;

class ScheduleMigration extends AbstractMigration
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
        $this->execute("DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `last_update` datetime NOT NULL,
  `class_id` int(11) UNSIGNED NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_uid` int(11) UNSIGNED NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `mon_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `mon_start_time` time NOT NULL,
  `mon_end_time` time NOT NULL,
  `tue_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `tue_start_time` time NOT NULL,
  `tue_end_time` time NOT NULL,
  `wed_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `wed_start_time` time NOT NULL,
  `wed_end_time` time NOT NULL,
  `thu_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `thu_start_time` time NOT NULL,
  `thu_end_time` time NOT NULL,
  `fri_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `fri_start_time` time NOT NULL,
  `fri_end_time` time NOT NULL,
  `sat_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `sat_start_time` time NOT NULL,
  `sat_end_time` time NOT NULL,
  `sun_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `sun_start_time` time NOT NULL,
  `sun_end_time` time NOT NULL,
  `semester_id` int(11) DEFAULT NULL,
  `session_id` int(11) NOT NULL,
  `locationid` int(11) DEFAULT NULL,
  `uniquecode` varchar(50) DEFAULT NULL,
  `is_release` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`),
  KEY `section_id` (`section_id`),
  KEY `subject_id` (`subject_id`),
  KEY `section_id_2` (`section_id`),
  KEY `subject_id_2` (`subject_id`),
  KEY `teacher_uid` (`teacher_uid`),
  KEY `semsterid` (`semester_id`),
  KEY `sessionid` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    }
    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS `schedule`");
    }
}
