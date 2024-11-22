<?php

namespace App\Filament\Resources\MatriculasResource\Pages;

use App\Filament\Resources\MatriculasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMatriculas extends ListRecords
{
    protected static string $resource = MatriculasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
