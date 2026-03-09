<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Models\Clinic;
use App\Http\Resources\ClinicResource;

class ClinicController extends Controller
{
    // Return a list of clinics
    public function index()
    {
        $clinics = Clinic::all();
        if ($clinics->isEmpty()) {
            return ApiResponse::sendResponse(404, 'No clinics found');
        }
        return ApiResponse::sendResponse(200, 'Clinics retrieved successfully', ClinicResource::collection($clinics));
    }

    // Return details of a specific clinic
    public function show($id)
    {
        $clinic = Clinic::find($id);
        if (!$clinic) {
            return ApiResponse::sendResponse(404, 'Clinic not found');
        }
        return ApiResponse::sendResponse(200, 'Clinic retrieved successfully', new ClinicResource($clinic));
    }
}
