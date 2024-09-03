<?php

namespace App\Livewire;

use App\Models\Shop\Product;
use App\Models\TimeRecord;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LiveTracking extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(TimeRecord::query()->orderBy('created_at', 'DESC'))
            ->columns([
                TextColumn::make('user.name')->label('FULLNAME')->searchable(),
                TextColumn::make('start_time')->date('F d, Y h:i A')->label('START TIME'),
                TextColumn::make('end_time')->date('F d, Y h:i A')->label('END TIME'),
                TextColumn::make('duration')->label('DURATION'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make('edit')->color('success'),
                DeleteAction::make('delete')
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.live-tracking');
    }
}
