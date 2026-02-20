<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Employee Information')
                ->description('Enter the employee details.')
                ->schema([

                    TextInput::make('name')->required(),
                    TextInput::make('father_name'),
                    Select::make('gender')
                    ->options([
                            'male' => 'Male',
                            'female' => 'Female',
                            'other' => 'Other',
                        ])
                        ->required(),
                    TextInput::make('phone')->tel(),
                    Select::make('group_id')
                        ->relationship('group', 'name')
                        ->nullable()
                        ->preload(),
                    Select::make('department_id')
                        ->relationship('department', 'name')
                        ->nullable()
                        ->preload(),
                    Select::make('designation_id')
                        ->relationship('designation', 'name')
                        ->nullable()
                        ->preload(),
                    Select::make('status')
                    ->options([
                            '1' => 'Active',
                            '0' => 'Deactive',
                        ])
                        ->required(),

                    TextInput::make('nic'),
                    TextInput::make('email')->label('Email address')->email(),
                    DatePicker::make('joined_date'),
                ])->columns(3)
                
            ])->columns(1);
    }
}
