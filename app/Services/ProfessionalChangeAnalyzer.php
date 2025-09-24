<?php

namespace App\Services;

use App\Models\Professional;
use App\Models\Schedule;
use App\Models\ClassType;
use Carbon\Carbon;

class ProfessionalChangeAnalyzer
{
    /**
     * Analyze the impact of changing a professional's class types
     */
    public function analyzeClassTypeChanges(Professional $professional, array $newClassTypeIds): array
    {
        $currentClassTypeIds = $professional->classTypes->pluck('id')->toArray();
        $removedClassTypeIds = array_diff($currentClassTypeIds, $newClassTypeIds);
        $addedClassTypeIds = array_diff($newClassTypeIds, $currentClassTypeIds);
        
        $analysis = [
            'hasImpact' => false,
            'hasRecommendations' => false,
            'futureSchedules' => 0,
            'orphanedSchedules' => 0,
            'affectedClassTypes' => [],
            'recommendations' => []
        ];
        
        if (empty($removedClassTypeIds) && empty($addedClassTypeIds)) {
            return $analysis; // No changes
        }
        
        // Analyze future schedules that will be affected
        if (!empty($removedClassTypeIds)) {
            $futureSchedules = Schedule::where('professional_id', $professional->id)
                ->whereIn('class_type_id', $removedClassTypeIds)
                ->where('start_at', '>', Carbon::now())
                ->get();
            
            $analysis['futureSchedules'] = $futureSchedules->count();
            $analysis['orphanedSchedules'] = $futureSchedules->count();
            
            // Group by class type for detailed breakdown
            $affectedClassTypes = [];
            foreach ($futureSchedules->groupBy('class_type_id') as $classTypeId => $schedules) {
                $classType = ClassType::find($classTypeId);
                if ($classType) {
                    $affectedClassTypes[] = [
                        'id' => $classTypeId,
                        'name' => $classType->name,
                        'count' => $schedules->count()
                    ];
                }
            }
            $analysis['affectedClassTypes'] = $affectedClassTypes;
            
            if ($analysis['futureSchedules'] > 0) {
                $analysis['hasImpact'] = true;
            }
        }
        
        // Generate recommendations
        $recommendations = $this->generateRecommendations($professional, $removedClassTypeIds, $addedClassTypeIds, $analysis);
        if (!empty($recommendations)) {
            $analysis['recommendations'] = $recommendations;
            $analysis['hasRecommendations'] = true;
        }
        
        return $analysis;
    }
    
    /**
     * Analyze compensation model changes
     */
    public function analyzeCompensationChanges(Professional $professional, array $newCompensationData): array
    {
        $analysis = [
            'hasImpact' => false,
            'hasRecommendations' => false,
            'recommendations' => [],
            'financialImpact' => []
        ];
        
        $currentModel = $professional->compensation_model;
        $newModel = $newCompensationData['compensation_model'] ?? $currentModel;
        
        if ($currentModel !== $newModel) {
            $analysis['hasImpact'] = true;
            
            // Calculate potential financial impact
            $analysis['financialImpact'] = $this->calculateFinancialImpact($professional, $newCompensationData);
            
            // Generate recommendations for compensation changes
            $analysis['recommendations'] = $this->generateCompensationRecommendations($professional, $currentModel, $newModel);
            $analysis['hasRecommendations'] = !empty($analysis['recommendations']);
        }
        
        return $analysis;
    }
    
    /**
     * Generate recommendations based on changes
     */
    private function generateRecommendations(Professional $professional, array $removedClassTypeIds, array $addedClassTypeIds, array $analysis): array
    {
        $recommendations = [];
        
        if ($analysis['futureSchedules'] > 0) {
            $recommendations[] = "Consider reassigning the {$analysis['futureSchedules']} affected future classes to other qualified professionals before making this change.";
            
            // Suggest alternative professionals
            $alternativeProfessionals = $this->findAlternativeProfessionals($removedClassTypeIds);
            if (!empty($alternativeProfessionals)) {
                $names = collect($alternativeProfessionals)->pluck('name')->join(', ');
                $recommendations[] = "Alternative professionals who can teach these class types: {$names}";
            }
        }
        
        if (!empty($addedClassTypeIds)) {
            $newClassTypes = ClassType::whereIn('id', $addedClassTypeIds)->pluck('name')->join(', ');
            $recommendations[] = "Ensure {$professional->name} is properly certified and trained for: {$newClassTypes}";
        }
        
        if ($analysis['futureSchedules'] > 0) {
            $recommendations[] = "Send notifications to affected clients about potential instructor changes.";
            $recommendations[] = "Update marketing materials if this professional was featured for specific class types.";
        }
        
        return $recommendations;
    }
    
    /**
     * Find alternative professionals who can teach the removed class types
     */
    private function findAlternativeProfessionals(array $classTypeIds): array
    {
        return Professional::whereHas('classTypes', function ($query) use ($classTypeIds) {
            $query->whereIn('class_types.id', $classTypeIds);
        })->get()->toArray();
    }
    
    /**
     * Generate compensation change recommendations
     */
    private function generateCompensationRecommendations(Professional $professional, string $oldModel, string $newModel): array
    {
        $recommendations = [];
        
        $modelNames = [
            'fixed_salary' => 'Fixed Salary',
            'commission_only' => 'Commission Only',
            'salary_plus_commission' => 'Salary + Commission'
        ];
        
        $recommendations[] = "Compensation model changing from {$modelNames[$oldModel]} to {$modelNames[$newModel]}";
        
        switch ($newModel) {
            case 'fixed_salary':
                $recommendations[] = "Ensure monthly payroll budget accommodates the fixed salary amount.";
                $recommendations[] = "Consider performance review schedule since compensation is no longer tied to class volume.";
                break;
                
            case 'commission_only':
                $recommendations[] = "Professional income will now vary based on class attendance and pricing.";
                $recommendations[] = "Consider providing class scheduling priority to maintain income stability.";
                break;
                
            case 'salary_plus_commission':
                $recommendations[] = "This hybrid model provides income stability with performance incentives.";
                $recommendations[] = "Clearly communicate how commission is calculated on top of base salary.";
                break;
        }
        
        $recommendations[] = "Update employment contract to reflect new compensation structure.";
        $recommendations[] = "Notify payroll and accounting departments of the change.";
        
        return $recommendations;
    }
    
    /**
     * Calculate potential financial impact of compensation changes
     */
    private function calculateFinancialImpact(Professional $professional, array $newData): array
    {
        // This would calculate estimated monthly costs, revenue impact, etc.
        // For now, return basic structure
        return [
            'estimated_monthly_cost_change' => 0,
            'revenue_impact' => 'neutral',
            'budget_considerations' => []
        ];
    }
}
