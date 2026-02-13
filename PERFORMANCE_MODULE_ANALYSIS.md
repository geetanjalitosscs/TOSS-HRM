# PERFORMANCE MANAGEMENT MODULE - COMPLETE ANALYSIS & IMPLEMENTATION

## STEP 1: CURRENT FLOW ANALYSIS

### ❌ CURRENT PROBLEMS IDENTIFIED

1. **No Clear Business Flow**
   - KPIs exist but are NOT linked to reviews
   - Trackers and Reviews are the SAME table (`performance_reviews`)
   - No KPI rating mechanism exists
   - No score calculation logic
   - Status values are inconsistent across pages

2. **Confusing Terminology**
   - "Trackers" = Performance Reviews (same table)
   - "Reviews" = Performance Reviews (same table)
   - No distinction between tracker assignment and review completion

3. **Missing Data Flow**
   - KPIs → Reviews: NOT CONNECTED
   - KPI Ratings → Overall Rating: NOT CALCULATED
   - Review Status → Approval: INCOMPLETE

4. **Database Issues**
   - `performance_review_kpis` table EXISTS but is NEVER USED
   - `overall_rating` field exists but is NEVER CALCULATED
   - `reviewer_id` is set but reviewer workflow is MISSING

### 📊 CURRENT STATE MAPPING

**What Actually Happens Now:**

1. **KPI Creation** (✅ Works)
   - Admin/HR creates KPIs in `kpis` table
   - KPIs have: name, description, weight
   - NO connection to reviews

2. **Tracker/Review Creation** (⚠️ Confused)
   - HR creates "tracker" = creates `performance_reviews` record
   - Same record used for "review"
   - Status: `not_started`, `in_progress`, `completed`, `approved`
   - NO KPI ratings stored
   - NO overall rating calculated

3. **Review Process** (❌ Missing)
   - No way to rate individual KPIs
   - No way to calculate overall score
   - No approval workflow
   - No reviewer assignment workflow

---

## STEP 2: CORRECT PERFORMANCE ARCHITECTURE

### ✅ PROPER BUSINESS FLOW

```
┌─────────────────────────────────────────────────────────────┐
│                    PERFORMANCE LIFECYCLE                     │
└─────────────────────────────────────────────────────────────┘

1. SETUP PHASE (HR/Admin)
   ├─ Create Performance Cycle (Annual, Quarterly, etc.)
   ├─ Define KPIs with weights
   └─ Assign employees to cycle

2. TRACKER ASSIGNMENT (HR/Manager)
   ├─ Create tracker for employee + cycle
   ├─ Assign reviewer (manager/supervisor)
   └─ Status: not_started

3. SELF-EVALUATION (Employee) - Optional
   ├─ Employee rates themselves on KPIs
   └─ Status: in_progress

4. REVIEW PHASE (Reviewer/Manager)
   ├─ Reviewer rates employee on each KPI
   ├─ Reviewer adds comments per KPI
   ├─ System calculates weighted score
   └─ Status: completed

5. APPROVAL PHASE (HOD/HR)
   ├─ Review overall rating
   ├─ Approve or request changes
   └─ Status: approved

6. CLOSURE
   ├─ Final rating stored
   ├─ Can trigger appraisal (salary change)
   └─ Status: closed (optional)
```

### 📋 DATA FLOW DIAGRAM

```
KPIs (Master List)
    ↓
Performance Cycle (Time Period)
    ↓
Performance Review (Employee + Cycle)
    ↓
Performance Review KPIs (Individual Ratings)
    ↓
Overall Rating (Calculated)
    ↓
Approval Status
```

---

## STEP 3: DATABASE AUDIT

### Table: `kpis`

**Purpose:** Master list of Key Performance Indicators

**Columns:**
- ✅ `id` - Used
- ✅ `name` - Used
- ✅ `description` - Used
- ✅ `weight` - Used (but NOT for calculation)
- ✅ `created_at` - Used
- ✅ `updated_at` - Used

**Issues:**
- ❌ `weight` is stored but NOT used in calculations
- ❌ No `job_title_id` or `department_id` - KPIs are global (may be intentional)
- ❌ No `is_active` flag

**Status:** ✅ Table structure is OK, but weight calculation missing

---

### Table: `performance_cycles`

**Purpose:** Time periods for reviews (Annual, Quarterly, etc.)

**Columns:**
- ✅ `id` - Used
- ✅ `name` - Used
- ✅ `start_date` - Used
- ✅ `end_date` - Used
- ✅ `status` - Used (planned, active, closed, archived)
- ✅ `created_at` - Used
- ✅ `updated_at` - Used

**Issues:**
- ✅ All columns properly used

**Status:** ✅ Table is complete

---

### Table: `performance_reviews`

**Purpose:** Main review record linking employee to cycle

**Columns:**
- ✅ `id` - Used
- ✅ `cycle_id` - Used
- ✅ `employee_id` - Used
- ✅ `reviewer_id` - Used (but workflow missing)
- ⚠️ `status` - Used (but values inconsistent)
- ❌ `overall_rating` - EXISTS but NEVER CALCULATED
- ❌ `comments` - EXISTS but NOT in UI
- ✅ `created_at` - Used
- ✅ `updated_at` - Used

**Issues:**
- ❌ `overall_rating` should be calculated from `performance_review_kpis`
- ❌ `comments` field not shown in UI
- ⚠️ Status enum: `not_started`, `in_progress`, `completed`, `approved`
  - Missing: `draft`, `submitted`, `rejected`, `closed`
- ❌ No `submitted_at`, `approved_at`, `approved_by` timestamps

**Status:** ⚠️ Structure OK but missing workflow fields

---

### Table: `performance_review_kpis`

**Purpose:** Individual KPI ratings within a review

**Columns:**
- ❌ `id` - EXISTS but NEVER USED
- ❌ `performance_review_id` - EXISTS but NEVER USED
- ❌ `kpi_id` - EXISTS but NEVER USED
- ❌ `rating` - EXISTS but NEVER USED
- ❌ `comments` - EXISTS but NEVER USED
- ✅ `created_at` - System
- ✅ `updated_at` - System

**Issues:**
- ❌ **ENTIRE TABLE IS UNUSED**
- ❌ No UI to create/edit these records
- ❌ No calculation logic to aggregate ratings

**Status:** ❌ **CRITICAL - Table exists but completely unused**

---

### Table: `performance_appraisals`

**Purpose:** Salary changes after review approval

**Columns:**
- ❌ `id` - EXISTS but NEVER USED
- ❌ `performance_review_id` - EXISTS but NEVER USED
- ❌ `old_salary` - EXISTS but NEVER USED
- ❌ `new_salary` - EXISTS but NEVER USED
- ❌ `effective_date` - EXISTS but NEVER USED
- ❌ `comments` - EXISTS but NEVER USED

**Status:** ❌ **Table exists but completely unused (future feature)**

---

## STEP 4: CORRECTED DATABASE SCHEMA

### Required Changes

#### 1. `performance_reviews` - Add Missing Fields

```sql
ALTER TABLE `performance_reviews`
ADD COLUMN `submitted_at` datetime NULL AFTER `comments`,
ADD COLUMN `approved_at` datetime NULL AFTER `submitted_at`,
ADD COLUMN `approved_by` bigint(20) UNSIGNED NULL AFTER `approved_at`,
ADD COLUMN `rejected_at` datetime NULL AFTER `approved_by`,
ADD COLUMN `rejected_by` bigint(20) UNSIGNED NULL AFTER `rejected_at`,
ADD COLUMN `rejection_reason` text NULL AFTER `rejected_by`;

-- Update status enum to include more states
ALTER TABLE `performance_reviews`
MODIFY COLUMN `status` enum('draft','not_started','in_progress','submitted','completed','approved','rejected','closed') DEFAULT 'not_started';
```

#### 2. `performance_review_kpis` - Ensure Proper Indexes

```sql
-- Already has proper indexes, but ensure foreign keys
ALTER TABLE `performance_review_kpis`
ADD CONSTRAINT `fk_review_kpis_review` FOREIGN KEY (`performance_review_id`) 
    REFERENCES `performance_reviews` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `fk_review_kpis_kpi` FOREIGN KEY (`kpi_id`) 
    REFERENCES `kpis` (`id`) ON DELETE RESTRICT;
```

#### 3. `kpis` - Add Active Flag

```sql
ALTER TABLE `kpis`
ADD COLUMN `is_active` tinyint(1) DEFAULT 1 AFTER `weight`;
```

---

## STEP 5: PAGE-BY-PAGE IMPLEMENTATION

### Page 1: KPIs Configuration (`/performance/kpis`)

#### Current State
- ✅ Lists KPIs
- ✅ CRUD operations work
- ❌ Weight not used in calculations
- ❌ No job title/department association

#### Model
- **Table:** `kpis`
- **Relations:** None (should link to `performance_review_kpis`)

#### Controller
- **Methods:** `kpis()`, `storeKpi()`, `updateKpi()`, `deleteKpi()`, `bulkDeleteKpis()`
- **Issues:**
  - Weight validation allows any number (should be 0-100 or percentage)
  - No check if KPI is used in active reviews before deletion

#### View
- **Fields:** name, description, weight
- **Missing:** 
  - Usage count (how many reviews use this KPI)
  - Active/inactive toggle
  - Job title filter

#### Fixes Required
1. Add validation: weight should be 0-100
2. Add soft delete check (prevent deletion if used)
3. Add "Used in X reviews" display
4. Add is_active toggle

---

### Page 2: Trackers (`/performance/trackers`)

#### Current State
- ✅ Lists performance_reviews as "trackers"
- ✅ Shows employee, cycle, dates, status
- ✅ CRUD operations
- ❌ Confusing name (should be "Reviews" not "Trackers")
- ❌ Missing reviewer assignment in UI
- ❌ Missing KPI ratings

#### Model
- **Table:** `performance_reviews`
- **Relations:** 
  - `employees` (employee_id)
  - `performance_cycles` (cycle_id)
  - `employees` as reviewers (reviewer_id)
  - ❌ Missing: `performance_review_kpis` (NOT JOINED)

#### Controller
- **Methods:** `trackers()`, `storeTracker()`, `updateTracker()`, `deleteTracker()`
- **Issues:**
  - Creates `performance_reviews` but doesn't create `performance_review_kpis`
  - No logic to assign KPIs to review
  - Status validation inconsistent

#### View
- **Fields:** employee, tracker (cycle), dates, status, reviewer, overall_rating, comments
- **Missing:**
  - KPI ratings section
  - Reviewer assignment workflow
  - Overall rating calculation display

#### Fixes Required
1. Rename to "Performance Reviews" (not "Trackers")
2. Add KPI ratings section
3. Add reviewer assignment
4. Show calculated overall rating
5. Add workflow buttons (Submit, Approve, Reject)

---

### Page 3: Manage Reviews (`/performance`)

#### Current State
- ✅ Lists all reviews
- ✅ Search/filter works
- ❌ Same data as "Trackers" page (confusing)
- ❌ No distinction between tracker and review
- ❌ Missing KPI details

#### Model
- **Table:** `performance_reviews`
- **Same as Trackers page**

#### Controller
- **Methods:** `index()`, `storeReview()`, `updateReview()`, `deleteReview()`
- **Issues:**
  - Status validation uses `pending` but DB uses `not_started`
  - No KPI rating logic

#### View
- **Fields:** employee, job_title, review_period, due_date, reviewer, review_status
- **Missing:**
  - Overall rating column
  - KPI breakdown
  - Approval workflow

#### Fixes Required
1. Fix status values (use DB enum values)
2. Add overall_rating column
3. Add KPI ratings view
4. Add approval workflow

---

### Page 4: My Trackers (`/performance/my-trackers`)

#### Current State
- ✅ Shows logged-in employee's reviews
- ❌ Hardcoded employee_id = 1
- ❌ Missing KPI ratings
- ❌ Missing status workflow

#### Model
- **Table:** `performance_reviews`
- **Filter:** `employee_id = current_user`

#### Controller
- **Methods:** `myTrackers()`
- **Issues:**
  - Hardcoded employee_id
  - No KPI data

#### View
- **Fields:** tracker name, dates
- **Missing:**
  - Status
  - KPI ratings
  - Self-evaluation form
  - Overall rating

#### Fixes Required
1. Use actual logged-in user
2. Add KPI self-rating form
3. Add status display
4. Add submit button

---

### Page 5: Employee Trackers (`/performance/employee-trackers`)

#### Current State
- ✅ Lists all employee reviews
- ❌ Same as "Trackers" but different view
- ❌ Missing KPI data

#### Model
- **Table:** `performance_reviews`

#### Controller
- **Methods:** `employeeTrackers()`
- **Issues:**
  - No KPI data
  - No reviewer workflow

#### View
- **Fields:** employee_name, tracker, dates
- **Missing:**
  - Status
  - Reviewer
  - KPI ratings
  - Overall rating

#### Fixes Required
1. Add missing columns
2. Add KPI ratings
3. Add reviewer assignment

---

### Page 6: My Reviews (`/performance/my-reviews`)

#### Current State
- ✅ Shows employee's reviews
- ❌ Hardcoded employee_id
- ❌ Missing KPI details
- ❌ Status mapping confusing

#### Model
- **Table:** `performance_reviews`

#### Controller
- **Methods:** `myReviews()`
- **Issues:**
  - Hardcoded employee_id
  - Complex status mapping (in_progress/completed = "Activated")

#### View
- **Fields:** job_title, sub_unit, review_period, due_date, status
- **Missing:**
  - KPI ratings
  - Overall rating
  - Action buttons

#### Fixes Required
1. Use actual logged-in user
2. Add KPI ratings view
3. Add self-evaluation form
4. Simplify status display

---

### Page 7: Employee Reviews (`/performance/employee-reviews`)

#### Current State
- ✅ Lists all employee reviews
- ❌ Missing KPI data
- ❌ Missing reviewer workflow

#### Model
- **Table:** `performance_reviews`

#### Controller
- **Methods:** `employeeReviews()`
- **Issues:**
  - No KPI data
  - No reviewer assignment

#### View
- **Fields:** employee, job_title, sub_unit, review_period, due_date, status
- **Missing:**
  - Reviewer column
  - KPI ratings
  - Overall rating
  - Approval workflow

#### Fixes Required
1. Add reviewer column
2. Add KPI ratings
3. Add overall rating
4. Add review/approve buttons

---

## STEP 6: PERFORMANCE SCORING LOGIC

### Calculation Formula

```
Overall Rating = Σ (KPI_Rating × KPI_Weight) / Σ (KPI_Weight)

Where:
- KPI_Rating = rating from performance_review_kpis (0-100)
- KPI_Weight = weight from kpis table
- Only active KPIs are included
```

### Example

```
KPI 1: Code Quality
  - Weight: 100
  - Rating: 85
  - Contribution: 85 × 100 = 8500

KPI 2: Delivery Timeliness
  - Weight: 60
  - Rating: 90
  - Contribution: 90 × 60 = 5400

Total Weight: 100 + 60 = 160
Total Contribution: 8500 + 5400 = 13900

Overall Rating: 13900 / 160 = 86.875
```

### Implementation

```php
public function calculateOverallRating($reviewId)
{
    $kpiRatings = DB::table('performance_review_kpis')
        ->join('kpis', 'performance_review_kpis.kpi_id', '=', 'kpis.id')
        ->where('performance_review_kpis.performance_review_id', $reviewId)
        ->where('kpis.is_active', 1)
        ->select(
            'performance_review_kpis.rating',
            'kpis.weight'
        )
        ->get();

    if ($kpiRatings->isEmpty()) {
        return null;
    }

    $totalWeight = 0;
    $weightedSum = 0;

    foreach ($kpiRatings as $kpi) {
        if ($kpi->rating !== null) {
            $totalWeight += $kpi->weight;
            $weightedSum += ($kpi->rating * $kpi->weight);
        }
    }

    if ($totalWeight == 0) {
        return null;
    }

    return round($weightedSum / $totalWeight, 2);
}
```

---

## STEP 7: STATUS WORKFLOW

### Status Flow Diagram

```
not_started
    ↓
in_progress (Employee self-evaluation OR Reviewer starts)
    ↓
submitted (Employee submits OR Reviewer completes)
    ↓
completed (All KPIs rated, overall calculated)
    ↓
approved (HOD/HR approves)
    ↓
closed (Optional - after appraisal)
```

### Status Transitions

| From | To | Who | Action |
|------|-----|-----|--------|
| not_started | in_progress | Employee/Reviewer | Start review |
| in_progress | submitted | Employee | Submit self-eval |
| in_progress | completed | Reviewer | Complete rating |
| submitted | completed | Reviewer | Rate KPIs |
| completed | approved | HOD/HR | Approve review |
| completed | rejected | HOD/HR | Reject with reason |
| rejected | in_progress | Reviewer | Make changes |
| approved | closed | HR | Close after appraisal |

---

## STEP 8: ROLE-BASED FLOW

### Employee Role

**Can See:**
- My Trackers (own reviews)
- My Reviews (own reviews)
- KPI list (read-only)

**Can Do:**
- View assigned reviews
- Self-evaluate on KPIs (if enabled)
- Submit self-evaluation
- View final rating after approval

**Cannot:**
- Create reviews
- Rate others
- Approve reviews
- Edit KPIs

---

### Manager/Reviewer Role

**Can See:**
- Employee Trackers (team members)
- Employee Reviews (team members)
- Assigned reviews (where reviewer_id = self)

**Can Do:**
- Rate employees on KPIs
- Add comments per KPI
- Complete review (calculate overall rating)
- View all team reviews

**Cannot:**
- Approve reviews
- Create cycles
- Edit KPIs

---

### HOD (Head of Department) Role

**Can See:**
- All reviews in department
- Employee Reviews
- Manage Reviews

**Can Do:**
- Approve reviews
- Reject reviews with reason
- View all department reviews
- Override ratings (if permission)

**Cannot:**
- Create cycles
- Edit KPIs

---

### HR Role

**Can See:**
- All reviews
- All trackers
- KPIs
- Cycles

**Can Do:**
- Create/edit KPIs
- Create/edit cycles
- Create reviews (assign trackers)
- Assign reviewers
- Approve reviews
- Close reviews
- Create appraisals

---

### Admin Role

**Can See:**
- Everything

**Can Do:**
- Everything
- System configuration
- User management

---

## STEP 9: IMPLEMENTATION PRIORITY

### Phase 1: Critical Fixes (Do First)

1. ✅ Fix status enum consistency
2. ✅ Implement `performance_review_kpis` CRUD
3. ✅ Add overall rating calculation
4. ✅ Fix reviewer assignment workflow
5. ✅ Add missing columns to UI

### Phase 2: Workflow Implementation

1. ✅ Add KPI rating form
2. ✅ Implement status transitions
3. ✅ Add approval workflow
4. ✅ Add rejection workflow

### Phase 3: Enhancements

1. ✅ Add self-evaluation
2. ✅ Add appraisal linking
3. ✅ Add reporting
4. ✅ Add notifications

---

## STEP 10: FILES TO CREATE/MODIFY

### New Files Needed

1. `app/Models/PerformanceReview.php` - Model
2. `app/Models/PerformanceReviewKpi.php` - Model
3. `app/Models/Kpi.php` - Model
4. `app/Models/PerformanceCycle.php` - Model
5. `app/Services/PerformanceRatingService.php` - Calculation logic
6. `database/migrations/xxxx_add_performance_workflow_fields.php` - Migration

### Files to Modify

1. `app/Http/Controllers/PerformanceController.php` - Add KPI rating methods
2. `resources/views/performance/trackers.blade.php` - Add KPI section
3. `resources/views/performance/performance.blade.php` - Add KPI section
4. All other performance views - Add missing fields

---

## NEXT STEPS

1. Review this analysis
2. Approve database changes
3. Implement Phase 1 fixes
4. Test workflow
5. Implement Phase 2
6. User acceptance testing

---

**Document Version:** 1.0  
**Date:** 2026-02-13  
**Status:** Ready for Implementation

