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
                        }),
                        TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(2048),
                    ]),
                ]),

                Card::make()
                ->schema([
                    FileUpload::make('thumbnail')
                    ->directory('content\thumbnail'),
                    \Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor::make('short_content')
                    ->simple()
                    ->required()
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
                            TextInput::make('title'),
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
                        Toggle::make('active'),
                        DateTimePicker::make('published_at'),
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
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
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
