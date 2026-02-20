<?php

namespace App\Filament\Resources\Stitchings;

use App\Filament\Resources\Stitchings\Pages\CreateStitching;
use App\Filament\Resources\Stitchings\Pages\EditStitching;
use App\Filament\Resources\Stitchings\Pages\ListStitchings;
use App\Filament\Resources\Stitchings\Pages\ViewStitching;
use App\Filament\Resources\Stitchings\Schemas\StitchingForm;
use App\Filament\Resources\Stitchings\Schemas\StitchingInfolist;
use App\Filament\Resources\Stitchings\Tables\StitchingsTable;
use App\Models\Stitching;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StitchingResource extends Resource
{
    protected static ?string $model = Stitching::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEyeDropper;
    protected static string|\UnitEnum|null $navigationGroup = "Production Management";
    protected static ?string $navigationLabel = 'Stitchings';

    protected static ?string $recordTitleAttribute = 'ref';

    public static function form(Schema $schema): Schema
    {
        return StitchingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StitchingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StitchingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStitchings::route('/'),
            'create' => CreateStitching::route('/create'),
            'view' => ViewStitching::route('/{record}'),
            'edit' => EditStitching::route('/{record}/edit'),
            'items' => Pages\ManageStitchingItems::route('/{record}/items'),
        ];
    }


    // In your Resource or Page file
    public static function shouldRegisterNavigation(): bool
    {
        return false; // Temporarily hidden from sidebar
    }
}
