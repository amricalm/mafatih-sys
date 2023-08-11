alter table ep_bayanat_result add column result_appreciation varchar(30) after result_decision_set;
alter table ep_bayanat_result add column result_decision_level varchar(30) after result_appreciation;
