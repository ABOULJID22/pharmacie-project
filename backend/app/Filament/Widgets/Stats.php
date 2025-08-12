<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;

class Stats extends Widget
{
    protected static string $view = 'filament.widgets.stats';

    protected static ?string $pollingInterval = '5s';

    public function getViewData(): array
    {
        return [
            'users' => User::count(),
        ];
    }
}