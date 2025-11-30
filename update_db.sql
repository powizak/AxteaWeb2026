-- Add sort_order and is_active columns to practical_info table
ALTER TABLE practical_info ADD COLUMN sort_order INT DEFAULT 0;
ALTER TABLE practical_info ADD COLUMN is_active TINYINT(1) DEFAULT 1;
