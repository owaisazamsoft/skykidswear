<?php

namespace App\Filament\Resources\Stitchings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

use Filament\Schemas\Components\Section;

use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Columns\ImageColumn;

class StitchingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                        Section::make('General')
                            ->schema([
                                TextInput::make('ref')
                                    ->required()
                                    ->unique(ignoreRecord: true),

                                DatePicker::make('date')
                                    ->required(),
                                TextInput::make('total_quantity')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->readOnly(),
                                FileUpload::make('image')
                                    ->image()
                                    ->columnSpan(3),
                                Textarea::make('description')
                                    ->default(null)
                                    ->columnSpan(3),
                            ])->columns(3),
            ])->columns(1);
    }



    /**
     * Logic to calculate the sum of all quantities in the repeater
     */
    public static function updateTotalQuantity(Set $set, Get $get): void
    {

        // Get all items from the 'items' repeater
        $items = $get('items') ?? [];
        
        // Sum the quantity values
        $total = collect($items)->sum(function ($item) {
            return (int) ($item['quantity'] ?? 0);
        });

        // Set the value of the total_quantity field in the parent form
        $set('total_quantity', $total);

    }

}
