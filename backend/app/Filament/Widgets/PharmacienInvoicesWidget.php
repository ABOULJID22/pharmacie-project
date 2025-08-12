<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PharmacienInvoicesWidget extends ApexChartWidget
{
    protected static ?string $chartId = 'pharmacienInvoicesWidget';
    protected static ?string $heading = null;
    protected static ?int $contentHeight = 300;
    protected static ?string $pollingInterval = null;
    protected static ?int $sort = 4;

    protected function getHeading(): string
    {
        return __('all.top_5_pharmaciens');
    }

    protected function getOptions(): array
    {
        // Filtrer explicitement sur le champ 'role'
        $query = User::query()
            ->where('role', 'pharmacien')
            ->leftJoin('documents', 'users.id_user', '=', 'documents.id_uploader')
            ->select('users.id_user', 'users.name', DB::raw('COUNT(documents.id_document) as document_count'))
            ->groupBy('users.id_user', 'users.name');

        $results = $query->get();

        $totalDocuments = $results->sum('document_count');
        $topPharmaciens = $results->sortByDesc('document_count')->take(5);
        $others = $results->sortByDesc('document_count')->skip(5)->sum('document_count');

        $series = $topPharmaciens->pluck('document_count')->map(function ($count) use ($totalDocuments) {
            return $totalDocuments > 0 ? round(($count / $totalDocuments) * 100, 1) : 0;
        })->toArray();

        if ($others > 0) {
            $series[] = round(($others / $totalDocuments) * 100, 1);
        }

        $labels = $topPharmaciens->pluck('name')->toArray();
        if ($others > 0) {
            $labels[] =__('all.others');
        }

        return [
            'chart' => [
                'type' => 'donut',
                'height' => 300,
            ],
            'series' => $series,
            'labels' => $labels,
            'legend' => [
                'show' => true,
                'position' => 'bottom',
            ],
            'colors' => ['#0284c7', '#60a5fa', '#93c5fd', '#bfdbfe', '#dbeafe', '#e5e7eb'],
            'plotOptions' => [
                'pie' => [
                    'donut' => [
                        'size' => '70%',
                        'labels' => [
                            'show' => true,
                            'name' => ['show' => true],
                            'value' => [
                                'show' => true,
                                'formatter' => 'function (val) { return val + "%"; }',
                            ],
                            'total' => [
                                'show' => true,
                                'formatter' => 'function (w) {
                                    return "' . __('all.total_documents') .' " + w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }


        public static function canAccess(): bool
    {
        return auth()->user()->isAdmin() || auth()->user()->isConseiller();
    }

}