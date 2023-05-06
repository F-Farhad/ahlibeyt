<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        //deleting the thumbnail if it was changed
        if ($post->isDirty('thumbnail') && !is_null($post->getOriginal('thumbnail'))) {
            Storage::disk('public')->delete($post->getOriginal('thumbnail'));
        }

        //deleting the image content and audio files if it was changed
        if($post->isDirty('content') && !is_null($post->getOriginal('content'))){
            $postNewData = json_decode($post->content, true);
            $postOldData = json_decode($post->getOriginal('content'), true);

            foreach($postOldData as $postOldDataValue){
                $deleteImage = true;
                $deleteAudio = true;
                if($postOldDataValue['type'] == 'image'){
                    foreach($postNewData as $postNewDataValue){
                        if($postNewDataValue['type'] == 'image'){
                            if($postOldDataValue['data']['image'] == $postNewDataValue['data']['image']){
                                $deleteImage = false;
                            }
                        }
                    }
                }elseif($postOldDataValue['type'] == 'audio'){
                    foreach($postNewData as $postNewDataValue){
                        if($postNewDataValue['type'] == 'audio'){
                            if($postOldDataValue['data']['audio'] == $postNewDataValue['data']['audio']){
                                $deleteAudio = false;
                            }
                        }
                    }
                }

                if($deleteImage && isset($postOldDataValue['data']['image'])){
                    Storage::disk('public')->delete($postOldDataValue['data']['image']);
                }elseif($deleteAudio && isset($postOldDataValue['data']['audio'])){
                    Storage::disk('public')->delete($postOldDataValue['data']['audio']);
                }
            }
        }
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        if (!is_null($post->thumbnail)) {
            Storage::disk('public')->delete($post->thumbnail);
        }
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
