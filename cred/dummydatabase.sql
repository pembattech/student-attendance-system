INSERT INTO `attendance_list` (`class_subject_id`, `doc`, `date_created`) VALUES
(1, '2020-10-28', '2020-10-28 20:06:37');

INSERT INTO `attendance_record` (`attendance_id`, `student_id`, `type`, `date_created`) VALUES
(1, 1, 1, '2020-10-28 20:06:37'),
(1, 2, 2, '2020-10-28 20:06:37');

INSERT INTO `class` (`course_id`, `level`, `section`, `status`, `date_created`) VALUES
(2, '1', 'B', 1, '2020-10-28 10:48:45'),
(2, '1', 'A', 1, '2020-10-28 10:52:58');

INSERT INTO `class_subject` (`class_id`, `subject_id`, `faculty_id`, `student_ids`) VALUES
(2, 1, 1, ''),
(1, 2, 1, '');

INSERT INTO `courses` (`course`, `description`, `date_created`) VALUES
('Sample Course', 'Sample Course', '2020-10-28 10:00:41'),
('Course 2', ' Course 2', '2020-10-28 10:02:09'),
('Course 3', ' Course 3', '2020-10-28 10:02:16'),
('Course 4', ' Course 4', '2020-10-28 10:02:24');

INSERT INTO `faculty` (`name`, `email`, `contact`, `address`) VALUES
('John Smith', 'jsmith@sample.com', '+18456-5455-55', 'Sample Only');

INSERT INTO `students` (`class_id`, `name`) VALUES
(2, 'Claire Blake'),
(2, 'George Wilson');

INSERT INTO `subjects` (`subject`, `description`) VALUES
('Subject 1 ', 'Subject 1 '),
('Subject 2', 'Subject 2'),
('Subject 3', 'Subject 3');



INSERT INTO `system_settings` (`name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
('Student Attendance Management System', 'info@sample.comm', '+6948 8542 623', '1603344720_1602738120_pngtree-purple-hd-business-banner-image_5493.jpg', '<p style="text-align: center; background: transparent; position: relative;"><span style="color: rgb(0, 0, 0); font-family: "Open Sans", Arial, sans-serif; font-weight: 400; text-align: justify;">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&rsquo;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><br></p><p style="text-align: center; background: transparent; position: relative;"><br></p><p style="text-align: center; background: transparent; position: relative;"><br></p><p></p>');


INSERT INTO `users` (`name`, `username`, `password`, `type`, `faculty_id`) VALUES
('Administrator', 'admin', '0192023a7bbd73250516f069df18b500', 1, 0),
('John Smith', 'jsmith@sample.com', 'af606ddc433ae6471f104872585cf880', 3, 1);

COMMIT;
