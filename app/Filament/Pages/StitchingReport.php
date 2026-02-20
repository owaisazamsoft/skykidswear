<?php

namespace App\Filament\Pages;

use App\Models\Lot;
use App\Models\StitchingItem;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;


class StitchingReport extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    
    protected string $view = 'filament.pages.stitching-report';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;
    protected static string|\UnitEnum|null $navigationGroup = "Reports Management";


    public function table(Table $table): Table
    {
        return $table
            ->query(StitchingItem::query())
            ->columns([
                TextColumn::make('stitching.date')->label('Date')->date(),
                TextColumn::make('lotItem.lot.ref')->label('Lot'),
                TextColumn::make('employee.name')->label('Employee'),
                TextColumn::make('lotItem.product.name')->label('Product'),
                TextColumn::make('lotItem.size.name')->label('Size'),
                TextColumn::make('quantity')->label('Quantity'),
                TextColumn::make('price')->label('Price'),
                TextColumn::make('total')->label('Total'),
            ])
            ->filters([
                // Filter::make('date')->schema([
                //         DatePicker::make('date'),
                //     ])->query(function($query,$data){

                //         $query->when($data['date'],function($q, $d){
                //             $q->whereDate('date', '>=', $d);
                //         });

                // })
            ])
            ->recordActions([
                
            ]);

    }

    // In your Resource or Page file
    public static function shouldRegisterNavigation(): bool
    {
        return false; // Temporarily hidden from sidebar
    }


}
