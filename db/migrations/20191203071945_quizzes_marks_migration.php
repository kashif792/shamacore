<?php

use Phinx\Migration\AbstractMigration;

class QuizzesMarksMigration extends AbstractMigration
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
        $this->execute("CREATE TABLE IF NOT EXISTS `quizzes_marks` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `school_id` int(11) NOT NULL,
          `student_id` int(11) NOT NULL,
          `semester_id` int(11) NOT NULL,
          `class_id` int(11) NOT NULL,
          `section_id` int(11) NOT NULL,
          `session_id` int(11) DEFAULT NULL,
          `subject_id` int(11) NOT NULL,
          `quiz_id` int(11) NOT NULL,
          `marks` int(11) NOT NULL,
          `created_at` datetime NOT NULL,
          PRIMARY KEY (`id`),
          KEY `school_id` (`school_id`),
          KEY `student_id` (`student_id`) USING BTREE,
          KEY `class_id` (`class_id`) USING BTREE,
          KEY `semester_id` (`semester_id`) USING BTREE,
          KEY `section_id` (`section_id`) USING BTREE,
          KEY `session_id` (`session_id`) USING BTREE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    }
    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS `quizzes_marks`");
    }
}
