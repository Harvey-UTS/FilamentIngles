<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InscripcionesResource\Pages;
use App\Models\Inscripciones;
use App\Models\User;
use App\Models\Matriculas;
use App\Models\Grupos;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InscripcionesImport;
use Filament\Tables\Actions\Action;

class InscripcionesResource extends Resource
{
    protected static ?string $model = Inscripciones::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('cedula')
                    ->label('Cédula')
                    ->numeric()
                    ->required()
                    ->unique(User::class, 'cedula'),
                Forms\Components\TextInput::make('name')
                    ->label('Nombre del Estudiante')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->unique(User::class, 'email'),
                Forms\Components\TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required(),
                Forms\Components\Select::make('grupo_id')
                    ->label('Grupo')
                    ->options(Grupos::all()->pluck('nombre', 'id'))
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.cedula')->label('Cédula'),
                Tables\Columns\TextColumn::make('user.name')->label('Estudiante'),
                Tables\Columns\TextColumn::make('matricula.grupo.nombre')->label('Grupo'),
                Tables\Columns\TextColumn::make('created_at')->label('Creado')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->headerActions([ // Aquí se agrega el botón de importación
                Action::make('importar')
                ->label('Importar Inscripciones')
                ->url(route('mostrar.importar.inscripciones')) // Esta sigue siendo la ruta GET que carga el archivo de importación
                ->openUrlInNewTab(false), // Esto asegura que la URL no se abra en una nueva pestaña
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInscripciones::route('/'),
            'create' => Pages\CreateInscripciones::route('/create'),
            'edit' => Pages\EditInscripciones::route('/{record}/edit'),
        ];
    }
}
