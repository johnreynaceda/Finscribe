<?php

namespace App\Livewire;

use App\Models\LogHistory;
use App\Models\Shop\Product;
use App\Models\TimeRecord;
use Carbon\Carbon;
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

class SystemLogList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(LogHistory::query()->orderBy('created_at', 'DESC'))
            ->columns([
                TextColumn::make('id')->label('FULLNAME')->formatStateUsing(
                    fn($record) => $record->user->name ?? 'NO NAME/DELETED'
                )->searchable(),
                TextColumn::make('user')->label('USER ROLE')->formatStateUsing(
                    fn($record) => $record->user->name == null ? 'NO NAME/DELETED' : strtoupper($record->user->user_type)
                )->searchable(),
                TextColumn::make('action')->label('ACTIONS')->searchable(),
                TextColumn::make('created_at')->label('DATE & TIME STAMP')->date('F d, Y h:i A')->searchable(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // EditAction::make('edit')->color('success'),
                // DeleteAction::make('delete')
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.system-log-list');
    }
}
