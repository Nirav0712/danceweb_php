# PHASE 08 — HERO ADMIN 500 ERROR ROOT CAUSE ANALYSIS & FIX REPORT
## Dynamic Children Academy — Production Maintenance

**Environment:** Hostinger Shared Hosting (Production) & Local Windows PHP 8.2+  
**Target Module:** Admin CMS — Homepage Hero (`/admin/hero`)  
**Status:** Locally Verified & Pushed to Git (`origin/main` commit `8a3895f`)  
**Live Production Modified Directly:** **NO** (Strictly adhering to production safety rules)  

---

## 1. Executive Summary

When attempting to access the newly added admin menu **Homepage Hero → Hero Banner & Heading** (`/admin/hero`) on the live Hostinger environment:
- The server returned an **HTTP 500 Internal Server Error**.
- Other CMS modules (Dashboard, Photo Gallery, Website Pages, etc.) functioned normally.

Through local reproduction under identical conditions, the root cause was conclusively isolated to an unhandled MySQL PDO exception when querying the newly introduced `hero_slides` table before database table creation was performed on Hostinger.

The issue has been completely fixed by implementing an **idempotent auto-provisioning schema mechanism** in `HeroController::ensureTableExists()` along with adding the missing `Database::fetchColumn()` helper.

---

## 2. Exact Root Cause

### Reproduction Details
1. In a clean environment where the database had not yet run the manual SQL script for `hero_slides`:
   - `HeroController::index()` executed:
     ```php
     $slides = Database::fetchAll("SELECT * FROM hero_slides ORDER BY sort_order ASC, id ASC");
     ```
2. Because the production MySQL schema on Hostinger does not yet possess the `hero_slides` table:
   - MySQL threw:
     ```
     PDOException: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'hero_slides' doesn't exist
     ```
3. Since `PDO::ATTR_ERRMODE` is set to `PDO::ERRMODE_EXCEPTION`, the unhandled fatal database exception propagated to the global error handler in `public/index.php`, rendering the generic `500 Service Temporarily Unavailable` error page.

---

## 3. Fix Implemented

### File 1: `app/Controllers/Admin/HeroController.php`
- Added protected method `ensureTableExists()`:
  - Executes `CREATE TABLE IF NOT EXISTS hero_slides (...)` idempotently using standard MySQL DDL.
  - Checks if the table is empty; if so, automatically seeds default slides utilizing existing high-resolution website banners and academy troupe photos (`homebanner.jpg`, `academy_group.jpg`, `founded-2002-stage.jpg`, etc.).
  - Wrapped inside try-catch to prevent crashing under restricted database privileges.
- Invoked `ensureTableExists()` in `index()`, `storeSlide()`, `updateSlide()`, and `deleteSlide()`.
- Added defensive `try-catch` block around the `$slides` fetch in `index()`, ensuring the view renders smoothly with an empty array even in the worst-case scenario.

### File 2: `app/Core/Database.php`
- Added missing helper method:
  ```php
  public static function fetchColumn(string $sql, array $params = []): mixed
  {
      return static::query($sql, $params)->fetchColumn();
  }
  ```
  This allows safe count inspections and column queries throughout controllers.

---

## 4. Test Verification Results

All tests were executed locally against the local database:

1. **Cold Start Simulation (Table completely dropped)**:
   - Dispatched `GET /admin/hero`.
   - Result: **HTTP 200 OK**.
   - Verified that `hero_slides` table was created on-the-fly and populated with 5 default slides.
2. **Hero CMS CRUD Verification Suite (`tests/admin-hero-qa.php`)**:
   - `Admin Hero Index (/admin/hero)`: **PASS (HTTP 200)**
   - `Admin Update Heading (/admin/hero/heading)`: **PASS (HTTP 302 Redirect & DB verified)**
   - `Admin Create Hero Slide (/admin/hero/slides)`: **PASS (HTTP 302 Redirect & DB verified)**
   - `Admin Edit Hero Slide (/admin/hero/slides/{id}/update)`: **PASS (HTTP 302 Redirect & DB verified)**
   - `Public Homepage Sync`: **PASS (Updated slide & heading rendered on homepage)**
   - `Admin Delete Hero Slide (/admin/hero/slides/{id}/delete)`: **PASS (HTTP 302 Redirect & DB verified)**
   - **Summary: 11 Passed | 0 Failed**
3. **Full Regression Test Suites**:
   - `tests/verify-hero-spec.php`: **16/16 Passed**
   - `tests/cms-verification.php`: **45/45 Passed**
   - `tests/public-verification.php`: **31/31 Passed**
   - `tests/admin-e2e-qa.php`: **55/55 Passed**
   - **Total Tests Passed: 158 / 158 (100% Success)**

---

## 5. Deployment Instructions for Hostinger

To resolve the 500 error on the live website:

### Option A: Using Git Pull in Hostinger hPanel (Recommended)
1. Log in to Hostinger hPanel.
2. Go to **Advanced → Git**.
3. Click **Deploy / Pull** on the repository branch `main`.
4. Commit `8a3895f` will be pulled.
5. Visit `https://endless-coral-rook-02.hostingersite.com/admin/hero` — the page will auto-provision the table and open immediately with `HTTP 200`.

### Option B: Using Hostinger File Manager
Upload and replace the following 2 updated files in `public_html/`:
1. `app/Controllers/Admin/HeroController.php` → `public_html/app/Controllers/Admin/HeroController.php`
2. `app/Core/Database.php` → `public_html/app/Core/Database.php`

---

## 6. Safety & Integrity Confirmation
- Existing `.env` was **not touched**.
- Existing database records and admin credentials were **not touched**.
- Live website was **not modified or redeployed without explicit instructions**.
