# Phase 08 Report: Dynamic CMS-Managed Rotating Hero Heading

**Dynamic Children Academy — Performance & Cultural Arts Institute**  
*Date: 27 November 2026*  
*Environment: Local PHP/MySQL Architecture (`F:\Dance Web\Dance Web\php-version`)*

---

## 1. Executive Summary

This phase successfully implemented a dynamic, CMS-managed rotating heading element directly below the homepage hero image slider for Dynamic Children Academy. 

The first portion of the heading is permanently visible as the fixed prefix:
> **Empowering Young Minds Through**

The second portion dynamically rotates through multiple CMS-managed phrases:
> **Indian Dance**, **Classical Dance**, **Cultural Excellence**, **Artistic Expression**, **Creative Learning**

The rotating dynamic phrases are highlighted using the academy's official orange/amber accent styling (`text-amber-500 font-extrabold`). The hero image banner slider above and the curriculum/disciplines section below remain 100% intact and untouched.

---

## 2. Database Schema Changes

A dedicated, lightweight table was created following the project's existing database architecture and naming conventions:

```sql
CREATE TABLE IF NOT EXISTS hero_rotating_phrases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phrase VARCHAR(255) NOT NULL,
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME(3) DEFAULT CURRENT_TIMESTAMP(3),
    updated_at DATETIME(3) DEFAULT CURRENT_TIMESTAMP(3) ON UPDATE CURRENT_TIMESTAMP(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Initial Seed Data
When the table is newly created or empty, it automatically seeds 5 authentic cultural phrases:
1. `Indian Dance` (sort_order: 1, active: 1)
2. `Classical Dance` (sort_order: 2, active: 1)
3. `Cultural Excellence` (sort_order: 3, active: 1)
4. `Artistic Expression` (sort_order: 4, active: 1)
5. `Creative Learning` (sort_order: 5, active: 1)

### Heading Section Storage
- **Fixed Prefix**: Stored in `sections.heading` where `section_key = 'hero'` (default: `Empowering Young Minds Through`).
- **Rotation Configuration**: Stored in `sections.content` as a JSON configuration payload:
  ```json
  {
    "rotation_duration": 3,
    "transition_style": "slide-fade"
  }
  ```

---

## 3. Exact Files Modified & Created

| File | Type | Description |
|---|---|---|
| `app/Controllers/Admin/HeroController.php` | Modified | Added schema auto-creation (`ensureTableExists`), validation logic, phrase CRUD (`storePhrase`, `updatePhrase`, `deletePhrase`, `togglePhrase`), and heading configuration. |
| `resources/views/admin/hero/index.php` | Modified | Added interactive live heading preview card, fixed heading and rotation settings form, rotating phrases table with status badges, and modals. |
| `app/Controllers/PublicController.php` | Modified | Updated `home()` method to query active phrases and pass rotation duration and transition style to the view. |
| `resources/views/public/home.php` | Modified | Updated hero heading section to split fixed text and dynamic rotating phrase container; added modular rotating text slider script with hover-pause and reduced-motion support. |
| `routes/web.php` | Modified | Added routes for phrase CRUD (`/admin/hero/phrases*`). |
| `tests/verify-dynamic-hero-heading-spec.php` | Created | Automated test suite with 49 test assertions verifying database, admin CRUD, validations, frontend rendering, and regression stability. |

---

## 4. Frontend Design & Rotator Behavior

- **Typography & Visual Style**: Matches existing homepage aesthetics (`font-serif text-2xl sm:text-[26px] font-bold text-slate-800 tracking-tight leading-snug`).
- **Dynamic Accent**: Rotating phrase is wrapped inside `.hero-dynamic-phrase` with `text-amber-500 font-extrabold`.
- **Configurable Duration**: Rotates every `N` seconds (default: 3 seconds; configurable between 2 and 15 seconds from the CMS).
- **Supported Transitions**:
  1. `slide-fade` (default): Smooth vertical slide with crossfade.
  2. `fade`: Gentle opacity crossfade in-place.
  3. `slide-up`: Upward translate transition.
- **Desktop Hover Pause**: The rotation timer automatically pauses when the pointer hovers over the heading (`mouseenter`) and resumes when the pointer leaves (`mouseleave`).
- **Accessibility & Reduced Motion**: Queries `window.matchMedia('(prefers-reduced-motion: reduce)')`. When active, vertical translations are disabled, using only subtle opacity fades.
- **Layout Shift Prevention**: Uses `.hero-phrase-wrapper` with inline-flex alignment and dynamic width stabilization to eliminate layout jumping when phrase lengths vary.
- **Single / Empty Fallback**: If only 1 phrase is active, it displays statically without running an unnecessary timer loop.

---

## 5. Admin CMS Features

Located at `/admin/hero`:
1. **Interactive Live Preview**:
   - Real-time preview showing the fixed text and rotating phrase in live action.
   - Includes a **↻ Test Next Phrase** manual trigger button.
2. **Fixed Text & Rotation Settings**:
   - Permanent Fixed Prefix Text input (default: `Empowering Young Minds Through`).
   - Subtitle / Tagline input.
   - Rotation Duration (2–15 seconds).
   - Transition Style selection (`slide-fade`, `fade`, `slide-up`).
3. **Rotating Dynamic Phrases Manager**:
   - Displays all phrases with sort order, active status, and visual preview badges.
   - **+ Add Rotating Phrase** modal dialog.
   - **Edit Phrase** modal dialog.
   - **1-Click Status Toggle** (Active ↔ Disabled).
   - **Delete Phrase** with safety validation (prevents deleting the only active phrase).
4. **Validation Rules**:
   - Phrase text cannot be empty.
   - Rotation duration must be between 2 and 15 seconds.
   - Disabling or deleting the last active phrase is rejected to prevent a broken frontend.

---

## 6. Automated Verification & Test Results

Executed via `php tests/verify-dynamic-hero-heading-spec.php`:

```
Starting Dynamic CMS Rotating Hero Heading Verification Spec...

--- 1. Testing Database Schema & Initial Seeding ---
  [PASS] Admin Hero Controller renders with HTTP 200
  [PASS] Table 'hero_rotating_phrases' exists in database
  [PASS] Database contains at least 5 seeded rotating phrases
  [PASS] Initial phrases include 'Indian Dance'
  [PASS] Initial phrases include 'Classical Dance'
  [PASS] Initial phrases include 'Cultural Excellence'
  [PASS] Initial phrases include 'Artistic Expression'
  [PASS] Initial phrases include 'Creative Learning'
  [PASS] Hero section exists in sections table
  [PASS] Hero section heading is initialized to 'Empowering Young Minds Through'

--- 2. Testing Admin Hero UI & Live Preview Markup ---
  [PASS] Admin hero index title updated
  [PASS] Admin page contains Live Heading Preview card
  [PASS] Live preview includes reactive fixed text element
  [PASS] Live preview includes reactive dynamic phrase element
  [PASS] Live preview features 'Test Next Phrase' trigger
  [PASS] Admin page includes Fixed Prefix Text field
  [PASS] Admin page includes Rotation Duration field
  [PASS] Admin page includes Transition Style field
  [PASS] Admin page includes Rotating Phrases management table
  [PASS] Admin page includes Add Rotating Phrase button & modal

--- 3. Testing Admin Phrases CRUD & Validations ---
  [PASS] Store phrase returns 302 redirect
  [PASS] New rotating phrase successfully persisted in database
  [PASS] Empty phrase submission is caught and redirects with validation error
  [PASS] Update phrase returns 302 redirect
  [PASS] Phrase edit successfully saved in database
  [PASS] Toggle phrase status returns 302 redirect
  [PASS] Phrase status toggled to inactive (0)
  [PASS] Phrase status toggled back to active (1)
  [PASS] Delete phrase returns 302 redirect
  [PASS] Phrase cleanly deleted from database
  [PASS] Invalid rotation duration (25s) is rejected with 302 redirect error
  [PASS] Valid heading and duration (4s) saved with 302 redirect
  [PASS] Rotation duration saved as 4 seconds in JSON content
  [PASS] Transition style saved as 'slide-fade'

--- 4. Testing Public Homepage Frontend Rendering ---
  [PASS] Homepage dispatches with HTTP 200
  [PASS] Homepage includes hero heading section
  [PASS] Homepage includes hero rotating heading element
  [PASS] Homepage displays fixed phrase 'Empowering Young Minds Through'
  [PASS] Homepage contains dynamic rotating phrase element
  [PASS] Dynamic phrase is styled with amber-500 font-extrabold accent
  [PASS] Heading element includes data-phrases JSON attribute
  [PASS] Heading initial render includes 'Indian Dance'
  [PASS] Heading data-duration matches configured duration (3s)
  [PASS] Heading data-transition matches configured style (slide-fade)
  [PASS] Rotator script implements desktop hover pause and resume
  [PASS] Rotator script respects prefers-reduced-motion accessibility
  [PASS] Rotator includes layout-shift prevention wrapper
  [PASS] Hero image slider section is 100% intact
  [PASS] Curriculum & disciplines section below heading is 100% intact

Total Passes: 49
Total Errors: 0
ALL DYNAMIC HERO HEADING TESTS PASSED! 100% SUCCESS
```

### Full Regression Suite
- ✅ `tests/verify-dynamic-hero-heading-spec.php`: **49 / 49 Passes (100%)**
- ✅ `tests/verify-admin-redesign-spec.php`: **29 / 29 Passes (100%)**
- ✅ `tests/verify-footer-spec.php`: **46 / 46 Passes (100%)**
- ✅ `tests/verify-legal-pages-spec.php`: **28 / 28 Passes (100%)**
- ✅ `tests/verify-gallery-and-contact-spec.php`: **22 / 22 Passes (100%)**

---

## 7. Remaining Issues & Notes

- **Remaining Issues**: None. All features implemented strictly locally without deploying to Hostinger as requested.
- **Data Integrity**: Zero existing records deleted; existing hero slides, awards, testimonials, and gallery items remain intact.
