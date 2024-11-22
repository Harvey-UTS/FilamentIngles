<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MatriculasResource\Pages;
use App\Models\Matriculas;
use App\Models\Grupos;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class MatriculasResource extends Resource
{
    protected static ?string $model = Matriculas::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Campo de estudiante_id como select con usuarios que tienen el rol 'estudiante'
                Forms\Components\Select::make('estudiante_id')
                    ->label('Estudiante')
                    ->options(function () {
                        return \App\Models\User::role('estudiante')->pluck('name', 'id')->toArray();
                    })
                    ->required(),

                // Campo de grupo_id como select con todos los grupos disponibles
                Forms\Components\Select::make('grupo_id')
                    ->label('Grupo')
                    ->options(function () {
                        return Grupos::pluck('nombre', 'id')->toArray();
                    })
                    ->required(),

                // Campo estado como select con los posibles valores del enum
                Forms\Components\Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'no aprobado' => 'No Aprobado',
                        'cancelado' => 'Cancelado',
                        'pendiente' => 'Pendiente',
                    ])
                    ->required(),

                // Campo nota_final
                Forms\Components\TextInput::make('nota_final')
                    ->numeric()
                    ->nullable()
                    ->maxLength(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('estudiante_id')
                    ->label('Estudiante')
                    ->getStateUsing(fn (Matriculas $record) => $record->estudiante->name)
                    ->sortable(),

                Tables\Columns\TextColumn::make('grupo_id')
                    ->label('Grupo')
                    ->getStateUsing(fn (Matriculas $record) => $record->grupo->nombre)
                    ->sortable(),

                Tables\Columns\TextColumn::make('estado')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nota_final')
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
            'index' => Pages\ListMatriculas::route('/'),
            'create' => Pages\CreateMatriculas::route('/create'),
            'edit' => Pages\EditMatriculas::route('/{record}/edit'),
        ];
    }
}
