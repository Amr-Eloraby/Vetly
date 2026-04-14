<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::paginate(10);
        return view('dashboard.booking.booking', compact('bookings'));
    }

    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'confirmed';
        $booking->save();

        return redirect()->route('booking.index');
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'cancelled';
        $booking->save();

        return redirect()->route('booking.index');
    }
}
