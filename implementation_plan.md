# Implementation Plan - Course Materials Section

The goal is to add a password-protected section for course participants with its own subcategories.

## User Review Required
> [!IMPORTANT]
> You will need to run the `update_db_courses.sql` script to add the configuration table and update the `practical_info` table structure.

## Proposed Changes

### Database
#### [NEW] [update_db_courses.sql](file:///c:/Users/admin/OneDrive/Dokumenty/Visual%20Studio%20Code/AxteaWeb26_Gemini3Asi/update_db_courses.sql)
- Create table `app_config` to store the shared password.
- Add `section` column to `practical_info` (ENUM: 'public', 'courses') to distinguish between main site info and course info.
- `category` column will now serve as subcategory for both sections.
    - Public: 'aktualne', 'odkazy', 'uzitecne'
    - Courses: 'materialy', 'prezentace', 'dalsi' (or similar customizable 3 columns)
- Insert default password.

### Backend
#### [MODIFY] [admin.php](file:///c:/Users/admin/OneDrive/Dokumenty/Visual%20Studio%20Code/AxteaWeb26_Gemini3Asi/admin.php)
- **Add Item Form**:
    - Add "Sekce" (Section) radio buttons: "Veřejné info" vs "Kurzy".
    - Dynamic "Kategorie" dropdown based on selected section.
        - If Public: Aktuálně, Odkazy, Užitečné.
        - If Courses: Materiály, Prezentace, Další (names to be defined).
- **List View**:
    - Filter or tab view to separate "Veřejné" and "Kurzy" for better organization.
- **Settings**: Password management.

#### [MODIFY] [api.php](file:///c:/Users/admin/OneDrive/Dokumenty/Visual%20Studio%20Code/AxteaWeb26_Gemini3Asi/api.php)
- **Public Request**: Fetch only `section = 'public'` AND `is_active = 1`.
- **Password Request**:
    - Verify password.
    - If correct, fetch `section = 'courses'` AND `is_active = 1`.
    - Group by `category` (3 columns).

### Frontend
#### [MODIFY] [index.php](file:///c:/Users/admin/OneDrive/Dokumenty/Visual%20Studio%20Code/AxteaWeb26_Gemini3Asi/index.php)
- **Course Section**:
    - Password input.
    - On success, render 3 columns similar to the public section but with course data.

## Verification Plan
### Manual Verification
- Run SQL update.
- Admin: Add items to both sections.
- Admin: Change course password.
- Frontend: Verify public info loads without password.
- Frontend: Verify course info requires password and displays correct columns.
