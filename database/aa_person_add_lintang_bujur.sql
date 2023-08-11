ALTER TABLE aa_address
ADD latitude VARCHAR(50) AFTER `post_code`,
ADD longitude VARCHAR(50) AFTER `latitude`;

ALTER TABLE aa_employe
ADD npwp VARCHAR(50) AFTER `position_id`,
ADD npwp_name VARCHAR(50) AFTER `npwp`,
ADD marital_status VARCHAR(50) AFTER `npwp_name`,
ADD coupleid INT(11) AFTER `marital_status`,
ADD employment_status INT(11) FIRST `niy`,
ADD niy VARCHAR(50) AFTER `coupleid`, -- Nomor Induk Yayasan
ADD nuptk VARCHAR(50) AFTER `niy`, -- NUPTK
ADD ptk_type VARCHAR(50) AFTER `nuptk`, -- Jenis PTK
ADD decision_number VARCHAR(50) AFTER `ptk_type`, -- Nomor SK Pengangkatan
ADD decision_date DATE AFTER `decision_number`, -- TMT Pengangkatan
ADD decision_institution VARCHAR(50) AFTER `decision_date`, -- Lembaga Pengangkatan
ADD source_salary VARCHAR(50) AFTER `decision_institution`; -- Sumber Gaji

ALTER TABLE aa_person
ADD hp VARCHAR(30) AFTER `disability_type`,
ADD received_date DATE AFTER `phone`,
ADD out_date DATE AFTER `received_date`;

