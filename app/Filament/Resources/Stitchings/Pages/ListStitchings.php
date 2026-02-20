<?php

namespace App\Filament\Resources\Stitchings\Pages;

use App\Filament\Resources\Stitchings\StitchingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStitchings extends ListRecords
{
    protected static string $resource = StitchingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
