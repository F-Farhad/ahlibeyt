<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Filament\Resources\CategoryResource\RelationManagers\PostsRelationManager;
use App\Models\Category;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'title';           //global search

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(2048)
                    ->reactive()
                    ->label(__('filament.title'))
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $set('slug', \Illuminate\Support\Str::slug($state));
                    }),
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
                    ->searchable()
                    ->label(__('filament.title')),
                Tables\Columns\TextColumn::make('updated_at')
                    ->sortable()
                    ->dateTime()
                    ->label(__('filament.updated_at')),
                Tables\Columns\TextColumn::make('posts_count')->counts('posts')
                    ->label(__('filament.posts')),
            ])
            ->filters([
                //
            ])
            ->actions([

            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            PostsRelationManager::class
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    } 

    /**
     * adding in navigation group
     */
    protected static function getNavigationGroup(): ?string
    {
        return __('filament.navigationGroupContent');
    }
    
    /**
     * Change category name
     */
    public static function getModelLabel(): string
    {
        return __('filament.create_category');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament.categories');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.categories');
    }

}
