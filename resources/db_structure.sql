-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2019 at 07:27 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shama_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` text,
  `age_limit` int(11) DEFAULT '5',
  `repeat` int(11) DEFAULT '0',
  `language` varchar(25) DEFAULT NULL,
  `source_type` enum('e','i') NOT NULL DEFAULT 'i',
  `apply_on_slp` enum('y','n') NOT NULL DEFAULT 'n',
  `graded` enum('y','n') NOT NULL DEFAULT 'n',
  `marks` int(11) DEFAULT '0',
  `created` date NOT NULL,
  `edited` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('a','i') NOT NULL DEFAULT 'i',
  `view_date` date DEFAULT NULL,
  `link` varchar(512) NOT NULL,
  `publicslug` varchar(256) NOT NULL,
  `hiddenslug` varchar(256) NOT NULL,
  `points_display_type` enum('percent','complete_incomplete','points','grade','gpa','not_graded') NOT NULL,
  `type` enum('activity','discussion','quiz','assignment','homework','essay','prompt','test','external') NOT NULL DEFAULT 'activity',
  `due_date` date NOT NULL,
  `from_date` date NOT NULL,
  `notify_changes` enum('y','n') NOT NULL DEFAULT 'y',
  `submit_type` enum('none','online','on_paper','external') NOT NULL,
  `attempts` int(11) DEFAULT '0',
  `group_assignment` enum('y','n') NOT NULL DEFAULT 'n',
  `published` enum('y','n') NOT NULL DEFAULT 'n',
  `sol_description` text,
  `sol_updated` date NOT NULL,
  `sol_notify_changes` enum('y','n') NOT NULL DEFAULT 'y',
  `sol_published` enum('y','n') NOT NULL DEFAULT 'n',
  `sol_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `activity_assesments`
--

CREATE TABLE `activity_assesments` (
  `id` int(11) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `activity_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `mark_type` enum('points','checkbox') NOT NULL DEFAULT 'checkbox',
  `question` varchar(256) NOT NULL,
  `marks` varchar(16) NOT NULL,
  `comment` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `activity_assesment_qt`
--

CREATE TABLE `activity_assesment_qt` (
  `id` int(11) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `activity_id` int(11) NOT NULL,
  `question` varchar(256) NOT NULL,
  `mark_type` enum('points','checkbox') NOT NULL DEFAULT 'points'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `activity_class`
--

CREATE TABLE `activity_class` (
  `class_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `activity_files`
--

CREATE TABLE `activity_files` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `link` varchar(256) NOT NULL,
  `type` enum('v','g','i','o','f','q') NOT NULL DEFAULT 'o',
  `file_name` varchar(256) DEFAULT NULL,
  `file_row` int(11) NOT NULL,
  `source` enum('i','e') NOT NULL DEFAULT 'i'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `activity_progress`
--

CREATE TABLE `activity_progress` (
  `student_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `viewed_datetime` datetime NOT NULL,
  `activity_iteration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `activity_section`
--

CREATE TABLE `activity_section` (
  `section_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `activity_semester`
--

CREATE TABLE `activity_semester` (
  `semester_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `activity_student`
--

CREATE TABLE `activity_student` (
  `student_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `activity_subject`
--

CREATE TABLE `activity_subject` (
  `subject_id` int(11) NOT NULL,
  `subject` varchar(256) NOT NULL,
  `activity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `activity_submissions`
--

CREATE TABLE `activity_submissions` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `text` text,
  `submit_date` date NOT NULL,
  `last_submit_date` date NOT NULL,
  `attempts` int(11) DEFAULT '0',
  `comment` varchar(256) NOT NULL,
  `marks` varchar(32) NOT NULL,
  `updated` date NOT NULL,
  `notify_changes` enum('y','n') NOT NULL DEFAULT 'y',
  `graded` enum('y','n') NOT NULL DEFAULT 'n',
  `publicslug` varchar(256) NOT NULL,
  `hiddenslug` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `activity_tag`
--

CREATE TABLE `activity_tag` (
  `remark_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL DEFAULT '',
  `ip_address` varchar(45) NOT NULL DEFAULT '',
  `timestamp` int(10) UNSIGNED DEFAULT '0',
  `data` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `grade` varchar(50) NOT NULL,
  `last_update` datetime DEFAULT NULL,
  `unique_code` varchar(50) DEFAULT NULL,
  `status` enum('a','i') NOT NULL DEFAULT 'a',
  `school_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `class_group`
--

CREATE TABLE `class_group` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `lessonid` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `status` enum('r','u','p') NOT NULL,
  `readed` date NOT NULL,
  `readed_device` enum('w','m') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `edited` datetime NOT NULL,
  `deleted` datetime NOT NULL,
  `status` enum('a','i') COLLATE ucs2_slovak_ci NOT NULL DEFAULT 'a',
  `ip` varchar(56) COLLATE ucs2_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ucs2 COLLATE=ucs2_slovak_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversation_media`
--

CREATE TABLE `conversation_media` (
  `id` bigint(20) NOT NULL,
  `type` enum('e','v','i') NOT NULL,
  `source_link` varchar(256) NOT NULL,
  `thumbnail_link` varchar(256) NOT NULL,
  `created` datetime NOT NULL,
  `status` enum('a','i') NOT NULL,
  `message_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `correct_option`
--

CREATE TABLE `correct_option` (
  `id` int(11) NOT NULL,
  `correct_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `unique_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department` varchar(56) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `id` int(11) NOT NULL,
  `option_value` text NOT NULL,
  `semester_date_id` int(11) NOT NULL,
  `status` enum('a','i') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exam_terms`
--

CREATE TABLE `exam_terms` (
  `id` int(11) NOT NULL,
  `term_name` text NOT NULL,
  `unique_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(256) NOT NULL,
  `slug` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `semester_date_id` int(11) NOT NULL,
  `status` enum('a','i') NOT NULL,
  `option_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `grade_lesson_plan`
--

CREATE TABLE `grade_lesson_plan` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `schoolid` int(11) NOT NULL,
  `created` date DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `concept` text,
  `unique_code` varchar(50) DEFAULT NULL,
  `prereq_type` enum('unit','lesson','exam') DEFAULT NULL,
  `seq` int(11) NOT NULL,
  `prereq_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE `holiday` (
  `id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text,
  `school_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` date NOT NULL,
  `last_edited` date NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `slug` varchar(256) NOT NULL,
  `apply` enum('y','n') NOT NULL DEFAULT 'n',
  `title` varchar(256) NOT NULL,
  `all_day` enum('y','n') NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `holiday_type`
--

CREATE TABLE `holiday_type` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `date` date NOT NULL,
  `slug` varchar(256) NOT NULL,
  `school_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_edited` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `location` varchar(56) NOT NULL,
  `date` date NOT NULL,
  `unique_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `status` enum('a','i') NOT NULL DEFAULT 'a',
  `message` text NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `is_readed` tinyint(1) NOT NULL DEFAULT '0',
  `ip` varchar(56) NOT NULL,
  `type` enum('t','m','f') NOT NULL COMMENT 'text,media,file'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `option_name` varchar(56) NOT NULL,
  `option_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(30) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `qimages`
--

CREATE TABLE `qimages` (
  `id` int(11) NOT NULL,
  `src` int(11) NOT NULL,
  `type` enum('q','o') NOT NULL,
  `selectedid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `qoptions`
--

CREATE TABLE `qoptions` (
  `id` int(11) NOT NULL,
  `option_value` varchar(256) NOT NULL,
  `created` date NOT NULL,
  `edited` date NOT NULL,
  `thumbnail_src` varchar(256) DEFAULT NULL,
  `unique_code` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_evaluation`
--

CREATE TABLE `quiz_evaluation` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `quizid` int(11) NOT NULL,
  `questionid` int(11) NOT NULL,
  `optionid` int(11) NOT NULL,
  `unique_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_result`
--

CREATE TABLE `quiz_result` (
  `id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `q_id` int(11) NOT NULL,
  `created` date DEFAULT NULL,
  `lastmodified` date DEFAULT NULL,
  `section_id` int(11) NOT NULL,
  `unique_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_section`
--

CREATE TABLE `quiz_section` (
  `section_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `readed_message`
--

CREATE TABLE `readed_message` (
  `user_id` int(11) NOT NULL,
  `message_id` bigint(20) NOT NULL,
  `created` datetime NOT NULL,
  `message_read` enum('r','u') NOT NULL DEFAULT 'u'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `remarks_tags`
--

CREATE TABLE `remarks_tags` (
  `id` int(11) NOT NULL,
  `tag` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `row_slug` varchar(11) NOT NULL,
  `role_heading` varchar(20) NOT NULL,
  `departmentid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role_rights`
--

CREATE TABLE `role_rights` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `description` varchar(30) NOT NULL,
  `role_value` varchar(30) NOT NULL,
  `status` enum('a','l') NOT NULL DEFAULT 'a'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) UNSIGNED NOT NULL,
  `last_update` datetime NOT NULL,
  `class_id` int(11) UNSIGNED NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_uid` int(11) UNSIGNED NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `semester_id` int(11) DEFAULT NULL,
  `session_id` int(11) NOT NULL,
  `locationid` int(11) DEFAULT NULL,
  `unique_code` varchar(50) DEFAULT NULL,
  `is_release` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `snumber` varchar(10) DEFAULT NULL,
  `shortname` varchar(4) NOT NULL,
  `cityid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `section_name` varchar(30) NOT NULL,
  `last_update` datetime DEFAULT NULL,
  `unique_code` varchar(50) DEFAULT NULL,
  `school_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` int(11) NOT NULL,
  `semester_name` varchar(20) NOT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `status` enum('a','i') NOT NULL,
  `unique_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `semester_dates`
--

CREATE TABLE `semester_dates` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('a','i') NOT NULL DEFAULT 'i',
  `created` date NOT NULL,
  `last_edited` date NOT NULL,
  `school_id` int(11) NOT NULL,
  `slug` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `semester_lesson_plan`
--

CREATE TABLE `semester_lesson_plan` (
  `id` int(11) NOT NULL,
  `set_id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `class_id` int(11) NOT NULL,
  `content` text,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `topic` text,
  `concept` text,
  `subject_id` int(11) NOT NULL,
  `type` varchar(40) DEFAULT NULL,
  `unique_code` varchar(50) DEFAULT NULL,
  `semester_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `preference` int(11) DEFAULT '0',
  `lesson` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `datefrom` date NOT NULL,
  `dateto` date NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('a','i') NOT NULL,
  `unique_code` varchar(50) DEFAULT NULL,
  `school_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_semesters`
--

CREATE TABLE `student_semesters` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `status` enum('r','u') NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `unique_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(50) NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `class_id` int(11) UNSIGNED NOT NULL,
  `last_update` datetime DEFAULT NULL,
  `subject_image` varchar(256) DEFAULT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tablet_status`
--

CREATE TABLE `tablet_status` (
  `id` int(11) NOT NULL,
  `mac_address` varchar(50) NOT NULL,
  `device_name` varchar(50) NOT NULL,
  `last_student_id` varchar(12) NOT NULL,
  `last_connected` varchar(50) NOT NULL,
  `current_student_id` varchar(12) NOT NULL,
  `school_id` varchar(12) NOT NULL,
  `blocked` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_locations`
--

CREATE TABLE `user_locations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `id` bigint(20) NOT NULL,
  `uid` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `log_detail` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_meta`
--

CREATE TABLE `user_meta` (
  `id` int(11) NOT NULL,
  `meta_key` varchar(256) NOT NULL,
  `meta_value` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `versions`
--

CREATE TABLE `versions` (
  `id` int(11) NOT NULL,
  `version` varchar(10) NOT NULL,
  `app_url` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `status` enum('a','i') NOT NULL DEFAULT 'i',
  `file_name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wizard`
--

CREATE TABLE `wizard` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `edited` datetime NOT NULL,
  `status` enum('y','n') NOT NULL DEFAULT 'y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `activity_assesments`
--
ALTER TABLE `activity_assesments`
  ADD PRIMARY KEY (`id`,`student_id`,`activity_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `activity_assesment_qt`
--
ALTER TABLE `activity_assesment_qt`
  ADD PRIMARY KEY (`id`,`activity_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `activity_class`
--
ALTER TABLE `activity_class`
  ADD PRIMARY KEY (`class_id`,`activity_id`),
  ADD KEY `activity_class_ibfk_1` (`activity_id`);

--
-- Indexes for table `activity_files`
--
ALTER TABLE `activity_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `activity_progress`
--
ALTER TABLE `activity_progress`
  ADD PRIMARY KEY (`student_id`,`activity_id`,`viewed_datetime`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `activity_section`
--
ALTER TABLE `activity_section`
  ADD PRIMARY KEY (`section_id`,`activity_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `activity_semester`
--
ALTER TABLE `activity_semester`
  ADD PRIMARY KEY (`semester_id`,`activity_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `activity_student`
--
ALTER TABLE `activity_student`
  ADD PRIMARY KEY (`student_id`,`activity_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `activity_subject`
--
ALTER TABLE `activity_subject`
  ADD PRIMARY KEY (`subject_id`,`activity_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `activity_submissions`
--
ALTER TABLE `activity_submissions`
  ADD PRIMARY KEY (`id`,`student_id`,`activity_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `activity_tag`
--
ALTER TABLE `activity_tag`
  ADD PRIMARY KEY (`remark_id`,`activity_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`,`ip_address`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `class_group`
--
ALTER TABLE `class_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `conversation_media`
--
ALTER TABLE `conversation_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `correct_option`
--
ALTER TABLE `correct_option`
  ADD PRIMARY KEY (`id`),
  ADD KEY `correct_id` (`correct_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `semester_date_id` (`semester_date_id`);

--
-- Indexes for table `exam_terms`
--
ALTER TABLE `exam_terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `semester_date_id` (`semester_date_id`);

--
-- Indexes for table `grade_lesson_plan`
--
ALTER TABLE `grade_lesson_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `schoolid` (`schoolid`) USING BTREE,
  ADD KEY `semester_id` (`semester_id`) USING BTREE;

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `holiday_type`
--
ALTER TABLE `holiday_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`conversation_id`),
  ADD KEY `conversation_id` (`conversation_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qimages`
--
ALTER TABLE `qimages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qoptions`
--
ALTER TABLE `qoptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_evaluation`
--
ALTER TABLE `quiz_evaluation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `quizid` (`quizid`),
  ADD KEY `questionid` (`questionid`),
  ADD KEY `optionid` (`optionid`);

--
-- Indexes for table `quiz_result`
--
ALTER TABLE `quiz_result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `std_id` (`std_id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `q_id` (`q_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `section_id_2` (`section_id`);

--
-- Indexes for table `quiz_section`
--
ALTER TABLE `quiz_section`
  ADD PRIMARY KEY (`section_id`,`quiz_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `readed_message`
--
ALTER TABLE `readed_message`
  ADD PRIMARY KEY (`user_id`,`message_id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `remarks_tags`
--
ALTER TABLE `remarks_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_rights`
--
ALTER TABLE `role_rights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `section_id_2` (`section_id`),
  ADD KEY `subject_id_2` (`subject_id`),
  ADD KEY `teacher_uid` (`teacher_uid`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `semester_id` (`semester_id`) USING BTREE;

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester_dates`
--
ALTER TABLE `semester_dates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester_lesson_plan`
--
ALTER TABLE `semester_lesson_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `semester_id` (`semester_id`) USING BTREE,
  ADD KEY `set_id` (`set_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_semesters`
--
ALTER TABLE `student_semesters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `semester_id` (`semester_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `session` (`session_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `tablet_status`
--
ALTER TABLE `tablet_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_locations`
--
ALTER TABLE `user_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_meta`
--
ALTER TABLE `user_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meta_key` (`meta_key`(255)),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `versions`
--
ALTER TABLE `versions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wizard`
--
ALTER TABLE `wizard`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `activity_assesments`
--
ALTER TABLE `activity_assesments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `activity_assesment_qt`
--
ALTER TABLE `activity_assesment_qt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `activity_files`
--
ALTER TABLE `activity_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `activity_submissions`
--
ALTER TABLE `activity_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `class_group`
--
ALTER TABLE `class_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `conversation_media`
--
ALTER TABLE `conversation_media`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `correct_option`
--
ALTER TABLE `correct_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `exam_terms`
--
ALTER TABLE `exam_terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `form`
--
ALTER TABLE `form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `grade_lesson_plan`
--
ALTER TABLE `grade_lesson_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `holiday_type`
--
ALTER TABLE `holiday_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `qoptions`
--
ALTER TABLE `qoptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `quiz_evaluation`
--
ALTER TABLE `quiz_evaluation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `quiz_result`
--
ALTER TABLE `quiz_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `remarks_tags`
--
ALTER TABLE `remarks_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `role_rights`
--
ALTER TABLE `role_rights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `semester_dates`
--
ALTER TABLE `semester_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `semester_lesson_plan`
--
ALTER TABLE `semester_lesson_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `student_semesters`
--
ALTER TABLE `student_semesters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `tablet_status`
--
ALTER TABLE `tablet_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_locations`
--
ALTER TABLE `user_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `user_meta`
--
ALTER TABLE `user_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=367;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;
--
-- AUTO_INCREMENT for table `versions`
--
ALTER TABLE `versions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wizard`
--
ALTER TABLE `wizard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `invantage_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `activity_assesments`
--
ALTER TABLE `activity_assesments`
  ADD CONSTRAINT `activity_assesments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `invantage_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activity_assesments_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `activity_assesment_qt`
--
ALTER TABLE `activity_assesment_qt`
  ADD CONSTRAINT `activity_assesment_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `activity_class`
--
ALTER TABLE `activity_class`
  ADD CONSTRAINT `activity_class_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activity_class_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `activity_files`
--
ALTER TABLE `activity_files`
  ADD CONSTRAINT `activity_files_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `activity_progress`
--
ALTER TABLE `activity_progress`
  ADD CONSTRAINT `activity_progress_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `invantage_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activity_progress_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `activity_section`
--
ALTER TABLE `activity_section`
  ADD CONSTRAINT `activity_section_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activity_section_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `activity_semester`
--
ALTER TABLE `activity_semester`
  ADD CONSTRAINT `activity_semester_ibfk_1` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activity_semester_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `activity_student`
--
ALTER TABLE `activity_student`
  ADD CONSTRAINT `activity_student_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `invantage_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activity_student_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `activity_subject`
--
ALTER TABLE `activity_subject`
  ADD CONSTRAINT `activity_subject_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activity_subject_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `activity_submissions`
--
ALTER TABLE `activity_submissions`
  ADD CONSTRAINT `activity_submissions_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `invantage_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activity_submissions_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `activity_tag`
--
ALTER TABLE `activity_tag`
  ADD CONSTRAINT `activity_tag_ibfk_1` FOREIGN KEY (`remark_id`) REFERENCES `remarks_tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activity_tag_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `invantage_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `correct_option`
--
ALTER TABLE `correct_option`
  ADD CONSTRAINT `correct_option_ibfk_1` FOREIGN KEY (`correct_id`) REFERENCES `qoptions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `correct_option_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`semester_date_id`) REFERENCES `semester_dates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grade_lesson_plan`
--
ALTER TABLE `grade_lesson_plan`
  ADD CONSTRAINT `grade_lesson_plan_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grade_lesson_plan_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grade_lesson_plan_ibfk_3` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grade_lesson_plan_ibfk_4` FOREIGN KEY (`schoolid`) REFERENCES `schools` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `invantage_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `invantage_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz_evaluation`
--
ALTER TABLE `quiz_evaluation`
  ADD CONSTRAINT `quiz_evaluation_ibfk_4` FOREIGN KEY (`quizid`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quiz_evaluation_ibfk_5` FOREIGN KEY (`questionid`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quiz_evaluation_ibfk_6` FOREIGN KEY (`optionid`) REFERENCES `qoptions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quiz_evaluation_ibfk_7` FOREIGN KEY (`student_id`) REFERENCES `invantage_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz_result`
--
ALTER TABLE `quiz_result`
  ADD CONSTRAINT `quiz_result_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quiz_result_ibfk_2` FOREIGN KEY (`q_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quiz_result_ibfk_3` FOREIGN KEY (`std_id`) REFERENCES `invantage_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quiz_result_ibfk_4` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz_section`
--
ALTER TABLE `quiz_section`
  ADD CONSTRAINT `quiz_section_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quiz_section_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `readed_message`
--
ALTER TABLE `readed_message`
  ADD CONSTRAINT `readed_message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `invantage_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `readed_message_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schedule_ibfk_3` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `semester_lesson_plan`
--
ALTER TABLE `semester_lesson_plan`
  ADD CONSTRAINT `semester_lesson_plan_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `semester_lesson_plan_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `semester_lesson_plan_ibfk_3` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_semesters`
--
ALTER TABLE `student_semesters`
  ADD CONSTRAINT `student_semesters_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `invantage_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_semesters_ibfk_2` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_semesters_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_semesters_ibfk_4` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_semesters_ibfk_5` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
