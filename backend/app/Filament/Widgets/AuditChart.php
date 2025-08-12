<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\Audit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class AuditChart extends ApexChartWidget
{
    protected static ?string $chartId = 'auditsChart';
    protected static ?string $heading = null;
    protected static ?int $contentHeight = 300;
    protected static ?string $pollingInterval = null;

    protected int|string|array $columnSpan = 2;
    protected static ?int $sort = 6;

    public ?string $startDate = null;

    public function mount(): void
    {
        parent::mount();
        $this->startDate = session()->get('startDate') ?? now();
        $this->options = $this->getOptions();
    }

    protected function getHeading(): string
    {
        return __('all.audits_by_month');
    }

    #[On('updateStartDate')]
    public function updateStartDate($startDate)
    {
        $this->startDate = $startDate ?? now();
        $this->updateOptions();
    }

    
    protected function getOptions(): array
    {
        $year = Carbon::parse($this->startDate)->year;

        $query = Audit::select([
            DB::raw('DATE_FORMAT(date_demande, "%Y-%m") as month'),
            DB::raw('COUNT(*) as total_audits'),
            DB::raw('SUM(CASE WHEN statut = "en_attente" THEN 1 ELSE 0 END) as pending_audits'),
            DB::raw('SUM(CASE WHEN statut = "realise" THEN 1 ELSE 0 END) as completed_audits'),
            DB::raw('SUM(CASE WHEN statut = "rejete" THEN 1 ELSE 0 END) as rejected_audits'),
        ])
        ->whereYear('date_demande', $year)
        ->groupBy('month')
        ->orderBy('month');

        $data = $query->get()->keyBy('month');

        // Générer tous les mois de l'année
        $allMonths = collect(range(1, 12))->map(function ($month) use ($year) {
            return Carbon::createFromDate($year, $month, 1)->format('Y-m');
        });

        // Compléter les données manquantes
        $completeData = $allMonths->map(function ($month) use ($data) {
            return $data[$month] ?? (object)[
                'month' => $month,
                'total_audits' => 0,
                'pending_audits' => 0,
                'completed_audits' => 0,
                'rejected_audits' => 0,
            ];
        });

        $months = $completeData->map(fn($item) => Carbon::createFromFormat('Y-m', $item->month)->isoFormat('MMM YY'))->values()->toArray();
        $pendingAudits = $completeData->pluck('pending_audits')->toArray();
        $completedAudits = $completeData->pluck('completed_audits')->toArray();
        $rejectedAudits = $completeData->pluck('rejected_audits')->toArray();

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
                'stacked' => true,
                'toolbar' => ['show' => false],
                'zoom' => ['enabled' => false],
            ],
            'series' => [
                [
                    'name' => __('all.completed_audits'),
                    'data' => $completedAudits,
                ],
                [
                    'name' => __('all.pending_audits'),
                    'data' => $pendingAudits,
                ],
                [
                    'name' => __('all.rejected_audits'),
                    'data' => $rejectedAudits,
                ],
            ],
            'xaxis' => [
                'categories' => $months,
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'yaxis' => [
                'title' => [
                    'text' => __('all.number_audit_per_month'),
                ],
            ],
            'colors' => ['#16a34a', '#eab308', '#dc2626'],
            'plotOptions' => [
                'bar' => [
                    'horizontal' => false,
                    'columnWidth' => '70%',
                ],
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
            'legend' => [
                'position' => 'bottom',
            ],
        ];
    }
}