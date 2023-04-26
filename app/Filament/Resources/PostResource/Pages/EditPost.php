<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if($data['block']){
            $data['content'] = json_encode($data['block']);
        }

        return $data;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if($data['content']){
            $data['block'] = json_decode($data['content'], true);
        }

        return $data;
    }
}
