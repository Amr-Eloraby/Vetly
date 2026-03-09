<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;



class BookingController extends Controller
{
    // Booking Clinic Appointment
    public function bookAppointment(BookingRequest $request)
    {
        $request->validated();

        $exists = Booking::where('clinic_id', $request->clinic_id)
            ->where('booking_date', $request->booking_date)
            ->where('booking_time', $request->booking_time)
            ->exists();

        if ($exists) {
            return ApiResponse::sendResponse(409, 'This appointment is not available, please choose another appointment');
        }

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'clinic_id' => $request->clinic_id,
            'service_type' => $request->service_type,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'status' => 'pending'
        ]);

        return ApiResponse::sendResponse(201, 'Appointment booked successfully',null);
    }

    // get user bookings
    public function getUserBookings()
    {
        $bookings = Booking::where('user_id', auth()->id())->get();
        return ApiResponse::sendResponse(200, 'User bookings retrieved successfully', BookingResource::collection($bookings));
    }   
}
