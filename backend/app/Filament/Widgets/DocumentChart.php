<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class DocumentChart extends ApexChartWidget
{
    protected static ?string $chartId = 'DocumentsChart';
    protected static ?string $heading = null;
    protected static ?int $contentHeight = 300;
    protected static ?string $pollingInterval = null;
    public ?string $status = null; // <-- Ajout du filtre status
    protected static bool $isLazy = false;

    public $startDate = null;

    public function mount(): void
    {
        parent::mount();
        $this->startDate = session()->get('startDate') ?? now();
        $this->options = $this->getOptions();
    }

    protected function getHeading(): string
    {
        return __('all.Documents_overview');
    }

    public function filters(): array
{
    return [
        'status' => [
            'label' => __('all.status_label'),
            'options' => [
                '' => __('all.status_all'),
                'brouillon' => __('all.status_brouillon'),
                'valide' => __('all.status_valide'),
                'archive' => __('all.status_archive'),
            ],
            'default' => '',
        ],
    ];
}


    #[On('updateStartDate')]
    public function updateStartDate($startDate)
    {
        $this->startDate = $startDate ?? now();
        $this->updateOptions();
    }

    protected function getOptions(): array
    {
        $user = auth()->user();
        $query = Document::query();

        // Filtrer par utilisateur connecté (hors admin)
        if (!$user->isAdmin()) {
            $query->where('id_uploader', $user->id_user);
        }

        // Filtrer par année sélectionnée
        $year = Carbon::parse($this->startDate)->year;
        $query->whereYear('date_upload', $year);

        // Filtrer par status si sélectionné
        if ($this->status && $this->status !== '') {
            $query->where('status', $this->status);
        }

        // Récupérer les stats par mois
        $data = $query->select([
                DB::raw('DATE_FORMAT(date_upload, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total_documents'),
                DB::raw('SUM(CASE WHEN status = "brouillon" THEN 1 ELSE 0 END) as pending_documents'),
                DB::raw('SUM(CASE WHEN status = "valide" THEN 1 ELSE 0 END) as finished_documents'),
            ])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        // Générer tous les mois de l'année
        $allMonths = collect(range(1, 12))->map(function ($month) use ($year) {
            return Carbon::createFromDate($year, $month, 1)->format('Y-m');
        });

        // Compléter les données manquantes
        $completeData = $allMonths->map(function ($month) use ($data) {
            return $data[$month] ?? (object)[
                'month' => $month,
                'total_documents' => 0,
                'pending_documents' => 0,
                'finished_documents' => 0,
            ];
        });

        $months = $completeData->map(fn($item) => Carbon::createFromFormat('Y-m', $item->month)->isoFormat('MMM YY'))->values()->toArray();
        $finishedDocuments = $completeData->pluck('finished_documents')->toArray();
        $pendingDocuments = $completeData->pluck('pending_documents')->toArray();

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
                    'name' => __('all.completed_documents'),
                    'data' => $finishedDocuments,
                ],
                [
                    'name' => __('all.pending_documents'),
                    'data' => $pendingDocuments,
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
                    'text' => __('all.number_Document_per_month'),
                ],
            ],
            'colors' => ['#0284c7', '#eab308'],
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