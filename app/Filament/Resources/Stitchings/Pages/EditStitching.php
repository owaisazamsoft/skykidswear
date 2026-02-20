<?php

namespace App\Filament\Resources\Stitchings\Pages;

use App\Filament\Resources\Stitchings\StitchingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditStitching extends EditRecord
{
    protected static string $resource = StitchingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
