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

use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';

    protected static ?string $recordTitleAttribute = 'title';       //global search

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
                        })
                        ->label(__('filament.title')),
                        Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(2048)
                        ->label(__('filament.slug')),
                    ]),
                ]),

                Card::make()
                ->schema([
                    Forms\Components\FileUpload::make('thumbnail')
                        ->directory('content\thumbnail')
                        ->image()
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('16:9')
                        ->imageResizeTargetWidth('1920')
                        ->imageResizeTargetHeight('1080')
                        ->label(__('filament.thumbnail')),
                    TinyEditor::make('short_content')
                        ->simple()
                        ->required()
                        ->label(__('filament.short_content')),
                ]),

                Card::make()
                ->schema([
                    Builder::make('block')
                    ->blocks([
                        Builder\Block::make('content')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            TinyEditor::make('content')
                                ->profile('ahlibeyt')
                                ->fileAttachmentsDirectory('content\imagesContent')
                                ->label(__('filament.content'))
                        ])->label(__('filament.content')),

                        Builder\Block::make('audio')
                        ->icon('heroicon-o-microphone')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label(__('filament.title_block_description')),
                            FileUpload::make('audio')
                                ->directory('content\audioFiles')
                                ->acceptedFileTypes(['audio/*'])
                                ->label(__('filament.audio')),
                        ])->label(__('filament.audio')),
                        
                        Builder\Block::make('image')
                            ->icon('heroicon-o-photograph')
                            ->schema([
                            Forms\Components\TextInput::make('image_description')
                                ->label(__('filament.image_block_description')),
                            FileUpload::make('image')
                                ->directory('content\imageContent')
                                ->image()
                                ->imageResizeMode('cover')
                                ->imageCropAspectRatio('16:9')
                                ->imageResizeTargetWidth('1920')
                                ->imageResizeTargetHeight('1080')
                                ->required()
                                ->label(__('filament.thumbnail')),
                        ])->label(__('filament.thumbnail')),
                    ])
                    ->collapsible()
                    ->label(__('filament.block'))
                ]),

                Card::make()
                ->schema([
                    Grid::make()
                    ->schema([
                        Select::make('category_id')
                            ->relationship('category', 'title')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label(__('filament.category')),
                        Select::make('tags')
                            ->multiple()
                            ->preload()
                            ->relationship('tags', 'title')
                            ->label(__('filament.tags')),
                        Forms\Components\Toggle::make('active')
                            ->label(__('filament.active')),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->unique(ignoreRecord: true)
                            ->minutesStep(15)
                            ->secondsStep(10)
                            ->label(__('filament.published_at')),
                    ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->words(3)
                    ->searchable()
                    ->label(__('filament.title')),
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label(__('filament.thumbnail')),
                Tables\Columns\IconColumn::make('active')
                    ->boolean()
                    ->label(__('filament.active')),
                Tables\Columns\TextColumn::make('published_at')
                    ->sortable()
                    ->dateTime('d-m-Y')
                    ->label(__('filament.published_at')),
                Tables\Columns\TextColumn::make('category.title')
                    ->label(__('filament.category')),
                Tables\Columns\TextColumn::make('updated_at')
                    ->sortable()
                    ->since()
                    ->label(__('filament.updated_at')),
            ])->defaultSort('published_at', 'desc')
            ->filters([
                TernaryFilter::make('active')
                    ->placeholder('-')
                    ->trueLabel(__('filament.published'))
                    ->falseLabel(__('filament.UnPublished'))
                    ->label(__('filament.active')),
                SelectFilter::make('Category')
                    ->relationship('category', 'title')
                    ->label(__('filament.category')),
                SelectFilter::make('Tag')
                    ->relationship('tags', 'title')
                    ->label(__('filament.tag'))
            ])
            ->actions([
                
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

    /**
     * Change category name
     */
    public static function getModelLabel(): string
    {
        return __('filament.create_post');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament.posts');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.posts');
    }
    
    /**
     * adding in navigation group
     */
    protected static function getNavigationGroup(): ?string
    {
        return __('filament.navigationGroupContent');
    }
}
