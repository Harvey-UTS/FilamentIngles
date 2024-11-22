<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GruposResource\Pages;
use App\Filament\Resources\GruposResource\RelationManagers;
use App\Models\Grupos;
use App\Models\Cursos;
use App\Models\semestresAcademicos;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;

class GruposResource extends Resource
{
    protected static ?string $model = Grupos::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),

                // Select para curso_id (muestra los nombres de los cursos)
                Forms\Components\Select::make('curso_id')
                    ->label('Curso')
                    ->options(Cursos::all()->pluck('nombre', 'id'))  // Muestra nombres de los cursos
                    ->required(),

                // Select para semestre_academico_id (muestra los semestres académicos)
                Forms\Components\Select::make('semestre_academico_id')
                    ->label('Semestre Académico')
                    ->options(semestresAcademicos::all()->pluck('nombre', 'id')) // Muestra los nombres de los semestres
                    ->required(),

                // Select para docente_id (muestra los usuarios con rol "docente")
                Forms\Components\Select::make('docente_id')
                    ->label('Docente')
                    ->options(
                        User::role('docente')  // Obtiene usuarios con el rol "docente" usando Spatie
                            ->pluck('name', 'id')  // Muestra el nombre del docente
                    )
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('curso_id')
                    ->label('Curso')
                    ->formatStateUsing(fn ($state) => Cursos::find($state)->nombre ?? 'N/A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('semestre_academico_id')
                    ->label('Semestre Académico')
                    ->formatStateUsing(fn ($state) => semestresAcademicos::find($state)->nombre ?? 'N/A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('docente_id')
                    ->label('Docente')
                    ->formatStateUsing(fn ($state) => User::find($state)->name ?? 'N/A')
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
                // Puedes añadir filtros aquí si es necesario
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
            'index' => Pages\ListGrupos::route('/'),
            'create' => Pages\CreateGrupos::route('/create'),
            'edit' => Pages\EditGrupos::route('/{record}/edit'),
        ];
    }
}
