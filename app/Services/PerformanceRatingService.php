<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PerformanceRatingService
{
    /**
     * Calculate overall rating from KPI ratings
     * Formula: Σ (KPI_Rating × KPI_Weight) / Σ (KPI_Weight)
     */
    public function calculateOverallRating(int $reviewId): ?float
    {
        $kpiRatings = DB::table('performance_review_kpis')
            ->join('kpis', 'performance_review_kpis.kpi_id', '=', 'kpis.id')
            ->where('performance_review_kpis.performance_review_id', $reviewId)
            ->whereNotNull('performance_review_kpis.rating')
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
            if ($kpi->rating !== null && $kpi->rating >= 0) {
                $totalWeight += (float) $kpi->weight;
                $weightedSum += ((float) $kpi->rating * (float) $kpi->weight);
            }
        }

        if ($totalWeight == 0) {
            return null;
        }

        return round($weightedSum / $totalWeight, 2);
    }

    /**
     * Auto-create performance_review_kpis entries for all active KPIs
     */
    public function createReviewKpis(int $reviewId): void
    {
        // Check if is_active column exists
        $hasIsActiveColumn = Schema::hasColumn('kpis', 'is_active');
        
        // Get all KPIs (filter by is_active if column exists, otherwise get all)
        $query = DB::table('kpis');
        
        if ($hasIsActiveColumn) {
            $kpis = $query->where(function($q) {
                $q->where('is_active', 1)
                  ->orWhereNull('is_active');
            })->select('id')->get();
        } else {
            // If is_active column doesn't exist, get all KPIs
            $kpis = $query->select('id')->get();
        }

        // Create entries for each KPI
        foreach ($kpis as $kpi) {
            // Check if already exists
            $exists = DB::table('performance_review_kpis')
                ->where('performance_review_id', $reviewId)
                ->where('kpi_id', $kpi->id)
                ->exists();

            if (!$exists) {
                DB::table('performance_review_kpis')->insert([
                    'performance_review_id' => $reviewId,
                    'kpi_id' => $kpi->id,
                    'rating' => null,
                    'comments' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Update KPI ratings for a review
     */
    public function updateKpiRatings(int $reviewId, array $ratings): void
    {
        foreach ($ratings as $kpiId => $data) {
            DB::table('performance_review_kpis')
                ->where('performance_review_id', $reviewId)
                ->where('kpi_id', $kpiId)
                ->update([
                    'rating' => isset($data['rating']) && $data['rating'] !== '' ? (float) $data['rating'] : null,
                    'comments' => $data['comments'] ?? null,
                    'updated_at' => now(),
                ]);
        }
    }

    /**
     * Get KPI ratings for a review
     */
    public function getReviewKpis(int $reviewId): array
    {
        return DB::table('performance_review_kpis')
            ->join('kpis', 'performance_review_kpis.kpi_id', '=', 'kpis.id')
            ->where('performance_review_kpis.performance_review_id', $reviewId)
            ->select(
                'kpis.id as kpi_id',
                'kpis.name as kpi_name',
                'kpis.description as kpi_description',
                'kpis.weight as kpi_weight',
                'performance_review_kpis.rating',
                'performance_review_kpis.comments'
            )
            ->orderBy('kpis.name')
            ->get()
            ->toArray();
    }
}

