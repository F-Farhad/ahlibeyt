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
        if ($post->isDirty('thumbnail') && !is_null($post->getOriginal('thumbnail'))) {
            Storage::disk('public')->delete($post->getOriginal('thumbnail'));
        }

        if($post->isDirty('content') && !is_null($post->getOriginal('content'))){
            $postNewData = json_decode($post->content, true);
            // dump($postNewData);

            $postOldData = json_decode($post->getOriginal('content'), true);
            // dd($postOldData);

            foreach($postOldData as $postOldDataValue){
                $deleteFiles = true;
                if($postOldDataValue['type'] == 'image'){
                    foreach($postNewData as $postNewDataValue){
                        if($postNewDataValue['type'] == 'image'){
                            if($postOldDataValue['data']['image'] == $postNewDataValue['data']['image']){
                                $deleteFiles = false;
                            }
                        }
                    }
                }
                if($deleteFiles && isset($postOldDataValue['data']['image'])){
                    Storage::disk('public')->delete($postOldDataValue['data']['image']);
                }
            }

            // if(!array_key_exists($keyOld, $postNewData)){
            //     Storage::disk('public')->delete($postOldDataValue['data']['image']);
            // }elseif($postNewData[$keyOld]['data']['image'] != $postOldData[$keyOld]['data']['image']){
            //     Storage::disk('public')->delete($postOldDataValue['data']['image']);
            // }
            

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
