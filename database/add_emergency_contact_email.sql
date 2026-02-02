-- Add email column to employee_emergency_contacts for emergency contacter email.
-- Run if your table does not already have this column.

USE toai_hrm;

ALTER TABLE `employee_emergency_contacts`
    ADD COLUMN `email` VARCHAR(191) DEFAULT NULL AFTER `work_phone`;
