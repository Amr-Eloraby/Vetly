<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Http\Requests\Web\PharmacyRequest;
use App\Http\Requests\Web\UpdatePharmcyRequest;
use App\Services\ImageService;

class PharmacyController extends Controller
{
    // return view for create pharmacy
    public function showCreate()
    {
        return view('dashboard.pharmacy.create');
    }

    // Create pharmacy
    public function store(PharmacyRequest $request)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('image')) {
            $imagePath = ImageService::upload($request->file('image'), 'pharmacy_images');
            $validatedData['image'] = $imagePath;
        }
        Medicine::create($validatedData);
        return to_route('pharmacy.create')->with('success', 'Pharmacy created successfully!');
    }
    

    // return view for update pharmacy
    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('dashboard.pharmacy.update', compact('medicine')); 
    }

    // Update pharmacy
    public function update(UpdatePharmcyRequest $request, $id)
    {
        $validatedData = $request->validated();
        $medicine = Medicine::findOrFail($id);
        if ($request->hasFile('image')) {
            ImageService::delete($medicine->image);
            $imagePath = ImageService::upload($request->file('image'), 'pharmacy_images');
            $validatedData['image'] = $imagePath;
        }
        $medicine->update($validatedData);
        return to_route('pharmacy.show')->with('success-update', 'Pharmacy updated successfully!');
    }
    
    // return view for show pharmacy
    public function show()
    {
        $medicines = Medicine::all();
        return view('dashboard.pharmacy.show', compact('medicines'));
    }

    // Delete pharmacy
    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();
        return to_route('pharmacy.show')->with('success-delete', 'Pharmacy deleted successfully!');
    }
}
