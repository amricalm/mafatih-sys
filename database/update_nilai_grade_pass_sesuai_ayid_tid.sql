### mastiin semua nilainya sama antara grade_pass remedy_class dan coursesubject sesuai ayid, tid

SELECT erc.`course_subject_id`, es.name,
	ecs.`grade_pass`, erc.`grade_pass`AS gp,
	grade_before, grade_after
FROM ep_remedy_class AS erc
JOIN ep_course_subject AS ecs
	ON ecs.`subject_id` = erc.`course_subject_id`
	AND ecs.`ayid` = erc.`ayid`
	AND ecs.tid = erc.tid
JOIN ep_subject AS es ON ecs.`subject_id` = es.id;

### update semua gradepass di remedy_class oleh isi tabel course subject sesuai ayid, tid

UPDATE ep_remedy_class AS erc
JOIN ep_course_subject AS ecs
	ON ecs.`subject_id` = erc.`course_subject_id`
	AND ecs.`ayid` = erc.`ayid`
	AND ecs.tid = erc.tid
JOIN ep_subject AS es ON ecs.`subject_id` = es.id
SET erc.grade_pass = ecs.grade_pass;
