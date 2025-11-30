# Implementation Plan - Practical Info Updates

The goal is to add ordering and visibility control to the "Praktické informace" section.

## User Review Required
> [!IMPORTANT]
> You will need to run the `update_db.sql` script on your database to add the new columns (`sort_order`, `is_active`).

## Proposed Changes

### Database
#### [NEW] [update_db.sql](file:///c:/Users/admin/OneDrive/Dokumenty/Visual%20Studio%20Code/AxteaWeb26_Gemini3Asi/update_db.sql)
- SQL script to add `sort_order` (INT) and `is_active` (BOOLEAN/TINYINT) columns to `practical_info` table.

### Backend
#### [MODIFY] [admin.php](file:///c:/Users/admin/OneDrive/Dokumenty/Visual%20Studio%20Code/AxteaWeb26_Gemini3Asi/admin.php)
- Update "Add Item" form to include:
    - `sort_order` input (number, default 0).
    - `is_active` checkbox (checked by default).
- Update "List" table to:
    - Show `sort_order` (editable).
    - Show `is_active` status (checkbox).
    - Add logic to update these values (e.g., a "Save Changes" button for the table).

#### [MODIFY] [api.php](file:///c:/Users/admin/OneDrive/Dokumenty/Visual%20Studio%20Code/AxteaWeb26_Gemini3Asi/api.php)
- Update SQL query to:
    - Select only where `is_active = 1`.
    - Order by `sort_order ASC`.

### Frontend
#### [MODIFY] [index.php](file:///c:/Users/admin/OneDrive/Dokumenty/Visual%20Studio%20Code/AxteaWeb26_Gemini3Asi/index.php)
- No major changes needed in `index.php` as it consumes the API, but I should verify if any frontend logic needs adjustment.

## Verification Plan
### Manual Verification
- Run `update_db.sql` (User action).
- Go to `admin.php`, add a new item with specific order and active status.
- Check `index.php` (or `api.php` output) to see if the item appears in the correct order.
- Deactivate an item in `admin.php` and verify it disappears from `index.php`.
