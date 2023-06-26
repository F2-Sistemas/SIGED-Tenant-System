<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrcamentoResource\Pages;
use App\Filament\Resources\OrcamentoResource\RelationManagers;
use App\Models\Orcamento;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TenancyBaseResource;

class OrcamentoResource extends TenancyBaseResource
{
    protected static ?string $model = Orcamento::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    // protected static string | array $middlewares = [];
    // protected static bool $shouldAuthorizeWithGate = true;
    protected static bool $shouldIgnorePolicies = false;
    protected static ?bool $tenantIsRequired = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tipo')
                    ->required(),
                Forms\Components\TextInput::make('ano_vigencia_inicio')
                    ->required(),
                Forms\Components\TextInput::make('ano_vigencia_fim'),
                Forms\Components\Toggle::make('ative'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('tipo'),
                Tables\Columns\TextColumn::make('ano_vigencia_inicio'),
                Tables\Columns\TextColumn::make('ano_vigencia_fim'),
                Tables\Columns\IconColumn::make('ative')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListOrcamentos::route('/'),
            'create' => Pages\CreateOrcamento::route('/create'),
            'edit' => Pages\EditOrcamento::route('/{record}/edit'),
        ];
    }    
}
