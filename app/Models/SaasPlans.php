<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaasPlans extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'monthly_price',
        'yearly_price',
        'max_clients',
        'max_professionals',
        'max_rooms',
        'features',
        'is_popular',
        'is_active',
        'trial_days',
    ];

    protected $casts = [
        'features' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'monthly_price' => 'decimal:2',
        'yearly_price' => 'decimal:2',
    ];

    /**
     * Get the formatted monthly price
     */
    public function getFormattedMonthlyPriceAttribute()
    {
        return 'R$ ' . number_format($this->monthly_price, 2, ',', '.');
    }

    /**
     * Get the formatted yearly price
     */
    public function getFormattedYearlyPriceAttribute()
    {
        return 'R$ ' . number_format($this->yearly_price, 2, ',', '.');
    }

    /**
     * Get the yearly savings percentage
     */
    public function getYearlySavingsPercentAttribute()
    {
        $monthlyTotal = $this->monthly_price * 12;
        $savings = $monthlyTotal - $this->yearly_price;
        return round(($savings / $monthlyTotal) * 100);
    }

    /**
     * Scope for active plans
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
