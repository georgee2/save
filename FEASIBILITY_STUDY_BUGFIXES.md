# Feasibility Study Module - Bug Fixes

## Date: October 29, 2025

---

## Bug Fix #1: Undefined Property - building_component_name

### Error Message:
```
Undefined property: stdClass::$building_component_name
```

### Location:
`Modules/Admin/resources/views/feasibility-studies/create.blade.php` - Line 166

### Root Cause:
Property name mismatch. The `ProjectFloor::getByProject()` method returns `building_component_name_en` and `building_component_name_ar`, not `building_component_name`.

Additionally, the construction cost was not being fetched from the correct table.

### Fix Applied:
1. Changed property name from `$firstFloor->building_component_name` to `$firstFloor->building_component_name_en`
2. Added database query to fetch construction costs from `project_building_components` table
3. Used `pluck()` to create a key-value collection for efficient lookup
4. Properly retrieved the cost for each building component ID

### Code Changes:
```php
// BEFORE (WRONG)
<td>{{ $firstFloor->building_component_name }}</td>
<td><strong>{{ number_format($firstFloor->construction_cost, 2) }}</strong></td>

// AFTER (CORRECT)
@php
    $buildingComponents = collect($projectFloors)->groupBy('building_component_id');
    // Get building component costs from project_building_components
    $bcCosts = DB::table('project_building_components')
        ->where('project_id', $project->id)
        ->whereNull('deleted_at')
        ->pluck('construction_cost', 'building_component_id');
@endphp
@foreach($buildingComponents as $bcId => $floors)
    @php
        $firstFloor = $floors->first();
        $currentCost = $bcCosts->get($bcId, 0);
    @endphp
    <tr>
        <td>{{ $firstFloor->building_component_name_en }}</td>
        <td><strong>{{ number_format($currentCost, 2) }}</strong></td>
```

---

## Bug Fix #2: Undefined Property - length_component_name

### Error Message:
```
Undefined property: stdClass::$length_component_name
```

### Location:
`Modules/Admin/resources/views/feasibility-studies/create.blade.php` - Line 205

### Root Cause:
Property name mismatch. The `ProjectLengthComponent::getByProject()` method returns `length_component_name_english` and `length_component_name_arabic`, not `length_component_name`.

### Fix Applied:
Changed property name from `$lc->length_component_name` to `$lc->length_component_name_english`

### Code Changes:
```php
// BEFORE (WRONG)
<td>{{ $lc->length_component_name }}</td>

// AFTER (CORRECT)
<td>{{ $lc->length_component_name_english }}</td>
```

---

## Summary of Property Names

For future reference, here are the correct property names returned by each model's `getByProject()` method:

### ProjectFloor::getByProject($projectId)
Returns these properties:
- `building_component_name_en` (not `building_component_name`)
- `building_component_name_ar`
- `building_component_icon`
- `floor_component_name_en`
- `floor_component_name_ar`
- `floor_component_icon`
- `sqft`, `sqm`, `count`

**Note:** Construction cost must be fetched separately from `project_building_components` table.

### ProjectLengthComponent::getByProject($projectId)
Returns these properties:
- `length_component_name_english` (not `length_component_name`)
- `length_component_name_arabic`
- `length_component_icon`
- `building_component_name_english`
- `building_component_name_arabic`
- `building_component_icon`
- `unit_cost`

### ProjectIncomeComponent::getByProject($projectId)
Returns these properties:
- `name_english` ✅ (correct in view)
- `name_arabic`
- `icon`
- `number_of_units`
- `rent_per_year`

### ProjectConstructionCost::getByProject($projectId)
Returns these properties:
- `substation_price` ✅ (correct in view)
- `pumps_price` ✅ (correct in view)
- `substation_name_english`
- `substation_name_arabic`
- `pumps_name_english`
- `pumps_name_arabic`

---

## Status: ✅ FIXED

Both bugs have been resolved. The create view now properly references all property names as returned by the respective model methods.

---

## Testing Checklist

After these fixes, test the following:

- [ ] Navigate to a project with floors and building components
- [ ] Click "Create New Feasibility Study"
- [ ] Verify Building Components table displays correctly
- [ ] Verify Length Components table displays correctly (if project has length components)
- [ ] Verify Income Components table displays correctly (if project has income components)
- [ ] Verify Construction Costs displays correctly (if project has construction costs)
- [ ] Select "Custom" study type and verify all tables remain visible
- [ ] Create a study and verify it saves successfully
- [ ] View the study report and verify all data displays correctly

---

## Additional Notes

### Why Property Names Are Different
The inconsistency in property naming comes from different aliasing conventions in the various model methods:
- Some use `_en` suffix (building_component_name_en)
- Some use `_english` suffix (length_component_name_english)
- Some use no suffix (name_english)

This is based on the existing codebase structure and we maintained consistency with each model's established naming convention.

### Recommendation for Future Development
When adding new features that display data from these models, always:
1. Check the model's `getByProject()` method
2. Review the `select()` statement to see exact property names
3. Use those exact property names in the view
4. Test with actual data to catch any mismatches early

---

## Files Modified

1. **Modules/Admin/resources/views/feasibility-studies/create.blade.php**
   - Fixed building_component_name property reference
   - Added construction cost lookup from project_building_components
   - Fixed length_component_name property reference

---

**Bug Fixes Completed By:** AI Assistant (Claude)  
**Date:** October 29, 2025  
**Status:** ✅ All Issues Resolved

