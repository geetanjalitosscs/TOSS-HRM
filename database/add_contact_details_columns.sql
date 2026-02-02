-- =========================================================
-- Add Contact Details columns to employee_personal_details
-- If your table already has these columns (e.g. from toai_hrm),
-- you do not need to run this file.
-- Otherwise run and ignore "Duplicate column" for any that exist.
-- =========================================================

USE toai_hrm;

-- Address
ALTER TABLE `employee_personal_details`
    ADD COLUMN `address1` VARCHAR(191) DEFAULT NULL;
ALTER TABLE `employee_personal_details`
    ADD COLUMN `address2` VARCHAR(191) DEFAULT NULL;
ALTER TABLE `employee_personal_details`
    ADD COLUMN `city` VARCHAR(100) DEFAULT NULL;
ALTER TABLE `employee_personal_details`
    ADD COLUMN `state` VARCHAR(100) DEFAULT NULL;
ALTER TABLE `employee_personal_details`
    ADD COLUMN `postal_code` VARCHAR(20) DEFAULT NULL;
ALTER TABLE `employee_personal_details`
    ADD COLUMN `country` VARCHAR(100) DEFAULT NULL;

-- Telephone
ALTER TABLE `employee_personal_details`
    ADD COLUMN `home_phone` VARCHAR(50) DEFAULT NULL;
ALTER TABLE `employee_personal_details`
    ADD COLUMN `mobile_phone` VARCHAR(50) DEFAULT NULL;
ALTER TABLE `employee_personal_details`
    ADD COLUMN `work_phone` VARCHAR(50) DEFAULT NULL;

-- Email
ALTER TABLE `employee_personal_details`
    ADD COLUMN `work_email` VARCHAR(191) DEFAULT NULL;
ALTER TABLE `employee_personal_details`
    ADD COLUMN `other_email` VARCHAR(191) DEFAULT NULL;
