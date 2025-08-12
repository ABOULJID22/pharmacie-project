<?php

namespace App\Filament\Resources\DocumentResource\Widgets;

use App\Models\Document;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DocumentStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalDocuments = Document::count();
        $draftDocuments = Document::where('status', 'brouillon')->count();
        $validatedDocuments = Document::where('status', 'valide')->count();
        $archivedDocuments = Document::where('status', 'archive')->count();

        return [
            Stat::make(__('all.total_documents'), $totalDocuments)
                ->description(__('all.total'))
                ->icon('heroicon-m-document')
                ->color('primary'),

            Stat::make(__('all.draft_documents'), $draftDocuments)
                ->description(__('all.draft'))
                ->icon('heroicon-m-pencil-square')
                ->color('warning'),

            Stat::make(__('all.validated_documents'), $validatedDocuments)
                ->description(__('all.validated'))
                ->icon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make(__('all.archived_documents'), $archivedDocuments)
                ->description(__('all.archived'))
                ->icon('heroicon-m-archive-box')
                ->color('gray'),
        ];
    }
}
