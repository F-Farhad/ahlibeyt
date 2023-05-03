<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Closure;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Model;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()
            ->schema([
                Grid::make()
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(2048)
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set, $state) {
                            $set('slug', \Illuminate\Support\Str::slug($state));
                        })
                        ->label(__('filament.title')),
                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(2048)
                        ->label(__('filament.slug')),
                ]),
            ]),

            Card::make()
            ->schema([
                FileUpload::make('thumbnail')
                    ->directory('content\thumbnail')
                    ->label(__('filament.thumbnail')),
                \Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor::make('short_content')
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
                        \Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor::make('content')
                        ->fileAttachmentsDirectory('content\imagesContent')
                        ->label(__('filament.content'))
                    ])
                    ->label(__('filament.content')),
                    Builder\Block::make('audio')
                    ->icon('heroicon-o-microphone')
                    ->schema([
                        TextInput::make('title')
                            ->label(__('filament.title')),
                            FileUpload::make('audio')
                            ->directory('content\audioFiles')
                            ->label(__('filament.audio')),
                    ])
                    ->label(__('filament.audio')),
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
                    Toggle::make('active')
                        ->label(__('filament.active')),
                    DateTimePicker::make('published_at')
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
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {           //before creating
                    $data['content'] = json_encode($data['block']);
                    return $data;
                }),
            ])
            ->actions([
                EditAction::make()
                ->mutateRecordDataUsing(function (array $data): array {         //before filling
                    $data['block'] = json_decode($data['content'], true);
                    return $data;
                })
                ->mutateFormDataUsing(function (array $data): array {           //before saving
                    $data['content'] = json_encode($data['block']);
                    return $data;
                })
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    } 
}
