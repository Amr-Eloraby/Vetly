<?php

namespace App\Observers;

use App\Models\Medicine;
use App\Models\Notification;

class MedicineObserver
{
    /**
     * Handle the Medicine "created" event.
     */
    public function created(Medicine $medicine): void
    {
        //
    }

    /**
     * Handle the Medicine "updated" event.
     */
    public function updated(Medicine $medicine): void
    {
        if($medicine->isDirty('stock') && $medicine->stock <= 10) {
            Notification::create([
                'type' => 'stock',
                'message' => 'Medicine '.$medicine->name.' Is Running Low On Stock',
                'notifiable_id' => $medicine->id,
                'notifiable_type' => Medicine::class,
            ]);
        }
    }

    /**
     * Handle the Medicine "deleted" event.
     */
    public function deleted(Medicine $medicine): void
    {
        //
    }

    /**
     * Handle the Medicine "restored" event.
     */
    public function restored(Medicine $medicine): void
    {
        //
    }

    /**
     * Handle the Medicine "force deleted" event.
     */
    public function forceDeleted(Medicine $medicine): void
    {
        //
    }
}
