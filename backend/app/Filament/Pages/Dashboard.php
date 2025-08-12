<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;


class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

  

       protected function getHeaderWidgets(): array
    {
        return [
            //\App\Filament\Resources\DocumentResource\Widgets\DocumentStatsOverview::class,
           // \App\Filament\Widgets\Stats::class,
        ];
    }
}