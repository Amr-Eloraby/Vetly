<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ClinicsRequest;
use App\Models\Clinic;
use App\Services\ImageService;
use App\Http\Requests\Web\UpdateClinicRequest;

class ClinicController extends Controller
{
    // return view for create clinic
    public function showCreate()
    {
        return view('dashboard.clinics.create');
    }

    // Create clinic
    public function store(ClinicsRequest $request)
    {   
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = ImageService::upload($request->file('image'), 'clinic_images');
            $validatedData['image'] = $imagePath;
        }

        Clinic::create($validatedData);

        return to_route('clinic.create')->with('success-create-clinics', 'Clinic created successfully!');
    }

    // return view for show all clinics
    public function show()
    {
        $clinics = Clinic::all();
        return view('dashboard.clinics.show', compact('clinics'));
    }

    // return view for update clinic
    public function edit($id)
    {
        $clinic = Clinic::findOrFail($id);
        return view('dashboard.clinics.update', compact('clinic')); 
    }

    // Update clinic
    public function update(UpdateClinicRequest $request, $id)
    {
        $validatedData = $request->validated();

        $clinic = Clinic::findOrFail($id);

        if ($request->hasFile('image')) {
            ImageService::delete($clinic->image);
            $imagePath = ImageService::upload($request->file('image'), 'clinic_images');
            $validatedData['image'] = $imagePath;
        }

        $clinic->update($validatedData);

        return to_route('clinic.show')->with('success-update-clinics', 'Clinic updated successfully!');
    }

    // Delete clinic
    public function destroy($id)
    {
        $clinic = Clinic::findOrFail($id);
        $clinic->delete();

        return to_route('clinic.show')->with('success-delete-clinics', 'Clinic deleted successfully!');
    }
}
