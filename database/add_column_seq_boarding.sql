ALTER TABLE ep_boarding_activity
ADD COLUMN seq INT AFTER TYPE;

ALTER TABLE ep_boarding_activity_group
ADD COLUMN seq INT AFTER name_en;

ALTER TABLE ep_boarding_activity_item
ADD COLUMN seq INT AFTER bypass;