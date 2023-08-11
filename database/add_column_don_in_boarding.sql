ALTER TABLE ep_boarding_activity
ADD don DATETIME AFTER uon;
ALTER TABLE ep_boarding_activity_group
ADD don DATETIME AFTER uon;
ALTER TABLE ep_boarding_activity_item
ADD don DATETIME AFTER uon;