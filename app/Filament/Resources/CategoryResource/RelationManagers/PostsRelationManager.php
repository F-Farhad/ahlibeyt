<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Closure;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;


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
                            ->maxLength(191)
                            ->reactive()
                            ->afterStateUpdated(function (Closure $set, $state) {
                                $set('slug', \Illuminate\Support\Str::slug($state));
                        })
                        ->label(__('filament.title')),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(191)
                            ->label(__('filament.slug')),
                    ]),
                ]),
                Card::make()
                ->schema([
                    Grid::make()
                    ->schema([
                        DateTimePicker::make('published_at')
                            ->unique(ignoreRecord: true)
                            ->minutesStep(15)
                            ->secondsStep(10)
                            ->label(__('filament.published_at')), 
                        Select::make('category_id')
                            ->relationship('category', 'title')
                            ->required()
                            ->label(__('filament.category')),    
                    ]),
                        Toggle::make('active')
                            ->label(__('filament.active')),
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
                //
            ])
            ->actions([
                EditAction::make()
            ]);
    } 
}
