-- Create the database and tables
CREATE DATABASE IF NOT EXISTS attendance_sys_student;

USE attendance_sys_student;

-- Table structure for table `attendance_list`
CREATE TABLE `attendance_list` (
  `id` INT(30) NOT NULL AUTO_INCREMENT,
  `class_subject_id` INT(30) NOT NULL,
  `doc` DATE NOT NULL,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`class_subject_id`) REFERENCES `class_subject` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `attendance_record`
CREATE TABLE `attendance_record` (
  `id` INT(30) NOT NULL AUTO_INCREMENT,
  `attendance_id` INT(30) NOT NULL,
  `student_id` INT(30) NOT NULL,
  `type` TINYINT(1) NOT NULL COMMENT '0=absent,1=present,2=late',
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`attendance_id`) REFERENCES `attendance_list` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `class`
CREATE TABLE `class` (
  `id` INT(30) NOT NULL AUTO_INCREMENT,
  `course_id` INT(30) NOT NULL,
  `level` VARCHAR(50) NOT NULL,
  `section` VARCHAR(100) NOT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `class_subject`
CREATE TABLE `class_subject` (
  `id` INT(30) NOT NULL AUTO_INCREMENT,
  `class_id` INT(30) NOT NULL,
  `subject_id` INT(30) NOT NULL,
  `faculty_id` INT(30) NOT NULL,
  `student_ids` TEXT NOT NULL,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `courses`
CREATE TABLE `courses` (
  `id` INT(30) NOT NULL AUTO_INCREMENT,
  `course` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `faculty`
CREATE TABLE `faculty` (
  `id` INT(30) NOT NULL AUTO_INCREMENT,
  `name` TEXT NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `contact` VARCHAR(50) NOT NULL,
  `address` TEXT NOT NULL,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `students`
CREATE TABLE `students` (
  `id` INT(30) NOT NULL AUTO_INCREMENT,
  `class_id` INT(30) NOT NULL,
  `name` TEXT NOT NULL,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `subjects`
CREATE TABLE `subjects` (
  `id` INT(30) NOT NULL AUTO_INCREMENT,
  `subject` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Table structure for table `users`
CREATE TABLE `users` (
  `id` INT(30) NOT NULL AUTO_INCREMENT,
  `name` TEXT NOT NULL,
  `username` VARCHAR(200) NOT NULL,
  `password` TEXT NOT NULL,
  `type` TINYINT(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff',
  `faculty_id` INT(30) NOT NULL COMMENT 'for faculty user only',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

