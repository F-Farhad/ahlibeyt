<?php

namespace App\Filament\Resources\PostResource\RelationManagers;

use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TagsRelationManager extends RelationManager
{
    protected static string $relationship = 'tags';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(191)
                    ->unique(ignoreRecord: true)
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $set('slug', \Illuminate\Support\Str::slug($state));
                    })
                    ->label(__('filament.title')),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(191)
                    ->label(__('filament.slug')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('filament.title')),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('filament.updated_at')),
                
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    } 

    /**
     * Change tags name
     */
    public static function getModelLabel(): string
    {
        return __('filament.tag');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('filament.tags');
    }
}
