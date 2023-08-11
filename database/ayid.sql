ALTER TABLE ep_course_class DROP COLUMN ayid;
ALTER TABLE ep_course_class_dtl ADD ayid INT(11) UNSIGNED NOT NULL COMMENT 'Academic Year ID' AFTER ccid;
UPDATE ep_course_class_dtl SET ayid = 1;
ALTER TABLE ep_course_class_dtl 
MODIFY COLUMN sid INT(10) UNSIGNED NOT NULL COMMENT 'student.id',
MODIFY COLUMN ccid INT(11) UNSIGNED NOT NULL;
ALTER TABLE ep_course_class_dtl DROP PRIMARY KEY;