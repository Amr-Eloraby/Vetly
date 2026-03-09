<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Http\Resources\MedicineResource;
use App\Models\Medicine;

class MedicienController extends Controller
{
    // show all medicien
    public function show()
    {
        $mediciens = Medicine::all();
        if ($mediciens->isEmpty()) {
            return ApiResponse::sendResponse(404, 'No medicines found');
        }
        return ApiResponse::sendResponse(200, 'Medicines retrieved successfully', MedicineResource::collection($mediciens));
    }
}
