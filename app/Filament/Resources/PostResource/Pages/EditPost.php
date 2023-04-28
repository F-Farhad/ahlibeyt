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
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['content'] = json_encode($data['block']);
        return $data;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
    
        $data['block'] = json_decode($data['content'], true);
        return $data;
    }
}
