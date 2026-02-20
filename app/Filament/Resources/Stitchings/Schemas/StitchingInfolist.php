<?php

namespace App\Filament\Resources\Stitchings\Schemas;

use App\Filament\Resources\Stitchings\StitchingResource;
use Filament\Actions\Action;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\Layout\Split;
use Illuminate\Support\HtmlString;

class StitchingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                    Section::make('Invoice Details')
                        ->headerActions([
                            // This puts a Print button at the top right of the invoice section
                            Action::make('print')
                                ->label('Print Invoice')
                                ->icon('heroicon-m-printer')
                                ->color('success')
                                ->alpineClickHandler('window.print()'),
                        ])
                        ->schema([
                            ViewEntry::make('invoice_view')
                                ->view('filament.resources.stitchings.components.items-table') // Points to your blade file
                                ->columnSpanFull(),
                        ]),

         
        
            ])->columns(1);
    }
}
