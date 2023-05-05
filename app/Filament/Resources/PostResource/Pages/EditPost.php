<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Post;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->before(function () {

                // $files = Storage::allFiles('public/content');

                // $posts = Post::all();

                // $allFilesFromPosts = [];

                // foreach($posts as $post){
                //     $allFilesFromPosts[] = $post->thumbnail;
                // }
                // dd($allFilesFromPosts);
                
                // dd($files);

                // foreach($files as $file){
                //     // dd($file);
                //     foreach($allFilesFromPosts as $filePost){
                //         // dd($file);
                //         if($file == 'public/content/audioFiles\OCSALJ7KzkjRTk3YFLilu6YgYinL9D-metac2FtcGxlLTlzLm1wMw==-.mp3'){
                //             dd('if');
                //         }
                //     }
                // }

                // dd('end');
                

                // dd($this->data);
                // $FilesForDelete = [];
                // array_push($FilesForDelete, $this->data['thumbnail']);

                // foreach($this->data['block'] as $itemBlock){
                //     if($itemBlock['type'] == 'audio'){
                //         array_push($FilesForDelete, $itemBlock['data']['audio']);
                //     }elseif($itemBlock['type'] == 'image'){
                //         array_push($FilesForDelete, $itemBlock['data']['image']);
                //     }
                // }

                // // dd($FilesForDelete);
                // foreach($FilesForDelete as $file){
                //     // dd($file);
                //     // Storage::delete(asset('/storage/' . $file));
                //     Storage::disk('public')->delete($file);
                // }

        //         $content = json_decode($post->content, true);

        //   dd($content);

        // $audioFiles = [];
        // foreach($content as $item){
       
        //     if($item['type'] == 'audio'){
        //         $audioFiles[] = $item['data']['audio'];
        //     }
        // }

        // dd($audioFiles);

            }),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // $post = Post::find($this->data['id']);
        // $postData = json_decode($post->content, true);
        // // dump($postData);
        // $formData = $data['block'];

        // foreach($postData as $postDataValue){
        //     if($postDataValue['type'] == 'image'){
        //         foreach($formData as $formDataValue){
        //             if($formDataValue['type'] == 'image'){
        //                 if($postDataValue['data']['image'] == $formDataValue['data']['image']){
        //                     exit;
        //                 }
        //             }
        //         }
        //         Storage::disk('public')->delete($postDataValue['data']['image']);
        //     }
        // }
        // dd($formData);



        // dd(collect(Storage::disk('public')->allFiles()));
        $data['content'] = json_encode($data['block']);
        return $data;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['block'] = json_decode($data['content'], true);
        return $data;
    }
}
