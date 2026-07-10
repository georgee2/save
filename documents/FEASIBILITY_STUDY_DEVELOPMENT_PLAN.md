# Feasibility Study Module - Development Plan

## Overview
This document outlines the phase-by-phase development plan for building the Feasibility Studies module within the SmartVision engineering projects system.

## System Analysis

### Existing Structure
The system currently includes:
1. **Building Components** - Related to project types with floor components and construction fees
2. **Length Components** - Related to building components with unit costs
3. **Floor Components** - Related to building components with area measurements (SQFT, SQM)
4. **Income Components** - With number of units and rent per year
5. **Construction Costs** - Substation Room and Pumps Room with predefined prices
6. **Feasibility Study Components** - Headers with target flags to categorize components

### Key Database Tables
- `projects` - Main project table
- `feasibility_study_components` - Headers with target flags (Building Components, Length Components, Income Components, Construction Cost, Project Cost)
- `building_components` - Building components master data
- `length_components` - Length components master data
- `floor_components` - Floor types master data
- `income_components` - Income types master data
- `substation_rooms` - Substation room types with prices
- `pumps_rooms` - Pumps room types with prices
- `project_building_components` - Project-specific building components with costs
- `project_length_components` - Project-specific length components with unit costs
- `project_floors` - Project floors with SQFT, SQM, count
- `project_income_components` - Project income components with units and rent
- `project_construction_costs` - Project construction costs

## Development Phases

---

## Phase 1: Database Structure - Feasibility Studies Master Table
**Objective**: Create the main feasibility studies table to store study metadata

### Tasks:
1. Create migration: `create_feasibility_studies_table.php`
   - `id` (primary key)
   - `project_id` (foreign key to projects)
   - `study_name` (varchar)
   - `study_type` (enum: 'Master', 'Custom')
   - `description` (text, nullable)
   - `created_by` (foreign key to users, nullable)
   - `status` (enum: 'Draft', 'Active', 'Archived')
   - `timestamps`
   - `softDeletes`

### Expected Outcome:
- Migration file created and ready to run
- Each project can have multiple feasibility studies
- Master study uses original project data
- Custom studies allow modifications

---

## Phase 2: Database Structure - Study Component Tables
**Objective**: Create tables to store modified values for each feasibility study

### Tasks:

#### 2.1: Feasibility Study Building Components
Create migration: `create_fs_building_components_table.php`
- `id`
- `feasibility_study_id` (foreign key)
- `building_component_id` (foreign key to building_components)
- `construction_cost` (decimal) - can override project value
- `timestamps`
- `softDeletes`

#### 2.2: Feasibility Study Length Components
Create migration: `create_fs_length_components_table.php`
- `id`
- `feasibility_study_id` (foreign key)
- `length_component_id` (foreign key to length_components)
- `building_component_id` (foreign key to building_components)
- `unit_cost` (decimal) - can override project value
- `timestamps`
- `softDeletes`

#### 2.3: Feasibility Study Income Components
Create migration: `create_fs_income_components_table.php`
- `id`
- `feasibility_study_id` (foreign key)
- `income_component_id` (foreign key to income_components)
- `number_of_units` (integer) - can override project value
- `rent_per_year` (decimal) - can override project value
- `timestamps`
- `softDeletes`

#### 2.4: Feasibility Study Construction Costs
Create migration: `create_fs_construction_costs_table.php`
- `id`
- `feasibility_study_id` (foreign key)
- `substation_room_id` (nullable foreign key)
- `substation_cost` (decimal, nullable)
- `pumps_room_id` (nullable foreign key)
- `pumps_cost` (decimal, nullable)
- `timestamps`
- `softDeletes`

#### 2.5: Feasibility Study Project Costs
Create migration: `create_fs_project_costs_table.php`
- `id`
- `feasibility_study_id` (foreign key, unique)
- `land_cost` (decimal)
- `consultant_cost` (decimal)
- `government_fees` (decimal)
- `additional_fees` (decimal)
- `timestamps`
- `softDeletes`

### Expected Outcome:
- All component tables created
- Foreign key relationships established
- Each study can override specific component values

---

## Phase 3: Eloquent Models
**Objective**: Create model classes with relationships and business logic

### Tasks:

#### 3.1: FeasibilityStudy Model
Create: `app/Models/FeasibilityStudy.php`
- Relationships:
  - `belongsTo(Project)`
  - `belongsTo(User, 'created_by')`
  - `hasMany(FsBuildingComponent)`
  - `hasMany(FsLengthComponent)`
  - `hasMany(FsIncomeComponent)`
  - `hasMany(FsConstructionCost)`
  - `hasOne(FsProjectCost)`
- Methods:
  - `list()` - Get all studies
  - `getByProject($projectId)` - Get studies for a project
  - `isMaster()` - Check if master study
  - `calculateTotals()` - Calculate all totals

#### 3.2: Component Models
Create models for each study component table:
- `FsBuildingComponent.php`
- `FsLengthComponent.php`
- `FsIncomeComponent.php`
- `FsConstructionCost.php`
- `FsProjectCost.php`

Each with appropriate relationships to:
- FeasibilityStudy
- Original component tables
- Helper methods for calculations

### Expected Outcome:
- All models created with proper relationships
- Query methods for data retrieval
- Calculation helper methods

---

## Phase 4: Controller Logic
**Objective**: Create controller with CRUD operations and calculation logic

### Tasks:

#### 4.1: FeasibilityStudyController
Create: `Modules/Admin/App/Http/Controllers/FeasibilityStudyController.php`

Methods:
- `index()` - List all feasibility studies
- `create($projectId)` - Show create form
- `store(Request)` - Store new study
- `show($id)` - Display study with all calculations
- `edit($id)` - Show edit form
- `update(Request, $id)` - Update study
- `destroy($id)` - Delete study
- `duplicate($id)` - Create copy of existing study

#### 4.2: Calculation Methods
Implement calculation logic:
- `calculateBuildingComponents($studyId)` - Calculate building costs
- `calculateLengthComponents($studyId)` - Calculate length costs
- `calculateConstructionCosts($studyId)` - Calculate construction costs
- `calculateProjectCosts($studyId)` - Calculate total project costs
- `calculateIncomeComponents($studyId)` - Calculate income totals
- `generateReport($studyId)` - Generate complete study report

### Expected Outcome:
- Full CRUD operations implemented
- All calculation logic working
- Data properly validated

---

## Phase 5: Routes Configuration
**Objective**: Register routes for feasibility study operations

### Tasks:

1. Add routes to `Modules/Admin/routes/web.php`:
```php
// Feasibility Studies
Route::prefix('feasibility-studies')->group(function() {
    Route::get('/', 'FeasibilityStudyController@index')->name('feasibility-study.index');
    Route::get('/project/{projectId}/create', 'FeasibilityStudyController@create')->name('feasibility-study.create');
    Route::post('/store', 'FeasibilityStudyController@store')->name('feasibility-study.store');
    Route::get('/{id}/show', 'FeasibilityStudyController@show')->name('feasibility-study.show');
    Route::get('/{id}/edit', 'FeasibilityStudyController@edit')->name('feasibility-study.edit');
    Route::post('/{id}/update', 'FeasibilityStudyController@update')->name('feasibility-study.update');
    Route::get('/{id}/delete', 'FeasibilityStudyController@destroy')->name('feasibility-study.delete');
    Route::post('/{id}/duplicate', 'FeasibilityStudyController@duplicate')->name('feasibility-study.duplicate');
});
```

### Expected Outcome:
- All routes properly registered
- RESTful naming conventions followed

---

## Phase 6: View Templates - Index & List
**Objective**: Create listing views

### Tasks:

#### 6.1: Index View
Create: `Modules/Admin/resources/views/feasibility-studies/index.blade.php`
- Breadcrumb navigation
- DataTable with columns:
  - ID
  - Study Name
  - Project Name
  - Study Type (Master/Custom)
  - Status
  - Created Date
  - Actions (View, Edit, Duplicate, Delete)
- Filter by project
- Create new study button

### Expected Outcome:
- Professional listing interface
- Sortable, searchable datatable
- Proper actions for each study

---

## Phase 7: View Templates - Create & Edit Forms
**Objective**: Create forms for study management

### Tasks:

#### 7.1: Create Form
Create: `Modules/Admin/resources/views/feasibility-studies/create.blade.php`
- Study name input
- Study type selection (Master auto-fills from project, Custom allows editing)
- Description textarea
- Status selection
- If Custom type, show component override sections:
  - Building Components table with editable costs
  - Length Components table with editable unit costs
  - Income Components with editable units and rent
  - Construction Costs with editable values
  - Project Costs form (Land, Consultant, Government, Additional)

#### 7.2: Edit Form
Create: `Modules/Admin/resources/views/feasibility-studies/edit.blade.php`
- Same as create form but pre-populated
- Cannot change study type after creation
- Show modification history (optional)

### Expected Outcome:
- User-friendly forms with validation
- Clear distinction between Master and Custom studies
- Intuitive component override interface

---

## Phase 8: View Templates - Show/Report View
**Objective**: Create comprehensive study display with calculations

### Tasks:

#### 8.1: Show View
Create: `Modules/Admin/resources/views/feasibility-studies/show.blade.php`

Structure:
1. **Study Header Section**
   - Study name, type, status
   - Project reference
   - Created date and by whom
   - Action buttons (Edit, Duplicate, Back)

2. **Building Components Section**
   - Header from feasibility_study_components table
   - Table with columns:
     - Component Name
     - Floor Type
     - SQFT
     - Count
     - Total Area (SQFT × Count)
     - Construction Cost per SQFT
     - Total Cost
   - Grand Total

3. **Length Components Section**
   - Header from feasibility_study_components table
   - Table with columns:
     - Component Name
     - Length
     - Count
     - Total Length
     - Unit Cost
     - Total Cost
   - Grand Total

4. **Construction Costs Section**
   - Header from feasibility_study_components table
   - Substation Room cost
   - Pumps Room cost
   - Total Construction Cost

5. **Project Costs Section**
   - Total Construction Cost (sum of building + length + construction)
   - Land Cost
   - Consultant Cost
   - Government Fees
   - Additional Fees
   - **Grand Total Project Cost**

6. **Income Components Section**
   - Header from feasibility_study_components table
   - Table with columns:
     - Component Name
     - Number of Units
     - Rent per Year
     - Total Income (Units × Rent)
   - Grand Total Income

7. **Summary Section**
   - Total Project Cost
   - Total Annual Income
   - ROI Calculation (if applicable)
   - Payback Period (if applicable)

### Expected Outcome:
- Comprehensive study report
- All calculations displayed correctly
- Professional presentation
- Print-friendly layout

---

## Phase 9: Integration with Project Module
**Objective**: Add feasibility study reference to project views

### Tasks:

#### 9.1: Update Project Show View
Modify: `Modules/Admin/resources/views/projects/show.blade.php`
- Add new tab: "Feasibility Studies"
- Display list of studies for this project
- Quick view of each study
- Links to create new study and view full studies

#### 9.2: Update Project Index
Add indicator showing number of feasibility studies per project (optional)

### Expected Outcome:
- Seamless integration with existing project module
- Easy access to feasibility studies from project view
- No disruption to existing functionality

---

## Phase 10: Additional Features & Refinements
**Objective**: Enhance functionality and user experience

### Tasks:

#### 10.1: Master Study Auto-Creation
- When project is created, optionally auto-create Master feasibility study
- Master study always uses original project values
- Cannot edit component values in Master study

#### 10.2: Study Duplication
- Implement duplicate functionality
- Copy all component values to new study
- Allow immediate editing

#### 10.3: Comparison View (Optional)
- Compare multiple studies side-by-side
- Highlight differences
- Export comparison report

#### 10.4: PDF Export (Optional)
- Generate PDF report of feasibility study
- Professional formatting
- Include charts/graphs

#### 10.5: Permissions & Access Control
- Define user permissions for managing studies
- Restrict deletion of Master study
- Audit trail for modifications

### Expected Outcome:
- Enhanced user experience
- Professional reporting capabilities
- Secure access control

---

## Phase 11: Testing & Documentation
**Objective**: Ensure quality and maintainability

### Tasks:

1. **Unit Testing**
   - Test all model methods
   - Test calculation logic
   - Test relationships

2. **Integration Testing**
   - Test CRUD operations
   - Test data flow between tables
   - Test UI interactions

3. **User Documentation**
   - Create user guide for feasibility studies
   - Document calculation formulas
   - Create video tutorials (optional)

4. **Code Documentation**
   - Add PHPDoc comments
   - Document complex logic
   - Create README for module

### Expected Outcome:
- Stable, tested module
- Comprehensive documentation
- Easy maintenance

---

## Implementation Timeline Estimate

| Phase | Estimated Time | Dependencies |
|-------|---------------|--------------|
| Phase 1 | 2 hours | None |
| Phase 2 | 3 hours | Phase 1 |
| Phase 3 | 4 hours | Phase 2 |
| Phase 4 | 6 hours | Phase 3 |
| Phase 5 | 1 hour | Phase 4 |
| Phase 6 | 3 hours | Phase 5 |
| Phase 7 | 5 hours | Phase 5 |
| Phase 8 | 6 hours | Phase 5 |
| Phase 9 | 2 hours | Phase 8 |
| Phase 10 | 8 hours | Phase 9 |
| Phase 11 | 6 hours | Phase 10 |
| **Total** | **46 hours** | |

---

## Database Schema Summary

### New Tables:
1. `feasibility_studies` - Master table for studies
2. `fs_building_components` - Study building component overrides
3. `fs_length_components` - Study length component overrides
4. `fs_income_components` - Study income component overrides
5. `fs_construction_costs` - Study construction cost overrides
6. `fs_project_costs` - Study project costs

### Foreign Key Relationships:
- All study component tables → `feasibility_studies`
- `feasibility_studies` → `projects`
- Component tables → Original master data tables
- `feasibility_studies` → `users` (created_by)

---

## Technical Considerations

### 1. Data Consistency
- Master study should always reflect current project values
- Custom studies store snapshots at time of creation
- Consider versioning if project data changes frequently

### 2. Performance
- Index foreign keys for faster queries
- Consider caching calculation results for large projects
- Lazy load relationships when not needed

### 3. Scalability
- Design supports multiple studies per project
- Can handle projects with many components
- Calculation methods optimized for performance

### 4. User Experience
- Clear visual distinction between Master and Custom studies
- Intuitive component override interface
- Responsive design for all screen sizes

---

## Success Criteria

The Feasibility Study module will be considered complete when:
1. ✅ All database tables created and migrated
2. ✅ All models with relationships working correctly
3. ✅ Full CRUD operations functional
4. ✅ All calculations accurate and tested
5. ✅ Professional, user-friendly interface
6. ✅ Integration with project module complete
7. ✅ Documentation complete
8. ✅ No existing functionality broken

---

## Future Enhancements (Post-Launch)

1. **Financial Analysis**
   - NPV (Net Present Value) calculations
   - IRR (Internal Rate of Return)
   - Break-even analysis

2. **Scenario Planning**
   - Best case / Worst case / Most likely
   - Sensitivity analysis
   - Risk assessment

3. **Visualization**
   - Charts and graphs for costs
   - Income projections over time
   - Comparative analysis charts

4. **Export Options**
   - Excel export
   - CSV export
   - JSON API for external tools

5. **Collaboration Features**
   - Comments on studies
   - Approval workflow
   - Version history

---

**End of Development Plan**

