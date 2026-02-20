<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EmployeeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('group.name')
                    ->label('Group'),
                TextEntry::make('department.name')
                    ->label('Department'),
                TextEntry::make('designation.name')
                    ->label('Designation'),
                TextEntry::make('phone'),
                TextEntry::make('gender'),
                TextEntry::make('nic'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('joined_date')
                    ->dateTime(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
