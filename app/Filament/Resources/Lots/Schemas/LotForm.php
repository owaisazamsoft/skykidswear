<?php

namespace App\Filament\Resources\Lots\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Columns\ImageColumn;

class LotForm
{


    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Tabs::make('Lot Management')
                    ->tabs([
                        Tab::make('General')
                            ->icon('heroicon-m-information-circle')
                            ->schema([
                                TextInput::make('ref')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->columnSpan(2),
                                DatePicker::make('date')
                                    ->required(),
                                TextInput::make('total_quantity')
                                    ->required()
                                    ->numeric()
                                    ->default(0),
                                FileUpload::make('image')
                                    ->image()
                                    ->columnSpan(3),
                                Textarea::make('description')
                                    ->default(null)
                                    ->columnSpan(3),
                            ])->columns(2),

                        // Tab::make('Items')
                        //     ->icon('heroicon-m-list-bullet')
                        //     ->schema([

                        //         Repeater::make('items')
                        //             ->relationship('items')
                        //             ->schema([
                        //                 Select::make('product_id')
                        //                     ->relationship('product', 'name')
                        //                     ->searchable()
                        //                     ->preload()
                        //                     ->required()
                        //                     ->columnSpan(2),
                        //                 Select::make('color_id')
                        //                     ->relationship('color', 'name')
                        //                     ->preload()
                        //                     ->required(),
                        //                 Select::make('size_id')
                        //                     ->relationship('size', 'name')
                        //                     ->preload()
                        //                     ->required(),
                        //                 TextInput::make('quantity')
                        //                     ->numeric()
                        //                     ->required()
                        //                     ->default(1),
                        //                 TextInput::make('description')
                        //                     ->columnSpan(5)

                        //         ])
                        //         ->columns(5)
                        //         ->afterStateUpdated(function (Set $set, Get $get) {
                        //             self::updateTotalQuantity($set, $get);
                        //         }),

                            // ])->columns(1)
                ]),

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
