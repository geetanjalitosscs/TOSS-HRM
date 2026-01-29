# PIM Module CRUD Flow Documentation

## Overview
This document explains the complete flow of how CRUD (Create, Read, Update, Delete) operations are implemented across all PIM (Personal Information Management) pages, including the logic, database operations, and patterns used.

---

## Table of Contents
1. [Architecture Pattern](#architecture-pattern)
2. [Routes Configuration](#routes-configuration)
3. [Controller Methods](#controller-methods)
4. [View Structure](#view-structure)
5. [JavaScript Functionality](#javascript-functionality)
6. [Database Operations](#database-operations)
7. [Page-by-Page Examples](#page-by-page-examples)

---

## Architecture Pattern

### Standard CRUD Pattern Used:
```
User Action → Route → Controller Method → Database Operation → Redirect with Status → View Update
```

### Key Components:
1. **Routes** (`routes/web.php`) - Define HTTP endpoints
2. **Controller** (`app/Http/Controllers/PIMController.php`) - Business logic & DB operations
3. **Views** (`resources/views/pim/*.blade.php`) - UI & JavaScript
4. **Database Tables** - Data storage

---

## Routes Configuration

### Route Types Used:

#### 1. GET Routes (Display Pages)
```php
Route::get('/pim/configuration/reporting-methods', [PIMController::class, 'reportingMethods'])
    ->name('pim.configuration.reporting-methods');
```
- **Purpose**: Display list page with data
- **Returns**: View with data

#### 2. POST Routes (Create)
```php
Route::post('/pim/configuration/reporting-methods', [PIMController::class, 'storeReportingMethod'])
    ->name('pim.configuration.reporting-methods.store');
```
- **Purpose**: Create new record
- **Returns**: Redirect with success message

#### 3. POST Routes (Update)
```php
Route::post('/pim/configuration/reporting-methods/{id}', [PIMController::class, 'updateReportingMethod'])
    ->whereNumber('id')
    ->name('pim.configuration.reporting-methods.update');
```
- **Purpose**: Update existing record
- **Parameter**: `{id}` - Record ID
- **Returns**: Redirect with success message

#### 4. POST Routes (Delete Single)
```php
Route::post('/pim/configuration/reporting-methods/{id}/delete', [PIMController::class, 'deleteReportingMethod'])
    ->whereNumber('id')
    ->name('pim.configuration.reporting-methods.delete');
```
- **Purpose**: Delete single record
- **Returns**: Redirect with success message

#### 5. POST Routes (Bulk Delete)
```php
Route::post('/pim/configuration/reporting-methods/bulk-delete', [PIMController::class, 'bulkDeleteReportingMethods'])
    ->name('pim.configuration.reporting-methods.bulk-delete');
```
- **Purpose**: Delete multiple records
- **Input**: Comma-separated IDs in request body
- **Returns**: Redirect with success message

---

## Controller Methods

### 1. Index/List Method (GET)

**Pattern:**
```php
public function reportingMethods()
{
    // Build query
    $query = DB::table('reporting_methods')
        ->select('id', 'name', 'description')
        ->where('is_active', 1)
        ->orderByDesc('id'); // Newest first
    
    // Apply search filters if needed
    if ($request->filled('search_field')) {
        $query->where('name', 'like', "%{$request->input('search_field')}%");
    }
    
    // Execute query
    $reportingMethods = $query->get();
    
    // Return view with data
    return view('pim.configuration.reporting-methods', [
        'reportingMethods' => $reportingMethods,
        // ... other data
    ]);
}
```

**Key Points:**
- Uses `DB::table()` for direct database queries
- Applies filters/search conditions
- Orders by `id DESC` to show newest records first
- Returns view with compacted data

---

### 2. Store Method (POST - Create)

**Pattern:**
```php
public function storeReportingMethod(Request $request)
{
    // 1. Validate input
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string', 'max:255'],
    ]);
    
    // 2. Prepare insert data
    $payload = [
        'name' => $data['name'],
        'description' => $data['description'] ?? null,
        'is_active' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ];
    
    // 3. Insert into database
    DB::table('reporting_methods')->insert($payload);
    
    // 4. Redirect with success message
    return redirect()->route('pim.configuration.reporting-methods')
        ->with('status', 'Reporting method added.');
}
```

**Key Points:**
- Validates input using Laravel's validation rules
- Uses `??` null coalescing for optional fields
- Sets timestamps manually (`created_at`, `updated_at`)
- Redirects with session flash message

---

### 3. Update Method (POST - Update)

**Pattern:**
```php
public function updateReportingMethod(Request $request, int $id)
{
    // 1. Validate input
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string', 'max:255'],
    ]);
    
    // 2. Prepare update data
    $payload = [
        'name' => $data['name'],
        'description' => $data['description'] ?? null,
        'updated_at' => now(),
    ];
    
    // 3. Update database
    DB::table('reporting_methods')
        ->where('id', $id)
        ->update($payload);
    
    // 4. Redirect with success message
    return redirect()->route('pim.configuration.reporting-methods')
        ->with('status', 'Reporting method updated.');
}
```

**Key Points:**
- Uses route model binding (`int $id`)
- Only updates `updated_at` (not `created_at`)
- Uses `where('id', $id)` to target specific record

---

### 4. Delete Method (POST - Delete Single)

**Pattern:**
```php
public function deleteReportingMethod(int $id)
{
    // Direct delete from database
    DB::table('reporting_methods')
        ->where('id', $id)
        ->delete();
    
    // Redirect with success message
    return redirect()->route('pim.configuration.reporting-methods')
        ->with('status', 'Reporting method deleted.');
}
```

**Key Points:**
- Hard delete (permanently removes from DB)
- Simple `where()->delete()` pattern
- No soft delete used (unlike employees which use status updates)

---

### 5. Bulk Delete Method (POST - Delete Multiple)

**Pattern:**
```php
public function bulkDeleteReportingMethods(Request $request)
{
    // 1. Parse comma-separated IDs
    $idsParam = $request->input('ids', '');
    $ids = collect(explode(',', $idsParam))
        ->map(fn ($v) => (int) trim($v))  // Convert to integers
        ->filter(fn ($v) => $v > 0)        // Remove invalid IDs
        ->unique()                          // Remove duplicates
        ->values()                          // Re-index array
        ->all();
    
    // 2. Delete if IDs exist
    if (!empty($ids)) {
        DB::table('reporting_methods')
            ->whereIn('id', $ids)
            ->delete();
    }
    
    // 3. Redirect with success message
    return redirect()->route('pim.configuration.reporting-methods')
        ->with('status', 'Selected reporting methods deleted.');
}
```

**Key Points:**
- Uses Laravel Collections for ID processing
- Validates and sanitizes input IDs
- Uses `whereIn()` for multiple record deletion
- Handles empty arrays gracefully

---

## View Structure

### Standard View Pattern:

```blade
@extends('layouts.app')

@section('body')
    <x-main-layout title="PIM">
        <!-- Tabs Navigation -->
        <x-pim.tabs activeTab="configuration-reporting-methods" />
        
        <!-- Main Section -->
        <section class="hr-card p-6">
            <!-- Header with Add Button -->
            <div class="flex items-center justify-between">
                <h2>Title</h2>
                <x-admin.add-button onClick="openAddModal()" />
            </div>
            
            <!-- Search Form -->
            <form method="GET" action="{{ route('page.route') }}">
                <input name="search_field" value="{{ request('search_field') }}">
                <x-admin.action-buttons resetType="reset" searchType="submit" />
            </form>
            
            <!-- Table -->
            <div id="table-container">
                <div class="hr-table-wrapper">
                    <!-- Table Header with Checkbox -->
                    <div class="table-header">
                        <input type="checkbox" id="master-checkbox">
                        <!-- Column Headers -->
                    </div>
                    
                    <!-- Table Rows -->
                    <div class="table-rows">
                        @foreach($records as $record)
                            <div class="table-row" data-record-id="{{ $record->id }}">
                                <input type="checkbox" class="row-checkbox">
                                <!-- Row Data -->
                                <!-- Action Buttons -->
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Modals: Add, Edit, Delete, Bulk Delete -->
        <!-- JavaScript -->
    </x-main-layout>
@endsection
```

---

## JavaScript Functionality

### 1. Modal Management

**Pattern:**
```javascript
// Open Modal
function openAddModal() {
    var m = document.getElementById('add-modal');
    if (m) m.classList.remove('hidden');
}
window.openAddModal = openAddModal; // Make globally accessible

// Close Modal
function closeAddModal(reset) {
    var m = document.getElementById('add-modal');
    if (m) m.classList.add('hidden');
    if (reset) {
        var form = m ? m.querySelector('form') : null;
        if (form) form.reset();
    }
}
window.closeAddModal = closeAddModal;
```

**Key Points:**
- Uses `hidden` class for show/hide
- Optionally resets form on close
- Exposes functions globally via `window`

---

### 2. Edit Modal Population

**Pattern:**
```javascript
function openEditModalFromRow(row) {
    // 1. Extract data from row's data attributes
    var info = row.querySelector('[data-record-id]');
    if (!info) return;
    
    var id = info.dataset.recordId;
    var name = info.dataset.recordName || '';
    var description = info.dataset.recordDescription || '';
    
    // 2. Populate form fields
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-description').value = description;
    
    // 3. Set form action URL
    var form = document.getElementById('edit-form');
    if (form) {
        form.action = editUrlTemplate.replace('__ID__', id);
    }
    
    // 4. Show modal
    var m = document.getElementById('edit-modal');
    if (m) m.classList.remove('hidden');
}
```

**Key Points:**
- Uses `data-*` attributes to store row data
- Dynamically updates form action URL
- Pre-fills form fields with existing data

---

### 3. Delete Confirmation

**Pattern:**
```javascript
var pendingDeleteId = null;

function openDeleteModalFromRow(row) {
    var info = row.querySelector('[data-record-id]');
    if (!info) return;
    pendingDeleteId = info.dataset.recordId;
    var m = document.getElementById('delete-modal');
    if (m) m.classList.remove('hidden');
}

function confirmDelete() {
    if (!pendingDeleteId) return;
    
    var form = document.getElementById('delete-form');
    if (!form) return;
    
    form.action = deleteUrlTemplate.replace('__ID__', pendingDeleteId);
    form.submit();
}
```

**Key Points:**
- Stores ID in variable before showing modal
- Uses hidden form for submission
- Updates form action dynamically

---

### 4. Checkbox Management

**Pattern:**
```javascript
function refreshSelectionState() {
    var table = document.getElementById('table-container');
    if (!table) return;
    
    var headerCheckbox = document.getElementById('master-checkbox');
    var rowCheckboxes = table.querySelectorAll('.row-checkbox');
    var deleteSelectedBtn = document.getElementById('delete-selected');
    
    // Count checked rows
    var checkedCount = 0;
    rowCheckboxes.forEach(function (cb) {
        if (cb.checked) checkedCount++;
    });
    
    // Show/hide delete button
    if (deleteSelectedBtn) {
        deleteSelectedBtn.classList.toggle('hidden', checkedCount === 0);
    }
    
    // Update header checkbox state
    if (headerCheckbox) {
        if (checkedCount === 0) {
            headerCheckbox.checked = false;
        } else if (checkedCount === rowCheckboxes.length) {
            headerCheckbox.checked = true;
        } else {
            headerCheckbox.checked = false;
        }
        headerCheckbox.indeterminate = false; // Never show "-" state
    }
}

// Header checkbox click handler
headerCheckbox.addEventListener('change', function () {
    var rowCheckboxes = table.querySelectorAll('.row-checkbox');
    rowCheckboxes.forEach(function (cb) {
        cb.checked = headerCheckbox.checked;
    });
    refreshSelectionState();
});
```

**Key Points:**
- Header checkbox controls all rows
- Delete button appears when any row is checked
- Header shows checked only when ALL rows checked
- No indeterminate state ("-") shown

---

### 5. Bulk Delete

**Pattern:**
```javascript
function confirmBulkDelete() {
    var table = document.getElementById('table-container');
    if (!table) return;
    
    // Collect checked checkbox IDs
    var checked = table.querySelectorAll('.row-checkbox:checked');
    var ids = [];
    checked.forEach(function (cb) {
        var row = cb.closest('.table-row');
        if (!row) return;
        var info = row.querySelector('[data-record-id]');
        if (info && info.dataset.recordId) {
            ids.push(info.dataset.recordId);
        }
    });
    
    if (!ids.length) return;
    
    // Submit form with comma-separated IDs
    var form = document.getElementById('bulk-delete-form');
    var input = document.getElementById('bulk-delete-ids');
    if (!form || !input) return;
    
    input.value = ids.join(',');
    form.submit();
}
```

**Key Points:**
- Collects IDs from checked checkboxes
- Joins IDs with commas
- Submits via hidden form field

---

### 6. Reset Button

**Pattern:**
```javascript
var resetBtn = document.querySelector('#search-form button[type="reset"]');
if (resetBtn) {
    resetBtn.addEventListener('click', function(e) {
        e.preventDefault();
        var form = document.getElementById('search-form');
        if (form) {
            form.querySelector('input[name="search_field"]').value = '';
            window.location.href = '{{ route("page.route") }}';
        }
    });
}
```

**Key Points:**
- Prevents default form reset
- Clears search fields manually
- Redirects to clean URL (removes query parameters)

---

## Database Operations

### Query Builder Pattern Used:

```php
// SELECT with filters
DB::table('table_name')
    ->select('id', 'name', 'description')
    ->where('is_active', 1)
    ->where('name', 'like', "%search%")
    ->orderByDesc('id')
    ->get();

// INSERT
DB::table('table_name')->insert([
    'field1' => 'value1',
    'field2' => 'value2',
    'created_at' => now(),
    'updated_at' => now(),
]);

// UPDATE
DB::table('table_name')
    ->where('id', $id)
    ->update([
        'field1' => 'new_value',
        'updated_at' => now(),
    ]);

// DELETE (Single)
DB::table('table_name')
    ->where('id', $id)
    ->delete();

// DELETE (Multiple)
DB::table('table_name')
    ->whereIn('id', $ids)
    ->delete();
```

---

## Page-by-Page Examples

### 1. Reporting Methods Page

**Table:** `reporting_methods`
**Fields:** `id`, `name`, `description`, `is_active`, `created_at`, `updated_at`

**Routes:**
- GET: `/pim/configuration/reporting-methods`
- POST: `/pim/configuration/reporting-methods` (store)
- POST: `/pim/configuration/reporting-methods/{id}` (update)
- POST: `/pim/configuration/reporting-methods/{id}/delete` (delete)
- POST: `/pim/configuration/reporting-methods/bulk-delete` (bulk delete)

**Controller Methods:**
- `reportingMethods()` - List with search
- `storeReportingMethod()` - Create
- `updateReportingMethod()` - Update
- `deleteReportingMethod()` - Delete single
- `bulkDeleteReportingMethods()` - Delete multiple

---

### 2. Termination Reasons Page

**Table:** `termination_reasons`
**Fields:** `id`, `name`, `description`, `is_active`, `created_at`, `updated_at`

**Same pattern as Reporting Methods**

---

### 3. Custom Fields Page

**Table:** `custom_fields`
**Fields:** `id`, `name`, `label`, `module`, `data_type`, `is_required`, `is_active`, `sort_order`, `created_at`, `updated_at`

**Special Features:**
- Enum field type detection
- Module/screen field
- Remaining fields count calculation

---

### 4. Reports Page

**Table:** `reports`
**Fields:** `id`, `name`, `description`, `type`, `created_at`, `updated_at`

**Special Features:**
- Copy button functionality
- Type enum (education, skill, language, certification, other)
- Toast notification on copy

---

### 5. Employee List Page

**Table:** `employees`
**Fields:** Multiple (id, employee_number, first_name, last_name, job_title_id, employment_status_id, etc.)

**Special Features:**
- Soft delete (status = 'terminated')
- Photo upload handling
- Search across multiple fields
- Scroll to section after operations

---

## Complete Request Flow Example

### Creating a New Record:

1. **User clicks "Add" button**
   ```javascript
   onClick="openAddModal()"
   ```

2. **Modal opens, user fills form and submits**
   ```html
   <form method="POST" action="{{ route('pim.configuration.reporting-methods.store') }}">
       @csrf
       <input name="name" required>
       <button type="submit">Save</button>
   </form>
   ```

3. **Request goes to route**
   ```
   POST /pim/configuration/reporting-methods
   ```

4. **Route calls controller**
   ```php
   Route::post('/pim/configuration/reporting-methods', [PIMController::class, 'storeReportingMethod'])
   ```

5. **Controller validates and inserts**
   ```php
   $data = $request->validate([...]);
   DB::table('reporting_methods')->insert([...]);
   ```

6. **Redirect with success message**
   ```php
   return redirect()->route('pim.configuration.reporting-methods')
       ->with('status', 'Reporting method added.');
   ```

7. **Page reloads, shows new record at top (ordered by id DESC)**

---

## Key Design Decisions

1. **Hard Delete vs Soft Delete:**
   - Configuration pages (reporting-methods, termination-reasons, custom-fields, reports): Hard delete
   - Employee List: Soft delete (status update)

2. **Ordering:**
   - All list pages order by `id DESC` to show newest first

3. **Search:**
   - GET request with query parameters
   - Preserves search state in form inputs
   - Reset button clears and redirects

4. **Modals:**
   - All CRUD operations use modals (no page redirects for forms)
   - Only redirect after successful submission

5. **Checkboxes:**
   - Header checkbox selects all
   - Individual checkboxes update header state
   - Delete Selected button appears when any checked

6. **Validation:**
   - Server-side validation in controller
   - Required fields marked with `*` in UI
   - Validation errors shown via redirect with errors

---

## Security Considerations

1. **CSRF Protection:**
   - All POST requests include `@csrf` token

2. **Input Validation:**
   - All inputs validated using Laravel's validation rules
   - SQL injection prevented via Query Builder (parameterized queries)

3. **Route Protection:**
   - All routes wrapped in `auth.session` middleware

4. **ID Validation:**
   - Route model binding with `whereNumber('id')`
   - Bulk delete IDs sanitized (filtered, cast to int)

---

## Testing Checklist

For each CRUD page, verify:
- [ ] List page displays all records
- [ ] Search filters records correctly
- [ ] Reset button clears search
- [ ] Add button opens modal
- [ ] Add form validates required fields
- [ ] New record appears at top after add
- [ ] Edit button opens modal with pre-filled data
- [ ] Update saves changes correctly
- [ ] Delete button shows confirmation modal
- [ ] Delete removes record from DB
- [ ] Checkbox selects individual row
- [ ] Header checkbox selects all rows
- [ ] Delete Selected button appears when checked
- [ ] Bulk delete removes all selected records
- [ ] Copy button copies data (if applicable)
- [ ] Scroll to section works (if applicable)

---

## Summary

The PIM module follows a consistent CRUD pattern across all pages:

1. **Routes** define HTTP endpoints with named routes
2. **Controllers** handle business logic and database operations
3. **Views** provide UI and client-side JavaScript
4. **Database** stores data using Laravel Query Builder
5. **JavaScript** manages modals, checkboxes, and user interactions

This pattern ensures consistency, maintainability, and scalability across all PIM configuration and management pages.

