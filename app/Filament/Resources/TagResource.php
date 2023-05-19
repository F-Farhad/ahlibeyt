<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Filament\Resources\TagResource\RelationManagers;
use App\Models\Tag;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(2048)
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $set('slug', \Illuminate\Support\Str::slug($state));
                    })
                    ->label(__('filament.title')),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(2048)
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
                Tables\Columns\TextColumn::make('posts_count')->counts('posts')
                    ->label(__('filament.posts')),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTags::route('/'),
        ];
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

    public static function getNavigationLabel(): string
    {
        return __('filament.tags');
    }

    /**
     * adding in navigation group
     */
    protected static function getNavigationGroup(): ?string
    {
        return __('filament.navigationGroupContent');
    }
}
