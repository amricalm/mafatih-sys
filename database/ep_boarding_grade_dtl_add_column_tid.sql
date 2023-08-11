ALTER TABLE ep_boarding_grade
ADD tid INT(1) NULL AFTER ayid;

ALTER TABLE ep_boarding_grade_dtl
ADD ayid INT(1) NULL AFTER sid,
ADD tid INT(1) NULL AFTER ayid;