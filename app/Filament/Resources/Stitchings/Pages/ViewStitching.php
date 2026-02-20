<?php

namespace App\Filament\Resources\Stitchings\Pages;

use App\Filament\Resources\Stitchings\StitchingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStitching extends ViewRecord
{
    protected static string $resource = StitchingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
