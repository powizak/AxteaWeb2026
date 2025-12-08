-- Add indexes to practical_info to improve performance on filtering and sorting
ALTER TABLE `practical_info` ADD INDEX `idx_section_active_sort` (`section`, `is_active`, `sort_order`);
ALTER TABLE `practical_info` ADD INDEX `idx_category` (`category`);
