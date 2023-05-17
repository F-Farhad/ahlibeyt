<?php

namespace App\Observers;

use App\Models\Widget;
use Illuminate\Support\Facades\Storage;

class WidgetObserver
{
    /**
     * Handle the Widget "created" event.
     */
    public function created(Widget $widget): void
    {
        //
    }

    /**
     * Handle the Widget "updated" event.
     */
    public function updated(Widget $widget): void
    {
        //deleting the thumbnail if it was changed
        if ($widget->isDirty('thumbnail') && !is_null($widget->getOriginal('thumbnail'))) {
            Storage::disk('public')->delete($widget->getOriginal('thumbnail'));
        }
    }

    /**
     * Handle the Widget "deleted" event.
     */
    public function deleted(Widget $widget): void
    {
        if (!is_null($widget->thumbnail)) {
            Storage::disk('public')->delete($widget->thumbnail);
        }
    }

    /**
     * Handle the Widget "restored" event.
     */
    public function restored(Widget $widget): void
    {
        //
    }

    /**
     * Handle the Widget "force deleted" event.
     */
    public function forceDeleted(Widget $widget): void
    {
        //
    }
}
