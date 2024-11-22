<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SemestresAcademicosResource\Pages;
use App\Filament\Resources\SemestresAcademicosResource\RelationManagers;
use App\Models\SemestresAcademicos;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SemestresAcademicosResource extends Resource
{
    protected static ?string $model = SemestresAcademicos::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('año')
                    ->label('Año')
                    ->options(function () {
                        $currentYear = now()->year;
                        $futureYears = range($currentYear, $currentYear + 10); // Opciones hasta 10 años en el futuro.
                        return array_combine($futureYears, $futureYears);
                    })
                    ->required(),
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('periodo_academico')
                    ->label('Periodo Académico')
                    ->options([
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4',
                        5 => '5',
                        6 => '6',
                    ])
                    ->required(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('año')
                ->label('Año')
                ->sortable()
                ->formatStateUsing(fn ($state) => (string) intval($state)),
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('periodo_academico')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListSemestresAcademicos::route('/'),
            'create' => Pages\CreateSemestresAcademicos::route('/create'),
            'edit' => Pages\EditSemestresAcademicos::route('/{record}/edit'),
        ];
    }
}
