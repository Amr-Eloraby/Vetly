<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Http\Requests\AnimalRequest;
use App\Http\Resources\AnimalResource;

class AnimalController extends Controller
{
    // Enter your animal
    public function enterAnimal(AnimalRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id; // Associate the animal with the authenticated user   
        $animal = Animal::create($validatedData);

        return ApiResponse::sendResponse(201, 'Animal entered successfully', new AnimalResource($animal));
    }

    // Get all animals for the authenticated user
    public function getAnimals()
    {
        $animals = Animal::where('user_id', auth()->id())->get();
        return ApiResponse::sendResponse(200, 'Animals retrieved successfully', AnimalResource::collection($animals));
    }
}
