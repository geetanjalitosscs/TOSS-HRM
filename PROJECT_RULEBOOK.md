# TOAI HRM Suite – Professional Edition
## Project Rulebook & Development Guidelines

**Version:** 1.1  
**Last Updated:** January 27, 2026  
**Status:** MANDATORY GOVERNANCE DOCUMENT

---

## SECTION 1: PRODUCT IDENTITY

### 1.1 Product Type
**TOAI HRM Suite – Professional Edition** is an **Enterprise HR SaaS Application** designed for professional organizations requiring comprehensive human resource management capabilities.

### 1.2 Quality Benchmark
This application must meet or exceed the quality standards of industry-leading HR platforms:

- **Workday** (enterprise-grade reliability)
- **SAP SuccessFactors** (professional polish)

### 1.3 Design Philosophy
The application follows a **clean, professional, calm, and premium** design philosophy:
- **Clean:** Uncluttered interfaces with clear visual hierarchy
- **Professional:** Enterprise-appropriate styling, no flashy elements
- **Calm:** Subtle interactions, no jarring animations
- **Premium:** High-quality visual details, consistent spacing, polished interactions

### 1.4 Project Classification

**❌ This is NOT:**
- A demo project
- A basic admin panel
- A prototype or proof-of-concept
- A learning exercise

**✅ This IS:**
- A production-grade enterprise system
- A professional SaaS application
- A long-term maintained product
- A system requiring enterprise-level quality standards

### 1.5 Data & Database Requirements

- All features must be backed by **real, normalized MySQL data**, never hardcoded dummy data in views.
- The authoritative schema lives in `db.sql` (utf8mb4, InnoDB, foreign keys, indexes) and must be kept in sync with models and migrations.
- Every page, table, filter, and report visible in the UI must have a corresponding table / relation in the database.
- Schema design must follow at least **3NF**, with audit fields (`created_at`, `updated_at`, `deleted_at` where needed) and proper indexing for search and reporting.

---

## SECTION 2: UI DESIGN RULES (VERY STRICT)

### 2.1 Color System

**MANDATORY:** Use ONLY existing CSS theme tokens. Never hardcode colors.

#### Light Theme Tokens:
```css
--color-hr-primary: #8B5CF6
--color-hr-primary-dark: #6D28D9
--color-hr-primary-soft: #A78BFA
--color-hr-primary-light: #F5F3FF
--bg-main: #F5F3FF
--bg-card: #FFFFFF
--bg-hover: rgba(139, 92, 246, 0.05)
--text-primary: #1E293B
--text-muted: #64748B
--border-default: rgba(139, 92, 246, 0.1)
```

#### Dark Theme Tokens:
```css
--bg-main: #0F172A
--bg-card: #1F2937
--bg-hover: rgba(139, 92, 246, 0.1)
--text-primary: #E5E7EB
--text-muted: #9CA3AF
--border-default: #334155
```

**FORBIDDEN:**
- ❌ Hardcoded colors (e.g., `#FFFFFF`, `rgb(255,255,255)`, `bg-white`)
- ❌ Tailwind color classes without theme variables (`text-gray-700`, `bg-purple-50`)
- ❌ Inline color styles that don't use CSS variables
- ❌ Mixed color systems (some theme tokens, some hardcoded)

**REQUIRED:**
- ✅ All colors must use CSS variables
- ✅ All components must adapt to dark mode automatically
- ✅ Colors must be defined in `resources/css/app.css` theme section

### 2.2 Typography

**Font Family:** Inter (system fallback: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif)

**Font Sizes:**
- Page Titles: `text-xl` (1.25rem) / `font-semibold`
- Section Headers: `text-sm` (0.875rem) / `font-bold`
- Body Text: `text-xs` (0.75rem) / `font-medium`
- Labels: `text-xs` (0.75rem) / `font-medium`
- Table Headers: `text-xs` (0.75rem) / `font-semibold uppercase tracking-wide`

**Font Weights:**
- Bold: `font-bold` (600) - for titles and important labels
- Semibold: `font-semibold` (600) - for section headers
- Medium: `font-medium` (500) - for body text and labels
- Regular: `font-normal` (400) - avoid unless necessary

**FORBIDDEN:**
- ❌ Random font sizes
- ❌ Inconsistent font weights
- ❌ Mixed typography hierarchies

### 2.3 Cards & Containers

**Standard Card:**
- Background: `var(--bg-card)`
- Border: `1px solid var(--border-default)`
- Border Radius: `0.5rem` (rounded-lg)
- Shadow: `0 1px 3px 0 var(--shadow-sm)`
- Padding: `p-4` (1rem)

**Card Hover (if interactive):**
- Shadow: `0 10px 15px -3px var(--shadow-lg)`
- Transform: `translateY(-2px)`
- Border Color: `var(--border-strong)`
- Transition: `all 0.3s cubic-bezier(0.4, 0, 0.2, 1)`

**FORBIDDEN:**
- ❌ Inconsistent border radius
- ❌ Hardcoded white backgrounds
- ❌ Missing shadows on elevated elements
- ❌ Cards that don't adapt to dark mode

### 2.4 Buttons

#### Primary Buttons (`.hr-btn-primary`)
- Background: `linear-gradient(to right, var(--color-hr-primary), var(--color-hr-primary-dark))`
- Color: `white`
- Padding: `0.5rem 1rem` (px-4 py-2)
- Border Radius: `0.5rem` (rounded-lg)
- Font Weight: `600` (font-semibold)
- Shadow: `0 2px 4px rgba(139, 92, 246, 0.2)`
- Transition: `all 0.2s cubic-bezier(0.4, 0, 0.2, 1)`

**Hover State:**
- Shadow: `0 4px 8px rgba(139, 92, 246, 0.3), 0 2px 4px rgba(139, 92, 246, 0.2)`
- Transform: `translateY(-1px)`
- Background: `linear-gradient(to right, var(--color-hr-primary-dark), var(--color-hr-primary))`

**Active State:**
- Transform: `translateY(0)`
- Shadow: `0 2px 4px rgba(139, 92, 246, 0.2)`

**Focus State:**
- Outline: `2px solid var(--color-hr-primary-light)`
- Outline Offset: `2px`

#### Secondary Buttons (`.hr-btn-secondary`)
- Background: `var(--bg-card)`
- Color: `var(--text-primary)`
- Border: `1px solid var(--border-default)`
- Padding: `0.5rem 1rem`
- Border Radius: `0.5rem`
- Font Weight: `500` (font-medium)
- Shadow: `0 1px 2px rgba(0, 0, 0, 0.05)`
- Transition: `all 0.2s cubic-bezier(0.4, 0, 0.2, 1)`

**Hover State:**
- Background: `var(--bg-hover)`
- Border Color: `var(--border-strong)`
- Shadow: `0 2px 4px rgba(0, 0, 0, 0.1)`
- Transform: `translateY(-1px)`

**FORBIDDEN:**
- ❌ Oversized buttons (unless explicitly required)
- ❌ Inconsistent button styles
- ❌ Missing hover states
- ❌ Flashy animations (scale, rotate, etc.)
- ❌ Hardcoded button colors
- ❌ Duplicate button classes

**REQUIRED:**
- ✅ All buttons must use `.hr-btn-primary` or `.hr-btn-secondary`
- ✅ Buttons must have smooth transitions
- ✅ Buttons must have focus states for accessibility
- ✅ Button text must be clear and action-oriented

### 2.5 Tables

**Table Header:**
- Background: `var(--bg-hover)`
- Border: `1px solid var(--border-default)`
- Padding: `px-2 py-1.5`
- Font: `text-xs font-semibold uppercase tracking-wide`
- Color: `var(--text-primary)`

**Table Rows:**
- Background: `var(--bg-card)` (default), `var(--bg-hover)` (on hover)
- Border: `1px solid var(--border-default)`
- Padding: `px-2 py-1.5`
- Transition: `all 0.2s ease`

**Table Cells:**
- Font: `text-xs`
- Color: `var(--text-primary)`
- Padding: Consistent with row padding

**Action Buttons in Tables:**
- Delete: `.hr-action-delete` (red hover)
- Edit: `.hr-action-edit` (purple hover)
- Size: `w-4 h-4` icons, `p-0.5` padding
- Spacing: `gap-1` between buttons

**FORBIDDEN:**
- ❌ Duplicate action buttons (only one set per row)
- ❌ Inconsistent row heights
- ❌ Misaligned columns
- ❌ Hardcoded table colors
- ❌ Missing hover states on rows
- ❌ Cluttered action columns

### 2.6 Forms

**Form Fields:**
- Label: `text-xs font-medium`, color: `var(--text-primary)`
- Input: `border border-purple-200 rounded-lg`, background: `var(--bg-input)`
- Focus: `focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)]`
- Padding: `px-2 py-1.5` (small), `px-3 py-2` (standard)
- Font Size: `text-xs` (small), `text-sm` (standard)

**Required Field Indicator:**
- Red asterisk: `<span class="text-red-500">*</span>`
- Must appear after label text

**Form Sections:**
- Spacing: `gap-4` or `gap-6` between fields
- Grid: `grid grid-cols-1 md:grid-cols-2` for two-column layouts
- Section Title: `text-sm font-bold`, color: `var(--text-primary)`

**FORBIDDEN:**
- ❌ Inconsistent input sizes
- ❌ Missing focus states
- ❌ Unlabeled inputs
- ❌ Inconsistent spacing
- ❌ Forms that don't adapt to dark mode

### 2.7 Dropdowns & Modals

**Dropdowns:**
- Background: `var(--bg-card)`
- Border: `1px solid var(--border-default)`
- Shadow: `0 10px 15px -3px var(--shadow-lg)`
- Border Radius: `0.5rem`
- Z-index: `9999` or higher for portal-based dropdowns
- Position: `absolute` or `fixed` (portal-based)

**Modals:**
- Background: `var(--bg-card)`
- Border: `1px solid var(--border-default)`
- Shadow: `0 20px 25px -5px var(--shadow-lg)`
- Border Radius: `0.75rem`
- Backdrop: Semi-transparent overlay
- Z-index: `99999`

**FORBIDDEN:**
- ❌ Dropdowns that scroll with content (must be portal-based)
- ❌ Modals without backdrop
- ❌ Inconsistent z-index values
- ❌ Dropdowns clipped by parent overflow

### 2.8 Visual Consistency Rules

**Every UI element must:**
- ✅ Use theme variables for colors
- ✅ Have consistent spacing (multiples of 0.25rem)
- ✅ Have proper hover states
- ✅ Have focus states for accessibility
- ✅ Adapt to dark mode
- ✅ Follow the established visual hierarchy

**FORBIDDEN:**
- ❌ Oversized buttons
- ❌ Duplicate edit/delete icons
- ❌ Inconsistent hover styles
- ❌ Uneven padding or misalignment
- ❌ Visual noise (unnecessary icons, decorations)
- ❌ Random spacing values
- ❌ Mixed icon sizes
- ❌ Inconsistent border radius

---

## SECTION 3: DARK MODE RULES (MANDATORY)

### 3.1 First-Class Feature

**Dark mode is MANDATORY, not optional.** Every component, page, and feature must fully support dark mode.

### 3.2 Implementation Requirements

**All components MUST:**
- ✅ Use CSS theme variables exclusively
- ✅ Test in both light and dark modes
- ✅ Maintain proper contrast ratios
- ✅ Preserve readability in both themes
- ✅ Adapt backgrounds, borders, and text colors automatically

### 3.3 Theme Variables Usage

**NEVER hardcode colors. ALWAYS use:**
- `var(--bg-main)` for page backgrounds
- `var(--bg-card)` for card backgrounds
- `var(--bg-hover)` for hover states
- `var(--text-primary)` for primary text
- `var(--text-muted)` for secondary text
- `var(--border-default)` for borders

### 3.4 Dark Mode Testing Checklist

Before submitting any feature, verify:
- ✅ No white/light background leaks
- ✅ All cards adapt correctly
- ✅ All tables are readable
- ✅ All modals work in dark mode
- ✅ All dropdowns are visible
- ✅ All forms are usable
- ✅ All buttons are visible
- ✅ Text contrast is sufficient

### 3.5 Invalid Features

**Any feature that breaks dark mode is considered INVALID and must be rejected.**

Common dark mode violations:
- ❌ Hardcoded white backgrounds
- ❌ Hardcoded dark text on dark backgrounds
- ❌ Missing theme variable usage
- ❌ Components that only work in light mode

---

## SECTION 4: LAYOUT & STRUCTURE RULES

### 4.1 Sidebar

**Structure:**
- Fixed position: `position: fixed`
- Width: `18rem` (288px) when expanded
- Background: `var(--bg-elevated)`
- Border: Right border `1px solid var(--border-default)`
- Z-index: `30`

**FORBIDDEN:**
- ❌ Structural changes to sidebar
- ❌ Changing sidebar width
- ❌ Removing sidebar collapse functionality
- ❌ Modifying sidebar navigation structure

### 4.2 Header

**Structure:**
- Fixed position: `position: sticky` or `fixed`
- Height: Consistent across all pages
- Background: `var(--bg-elevated)`
- Border: Bottom border `1px solid var(--border-default)`
- Z-index: `40`

**FORBIDDEN:**
- ❌ Repositioning header elements
- ❌ Resizing header
- ❌ Changing header layout
- ❌ Removing header functionality

### 4.3 Content Area

**Structure:**
- Padding: Consistent `p-4` or `p-6`
- Background: `var(--bg-main)`
- Max-width: As per design requirements
- Margin: Adjusted for sidebar width

**FORBIDDEN:**
- ❌ Breaking layout with content
- ❌ Creating horizontal scroll (unless explicitly required)
- ❌ Layout shifts on interaction
- ❌ Inconsistent padding

### 4.4 Sticky Tabs

**Structure:**
- Position: `sticky` at top of content
- Background: `var(--bg-card)` or `var(--bg-elevated)`
- Border: Bottom border for active state
- Z-index: Appropriate for sticky behavior

**Behavior:**
- Must remain visible when scrolling
- Active tab must be clearly indicated
- Hover states must be consistent

**FORBIDDEN:**
- ❌ Tabs that don't stick
- ❌ Inconsistent tab styling
- ❌ Missing active states

---

## SECTION 5: COMPONENT ARCHITECTURE

### 5.1 Reusable Components Policy

**MANDATORY:** Every new feature MUST reuse existing components or extend them cleanly.

### 5.2 Available Components

**Admin Components:**
- `x-admin.tabs` - Tab navigation
- `x-admin.data-table` - Data table with header
- `x-admin.table-row` - Table row wrapper
- `x-admin.table-cell` - Table cell wrapper
- `x-admin.form-section` - Form section with edit toggle
- `x-admin.form-field` - Form input field
- `x-admin.search-panel` - Collapsible search panel
- `x-admin.color-picker` - Color picker component

**PIM Components:**
- `x-pim.tabs` - PIM-specific tab navigation

**Recruitment Components:**
- `x-recruitment.tabs` - Recruitment-specific tab navigation

**Shared Components:**
- `x-dropdown-menu` - Reusable dropdown menu
- `x-main-layout` - Main page layout wrapper

### 5.3 Component Usage Rules

**REQUIRED:**
- ✅ Use existing components whenever possible
- ✅ Extend components rather than duplicating
- ✅ Pass props correctly to components
- ✅ Follow component API conventions

**FORBIDDEN:**
- ❌ Creating duplicate UI logic
- ❌ Copy-pasting UI blocks
- ❌ Building new components when existing ones work
- ❌ Modifying core components without approval
- ❌ Breaking component APIs

### 5.4 Creating New Components

**When creating a new component:**
1. Check if existing components can be extended
2. Follow existing component patterns
3. Use theme variables exclusively
4. Support dark mode
5. Document component props and usage
6. Place in appropriate directory (`resources/views/components/`)

---

## SECTION 6: MVC & DIRECTORY STRUCTURE

### 6.1 MVC Separation

**Controllers (`app/Http/Controllers/`):**
- Handle request logic
- Return views with data
- Perform business logic
- Validate input

**Views (`resources/views/`):**
- Display data
- Use components
- No business logic
- Minimal JavaScript (only for UI interactions)

**Models (`app/Models/`):**
- Database interactions
- Business logic related to data
- Relationships

### 6.2 Directory Structure

```
resources/
├── views/
│   ├── components/          # Reusable Blade components
│   │   ├── admin/          # Admin-specific components
│   │   ├── pim/            # PIM-specific components
│   │   └── recruitment/    # Recruitment-specific components
│   ├── layouts/            # Layout templates
│   ├── admin/              # Admin module views
│   │   ├── job/           # Job-related views
│   │   ├── organization/  # Organization views
│   │   ├── qualifications/# Qualifications views
│   │   └── configuration/ # Configuration views
│   ├── pim/               # PIM module views
│   ├── recruitment/       # Recruitment module views
│   └── profile/           # Profile views
├── css/
│   └── app.css            # Main stylesheet with theme variables
└── js/
    └── app.js             # Main JavaScript file

app/
├── Http/
│   └── Controllers/       # All controllers
├── Models/                # All models
└── View/
    └── Components/        # Component PHP classes
```

### 6.3 Strict Rules

**FORBIDDEN:**
- ❌ Business logic in views
- ❌ Inline CSS hacks
- ❌ Breaking directory conventions
- ❌ Mixing concerns (logic in views, display in controllers)
- ❌ Creating files in wrong directories

**REQUIRED:**
- ✅ Follow MVC pattern strictly
- ✅ Keep views clean and simple
- ✅ Use controllers for all logic
- ✅ Organize files by module/feature
- ✅ Create folders for related views

---

## SECTION 7: INTERACTION & UX QUALITY

### 7.1 Hover States

**Requirements:**
- Smooth transition: `0.2s cubic-bezier(0.4, 0, 0.2, 1)`
- Subtle elevation: `translateY(-1px)` or `translateY(-2px)`
- Shadow increase: Subtle, not dramatic
- Color change: Use theme variables

**FORBIDDEN:**
- ❌ No hover state
- ❌ Jarring transitions
- ❌ Excessive movement
- ❌ Inconsistent hover behavior

### 7.2 Focus States

**Requirements:**
- Visible outline: `2px solid var(--color-hr-primary-light)`
- Outline offset: `2px`
- Must be accessible (keyboard navigation)

**FORBIDDEN:**
- ❌ Missing focus states
- ❌ Invisible focus indicators
- ❌ Inconsistent focus styling

### 7.3 Active States

**Requirements:**
- Visual feedback on click
- Transform reset: `translateY(0)`
- Shadow reduction

**FORBIDDEN:**
- ❌ Missing active states
- ❌ No feedback on interaction

### 7.4 Transitions

**Requirements:**
- Smooth: `cubic-bezier(0.4, 0, 0.2, 1)`
- Duration: `0.2s` or `0.3s`
- Subtle and professional

**FORBIDDEN:**
- ❌ No transitions
- ❌ Flashy animations
- ❌ Excessive movement
- ❌ Bounce effects

### 7.5 Loading States

**Requirements:**
- Show loading indicator
- Disable interactions during load
- Clear feedback to user

### 7.6 Empty States

**Requirements:**
- Clear message
- Helpful guidance
- Consistent styling

**UX Quality Standards:**
- ✅ Predictable interactions
- ✅ Polished feel
- ✅ Premium experience
- ✅ Consistent behavior

---

## SECTION 8: WHAT NOT TO DO (CRITICAL)

### 8.1 Forbidden UI Patterns

**NEVER introduce:**
- ❌ Duplicate action buttons (only one set per row)
- ❌ Mixed themes (some light, some dark)
- ❌ Inconsistent icon sizes
- ❌ Random spacing values
- ❌ Flashy animations (scale, rotate, bounce)
- ❌ Oversized buttons
- ❌ Missing hover states
- ❌ Hardcoded colors
- ❌ Components that break dark mode
- ❌ Inconsistent border radius
- ❌ Visual noise (unnecessary decorations)
- ❌ Misaligned elements
- ❌ Inconsistent padding
- ❌ Missing focus states
- ❌ Tables without hover states
- ❌ Forms without validation UI
- ❌ Dropdowns that scroll with content
- ❌ Modals without backdrop

### 8.2 Common Mistakes to Avoid

1. **Hardcoding Colors**
   - ❌ `bg-white`, `text-gray-700`
   - ✅ `var(--bg-card)`, `var(--text-primary)`

2. **Inconsistent Spacing**
   - ❌ Random `px-3`, `px-5`, `px-7`
   - ✅ Consistent spacing: `px-2`, `px-4`, `px-6`

3. **Missing Dark Mode Support**
   - ❌ Components that only work in light mode
   - ✅ All components must support both themes

4. **Duplicate Code**
   - ❌ Copy-pasting UI blocks
   - ✅ Use reusable components

5. **Breaking Existing Behavior**
   - ❌ Changing sidebar structure
   - ✅ Extend, don't break

6. **Visual Inconsistency**
   - ❌ Different button styles on same page
   - ✅ Use standard button classes

7. **Missing Accessibility**
   - ❌ No focus states
   - ✅ All interactive elements must have focus states

### 8.3 Things That Must NEVER Be Introduced

- ❌ jQuery or other heavy libraries (use vanilla JS)
- ❌ Inline styles for colors
- ❌ CSS frameworks beyond Tailwind (with theme variables)
- ❌ Breaking changes to core components
- ❌ Features that don't support dark mode
- ❌ UI that doesn't match the design system
- ❌ Code that breaks existing functionality
- ❌ Duplicate functionality
- ❌ Inconsistent naming conventions

---

## SECTION 9: CONTRIBUTION CHECKLIST

### 9.1 Pre-Submission Verification

**Every developer MUST verify the following BEFORE submitting work:**

#### UI Consistency
- [ ] All colors use theme variables
- [ ] Consistent spacing throughout
- [ ] Consistent typography
- [ ] Consistent button styles
- [ ] Consistent table styling
- [ ] Consistent form styling

#### Dark Mode Correctness
- [ ] Feature works in light mode
- [ ] Feature works in dark mode
- [ ] No white/light background leaks
- [ ] Proper contrast ratios
- [ ] All text is readable
- [ ] All interactive elements visible

#### Alignment & Spacing
- [ ] Elements are properly aligned
- [ ] Consistent padding/margins
- [ ] No misaligned columns
- [ ] No uneven spacing
- [ ] Proper visual hierarchy

#### Reusability
- [ ] Uses existing components where possible
- [ ] New components follow patterns
- [ ] No duplicate UI code
- [ ] Components are properly documented

#### No Duplication
- [ ] No duplicate action buttons
- [ ] No duplicate functionality
- [ ] No copy-pasted code blocks
- [ ] No redundant components

#### No Breaking Changes
- [ ] Doesn't break existing features
- [ ] Doesn't change core component APIs
- [ ] Doesn't break layout
- [ ] Doesn't break navigation
- [ ] Doesn't break dark mode

#### Accessibility
- [ ] Focus states on all interactive elements
- [ ] Keyboard navigation works
- [ ] Proper ARIA labels where needed
- [ ] Color contrast meets WCAG standards

#### Code Quality
- [ ] Follows MVC pattern
- [ ] No business logic in views
- [ ] Proper error handling
- [ ] Clean, readable code
- [ ] Proper comments where needed

---

## SECTION 10: FINAL STATEMENT

### 10.1 Mandatory Compliance

**This document is MANDATORY.** All developers working on TOAI HRM Suite – Professional Edition must read, understand, and comply with these rules.

### 10.2 Quality Standard

**Any feature not following these rules must be rejected.** There are no exceptions. Quality and consistency are non-negotiable.

### 10.3 Review Process

All code submissions will be reviewed against this rulebook. Features that violate these rules will be:
1. **Rejected** with specific violation notes
2. **Required** to be fixed before resubmission
3. **Documented** to prevent future violations

### 10.4 Continuous Improvement

This rulebook is a living document. As the project evolves, rules may be updated. However, changes must be:
- Documented
- Communicated to all developers
- Applied consistently

### 10.5 Enterprise Commitment

**TOAI HRM Suite – Professional Edition** is an enterprise-grade application. Every line of code, every UI element, and every interaction must reflect this commitment to quality, consistency, and professionalism.

---

## APPENDIX A: Quick Reference

### Button Classes
- Primary: `.hr-btn-primary`
- Secondary: `.hr-btn-secondary`

### Action Button Classes
- Delete: `.hr-action-delete`
- Edit: `.hr-action-edit`

### Common Theme Variables
- Background: `var(--bg-main)`, `var(--bg-card)`, `var(--bg-hover)`
- Text: `var(--text-primary)`, `var(--text-muted)`, `var(--text-secondary)`
- Border: `var(--border-default)`, `var(--border-strong)`
- Primary: `var(--color-hr-primary)`, `var(--color-hr-primary-dark)`

### Component Locations
- Admin: `resources/views/components/admin/`
- PIM: `resources/views/components/pim/`
- Recruitment: `resources/views/components/recruitment/`
- Shared: `resources/views/components/`

---

**END OF DOCUMENT**

*This rulebook is the foundation of quality for TOAI HRM Suite – Professional Edition. Follow it religiously.*

