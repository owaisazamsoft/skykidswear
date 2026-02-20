<?php

namespace App\Filament\Pages;

use App\Models\Lot;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Tapp\FilamentProgressBarColumn\Tables\Columns\ProgressBarColumn;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Contracts\HasTable;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Builder;

class LotReport extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected string $view = 'filament.pages.lot-report';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;
    protected static string|\UnitEnum|null $navigationGroup = "Reports Management";


    public function table(Table $table): Table
    {
        return $table
            ->query(Lot::with(['items.stitchingItem']))
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),
                TextColumn::make('ref')
                    ->label('Ref')
                    ->searchable(),
                TextColumn::make('date')
                    ->label('Date')
                    ->date(),
                TextColumn::make('total_quantity')
                    ->label('Quantity'),
                TextColumn::make('used_qty')
                    ->label('Used Qty')
                    ->state(fn($record) => $this->used_qty($record)),
                TextColumn::make('remaining_qty')
                    ->label('Remaining')
                    ->state(fn($record) => $this->remaining_qty($record)),

                TextColumn::make('progress')
                    ->label('Progress')
                    ->state(function ($record){
                        $total = (float) ($record->total_quantity ?? 0);
                        $used = $this->used_qty($record) ?? 0;
                        // $used = 50;
                        if ($total > 0) {
                            $percentage = ($used / $total) * 100;
                        } else {
                            $percentage = 0;
                        }

                        $percentage = round(min(max($percentage, 0), 100));
                        $color = "red";

                        return new HtmlString("<div style='display: flex; align-items: center; gap: 12px; min-width: 160px;'>
                            <div style='width: 100%; background-color: #e5e7eb; border-radius: 9999px; height: 10px; overflow: hidden;'>
                                <div style='width: {$percentage}%; background-color: {$color}; height: 10px; border-radius: 9999px;'></div>
                            </div>
                            <span style='font-size: 14px; font-weight: 500;'>{$percentage}%</span>
                        </div>");

                        return round(min(max($percentage, 0), 100));
                    })

            ])
            ->filters([

                Filter::make('date')
                ->schema([
                    DatePicker::make('date'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query->when(
                        $data['date'], 
                        fn (Builder $query, $date): Builder => $query->whereDate('date', $date)
                    );
                }),

                Filter::make('id')
                ->schema([
                    Select::make('id')
                        ->label('Lot')
                        ->options(\App\Models\Lot::pluck('ref', 'id'))
                        ->searchable()
                        ->preload(),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query->when(
                        $data['id'],
                        fn (Builder $query, $value): Builder => $query->where('id', $value)
                    );
                })

              
            
            ])
            ->recordActions([
                
            ]);
    }


    public function remaining_qty(Lot $record){

        $qty = $record->total_quantity;
        $used = 0;
        foreach ($record->items as $value){
            if($value->stitchingItem){
                $used += $value->stitchingItem->sum('quantity');
            }
        } 
        return ($qty - $used);
    }


    public function used_qty(Lot $record){
        $used = 0;
        foreach ($record->items as $value){
            if($value->stitchingItem){
                $used += $value->stitchingItem->sum('quantity');
            }
        } 
        return $used;
    }


    public function remaining_percentage(Lot $record){

        return 10;
        $total = (float) ($record->total_quantity ?? 0);
        $used = $this->used_qty($record);
        if ($total > 0) {
            $percentage = ($used / $total) * 100;
        } else {
            $percentage = 0;
        }

        return round(min(max($percentage, 0), 100));
    }

    // In your Resource or Page file
    public static function shouldRegisterNavigation(): bool
    {
        return false; // Temporarily hidden from sidebar
    }



}
