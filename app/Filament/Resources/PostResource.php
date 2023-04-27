<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\TemporaryUploadedFile;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';

    protected static ?string $navigationGroup = 'Контент';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(2048)
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set, $state) {
                            $set('slug', \Illuminate\Support\Str::slug($state));
                        }),
                        Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(2048),
                    ]),
                ]),

                Card::make()
                ->schema([
                    Forms\Components\FileUpload::make('thumbnail')
                    ->directory('content\thumbnail'),
                ]),

                Card::make()
                ->schema([
                    Builder::make('block')
                    ->blocks([
                        Builder\Block::make('content')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            \Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor::make('content')
                            ->fileAttachmentsDirectory('content\imagesContent')
                        ]),
                        Builder\Block::make('audio')
                        ->icon('heroicon-o-microphone')
                        ->schema([
                            Forms\Components\TextInput::make('title'),
                            FileUpload::make('audio')
                            ->directory('content\audioFiles')
                        ])
                    ])
                    ->collapsible()
                ]),

                Card::make()
                ->schema([
                    Grid::make()
                    ->schema([
                        Select::make('category_id')
                        ->relationship('category', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),
                        Select::make('tags')
                        ->multiple()
                        ->preload()
                        ->relationship('tags', 'title'),
                        Forms\Components\Toggle::make('active'),
                        Forms\Components\DateTimePicker::make('published_at'),
                    ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('category.title'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
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
            RelationManagers\TagsRelationManager::class
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }    
}
