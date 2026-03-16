<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\VaccinationService;
use App\Http\Resources\VaccinationResource;
use App\Http\Resources\VaccinatioRecordedResource;

class VaccinationController extends Controller
{
    protected $vaccinationService;
    
    public function __construct(VaccinationService $vaccinationService)
    {
        $this->vaccinationService = $vaccinationService;
    }

    public function getAvailableVaccines($animalId)
    {
        $vaccinations = $this->vaccinationService->getAvailableVaccines($animalId);
        return ApiResponse::sendResponse(200, 'Available vaccines', VaccinationResource::collection($vaccinations));
    }

    public function takeVaccine($animalId, $vaccineId)
    {
        $vaccination = $this->vaccinationService->takeVaccine($animalId, $vaccineId);
        return ApiResponse::sendResponse($vaccination['status'], $vaccination['message'], $vaccination['data']);
    }

    public function getUpcomingVaccines($animalId)
    {
        $vaccinations = $this->vaccinationService->getUpcomingVaccines($animalId);
        return ApiResponse::sendResponse(200, 'Upcoming vaccines', VaccinatioRecordedResource::collection($vaccinations));
    }
}
