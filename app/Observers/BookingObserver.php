<?php

namespace App\Observers;

use App\Models\Booking;
use App\Models\Notification;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        Notification::create([
            'type' => 'booking',
            'message' => 'New Booking From '.$booking->user->name.' For '.$booking->clinic->name,
            'notifiable_id' => $booking->id,
            'notifiable_type' => Booking::class,
        ]);
    }

    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     */
    public function restored(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     */
    public function forceDeleted(Booking $booking): void
    {
        //
    }
}
