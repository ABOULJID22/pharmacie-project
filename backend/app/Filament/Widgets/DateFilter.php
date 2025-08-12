<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;

class DateFilter extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.widgets.date-filter';

    protected static ?int $sort = -2;

    protected array|string|int $columnSpan = 'full';

    public ?array $data = [
        'startDate' => null,
        'endDate' => null,
    ];

    public function mount()
    {
        if (session()->has('startDate') || session()->has('endDate')) {
            $this->data['startDate'] = session()->get('startDate');
            $this->data['endDate'] = session()->get('endDate');
        }
    }



    public function dispatchAll()
    {
        if ($this->data['startDate']) {
            session()->put('startDate', $this->data['startDate']);
        } else {
            session()->forget('startDate');
        }

        if ($this->data['endDate']) {
            session()->put('endDate', $this->data['endDate']);
        } else {
            session()->forget('endDate');
        }

        $this->dispatch('updateStartDate', startDate: $this->data['startDate']);
        $this->dispatch('updateEndDate', endDate: $this->data['endDate']);
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('startDate')
                    ->label(__('all.start_date'))
                    ->afterStateUpdated(fn(?string $state) => $this->dispatchAll())
                    ->live(debounce: 500)
                    ->maxDate(fn(Get $get) => $get('endDate') ?: now()),
                DatePicker::make('endDate')
                    ->label(__('all.end_date'))
                    ->minDate(fn(Get $get) => $get('startDate') ?: now())
                    ->afterStateUpdated(fn(?string $state) => $this->dispatchAll())
                    ->live(debounce: 500)
                    ->maxDate(now()),
            ])
            ->columns(3)
            ->statePath('data');
    }
}
