<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\FeasibilityStudy;
use App\Models\FsBuildingComponent;
use App\Models\FsLengthComponent;
use App\Models\FsIncomeComponent;
use App\Models\FsConstructionCost;
use App\Models\FsProjectCost;

class ClearFeasibilityStudies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feasibility:clear 
                            {--force : Force the operation without confirmation}
                            {--all : Include soft-deleted records}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all feasibility study records and their related data from all tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Show warning
        $this->warn('⚠️  WARNING: This will delete ALL feasibility study data!');
        $this->newLine();
        
        // Get counts before deletion
        $studyCount = FeasibilityStudy::count();
        $buildingCount = FsBuildingComponent::count();
        $lengthCount = FsLengthComponent::count();
        $incomeCount = FsIncomeComponent::count();
        $constructionCount = FsConstructionCost::count();
        $projectCostCount = FsProjectCost::count();
        
        if ($this->option('all')) {
            $studyCount = FeasibilityStudy::withTrashed()->count();
            $this->info('Including soft-deleted records...');
        }
        
        $totalRecords = $studyCount + $buildingCount + $lengthCount + $incomeCount + $constructionCount + $projectCostCount;
        
        if ($totalRecords === 0) {
            $this->info('✅ No feasibility study records found. Nothing to delete.');
            return 0;
        }
        
        // Display what will be deleted
        $this->info("Records to be deleted:");
        $this->table(
            ['Table', 'Count'],
            [
                ['feasibility_studies', $studyCount],
                ['fs_building_components', $buildingCount],
                ['fs_length_components', $lengthCount],
                ['fs_income_components', $incomeCount],
                ['fs_construction_costs', $constructionCount],
                ['fs_project_costs', $projectCostCount],
                ['TOTAL', $totalRecords],
            ]
        );
        
        // Ask for confirmation unless --force is used
        if (!$this->option('force')) {
            if (!$this->confirm('Are you sure you want to delete all this data? This action cannot be undone!')) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }
        
        // Start deletion process
        $this->info('🗑️  Starting deletion process...');
        $this->newLine();
        
        DB::beginTransaction();
        
        try {
            // Delete with progress bar
            $bar = $this->output->createProgressBar(6);
            $bar->start();
            
            // Delete all building components
            if ($this->option('all')) {
                FsBuildingComponent::withTrashed()->forceDelete();
            } else {
                DB::table('fs_building_components')->delete();
            }
            $this->info(' ✓ Building components deleted');
            $bar->advance();
            
            // Delete all length components
            if ($this->option('all')) {
                FsLengthComponent::withTrashed()->forceDelete();
            } else {
                DB::table('fs_length_components')->delete();
            }
            $this->info(' ✓ Length components deleted');
            $bar->advance();
            
            // Delete all income components
            if ($this->option('all')) {
                FsIncomeComponent::withTrashed()->forceDelete();
            } else {
                DB::table('fs_income_components')->delete();
            }
            $this->info(' ✓ Income components deleted');
            $bar->advance();
            
            // Delete all construction costs
            if ($this->option('all')) {
                FsConstructionCost::withTrashed()->forceDelete();
            } else {
                DB::table('fs_construction_costs')->delete();
            }
            $this->info(' ✓ Construction costs deleted');
            $bar->advance();
            
            // Delete all project costs
            if ($this->option('all')) {
                FsProjectCost::withTrashed()->forceDelete();
            } else {
                DB::table('fs_project_costs')->delete();
            }
            $this->info(' ✓ Project costs deleted');
            $bar->advance();
            
            // Delete all feasibility studies
            if ($this->option('all')) {
                FeasibilityStudy::withTrashed()->forceDelete();
            } else {
                DB::table('feasibility_studies')->delete();
            }
            $this->info(' ✓ Feasibility studies deleted');
            $bar->advance();
            
            $bar->finish();
            $this->newLine(2);
            
            DB::commit();
            
            $this->info("✅ Successfully deleted {$totalRecords} records from all feasibility study tables!");
            
            return 0;
            
        } catch (\Exception $e) {
            DB::rollback();
            
            $this->error('❌ Failed to delete records!');
            $this->error('Error: ' . $e->getMessage());
            
            return 1;
        }
    }
}
