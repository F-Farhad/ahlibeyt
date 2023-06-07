<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
            /**
             * Before deleting categories, check on empty
             */
            Actions\DeleteAction::make()
            ->before(function (Actions\DeleteAction $action) {
                if ($this->record->posts()->count() != 0) {
                    Notification::make()
                        ->warning()
                        ->title('Вы не можете удалить категорию')
                        ->body('Категория не пуста, удалите/перенесите все посты, перед удалением категории.')
                        ->persistent()
                        ->send();
         
                    $action->cancel();
                }
            })
        ];
    }
}
