<?php

namespace App\Filament\Resources\SemestresAcademicosResource\Pages;

use App\Filament\Resources\SemestresAcademicosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSemestresAcademicos extends ListRecords
{
    protected static string $resource = SemestresAcademicosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
