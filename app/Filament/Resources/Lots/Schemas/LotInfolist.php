<?php

namespace App\Filament\Resources\Lots\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LotInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('ref'),
                TextEntry::make('description')
                    ->placeholder('-'),
                TextEntry::make('total_quantity')
                    ->numeric(),
                TextEntry::make('date')
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
