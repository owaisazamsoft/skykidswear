<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product Information')
                ->description('Enter the product details.')
                ->schema([

                    TextInput::make('name')
                        ->columnSpan(2),
                    TextInput::make('code')
                        ->required(),
                    TextInput::make('price')
                        ->numeric(),
                    Select::make('size_id')
                        ->relationship('size', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('category_id')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('brand_id')
                        ->relationship('brand', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    FileUpload::make('image')
                        ->image()
                        ->columnSpan(3),
                    TextInput::make('description')
                        ->columnSpan(3),
                ])


            ])->columns(1);
    
    }


}
