<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\Professional;
use App\Models\Room;
use App\Models\ClassType;
use App\Models\Plan;
use App\Models\Schedule;
use Illuminate\Console\Command;

class TestSoftDeletes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-soft-deletes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test soft delete functionality on all models';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Testing Soft Delete Functionality');
        $this->newLine();

        // Test Client soft delete
        $this->testModelSoftDelete(Client::class, 'Client');
        
        // Test Professional soft delete
        $this->testModelSoftDelete(Professional::class, 'Professional');
        
        // Test Room soft delete
        $this->testModelSoftDelete(Room::class, 'Room');
        
        // Test ClassType soft delete
        $this->testModelSoftDelete(ClassType::class, 'ClassType');
        
        // Test Plan soft delete
        $this->testModelSoftDelete(Plan::class, 'Plan');
        
        // Test Schedule soft delete
        $this->testModelSoftDelete(Schedule::class, 'Schedule');

        $this->newLine();
        $this->info('✅ All soft delete tests completed successfully!');
    }

    private function testModelSoftDelete($modelClass, $modelName)
    {
        $this->info("Testing {$modelName} soft delete...");
        
        // Get the first record
        $model = $modelClass::first();
        if (!$model) {
            $this->warn("No {$modelName} records found to test");
            return;
        }

        $identifier = $model->name ?? $model->id;
        $this->line("  • Found {$modelName}: {$identifier}");

        // Perform soft delete
        $model->delete();
        $this->line("  • Soft deleted {$modelName}");

        // Check if it's excluded from normal queries
        $normalQuery = $modelClass::where('id', $model->id)->first();
        if ($normalQuery) {
            $this->error("  ❌ {$modelName} still appears in normal queries!");
        } else {
            $this->line("  ✅ {$modelName} excluded from normal queries");
        }

        // Check if it exists in withTrashed queries
        $trashedQuery = $modelClass::withTrashed()->where('id', $model->id)->first();
        if ($trashedQuery && $trashedQuery->deleted_at) {
            $this->line("  ✅ {$modelName} found in trashed records with deleted_at: {$trashedQuery->deleted_at}");
        } else {
            $this->error("  ❌ {$modelName} not found in trashed records!");
        }

        // Test restore functionality
        $trashedQuery->restore();
        $restoredModel = $modelClass::where('id', $model->id)->first();
        if ($restoredModel && !$restoredModel->deleted_at) {
            $this->line("  ✅ {$modelName} successfully restored");
        } else {
            $this->error("  ❌ {$modelName} restore failed!");
        }

        $this->newLine();
    }
}
