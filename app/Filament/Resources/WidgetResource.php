<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WidgetResource\Pages;
use App\Filament\Resources\WidgetResource\RelationManagers;
use App\Models\Widget;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WidgetResource extends Resource
{
    protected static ?string $model = Widget::class;

    protected static ?string $navigationIcon = 'heroicon-o-template';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    Forms\Components\TextInput::make('key')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->label(__('filament.key')),
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(2048)
                        ->label(__('filament.title')),
                    // Forms\Components\FileUpload::make('thumbnail')
                    //     ->directory('widget\image')
                    //     ->image()
                    //     ->label(__('filament.thumbnail')),
                    \Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor::make('content')
                        ->profile('ahlibeyt')
                        ->label(__('filament.content')),
                    Forms\Components\Toggle::make('active'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label(__('filament.key')),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('filament.title')),
                // Tables\Columns\TextColumn::make('thumbnail'),
                Tables\Columns\IconColumn::make('active')
                    ->boolean()
                    ->label(__('filament.active')),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d-m-Y')
                    ->label(__('filament.updated_at')),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListWidgets::route('/'),
            'create' => Pages\CreateWidget::route('/create'),
            'edit' => Pages\EditWidget::route('/{record}/edit'),
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
     * Change widget name
     */
    public static function getModelLabel(): string
    {
        return __('filament.create_widget');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament.widgets');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.widgets');
    }
}
