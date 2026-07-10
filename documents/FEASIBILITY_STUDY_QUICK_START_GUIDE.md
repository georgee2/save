# Feasibility Study Module - Quick Start Guide

## 🚀 Getting Started in 5 Minutes

### Step 1: Run Database Migrations

Open your terminal and run:

```bash
php artisan migrate
```

This creates 6 new tables:
- `feasibility_studies`
- `fs_building_components`
- `fs_length_components`
- `fs_income_components`
- `fs_construction_costs`
- `fs_project_costs`

---

### Step 2: Verify Prerequisites

Make sure you have a project with:
- ✅ At least one floor configured
- ✅ Building components assigned to the project
- ✅ (Optional) Length components
- ✅ (Optional) Income components
- ✅ (Optional) Construction costs

**How to check:** Go to Admin → Projects → View a project → Check the various tabs

---

### Step 3: Create Your First Feasibility Study

1. **Navigate to a project:**
   - Admin Dashboard → Projects → Click on any project

2. **Go to Feasibility Studies tab:**
   - Click the "Feasibility Studies" tab in the project details view

3. **Click "Create New Feasibility Study"**

4. **Fill in the form:**
   - **Study Name:** e.g., "Base Scenario 2025"
   - **Study Type:** Choose Master or Custom
     - **Master:** Uses project's original data (recommended for first study)
     - **Custom:** Allows you to modify costs and values
   - **Status:** Choose Draft (for testing) or Active
   - **Description:** Optional notes about the study

5. **For Custom Studies (Optional):**
   - Override building component costs
   - Modify length component unit costs
   - Adjust income component units/rent
   - Change construction costs
   - Enter project costs (land, consultant fees, etc.)

6. **Click "Create Feasibility Study"**

---

### Step 4: View the Report

After creation, you'll see a comprehensive report showing:

- **Building Components Section:** Total construction costs by component
- **Length Components Section:** Total costs for linear items
- **Construction Costs:** Substation and pumps room costs
- **Project Costs:** Total project investment breakdown
- **Income Components:** Annual income projections
- **Financial Summary:** Key metrics including payback period

---

### Step 5: Explore Features

#### Edit a Study
- Click "Edit Study" button
- Modify name, status, or (for Custom studies) component values
- Save changes

#### Duplicate a Study
- Click "Duplicate Study" button
- Creates a copy as a Custom study
- Useful for creating alternative scenarios

#### Print a Report
- Click "Print Report" button
- Professional print-ready format
- Perfect for presentations or documentation

---

## 📋 Common Use Cases

### Use Case 1: Base Analysis
**Goal:** Understand the current project economics

**Steps:**
1. Create a **Master Study** named "Base Analysis"
2. Set status to **Active**
3. Review the report to understand:
   - Total project cost
   - Expected annual income
   - Payback period

### Use Case 2: Cost Reduction Scenario
**Goal:** See impact of reducing construction costs

**Steps:**
1. Duplicate the Base Analysis study
2. Rename to "Cost Reduction Scenario"
3. Edit the study
4. Reduce building component costs by 10%
5. Compare total project cost and payback period

### Use Case 3: Increased Income Scenario
**Goal:** Analyze higher rent projections

**Steps:**
1. Duplicate an existing study
2. Rename to "Optimistic Income"
3. Edit income components
4. Increase rent per year values by 15%
5. Review improved payback period

### Use Case 4: What-If Analysis
**Goal:** Test multiple variables at once

**Steps:**
1. Create a Custom study
2. Adjust multiple parameters:
   - Lower construction costs
   - Higher income projections
   - Include additional fees
3. Compare with Master study
4. Present best/worst/likely scenarios

---

## 🎯 Best Practices

### Study Naming Convention
Use descriptive names that indicate:
- **Time period:** "Q1 2025 Analysis"
- **Scenario type:** "Conservative Estimate", "Optimistic Forecast"
- **Version:** "Version 2.0", "Updated Oct 2025"

### Study Status Usage
- **Draft:** Work in progress, for internal review
- **Active:** Current/approved studies for decision making
- **Archived:** Historical studies, no longer relevant

### Master vs Custom Studies
- **Create one Master study per project** as the baseline
- **Use Custom studies for all scenarios** and alternatives
- **Keep Master study Active** for easy reference
- **Archive old Custom studies** when superseded

---

## 🔍 Understanding the Reports

### Building Components Section
Shows how much each building type costs to construct:
- Lists all floors under each building component
- Calculates total area (SQFT × Count)
- Applies construction cost per SQFT
- **Use this to:** Identify which building types are most expensive

### Length Components Section
Shows costs for linear construction elements:
- Lists items like fences, roads, utilities
- Calculates total length (Length × Count)
- Applies unit cost per length
- **Use this to:** Estimate infrastructure costs

### Construction Costs Section
Fixed-cost items:
- Substation room cost
- Pumps room cost
- **Use this to:** Account for utilities infrastructure

### Project Costs Section
The big picture:
- Total construction cost (sum of all above)
- Land acquisition cost
- Consultant fees
- Government approvals and permits
- Miscellaneous additional fees
- **GRAND TOTAL** = Your total investment

### Income Components Section
Revenue projections:
- Lists all income-generating units (apartments, shops, etc.)
- Multiplies: Units × Annual Rent
- **Use this to:** Estimate annual revenue

### Financial Summary
Key metrics at a glance:
- **Total Project Cost:** Your investment
- **Total Annual Income:** Your return
- **Payback Period:** How many years to recover investment
  - Formula: Total Cost ÷ Annual Income
  - Example: $1,000,000 ÷ $100,000/year = 10 years

---

## 💡 Tips & Tricks

### Tip 1: Start Simple
- Create your first study as a Master study
- Review the report to understand the calculations
- Then create Custom studies to experiment

### Tip 2: Use Duplication
- Don't create Custom studies from scratch
- Duplicate an existing study
- Modify only what's different
- Saves time and reduces errors

### Tip 3: Document Your Assumptions
- Use the Description field
- Note key assumptions:
  - "Assuming 5% annual rent increase"
  - "Construction cost based on 2025 Q1 prices"
  - "Includes 10% contingency buffer"

### Tip 4: Compare Studies Side-by-Side
- Open multiple studies in different browser tabs
- Compare total project costs
- Compare payback periods
- Identify which scenario is most viable

### Tip 5: Print for Presentations
- The Show view is optimized for printing
- Print to PDF for digital distribution
- Great for board meetings and investor presentations

### Tip 6: Regular Updates
- Duplicate your Active study monthly/quarterly
- Update with latest costs and rent data
- Archive the old version
- Track how projections change over time

---

## ❓ Frequently Asked Questions

### Q: Can I edit a Master study?
**A:** You can edit the name, status, and description, but not the component values. Master studies always use the current project data. To modify values, create a Custom study.

### Q: What happens if I change project data after creating a Master study?
**A:** Master studies always show current project data. If you update the project, the Master study report will reflect those changes immediately.

### Q: Can I delete a study?
**A:** Yes, but only Custom studies. Master studies cannot be deleted to protect data integrity.

### Q: How many studies can I create per project?
**A:** Unlimited! Create as many Custom studies as needed for different scenarios.

### Q: What if my payback period shows "N/A"?
**A:** This means there are no income components configured, so payback cannot be calculated. Add income components to the project first.

### Q: Can I create a study if my project has no floors?
**A:** Technically yes, but the report will show zero building component costs. It's recommended to configure floors first.

### Q: How do I share a study with someone?
**A:** Use the Print function and save as PDF, then email or share the PDF file.

### Q: Can I export to Excel?
**A:** Not yet - this is planned for a future update. Currently, you can print to PDF or copy data from the tables.

---

## 🐛 Troubleshooting

### Issue: "No data showing in report"
**Cause:** Project may not have associated floors/components  
**Solution:** Go back to the project and configure:
- Building components
- Floors under each building component
- Optionally: length, income, construction components

### Issue: "All calculations show zero"
**Cause:** Component costs may be set to zero  
**Solution:** Check project building components and ensure costs are entered

### Issue: "Cannot find Feasibility Studies tab"
**Cause:** May need to refresh the page  
**Solution:** 
1. Clear browser cache
2. Hard refresh (Ctrl+F5 or Cmd+Shift+R)
3. Log out and log back in

### Issue: "Error when creating study"
**Cause:** Validation error or missing required fields  
**Solution:** 
- Ensure Study Name is filled in
- Check that a Study Type is selected
- Review error messages displayed

### Issue: "Page loads slowly with many studies"
**Cause:** DataTable loading many records  
**Solution:** This is normal for 100+ studies. Use the search/filter features to find specific studies quickly.

---

## 📊 Sample Workflow: Complete Analysis

### Scenario: Analyzing a Residential Building Project

#### Project Setup (Prerequisites)
- Project: "Sunset Towers" - 5-floor residential building
- Building Component: "Residential Tower" with construction cost $100/SQFT
- Floors: 
  - Ground floor: 2,000 SQFT × 1
  - Typical floors: 1,800 SQFT × 4
- Income Components:
  - Apartments: 20 units × $24,000/year rent
- Construction Costs:
  - Substation: $50,000
  - Pumps: $30,000

#### Step-by-Step Analysis

**1. Create Master Study (Baseline)**
- Name: "Sunset Towers - Base Case"
- Type: Master
- Status: Active
- Result: 
  - Total building cost: $820,000 (10,000 SQFT × $100)
  - Construction cost: $80,000
  - Total project cost: $900,000
  - Annual income: $480,000
  - Payback: 1.88 years ✅ Good!

**2. Add Project Costs**
- Create Custom study: "With Land & Fees"
- Duplicate Base Case
- Add:
  - Land cost: $500,000
  - Consultant: $50,000
  - Gov fees: $25,000
- Result:
  - Total project cost: $1,475,000
  - Payback: 3.07 years ✅ Still acceptable

**3. Test Rent Reduction**
- Create Custom study: "Conservative Income"
- Duplicate previous
- Reduce rent to $20,000/year (from $24,000)
- Result:
  - Annual income: $400,000
  - Payback: 3.69 years ⚠️ Getting longer

**4. Test Cost Increase**
- Create Custom study: "Inflation Adjusted"
- Increase construction cost to $110/SQFT
- Result:
  - Total project cost: $1,575,000
  - Payback: 3.94 years ⚠️ Close to 4 years

**5. Best Case Scenario**
- Create Custom study: "Optimistic"
- Increase income to $28,000/year
- Result:
  - Annual income: $560,000
  - Payback: 2.63 years ✅ Excellent

**Conclusion:**
- Base case shows strong 1.88-year payback
- With realistic costs/fees, payback is ~3 years
- Conservative scenario still viable at 3.69 years
- Risk is manageable
- **Recommendation:** Proceed with project

---

## 🎓 Next Steps

### Level 1: Basic User (Completed ✅)
- [x] Create Master study
- [x] View and understand report
- [x] Print a report

### Level 2: Intermediate User
- [ ] Create Custom study with modifications
- [ ] Duplicate studies for scenarios
- [ ] Compare multiple studies
- [ ] Use Draft/Active/Archived statuses effectively

### Level 3: Advanced User
- [ ] Create comprehensive scenario analysis (best/worst/likely)
- [ ] Track changes over time with regular updates
- [ ] Present findings to stakeholders
- [ ] Use studies to guide project decisions

---

## 📞 Need Help?

If you encounter issues or have questions:

1. **Check this guide** - Most common questions answered here
2. **Review the Implementation Summary** - Technical details and troubleshooting
3. **Check the Development Plan** - Understand the architecture
4. **Contact system administrator** - For technical/database issues

---

## 🎉 You're Ready!

You now have everything you need to use the Feasibility Study module effectively. Start with a simple Master study, then experiment with Custom studies to explore different scenarios.

**Remember:** The goal is to make informed decisions about your projects. Use the module to:
- Understand your baseline economics
- Test different scenarios
- Compare alternatives
- Identify risks and opportunities
- Present data-driven recommendations

**Happy analyzing! 📊**

---

**Quick Start Guide Version:** 1.0  
**Last Updated:** October 29, 2025  
**Module Version:** 1.0.0

