<?php

namespace App\Filament\Resources\Lots\Tables;

use App\Models\Lot;
use App\Models\Product;
use App\Models\Size;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LotsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->searchable(),
                TextColumn::make('ref')->searchable(),
                TextColumn::make('product.category.name')->searchable(),
                TextColumn::make('product.brand.name')->searchable(),
                TextColumn::make('product.name')
                ->searchable()
                ->state(function ($record){
                    return $record->product->code.'-'.$record->product->name;
                }),
                TextColumn::make('product.size.name')->searchable(),
                TextColumn::make('total_quantity')->label('Quantity')->numeric(),
                TextColumn::make('date')->date(),
            ])
            ->filters([
                //

                Filter::make('date_from')
                ->schema([DatePicker::make('from')->label('Date From')])
                ->query(function($query,$data){
                    return $query->when($data['from'],function($q, $date){
                        return $q->whereDate('date', '>=', $date);
                    });
                }),

                Filter::make('date_to')
                ->schema([DatePicker::make('to')->label('Date To')])
                ->query(function($query,$data){
                    return $query->when($data['to'],function($q, $date){
                        return $q->whereDate('date', '<=', $date);
                    });
                }),

                SelectFilter::make('id')
                ->label('Lot')
                ->searchable()
                ->getOptionLabelUsing(fn ($value): ?string => Lot::where('id', $value)->value('ref'))
                ->getSearchResultsUsing(function (string $search): array {
                    return Lot::query()
                        ->where('ref', 'like', "%{$search}%")
                        ->limit(10)
                        ->pluck('ref', 'id')
                        ->toArray();
                })
                ->preload()
                ->columns(1)
                ->query(function (Builder $query, array $data): Builder {
                    return $query->when($data['value'], fn ($q, $value) 
                            => $q->where('id', $value));
                }),

                SelectFilter::make('product_id')
                ->label('Product')
                ->searchable(['code','name'])
                ->preload()
                ->relationship('product','id')
                 ->getOptionLabelFromRecordUsing(function ($record) {
                    return $record->name.'-'.$record->code;
                })
                ->columns(1),


            SelectFilter::make('size')
                ->label('Size')
                ->searchable()
                ->getOptionLabelUsing(function($value){ 
                    return Size::where('id', $value)->value('name'); 
                })
                ->options(function(){ 
                    return Size::query()
                        ->limit(10)
                        ->pluck('name', 'id')
                        ->toArray();
                })
                ->getSearchResultsUsing(function($search){
                    return Size::where('name', 'like', "%{$search}%")
                            ->limit(10)
                            ->pluck('name', 'id')
                            ->toArray();
                })
                ->preload()
                ->columns(1)
                ->query(function($query, array $data){
                    return $query->when($data['value'], function ($q, $value) {
                        return $q->whereHas('product.size', function (Builder $innerQuery) use ($value) {
                            return $innerQuery->where('id', $value);
                        });
                    });
                }),



                // SelectFilter::make('id')
                // ->label('Lot')
                // ->searchable()
                // ->preload()
                // ->options(
                //     fn () => Product::query()->pluck('code', 'id')->toArray()
                // )->columns(1)->query(function (Builder $query, array $data): Builder {
                //     return $query
                //         ->when($data['id'], fn ($q, $value) => $q->where('id', '>=', $value));
                // })

                
            ],FiltersLayout::AboveContent)
            ->filtersFormColumns(3)
            ->recordActions([
                // ViewAction::make(),
                EditAction::make()->iconButton(),
            ])
            ->recordUrl(null)
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
