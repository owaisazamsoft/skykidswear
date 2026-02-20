<?php

namespace App\Filament\Resources\Stitchings\Tables;

use App\Filament\Resources\StitchingItems\StitchingItemResource;
use App\Filament\Resources\Stitchings\StitchingResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class StitchingsTable
{

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->searchable(),
                TextColumn::make('ref')->searchable(),
                TextColumn::make('ref')->searchable()->color('primary')
                ->url(fn ($record) => StitchingResource::getUrl('view', ['record' => $record->id])),
                ImageColumn::make('image'),
                TextColumn::make('description')->searchable(),
                TextColumn::make('total_quantity')->numeric(),
                TextColumn::make('date')->date()            
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('view_items')
                ->iconButton()
                ->icon('heroicon-m-inbox-stack')
                ->color('info')
                ->url(fn ($record): string => StitchingResource::getUrl('items', [
                    'record' => $record->id,
                ])),
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
