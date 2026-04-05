<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\VaccinationService;
use App\Http\Resources\VaccinationResource;
use App\Http\Resources\VaccinatioRecordedResource;
use Illuminate\Http\Request;

class VaccinationController extends Controller
{
    protected $vaccinationService;
    
    public function __construct(VaccinationService $vaccinationService)
    {
        $this->vaccinationService = $vaccinationService;
    }

    public function getAvailableVaccines($animalId)
    {
        $vaccinations = $this->vaccinationService->generateSchedule($animalId);
        return ApiResponse::sendResponse(200, 'Vaccination schedule', $vaccinations);
    }

    public function takeVaccine(Request $request, $animalId, $vaccineId)
    {
        $date = $request->validate([
            'date' => 'required|date',
        ]);
        $vaccination = $this->vaccinationService->takeVaccine($animalId, $vaccineId, $date['date']);
        return ApiResponse::sendResponse($vaccination['status'], $vaccination['message'], $vaccination['data']);
    }

    public function makeAsDone($animalId, $vaccineId, Request $request)
    {
        $date = $request->validate([
            'date' => 'required|date',
        ]);
        $vaccinations = $this->vaccinationService->makeAsDone($animalId, $vaccineId, $date['date']);
        return ApiResponse::sendResponse(200, 'Vaccines updated successfully', $vaccinations);
    }
}
