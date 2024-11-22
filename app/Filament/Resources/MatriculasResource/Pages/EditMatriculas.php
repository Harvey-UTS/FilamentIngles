<?php

namespace App\Filament\Resources\MatriculasResource\Pages;

use App\Filament\Resources\MatriculasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMatriculas extends EditRecord
{
    protected static string $resource = MatriculasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
